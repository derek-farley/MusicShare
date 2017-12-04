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
    private $likes; #int
    private $reposts; #int
    private $artist; #string
    private $songalbum; #string
    private $image; #string
    private $post_id; #int
    private $timestamp; # string
    private $isRepost;
    private $reposter;



    public function __construct(string $owner, string $artist, string $songalbum, string $song_url, string $image,
                                int $likes=0, int $reposts=0, string $timestamp=null, int $post_id=null,
                                $isRepost = false, $reposter=null) {
        $this->owner=$owner;
        $this->song_url=$song_url;
        $this->artist=$artist;
        $this->songalbum=$songalbum;
        $this->image=base64_encode($image); #base64 encode for displaying in img tag in html later
        if ($post_id === null) {
          $this->post_id = $this->getNextPostId();
        }
        else {
            $this->post_id = $post_id;
        }
        $this->reposts = $reposts;
        $this->likes = $likes;
        if ($timestamp === null) {
            $this->timestamp = date("h:i:sa");
        }
        else {
            $this->timestamp = $timestamp;
        }
        $this->isRepost = $isRepost;
        $this->reposter = $reposter;
    }

    public function __toString() {
        return "owner: ".$this->owner."song_url: ".$this->song_url." # of likes: ".$this->likes." # of reposts: ".$this->reposts."";
    }

    public function getAlbumArt() {
        return $this->image;
    }

    public function getNextPostId() {
        return DB::queryFirstField("Select MAX(".PostsTable::POST_ID_FIELD.") from ".PostsTable::TABLE_NAME.";") + 1;
    }

    public function displayPost($user) {
      $repostMessage = "";
      if ($this->isRepost) {
        $repostMessage = "&nbsp <i class=\"glyphicon glyphicon-refresh\"></i> by <strong>$this->reposter</strong>";
      }
        $display= <<<EOBODY
        <br>
      <div class="panel panel-default">
        <div class="panel-heading">
            <strong>$this->owner</strong> $repostMessage
        </div>
        <div class="panel-body">
            <div class="col-xs-6 col-md-6">
                <div class="row">
                    <div class="well">
                        <strong>Artist:</strong> $this->artist
                    </div>
                </div>
                <div class="row">
                    <div class="well">
                        <strong> Album/Song Name:</strong> $this->songalbum
                    </div>
                </div>
                <div class="row">
                    <div class="well">
                        <strong>Music Link:</strong> <a href=http://$this->song_url target="_blank">$this->song_url</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-6">
                <img src="data:image/jpeg;base64,$this->image"/><br><br>
                <form align="center">
                <input type="hidden" name="post_id" value="$this->post_id"/>
                    <strong>Likes:</strong> <span id="$this->post_id likes">$this->likes</span> <i class="glyphicon glyphicon-thumbs-up"></i>
EOBODY;
      if ($user->likesPost($this->post_id)) {
          $display = $display."<input type=\"button\" id=\"$this->post_id likeButton\" name=\"like Button\" 
                    style='background-color: PaleVioletRed;' value=\"Unlike\" class=\"btn btn-default button\" onclick=\"decrementLikes(this.form);\"/>
                </form>";
      }
      else {
          $display = $display."<input type=\"button\" id=\"$this->post_id likeButton\" name=\"like Button\" 
                            value=\"Like\" class=\"btn btn-default button\" onclick=\"incrementLikes(this.form);\"/>
                            </form>";
      }
      $display = $display."<form align=\"center\">
                    <input type=\"hidden\" name=\"post_id\" value=\"$this->post_id\"/>
                    <strong>Reposts:</strong> <span id=\"$this->post_id reposts\">$this->reposts</span> <i class=\"glyphicon glyphicon-refresh\"></i>";
      if ($user->didRepost($this->post_id)) {
          $display = $display."<input type=\"button\" id=\"$this->post_id repostButton\" name=\"repostButton\" value=\"Unrepost\" 
                    style='background-color: PaleVioletRed;' class=\"btn btn-default button\" onclick=\"decrementReposts(this.form);\"/>
                </form>";
      }
      else {
          $display = $display."<input type=\"button\" id=\"$this->post_id repostButton\" name=\"repostButton\" value=\"Repost\" 
                    class=\"btn btn-default button\" onclick=\"incrementReposts(this.form);\"/>
                </form>";
      }

      $bottom = <<<EOBODY
            </div>
        </div>
        <div class="panel-footer" align="center">
            <strong>$this->timestamp</strong>
        </div>
        </div><br><br>
EOBODY;


        return $display.$bottom;
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
        $post_id = $this->getNextPostId();
        DB::insert(PostsTable::TABLE_NAME, array(
            PostsTable::POST_ID_FIELD => $this->post_id,
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
            $post_array[PostsTable::SONGALBUM_FIELD], $post_array[PostsTable::URL_FIELD], $post_array[PostsTable::ALBUMART_FIELD],
            (int)$post_array[PostsTable::LIKES_FIELD], (int)$post_array[PostsTable::REPOSTS_FIELD], $post_array[PostsTable::TIMESTAMP_FIELD],
            (int)$post_array[PostsTable::POST_ID_FIELD]);
    }

    public static function createRepost($post_array) {
        return new Post($post_array[PostsTable::OWNER_FIELD], $post_array[PostsTable::ARTIST_FIELD],
            $post_array[PostsTable::SONGALBUM_FIELD], $post_array[PostsTable::URL_FIELD], $post_array[PostsTable::ALBUMART_FIELD],
            (int)$post_array[PostsTable::LIKES_FIELD], (int)$post_array[PostsTable::REPOSTS_FIELD], $post_array[PostsTable::TIMESTAMP_FIELD],
            (int)$post_array[PostsTable::POST_ID_FIELD][LikeRepostTable::POST_ID_FIELD], true,
            $post_array[PostsTable::POST_ID_FIELD][LikeRepostTable::USERNAME_FIELD]);
    }
}

?>
