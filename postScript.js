function incrementLikes(form) {
    console.log(form.elements.namedItem("post_id").value);
    let post_id = form.elements.namedItem("post_id").value;
    console.log(document.getElementById(post_id + " likes").innerHTML);
    let currLikes = parseInt(document.getElementById(post_id + " likes").innerHTML);
    document.getElementById(post_id + " likes").innerHTML = String(currLikes+1);
    changeLikeButton(post_id);
    updateDatabase("like");
}

function decrementLikes(form) {
    console.log(form.elements.namedItem("post_id").value);
    let post_id = form.elements.namedItem("post_id").value;
    console.log(document.getElementById(post_id + " likes").innerHTML);
    let currLikes = parseInt(document.getElementById(post_id + " likes").innerHTML);
    document.getElementById(post_id + " likes").innerHTML = String(currLikes-1);
    changeUnlikeButton(post_id);
    updateDatabase("unlike");
}

function incrementReposts(form) {
    console.log(form.elements.namedItem("post_id").value);
    let post_id = form.elements.namedItem("post_id").value;
    console.log(document.getElementById(post_id + " reposts").innerHTML);
    let currReposts = parseInt(document.getElementById(post_id + " reposts").innerHTML);
    document.getElementById(post_id + " reposts").innerHTML = String(currReposts+1);
    changeRepostButton(post_id);
    updateDatabase("repost");
}

function decrementReposts(form) {
    console.log(form.elements.namedItem("post_id").value);
    let post_id = form.elements.namedItem("post_id").value;
    console.log(document.getElementById(post_id + " reposts").innerHTML);
    let currReposts = parseInt(document.getElementById(post_id + " reposts").innerHTML);
    document.getElementById(post_id + " reposts").innerHTML = String(currReposts-1);
    changeUnrepostButton(post_id);
    updateDatabase("unrepost");
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

function updateDatabase(post_id, operation) {
    var scriptURL = "updateDatabase.php";

    /* adding name to url */
    var name = document.getElementById("name").value;
    scriptURL += "?postid=" + post_id;

    scriptURL += "&operation=" + operation;
    /* adding random value to url to avoid cache */
    var randomValueToAvoidCache = (new Date()).getTime();
    scriptURL += "&randomValue=" + randomValueToAvoidCache;

    var asynch = true; // asynchronous
    requestObj.open("GET", scriptURL, asynch);
    /* sending request */
    requestObj.send(null);
}
