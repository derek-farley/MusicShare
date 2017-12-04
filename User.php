<?php
declare(strict_types=1);
require_once "meekrodb.2.3.class.php";
require_once "support.php";
require_once "Post.php";
/**
 * MusicShare user class
 */

class User {
    private $username;
    private $follower_array;
    private $following_array;
    private $posts_array;
    private $reposts_array;

    public function __construct(string $user_name) {
        $this->username = $user_name;
        $this->follower_array = $this->collectFollowers();
        $this->following_array = $this->collectFollowing();
        $this->posts_array = $this->collectPosts();
        $this->reposts_array = $this->collectReposts(); #associative array to determine reposts in posts array
    }

    public function __toString() {
        return "Username ".$this->username." with "
            .count($this->follower_array)." followers and following ".count($this->following_array)
            ." with ".count($this->posts_array)." posts on timeline";
    }

    public function getUserName() : string {
        return $this->username;
    }
    public function getFollowers() : array {
        return $this->follower_array;
    }

    public function getFollowing() : array {
        return $this->following_array;
    }

    public function getPosts() : array {
        return $this->posts_array;
    }
    public function addFollower(User $user) {
        $this->follower_array[] = $user;
    }

    public function addFollowing(User $user) {
        $this->following_array[] = $user;
    }

    public function addPost(Post $post) {
        $this->posts_array[] = $post;
    }

    public function collectPosts() {
        array_push($this->following_array, $this->username);
        $results = DB::query(
            "SELECT * from ".PostsTable::TABLE_NAME." where ".PostsTable::OWNER_FIELD." in %ls"." UNION SELECT * from "
            .PostsTable::TABLE_NAME." where ".PostsTable::POST_ID_FIELD." in (SELECT ".LikeRepostTable::POST_ID_FIELD.
            " from ".LikeRepostTable::TABLE_NAME." where ".LikeRepostTable::USERNAME_FIELD." in %ls and ".LikeRepostTable::IS_LIKE_FIELD.
            " = 0) order by ".PostsTable::TIMESTAMP_FIELD." DESC", $this->following_array, $this->following_array);
        array_pop($this->following_array);
        return $results;
    }

    public function collectFollowing() : array {
        $results = DB::queryOneColumn(FollowsTable::FOLLOWS_FIELD,
            "SELECT * from ".FollowsTable::TABLE_NAME." where ".FollowsTable::FOLLOWED_BY_FIELD." = %s", $this->username);
        return $results;
    }

    public function isRepost($post) : bool {
      $key = $post[PostsTable::POST_ID_FIELD];
      return array_key_exists($key, $this->reposts_array);
    }

    public function getReposts() : array {
      return $this->reposts_array;
    }

    public function collectReposts() : array {
      array_push($this->following_array, $this->username);
      $results = DB::query("SELECT * from ".LikeRepostTable::TABLE_NAME." where username in %ls", $this->following_array);
      array_pop($this->following_array);
      $returnArray = [];
      foreach($results as $result) {
        $returnArray[$result[LikeRepostTable::POST_ID_FIELD]] = $result;
      }
      return $returnArray;
    }

    function collectFollowers() : array {
        $results = DB::queryOneColumn(FollowsTable::FOLLOWED_BY_FIELD,
            "SELECT * from ".FollowsTable::TABLE_NAME." where ".FollowsTable::FOLLOWS_FIELD." = %s",
            $this->username);
        return $results;
    }
}

?>
