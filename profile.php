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
require_once "User.php";
require_once("support.php");
require_once "meekrodb.2.3.class.php";
require_once "Post.php";


includeConstants();
dbConfig();
if (!isset($_SESSION["user"]))
    session_start(); # initialize session to pull and push variables

if (isset($_POST['searchedFriend']))
{
    $viewing = new User($_POST['searchedFriend']);
    $viewing = $viewing->getUsername();

}
else
{
    $userObject = $_SESSION["userObject"]; #initialize user so header can be customized
    $user = $_SESSION["user"];
    $currUser = new User($user);
}

?>
<script type="text/javascript" src="postScript.js"></script>
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
        <form align="center">
            <input type="hidden" id="following" name="following" value="<?php if(!isset($_POST['searchedFriend'])) echo $user; else
                echo $viewing;?>"/>
            <?php
                if(isset($_POST['searchedFriend']) && $_SESSION["userObject"]->getUsername() !== $viewing) {
                    if (!$_SESSION["userObject"]->isFollowing($viewing)) {
                        echo "<input type=\"button\" name=\"followButton\" value=\"Follow\" id=\"followButton\" class=\"btn btn-primary button\"
                        onclick=\"followUser(this.form)\"/>";
                    }
                    else {
                        echo "<input type=\"button\" name=\"followButton\" value=\"Unfollow\" id=\"followButton\" class=\"btn btn-primary button\"
                        style='background-color: PaleVioletRed;' onclick=\"unfollowUser(this.form)\"/>";
                    }
                }
            ?>

        </form>
    </div>
    <?php
    if(!isset($_POST['searchedFriend']))
    {
        $divBody = <<<EOT
    <div class="col-xs-4 col-md-4">
    <br>
    <span style="float: left;">
    <form action="newpost.php" method="post">
    <input type="submit" name="newPost" value="New Post" class="btn btn-primary button" align="center"/>
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
EOT;
    }
    else
    {
        $divBody = <<<EOT
    <div class="col-xs-4 col-md-4">
    <br>
    <span style="float: left;">
    </span>
    <span style="float:left;">
    </span>
    </div>
EOT;
    }
        echo $divBody;
    ?>
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
<div class="container" id="displayPost">
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
            echo $post->displayPost($_SESSION["userObject"]);
        }

        ?>
    </div>
    <div class="col-xs-3 col-md-3">
    </div>
</div>
</body>
</html>
