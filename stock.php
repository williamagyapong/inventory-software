<?php
 require_once 'front_page_config.php';
 $project = new Project();
 $matObject = new Material();
 $billedProjects = $project->getBilled();
 $matNum = 0;
 //print_array($matObject->getProjectMaterials(6));

?>

<!-- front end matter -->
<!DOCTYPE html>
<html>
 <head>
  <link rel="icon" type="image/x-icon" href="images/logo2.png">
  <title>Stock | NMIS</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
  <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
  <link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway"> -->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <style>
  html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
  a{text-decoration: none;}
  .stock-content{

   /* background-image: url(images/background1.jpg);
    background-repeat: no-repeat;
    background-size: 100%; */
    background:#4ca1af;
    background:-webkit-linear-gradient(to right, #4ca1af,#c4e0e5);
    background:linear-gradient(to right, #4ca1af,#c4e0e5);
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
    <div class="w3-bar w3-grey w3-text-indigo" style="font-weight: bold;">
    <?php if($admin->role =='storekeeper'):?>
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="openTab('add-modal','tab')">Add Stock</a>
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="openTab('receive-modal','tab')">Receive Stock</a>
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="openTab('dispatch-modal','tab') " title="Issue materials from store to site">Dispatch Stock</a>
    <?php endif;?>
     <a href="#" id="tabs" class="w3-bar-item w3-button" onclick="openTab('current-modal','tab')">Current Stock</a>
  </div>
  <div class="stock-content">
     <!-- messaging board -->
      <?php if(Session::exist('R_SUCCESS')&&Session::get('R_SUCCESS')=='received'):?>
      <div id="msg-dialog" class="w3-card-4 w3-text-red w3-padding w3-center" style="margin-left: 70px;margin-right: 70px">
          <h3> details of materails have been submited for approval</h3>
      </div>
      <?php elseif(Session::exist('R_SUCCESS')&&Session::get('R_SUCCESS')=='bill'):?>
      <div id="msg-dialog" class="w3-card-4 w3-text-red w3-padding w3-center" style="margin-left: 70px; margin-right: 70px">
          <h3>The bill has been successfully submited for approval</h3>
      </div>
      <?php elseif(Session::exist('R_SUCCESS')&&Session::get('R_SUCCESS')=='new_mat_added'):?>
      <div id="msg-dialog" class="w3-card-4 w3-text-red w3-padding w3-center" style="margin-left: 70px; margin-right: 70px">
          <h3>New materials saved</h3>
      </div>
     <?php elseif(Session::exist('R_SUCCESS')&&Session::get('R_SUCCESS')=='changes_saved'):?>
      <div id="msg-dialog" class="w3-card-4 w3-text-red w3-padding w3-center" style="margin-left: 70px; margin-right: 70px">
          <h3>Changes saved successfully</h3>
      </div>
      <?php elseif(Session::exist('R_SUCCESS')&&Session::get('R_SUCCESS')=='deleted'):?>
      <div id="msg-dialog" class="w3-card-4 w3-text-red w3-padding w3-center" style="margin-left: 70px; margin-right: 70px">
          <h3>One record deleted</h3>
      </div>
    <?php elseif(Session::exist('R_SUCCESS')&&Session::get('R_SUCCESS')=='dispatched'):?>
      <div id="msg-dialog" class="w3-card-4 w3-text-red w3-padding w3-center" style="margin-left: 70px; margin-right: 70px">
          <h3>Dispatched items saved successfully</h3>
      </div>
    
    <?php endif;?>
    <?php Session::delete('R_SUCCESS');?><!-- disable  message -->
    <div class="w3-container">
        <!--  New materials form-->
      <div id="add-modal" class="tab" style="display: none;">
        <div class="w3-border w3-modal-content w3-round" style="margin-top: 30px;">
          <span id="p-close-btn" onclick="hideElement('add-modal')" class="fa fa-times w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal"></span>
          <div class="w3-center"><br>
             <h3 class="w3-text-red">Add New Materials to Stock</h3>
          </div>
          <form id="add_form" class="w3-container" action="action_page.php" method="post" onsubmit="return validateNewMatForm()">
            <div class="w3-container w3-card-4 w3-round w3-margin-bottom w3-border-top w3-padding-16 w3-light-grey">
              <div class="w3-responsive">
                <table class="w3-table-all">
                  <thead>
                    <tr>
                      <th><span class="fa fa-check-square w3-indigo"></span></th>
                      <th>Name of Material </th>
                      <th>Quantity</th>
                      <th>Unit of Measurement</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php for($x=0;$x<5;$x++):?>
                    <tr id="field_row_<?php echo $x;?>">
                      <td><input type="checkbox" name="checked_<?php echo $x;?>" value="checked" class="w3-check"></td>
                      <td><input class="new-material table-input" type="text" name="name_<?php echo $x;?>"></td>
                      <td><input type="number" class="table-input" name="quantity_<?php echo $x;?>"></td>
                      <td><input type="text" name="unit_<?php echo $x;?>" class="table-input"></td>
                    </tr>
                  <?php endfor;?>
                  </tbody>
                </table>
              </div>
              <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <div>
                  <span id="check" onclick="checkAll()" class="w3-button my-button"><b>Select All</b></span>
                </div>
                <div class="w3-right">
                  <span id="add-alert" class="w3-text-red w3-padding"></span>
                  <button class="w3-button " type="submit" name="p_token" value="add_new_mat"><b>Save</b></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div> 
          <!--  Received materials form-->
      <div id="receive-modal" class="tab" style="display: none;">
        <div class="w3-border w3-modal-content w3-round" style="margin-top: 30px;">
          <span id="p-close-btn" onclick="hideElement('receive-modal')" class="fa fa-times w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal"></span>
          <div class="w3-center"><br>
             <h3 class="w3-text-red">Receive Materials for Store</h3>
          </div>
          <form id="mr_form" class="w3-container" action="action_page.php" method="post" onsubmit="">
            <div class="w3-container w3-card-4 w3-round w3-margin-bottom w3-border-top w3-padding-16 w3-light-grey">
              <input type="hidden" name="total_rows">
              <div class="w3-responsive">
                <table class="w3-table-all">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Name of Material </th>
                      <th>Quantity Received </th>
                      <th>Date Received</th>
                      <th>Current Quantity of Material at Store </th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php for($x=0; $x<30;$x++):?>
                    <input type="hidden" name="COUNTER">
                    <tr id="field_row_<?php echo $x;?>">
                      <td><input type="checkbox" name="checked_<?php echo $x;?>"></td>
                      <td><input class="material table-input" type="text" name="name_<?php echo $x;?>"></td>
                      <td><input type="text" name="quantity_received_<?php echo $x;?>" class="table-input"></td>
                      <td><input type="date" name="date_received_<?php echo $x;?>" class="table-input" ></td>
                      <td><input type="text" name="current_quantity_<?php echo $x;?>" class="table-input"  readonly></td>
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
                  <button class="w3-button " type="submit" name="p_token" value="receive"><b>Submit For Approval</b></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div> 
         <!--   materials issued out form-->
      <div id="dispatch-modal" class="tab" style="display: none;">
        <div class=" w3-border w3-modal-content w3-round" style="margin-top: 30px">
          <span id="p-close-btn" onclick="hideElement('dispatch-modal')" class="fa fa-times w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal"></span>
          <div class="w3-center"><br>
             <h3 class="w3-text-red">Issuing Materials from Store to Site</h3>
          </div>
          <form id="dispatch_form" class="w3-container" action="action_page.php" method="post" onsubmit="">
            <div class="w3-container w3-card-4 w3-round w3-margin-bottom w3-border-top w3-padding-16 w3-light-grey">
              <label><b>Name of Project:</b></label>
                <select name="project_id" class="w3-select w3-margin-bottom w3-border" required>
                  <option value="" class="w3-text-indigo">--Select project to issue materials against--</option>
                  <?php foreach($billedProjects as $thisProject):?>
                    <option value="<?php echo $thisProject->id;?>"><?php echo $thisProject->name;?></option>
                  <?php endforeach;?>
                </select>
                <div class="w3-container">
                  <span id="load_mat_btn" class="my-button w3-button w3-right"><b>Load Materials</b></span><br>
                </div>
              <div class="w3-responsive">
                <table class="w3-table">
                  <thead>
                    <tr>
                      <th title="check to include item"><span class="fa fa-check-square w3-indigo"></span></th>
                      <th>Name of Material Sent Out</th>
                      <th>Quantity Sent Out </th>
                    </tr>
                  </thead>
                  <tbody id="materials">
                    <!-- load materials via ajax request -->
                  </tbody>
                </table>
               </div>
                <fieldset class="w3-margin-top">
                  <div class="w3-half">
                    <label><b>Name of Receiving Department</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="receiving_dept" required="required">
                  </div>
                  <div class="w3-half">
                    <label><b>Purpose for which material is sent out</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="purpose" required>
                  </div>
                </fieldset>
                <fieldset class="w3-light-grey w3-margin-top">
                  <legend class="w3-text-red"><b>Receiving Officer</b></legend>
                  <div class="w3-half">
                    <label><b>Name</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="receive_officer_name" required="required">
                  </div>
                  <div class="w3-half">
                    <label><b>Position</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="receive_officer_pos" required="required">
                  </div>
                </fieldset>
              <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <div>
                  
                </div>
                <div class="w3-right">
                  <span id="alert" class="w3-text-red w3-padding"></span>
                  <button class="w3-button " type="submit" name="p_token" value="dispatch"><b>Submit For Approval</b></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div> 
         <!-- current stock-->
      <div id="current-modal" class="tab" style="display: none;">
        <div class="w3-border w3-modal-content w3-round w3-margin-bottom" style="margin-top: 30px;">
          <span id="p-close-btn" onclick="hideElement('current-modal')" class="fa fa-times w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close"></span>
          <div class="w3-center"><br>
             <h3 class="w3-text-red">Current Stock Levels</h3>
          </div>
          <div class="w3-responsive">
            <table class="w3-table-all">
              <thead>
                <tr class="w3-grey w3-hover-light-grey">
                  <th>#</th>
                  <th>Name of Material</th>
                  <th>Quantity Available</th>
                  <th>Unit of Measure</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($matObject->get() as $material): $matNum++;?>
                <tr>
                  <td><?php echo $matNum;?></td>
                  <td><?php echo $material->name;?></td>
                  <td><?php echo $material->quantity;?></td>
                  <td><?php echo $material->unit;?></td>
                  <td class="w3-text-indigo"><button class="w3-button" title="make changes" onclick="<?php echo "showElement('edit-stock-modal-".$matNum."')";?>"><i class="fa fa-pencil w3-text-orange"></i>&nbsp;Edit</button><button class=" delete w3-button" title="delete record" value="<?php echo $material->id;?>"><i class="fa fa-trash w3-text-red"></i>&nbsp;Delete</button>
                  </td>
                </tr>
                         <!-- Stock editing dialog box -->
                 <div id="edit-stock-modal-<?php echo $matNum;?>" class="w3-modal">
                  <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round" style="max-width:600px">
                    <header class="w3-container w3-blue"> 
                      <span onclick="<?php echo "hideElement('edit-stock-modal-".$matNum."')";?>" 
                      class="fa fa-times w3-button w3-hover-red w3-display-topright w3-xlarge"></span>
                      <h3><i class="fa fa-pencil w3-text-orange"></i>&nbsp; Editing <span class="fa fa-arrow-right"></span><span class="w3-text-orange"><?php echo $material->name;?></span></h3>
                    </header>
                    <form action="action_page.php" method="post" >
                      <div class="w3-container w3-margin-left w3-padding">
                        <input type="hidden" name="mat_id" value="<?php echo $material->id;?>">
                        <label><b>Name of Material<span class=" w3-text-red" title="This field is required">*</span></b></label><br>
                        <input type="text" name="name" value="<?php echo $material->name;?>" class="w3-input w3-margin-bottom w3-border" required><br>
                        <label><b>Quantity Available<span class="w3-text-red" title="This field is required">*</span></b></label><br>
                        <input type="text" name="quantity" value="<?php echo $material->quantity;?>" class="w3-input w3-margin-bottom w3-border numberonly" required><br>
                        <label><b>Unit of Measurement</b></label><br>
                        <input type="text" name="unit" value="<?php echo $material->unit;?>" class="w3-input w3-margin-bottom w3-border">
                      </div>
                      <footer class="w3-container w3-light-grey">
                       <div class="w3-right">
                        <span class="my-button w3-button" onclick="<?php echo "hideElement('edit-stock-modal-".$matNum."')";?>"><i class="fa fa-times w3-text-red"></i>&nbsp;<b>Cancel</b></span>
                        <button type="submit" name="p_token" value="update_stock" class="w3-button"><i class="fa fa-save w3-text-red"></i>&nbsp;<b>Save Changes</b></button>
                       </div>
                      </footer>
                    </form>
                  </div>
                </div>
               <?php endforeach;?>
              </tbody>
            </table>
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
     <!-- <source src="audio/mouseclick2.mp3" type="audio/mpeg">       -->               
</audio>
<audio id="failed">
     <!-- <source src="audio/bell.mp3" type="audio/mpeg"> -->                   
</audio>

<script src="js/jquery.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/project_stock.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>

//materialExist();
  //background properties manipulation
$(document).on('click', '#tabs', function(){
  $('.stock-content').css({"background":"white"});
  
})
$(document).on('click', '#p-close-btn', function(){
  /*$('.stock-content').css({"background-image":"url(images/background1.jpg)",
        "background-size":"100%","background-repeat":"no-repeat"
     });*/
    $('.stock-content').css({"background":"-webkit-linear-gradient(to right, #4ca1af,#c4e0e5)","background":"linear-gradient(to right, #4ca1af,#c4e0e5)"
     });
})


$(document).click(function() {
  // toggle select button text for new materials
  var checkedRows = $('#add_form :checked').length;
  if(checkedRows == 5) {
     $('#check').html('<b>Uncheck All</b>')
     $('#add_form :text').attr('required', 'required')
  } else {
    $('#check').html('<b>Select All</b>');
    $('#add_form :text').attr('required', null)
  }

  // toggle select button text for dispatched materials
  var loadedMat = $('#dispatch_form :checkbox').length;
  var selectedMat = $('#dispatch_form :checked').length;
  //deduct 1 from total checked since the select element is included
  if((selectedMat-1) == loadedMat) {
     $('#check2').html('<b>Uncheck All</b>')
  } else {
    $('#check2').html('<b>Select All</b>');
  }
})

</script>

</body>
</html>

