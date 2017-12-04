<?php
require_once "meekrodb.2.3.class.php";
require_once "support.php";

includeConstants();
dbConfig();
session_start();
echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
$user = $_SESSION["userObject"];
$postid = (int) $_GET["postid"];
$newValue = (int) $_GET["newValue"];
echo "updating db";
switch ($_GET["operation"]) {
    case "like" :
        insertDeleteLikeRepost($user->getUsername(), $postid, 1, true);
        updatePostsTable($newValue, $postid);
        break;
    case "unlike" :
        insertDeleteLikeRepost($user->getUsername(), $postid, 1, false);
        DB::delete(LikeRepostTable::TABLE_NAME,
            LikeRepostTable::USERNAME_FIELD." =%s and ".LikeRepostTable::POST_ID_FIELD." = %d and "
            .LikeRepostTable::IS_LIKE_FIELD." = %d",
            $user->getUsername(),
            $postid,
            1);
        updatePostsTable($newValue, $postid);
        break;
    case "repost" :
        insertDeleteLikeRepost($user->getUsername(), $postid, 0, true);
        updatePostsTable($newValue, $postid);
        break;
    case "unrepost" :
        insertDeleteLikeRepost($user->getUsername(), $postid, 0, false);
        updatePostsTable($newValue, $postid);
        break;
}

function updatePostsTable($newValue, $postid) {
    DB::update(PostsTable::TABLE_NAME, array(
        PostsTable::LIKES_FIELD => $newValue
    ), PostsTable::POST_ID_FIELD." = %d", $postid);
}

function insertDeleteLikeRepost($username, $postid, $isLike, $isInsert) {
    if ($isInsert) {
        DB::insert(LikeRepostTable::TABLE_NAME, array(
            LikeRepostTable::USERNAME_FIELD => $username,
            LikeRepostTable::POST_ID_FIELD => $postid,
            LikeRepostTable::IS_LIKE_FIELD => $isLike
        ));
    }
    else {
        DB::delete(LikeRepostTable::TABLE_NAME,
            LikeRepostTable::USERNAME_FIELD." =%s and ".LikeRepostTable::POST_ID_FIELD." = %d and "
            .LikeRepostTable::IS_LIKE_FIELD." = %d",
            $username,
            $postid,
            $isLike);
    }
}
