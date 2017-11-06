<?php
	#declare(strict_types=1);
	require_once("support.php");

$body = <<<EOBODY
	<script src="signup.js"></script>
	<form action="upload.php" method="post">
		<h1><strong>MusicShare </strong></h1><br />
		<h2><strong>Sign up as a New Member</strong></h2><br />
		<strong>Create Username: </strong><input type="text" name="new_username" required/><br />
		<strong>Create Password: </strong><input type="text" id="new_pwd" name="new_pwd" required/><br />
		<strong>Verify Password: </strong><input type="text" id="verify_pwd" name="verify_pwd" required/><br />
	</form>

EOBODY;

$page = generatePage($body);
	echo $page;
?>
