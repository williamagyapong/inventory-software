<?php
 require_once 'front_page_config.php';

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
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway"> -->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <style>
  html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
  a{text-decoration: none;}
  .stock-content{
    background-image: url(images/conmat2.jpg);
    background-repeat: no-repeat;
    background-size: 100%; 
    min-height: 500px;
  }
  </style>
 </head>

<body id="body">

<!-- Top container -->
<?php require_once 'includes/header.php';?>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div id="main-content" class="w3-main">
    <div class="w3-bar w3-grey w3-text-indigo" style="font-weight: bold;">
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="document.getElementById('modal').style.display='block'">Add Stock</a>
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="document.getElementById('modal').style.display='block'">Current Stock</a>
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="document.getElementById('modal').style.display='block'">Dispatch Stock</a>
  </div>
  <div class="stock-content">
    
  </div>



  

  <!-- End page content -->
</div>

<script type="text/javascript" src="js/custom.js"></script>
<script src="js/jquery.js"></script>
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

  //background properties manipulation
$(document).on('click', '#tabs', function(){
  $('.stock-content').css({"background":"white"});
  
})
$(document).on('click', '#p-close-btn', function(){
  $('.stock-content').css({"background-image":"url(images/conimg1.jpg)",
        "background-size":"100%","background-repeat":"no-repeat"
     });
})
</script>

</body>
</html>

