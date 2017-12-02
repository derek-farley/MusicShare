<?php
	#declare(strict_types=1);
	require_once "support.php";
	require_once "meekrodb.2.3.class.php";

	includeConstants();
	dbConfig(); # configure meekrodb for musicshare db

	$provided_user = "";
	$provided_password = "";
	if (isset($_POST["loginbutton"])) {
		$provided_user = $_POST["username"];
		$provided_password = $_POST["pwd"];

		$user = DB::queryFirstRow("SELECT * from ".UserTable::TABLE_NAME." where ".UserTable::USERNAME_FIELD." = %s",
			$provided_user); # check for user in db
		if ($user !== null) {
			if (password_verify($provided_password, $user[UserTable::PASSWORD_FIELD])) {
				# verify password matches hashed password in db for user
				session_start();
				$_SESSION["user"] = $provided_user;
				# create session variable to be accessed in timeline.php to create user object and display timeline
				header('Location: timeline.php');
			}
		}
	}


	$login = <<<EOBODY
		<!doctype html>
	<html> 
	    <head>
	        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                     <!-- scale application to window space available (1 ==> 100%) -->
                     <meta name="viewport" content="width=device-width, initial-scale=1">
        
                     <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
                     <link rel="stylesheet" href="logincss.css" />


	                    <title>title</title>
	    </head>

	    <body>
	        

		<script src="login.js"></script>
		<p>
		<form action= "login.php" method="post">
			<div class="container">
              <div class="row text-center">

			<h1><strong>Music Share<Strong></h1>
			    </div>
			     <div class="row ">
                <div class="col-xs-4 col-md-2 " >
                  <img src="Tambourine.jpg" alt="college image"  width="250" height= "250" class="img-circle">
                </div>
                <div class="col-xs-4 col-md-5 ">
                    
                </div>
                <div class="col-xs-4 col-md-5">
                    <img src="headphone.jpg" alt="college image"  width="250" height= "250" class="img-circle">
                </div>

                </div>

			    </div>


			<h2><strong>Login </strong></h2><br />
			<strong>Username: </strong><input type="text" id="username" value="$provided_user" name="username" required/>
			<table align="right">
			 <tr>
	 <td> <img src="images/taylor.jpg" alt="college image"  width="200" height= "100" class="img-rounded"></td>
    <td> <img src="images/katy.jpg" alt="college image"  width="200" height= "100" class="img-rounded"></td>
    <td><img src="images/weekend.jpg" alt="college image"  width="200" height= "100" class="img-rounded"></td>
  </tr>
  <tr>
	 <td> <img src="images/demi.jpg" alt="college image"  width="200" height= "100" class="img-rounded"></td>
    <td> <img src="images/usher.jpg" alt="college image"  width="200" height= "100" class="img-rounded"></td>
    <td><img src="images/justin.jpg" alt="college image"  width="200" height= "100" class="img-rounded"></td>
  </tr>


</table><br><br>

			<strong>Password: </strong><input type="password" id="pwd" value="$provided_password" name="pwd" required/><br /><br/>
			<input type="submit" class="button" value="Login" name="loginbutton" id="loginSubmit"/><br />
		</form>
		</p>
		<script src="bootstrap/jquery-3.2.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
     </body>
	</html>


	
		
EOBODY;

	if (isset($_POST["loginbutton"])) {
		$failMessage = "<p><strong>You have entered an invalid username or password. Please try again<br /></strong></p>";
		$login = $login.$failMessage;
	}

	$signup = <<<EOBODY
	
	
		<p>
		<h2><strong>Not a member? Sign up now!</strong></h2><br />
		<form action="signup/sign_up.php" method="post">
			<input type="submit" class="button" value="Sign Up" name="Signupbutton" /><br />
		</form>
		</p>

EOBODY;


	$page = generatePage($login.$signup);
	echo $page;
?>
