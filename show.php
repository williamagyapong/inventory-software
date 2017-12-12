<?php
  require_once 'front_page_config.php';
 
 if($admin->role !='manager') {// handle user authentication
   Redirect::to('index.php');
 }

$pObject = new Project();//instantiate project class
//print_array($_GET);die();
//control page content
//print_array($_SESSION);
 if(Session::exist('SHOW_PROJECT_BILL'))
 {
    //fetch materials bill details for executing SHOW and PRINT commands
    $billedProject = DBHandler::getInstance()->get('projects', array('bill_status','=',0))->first();
    if(empty($billedProject)) Redirect::to(503);//trigger error
    $materialsBill = $pObject->getProjectMaterials($billedProject->id);
    //print_array($materialsBill);
 }
 else{
      //fetch projects for executing SHOW command
      $project = DBHandler::getInstance()->get('projects', array('status', '=', 0))->first();
      if(empty($project)) Redirect::to(503);//trigger error
     $projectM = json_decode($project->project_manager);
     $storesAdmin = json_decode($project->stores_admin);
 }
 

?>

<!-- front end matter -->
<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
    <title>Showing</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">-->
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
  </head>
  
<body class="w3-white">

<!-- Top container -->
<?php require_once 'includes/header.php';?>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div id="main-content" class="w3-main">

  <!-- Header -->
  <nav class="w3-bar" style="padding-top:22px">
   <!--  <h5><b><i class="fa fa-dashboard"></i></b></h5> -->
  </nav>
  <!-- include dialogs here -->
  <?php require_once'includes/pop_ups.php';?>

  <div class="w3-row-padding w3-margin-bottom">
  <?php if(Session::exist('SHOW_PROJECT_BILL')):?>
       <!-- modal for bill confirmation -->
    <div id="bill-modal">
      <div class="w3-modal-content w3-border w3-round" style="margin-top: 30px;">
        <div class="w3-center"><br>
           <span class="w3-text-red w3-large">Bill of Required Materials</span><span class="w3-display-topright">Date Prepared: <?php echo $materialsBill[0]->date_prepared;?>&nbsp;&nbsp;&nbsp;</span>
        </div>

        <form class="w3-container" action="action_page.php" method="post">
          <input type="hidden" name="project_id" value="<?php echo $billedProject->id;?>"><!-- for approval only-->
          <input type="hidden" name="print_bill_project_id" value="<?php echo $billedProject->id;?>">
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
          <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
            <div class="w3-right">
            <?php if(Session::exist('PRINT_PROJECT_BILL')):?>
              <a href="#" id="print_bill_btn" class="my-button w3-button" title="Append approval to print bill"><b>Satisfied</b></a>
            <?php else:?>
              <input type="hidden" name="field_name" value="bill_status">
              <button class="w3-button" type="submit" name="p_token" value="satisfied"><b>Satisfied</b></button>
            <?php endif;?>

              <?php echo "
              <span  onclick=\"showElement('notsatisfied-bill-modal','".$billedProject->id."')\" class=\"my-button w3-button\"><b>Not Satisfied</b></span>";
              ?>
            </div>
          </div>
        </form>
      </div>
    </div> 
  <?php else:?>
     <!-- modal for project confirmation -->
    <div id="modal">
      <div class="w3-modal-content w3-border w3-round" style="margin-top: 30px;">
        <div class="w3-center"><br>
           <h3 class="w3-text-red">Project Registration Details For Approval <?php echo (Session::exist('PRINT_PROJECT'))?'And Printing':'';?></h3>
        </div>

        <form id="print_form" class="w3-container" action="action_page.php" method="post">
          <input type="hidden" name="project_id" value="<?php echo $project->id;?>">
          <input type="hidden" name="print_project_id" value="<?php echo $project->id;?>">
          <div class="w3-section">
           <fieldset class="w3-light-grey">
            <div class="w3-half">
              <label><b>Name of Project</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name" value="<?php echo $project->name;?>" id="box" readonly="yes">
            </div>
            <div class="w3-half">
              <label><b>Company In Charge of Project</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="company" value="<?php echo $project->company_in_charge;?>" id="box" readonly="yes">
            </div>
            <div class="w3-half">
              <label><b>Location of Project</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" value="<?php echo $project->location;?>" id="box" readonly="yes" name="location">  
            </div>
            <div class="w3-half">
              <label><b>Description of Project</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" value="<?php echo $project->description;?>" id="box" readonly="yes"  name="description">
            </div>
            <div class="w3-half">
              <label><b>Date of Commencement</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="commencement_date" value="<?php echo $project->date_begun;?>" id="box" readonly="yes"> 
            </div>
            <div class="w3-half">
              <label><b>Expected Date of Completion</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="completion_date" value="<?php echo $project->date_completion;?>" id="box" readonly="yes">
            </div>
            </fieldset>
            <fieldset class="w3-light-grey">
              <legend class="w3-text-red"><b>Project Manager</b></legend>
              <div class="w3-half">
                <label><b>Name</b></label>
                <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name_of_project_manager" value="<?php echo $projectM->name;?>" id="box" readonly="yes">
              </div>
              <div class="w3-half">
                <label><b>Phone</b></label>
                <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="project_manager_phone" value="<?php echo $projectM->phone;?>" id="box" readonly="yes">
              </div>
            </fieldset>
            <fieldset class="w3-light-grey">
              <legend class="w3-text-red"><b>Stores Administrator</b></legend>
              <div class="w3-half">
                <label><b>Name</b></label>
                <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name_of_stores_admin" value="<?php echo $storesAdmin->name;?>" id="box" id="box" readonly="yes">
              </div>
              <div class="w3-half">
                <label><b>Phone</b></label>
                <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="stores_admin_phone" value="<?php echo $storesAdmin->phone;?>" id="box" readonly="yes">
              </div>
            </fieldset>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <div class="w3-right">
              <?php if(Session::exist('PRINT_PROJECT')):?>
                <input type="hidden" name="field_name" value="status">
                <span id="print_btn" class="my-button w3-button" title="click to append approval and print"><b>Satisfied</b></span>
              <?php else:?>
                <input type="hidden" name="field_name" value="status">
                <button class="w3-button" type="submit" name="p_token" value="satisfied"><b>Satisfied</b></button>
              <?php endif;?>

                <?php echo "
                <span  onclick=\"showElement('notsatisfied-modal','".$project->id."')\" class=\"my-button w3-button\"><b>Not Satisfied</b></span>";
                ?>
              </div>
            </div>
            
          </div>
        </form>
      </div>
    </div> 
  <?php endif;?>
 
  </div>

  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-dark-grey">
    
    <p>Powered by <a href="#" target="_blank"><?php echo Config::get('developer/name');?></a></p>
  </footer>

  <!-- End page content -->
</div>

<!-- include external script files -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script>
  // create a new window to handle project printing
  var winProps = 'width=600, height=600, resizable=yes, scrollbars=yes';
  $('#print_btn').click(function(){
    var projectId = $('input[name="print_project_id"]').val();
    $.post("action_page.php", {p_token:'print', project_id:projectId, field_name:'status'}, function(response){

    })
    //open print window
    var printWin = open('print.php', 'printWin', winProps);
    window.location = "dashboard.php?pp=done";//redirect to the home page
    //printWin.close(); //dismiss the print window after printing the document
  })
  //handle material bill printing
  $('#print_bill_btn').click(function(){
    var projectId = $('input[name="print_bill_project_id"]').val();
    $.post("action_page.php", {p_token:'print', project_id:projectId, field_name:'bill_status'}, function(response){

    })
    //open print window
    var printWin = open('print.php', 'printWin', winProps);
    window.location = "dashboard.php?pb=done";//redirect to the home page
    //printWin.close(); //dismiss the print window after printing the document
  })
</script>

</body>
</html>

