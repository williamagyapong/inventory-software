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

 $pObject = new Project();//instantiate project class
//print_array($_SESSION);die();
 if(Session::exist('PROJECT_ID')) {
    //handle printing of project details
    $project = DBHandler::getInstance()->get('projects', array('id', '=', Session::get('PROJECT_ID')))->first();

    if(empty($project)) Redirect::to(502);
     $projectM = json_decode($project->project_manager);
     $storesAdmin = json_decode($project->stores_admin);

 } elseif(Session::exist('BILL_ID')){
   
 } else {

    $project = DBHandler::getInstance()->get('projects', array('status', '=', 0))->results();

    if(empty($project)) Redirect::to(502);
 }
 
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
 <!-- print button-->
  
  <div class="w3-row-padding w3-margin-bottom">
  <?php 
    if(Session::exist('BILL_ID')):
      //handle printing of materials bill
       $billedProject = DBHandler::getInstance()->get('projects', array('id', '=',Session::get('BILL_ID')))->first();
       $materialsBill = $pObject->getProjectMaterials($billedProject->id);
  ?>
   <div id="bill-modal">
      <div class="w3-modal-content w3-border w3-round" style="max-width:690px;margin-top: 30px;">
        <div class="w3-center"><br>
           <h3 class="w3-text-red">Bill of Required Materials</h3>
        </div>

        <form class="w3-container" action="action_page.php" method="post">
          <input type="hidden" name="projectId" value="<?php echo $billedProject->id;?>">
          <fieldset>
            <legend class="w3-text-red"><b>Name of Project</b></legend>
            <div class="w3-input w3-border w3-margin-bottom w3-light-grey">
              <b><?php echo $billedProject->name;?></b>
            </div>
          </fieldset>
          <fieldset class="w3-white">
            <legend class="w3-text-red"><b>Project Materials</b></legend>
            <div class="w3-responsive">
              <table class="w3-table w3-striped w3-bordered">
               <tr>
                <th></th>
                <th>Name of Material Needed For The Project</th>
                <th>Quantity Needed</th>
                <th>Quantity Already Available And Usable</th>
                <th>Quantity to Purchase</th>
               </tr>
                <?php foreach($materialsBill as $material):?>
               <tr>
                <td></td>
                <td><?php echo $material->name;?></td>
                <td><?php echo $material->quantity_needed;?></td>
                <td><?php echo $material->quantity;?></td>
                <td><?php echo $material->quantity<$material->quantity_needed?$material->quantity_needed-$material->quantity: 0; ?></td>
               </tr>
               <?php endforeach;?>
              </table>
            </div>
          </fieldset> 
          </form>
        </div>
      </div> 
    <?php else:?>
     <!-- modal for project -->
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
  <?php endif;?>
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




	 