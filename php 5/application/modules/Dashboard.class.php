<?php
/**
 * Description of Dashboard
 *
 * @author daithi
 */
class Dashboard extends WPPluginFrameWorkController{
	
	/**
	 * Construct.
	 * 
	 * Constructs the WPPluginFrameWorkController parent class as well. 
	 */
	function __construct(){
		
		$this->wp_action = array(
			'admin_menu' => array(&$this, 'dash_menu')
		);
		
		parent::__construct(__CLASS__);
	}
	
	/**
	 * Adds the dashboard menu. 
	 */
	public function dash_menu(){
		add_menu_page("WPF Dashboard", "WPF Dashboard", "manage_options", "wpf-dashboard", array(&$this, 'get_page'));
	}
}

?>
