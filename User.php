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

    public function __construct(string $user_name) {
      $this->username = $user_name;
      $this->follower_array = $this->collectFollowers();
      $this->following_array = $this->collectFollowing();
      $this->posts_array = $this->collectPosts();
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
              "SELECT * from ".PostsTable::TABLE_NAME." where ".PostsTable::OWNER_FIELD." in %ls order by ".PostsTable::TIMESTAMP_FIELD,
              $this->following_array);
          array_pop($this->following_array);
          return $results;
      }

      public function collectFollowing() : array {
          $results = DB::queryOneColumn(FollowsTable::FOLLOWS_FIELD,
              "SELECT * from ".FollowsTable::TABLE_NAME." where ".FollowsTable::FOLLOWED_BY_FIELD." = %s", $this->username);
          return $results;
      }

      function collectFollowers() : array {
          $results = DB::queryOneColumn(FollowsTable::FOLLOWED_BY_FIELD,
              "SELECT * from ".FollowsTable::TABLE_NAME." where ".FollowsTable::FOLLOWS_FIELD." = %s",
              $this->username);
          return $results;
      }
  }

?>
