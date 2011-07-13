<?php
	App::import('lib', 'libs.test/app_test.php');

	/**
	 * @brief AppModelTestCase is the class that model tests should extend
	 *
	 * This class uses AppTest for autoloading fixtures, classes and all dependencies
	 *
	 * @copyright Copyright (c) 2011 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package Infinitas.Testing
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 0.9b
	 *
	 * @author dogmatic69
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */
	
	class AppModelTestCase extends CakeTestCase {
		/**
		 * @brief set to true after the first test runs.
		 *
		 * @var bool
		 */
		public $fistTestRun = false;

		/**
		 * @brief list of tests to run
		 * 
		 * @var <type>
		 */
		public $run = array();

		/**
		 * @brief if set to stop, testing will stop before the next testCase starts
		 *
		 * @var bool
		 */
		public $stop = false;

		/**
		 * @brief stores some data about the tests
		 *
		 * @var array
		 */
		public $data = array();

		/**
		 * @brief setup the test case and try catch any errors
		 *
		 * CakePHP just throws errors all over if there is a missing fixture.
		 * Here we try and catch any errors and display them so that its easier
		 * to fix.
		 *
		 * @access public
		 *
		 * @return void
		 */
		public function __construct(){
			parent::__construct();

			if(is_subclass_of($this, 'AppModelTestCase')){
				try{
					$this->AppTest = new AppTest($this);
				}

				catch (AppTestException $e){
					pr($e->error());
					exit;
				}
			}
		}

		/**
		 * @brief call only when its not set
		 * 
		 * overload the _initDb method and make sure its only called when the db
		 * object does not exist
		 *
		 * @access public
		 *
		 * @return true
		 */
		public function _initDb() {
			if(!isset($this->db) || !$this->db){
				parent::_initDb();
			}

			return true;
		}
		
		/**
		 * @brief allow running only some of the tests in the test case
		 * 
		 * Overrides parent method to allow selecting tests to run in the current test case
		 * It is useful when working on one particular test
		 *
		 * @link https://github.com/CakeDC/templates
		 * @author Cake Development Corporation
		 * @copyright 2005-2011, Cake Development Corporation (http://cakedc.com)
		 *
		 * @access public
		 *
		 * @return array List of tests to run
		 */
		public function getTests() {
			if (!empty($this->tests)) {
				debug('Only the following tests will be executed: ' . join(', ', (array) $this->tests), false, false);
				return array_merge(array('start', 'startCase'), (array) $this->tests, array('endCase', 'end'));
			}

			return parent::getTests();
		}

		/**
		 * @brief before a model test starts
		 *
		 * Load up the fixtures and then set the model object for use. If it is
		 * the first test method that is run, display a list of fixtures that have
		 * been loaded so that people know what is going on under the hood
		 *
		 * @access public
		 *
		 * @return void
		 */
		public function startTest($method) {
			if(is_subclass_of($this, 'AppModelTestCase')) {
				$this->AppTest->startTest($method);
				$this->AppTest->loadFixtures(null, true);

				echo '<div style="border: 2px solid #d6ab00; padding: 5px; margin-top:5px; margin-bottom:5px">';

				list($plugin, $model) = pluginSplit($this->setup[$this->setup['type']]);
				$this->{$model} = ClassRegistry::init($this->setup[$this->setup['type']]);
			}
		}

		/**
		 * @brief after a test stops
		 *
		 * unset the model object and clear out the registry
		 *
		 * @access public
		 *
		 * @return void
		 */
		public function endTest($method) {
			if(is_subclass_of($this, 'AppModelTestCase')) {
				list($plugin, $model) = pluginSplit($this->setup[$this->setup['type']]);
				unset($this->{$model});
				ClassRegistry::flush();

				$this->AppTest->endTest($method);
				echo sprintf(
					'<div style="padding: 8px; background-color: green; color: white;">%s <span style="color:#ffdd00;">[%ss]</span></div>',
					$this->AppTest->prettyTestMethod($method),
					$this->data[$method]['total']
				);

				echo '</div>';
				if($this->stop === true){
					debug('Skipping further tests', false, false);

					$this->AppTest->endTest();
					exit;
				}
			}
		}

		public function startCase() {
			if(is_subclass_of($this, 'AppModelTestCase')) {
				$this->AppTest->startCase();
			}
		}

		/**
		 * @brief end of tests
		 *
		 * When everything is done, clean up the database logs so that debugging
		 * the queries is a bit easier.
		 *
		 * @access public
		 *
		 * @return void
		 */
		public function endCase(){
			if(is_subclass_of($this, 'AppModelTestCase')) {
				$this->AppTest->endCase();
			}
		}

		/**
		 * @brief clean out the data for the selected model
		 *
		 * @access public
		 *
		 * @return bool true if it happened, false if not
		 */
		public function truncate(){
			list($plugin, $model) = pluginSplit($this->setup[$this->setup['type']]);
			$this->assertTrue(isset($this->{$model}));
			$this->assertTrue($this->{$model}->deleteAll(array($this->{$model}->alias . '.' . $this->{$model}->primaryKey . ' != ' => 'will-never-be-this-that-is-for-sure')));
		}

		public function testModelSchema(){
			foreach($this->_fixtureClassMap as $model => $fixture){
				$this->assertFixtureSchemaLiveSchema(array('model' => $model, 'fixture' => $fixture));
			}
		}

		public function assertFixtureSchemaLiveSchema($data){
			$fixture = array(
				'fields' => $this->_fixtures[$data['fixture']]->fields,
				'indexes' => $this->_fixtures[$data['fixture']]->fields['indexes'],
				'params' => $this->_fixtures[$data['fixture']]->fields['tableParameters']
			);
			unset($fixture['fields']['indexes'], $fixture['fields']['tableParameters']);

			$this->assertSchemaParams($data['model'], $fixture['params']);
			$this->assertSchemaFields($data['model'], $fixture['fields']);
			$this->assertFixtureMatchesLive($data['fixture'], $fixture);
		}

		/**
		 * @brief assert the fixture is the correct type
		 *
		 * Make sure that the engine and other details are correct.
		 *
		 * @param array $params the details of the fixture
		 */
		public function assertSchemaParams($model, $params){
			$params = array_merge(array('collate' => null, 'charset' => null, 'engine' => null), $params);
			$this->assertEqual($this->setup['schema']['collate'], $params['collate'], sprintf('Database collate "%s" for model "%s" does not match "%s"', $this->setup['schema']['collate'], $model, $params['collate']));
			$this->assertEqual($this->setup['schema']['charset'], $params['charset'], sprintf('Database charset "%s" for model "%s" does not match "%s"', $this->setup['schema']['charset'], $model, $params['charset']));
			$this->assertEqual($this->setup['schema']['engine'], $params['engine'], sprintf('Database engine "%s" for model "%s" does not match "%s"', $this->setup['schema']['engine'], $model, $params['engine']));
		}

		/**
		 * @brief assert indervidual fields are correct
		 *
		 * make sure that all the fields have the correct schema
		 * 
		 * @access public
		 *
		 * @param string $model the model the fields belong to
		 * @param array $fields all the fields for this model
		 *
		 * @return void
		 */
		public function assertSchemaFields($model, $fields){
			foreach($fields as $field => $data){
				$data = array_merge(array('collate' => null, 'charset' => null, 'engine' => null), $data);
				
				$yearField = ($data['type'] == 'string') && empty($data['collate']) && ($data['length'] === 4);
				$integer = !$this->assertIsUuid($model, $field, $data) && $data['type'] == 'integer';

				if($data['type'] == 'datetime'){
					if($field == 'created' || $field == 'modified'){
						$this->assertTrue($data['null'], sprintf('Field "%s" in "%s" should allow being null', $field, $model));
						$this->assertFalse($data['default'], sprintf('Field "%s" in "%s" should have an empty default value', $field, $model));
					}
					
					continue;
				}
				
				if($yearField || $integer){
					continue;
				}

				$this->assertEqual($this->setup['schema']['collate'], $data['collate'], sprintf('Field collate "%s" in "%s" for field "%s" does not match"%s"', $this->setup['schema']['collate'], $model, $field, $data['collate']));
				$this->assertEqual($this->setup['schema']['charset'], $data['charset'], sprintf('Field charset "%s" in "%s" for field "%s" does not match "%s"', $this->setup['schema']['charset'], $model, $field, $data['charset']));
			}
		}

		/**
		 * @brief test to make sure that nay pk / fk fields are uuid
		 *
		 *
		 * $fields array is something like the following
		 * Array (
		 *	[type] => string/integer/datetime etc
		 *	[null] => // or 1
		 *	[default] =>  // or 'some string'
		 *	[length] => 36
		 *	[key] => primary // or nothing?
		 *	[collate] => utf8_general_ci
		 *	[charset] => utf8
		 * )
		 * 
		 * @access public
		 *
		 * @param string $model the model the field belongs to
		 * @param string $field the field being tested
		 * @param array $data the fields config
		 *
		 * @return true if it should be, false if not.
		 */
		public function assertIsUuid($model, $field, $data){
			if(strstr($field, '_id') || $field == 'id'){
				$uuid = ($data['type'] == 'string') && ($data['length'] === 36);
				$this->assertTrue($uuid, sprintf('Field "%s" in "%s" is "%s" but should be UUID', $field, $model, $data['type']));
				return true;
			}

			return false;
		}

		/**
		 * @brief assert the fixture is the same as the dev db
		 *
		 * Make sure that your test fixtures match your dev setup, especially good
		 * when working with others to keep everything upto date.
		 * 
		 * @param array $fixture
		 */
		public function assertFixtureMatchesLive($fixtureName, $fixture){
			$model = Inflector::classify(str_replace('plugin.', '', $fixtureName));
			$config = $this->db->configKeyName;
			
			ClassRegistry::config(array('ds' => 'default'));

			ClassRegistry::flush();
			$Model = ClassRegistry::init($model);
			$this->assertEqual($Model->useDbConfig, 'default');
			$schema = $Model->schema();

			ClassRegistry::flush();
			ClassRegistry::config(array('ds' => $config));
			$this->assertEqual(ClassRegistry::init($model)->useDbConfig, $config);

			foreach($fixture['fields'] as $fixtureField => $fixtureData){
				$yearField = ($fixtureData['type'] == 'string') && ($fixtureData['length'] == 4);

				$this->assertTrue(isset($schema[$fixtureField]), sprintf('Model "%s" is missing field "%s"', $model, $fixtureField));
				$this->assertEqual($fixtureData['type'], $schema[$fixtureField]['type'], sprintf('Field "%s" type "%s" in model "%s" does not match "%s"', $fixtureData['type'], $fixtureField, $model, $schema[$fixtureField]['type']));

				if($yearField){
					unset($schema[$fixtureField]);
					continue;
				}

				$this->assertEqual($fixtureData['length'], $schema[$fixtureField]['length'], sprintf('Field "%s" length "%s" in model "%s" does not match "%s"', $fixtureData['length'], $fixtureField, $model, $schema[$fixtureField]['length']));
				$this->assertEqual($fixtureData['key'], $schema[$fixtureField]['key'], sprintf('Field "%s" key "%s" in model "%s" does not match "%s"', $fixtureData['key'], $fixtureField, $model, $schema[$fixtureField]['key']));

				if($fixtureData['type'] == 'integer'){
					unset($schema[$fixtureField]);
					continue;
				}

				if($fixtureData['type'] == 'datetime'){
					if($fixtureField == 'created' || $field == 'modified'){
						$this->assertTrue($schema[$fixtureField]['null'], sprintf('Field "%s" in "%s" should allow being null', $fixtureField, $model));
						$this->assertFalse($schema[$fixtureField]['default'], sprintf('Field "%s" in "%s" should have an empty default value', $fixtureField, $model));
					}
					unset($schema[$fixtureField]);
					continue;
				}
				
				unset($schema[$fixtureField]);
			}
			
			if(count($schema) > 0){
				$this->assertFalse(true, sprintf('Live DB has extra fields "%s"', implode(', ', array_keys($schema))));
			}
		}

		/**
		 * @brief asset that data is valid
		 * 
		 * Asserts that data are valid given Model validation rules
		 * Calls the Model::validate() method and asserts the result
		 *
		 * @link https://github.com/CakeDC/templates
		 * @author Cake Development Corporation
		 * @copyright 2005-2011, Cake Development Corporation (http://cakedc.com)
		 *
		 * @access public
		 *
		 * @param Model $Model Model being tested
		 * @param array $data Data to validate
		 *
		 * @return void
		 */
		public function assertValid(Model $Model, $data) {
			$this->assertTrue($this->_validData($Model, $data));
		}

		/**
		 * @brief assert that data is not valid
		 * 
		 * Asserts that data are invalid given Model validation rules
		 * Calls the Model::validate() method and asserts the result
		 *
		 * @link https://github.com/CakeDC/templates
		 * @author Cake Development Corporation
		 * @copyright 2005-2011, Cake Development Corporation (http://cakedc.com)
		 *
		 * @access public
		 *
		 * @param Model $Model Model being tested
		 * @param array $data Data to validate
		 * 
		 * @return void
		 */
		public function assertInvalid(Model $Model, $data) {
			$this->assertFalse($this->_validData($Model, $data));
		}

		/**
		 * @brief check validation errors are correct
		 * 
		 * Asserts that data are validation errors match an expected value when
		 * validation given data for the Model
		 * Calls the Model::validate() method and asserts validationErrors
		 *
		 * @link https://github.com/CakeDC/templates
		 * @author Cake Development Corporation
		 * @copyright 2005-2011, Cake Development Corporation (http://cakedc.com)
		 *
		 * @param Model $Model Model being tested
		 * @param array $data Data to validate
		 * @param array $expectedErrors Expected errors keys
		 *
		 * @return void
		 */
		public function assertValidationErrors($Model, $data, $expectedErrors) {
			$this->_validData($Model, $data, $validationErrors);
			sort($expectedErrors);
			$this->assertEqual(array_keys($validationErrors), $expectedErrors);
		}

		/**
		 * @brief Convenience method allowing to validate data and return the result
		 *
		 * @link https://github.com/CakeDC/templates
		 * @author Cake Development Corporation
		 * @copyright 2005-2011, Cake Development Corporation (http://cakedc.com)
		 *
		 * @access protected
		 *
		 * @param Model $Model Model being tested
		 * @param array $data Profile data
		 * @param array $validationErrors Validation errors: this variable will be updated with validationErrors (sorted by key) in case of validation fail
		 * 
		 * @return boolean Return value of Model::validate()
		 */
		protected function _validData(Model $Model, $data, &$validationErrors = array()) {
			$valid = true;
			$Model->create($data);
			if (!$Model->validates()) {
				$validationErrors = $Model->validationErrors;
				ksort($validationErrors);
				$valid = false;
			}

			else {
				$validationErrors = array();
			}
			
			return $valid;
		}
	}