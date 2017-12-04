<?php
    require_once("support.php");
    require_once "meekrodb.2.3.class.php";
    require_once("Post.php");
    session_start();
    #this is to be the Main Page of the website, once logged in. This should display the user's timeline. Still a draft.

     dbConfig();
 
# initialize session to pull and push variables
    $userName = $_SESSION["user"];
    //$userObject = new User()
 
    $userQuery = DB::query("SELECT * from posts where ".'owner'." = %s",
            'pkarki113'); # check for user in db
    $allPosts = [];
 
    for($i = 0; $i < count($userQuery); $i++)
    {
        $owner = $userQuery[$i]['owner'];
        $artist = $userQuery[$i]['artistname'];
        $album = $userQuery[$i]['songalbumname'];
        $song_url = "inserturlhere";
        $imagefilepath = $userQuery[$i]['albumart'];
        $toAdd = new Post($owner, $artist, $album, $song_url, $imagefilepath);
        array_push($allPosts , $toAdd);
        echo $toAdd->displayPost();
    }
 

    $userTable = '<table border="1">';
    $userTable .= '<th>Posts</th><th>Followers</th><th>Following</th><th>Likes</th>';
    $userTable .= '<tr><td>'.count($userQuery).'</td><tr></table>';


    
    $top = "<h1><strong>".$userName."'s Timeline</strong></h1>";



    //var_dump($userQuery);

    $body=$userTable.$top;//.$bottom;
     $page = generatePage($body);
     echo $page;
?>