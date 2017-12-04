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
require_once "Post.php";
require_once "User.php";

includeConstants();
dbConfig();
session_start(); # initialize session to pull and push variables

$user = $_SESSION["userObject"]; #initialize user so header can be customized
?>
<div class="fixedHeader">
    <div class="col-xs-3 col-md-3">
        <br>
        <form action="timeline.php">
            <input type="submit" name="timelineButton" value="Timeline" class="btn btn-primary button"/>
        </form>
    </div>
    <div class="col-xs-6 col-md-6">
        <h1 class="headers" align="center"><?php echo $user->getUsername()?>'s Profile</h1>
    </div>
    <div class="col-xs-3 col-md-3">
        <br>
        <span style="float:left;">
            <input type="submit" name="createPost" value="New Post" class="btn btn-primary button"/>
        </span>
        <span style="float:right;">
            <form action = "profile.php" method="GET" align="center">
            <i class="glyphicon glyphicon-search"></i>
            <input type="text" placeholder="Search..." name="searchBar"/>
        </form>
        </span>
    </div>
</div>
<div class="container">
    <div class="col-xs-3 col-md-3">
    </div>
    <div class="col-xs-6 col-md-6 whiteColumn" style="border-radius: 10px">
        <?php
        $userposts=DB::query("SELECT * FROM ".PostsTable::TABLE_NAME." where ".PostsTable::OWNER_FIELD." = %s",
            $user->getUsername());

        foreach ($userposts as $postarray) {
            $post = Post::createPost($postarray);
            echo $post->displayPost();
        }
        ?>
    </div>
    <div class="col-xs-3 col-md-3">
    </div>
</div>
</body>
</html>
