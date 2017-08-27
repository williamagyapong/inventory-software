<?php
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
 }
 
 $admin = $user->data();
 //$services = DBHandler::getInstance()->get('services', array())->results();
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
     <!-- Project approval alert modal -->
   <div id="nmodal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large" style="max-width:600px">
      <header class="w3-container w3-indigo"> 
        <span onclick="hideElement('nmodal')" 
        class="w3-button w3-hover-red w3-display-topright w3-xlarge">&times;</span>
        <h2>Project Approval</h2>
      </header>

      <div class="w3-container w3-text-red w3-large w3-bold">
        <p><b>Please confirm that the Registration Info entered by Storekeeper is correct</b></p>
      </div>

      <footer class="w3-container w3-indigo">
        <a href="approve.php?pid=<?php echo Input::get('get','pid');?>" class="w3-button">Show</a>
        <a href="" class="w3-button">Print</a>
        <a href="" class="w3-button">Remind Me Later</a>
      </footer>

    </div>
   </div>
     <!-- modal for project confirmation -->
  <div id="modal" class="w3-hide">
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


  <hr>
  <div class="w3-container">
    <h5>General Stats</h5>
    <p>New Visitors</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-green" style="width:25%">+25%</div>
    </div>

    <p>New Users</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-orange" style="width:50%">50%</div>
    </div>

    <p>Bounce Rate</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-red" style="width:75%">75%</div>
    </div>
  </div>
  <hr>

  
  <br>


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

