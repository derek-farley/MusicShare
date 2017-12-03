<?php
/**
 * Constants to be used for database ops involving "posts" table
 */

class PostsTable {
    const TABLE_NAME = "posts";
    const POST_ID_FIELD = "post_id"; # id of the post
    const TIMESTAMP_FIELD = "timestamp"; # timestamp of when post was made
    const SONGALBUM_FIELD = "songalbumname"; # the song or album name of the post
    const ARTIST_FIELD = "artistname"; # the artist of the song/album in the post
    const LIKES_FIELD = "likes"; # number of likes on the post
    const REPOSTS_FIELD = "reposts"; # number of reposts on the post
    const OWNER_FIELD = "owner"; # user that made the post
    const ALBUMART_FIELD = "albumart"; # blob (binary data) image of the album art
    const URL_FIELD = "url";
}