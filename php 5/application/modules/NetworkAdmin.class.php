<?php
/**
 * Description of NetworkAdmin
 *
 * @author daithi
 */
class NetworkAdmin extends WPPluginFrameWorkController{
	
	/**
	 * Construct. 
	 * 
	 * Constructs parent class WPPluginFrameWorkController as well.
	 */
	function __construct(){
		
		//only runs if multisite
		if(!is_multisite()) return;
		
		//set up actions
		$this->wp_action = array(
			'network_admin_menu' => array($this, 'admin_menu')
		);
		
		parent::__construct(__CLASS__);
	}
	
	/**
	 * Register the network admin settings.
	 */
	public function admin_menu(){
		add_menu_page("AutoFlow Network Admin", "AutoFlow", "manage_options", "autoflow", array(&$this, 'get_page'));
	}
}

?>
