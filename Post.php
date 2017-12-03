<?php
  require_once "../support.php";
  require_once "../meekrodb.2.3.class.php";
  declare(strict_types=1);

  /**
  * Object representing posts of shared music by Users
  */

  class Post {
    private string $owner;
    private string $image
    private int $likes=0;
    private int $reposts=0;
    private string $artist;
    private string $album;
    private string $filepath;
    private static int $id=0;
    private string $timestamp


    public function __construct(string $owner, string $image, string $artist, string $album, string $filepath) {
        $this->owner=$owner;
        $this->image=$image;
        $this->artist=$artist;
        $this->album=$album;
        $this->filepath=$filepath;
        $this->id++;
        $this->timestamp=date("h:i:sa");
    }

    public function __toString() {
      return "owner: ".$this->owner."message: ".$this->message." # of likes: ".$this->likes." # of reposts: ".$this->reposts." filepath: ".$this->filepath."";

    }

    public function displayPost() {
      return "<table><tr><th>".$this->owner."</th></tr><tr><td>".$this->image."</td></tr>
      <tr><td> artist: ".$this->artist.", album; ".$this->album."</td></tr>
      <tr><td> Music link: <a href=\"".$this->filepath."\">".$this->filepath."</a></td></tr>
      <tr><td> Likes: ".$this->likes."</td></tr><tr><td> Reposts: ".$this->reposts."</td></tr></table>";
              //input buttons for likes and reposts, buttons call increment functions

    }

    public function incrementLikes(){
      $this->likes++;
    }

    public function incrementReposts(){
      $this->reposts++;
    }

    public function addPostToDb() {
      dbConfig();
      session_start();
      DB::insert(PostsTable::TABLE_NAME, array(
           PostsTable::POST_ID_FIELD => $this->id,
           PostsTable::TIMESTAMP_FIELD =>$this->timestamp,
           PostsTable::SONGALBUM_FIELD => $this->album, 
            PostsTable::ARTIST_FIELD => $this->artist, 
          PostsTable::LIKES_FIELD => $this->likes, 
          PostsTable::REPOSTS_FIELD => $this->reposts, 
          PostsTable::OWNER_FIELD => $this->owner, 
          PostsTable::ALBUMART_FIELD =>$this->image ));

    }

  }

?>
