<?php
	#declare(strict_types=1);
	require_once("support.php");

	$user = "main";
$password = "terps";

$hashedpwd = password_hash($password, PASSWORD_DEFAULT);
$hasheduser=password_hash($user,PASSWORD_DEFAULT);

$body = <<<EOBODY
	 <head>
        <meta charset="utf-8" />
		<title>Login Page</title>
		<script src="login.js"></script>
	</head>
	<body>
	<p>
	<form action="homepage.php" method="post">
		<h1><strong>MusicShare </strong></h1><br />
		<h2><strong>Login </strong></h2><br />
		<strong>Username: </strong><input type="text" name="username" required/><br />
		<strong>Password: </strong><input type="text" name="pwd" required/><br />
		<input type="submit" value="Login" name="loginbutton" /><br />
	</form>
	</p>

	<p>
	<h2><strong>Not a member? Sign up now!</strong></h2><br />
	<form action="sign_up.php" method="post">
		<input type="submit" value="Sign Up" name="Signupbutton" /><br />
	</form>
	</p>
	</body>
EOBODY;

$page = generatePage($body);
	echo $page;
?>
