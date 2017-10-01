<?php
/**
|----------------------------------------------------
|    REGISTER SESSION
|----------------------------------------------------
*/
    session_start(); 

/**
|----------------------------------------------------
|     SET THE DEFAULT TIMEZONE
|----------------------------------------------------
*/

     date_default_timezone_set("UTC");

/**
|----------------------------------------------------
|     GLOBAL VARIABLES
|----------------------------------------------------
*/

// set global variables
$GLOBALS['config'] = array(
        'mysql'=>array(
              'host'=>'127.0.0.1',
              'db'=>'napol_db',
              'password'=>'',
              'username'=>'root'
        	),

        'remember'=>array(
             'cookie_name'=>'hash',
             'cookie_expiry'=>604800
        	),

        'session'=>array(
             'session_name'=>'user',
             'token_name'=>'csrf_token'
        	),

        'app'=>array(
              'name'=>'Napol\'s Material Inventory Software',
              'base_url'=>'/inventory-software',
              'version'=>'1.0',
              
          ),
        'developer'=>array(
              'name'=>'Agyapong William',
              'contact'=>'0501426834'
          ),
        'client'=>array(
              'name'=>'Napoleon',
              'contact'=>'0200665525'
          )
	);


/**
|---------------------------------------------
|      FILES REQUIREMENTS
|---------------------------------------------
*/

// autoload classes
spl_autoload_register(function($class_name){
    require_once 'classes/'.$class_name.'.php';
});

// access functions
require_once 'functions.php';

$p = new Project();
//print_array($p->getInProgress());exit();

?>
