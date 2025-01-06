<?php
	class DateTimeConfiguratorPlugin extends BaseApplicationPlugin {
		# -------------------------------------------------------
		protected $description = null;
		
		private $opo_config;
		
		private $ops_plugin_path;
		# -------------------------------------------------------
		public function __construct($ps_plugin_path) {
			$this->ops_plugin_path = $ps_plugin_path;
			$this->description = _t('DateTime configurator plugin');
			
			parent::__construct();
			
			$this->opo_config = Configuration::load($ps_plugin_path.'/conf/DateTimeConfigurator.conf');
		}
		# -------------------------------------------------------
		/**
		 * Override checkStatus() to return true - the statisticsViewerPlugin always initializes ok... (part to complete)
		 */
		public function checkStatus() {
			return array(
				'description' => $this->getDescription(),
				'errors' => array(),
				'warnings' => array(),
				'available' => ((bool)$this->opo_config->get('enabled'))
			);
		}
		# -------------------------------------------------------
		/**
		 * Insert activity menu
		 */
		public function hookRenderMenuBar($pa_menu_bar) {
			if ($o_req = $this->getRequest()) {
				if(!(bool)$this->opo_config->get('enabled')) { return $pa_menu_bar; }
				
				if (isset($pa_menu_bar['manage'])) {
					$va_menu_items = $pa_menu_bar['manage']['navigation'];
					if (!is_array($va_menu_items)) { $va_menu_items = array(); }
				} else {
					$va_menu_items = array();
				}
				
				$va_menu_items['DateTimeConfigator'] = array(
					'displayName' => _t('Gestion des dates'),
					"default" => array(
						'module' => 'DateTimeConfigurator', 
						'controller' => 'DateTime', 
						'action' => 'Index'
					)
				);	
				
				if (isset($pa_menu_bar['manage'])) {
					$pa_menu_bar['manage']['navigation'] = $va_menu_items;
				} else {
					$pa_menu_bar['manage'] = array(
						'displayName' => _t('manage'),
						'navigation' => $va_menu_items
					);
				}
			} 
			
			return $pa_menu_bar;
		}
	}
