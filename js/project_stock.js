
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
           alert('Please enter a material name')//use custom dialog for this
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
                  matObj.attr('autofocus', 'autofocus');
          
                  //break;
              }
            }
          })
       }
        
       
    })
})

//check whether material already exist
$('.new-material').blur(function() {
    var materialName = $(this).val();
       var matObject = $(this);
       //make request to the database for checks and addition
       if(materialName =='') {
           alert('Please enter a material name')//use custom dialog for this
           //matObj.removeClass('material')
       } else {
            $.post("action_page.php", {p_token:'check_material', term:materialName}, function(res){
            if(res==1) {
               alert(materialName+' is already in stock.');
              
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