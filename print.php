<?php
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
 }
 
 $admin = $user->data();
 if($admin->role !='manager') {
   Redirect::to('index.php');
 }
//print_array($_SESSION);die();
 if(Session::exist('PROJECT_ID')) {
    $project = DBHandler::getInstance()->get('projects', array('id', '=', Session::get('PROJECT_ID')))->results();
 } else{
    $project = DBHandler::getInstance()->get('projects', array('status', '=', 0))->results();
 }
 
 if(empty($project)) die();
 $project = $project[0];
 $projectM = json_decode($project->project_manager);
 $storesAdmin = json_decode($project->stores_admin);
 //$orders = DBHandler::getInstance()->get('orders', array())->results();
 //$customers = DBHandler::getInstance()->get('customers', array())->results();
?>

<!-- front end matter -->
<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
    <title>Print</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">-->
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
  </head>
  
<body class="w3-white">
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-top:20px;">

  <div class="w3-row-padding w3-margin-bottom">
     <!-- modal for project confirmation -->
  <div id="modal">
    <div class="w3-modal-content w3-border w3-round" style="max-width:98%">
      <div class="w3-center"><br>
         <h3>Project Details</h3>
      </div>

      <div class="w3-container" action="action_page.php" method="post">
       
        <div class="w3-section">
         <fieldset class="w3-light-grey">
          <div class="w3-half">
            <label><b>Name of Project</b></label>
            <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $project->name;?></div>
          </div>
          <div class="w3-half">
            <label><b>Company In Charge of Project</b></label>
            <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $project->company_in_charge;?></div>
          </div>
          <div class="w3-half">
            <label><b>Location of Project</b></label>
            <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $project->location;?></div>  
          </div>
          <div class="w3-half">
            <label><b>Description of Project</b></label>
            <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $project->description;?></div>
          </div>
          <div class="w3-half">
            <label><b>Date of Commencement</b></label>
            <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $project->date_begun;?></div>
          </div>
          <div class="w3-half">
            <label><b>Expected Date of Completion</b></label>
            <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $project->date_completion;?></div>
          </div>
          </fieldset>
          <fieldset class="w3-light-grey">
            <legend class="w3-text-red"><b>Project Manager</b></legend>
            <div class="w3-half">
              <label><b>Name</b></label>
              <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $projectM->name;?></div>
            </div>
            <div class="w3-half">
              <label><b>Phone</b></label>
              <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $projectM->phone;?></div>
            </div>
          </fieldset>
          <fieldset class="w3-light-grey">
            <legend class="w3-text-red"><b>Stores Administrator</b></legend>
            <div class="w3-half">
              <label><b>Name</b></label>
              <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $storesAdmin->name;?></div>
            </div>
            <div class="w3-half">
              <label><b>Phone</b></label>
              <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $storesAdmin->phone;?></div>
            </div>
          </fieldset> 
        </div>
      </div>
    </div>
  </div> 
  <!-- End page content -->
</div>

<!-- include external script files -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

<script>
  window.print();
</script>
</body>
</html>




	 