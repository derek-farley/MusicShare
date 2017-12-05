<?php
/**
 * file for checking if user present in database
 */
    require_once "../support.php";
    require_once "../meekrodb.2.3.class.php";

    includeConstants("../");
    dbConfig();

    $username = $_GET["username"];
    $exists = DB::queryFirstRow("SELECT * from ".UserTable::TABLE_NAME." where ". UserTable::USERNAME_FIELD." = %s",
        $username);
    if ($exists !== null) {
        echo "<strong>This username is already taken. Please try again<br /></strong>";
    }