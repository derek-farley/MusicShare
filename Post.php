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
    private $songalbum; #string
    private $image; #string
    private static $id=0; #int
    private $timestamp; # string


    public function __construct(string $owner, string $artist, string $songalbum, string $song_url, string $image) {
        $this->owner=$owner;
        $this->song_url=$song_url;
        $this->artist=$artist;
        $this->songalbum=$songalbum;
        $this->image=base64_encode($image); #base64 encode for displaying in img tag in html later
        Post::$id++;
        $this->timestamp=date("h:i:sa");
    }

    public function __toString() {
      return "owner: ".$this->owner."song_url: ".$this->song_url." # of likes: ".$this->likes." # of reposts: ".$this->reposts."";
    }

    public function getAlbumArt() {
      return $this->image;
    }

    public function displayPost() {
      $post_id = Post::$id;
      $display= <<<EOBODY
      <div class="panel panel-default">
        <table><tr><th>$this->owner</th></tr><tr><td><img src="data:image/jpeg;base64,$this->image" height="50" width="50"/></td></tr>
        <tr><td> artist: $this->artist, album: $this->songalbum</td></tr>
        <tr><td> Music link: <a href=$this->song_url>$this->song_url</a></td></tr>
        <tr><td> Likes: $this->likes."</td></tr><tr><td> Reposts: $this->reposts</td></tr></table>
        <form method="post" >
        <input type="submit" name="likeButton" value="Like" /><br/>
        <input type="submit" name="repostButton" value="Repost" /><br/>
        <input type="hidden" name="post_id" value=$post_id/>
        </form>
      </div>
EOBODY;

      if(array_key_exists('likeButton',$_POST)){
        $this->incrementLikes();
      }

      if(array_key_exists('repostButton',$_POST)){
        $this->incrementReposts();
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
           PostsTable::POST_ID_FIELD => Post::$id,
           PostsTable::TIMESTAMP_FIELD =>$this->timestamp,
           PostsTable::SONGALBUM_FIELD => $this->songalbum,
            PostsTable::ARTIST_FIELD => $this->artist, 
          PostsTable::LIKES_FIELD => $this->likes, 
          PostsTable::REPOSTS_FIELD => $this->reposts, 
          PostsTable::OWNER_FIELD => $this->owner, 
          PostsTable::ALBUMART_FIELD =>$this->image,
            PostsTable::URL_FIELD =>$this->song_url,));

    }

    public static function createPost($post_array) {
      return new Post($post_array[PostsTable::OWNER_FIELD], $post_array[PostsTable::ARTIST_FIELD],
          $post_array[PostsTable::SONGALBUM_FIELD], $post_array[PostsTable::URL_FIELD], $post_array[PostsTable::ALBUMART_FIELD]);
  }

  }

?>
