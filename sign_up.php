<?php
	#declare(strict_types=1);
	require_once("support.php");

$body = <<<EOBODY
	 <head>
        <meta charset="utf-8" />
		<title>Research Form</title>
		<script src="signup.js"></script>
	</head>
	<body>
	<form action="homepage.php" method="post">
		<h1><strong>MusicShare </strong></h1><br />
		<h2><strong>Sign up as a New Member</strong></h2><br />
		<strong>Create Username: </strong><input type="text" name="username" required/><br />
		<strong>Create Password: </strong><input type="text" id="newpwd" name="newpwd" required/><br />
		<strong>Verify Password: </strong><input type="text" id="verify_pwd" name="verify_pwd" required/><br />
	</form>
	</body>
EOBODY;

$page = generatePage($body);
	echo $page;
?>
