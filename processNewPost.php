<?php
require_once "User.php";
require_once "meekrodb.2.3.class.php";
require_once "support.php";
require_once "Post.php";

includeConstants();
dbConfig();
if (!isset($_SESSION['user']))
    session_start();

if (isset($_POST['artist']))
{
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $song = $_POST['song'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "Sorry, there was an error uploading your file.";
            }

            $imgloc = $target_file; 
            $image = fopen($imgloc, 'rb'); 
            $imageContent = fread($image, filesize($imgloc));
            //echo '<img src="data:image/jpeg;base64,'.$imgur.'"/>';
            $_SESSION['nine'] = $imageContent;
    if (isset($_SESSION["userObject"]))
        $user = $_SESSION['userObject'];
    $post = new Post($user->getUserName() , $artist, $album , $song , $imageContent);
    $user->addPost($post);
    //update backend

    DB::insert(PostsTable::TABLE_NAME, array(
            PostsTable::POST_ID_FIELD => $post->getPostID(),
            PostsTable::TIMESTAMP_FIELD => $post->getTimeStamp(),
            PostsTable::SONGALBUM_FIELD => $post->getAlbumName(),
            PostsTable::ARTIST_FIELD => $post->getArtist(),
            PostsTable::LIKES_FIELD => $post->getLikes(),
            PostsTable::REPOSTS_FIELD => $post->getReposts(),
            PostsTable::OWNER_FIELD => $post->getOwner(),
            PostsTable::ALBUMART_FIELD => $post->getAlbumArt(),
            PostsTable::URL_FIELD => $post->getURL()
        ));


}

$_SESSION['userObject'] = $user;

?>

