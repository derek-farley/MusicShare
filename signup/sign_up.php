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
			<!doctype html>
	<html> 
	    <head>
	    <style>

            .greenBackground { background: green }
        </style>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  		<link rel="stylesheet" href="color.css" />
        </head>
        <body>
		<script type="text/javascript" src="signup.js"></script>
		        <div class="container-fluid full">
            <!-- Rows creating using row class; must be created within containers -->
            <!-- 12 available Boostrap columns; you need to specify how many -->
            <!-- Boostrap columns a column should span.  For example, col-xs-6 -->
            <!-- indicates a column will span 6 bootstrap columns -->
            <div class="row"  style="background:transparent url('mu.jpg') no-repeat center center /cover">>
                <div class="col-xs-12 col-md-12 text-center headers">
                    <h2>MusicShare</h2>

            </div>
            </div>
            </div>
		<div align="center">
			<form action="sign_up.php" method="post">
				<h3><strong>Sign up as a New Member</strong></h3><br />
				<strong>Create Username: </strong><input type="text" id="new_username" value="$provided_user"
					name="new_username" required/><br /><br/>
				<strong>Create Password: </strong><input type="password" value="$provided_password"
					id="new_pwd" name="new_pwd" required/><br /><br/>
				<strong>Verify Password: </strong><input type="password" value="$provided_verify" 
					id="verify_pwd" name="verify_pwd" required/><br /><br/>
				<input type="submit" class="btn btn-primary button" value="Create new Membership" name="submit_sign_up"/>
			</form> <br/>
		</div>
		<div id = "errorText"></div>
       	<script src="../bootstrap/jquery-3.2.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        </body>
 

EOBODY;

	$page = generatePage($signup);
		echo $page;
?>
