<?php
    require_once "support.php";
    require_once "meekrodb.2.3.class.php";
    require_once "Post.php";
    require_once "User.php";
    session_start();
    #this is to be the Main Page of the website, once logged in. This should display the user's timeline. Still a draft.
    includeConstants();
    dbConfig();
 
# initialize session to pull and push variables
    $username = $_SESSION["user"];
    //$userObject = new User()

    $currUser = new User($username);
    echo strval($currUser);
    $_SESSION["user"] = $currUser; #make user object accessible in any script
    #print_r($postsArray[0]);
    #print_r($postsArray);
      #  echo '<img src="data:image/jpeg;base64,'.base64_encode($postsArray[0]["albumart"]).'"/>';

 

    $userTable = '<table border="1">';
    $userTable .= '<th>Posts</th><th>Followers</th><th>Following</th><th>Likes</th>';
    $userTable .= '<tr><td>'.count($userQuery).'</td><tr></table>';


    
    $top = "<h1><strong>".$username."'s Timeline</strong></h1>";


    //var_dump($userQuery);

    $body=$userTable.$top;//.$bottom;
     $page = generatePage($body);
     echo $page;
?>