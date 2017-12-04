<?php
    require_once("support.php");
    require_once "meekrodb.2.3.class.php";


    includeConstants();
    dbConfig();
    session_start(); # initialize session to pull and push variables

    $user=$_SESSION["user"];
    //$user="pkarki1";
    
    $userposts=DB::query("SELECT * FROM posts WHERE owner='".$user."'order by STR_TO_DATE(`timestamp`,'%h:%i:%s %p') desc");


    //getting and adding reposts to userposts
    //$reposts_ids=DB::query("SELECT post_id FROM likerepost WHERE username='".$user."' AND isLike=0");
    
    // for($j=0; $j<count($reposts_ids); $j++){
    //     $post=DB::query("SELECT * FROM posts WHERE post_id='".$reposts_ids[$j]."'");
    //     array_push($userposts, $post);
    // }
    //order by STR_TO_DATE(`timestamp`,'%h:%i:%s %p') desc


    $top = <<<EOBODY
        <!doctype html>
    <html> 
        <head>
            <title>Profile Page</title>
        </head>

    <h1><strong>Your Profile</strong></h1><br /><br />
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
        $bottom+= $toAdd->displayPost();
    }

    #create shortcuts to Timeline feed, search query bar for friends, loggin out?


    $body=$top.$bottom;
    $page = generatePage($body);
    echo $page;
?>