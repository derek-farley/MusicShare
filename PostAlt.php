<?php

  /**
  * Object representing posts of shared music by Users
  */

  class Post {
    private  $owner;
    private  $image;
    private  $likes=0;
    private  $reposts=0;
    private  $artist;
    private  $album;
    private  $filepath;
    private  $timestamp;


    public function __construct($owner, $artist,  $album, $image) {
        $this->owner=$owner;
        $this->artist=$artist;
        $this->album=$album;
        $this->image=$image;
        $this->timestamp=date("h:i:sa");
    }
        public function displayPost() {
      $display= "<table><tr><th>".$this->owner."</th></tr>"."<tr><td> artist: ".$this->artist.", album; ".$this->album."</td></tr>
      <tr><td> Music link: <a href=\"".$this->filepath."\">".$this->filepath."</a></td></tr>
      <tr><td> Likes: ".$this->likes."</td></tr><tr><td> Reposts: ".$this->reposts."</td></tr></table>"."
      <input type=\"submit\" name=\"likeButton\" value=\"Like\" /><br/>
      <input type=\"submit\" name=\"repostButton\" value=\"Repost\" /><br/>
      </form>";
      $display .= '<img src="data:image/jpeg;base64,'.base64_encode($this->$image).'"/>';

      if(array_key_exists('likeButton',$_POST)){
        incrementLikes();
      }

      if(array_key_exists('repostButton',$_POST)){
        incrementReposts();
      }

      return $display;
    }
  }



?>
