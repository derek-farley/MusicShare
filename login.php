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
		<title>Research Form</title>	
		<script src="login.js"></script>
	</head>
	<body>
	<form action="displayApp.php" method="post">
		<h1><strong>MusicShare </strong></h1><br />
		<h2><strong>Login </strong></h2><br />
		<strong>Username: </strong><input type="text" name="username" /><br />
		<strong>Password: </strong><input type="text" name="pwd" /><br />
		<input type="submit" value="Login" name="loginbutton" /><br />
		<h2><strong>Not a member? Sign up now!</strong></h2><br />
		<strong>Create Username: </strong><input type="text" name="username" /><br />
		<strong>Create Password: </strong><input type="text" id="pwd" name="pwd" /><br />
		<strong>Verify Password: </strong><input type="text" id="verify_pwd" name="pwd" /><br />
	</form>
	</body>
EOBODY;

$page = generatePage($body);
	echo $page;
?>