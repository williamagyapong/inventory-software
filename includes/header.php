
  <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey w3-right" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <!-- <span class="w3-bar-item w3-center">BusinessRecords</span> -->
  <span class="w3-bar-item w3-left" style="cursor: pointer;"><img src="images/logo2.png" width="65" height="30"> <span class="w3-hide-small"><?php echo Config::get('app/name');?></span></span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-light-grey w3-animate-left" style="z-index:3;width:265px;resize: auto;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="images/avator.png" class="w3-circle w3-margin-right w3-hover-sepia" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span><?php echo $admin->username; ?>, <strong><?php echo $admin->role?></strong></span><br>
    <?php if (($admin->role == 'manager') && (count($projectsForApproval))!=0):?>
      <button class="w3-bar-item w3-button" onclick="showElement('nmodal')"><i class="fa fa-bell w3-text-indigo"></i><span class="w3-badge w3-right w3-small w3-red" title="<?php echo count($projectsForApproval);?> project needs your approval"><?php echo count($projectsForApproval);?></span> </button>
    <? else:?>
      <a href="#" class="w3-bar-item w3-button" title="Notifications"><i class="fa fa-bell w3-text-indigo"></i><span class="w3-badge w3-right w3-small w3-red"></span></a>
     <? endif;?>
      <a href="logout.php" class="w3-bar-item w3-button" title="Exit"><i class="fa fa-sign-out w3-text-indigo"></i></a>
      <a href="#" class="w3-bar-item w3-button" title="Settings"><i class="fa fa-cog w3-text-indigo"></i></a>
    </div>
  </div>
  <div class="hrule"></div>
  
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><span class="w3-right"><i class="fa fa-remove fa-fw "></i> Close Menu</span></a>
    <a href="dashboard.php" class="<?php echo activePage('/napol-inventory/dashboard.php');?> w3-bar-item w3-button w3-padding w3-hover-blue"><i class="fa fa-dashboard fa-fw w3-text-indigo"></i> Dashboard</a>
    <a  class="<?php echo activePage('/napol-inventory/project.php');?> w3-bar-item w3-button w3-padding w3-hover-blue" href="project.php"><i class="fa fa-line-chart fa-fw w3-text-indigo"></i>  Projects</a>
     <a  class="<?php echo activePage('/napol-inventory/stock.php');?> w3-bar-item w3-button w3-padding w3-hover-blue" href="stock.php"><i class="fa fa-refresh fa-fw w3-text-indigo"></i>  Stock</a>
    
  </div>
</nav>

<!-- set the role of the logged in user for use on the js side -->
<input type="hidden" id="user_role" value="<?php echo $admin->role;?>">
    
