<?php
  declare(strict_types=1);
  require_once "support.php";
  require_once "meekrodb.2.3.class.php";
 
  /**
  * Object representing posts of shared music by Users
  */

  class Post {
    private $owner; #string
    private $song_url; #string
    private $likes=0; #int
    private $reposts=0; #int
    private $artist; #string
    private $album; #string
    private $image; #string
    private static $id=0; #int
    private $timestamp; # string


    public function __construct(string $owner, string $artist, string $album, string $song_url, string $image) {
        $this->owner=$owner;
        $this->song_url=$song_url;
        $this->artist=$artist;
        $this->album=$album;
        $this->image=$image;
        Post::$id++;
        $this->timestamp=date("h:i:sa");
    }

    public function __toString() {
      return "owner: ".$this->owner."song_url: ".$this->song_url." # of likes: ".$this->likes." # of reposts: ".$this->reposts."";
    }

    public function displayPost() {
      $display= "<table><tr><th>".$this->owner."</th></tr><tr><td>".'<img src="data:image/jpeg;base64,'.base64_encode($this->image).'"/>'."</td></tr>
      <tr><td> artist: ".$this->artist.", album; ".$this->album."</td></tr>
      <tr><td> Music link: <a href=\"".$this->song_url."\">".$this->song_url."</a></td></tr>
      <tr><td> Likes: ".$this->likes."</td></tr><tr><td> Reposts: ".$this->reposts."</td></tr></table>
      <form method=\"post\">
      <input type=\"submit\" name=\"likeButton\" value=\"Like\" /><br/>
      <input type=\"submit\" name=\"repostButton\" value=\"Repost\" /><br/>
      </form>";

      if(array_key_exists('likeButton',$_POST)){
        incrementLikes();
      }

      if(array_key_exists('repostButton',$_POST)){
        incrementReposts();
      }

      return $display;
    }

    public function incrementLikes(){
      $this->likes++;
      //somehow add post and the liking user to LikeRepostTable
    }

    public function incrementReposts(){
      $this->reposts++;
      //somehow add post and Reposting user to LikeRepostTable
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
          PostsTable::ALBUMART_FIELD =>$this->image,
            PostsTable::URL_FIELD =>$this->song_url,));

    }

  }

?>
