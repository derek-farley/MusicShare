<?php
require_once "meekrodb.2.3.class.php";
require_once "support.php";



includeConstants();
dbConfig();

if (!isset($_SESSION['user']))
    session_start();

$user = $_SESSION["userObject"];
if (isset($_GET["postid"])) {
    $postid = (int) $_GET["postid"];
}
$newValue = (int) $_GET["newValue"];
echo "updating db";
switch ($_GET["operation"]) {
    case "like" :
        insertDeleteLikeRepost($user->getUsername(), $postid, 1, true);
        updatePostsTable($newValue, $postid, true);
        $user->addLike($postid);
        break;
    case "unlike" :
        insertDeleteLikeRepost($user->getUsername(), $postid, 1, false);
        DB::delete(LikeRepostTable::TABLE_NAME,
            LikeRepostTable::USERNAME_FIELD." =%s and ".LikeRepostTable::POST_ID_FIELD." = %d and "
            .LikeRepostTable::IS_LIKE_FIELD." = %d",
            $user->getUsername(),
            $postid,
            1);
        updatePostsTable($newValue, $postid, true);
        $user->removeLike($postid);
        break;
    case "repost" :
        insertDeleteLikeRepost($user->getUsername(), $postid, 0, true);
        updatePostsTable($newValue, $postid, false);
        $user->addRepost($postid);
        break;
    case "unrepost" :
        insertDeleteLikeRepost($user->getUsername(), $postid, 0, false);
        updatePostsTable($newValue, $postid, false);
        $user->removeRepost($postid);
        break;
    case "follow" :
        DB::insert(FollowsTable::TABLE_NAME, array(
            FollowsTable::FOLLOWS_FIELD => $_GET["newValue"],
            FollowsTable::FOLLOWED_BY_FIELD => $user->getUsername()
        ));
        $user->addFollowing($_GET["newValue"]);
        break;
    case "unfollow" :
        DB::delete(FollowsTable::TABLE_NAME,
            FollowsTable::FOLLOWED_BY_FIELD." = %s and ".FollowsTable::FOLLOWS_FIELD." = %s",
            $user->getUsername(), $_GET["newValue"]);
        $user->removeFollow($_GET["newValue"]);
        break;
}

$_SESSION["userObject"] = $user;

function updatePostsTable($newValue, $postid, $isLike) {
    if ($isLike) {
        DB::update(PostsTable::TABLE_NAME, array(
            PostsTable::LIKES_FIELD => $newValue
        ), PostsTable::POST_ID_FIELD . " = %d", $postid);
    }
    else {
        DB::update(PostsTable::TABLE_NAME, array(
            PostsTable::REPOSTS_FIELD => $newValue
        ), PostsTable::POST_ID_FIELD . " = %d", $postid);
    }
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
