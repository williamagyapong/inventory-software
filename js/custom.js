 
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

function openTab(tabId) {
    var i;
    var x = document.getElementsByClassName("tab");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none"; 
    }
    
    document.getElementById(tabId).style.display = "block"; 
}

function openModal(id) {
    var x = document.getElementById(id);

    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}

function showElement(id) {
  document.getElementById(id).style.display="block";
}

function hideElement(id) {
  document.getElementById(id).style.display="none";
}