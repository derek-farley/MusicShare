<?php
    require_once("support.php");
    require_once "meekrodb.2.3.class.php";

    #this is to be the Main Page of the website, once logged in. This should display the user's timeline. Still a draft.

    includeConstants();
    dbConfig();

    session_start(); # initialize session to pull and push variables

    $top = "<h1><strong>Your MusicShare Timeline</strong></h1>,br /><br />";

    #if Logging in to existing user, pull records and display on timeline

    #if new user created, check if username already exists, if so then notify and return to sign up page, otherwise display empty timeline

    $body=$top.$bottom;
    $page = generatePage($body);
    echo $page;
?>