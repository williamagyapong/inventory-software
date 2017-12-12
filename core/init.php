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


/**
|---------------------------------------------
|      SYSTEM CONVENTIONS
|---------------------------------------------
  <> Project/Materials Bill Status Conventions <>
  1. 0 -> Newly registered project / prepared materials bill pending approval
  2. 1 -> Approved project or materials bill
  3. 2 -> Project/mat. bill on reminder / on storekeeper interface it represents project pending approval
  4. 3 -> Project/ materials bill marked as non-satisfactory
  5. none -> Indicates a project with no materials bill

  <> General Conventions <>
  1.
  2.
  3.
  
  <> Error Codes <>
  1. 
  2. 
  3. 

*/



?>
