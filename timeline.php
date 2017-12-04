<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- scale application to window space available (1 ==> 100%) -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="signup/color.css" />
    <script type="text/javascript" src="postScript.js"></script>
</head>
<body>
<div class="fixedHeader">
    <div class="col-xs-4 col-md-4">
        <br>
        <span style="float: left">
            <form action="profile.php" method="POST">
            <input type="submit" name="profileButton" value="Profile" class="btn btn-primary button"/>&emsp;&emsp;
            </form>
        </span>
        <span style="float: left;">
            <form action="login.php">
                <input type="submit" name="logoutButton" value="Logout" class="btn btn-primary button"/>&emsp;&emsp;
            </form>
        </span>
    </div>
    <div class="col-xs-4 col-md-4">
        <h1 class="headers" align="center">MusicShare</h1>
    </div>
    <div class="col-xs-4 col-md-4">
        <br>
        <span style="float:left;">
        <form action="newpost.php" method="post">
            <input type="submit" name="createPostfromtimeline" value="New Post" class="btn btn-primary button" align="center"/>
            &nbsp;&nbsp;&nbsp;
        </form>
        </span>
        <span style="float:left;">
            <form action = "profile.php" method="POST" align="center">
            <i class="glyphicon glyphicon-search"></i>
            <input type="text" placeholder="Search..." name="searchBar"/>
            <input type="submit" name="submitSearch" value="go">
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
        if (!isset($_SESSION))
            session_start();


        $username = $_SESSION["user"];
        //$userObject = new User()
        $currUser = new User($username);
        $_SESSION["userObject"] = $currUser; #make user object accessible in any script
        #print_r($postsArray[0]);
        #print_r($currUser->getReposts());

    if (isset($_POST['submitPost'])){
        $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submitPost"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
     if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
$imgloc = $target_file; 
$image = fopen($imgloc, 'rb'); 
$imageContent = fread($image, filesize($imgloc));
$imgur = base64_encode($imageContent);
        $newpost= new Post($_SESSION['user'],$_POST['artist'],$_POST['album'],$_POST['song'],$imageContent);
        $newpost->addPostToDb();          
        if (isset($_POST['submitPost'])){
            $newpost= new Post($currUser,$_POST['artist'],$_POST['album'],$_POST['song'],$_POST['image']);
            $newpost.addPosttoDb();
        }

        foreach ($currUser->getPosts() as $array) {
            # print_r($array);
            if ($currUser->isRepost($array)) {
                $array[PostsTable::POST_ID_FIELD] = $currUser->getReposts()[$array[PostsTable::POST_ID_FIELD]];
                $post = Post::createRepost($array);
                echo $post->displayPost($currUser);
            }
            else {
                $post = Post::createPost($array);
                echo $post->displayPost($currUser);
            }
        }

        if (count($currUser->getPosts()) === 0) {
            echo "You have no posts to view. Follow some users or make some posts... or both";
        }
        ?>

    </div>
    <div class="col-xs-3 col-md-3">
    </div>
</div>
</body>
</html>