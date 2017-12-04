<?php
    require_once("support.php");
    require_once "meekrodb.2.3.class.php";


    includeConstants();
    dbConfig();
    session_start(); # initialize session to pull and push variables

    $user=$_SESSION["user"];

    $reposts_ids=DB::query("SELECT post_id from likerepost where username= '%s' and isLike=0",$user);
    $ids = join("','",$reposts_ids);   
    $userposts=DB::query("SELECT * from posts where owner= '%s' or post_id in ('$ids')",$user);

    $allPosts = [];


    $top = <<<EOBODY
        <!doctype html>
    <html> 
        <head>
            <title>Friend Profile Page</title>
        </head>

    <h1><strong>Friend Profile</strong></h1><br /><br />
    <form action="timeline.php" method="post">
        <input type="submit" name="returntotimeline" value="Return to Timeline" /><br />
    </form>
    <form action="friend_profile.php" method="post">
        <input type="text" name="queried_friend"/>
        <input type="submit" name="submit_query" value="Find" />
    </form>
EOBODY;

$bottom="";

for($i = 0; $i < count($userposts); $i++)
    {
        $owner = $userposts[$i]['owner'];
        $artist = $userposts[$i]['artistname'];
        $album = $userposts[$i]['songalbumname'];
        $song_url = $userposts[$i]['url'];
        $imagefilepath = $userposts[$i]['albumart'];
        $toAdd = new Post($owner, $artist, $album, $song_url, $imagefilepath);
        array_push($allPosts , $toAdd);
        $bottom+= $toAdd->displayPost();
    }

    #create shortcuts to Timeline feed, search query bar for friends, loggin out?


    $body=$top.$bottom;
    $page = generatePage($body);
    echo $page;
?>