<?php
    require_once("support.php");
    require_once "meekrodb.2.3.class.php";


    includeConstants();
    dbConfig();
    session_start(); # initialize session to pull and push variables

    $top = "<h1><strong>Your Profile</strong></h1>,br /><br />";

    #if new user created, check if username already exists, if so then notify and return to sign up page, otherwise display empty timeline

    $body=$top.$bottom;
    $page = generatePage($body);
    echo $page;
?>