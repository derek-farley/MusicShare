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
                     <link rel="stylesheet" href="signup/color.css" />


	                    <title>MusicShare</title>
	    </head>

	    <body>
	        

		<script src="login.js"></script>
		
		<div class="container">
              <div class="row text-center headers">
              	<div class="well">
              		<h1><strong>MusicShare<Strong></h1>
              	</div>
			  </div>
			  <div class="row">
              	<div class="col-xs-4 col-md-4" align="center">
                	<img src="images/cole.jpg" alt="college image" class="img-rounded">
                </div>
                <div class="col-xs-4 col-md-4" align="center">
                	<img src="images/headphone.jpg" alt="college image" width="250" height="250" class="img-circle"><br><br>
				</div>
                <div class="col-xs-4 col-md-4" align="center">
                    <img src="images/pinkfloyd.jpg" alt="college image" class="img-rounded">
                </div>
              </div>
              <div class="row">
              	<div class="col-xs-4 col-md-4 " align="center">
                	<img src="images/weekend.jpg" alt="college image" class="img-rounded">
                </div>
                <div class="col-xs-4 col-md-4" align="center">
                	<div class="well" id="loginDiv">
						<form action= "login.php" method="post">
							<h2><strong>Login </strong></h2><br />
							<strong>Username: </strong><input type="text" id="username" value="$provided_user" name="username" required/><br><br>
							<strong>Password: </strong><input type="password" id="pwd" value="$provided_password" name="pwd" required/><br /><br/>
							<input type="submit" class="btn btn-primary button" value="Login" name="loginbutton" id="loginSubmit" onsubmit="validate()"/><br />	
						</form>
					</div>
				</div>
                <div class="col-xs-4 col-md-4" align="center">
                    <img src="images/kendrick.jpeg" alt="college image" class="img-rounded"> <br><br>
                </div>
              </div>
              <div class="row">
              	<div class="col-xs-4 col-md-4" align="center">
                	<img src="images/cudi.jpg" alt="college image" class="img-rounded">
              	</div>
              	<div class="col-xs-4 col-md-4" align="center">
              		<div class="well">
              		<br><br><br><br><h2><strong>Not a member? Sign up now!</strong></h2><br />
						<form action="signup/sign_up.php" method="post">
							<input type="submit" class="btn btn-default button" value="Sign Up" name="Signupbutton" /><br />
						</form><br/><br/>
					</div>
				</div>
              	<div class="col-xs-4 col-md-4" align="center">
                	<br><img src="images/bobmarley.jpg" alt="college image" class="img-rounded">
              	</div>
              </div>
		</div>
		<br>
		<script src="bootstrap/jquery-3.2.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>		
EOBODY;

if (isset($_POST["loginbutton"])) {
	$script = <<<EOBODY
<script type="text/javascript">
	document.getElementById("loginDiv").innerHTML += 
		"<p><strong>You have entered an invalid username or password. Please try again<br /></strong></p>";
</script>
</body>
</html>
EOBODY;

	$login = $login.$script;
}


$page = generatePage($login);
echo $page;
?>
