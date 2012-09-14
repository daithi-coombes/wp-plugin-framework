<?php
namespace PluginFramework;
use PluginFramework\Modules;

/**
 * Configuration Class.
 * 
 *  - Holds plugin wide params
 *  - Registers activation hook
 *  - Registers 3rd party scripts and styles
 * 
 * @author daithi
 * @package ci-groups 
 */
class Config{
	
	/** @var string The key name for looking for action requests */
	public $action_key = false;
	/** @var boolean Print debug messages to stdout */
	public $debug = false;
	/** @var array An array of errors. Used in the global $controller object */
	public $errors = array();
	/** @var array An array of modules to be loaded always */
	public $init_modules = array();
	/** @var array An array of messages. Used in the $controller object */
	public $messages = array();	
	/** @var array Associative array of tables to be created in plugin
	 * activation. */
	public $modal_tables = array();
	/** @var string The plugin prefix to append to db tables */
	public $modal_prefix = false;
	/** @var array Associative array of 3rd party scripts to register */
	public $third_party = array('scripts','styles');
	/** @var string The directory of the plugin base */
	public $plugin_dir = false;
	/** @var string The full url of the plugin base */
	public $plugin_url = false;
	
	/**
	 * constructor.
	 * 
	 * @global wpdb The wordpress database class. 
	 */
	function __construct(){
		
		//default fields
		$this->plugin_dir = WP_PLUGIN_DIR . "/" . basename(dirname(dirname( __FILE__ )));
		$this->plugin_url = WP_PLUGIN_URL . "/" . basename(dirname(dirname( __FILE__ )));
		$this->modal_prefix = $wpdb->prefix . str_replace("\\", "_", __NAMESPACE__);
	}
	
	/**
	 * Build plugin configuration.
	 *  - registers activation hook
	 *  - registers 3rd party scripts & styles
	 * 
	 * @return void 
	 */
	public function build(){
		
		//debug?
		if($this->debug) $this->set_debug();
		
		//load controller
		//$foo = new Controller();
		
		//register activation hooks
		register_activation_hook( "{$this->plugin_dir}/index.php", array(&$this, 'activate'));
		
		//register 3rd parties
		$this->register_3rd_parties();
		
		//load modules
		$this->load_modules();
		
	}
	
	/**
	 * Activation callback.
	 * 
	 * Installs tables 
	 */
	public function activate(){
		
		require_once( ABSPATH . '/wp-admin/includes/upgrade.php');
		
		foreach($this->modal_tables as $table=>$fields){
			$sql = "
				CREATE TABLE IF NOT EXISTS `{$this->modal_prefix}_{$table}`("
				. implode(",", $fields)
				. ");";
			dbDelta($sql);
		}
	}
	
	/**
	 * Add an error to the errors array.
	 *
	 * @see Config::errors
	 * @param string $err The error string to report
	 */
	public function error( $err ){
		$this->errors[] = $err;
	}
	
	/**
	 * Sets php error reporting to E_ALL and php ini display_errors to on.
	 * 
	 * @return void 
	 */
	public function set_debug(){
		
		//debug on
		if($this->debug){
			error_reporting(E_ALL);
			ini_set('display_errors','on');
		}
	}
	
	/**
	 * Loads modules set to construct on plugin init().
	 * 
	 * Reads ClassNames from $this->init_modules() array.
	 * 
	 * @see Config::init_modules
	 * @return type 
	 */
	private function load_modules(){
		
		if(!@count($this->init_modules)) return;
		
		foreach($this->init_modules as $module){
			$class = __NAMESPACE__ . "\\Modules\\$module";
			$netadmin = new $class();
		}
	}
	
	/**
	 * Registers third parties.
	 * 
	 * @return void
	 */
	private function register_3rd_parties(){
		
		if(!count($this->third_party)) return;
		
		//register scripts
		if(count(@$this->third_party['script']))
			foreach($this->third_party['script'] as $handle=>$src)
				wp_register_script($handle, "{$this->plugin_url}/application/includes/{$src}");
		
		//register styles
		if(count(@$this->third_party['css']))
			foreach($this->third_party['css'] as $handle=>$src)
				wp_register_style($handle, "{$this->plugin_url}/application/includes/{$src}");
	}
	
}
?>
