<?php
function activeItem($page){
	$ser = $_SERVER["SCRIPT_NAME"];

	if ($page == $ser) {

		return "w3-white";
	}
}
$projectsForApproval = DBHandler::getInstance()->get('projects', array('approved','=',0))->results();
?>

  <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <!-- <span class="w3-bar-item w3-center">BusinessRecords</span> -->
  <span class="w3-bar-item w3-right" style="cursor: pointer;"><img src="images/logo2.png" width="65" height="30"> <?php echo Config::get('app/name');?></span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-light-grey w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="images/avator.png" class="w3-circle w3-margin-right w3-hover-sepia" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span><?php echo $admin->username; ?>, <strong><?php echo $admin->role?></strong></span><br>
      <a href="#?pid=12" class="w3-bar-item w3-button" title="Notifications"><i class="fa fa-bell w3-text-indigo" onclick="showElement('nmodal')"></i><span class="w3-badge w3-right w3-small w3-red" title="<?php echo count($projectsForApproval);?> projects needs approval"><?php echo count($projectsForApproval);?></span></a>
      <div class="w3-dropdown-content">
        <?php foreach($projectsForApproval as $project):?>
          <li><?php echo $project->name;?></li>
        <?php endforeach; ?>
      </div>
      
      <a href="logout.php" class="w3-bar-item w3-button" title="Exit"><i class="fa fa-sign-out w3-text-indigo"></i></a>
      <a href="#" class="w3-bar-item w3-button" title="Settings"><i class="fa fa-cog w3-text-indigo"></i></a>
    </div>
  </div>
  <div class="hrule"></div>
  
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw "></i>  Close Menu</a>
    <a href="dashboard.php" class="<?php echo activeItem('/napol-inventory/dashboard.php');?> w3-bar-item w3-button w3-padding w3-hover-blue"><i class="fa fa-dashboard fa-fw w3-text-indigo"></i> Dashboard</a>
    <a  class="<?php echo activeItem('/napol-inventory/project.php');?> w3-bar-item w3-button w3-padding w3-hover-blue" href="project.php"><i class="fa fa-line-chart fa-fw w3-text-indigo"></i>  Projects</a>
     <a  class="<?php echo activeItem('/napol-inventory/stock.php');?> w3-bar-item w3-button w3-padding w3-hover-blue" href="stock.php"><i class="fa fa-refresh fa-fw w3-text-indigo"></i>  Stock</a>
    
  </div>
</nav>
    
