<?php
    require_once("support.php");
    require_once "meekrodb.2.3.class.php";


    includeConstants();
    dbConfig();
    session_start(); # initialize session to pull and push variables

    $top = "<h1><strong>Your Profile</strong></h1>,br /><br />";

    #create shortcuts to Timeline feed, search query bar for friends, loggin out?


    #select post_ids from LikeRePostTable where username==currentuser and isLike==0
    #select * from PostsTable where owner==currentuser OR post_ids.contain(post_id)
    #take returned list of post objects and output them using display funciton across the profile
    #put <br /><br /> in between

    $body=$top.$bottom;
    $page = generatePage($body);
    echo $page;
?>