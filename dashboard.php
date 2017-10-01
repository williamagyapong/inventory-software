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
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">-->
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway"> -->
    <link rel="stylesheet" type="text/css" href="css/main.css">
  </head>
  
<body class="w3-white" id="body">

<!-- Top container -->
<?php require_once 'includes/header.php';?>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div id="main-content" class="w3-main">

  <!-- Header -->
  <nav class="w3-bar w3-grey w3-text-indigo" style="position: fixed; font-weight: bold;">
    <a href="#c-levels" id="tabs" class="w3-bar-item w3-button">Completion Levels</a>
    <a href="#classify" id="tabs" class="w3-bar-item w3-button">Classifications</a>
  </nav>
  <!-- load reminded/to-be-printed projects here -->
  <div id="reminded"> </div>
  <div class="w3-row-padding w3-margin-bottom">
    <!-- require pop up dialog boxes here -->
    <?php require_once'includes/pop_ups.php';?>

  </div>
  <!-- welcome the user --><br>
  <div id="welcome" class="w3-card-4 w3-padding w3-margin">welcome <?php echo $admin->name;?></div>

  <div class="w3-container">
    <h5 class="w3-bold w3-xlarge" style="">General Statistics</h5>
    
    <div id="c-levels" class="w3-card-4 w3-padding">
      <h3 class="w3-text-grey">Projects Completion Levels</h3>
      <canvas id="chart" width="250" height="110"></canvas>
    </div>
    <div id="classify" class="w3-card-4 w3-padding" style="margin-top: 25px;">
      <h3 class="w3-text-grey">Project Classifications</h3>
      <p>Non satisfactory Project Registration</p>
      <div class="w3-grey">
        <div class="w3-container w3-center w3-padding w3-green" style="width:25%">25%</div>
      </div>

      <p>Approved Projects</p>
      <div class="w3-grey">
        <div class="w3-container w3-center w3-padding w3-orange" style="width:50%">50%</div>
      </div>

      <p>Projects Awaiting Approval</p>
      <div class="w3-grey">
        <div class="w3-container w3-center w3-padding w3-red" style="width:25%">25%</div>
      </div>
    </div>
  </div>
  <hr>

  
  <br>


  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-dark-grey">
    
    <p>Powered by <a href="#" target="_blank"><?php echo Config::get('developer/name');?></a></p>
  </footer>

  <!-- End page content -->
</div>

<!-- include external script files -->

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/Chart.js"></script>
<script type="text/javascript" src="js/chartconfig.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script>


//invoking reminder modal
var token = "<?php echo $reminders ?>";
var userRole = $('#user_role').val();
  if(token !=0 && userRole!=='storekeeper') {
    showElement('rmodal');
  }
  
// user log in welcome message
 $(document).ready(function(){
    $('#welcome').hide().slideDown(3000, function(){
       $(this).fadeOut(6000);
    });
 })
</script>

</body>
</html>

