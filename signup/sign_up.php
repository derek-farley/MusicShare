<?php
	#declare(strict_types=1);
	require_once "../support.php";
	require_once "../meekrodb.2.3.class.php";

	includeConstants("../");
	dbConfig();

	$provided_user = "";
	$provided_password = "";
	$provided_verify = "";
	if (isset($_POST["submit_sign_up"])) {
		$provided_user = $_POST["new_username"];
		$provided_password = $_POST["new_pwd"];
		$provided_verify = $_POST["verify_pwd"];

        session_start();
        DB::insert(UserTable::TABLE_NAME, array(
            UserTable::USERNAME_FIELD => $provided_user,
            UserTable::PASSWORD_FIELD => password_hash($provided_password, PASSWORD_DEFAULT)));
        $_SESSION["user"] = $provided_user;
        $_SESSION["new_user"] = true;
        # flag to prevent future scripts from wasting time querying all tables for a new user
        header("Location: timeline.php");
	}

	$signup = <<<EOBODY
		<script type="text/javascript" src="signup.js"></script>
		<form action="sign_up.php" method="post">
			<h1><strong>MusicShare </strong></h1><br />
			<h2><strong>Sign up as a New Member</strong></h2><br />
			<strong>Create Username: </strong><input type="text" id="new_username" value="$provided_user"
				name="new_username" required/><br /><br/>
			<strong>Create Password: </strong><input type="password" value="$provided_password"
				id="new_pwd" name="new_pwd" required/><br /><br/>
			<strong>Verify Password: </strong><input type="password" value="$provided_verify" 
				id="verify_pwd" name="verify_pwd" required/><br /><br/>
			<input type="submit" value="Create new Membership" name="submit_sign_up"/>
		</form> <br/>
		<div id = "errorText"></div>

EOBODY;

	$page = generatePage($signup);
		echo $page;
?>
