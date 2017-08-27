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
  html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
  a{text-decoration: none;}
  </style>
 </head>

<body>

<!-- Top container -->
<?php require_once 'includes/header.php';?>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">
    <div class="w3-bar w3-grey w3-text-indigo" style="font-weight: bold;">
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="document.getElementById('modal').style.display='block'">Add Stock</a>
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="document.getElementById('modal').style.display='block'">Current Stock</a>
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="document.getElementById('modal').style.display='block'">Dispatch Stock</a>
  </div>
</div>


  <!-- Footer -->
  

  <!-- End page content -->
</div>

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

