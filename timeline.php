<?php
	require_once("support.php");
	require_once("Database.php");

	#this is to be the Main Page of the website, once logged in. This should display the user's timeline. Still a draft.

	$host = "localhost";
	$user = "dbuser";
	$password = "goodbyeWorld";
	$database = "musicshare";
	$table = "users";
	$db= new Database($host, $user, $password, $database);
	$db_connected = db->connect($host, $user, $password, $database);

	$top = "<h1><strong>Your MusicShare Timeline</strong></h1>,br /><br />";

	#if Logging in to existing user, pull records and display on timeline

	if(isset($_POST["loginbutton"])){
		$sqlQuery = sprintf("select * from $table where username='%s'", trim($_POST["username"]));
		$result = mysqli_query($db_connected, $sqlQuery);
		if ($result) {
			$numberOfRows = mysqli_num_rows($result);
 	 		if ($numberOfRows == 0) {
				$bottom="<h2><strong>No entry exists in the database for the specified user<strong></h2>";
			} else {
				while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

		     	#fill variables with posts of friends following

     			}
			}

			mysqli_free_result($result);

			#display variables on timeline using bottom variable

		}  else {
			echo "Retrieving records failed.".mysqli_error($db);
		}


	#if new user created, check if username already exists, if so then notify and return to sign up page, otherwise display empty timeline

	}else if(isset($_POST["submit_sign_up"])){
		$sqlQuery = sprintf("select * from $table where username='%s'", trim($_POST["new_username"]));
		$result = mysqli_query($db_connected, $sqlQuery);
		if ($result) {
			$numberOfRows = mysqli_num_rows($result);
 	 		if ($numberOfRows == 0) {
				$bottom="<h2><strong>Empty Timeline<strong></h2><br />";
			} else {
				$bottom=<<<EOBODY
				<form action="sign_up.php" method="post">
				<h2><strong>The username you entered already exists, return to Sign Up page</strong></h2><br />
				<input type="submit" value="Return to Sign Up" name="return_sign_up" />
				</form>
EOBODY;
     			}
			}

			mysqli_free_result($result);
		}  else {
			echo "Retrieving records failed.".mysqli_error($db);
		}
	}

$body=$top.$bottom;
$page = generatePage($body);
	echo $page;