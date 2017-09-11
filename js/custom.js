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
  }
  document.getElementById(id).style.display="block";
}

function hideElement(id) {
  document.getElementById(id).style.display="none";
}

function updateProject(id, token) {
  

   $.post('action_page.php', {p_token:token, projectId:id}, function(data){
      
      
   })
 }



 function setSession(token)
 {
   $.post("action_page.php", {p_token:token}, function(data){
      if(token=='print_session') {
          window.location = "show_project.php";
      }
   })
 }


 function loadElement(id, token)
 {
   $("#"+id).load("action_page.php?p_token="+token);


 }

 function createListBox()
 {
    var counter;
    var listbox = document.getElementById("listbox1");
    for (counter = 100; counter < 500; counter += 50) {
    listbox.options[listbox.length] = 
    new Option(counter + " - " + (counter+49));
   }
 }



function toggleFormRow(formId, state='')
{
  var formElement = document.getElementById(formId);
    var numMaterials = formElement.COUNTER.length;
    //iterate through form elements
    for(var i = 5; i<numMaterials; i++) {
          var fieldRow = document.getElementById('field_row_'+i);
          if(state ==='add_row') {
              if(fieldRow.style.display == 'none') {
                  fieldRow.style.display = 'block';
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


function checkRow(formId)
{
  var formElement = document.getElementById(formId);
  var numMaterials = formElement.COUNTER.length;
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


 function validateForm(formId)
 {
    var formElement = document.getElementById(formId);
    var numMaterials = formElement.COUNTER.length;
    //iterate through form elements
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
        setTimeout(function(){
           alertBox.innerHTML = '';
        }, 6000);
      return false;//don't allow submission
    } else {
              var textStr = (fieldsFilled==1)?'material':'materials';
              var response = confirm('You are about to submit '+ fieldsFilled +' '+ textStr +' for approval');
              if(response) {
                formElement['total_rows'].value = fieldsFilled;
                alert(formElement['total_rows'].value);
                return true;// allow submission
              } else {
                return false;//don't allow submission
              }
    }
    
 }


