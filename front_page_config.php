<?php
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to('index.php');//user authentication
 }
 
 $admin = $user->data();
 
 
function activePage($page){
	$ser = $_SERVER["SCRIPT_NAME"];

	if ($page == $ser) {

		return "w3-white w3-text-red";
	}
}

$projectsForApproval = DBHandler::getInstance()->get('projects', array('status','=',0))->results();
$reminders = count(DBHandler::getInstance()->get('projects', array('status','=',2))->results());
if(Session::exist('remind_later')) {
  $reminders = array();//help display reminder dialog on next log in
}
?>
