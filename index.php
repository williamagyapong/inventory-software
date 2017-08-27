<?php
 
 require_once 'core/init.php';
 
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/x-icon" href="images/logo2.png">
	<title>Home page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<style type="text/css">
    body{
      background: white;
      min-height: 500px;
      background-repeat: no-repeat;
      background-size: 100%;
    }
  
  .main{
    background-image: url(images/loginbg.jpg);
  }
  .wrap{
    min-height:450px;max-height:600px;
    margin-top: 150px;

  }
  .error{
    font-family: verdana;
    font-weight: bold;
    color: #ff0000;
    width: 100%;
    position: absolute;
    text-align: center;
    margin-top: 80PX;
  }
 
  </style>
</head>
<body>
<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <!-- <span class="w3-bar-item w3-center">BusinessRecords</span> -->
  <span class="w3-bar-item w3-right"><img src="images/logo2.png" width="65" height="30"><span><?php echo Config::get('config/app/name'); ?></span></span>
</div>
<div class="container-fluid" >
  <div class="row main">
    <div class=" error w3-padding">
      
      <!-- <span onclick="this.parentElement.style.display='none'" class="w3-button w3-display-topright w3-xxlarge">&times;</span> -->
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
                   Redirect::to('dashboard.php');
                  //header('Location: profile.php');
                } else {
                          echo "<h3>Sorry, invalid credentials!</h3>";
                }
              } else {
                foreach($validation->errors() as $error) {
                  echo '<li>'.$error.'</li>';
                }
                
              }
            }

      ?>
    </div>
   
    <div class="wrap">

   <form action="index.php" method="post" role="form">
     <fieldset class="loginfieldset">
    
          <br><br><br>
      <div class="form-group">
         <input type="text" name="username" placeholder="username" class="form-control text_input" required="required" autocomplete="off">
      </div>
    
      <div class="form-group">
        <input type="password" name="password" placeholder="password" class="form-control text_input" required ="required">
      </div>
    

      <div class="form-group">
        <input type="submit" name="login" value="Login" class="form-control text_input submit-btn2">
      </div>


    </fieldset>
  </form>
    </div>
    
  </div>
 
</div>


</body>
</html>

