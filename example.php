<?php
 require_once 'core/init.php';
 $mat = new Material();
 //echo $mat->exist('roofingsheets');die();
 echo Input::get('checked')." ".Input::get('choice');
?>

<!DOCTYPE html>
<html>
<head>
	<title>examples</title>
    <link rel="stylesheet" type="text/css" href="css/table.css">
<style>
.ballstyle {
position: absolute;
top: 50px;
left: 100px;
}
.boxstyle {
position: absolute;
top: 50px;
left: 100px;
height: 250px;
width: 400px;
border: solid 1pt black;
}

  </style>


</head>
<body id="body">

  <input type="text" id="output" name="output">
 
<form accept="" method="post">
  <input type="checkbox" name="checked">
  <input type="checkbox" name="choice">
  <input type="submit" name="sent">
</form>
<div class="scrollingtable">
  <div>
    <div>
      <table>
        <caption>Top Caption</caption>
        <thead>
          <tr>
            <th><div label="Column 1"></div></th>
            <th><div label="Column 2"></div></th>
            <th><div label="Column 3"></div></th>
            <th>
              <!--Here's a more versatile way of doing a column label; unlike the
              custom label attribute used above, it's fully stylable, but requires 2
              identical copies of the label-->
              <div><div>Column 4</div><div>Column 4</div></div>
            </th>
            <th class="scrollbarhead"></th> <!--ALWAYS ADD THIS EXTRA CELL AT END OF HEADER ROW-->
          </tr>
        </thead>
        <tbody>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
          <tr><td>Lorem ipsum</td><td>Dolor</td><td>Sit</td><td>Amet consectetur</td></tr>
        </tbody>
      </table>
    </div>
    Faux bottom caption
  </div>
</div>
<!-- <div class="container-fluid" >
  <div class="row">
    <div class="col-md-4 col-mdoffset-4 wrapper">
      <div class="app-name"><span class="first-letter">N</span>apol's <span class="first-letter">M</span>aterial <span class="first-letter">I</span>nventory <span class="first-letter">S</span>oftware</div>
      <img src="images/administrator.ico" width="130" height="90" class="center-logo">
      <form action="index.php" method="post" role="form">
       <div class="form-group has-success has-feedback">
          <label class="control-label sr-only" for="inputGroupSuccess4"></label>
          <div class="input-group">
             <span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
            <input type="text" name= "username" value="<?php echo Input::get('username');?>" class="form-control name_input" placeholder ="Username" id="inputGroupSuccess4" autocomplete="off">
          </div>
          <span class="glyphicon glyphicon form-control-feedback glyphicon_ok" aria-hidden="true"></span>
          <span id="inputGroupSuccess4Status" class="sr-only">(success)</span>
       </div>
       <div class="form-group has-success has-feedback">
          <label class="control-label sr-only" for="inputGroupSuccess4">Input group with success</label>
          <div class="input-group">
             <span style="" class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
            <input type ="password" name = "password" value="<?php echo Input::get('password');?>" class="form-control name_input" placeholder ="Password" id="inputGroupSuccess4" aria-describedby="inputGroupSuccess4Status">
          </div>
          <span class="glyphicon glyphicon form-control-feedback glyphicon_ok" aria-hidden="true"></span>
          <span id="inputGroupSuccess4Status" class="sr-only">(success)</span>
         </div>
         <button type="submit" name="login" class="btn btn-primary btn-block sumit_button">Sign In</button>  
     </form> 
     <div class="error ">
      
     <?php
          // handle user login process
        if(Input::exist('login')) {
           
              $validate = new Validator();

              $validation = $validate->check($_POST, array(
                          'username' => array('required'=> true),
                          'password' => array('required'=> true)
                ));

              if($validation->passed()) {
                //log user in
                $user = new User();

                //$remember = (Input::get('remember')=='on')? true: false;
                $login = $user->login(Input::get('username'), Input::get('password'));
                if($login) {
                   Redirect::to('dashboard');
                  //header('Location: profile.php');
                } else {
                          echo "Sorry, invalid credentials. Please try again";
                }
              } else {
                foreach($validation->errors() as $error) {
                  echo '<li>'.$error.'</li>';
                }
                
              }
            }

      ?>
    </div>
    </div>
  </div>
</div> -->

<!--[if lte IE 9]><style>.scrollingtable > div > div > table {margin-right: 17px;}</style><![endif]-->
 
  <script type="text/javascript">
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
//document.write("Mozilla based browser");
var body = document.getElementById('body');
	//body.style.backgroundColor = "#000";
	//alert('sorry, your browser does not support the application')
// Keep your gecko specific URL here.
}else if (ie){
	var body = document.getElementById('body');
	body.style.backgroundColor = "#000";
	alert('sorry, your browser does not support the application')
//document.write("IE based browser");
// Keep your IE specific URL here.
}else if (netscape){
document.write("Netscape based browser");
// Keep your Netscape specific URL here.
}else{
document.write("Unknown browser");

//-->
}
//document.write("<br /> Browser version info : " + version );

//alert($("span[id*='close']").html());
//$("table tr:first").css({"background":"red"});
//$("table").before("<p>here is a new paragraph</p>");
//$("table").after("<p>here is a new paragraph</p>");
$(document).keypress(function(e) {
    var keyPressed = (e.which);
    keyPressed = String.fromCharCode(keyPressed);//convert keycode to character string
    $("input[type='text']#output").val(keyPressed);
})

$(document).mouseover(function(e) {
    $("input[type='text']#output").val(e.pageX);//get the vertical position
})

</script>
<!-- <img src="images/world.icon" width="150" height="150" id="ball" class="ballstyle">
<div class="boxstyle">&nbsp;</div> -->




<canvas id="myChart" width="300" height="150"></canvas>
<script type="text/javascript" src="js/Chart.js"></script>
<script>
	// Set the starting coordinates
var mytop, myleft;
mytop = 50;
myleft = 100;
function moveball() {
img = document.getElementById("ball");
mytop += 10;
myleft += 2;
if (mytop > 230) mytop = 50;
if (myleft > 430) myleft = 100;
img.style.top = mytop;
img.style.left = myleft;
setTimeout("moveball()", 100);
}
</script>


<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


/*function requestFullScreen(element) {
    // Supports most browsers and their versions.
    var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;

    if (requestMethod) { // Native full screen.
        requestMethod.call(element);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
}

var elem = document.body; // Make the body go full screen.
requestFullScreen(elem);*/
</script>
</body>
</html>