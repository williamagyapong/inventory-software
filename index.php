<?php
 require_once 'core/init.php';

 if(Input::exist('login')) {
              $errorMsg = [];
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
                          $errorMsg[] = "Invalid credentials. Please try again";
                }
              } else {

                  $errorMsg[] = $validation->errors();
                /*foreach($validation->errors() as $error) {
                  echo '<li>'.$error.'</li>';
                }*/
                
              }
            }
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/x-icon" href="images/logo2.png">
	<title>Home page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="css/w3.css"> -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway"> -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<style type="text/css">
    body, html{
      padding: 0;
      margin: 0;
      height: 100%;
      /*background-size: 100%;*/
    }

  .container{
      background: #00BFFF;
      background-image: url(images/bgimg.jpg);
      width: 100%;
      height: 100%;
      background-position: center center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
      overflow: none;
  }
  
  .wrapper{
    /*position: absolute;*/
    height:550px;
    width: 350px;
    /*margin-top: 50px;*/
    padding: 15px;
    background: #f8f8f8;
    /*border-radius: 10px;*/
    

  }
  .wrapper2{
    height:400px;
    width: 350px;
    position: absolute;
    left: 50% ;
    margin-left: -175px;
    margin-top: 130px;
    padding: 15px;
    /*background: #f8f8f8;
    border:1px solid red;
    border-radius: 10px;*/
    

  }
  .footer{
    width: 100%;
    position: absolute;
    bottom: 0;
    text-align: center;

  }
  .logo{
    width: 150px;
    position: relative;
    left: 50%;
    text-align: center;
    margin-bottom: 47px;
    margin-left: -75px;
    background:#4ca1af;
    
    padding-top: 10px;
    padding-bottom: 10px;
    border-radius: 10px;
  }
  .controls{
    margin-left: 50px;
    margin-bottom: 70px;
  }
  #login-alert{
    color: #ff0000;
    font-size: 1.2em;
    height: 50px;
    width: 100%;
   /* border:1px solid black;*/
  }
  .error{
    font-family: verdana;
    font-weight: bold;
    color: #ff0000;
    position: relative;
    padding: 10px;
    background: 
    margin-top: 150PX;
  }
  #thisusername{
    font-size: 1.2em;
    font-weight: bolder;
    text-align: center;
    color: #fff;
  }
  @media(max-width: 480px) {
  .container{
  margin: 10px auto;
}
}


@media(min-width: 480px) {
.container{
  margin: -50px auto;
}
}


@media(min-width: 1200px) {
  .container{
  margin: -10px auto;
}
}


form{
  font-size: 15px;
  font-family: arial;
}
.center-logo{
  /*text-align: center;
  margin-bottom: 4px;
  margin-left: 95px;*/
  padding: 5px;
  background:#4ca1af;
  background:-webkit-linear-gradient(to right, #4ca1af,#c4e0e5);
  background:linear-gradient(to right, #4ca1af,#c4e0e5);
  border-radius: 5px;
}
.first-letter{
  font-family: verdana;
  font-weight: bolder;
  font-size: 18px;
  color: #0000ff;
}
.text-field{
  padding-left: 10px;
  border-radius: 5px;
}
.app-name{
  font-weight: bold;
  text-align: center;
  font-size: 1.5em;
  color: #ffaaaa;
}
.version{
  float: right;

  padding-right: 30px;
}
.name_input{
  height: 50px;
  font-size:20px;
}

.glyphicon_ok{
  margin-top: 10px;

}

.sumit_button{
  height: 50px;
  font-size: 17px;
}
 
  </style>
</head>
<body>
<!-- Top container -->
 <div class="container">
   <div class="wrapper2">
   <div class="logo">
     <!-- <img src="images/administrator.ico" width="130" height="90" class="center-logo"> -->
     <img src="images/logo2.png" width="130" height="90" class="center-logo"> 
   </div>
   <p id="thisusername"></p>
   <div class="controls">
     <form action="index.php" method="post">
       <div id="start">
         <input id="username" type="text" name="username" value="<?php echo Input::get('username');?>" placeholder="Username" autocomplete="off" autofocus="autofocus" required="required" class="text-field">
       <span id="next" tabindex="0" class="my-button fa fa-arrow-right"></span>
       </div>
       <div style="display: none;" id="final">
         <input id="password" type="password" name="password" value="<?php echo Input::get('password');?>" placeholder="Password" required="required" class="text-field">
         <button id="login" type="submit" name="login" class="my-button fa fa-arrow-right"></button>
       </div>
       <p id="login-alert">
        <?php if(isset($errorMsg)) 
         { 
           foreach($errorMsg as $error) {
             echo $error.'<br>';
           }
         }
        ?>
       </p>
     </form>
   </div>
  </div>
  <div class="footer">
    <p class="app-name">Napol's Material Inventory Software</p>
   <p class="version">Version 1.0</p>
  </div>
 </div>
<script src="js/jquery.js"></script>
<script src="js/custom.js"></script>

<script type="text/javascript">
  // login fields toggle code support
  $(document).ready(function(){
     $('#next').click(function() {
       var username = $('#username').val();
       if(username=='') {
          $('#login-alert').html("<b>Please enter username</b>");
          setTimeout(function(){
             $('#login-alert').html('');
          }, 5000)
       } else {
          $('#start').hide(function() {
             $('#final').show();
             $('#thisusername').html($('#username').val())
          });
       }
     })

     //bind enter key press to this element
     $('#next').keypress(function(e) {
        if(e.which == 13) {
          var username = $('#username').val();
           if(username=='') {
              $('#login-alert').html("<b>Please enter username</b>");
              setTimeout(function(){
                 $('#login-alert').html('');
              }, 5000)
           } else {
              $('#start').hide(function() {
                 $('#final').show();
                 $('#thisusername').html($('#username').val())
              });
           }
        }
     })

     
    setTimeout(function(){
         $('#login-alert').html('');
      }, 5000);
     
  })
</script>
</body>
</html>

