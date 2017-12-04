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

if (isset($_POST['searchedFriend']))
{
    $viewing = new User($_POST['searchedFriend']);
    $viewing = $viewing->getUsername();
}
else
{
    $userObject = $_SESSION["userObject"]; #initialize user so header can be customized
    $user = $userObject->getUsername();
}
?>
<div class="fixedHeader">
    <div class="col-xs-4 col-md-4">
        <br>
        <span style="float: left;">
            <form action="timeline.php">
                <input type="submit" name="timelineButton" value="Timeline" class="btn btn-primary button"/>&emsp;&emsp;
            </form>
        </span>
        <?php
            if (isset($_POST["searchedFriend"])) {
                echo "<span style='float: left;'><form action='profile.php'>
                        <input type=\"submit\" name=\"profileButton\" value=\"Profile\" class=\"btn btn-primary button\"/>&emsp;&emsp;
                        </form>
                        </span>";
            }
        ?>
        <span style="float: left;">
            <form action="login.php">
                <input type="submit" name="logoutButton" value="Logout" class="btn btn-primary button"/>&emsp;&emsp;
            </form>
        </span>
    </div>
    <div class="col-xs-4 col-md-4">
        <h1 class="headers" align="center"><?php if(!isset($_POST['searchedFriend'])) echo $user; else
                echo $viewing;?>'s Profile</h1>
    </div>
    <div class="col-xs-4 col-md-4">
        <br>
        <span style="float: left;">
        <form action="newpost.php" method="post">
            <input type="submit" name="createPostfromprofile" value="New Post" class="btn btn-primary button" align="center"/>
            &nbsp;&nbsp;&nbsp;
        </form>
        </span>
        <span style="float:left;">
            <form action = "profile.php" method="POST">
            <i class="glyphicon glyphicon-search"></i>
            <input type="text" placeholder="Search..." name="searchBar"/>
            <input type="submit" name="submitSearch" value="go">
        </form>
        </span>
    </div>
</div>
<div class="container" id="container1">
    <?php
    if (!isset($_POST['searchBar']) && !isset($_POST['searchedFriend']))
    {

    }
    else if (isset($_POST['searchBar']))
    {
        $table = <<<EOD
    <table class="table table-sm table-inverse">
  <thead>
    <tr>
      <th>Username</th>
    </tr>
  </thead>
  <tbody>
EOD;


        $search = $_POST['searchBar'];
        $sQuery = $userposts=DB::query("SELECT ".UserTable::USERNAME_FIELD." FROM ".UserTable::TABLE_NAME." WHERE ".UserTable::USERNAME_FIELD." LIKE ".'\'%'.$search.'%\'');
        for($i = 0; $i < count($sQuery); $i++)
        {
            $ix =  $sQuery[$i]['username'];
            $table .= '<form method="post" action="profile.php">';
            $table .= '<input type="hidden" name="searchedFriend" value="'.$ix.'" >';
            $table .= "<tr><td>".'<input type="submit" class="submitLink" value="'.$ix.'"></td></tr></form>';
        }

        $table .= <<<EOD
  </tbody>
</table>
EOD;
        echo $table;
    }
    ?>
</div>
<div class="container">
    <div class="col-xs-3 col-md-3">
    </div>
    <div class="col-xs-6 col-md-6 whiteColumn" style="border-radius: 10px">
        <?php
        if (isset($_POST['searchedFriend']))
        {
            $userposts = DB::query("SELECT * FROM ".PostsTable::TABLE_NAME . " where " . PostsTable::OWNER_FIELD . " = %s",
                $viewing);
            if (count($userposts) === 0) {
                $exist = DB::query("SELECT * FROM ".UserTable::TABLE_NAME." where ".UserTable::USERNAME_FIELD." = %s",
                    $viewing);
                if (count($exist) === 0) {
                    echo "This user does not exist. Please verify username and try again";
                }
                else {
                    echo "This user hasn't made any posts. Inspire them";
                }
            }
        }
        else
        {
            $userposts = DB::query("SELECT * FROM ".PostsTable::TABLE_NAME . " where " . PostsTable::OWNER_FIELD . " = %s",
                $user);
            if (count($userposts) === 0) {
                echo "You haven't made any posts. Feel free to make some";
            }
        }

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
