<?php
  require_once 'front_page_config.php';
 
 if($admin->role !='manager') {
   Redirect::to('index.php');
 }
 $project = DBHandler::getInstance()->get('projects', array('status', '=', 0))->results()[0];
 $projectM = json_decode($project->project_manager);
 $storesAdmin = json_decode($project->stores_admin);

?>

<!-- front end matter -->
<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
    <title>Dashboard</title>
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

  <div class="w3-row-padding w3-margin-bottom">
     <!-- modal for project confirmation -->
  <div id="modal">
    <div class="w3-modal-content w3-border w3-round" style="max-width:690px;margin-top: 30px;">
      <div class="w3-center"><br>
         <h3>Project Registration Details</h3>
      </div>

      <form class="w3-container" action="action_page.php" method="post">
        <input type="hidden" name="projectId" value="<?php echo $project->id;?>">
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
            <?php if(Session::exist('PRINTING')):?>
              <button class="w3-button  w3-indigo w3-section w3-padding" type="submit" name="p_token" value="print"><b>Satisfied</b></button>
            <?php else:?>
              <button class="w3-button  w3-indigo w3-section w3-padding" type="submit" name="p_token" value="satisfied"><b>Satisfied</b></button>
            <?php endif;?>

              <?php echo "
              <span  onclick=\"showElement('notsatisfied-modal','".$project->id."')\" class=\"w3-button  w3-indigo w3-section w3-padding\"><b>Not Satisfied</b></span>";
              ?>
            </div>
          </div>
          
        </div>
      </form>
    </div>
  </div> 
          <!-- Not satisfied dialog box -->
   <div id="notsatisfied-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round" style="max-width:600px">
      <header class="w3-container w3-indigo"> 
        <span onclick="hideElement('notsatisfied-modal')" 
        class="w3-button w3-hover-red w3-display-topright w3-xlarge">&times;</span>
        <h3>Registration Dissatisfaction Note</h3>
      </header>

      <div class="w3-container w3-text-red w3-large w3-bold w3-center">
        <form action="action_page.php" method="post">
            <textarea class="w3-input w3-border w3-margin-top" name="notes" placeholder="Please write here"></textarea>
            <!-- set the value field when this modal is displayed -->
            <input type="hidden" name="projectId" id="nspId">
        
      </div>

      <footer class="w3-container w3-light-grey">
       <div class="w3-right">
        <button type="reset" class="w3-button">Clear</button>
        <button type="submit" name="p_token" value="notsatisfied" class="w3-button" onclick="document.getElementById('notsatisfied-modal').style.display='none'">Submit</button>
         </form>
       </div>
      </footer>
    </div>
   </div>
  </div>

  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-dark-grey">
    
    <p>Powered by <a href="#" target="_blank"><?php echo Config::get('client/name');?></a></p>
  </footer>

  <!-- End page content -->
</div>

<!-- include external script files -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>

