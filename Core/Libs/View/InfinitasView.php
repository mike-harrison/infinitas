<?php
	/**
	 * Infinitas View
	 *
	 * makes the mustache templating class available in the views, and extends
	 * the Theme View to allow the use of themes.
	 * 
	 * Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * 
	 * @filesource
	 * @copyright Copyright (c) 2010 Carl Sutton ( dogmatic69 )
	 * @link http://www.infinitas-cms.org
	 * @package infinitas
	 * @subpackage infinitas.extentions.views.infinitas
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 0.8a
	 * 
	 * @author dogmatic69
	 * 
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */
	App::uses('Mustache', 'Libs.Lib');

	class InfinitasView extends View {
		/**
		 * place holder for the mustache templating engine.
		 */
		public $Mustache = null;

		/**
		 * internal cache of template parts from the entire system
		 */
		private $__mustacheTemplates = array();

		/**
		 * internal cache of vars that are used in the mustache template rendering
		 */
		private $__vars = array();

		/**
		 * get the
		 */
		public function __construct($Controller, $register = true) {
			$this->Mustache = new Mustache();
			parent::__construct($Controller, $register);

			$this->__setJsVariables();
		}

		/**
		 * render views
		 *
		 * Lets cake do its thing, then takes the output and runs it through
		 * mustache, doing all the template rendering things, and then returns
		 * the final output to where ever its going.
		 *
		 * you can pass ?mustache=false in the url to see the raw output skipping
		 * the template rendering. could be handy for debugging. if debug is off
		 * this has no effect.
		 */
		protected function _render($viewFile, $data = array()) {
			$this->__loadHelpers();
			$out = parent::_render($viewFile, $data);
			$this->__renderMustache($out);
			
			return $out;
		}

		private function __renderMustache(&$out) {
			if(Configure::read('debug') < 1){
				unset($this->request['url']['mustache']);
			}

			
			if($this->__skipMustacheRender()) {
				return;
			}
			
			if(empty($this->__mustacheTemplates)){
				$this->__mustacheTemplates = array_filter(current($this->Event->trigger('requireGlobalTemplates')));
			}

			foreach($this->__mustacheTemplates as $plugin => $template) {
				$this->__vars['viewVars'][Inflector::classify($plugin) . 'Template'] = $template;
			}

			$this->__vars['viewVars']  = &$this->viewVars;
			$this->__vars['viewVars']['templates'] =& $this->__mustacheTemplates['requireGlobalTemplates'];
			$this->__vars['params']	= &$this->params;

			$out = $this->Mustache->render($out, $this->__vars['viewVars']);
		}


		/**
		 * only on for admin or it renders the stuff in the editor which is pointless
		 * could maybe just turn it off for edit or some other work around
		 */
		private function __skipMustacheRender() {
			return !($this->request->params['admin'] || !($this->Mustache instanceof Mustache) ||
				(isset($this->request['url']['mustache']) && $this->request['url']['mustache'] == 'false'));
		}

		private function __loadHelpers() {
			$helpers = EventCore::trigger($this, 'requireHelpersToLoad');
			foreach($helpers['requireHelpersToLoad'] as $plugin) {
				foreach((array)$plugin as $helper => $config) {
					if(is_int($helper) && is_string($config)) {
						$helper = $config;
						$config = array();
					}

					$this->Helpers->load($helper, $config);
				}
			}
		}

		/**
		 * Set some data for the infinitas js lib.
		 */
		private function __setJsVariables() {
			if($this->request->is('ajax')){
				return false;
			}

			$infinitasJsData['base']	= $this->request->base;
			$infinitasJsData['here']	= $this->request->here;
			$infinitasJsData['plugin']	= $this->request->params['plugin'];
			$infinitasJsData['name']	= $this->name;
			$infinitasJsData['action']	= $this->request->params['action'];
			$infinitasJsData['params']	= $this->request->params;
			$infinitasJsData['passedArgs'] = $this->request->params['pass'];
			$infinitasJsData['data']	   = $this->request->data;

			//$infinitasJsData['model']	   = $this->Controller->modelClass;

			$infinitasJsData['config']	 = Configure::read();

			$this->set(compact('infinitasJsData'));
		}
	}