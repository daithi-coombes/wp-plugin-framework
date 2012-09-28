<?php
namespace PluginFramework\Modules;
use PluginFramework\Controller;

class NetworkAdmin extends Controller{
	
	function __construct(){
		
		$this->wp_action = array(
			'network_admin_menu' => array(&$this, 'admin_menu')
		);
		
		parent::__construct( __CLASS__ );
	}
	
	public function admin_menu(){
		add_menu_page("Plugin Framework", "Plugin Framework", "options", "plugin-framework", array(&$this, 'get_page'));
	}
}
