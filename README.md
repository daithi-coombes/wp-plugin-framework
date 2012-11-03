wp-plugin-framework
===================

A very light plugin framework for developing wordpress plugins

Usage php 5.3
=============
not fully supported at this time, dev version can be found at:
php 5.3/

Usage php 5 < 5.3
===================
To use this framework upload the folder 
php 5/ 
to your 
wp-content/plugins/ 
folder on wordpress and rename the folder to plugin of your choice.

Create a class file in:
php 5/application/modules
the naming scheme is camel case, with first letter uppercase. So to add a module
for online contacts create the file
Contacts.class.php
```php
<?php

if(!class_exists("MyPluginContacts")):
	/**
	* Class description 
	*/
	class MyPluginContacts extends WPPluginFrameWorkConfig{

		public __construct(){
			
			//set framework params here
			;;;
			//call parent construct
			parent::__construct();

			//do what ever next
			$this->get_whos_online();
		}

		private function get_whos_online(){
			//code flow...
		}
	}
```

if your class needs to be loaded with every run of wordpress then you will need 
to declare it in the index.php file. At the bottom of the file add the class
name to your $config->init_modules array like so:
```php
$config->init_modules = array(
	'MyPluginContacts'
);
```
This will autoload and construct your class as $MyPluginContacts object. If you
need to access this class from anywhere else in your plugin, get can acces it
like so
```php
	public function foo(){
		global $MyPluginContacts;
	}
```