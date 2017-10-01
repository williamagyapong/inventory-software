 //determine user's browser
 <!--
var userAgent = navigator.userAgent;
var opera = (userAgent.indexOf('Opera') != -1);
var ie = (userAgent.indexOf('MSIE') != -1);
var gecko = (userAgent.indexOf('Gecko') != -1);
var netscape = (userAgent.indexOf('Mozilla') != -1);
var version = navigator.appVersion;
if (opera){
document.write("Opera based browser");
// Keep your opera specific URL here.
}else if (gecko){
// Keep your gecko specific URL here.
}else if (ie){
  var body = document.getElementById('body');
  body.style.display = "none";
  alert('sorry, the software is not supported in this browser.\
         Consider using either Chrome or Mozilla firefox.')
//document.write("IE based browser");
// Keep your IE specific URL here.
}else if (netscape){
var body = document.getElementById('body');
  body.style.backgroundColor = "#000";
  alert('sorry, the software is not supported in this browser.<br>\
         Consider using either Chrome or Mozilla firefox.')
// Keep your Netscape specific URL here.
}else{

 document.write("Unknown browser");
 var body = document.getElementById('body');
  body.style.backgroundColor = "#000";
  alert('sorry, the software is not supported in this browser.<br>\
         Consider using Chrome or Mozilla firefox.')
//-->
}
 
//prevent user from accessing the right click menu
window.oncontextmenu = function() {
  //return false;
}


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


 function isNumber(name) {
 	var fieldName = name;
 	var data = document.myForm.fieldName.value;
 	     alert(data);
         if(!isNaN(data)) {
            return true;
         } else{
            alert('Invalid entry');
            document.myForm.fieldName.focus();
            return false;
         }
       }
     
  function deleteAlert()
  {
  	 response = confirm("The selected record will be deleted !");
  	 if(response) {
  	 	return true;
  	 } else {
  	 	return false;
  	 }
  }

function openTab(tabId, tabClass='tabs') {
    var i;
    var x = document.getElementsByClassName(tabClass);
    var y = document.getElementById(tabId); //element to show
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none"; 
    }
    
   if( y.style.display == "block") {
       y.style.display = "none";
   } else {
      y.style.display = "block";
   }
  
  /*$('#tabs').click(function(){
      $('#'+tabId).toggle();
  })*/
  //scrollToBottom();
}


function scrollToBottom(){
    $("html, body").animate({ 
      scrollTop: $(document).height()-($(window).height()+200) 
    },1000);
    //alert($(document).height()+":"+ $(window).height());
  }


function changeBgC(id, color='blue') {
   document.getElementById(id).style.backgroundColor = color;

}

function openModal(id) {
    var x = document.getElementById(id);

    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}



function showElement(id, token='') {
  if(id == 'notsatisfied-modal') {
      $('#nspId').val(token);
  } else if(id == 'notsatisfied-bill-modal') {
      $('#nSBilledProjectId').val(token);
  }
  document.getElementById(id).style.display="block";
}


/*
* Hide html elements with associated id
*/

function hideElement(id) {
  document.getElementById(id).style.display="none";
}


/*
* update project details on request via ajax 
*/

function updateProject(id, token, field='status') {
  
   $.post('action_page.php', {p_token:token, projectId:id, field_name:field}, function(data){
      window.location = "dashboard.php";
   })
 }


/*
* Set session variables for use
*/

 function setSession(token)
 {
   $.post("action_page.php", {p_token:token}, function(data){
      if(token=='print_project_session') {
          window.location = "show.php";
      }
   })
 }


/*
* Populate sections of pages with content through ajax request
*/
 function loadElement(id, token)
 {
   $("#"+id).load("action_page.php?p_token="+token);

 }


/*
* Bind sound effect to user events
*/
function soundEffect(audioElement)
{
   var audioFile = document.getElementById(audioElement);
   audioFile.play();
}



/*
* Responsible for the add row and remove row functionality
* makes use of the global variables
*/
function toggleFormRow(state='')
{
    
    //iterate through form elements
    for(var i = 5; i<numMaterials; i++) {
          var fieldRow = document.getElementById('field_row_'+i);
          if(state ==='add_row') {
              if(fieldRow.style.display == 'none') {
                  fieldRow.style.display = 'table-row';
                  break;
              }
          } else if(state === 'remove_row'){
                    if(fieldRow.style.display == 'none') {
                    var x = i-1;//shift focus to one row above
                    if(formElement['checked_'+x].checked) {
                      var response =confirm('You will lose data by removing this row');
                      if(response) {
                          //remove row
                          document.getElementById('field_row_'+x).style.display='none';
                          //empty all input elements
                          formElement['checked_'+x].checked = false;
                          formElement['name_'+x].value ='';
                          formElement['quantity_'+x].value ='';
                          formElement['quantity_available_usable_'+x].value ='';
                          formElement['quantity_to_purchase_'+x].value ='';
                      }
                    } else {
                      //remove row
                      document.getElementById('field_row_'+x).style.display='none';
                      //empty all input elements
                      formElement['checked_'+x].checked = false;
                      formElement['name_'+x].value ='';
                      formElement['quantity_'+x].value ='';
                      formElement['quantity_available_usable_'+x].value ='';
                      formElement['quantity_to_purchase_'+x].value ='';
                    }
                    break;
              }
          }else {

                  fieldRow.style.display = 'none';//hide 45 rows by default
          }
            
    }
}

