function incrementLikes(form) {
    console.log(form.elements.namedItem("post_id").value);
    let post_id = form.elements.namedItem("post_id").value;
    console.log(document.getElementById(post_id + " likes").innerHTML);
    let currLikes = parseInt(document.getElementById(post_id + " likes").innerHTML);
    let newLikes = currLikes + 1;
    document.getElementById(post_id + " likes").innerHTML = String(newLikes);
    changeLikeButton(post_id);
    updateDatabase(post_id, "like", newLikes);
}

function decrementLikes(form) {
    console.log(form.elements.namedItem("post_id").value);
    let post_id = form.elements.namedItem("post_id").value;
    console.log(document.getElementById(post_id + " likes").innerHTML);
    let currLikes = parseInt(document.getElementById(post_id + " likes").innerHTML);
    let newLikes = currLikes - 1;
    document.getElementById(post_id + " likes").innerHTML = String(newLikes);
    changeUnlikeButton(post_id);
    updateDatabase(post_id, "unlike", newLikes);
}

function incrementReposts(form) {
    console.log(form.elements.namedItem("post_id").value);
    let post_id = form.elements.namedItem("post_id").value;
    console.log(document.getElementById(post_id + " reposts").innerHTML);
    let currReposts = parseInt(document.getElementById(post_id + " reposts").innerHTML);
    let newReposts = currReposts + 1;
    document.getElementById(post_id + " reposts").innerHTML = String(newReposts);
    changeRepostButton(post_id);
    updateDatabase(post_id, "repost", newReposts);
}

function decrementReposts(form) {
    console.log(form.elements.namedItem("post_id").value);
    let post_id = form.elements.namedItem("post_id").value;
    console.log(document.getElementById(post_id + " reposts").innerHTML);
    let currReposts = parseInt(document.getElementById(post_id + " reposts").innerHTML);
    let newReposts = currReposts - 1;
    document.getElementById(post_id + " reposts").innerHTML = String(newReposts);
    changeUnrepostButton(post_id);
    updateDatabase(post_id, "unrepost", newReposts);
}

function changeLikeButton(post_id) {
    document.getElementById(post_id + " likeButton").value = "Unlike";
    document.getElementById(post_id + " likeButton").style.backgroundColor = "PaleVioletRed";
    document.getElementById(post_id + " likeButton").onclick = function() { decrementLikes(this.form)};
}

function changeUnlikeButton(post_id) {
    document.getElementById(post_id + " likeButton").value = "Like";
    document.getElementById(post_id + " likeButton").style.backgroundColor = "#4CAF50";
    document.getElementById(post_id + " likeButton").onclick = function() { incrementLikes(this.form)};
}


function changeRepostButton(post_id) {
    document.getElementById(post_id + " repostButton").value = "Unrepost";
    document.getElementById(post_id + " repostButton").style.backgroundColor = "PaleVioletRed";
    document.getElementById(post_id + " repostButton").onclick = function() { decrementReposts(this.form)};
}

function changeUnrepostButton(post_id) {
    document.getElementById(post_id + " repostButton").value = "Repost";
    document.getElementById(post_id + " repostButton").style.backgroundColor = "#4CAF50";
    document.getElementById(post_id + " repostButton").onclick = function() { incrementReposts(this.form)};
}

function followUser(form) {
    console.log(form.elements.namedItem("following").value);
    let followedUser = form.elements.namedItem("following").value;
    changeFollowButton();
    updateDatabase(null, "follow", followedUser);
}

function changeFollowButton() {
    document.getElementById("followButton").value = "Unfollow";
    document.getElementById("followButton").style.backgroundColor = "PaleVioletRed";
    document.getElementById("followButton").onclick = function() { unfollowUser(this.form)};
}

function unfollowUser(form) {
    console.log(form.elements.namedItem("following").value);
    let unfollowedUser = form.elements.namedItem("following").value;
    changeUnfollowButton();
    updateDatabase(null, "unfollow", unfollowedUser);
}

function changeUnfollowButton() {
    document.getElementById("followButton").value = "Follow";
    document.getElementById("followButton").style.backgroundColor = "#4CAF50";
    document.getElementById("followButton").onclick = function() { followUser(this.form)};
}

function updateDatabase(post_id, operation, newValue) {
    console.log("updating db");
    let requestObj = new XMLHttpRequest();
    let scriptURL = "updateDatabase.php";

    if (post_id !== null) {
        scriptURL += "?postid=" + post_id;
        scriptURL += "&operation=" + operation;
    }
    else {
        scriptURL += "?operation=" + operation;
    }

    scriptURL += "&newValue=" + newValue;
    /* adding random value to url to avoid cache */
    let randomValueToAvoidCache = (new Date()).getTime();
    scriptURL += "&randomValue=" + randomValueToAvoidCache;

    let asynch = true; // asynchronous
    requestObj.open("GET", scriptURL, asynch);
    /* sending request */
    requestObj.onreadystatechange = function() { processProgress(requestObj)};
    requestObj.send(null);
}


function processProgress(requestObj) {
    if (requestObj.readyState === 4) {
        if (requestObj.status === 200) {
            /* retrieving response */
            let results = requestObj.responseText;
            console.log(results);
        }
    }
}
