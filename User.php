<?php
  declare(strict_types=1);

  /**
  * MusicShare user class
  */

  class User {
    private $user_id;
    private $user_name;
    private $email_address;
    private $follower_array;
    private $following_array;
    private $posts_array;

    public function __construct(string $user_id, string $user_name,
      string $email_address, array $follower_array, array $following_array) {
      this->user_name = $user_name;
      this->user_id  = $user_id;
      this->email_address = $email_address;
      this->follower_array = $follower_array;
      this->following_array = $following_array;
    }

    public function __toString() {
      return "Username ".$user_name.",id ".$user_id.",email ".$email_address." with "
        .count($follower_array)." followers and following ".count($following_array);
    }

    public function getUserId() ; string {
      return this->user_id;
    }

    public function getUserName() : string {
      return this->user_name;
    }

    public function getEmailAddress() : string{
      return this->email_address;
    }

    public function getFollowers() : array {
      return this->follower_array;
    }

    public function getFollowing() : array {
      return this->following_array;
    }

    public function addFollower(User user) {
      this->follower_array[] = user;
    }

    public function addFollowing(User user) {
      this->following_array[] = user;
    }

  }

?>
