 //determine user's browser
 //<!--
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


//make form input accept only number values
 jQuery('.numberonly').keyup(function () { 
    if(this.value != this.value.replace(/[^0-9\.]/g,'')) {
      this.value = this.value.replace(/[^0-9\.]/g,'')
    }
    //this.value = this.value.replace(/[^0-9\.]/g,'');
});
 
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
   //audioFile.play();
}



/*
* Responsible for the add row and remove row functionality
* makes use of the global variables
*/
function toggleFormRow(state='')
{
    
    // iterate through form elements
    // numMaterials is a global variable
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
    var duplicatedMat = 0;
 
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
        // check for material duplication
        for(var x=0; x<numMaterials; x++) {
            if(i == x) {
              continue //skip the very material in question
            }
            //console.log(x)
            if((formElement['name_'+i].value)==(formElement['name_'+x].value)) {
                duplicatedMat++;
            }

        }
        }
       
    }

    //pass duplication of materials alert
    console.log(formElement['project_id'].value)
    if(duplicatedMat>0) {
       var alertBox = document.getElementById('alert');
        alertBox.innerHTML = '<b>Please remove duplicated materials!</b>';
        clearAlert(alertBox);
      return false;//don't allow submission
    }

    if(fieldsFilled == 0) {
        var alertBox = document.getElementById('alert');
        alertBox.innerHTML = '<b>Please enter materials!</b>';
        clearAlert(alertBox);
      return false;//don't allow submission
    }  else {
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
  var filledRows = 0;
  var selectedNotFilled = 0;
  var filledNotSelected = 0;
  for(var i = 0; i<5; i++)
  {
    var name = formObj['name_'+i];
    var quantity = formObj['quantity_'+i];
    var checkBox = formObj['checked_'+i];
    // validate fields
    if(checkBox.checked && (name.value=='' || quantity.value=='')) {
      selectedNotFilled++;
      
    }
   if(!checkBox.checked && (name.value!='' || quantity.value!='')) {
      filledNotSelected++;
      
    }
   if(checkBox.checked && (name.value!='') && (quantity.value=!'')) {
       filledRows++;
    }

  }
    //console.log(filledRows)
    if(selectedNotFilled>0) {
      alertBox.innerHTML = "<b>Please fill out all selected row fields or uncheck rows</b>";
      clearAlert(alertBox);
      return false;
    }
    
    if(filledNotSelected>0) {
      alertBox.innerHTML = "<b>Please select all filled rows or uncheck and clear contents</b>";
      clearAlert(alertBox);
      return false;
    }

    if(filledRows==0) {
        alertBox.innerHTML = "<b>Please select a row and fill out details</b>";
        clearAlert(alertBox);
        return false;
    } else {
              var textStr = (filledRows==1)?'material':'materials';
              var response = confirm('You are about to add '+ filledRows +' new '+ textStr +' to stocks');
              if(response) {
                  return true;
              } else {
                  return false;
              }
    }
    
}


function materialExist()
 {
  
    for(var i = 0; i<numMaterials; i++) {
      var materialName = formElement['name_'+i];
      if(formElement['name_'+i].value !=='') {
        //make request to the database for checks and addition
        console.log('something')
        return false;
        $.post("action_page.php", {p_token:'check_material', term:materialName.value}, function(res){
          console.log(materialName.value)
          if(res!=1) {
            alert( materialName.value + 'already exists in stock.');
            
          }
        })
      }

    }
    
    
 }



/*
* add non existing materials to stock while user fills out materials bill
* numMaterials and formElement are global variable
*/
 function autoAddMaterial()
 {
    
    for(var i = 0; i<numMaterials; i++) {
      var materialName = formElement['name_'+i].value;
      if((materialName !=='')&&(formElement['checked_'+i].checked==false)) {
        //make request to the database for checks and addition
        $.post("action_page.php", {p_token:'check_material', term:materialName}, function(res){
          console.log(materialName)
          if(res!=1) {
            var userRes = confirm('The material, '+ materialName + 'does not exist. Click OK to add it or cancel otherwise.');
            if(userRes) {
              $.post("action_page.php", {p_token:'auto_add_material', term:materialName}, function(){

              })
            } else {
            
            }
          }
        })
      }

    }
    
 }


 /*
 * auto fill the quantity available and quantity to purchase 
 * numMaterials is a globalavariable
 | challenges: 
 | 1. dificulty in uniquely referencing the current row being worked on by the user 
 | solution: modify the condition
 | 2. excess of material needed over material available criteria not working as required
 |  solution: force the data type to integer value using the parseInt function
 | 3. duplication of materials
 */

 function autoFill()
 {
    var materialName = '';
    for(var i = 0; i < numMaterials; i++) {
      materialName = formElement['name_'+i].value;
      if((materialName !=='') && (formElement['checked_'+i].checked ==false)) {
        //initialize relevant variables
        var qtyNeeded = formElement['quantity_'+i].value;
        var qtyAvailableField = formElement['quantity_available_usable_'+i];
        var qtyToPurchField  = formElement['quantity_to_purchase_'+i];
        //make request to the database for checks and creation
        $.getJSON("action_page.php", {p_token:'get_material', term:materialName}, function(data){
          var qtyToPurch = 0;
          var qtyAvailable = parseInt(data.quantity_available);
          //check for excess of material needed
          if(qtyNeeded>qtyAvailable) {
              qtyToPurch = qtyNeeded - qtyAvailable;
          }
          //populate various fields
          qtyAvailableField.value = data.quantity_available+' '+data.unit;
          qtyToPurchField.value = qtyToPurch+' '+data.unit;
          
        }).error(function(){
          console.log('sorry, an autofill error occurred')
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

