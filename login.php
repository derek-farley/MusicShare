<?php
	#declare(strict_types=1);
	require_once "support.php";
	require_once "meekrodb.2.3.class.php";

	#$hashedpwd = password_hash($password, PASSWORD_DEFAULT);
	#$hasheduser=password_hash($user,PASSWORD_DEFAULT);

	includeConstants();
	dbConfig(); # configure meekrodb for musicshare db

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
	
		<script src="login.js"></script>
		<p>
		<form action= "login.php" method="post">
			<h1><strong>MusicShare </strong></h1><br />
			<h2><strong>Login </strong></h2><br />
			<strong>Username: </strong><input type="text" id="username" name="username" required/><br />
			<strong>Password: </strong><input type="password" id="pwd" name="pwd" required/><br />
			<input type="submit" value="Login" name="loginbutton" id="loginSubmit"/><br />
		</form>
		</p>
	
		
EOBODY;

	if (isset($_POST["loginbutton"])) {
		$login = $login."You have entered an invalid username or password. Please try again<br />";
	}

	$signup = <<<EOBODY
	
	
		<p>
		<h2><strong>Not a member? Sign up now!</strong></h2><br />
		<form action="sign_up.php" method="post">
			<input type="submit" value="Sign Up" name="Signupbutton" /><br />
		</form>
		</p>

EOBODY;


	$page = generatePage($login.$signup);
	echo $page;
?>
