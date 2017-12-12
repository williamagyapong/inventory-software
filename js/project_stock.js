
// hide the process feedback messaging system by fading out
$("#msg-dialog").fadeOut(8000);//10 seconds later

/*
|=====================================================================
| set global variables for use in related functions
|=====================================================================
*/
var formElement = document.getElementById('mr_form');
var numMaterials = formElement['COUNTER'].length;

// hide 45 fields in the required materias section by default
$(document).ready(function(){
    toggleFormRow();

    //check availability of material
    $('.material').blur(function() {
       var materialName = $(this).val();
       var matObj = $(this);
       //make request to the database for checks and addition
       if(materialName =='') {
           //alert('Please enter a material name')//use custom dialog for this
           $('#alert_content').html('<b>Please enter a material name');
           showElement('alert-modal');
           //matObj.removeClass('material')
       } else {
            $.post("action_page.php", {p_token:'check_material', term:materialName}, function(res){
            if(res!=1) {
              var userRes = confirm('"'+materialName+'" does not exist. Please click OK to add or CANCEL otherwise','');
              if(userRes) {
                 $.post("action_page.php", {p_token:'auto_add_material', term:materialName},function(data){

                 });
              } else {
                  matObj.val('');
                  matObj.prop('autofocus', 'autofocus');
          
                  //break;
              }
            }
          })
       }
        
       
    })


//check whether material already exist
$('.new-material').blur(function() {
    var materialName = $(this).val();
       var matObject = $(this);
       //make request to the database for checks and addition
       if(materialName =='') {
           //alert('Please enter a material name')//use custom dialog for this
           $('#alert_content').html('<b>Please enter a material name');
           showElement('alert-modal');
           //matObj.removeClass('material')
       } else {
            $.post("action_page.php", {p_token:'check_material', term:materialName}, function(res){
            if(res==1) {
               //alert(materialName+' is already in stock.');
               $('#alert_content').html('<b>'+materialName+' is already in stock');
               showElement('alert-modal');
              
                 matObject.val('');
          }
        })
      }
})


// autocomplete functionality
$(function() {
    $('.material').autocomplete({
      source: 'search.php?mat_autocomplete'
    })
})

//load project materials for dispatch
$('#load_mat_btn').click(function() {
    var projectId = $('#dispatch_form :selected').val();
    $('#materials').load("action_page.php?load_mat_id="+projectId);
})
//handle material editing
$('.edit').click(function(){
    var matId = $(this).val();
    alert(matId)
})
//handle material deletion
$('.delete').click(function(){
    var matId = $(this).val();
    $.post("action_page.php", {p_token:'allow_delete',material_id:matId}, function(response) {
      if(response!=1) {
        //soundEffect('failed');
        showElement('delete-modal');

      } else{
        var userRes = confirm("Please click OK to delete selected record or CANCEL to abort");
        if(userRes) {
          $.post("action_page.php", {p_token:'delete_mat', material_id:matId}, function(response) {
           window.location = "stock.php";
        })
        }
        
      }
    })
  })

//registration validation
    $('#registration_form').submit(function(){
       var pManagerPhoneObject = $('#registration_form input[name="project_manager_phone"]');
       var adminPhoneObject = $('#registration_form input[name="stores_admin_phone"]');
       var pManagerPhone = pManagerPhoneObject.val();
       var adminPhone = adminPhoneObject.val();

        if((adminPhone[0] != 0) || (pManagerPhone[0] != 0)) {
          //ensure the phone number begins with a zero
          $('#alert_content').html('<b>Please enter a valid phone number</b>');
             showElement('alert-modal');
              if((adminPhone[0] != 0) || (pManagerPhone[0] == 0)) {
                  //adminPhoneObject.addClass('w3-red');
              } else if((adminPhone[0] == 0) || (pManagerPhone[0] != 0)) {
                  pManagerPhoneObject.addClass('w3-red');
              }
             
             return false;
        } 
        else
        {
            if((adminPhone.length != 10) && (pManagerPhone.length != 10)) {

             $('#alert_content').html('<b>Please enter a valid phone number</b>');
             showElement('alert-modal');
             adminPhoneObject.addClass('w3-red');
             pManagerPhoneObject.addClass('w3-red');
             return false;

          } else if((adminPhone.length == 10) && (pManagerPhone.length != 10)){

              $('#alert_content').html('<b>Please enter a valid phone number in the project manager field</b>');
             showElement('alert-modal');
             pManagerPhoneObject.addClass('w3-red');
             return false;

          } else if((adminPhone.length != 10) && (pManagerPhone.length == 10)){

              $('#alert_content').html('<b>Please enter a valid phone number in the stores administrator field</b>');
             showElement('alert-modal');
             adminPhoneObject.addClass('w3-red');
             return false;
          } else{
              return true;
          }
        }
        
    })
    
    //change background color to default after validation
    $('#registration_form input[name="project_manager_phone"]').focus(function(){
        $(this).removeClass('w3-red');
    })

    $('#registration_form input[name="stores_admin_phone"]').focus(function(){
        $(this).removeClass('w3-red');
    })


    

})//document ready function ends here
