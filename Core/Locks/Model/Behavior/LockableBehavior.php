<?php
	/**
	 * lockable behavior.
	 *
	 * This behavior auto binds to any model and will lock a row when it is being
	 * edited by a user. only that user will be able to edit it while it is locked.
	 * This will avoid any issues with many people working on content at the same
	 * time
	 *
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 *
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package Infinitas.locks
	 * @subpackage Infinitas.locks.behaviors.lockable
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 0.5a
	 *
	 * @author Carl Sutton ( dogmatic69 )
	 * @author Ceeram
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */

	class LockableBehavior extends ModelBehavior {		
		/**
		 * Contain default settings.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_defaults = array(
		);
		
		public function __construct() {
			parent::__construct();
			
			ClassRegistry::init('Locks.Lock')->clearOldLocks();
		}

		/**
		 *
		 * @param object $Model Model using the behavior
		 * @param array $settings Settings to override for model.
		 * @access public
		 * @return void
		 */
		public function setup($Model, $config = null) {
			if($Model->alias == 'Lock' || !$Model->Behaviors->enabled('Locks.Lockable')) {
				return;
			}

			$Model->bindModel(
				array(
					'hasOne' => array(
						'Lock' => array(
							'className' => 'Locks.Lock',
							'foreignKey' => 'foreign_key',
							'conditions' => array(
								'Lock.class' => $Model->plugin . '.' . $Model->alias
							),
							'fields' => array(
								'Lock.id',
								'Lock.created',
								'Lock.user_id'
							),
							'dependent' => true
						)
					)
				),
				false
			);

			if (is_array($config)) {
				$this->settings[$Model->alias] = array_merge($this->_defaults, $config);
			}

			else {
				$this->settings[$Model->alias] = $this->_defaults;
			}
		}

		/**
		 * Locking rows.
		 *
		 * After a row has been pulled from the database this will record the locked
		 * state with the user that locked it. if a user reads a row that they
		 * locked the date will be updated. if a different user tries to read this
		 * row nothing will be retured and the component will take over displaying
		 * an error message
		 *
		 * @var object $Model the current model
		 * @var array $results the data that was found
		 * @var bool $primary is it the main model doing the find
		 */
		public function afterFind($Model, $results, $primary) {
			$this->userId = class_exists('CakeSession') ? CakeSession::read('Auth.User.id') : null;
			
			if(!$this->userId || $Model->findQueryType != 'first' || !$primary || empty($results)) {
				if(!$this->userId || $Model->findQueryType != 'all') {
					return $results;
				}

				foreach($results as $k => &$result) {
					$result['Lock']['Locker'] = $result['LockLocker'];
					unset($result['LockLocker']);
				}

				return $results;
			}

			if(isset($results[0][$Model->alias][$Model->primaryKey])) {
				$Lock = ClassRegistry::init('Locks.Lock');
				$lock = $Lock->find(
					'all',
					array(
						'conditions' => array(
							'Lock.foreign_key' => $results[0][$Model->alias][$Model->primaryKey],
							'Lock.class' => $Model->fullModelName()
						),
						'contain' => array(
							'Locker'
						)
					)
				);

				if(isset($lock[0]['Lock']['user_id']) && $this->userId == $lock[0]['Lock']['user_id']) {
					$Lock->delete($lock[0]['Lock']['id']);
					$lock = array();
				}

				if(!empty($lock)) {
					return $lock;
				}

				$lock['Lock'] = array(
					'foreign_key' => $results[0][$Model->alias][$Model->primaryKey],
					'class' => $Model->fullModelName(),
					'user_id' => $this->userId
				);

				$Lock->create();
				$Lock->save($lock);
			}

			return $results;
		}

		/**
		 * contain the lock
		 *
		 * before a find is made the Lock model is added to contain so that
		 * the lock details are available in the view to show if something is locked
		 * or not.
		 *
		 * @param object $model referenced model
		 * @param array $query the query being done
		 *
		 * @return array the find query data
		 */
		public function beforeFind($Model, $query) {
			if($Model->findQueryType == 'count') {
				return $query;
			}

			if(!is_array($query['fields'])) {
				$query['fields'] = array($query['fields']);
			}


			$query['fields'] = array_merge(
				$query['fields'],
				array(
					'Lock.*',
					'LockLocker.id',
					'LockLocker.username',
				)
			);

					// possible alternative:
					// 'Lock.class = ' . $Model->fullModelName(),
			$query['joins'][] = array(
				'table' => 'global_locks',
				'alias' => 'Lock',
				'type' => 'LEFT',
				'conditions' => array(
					'Lock.class' => $Model->fullModelName(),
					'Lock.foreign_key = ' . $Model->alias . '.' . $Model->primaryKey,
				)
			);

			$query['joins'][] = array(
				'table' => 'core_users',
				'alias' => 'LockLocker',
				'type' => 'LEFT',
				'conditions' => array(
					'LockLocker.id = Lock.user_id',
				)
			);
			
			return $query;
		}

		/**
		 * unlock after the save
		 *
		 * once the row has been saved, the lock can be removed so that other users
		 * may have accesss to the data.
		 *
		 * @param object $model referenced model
		 * @param bool $created if its a new row
		 *
		 * @return bool true on succsess false if not.
		 */
		public function afterSave($Model, $created) {
			if(!$created) {
				$this->__deleteLock($Model, $Model->data[$Model->alias][$Model->primaryKey]);
			}

			return parent::afterSave($Model, $created);
		}

		/**
		 * @brife Unlock a row
		 *
		 * This method is for use when afterSave is not used eg: cancel pushed
		 * or some other reason for manual unlock
		 *
		 * @access public
		 *
		 * @param Model $Model the model being unlocked
		 * @param string $id the id of the record being unlocked
		 *
		 * @return bool true if unlocked, false if not
		 */
		public function unlock($Model, $id = null) {
			return $this->__deleteLock($Model, $id);
		}

		/**
		 * @brief internal private method for deleting locks
		 *
		 * This will delete locks for records only when there is a user_id
		 * in the session. It deletes based on model, pk and user_id.
		 *
		 * @access private
		 *
		 * @param Model $Model the model being unlocked
		 * @param string $id the id of the record being unlocked
		 *
		 * @return bool false on error, true if removed
		 */
		private function __deleteLock($Model, $id = null) {
			if(!AuthComponent::user('id') || !$id) {
				return true;
			}
			
			return ClassRegistry::init('Locks.Lock')->deleteAll(
				array(
					'Lock.foreign_key' => $id,
					'Lock.class' => $Model->plugin . '.' . $Model->alias,
					'Lock.user_id' => AuthComponent::user('id')
				)
			);
		}
	}
