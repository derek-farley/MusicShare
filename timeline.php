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
<div class="fixedHeader">
    <div class="col-xs-3 col-md-3">
            <br>
            <form action="profile.php" method="GET">
                <input type="submit" name="profileButton" value="Profile" class="btn btn-primary button"/>
            </form>
    </div>
    <div class="col-xs-6 col-md-6">
        <h1 class="headers" align="center">MusicShare</h1>
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
        require_once "support.php";
        require_once "meekrodb.2.3.class.php";
        require_once "Post.php";
        require_once "User.php";

        #this is to be the Main Page of the website, once logged in. This should display the user's timeline. Still a draft.
        includeConstants();
        dbConfig();


        # initialize session to pull and push variables
        session_start();


        $username = $_SESSION["user"];
        //$userObject = new User()
        $currUser = new User($username);
        $_SESSION["userObject"] = $currUser; #make user object accessible in any script
        #print_r($postsArray[0]);
        #print_r($postsArray);
        #print_r($currUser->getReposts());

        foreach ($currUser->getPosts() as $array) {
           # print_r($array);
            if ($currUser->isRepost($array)) {
                $array[PostsTable::POST_ID_FIELD] = $currUser->getReposts()[$array[PostsTable::POST_ID_FIELD]];
                $post = Post::createRepost($array);
                echo $post->displayPost();
            }
            else {
                $post = Post::createPost($array);
                echo $post->displayPost();
            }
        }
        ?>

    </div>
    <div class="col-xs-3 col-md-3">
    </div>
</div>
</body>
</html>