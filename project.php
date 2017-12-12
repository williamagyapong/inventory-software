<?php
   require_once 'front_page_config.php';
   $projects = $project->get();
   $unbilledProjects = $project->getUnbilled();
   //print_array($project->getProjectMaterials(3));
?>

<!-- front end matter -->
<!DOCTYPE html>
<html>
 <head>
  <link rel="icon" type="image/x-icon" href="images/logo2.png">
  <title>Projects | NMIS</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
  <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
  <link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway"> -->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <style>
  html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif;}
  a{text-decoration: none;

  }
  a:active{
    background: white;
  }
  .project-content{
    background-image: url(images/conimg1.jpg);
    background-repeat: no-repeat; 
    min-height: 580px;
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
  <!-- menu bar -->
  <div class="w3-bar w3-grey w3-text-indigo" style="font-weight: bold;">
  <?php if($admin->role=='storekeeper'):?>
     <button id="tabs" class="w3-bar-item w3-button" onclick="openTab('modal','tab')" title="Registration">Register a project</button>
     <button id="tabs" class="w3-bar-item w3-button" onclick="openTab('bill-modal','tab')" title="Required Materials Bill">Prepare Materials Bill</button>

  <?php endif;?>
     <button id="tabs" class="w3-bar-item w3-button" onclick="openTab('modal2','tab')">Current Projects<span class="w3-badge w3-right w3-small w3-teal"><?php echo count($projects);?></span></button>
  </div>
  <div class="project-content">

      <!-- error reporting/messages -->
    <?php if(Session::exist('R_SUCCESS')&&Session::get('R_SUCCESS')=='project'):?>
    <div id="msg-dialog" class="w3-card-4 w3-text-red w3-padding" style="margin-left: 70px;">
        <h3>Project details have been successfully submited for approval</h3>
    </div>
  <?php elseif(Session::exist('R_SUCCESS')&&Session::get('R_SUCCESS')=='bill'):?>
    <div id="msg-dialog" class="w3-card-4 w3-text-red w3-padding" style="margin-left: 70px;">
        <h3>The bill has been successfully submited for approval</h3>
    </div>
    <?php endif;?>
    <?php Session::delete('R_SUCCESS');?><!-- disable success message-->
    <div class="w3-container">
        <!-- modal for project registration -->
      <div id="modal" class="tab" style="display: none;">
        <div class="w3-border w3-round" style="margin-top: 30px; position: relative;">
          <span id="p-close-btn" onclick="hideElement('modal')" class="fa fa-times w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal"></span>
          <div class="w3-center"><br>
             <h3 class="w3-text-red">Project Registration</h3>
          </div>
          <form id="registration_form" class="w3-container" action="action_page.php" method="post">
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
                <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="date" name="commencement_date" required="required"> 
              </div>
              <div class="w3-half">
                <label><b>Expected Date of Completion</b></label>
                <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="date" name="completion_date" required="required">
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
                  <input class="w3-input w3-border w3-margin-bottom w3-blue-grey numberonly" type="text" name="project_manager_phone" required="required" autocomplete="off">
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
                  <input class="w3-input w3-border w3-margin-bottom w3-blue-grey numberonly" type="text" name="stores_admin_phone" required="required" autocomplete="off">
                </div>
              </fieldset>
              <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <div class="w3-right">
                  <button class="w3-button" type="submit" name="register" value="register_project"><b>Submit For Approval</b></button>
                </div>
             </div>
            </div>
          </form>
        </div>
      </div> 
          <!--  Required materials Bill form-->
      <div id="bill-modal" class="tab" style="display: none;">
        <div class=" w3-border w3-modal-content w3-round " style="margin-top:30px;">
          <span id="p-close-btn" onclick="hideElement('bill-modal')" class="fa fa-times w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal"></span>
          <div class="w3-center"><br>
             <h3 class="w3-text-red">Required Materials Bill</h3>
          </div>
          <form id="mr_form" class="w3-container" action="action_page.php" method="post" onsubmit="return validateForm()">
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <input type="hidden" name="total_rows">
              <label><b>Name of Project:</b></label>
                <select name="project_id" class="w3-select w3-margin-bottom w3-border" autofocus required>
                  <option value=""></option>
                  <?php foreach($unbilledProjects as $thisProject):?>
                    <option value="<?php echo $thisProject->id;?>"><?php echo $thisProject->name;?></option>
                  <?php endforeach;?>
                </select>
              <div class="w3-responsive">
                <table class="w3-table">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Name of Material Needed For The Project</th>
                      <th>Quantity Needed</th>
                      <th>Quantity Already Available And Usable</th>
                      <th>Quantity to Purchase</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php for($x=0; $x<15;$x++):?>
                    <input type="hidden" name="COUNTER">
                    <tr id="field_row_<?php echo $x;?>">
                      <td><input type="checkbox" name="checked_<?php echo $x;?>" disabled></td>
                      <td><input class="material table-input" type="text" name="name_<?php echo $x;?>" onblur="checkRow();"></td>
                      <td><input type="text" name="quantity_<?php echo $x;?>" class="table-input numberonly" onblur="checkRow();autoFill()"></td>
                      <td><input type="text" name="quantity_available_usable_<?php echo $x;?>" class="table-input" onblur="checkRow()" readonly></td>
                      <td><input type="text" name="quantity_to_purchase_<?php echo $x;?>" class="table-input" onblur="checkRow()" readonly></td>
                    </tr>
                  <?php endfor;?>
                  </tbody>
                </table>
              </div>
              <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <div>
                  <span onclick="toggleFormRow('add_row')" class="w3-button my-button"><b>Add Row</b></span>
                  <span onclick="toggleFormRow('remove_row')" class="w3-button w3-text-red my-button"><b>Remove Row</b></span>
                </div>
                <div class="w3-right">
                  <span id="alert" class="w3-text-red w3-padding"></span>
                  <button class="w3-button" type="submit" name="p_token" value="submit_bill"><b>Submit For Approval</b></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div> 
     <!-- modal for current projects -->
      <div id="modal2" class="tab" style="display: none;">
        <div class="w3-border w3-round " style="margin-top: 30px; position: relative;">

          <div class="w3-center w3-light-blue"><br>
            <span id="p-close-btn" onclick="openTab('modal2')" class="fa fa-times w3-button w3-xlarge w3-text-white w3-hover-red w3-display-topright" title="Close Modal"></span>
            <h3>Current Projects</h3>
          </div>

           <div class="w3-responsive">
            <table class="talbe w3-table w3-striped w3-border w3-bordered">
              <tr>
               <th>ID</th>
               <th>Project Name</th>
               <th>Project Status</th>
               <th>Materials Bill Status</th>
               <th>Action</th>
              </tr>
              <?php $ID = 0;?>
              <?php foreach($projects as $nProject):
                 $ID++;
              ?>
              <tr title="<?php echo $nProject->d_notes;?>">
                <td>
                   <?php echo $ID;?>
                </td>
                <td>
                   <?php echo $nProject->name;?>
                </td>
                <td>
                  <?php echo $project->displayStatus($admin->role, $nProject->id);?>
                </td>
                <td>
                  <?php echo $project->displayBillStatus($admin->role, $nProject->id);?>
                </td>
                <td>
                 <a href="#" class="w3-button w3-text-teal w3-large" onclick="<?php echo "openTab('div".$nProject->id."')";?>;soundEffect('clicked')"><?php echo (($nProject->status==3)&&($admin->role=='storekeeper'))?'<i class="fa fa-pencil"></i>&nbsp;Edit':'<i class="fa fa-toggle-down"></i>&nbsp;View';?></a>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <div id="div<?php echo $nProject->id;?>" class="tabs w3-light-grey w3-card-4" style="display: none;" >
                    <?php $thisProject = $project->get($nProject->id)?>
                      <div class="w3-section">
                       <span onclick="<?php echo "hideElement('div".$nProject->id."')";?>" class="fa fa-times w3-button w3-large w3-hover-red" title="Close"></span>
                      <?php if(($nProject->status==3)&&($admin->role=='storekeeper')):?>
                        <!-- provide editable project details -->
                        <form class="w3-container" action="action_page.php" method="post">
                          <input type="hidden" name="project_id" value="<?php echo $thisProject->id;?>">
                          <div class="w3-section">
                           <fieldset class="w3-light-grey">
                            <div class="w3-half">
                              <label><b>Name of Project</b></label>
                              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name" value="<?php echo $thisProject->name;?>" required="required">
                            </div>
                            <div class="w3-half">
                              <label><b>Company In Charge of Project</b></label>
                              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="company" value="<?php echo $thisProject->company_in_charge;?>" required>
                            </div>
                            <div class="w3-half">
                              <label><b>Location of Project</b></label>
                              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="location" value="<?php echo $thisProject->location;?>" required>  
                            </div>
                            <div class="w3-half">
                              <label><b>Description of Project</b></label>
                              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text"  name="description" value="<?php echo $thisProject->description;?>" required="require">
                            </div>
                            <div class="w3-half">
                              <label><b>Date of Commencement</b></label>
                              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="date" name="commencement_date" value="<?php echo $thisProject->date_begun;?>" required="required"> 
                            </div>
                            <div class="w3-half">
                              <label><b>Expected Date of Completion</b></label>
                              <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="date" name="completion_date" value="<?php echo $thisProject->date_completion;?>" required="required">
                            </div>
                            </fieldset>
                            <fieldset class="w3-light-grey">
                              <legend class="w3-text-red"><b>Project Manager</b></legend>
                              <div class="w3-half">
                                <label><b>Name</b></label>
                                <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name_of_project_manager" value="<?php echo json_decode($thisProject->project_manager)->name;?>" required="required">
                              </div>
                              <div class="w3-half">
                                <label><b>Phone</b></label>
                                <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="project_manager_phone" value="<?php echo json_decode($thisProject->project_manager)->phone;?>" required="required">
                              </div>
                            </fieldset>
                            <fieldset class="w3-light-grey">
                              <legend class="w3-text-red"><b>Stores Administrator</b></legend>
                              <div class="w3-half">
                                <label><b>Name</b></label>
                                <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="name_of_stores_admin" value="<?php echo json_decode($thisProject->stores_admin)->name;?>" required="required">
                              </div>
                              <div class="w3-half">
                                <label><b>Phone</b></label>
                                <input class="w3-input w3-border w3-margin-bottom w3-blue-grey" type="text" name="stores_admin_phone" value="<?php echo json_decode($thisProject->stores_admin)->phone;?>" required="required">
                              </div>
                            </fieldset>
                            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                              <div class="w3-right">
                                <button class="w3-button" type="submit" name="register" value="update_project"><b>Submit For Approval</b></button>
                              </div>
                           </div>
                          </div>
                        </form>
                      <?php else:?><!-- non editable project details -->
                       <fieldset class="w3-light-grey">
                        <div class="w3-half">
                          <label><b>Name of Project</b></label>
                          <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $thisProject->name;?></div>
                        </div>
                        <div class="w3-half">
                          <label><b>Company In Charge of Project</b></label>
                          <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $thisProject->company_in_charge;?></div>
                        </div>
                        <div class="w3-half">
                          <label><b>Location of Project</b></label>
                          <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $thisProject->location;?></div>  
                        </div>
                        <div class="w3-half">
                          <label><b>Description of Project</b></label>
                          <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $thisProject->description;?></div>
                        </div>
                        <div class="w3-half">
                          <label><b>Date of Commencement</b></label>
                          <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $thisProject->date_begun;?></div>
                        </div>
                        <div class="w3-half">
                          <label><b>Expected Date of Completion</b></label>
                          <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo $thisProject->date_completion;?></div>
                        </div>
                        </fieldset>
                        <fieldset class="w3-light-grey">
                          <legend class="w3-text-red"><b>Project Manager</b></legend>
                          <div class="w3-half">
                            <label><b>Name</b></label>
                            <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo json_decode($thisProject->project_manager)->name;?></div>
                          </div>
                          <div class="w3-half">
                            <label><b>Phone</b></label>
                            <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo json_decode($thisProject->project_manager)->phone;?></div>
                          </div>
                        </fieldset>
                        <fieldset class="w3-light-grey">
                          <legend class="w3-text-red"><b>Stores Administrator</b></legend>
                          <div class="w3-half">
                            <label><b>Name</b></label>
                            <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo json_decode($thisProject->stores_admin)->name;?></div>
                          </div>
                          <div class="w3-half">
                            <label><b>Phone</b></label>
                            <div class="w3-border w3-margin-bottom w3-blue-grey w3-padding" id="box2"><?php echo json_decode($thisProject->stores_admin)->phone;?></div>
                          </div>
                        </fieldset> 
                        
                        <footer class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                        <?php if((($thisProject->status==0)||($thisProject->status==2))&&($admin->role=='manager')):?>
                          <div class="w3-right">
                            <button class="w3-button" type="submit" name="p_token" onclick="<?php echo "updateProject('".$thisProject->id."','satisfied')";?>;window.location='project.php'"><b>Satisfied</b></button>
                            <button class="w3-button" type="submit" onclick="<?php echo "showElement('notsatisfied-modal','".$thisProject->id."')";?>" ><b>Not Satisfied</b></button>
                            <?php elseif(($thisProject->status==3)&&($admin->role=='storekeeper')):?>
                            <button class="w3-button" type="submit" onclick="<?php echo "showElement('reconcile-modal','".$thisProject->id."')";?>"><b>Reconcile Differences</b></button>
                          </div>
                          <?php endif;?><!-- end of footer buttons if -->
                        </footer>
                        <!-- load materials if any -->
                        <?php $materials = $project->getProjectMaterials($nProject->id);?>
                        <?php if(count($materials) !=0):?>
                        <fieldset class="w3-white">
                          <legend class="w3-text-red"><b>Project Materials</b></legend>
                          <div class="w3-responsive">
                            <table class="w3-table w3-striped w3-bordered">
                             <tr>
                              <th></th>
                              <th>Name of Material Needed For The Project</th>
                              <th>Quantity Needed</th>
                              <th>Quantity Already Available And Usable</th>
                              <th>Quantity to Purchase</th>
                             </tr>
                              <?php foreach($materials as $material):?>
                             <tr>
                              <td></td>
                              <td><?php echo $material->name;?></td>
                              <td><?php echo $material->quantity_needed;?></td>
                              <td><?php echo $material->quantity;?></td>
                              <td><?php echo $material->quantity<$material->quantity_needed?$material->quantity_needed-$material->quantity: 0; ?></td>
                             </tr>
                             <?php endforeach;?>
                            </table>
                          </div>
                        </fieldset>
                        <?php endif;?><!-- end of materials if -->
                        <?php endif;?><!-- end of project type if -->
                      </div>
                  </div>
                </td>
              </tr>
              <?php endforeach;?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="w3-row-padding w3-margin-bottom">
      <!-- require pop up dialog boxes here -->
      <?php require_once'includes/pop_ups.php';?>
  </div>
 </div>
  <!-- End page content -->
</div>

<!-- audio file -->
<audio id="clicked">
     <!-- <source src="audio/mouseclick2.mp3" type="audio/mpeg">   -->                   
</audio>
<!-- Include javascript -->

<script src="js/jquery.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/project_stock.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
  $(document).ready(function(){
        //background properties manipulation
    $(document).on('click', '#tabs', function(){
      $('.project-content').css({"background":"white"});
      //$(this).css({"background":"white"});
    })

    $(document).on('click', '#p-close-btn', function(){

      $('.project-content').css({"background-image":"url(images/conimg1.jpg)",
            "background-size":"100%","background-repeat":"no-repeat"
         });
      
    })

        
        
  })
</script>

</body>
</html>

