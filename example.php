<!DOCTYPE html>
<html>
<head>
	<title>examples</title>
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
<body onload="moveball()" id="body">

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
</script>
<!-- <img src="images/world.icon" width="150" height="150" id="ball" class="ballstyle">
<div class="boxstyle">&nbsp;</div> -->

<div style="color:red"> class="color:mediumblue">="w3-dropdown-hover"="color:mediumblue">>
  <button style="color:red"> class="color:mediumblue">="w3-button"="color:mediumblue">>Hover Over Me!</button style="color:mediumblue">>
  <div style="color:red"> class="color:mediumblue">="w3-dropdown-content w3-bar-block w3-border"="color:mediumblue">>
    <a style="color:red"> href="color:mediumblue">="#" class="color:mediumblue">="w3-bar-item w3-button"="color:mediumblue">>Link 1</a style="color:mediumblue">>
    <a style="color:red"> href="color:mediumblue">="#" class="color:mediumblue">="w3-bar-item w3-button"="color:mediumblue">>Link 2</a style="color:mediumblue">>
    <a style="color:red"> href="color:mediumblue">="#" class="color:mediumblue">="w3-bar-item w3-button"="color:mediumblue">>Link 3</a style="color:mediumblue">>
  </div style="color:mediumblue">>
</div style="color:mediumblue">>

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
</script>
</body>
</html>