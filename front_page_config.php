<?php
/**
|========================================================================================================
| Generic page configurations are set up here
|========================================================================================================
*/
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to('index.php');//user authentication
 }
 $project = new Project();
 $admin = $user->data();
 
 


//set up useful variables to be used elsewhere
$projectsForApproval = DBHandler::getInstance()->get('projects', array('status','=',0))->results();
$billsForApproval = DBHandler::getInstance()->get('projects', array('bill_status','=',0))->results();

//initialize notifications variables
$numProjects = count($projectsForApproval);
$numBills = count($billsForApproval);
$numProjectReminders = 0;
$numBillReminders = 0;
$numReminders = $numBillReminders + $numProjectReminders;
$totalNotices = $numProjects + $numBills + $numReminders;

//get reminders
$reminders = count(DBHandler::getInstance()->get('projects', array('status','=',2))->results());
//if(empty($projectsForApproval)) die();
if(Session::exist('remind_later')) {
  $reminders = 0;//help display reminder dialog on next log in
}

?>
