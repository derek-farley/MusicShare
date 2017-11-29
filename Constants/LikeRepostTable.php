<?php
/**
 * Constants to be used for db ops involving the "likerepost" table
 */

class LikeRepostTable {
    const TABLE_NAME = "likerepost";
    const USERNAME_FIELD = "username"; # user that liked or reposted the post
    const POST_ID_FIELD = "post_id"; # id of the post that was liked or reposted
    const IS_LIKE_FIELD = "isLike"; # 0 if not a like, 1 if is a like
}