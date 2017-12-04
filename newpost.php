<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- scale application to window space available (1 ==> 100%) -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="signup/color.css" />
</head>
<body>
<?php
require_once("support.php");
require_once "meekrodb.2.3.class.php";

$file="";

if(isset($_POST["createPostfromprofile"])){
	$file="profile.php";
}else{
	$file="timeline.php";
}


$body=<<<EOBODY
	<h1>Create New Post</h1><br />
	<div>
	<form action=$file method="post">
		Artist Name : <input type="text" name="artist"/><br /><br />
		Album Title : <input type="text" name="album"/><br /><br />
		Link to song: <input type="text" name="song"/><br /><br />
		Image filepath: <input type="text" name="image"/><br /><br />
		<input type="submit" name="submitPost" value="Enter Post" />
		<input type="reset" value="Clear Fields"/>
	</form>
	</div>
	</body>
EOBODY;

$page = generatePage($body);
echo $page;
?>
