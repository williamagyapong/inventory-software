<?php
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
 }
 
 $admin = $user->data();
 $nonApprovedProjects = DBHandler::getInstance()->get('projects', array('approved', '=', 0))->results();
 print_array($nonApprovedProjects);die();
 //$orders = DBHandler::getInstance()->get('orders', array())->results();
 //$customers = DBHandler::getInstance()->get('customers', array())->results();
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="css/main.css">
  </head>
  
<body class="w3-white">

<!-- Top container -->
<?php require_once 'includes/header.php';?>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:40px;">

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
        <div class="w3-section">
         <fieldset class="w3-light-grey">
          <div class="w3-half">
            <label><b>Name of Project</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name" value="" readonly="yes">
          </div>
          <div class="w3-half">
            <label><b>Company In Charge of Project</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="company" value="" readonly="yes">
          </div>
          <div class="w3-half">
            <label><b>Location of Project</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" value="" readonly="yes" name="location">  
          </div>
          <div class="w3-half">
            <label><b>Description of Project</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" value="" readonly="yes"  name="description">
          </div>
          <div class="w3-half">
            <label><b>Date of Commencement</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="commencement_date" value="" readonly="yes"> 
          </div>
          <div class="w3-half">
            <label><b>Expected Date of Completion</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="completion_date" value="" readonly="yes">
          </div>
          </fieldset>
          <fieldset class="w3-light-grey">
            <legend class="w3-text-red"><b>Project Manager</b></legend>
            <div class="w3-half">
              <label><b>Name</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name_of_project_manager" value="" readonly="yes">
            </div>
            <div class="w3-half">
              <label><b>Phone</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="project_manager_phone" value="" readonly="yes">
            </div>
          </fieldset>
          <fieldset class="w3-light-grey">
            <legend class="w3-text-red"><b>Stores Administrator</b></legend>
            <div class="w3-half">
              <label><b>Name</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name_of_stores_admin" value="" readonly="yes">
            </div>
            <div class="w3-half">
              <label><b>Phone</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="stores_admin_phone" value="" readonly="yes">
            </div>
          </fieldset>
          <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
            <button class="w3-button w3-block w3-indigo w3-section w3-padding" type="submit" name="satisfied"><b>Satisfied</b></button>
            <button class="w3-button w3-block w3-indigo w3-section w3-padding" type="submit" name="notsatisfied"><b>Not Satisfied</b></button>
          </div>
          
        </div>
      </form>
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

