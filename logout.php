<?php
 require_once 'core/init.php';

$user = new User();
if($user->logout()) {
  Redirect::to('index.php');
}
 
 
?>