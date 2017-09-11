<?php
 
 require_once 'core/init.php';
 
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
	<!-- <link rel="stylesheet" type="text/css" href="css/main.css"> -->

	<style type="text/css">
    body{
      background-image: url(images/bgimg.jpg);
      background-repeat: no-repeat;
      background-size: 100%;
    }
  
  .wrapper{
    /*position: absolute;*/
    height:350px;
    margin-top: 150px;
    padding: 15px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 5px;

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
  text-align: center;
  margin-bottom: 4px;
  margin-left: 95px;
}
.first-letter{
  font-family: verdana;
  font-weight: bolder;
  font-size: 18px;
  color: #0000ff;
}
.app-name{
  font-weight: bold;
  margin-bottom: 10px;
  text-align: center;
}
.name_input{
  height: 60px;
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
<div class="container" >
  <div class="row">
    <div class="error w3-padding">
      
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
    <div class="col-md-4 col-mdoffset-4 wrapper">
      <img src="images/logo2.png" width="130" height="90" class="center-logo">
      <div class="app-name"><span class="first-letter">N</span>apol's <span class="first-letter">M</span>aterial <span class="first-letter">I</span>nventory <span class="first-letter">S</span>oftware</div>
      <form action="index.php" method="post" role="form">
       <div class="form-group has-success has-feedback">
          <label class="control-label sr-only" for="inputGroupSuccess4"></label>
          <div class="input-group">
             <span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
            <input type="text" name= "username" class="form-control name_input" placeholder ="Username" id="inputGroupSuccess4" autocomplete="off">
          </div>
          <span class="glyphicon glyphicon form-control-feedback glyphicon_ok" aria-hidden="true"></span>
          <span id="inputGroupSuccess4Status" class="sr-only">(success)</span>
       </div>
       <div class="form-group has-success has-feedback">
          <label class="control-label sr-only" for="inputGroupSuccess4">Input group with success</label>
          <div class="input-group">
             <span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
            <input type ="password" name = "password" class="form-control name_input" placeholder ="Password" id="inputGroupSuccess4" aria-describedby="inputGroupSuccess4Status">
          </div>
          <span class="glyphicon glyphicon form-control-feedback glyphicon_ok" aria-hidden="true"></span>
          <span id="inputGroupSuccess4Status" class="sr-only">(success)</span>
         </div>
         <button type="submit" name="login" class="btn btn-primary btn-block sumit_button">Sign In</button>  
     </form>
    </div>
  </div>
</div>

<script src="js/custom.js"></script>
</body>
</html>

