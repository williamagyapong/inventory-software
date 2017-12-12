
<div class="w3-bar w3-top w3-card-4 w3-blue-grey w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey w3-right" onclick="w3_open();"><i class="fa fa-bars"></i>Menu</button>
  <span class="w3-bar-item w3-left" style="cursor: pointer;"><img src="images/logo2.png" width="65" height="30" class="logo"> <span class="w3-hide-small"><?php echo Config::get('app/name');?></span></span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-light-grey w3-animate-left" style="z-index:3;width:265px;resize: auto;" id="mySidebar"><br>
  <div class="w3-container w3-row">
  <!-- top menu -->
    <div class="w3-col s3">
      <img src="images/avator.png" class="w3-circle w3-margin-right w3-hover-sepia" style="width:46px">
    </div>
    <div class="w3-col s9 w3-bar">
      <span><?php echo $admin->username; ?>, <strong><?php echo $admin->role?></strong></span><br>
    <?php if (($admin->role == 'manager') && ($totalNotices!=0)):?> <!-- first condition -->
     <div class="w3-dropdown-hover">
      <button class="w3-button"><i class="fa fa-bell w3-text-indigo"></i><span class="w3-badge w3-right w3-small w3-red"><?php echo $totalNotices;?></span> </button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
       <!-- load projects for approval -->
       <?php if($numProjects !=0):?>
       <button class="w3-bar-item w3-button w3-border-bottom w3-border-bottom" onclick="showElement('nmodal')"><?php echo ($numProjects==1)?'1 Project for approval':$numProjects.' Projects for approval';?></button>
       <?php endif;?>
       <?php if($numBills !=0):?>
       <button class="w3-bar-item w3-button w3-border-bottom" onclick="showElement('nbillmodal')"><?php echo ($numBills==1)?'1 Bill for approval':$numBills.' Bills for approval';?></button>
       <?php endif;?>
       <!-- show reminders -->
       <?php if($numProjectReminders !=0):?><!-- render project approval reminders-->
       <button class="w3-bar-item w3-button w3-border-bottom" onclick="showElement('nbillmodal')"><?php echo ($numProjectReminders==1)?'1 project approval reminder':$numProjectReminders.' project approval reminders';?></button>
       <?php endif;?>
       <?php if($numBillReminders !=0):?><!-- render bills approval reminders-->
       <button class="w3-bar-item w3-button w3-border-bottom" onclick="showElement('nbillmodal')"><?php echo ($numBillReminders==1)?'1 Material Bill reminder':$numBillReminders.' Material Bill reminders';?></button>
       <?php endif;?>
      </div>
      </div>
    <?php elseif(($admin->role == 'manager') && ($totalNotices==0)):?>
      <a href="#" class="w3-bar-item w3-button" title="Notifications"><i class="fa fa-bell w3-text-indigo"></i><span class="w3-badge w3-right w3-small w3-red"></span></a>
    <!-- display storekeepers messages -->
    <?php elseif(($admin->role == 'storekeeper') && ($totalMessages!=0)):?>
      <a href="#" class="w3-bar-item w3-button" title="<?php echo $totalMessages;?> messages" onclick="showElement('storekeeper_msg_modal')"><i class="fa fa-envelope w3-text-indigo"></i><span class="w3-badge w3-right w3-small w3-red"><?php echo $totalMessages;?></span></a>
    <?php elseif(($admin->role == 'storekeeper') && ($totalMessages==0)):?>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope w3-text-indigo"></i><span class="w3-badge w3-right w3-small w3-green">0</span></a>
     <?php endif;?> <!-- first condition tail-->
      <a href="settings.php" class="w3-bar-item w3-button" title="Settings"><i class="fa fa-cog w3-text-indigo"></i></a>
      <a href="logout.php" class="w3-bar-item w3-button" title="Exit"><i class="fa fa-sign-out w3-text-indigo"></i></a>
    </div>
  </div>
  <div class="hrule"></div>
  <!-- left side menu -->
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><span class="w3-right"><i class="fa fa-remove fa-fw "></i> Close Menu</span></a>
    <a href="dashboard" class="<?php echo activePage('dashboard.php');?> w3-bar-item w3-button w3-padding w3-hover-blue"><i class="fa fa-dashboard fa-fw w3-text-indigo"></i> Dashboard</a>
    <a  class="<?php echo activePage('project.php');?> w3-bar-item w3-button w3-padding w3-hover-blue" href="project"><i class="fa fa-line-chart fa-fw w3-text-indigo"></i>  Projects</a>
     <a  class="<?php echo activePage('stock.php');?> w3-bar-item w3-button w3-padding w3-hover-blue" href="stock"><i class="fa fa-refresh fa-fw w3-text-indigo"></i>  Stock</a>
    
  </div>
</nav>

<!-- set the role of the logged in user for use on the js side -->
<input type="hidden" id="user_role" value="<?php echo $admin->role;?>">
    
