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
  <link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <style>
  html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif;}
  a{text-decoration: none;

  }
  a:active{
    background: white;
  }
  </style>
 </head>
<body>

<!-- Top container -->
<?php require_once 'includes/header.php';?>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">
  <div class="w3-bar w3-card w3-grey w3-text-indigo" style="font-weight: bold;">
  <?php if($admin->role=='storekeeper'):?>
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="openTab('modal')">Registration</a>
  <?php endif;?>
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="openTab('modal2')">Current Projects</a>
  </div>
  <!-- error reporting/messages -->
  <?php if(Session::exist('R_SUCCESS')):?>
  <div class="w3-card-4 w3-text-red">
      <h3>Project Registration Info has been successfully submited for approval</h3>
      <?php Session::delete('R_SUCCESS');?>
  </div>
  <?php endif;?>
  <div class="w3-container">
  <!-- modal for project registration -->
  <div id="modal" class="tab">
    <div class="w3-modal-content w3-border w3-round " style="max-width:690px;margin-top: 30px;">
      <span onclick="this.parentElement.style.display='none'" class="w3-button w3-xxlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
      <div class="w3-center"><br>
        
        <img src="img_avatar4.png" alt="Project Registration" style="width:30%" class="w3-circle w3-margin-top">
      </div>

      <form class="w3-container" action="action_page.php" method="post">
        <div class="w3-section">
         <fieldset class="w3-light-grey">
          <div class="w3-half">
            <label><b>Name of Project</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name" required="required">
          </div>
          <div class="w3-half">
            <label><b>Company In Charge of Project</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="company" required>
          </div>
          <div class="w3-half">
            <label><b>Location of Project</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="location" required>  
          </div>
          <div class="w3-half">
            <label><b>Description of Project</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text"  name="description" required>
          </div>
          <div class="w3-half">
            <label><b>Date of Commencement</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="commencement_date" required="required"> 
          </div>
          <div class="w3-half">
            <label><b>Expected Date of Completion</b></label>
            <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="completion_date" required="required">
          </div>
          </fieldset>
          <fieldset class="w3-light-grey">
            <legend class="w3-text-red"><b>Project Manager</b></legend>
            <div class="w3-half">
              <label><b>Name</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name_of_project_manager" required="required">
            </div>
            <div class="w3-half">
              <label><b>Phone</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="project_manager_phone" required="required">
            </div>
          </fieldset>
          <fieldset class="w3-light-grey">
            <legend class="w3-text-red"><b>Stores Administrator</b></legend>
            <div class="w3-half">
              <label><b>Name</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name_of_stores_admin" required="required">
            </div>
            <div class="w3-half">
              <label><b>Phone</b></label>
              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="stores_admin_phone" required="required">
            </div>
          </fieldset>
          <button class="w3-button w3-block w3-indigo w3-section w3-padding" type="submit" name="register"><b>Submit For Approval</b></button>
          
        </div>
      </form>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button onclick="openTab('modal')" type="button" class="w3-button w3-red w3-right"><strong>Cancel</strong></button>
      </div>

    </div>
  </div>
 <!-- modal for current projects -->
  <div id="modal2" class="tab" style="display: none;">
    <div class="w3-modal-content w3-border w3-round " style="max-width:690px;margin-top: 30px;">

      <div class="w3-center"><br>
        <span onclick="openTab('modal2')" class="w3-button w3-xxlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
        <img src="img_avatar4.png" alt="Current Projects" style="width:30%" class="w3-circle w3-margin-top">
      </div>

      <form class="w3-container" action="/action_page.php">
        <div class="w3-section">
          <label><b>Name of Project</b></label>
          <input class="w3-input w3-border w3-margin-bottom " type="text" placeholder="Enter Username" name="usrname" required>
          <label><b>Company In Charge</b></label>
          <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="psw" required>
          
          <button class="w3-button w3-block w3-indigo w3-section w3-padding" type="submit"><b>Submit For Approval</b></button>
          
        </div>
      </form>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button onclick="openTab('modal2')" type="button" class="w3-button w3-red w3-right"><strong>Cancel</strong></button>
      </div>

    </div>
  </div>
</div>
  </div>
   
<!-- </div> -->


  <!-- Footer -->
  

  <!-- End page content -->
</div>

<!-- Include javascript -->
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

