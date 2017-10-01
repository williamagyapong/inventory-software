<?php
 require_once 'core/init.php';

$user = new User();
if($user->logout()) {
  Session::deleteAll();	
  Redirect::to('index');
}
 
 
?>