/*
* automatically mark every entered material for tracking purposes
* uses the global variables
*/
function checkRow()
{
  //iterate through form elements
  for(var i = 0; i<numMaterials; i++) {
      if((formElement['name_'+i].value !='')&&
        (formElement['quantity_'+i].value !='')&&
        (formElement['quantity_available_usable_'+i].value !='')&&
        (formElement['quantity_to_purchase_'+i].value !='')) {

         formElement['checked_'+i].checked = true;
      }
  }
}

function clearAlert(htmlElement)
{
  setTimeout(function() {
     htmlElement.innerHTML = '';
  }, 6000);
}

/*
* validate required materials bill form before submission is allowed
* makes use of the global variables
*/
 function validateForm()
 {
    
    var fieldsFilled = 0;
 
    if(formElement['project_id'].value =='') {
        alert("Please select a project");
        return false;//don't allow submission
    }

    for(var i = 0; i<numMaterials; i++) {
        if((formElement['name_'+i].value !='')&&
          (formElement['quantity_'+i].value !='')&&
          (formElement['quantity_available_usable_'+i].value !='')&&
          (formElement['quantity_to_purchase_'+i].value !='')) {
           
          fieldsFilled++;
        }
    }

    if(fieldsFilled == 0) {
        var alertBox = document.getElementById('alert');
        alertBox.innerHTML = '<b>Please enter materials!</b>';
        clearAlert(alertBox);
      return false;//don't allow submission
    } else {
              var textStr = (fieldsFilled==1)?'material':'materials';
              var response = confirm('You are about to submit '+ fieldsFilled +' '+ textStr +' for approval');
              if(response) {
                formElement['total_rows'].value = fieldsFilled;
                return true;// allow submission
              } else {
                return false;//don't allow submission
              }
    }
    
 }

/*
* validate new materials to be added to stock
* 
*/
function validateNewMatForm()
{ 
  var formObj = document.getElementById('add_form');
  var alertBox = document.getElementById('add-alert');
  for(var i = 0; i<5; i++)
  {
    var tRow = document.getElementById('field_row_'+i);
    var name = formObj['name_'+i];
    var quantity = formObj['quantity_'+i];
    var checkBox = formObj['checked_'+i];
    var unit = formObj['unit_'+i].value;
    var rows = 0;
    // validate fields
    if(checkBox.checked && (name.value=='' || quantity.value=='')) {
      alertBox.innerHTML = "<b>Please fill out all selected row fields</b>";
      clearAlert(alertBox);
      return false;
    } else if(!checkBox.checked && (name.value!='' || quantity.value!='')) {
      alertBox.innerHTML = "<b>Please select all filled rows</b>";
      clearAlert(alertBox);
      return false;
    }
    else if(!checkBox.checked) {
      alertBox.innerHTML = "<b>Please select a row and fill out details</b>";
      clearAlert(alertBox);
      return false;
    } 
    // get total field rows
    if(checkBox.checked && (name.value!='') && (quantity.value=!'')) {
       rows++;
    }

    if(rows !=0) {
      return true;
    }
    //alert(rows);
  //return false;
    }
}


function materialExist()
 {
    
    for(var i = 0; i<numMaterials; i++) {
      var materialName = formElement['name_'+i].value;
      
      if(materialName !=='') {
        var materialNameField = formElement['name_'+i];
        
      }

    }
    
 }



/*
* add non existing materials to stock while user fills materials bill
*/
 function autoAddMaterial()
 {
    
    for(var i = 0; i<numMaterials; i++) {
      var materialName = formElement['name_'+i].value;
      if(materialName !=='') {
        //make request to the database for checks and addition
        $.post("action_page.php", {p_token:'check_material', term:materialName}, function(res){
          if(res!=1) {
            var userRes = confirm('The material, '+ materialName + '\
              does not exist. Click OK to add it or cancel otherwise.');
            if(userRes) {
              $.post("action_page.php", {p_token:'auto_add_material', term:materialName}, function(){

              })
            } else {
              break;
            }
          }
        })
      }

    }
    
 }


 /*
 * auto fill the quantity available and quantity to purchase 
 */

 function autoFill()
 {
    var materialName = '';
    for(var i = 0; i < numMaterials; i++) {
      materialName = formElement['name_'+i].value;
      if(materialName !=='') {
        var qtyNeeded = formElement['quantity_'+i].value;
        var qtyAvailableField = formElement['quantity_available_usable_'+i];
        var qtyToPurchField  = formElement['quantity_to_purchase_'+i];
        //make request to the database for checks and creation
        $.getJSON("action_page.php", {p_token:'get_material', term:materialName}, function(data){
          var qtyToPurch = 0;
          if(qtyNeeded > data.quantity_available) {
              qtyToPurch = qtyNeeded - data.quantity_available;
          }
          //populate various fields
          qtyAvailableField.value = data.quantity_available+' '+data.unit;
          qtyToPurchField.value = qtyToPurch+' '+data.unit;
          
        }).error(function(){
          console.log('sorry, an error occurred')
        })
      }

    }


 }


 function checkAll(id='check',formId='add_form')
 {
   var btn= document.getElementById(id);
   var checkBox = $("#"+formId+" input[type='checkbox']");
   //alert(btn.innerHTML)
   if(btn.innerHTML == '<b>Select All</b>') {
      checkBox.prop('checked', true);
      btn.innerHTML = '<b>Uncheck All</b>'

   } else if(btn.innerHTML == '<b>Uncheck All</b>') {
      checkBox.prop('checked', false);
     btn.innerHTML = '<b>Select All</b>'
   }
 }

