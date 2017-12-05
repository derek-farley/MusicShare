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

// function processNewPost(){
//     var formData = new FormData(document.querySelector("#newPost"));

//     var XHR = new XMLHttpRequest();

//     XHR.addEventListener("load", function(event) {
//       alert("Successful Post");
//     });

//     // Define what happens in case of error
//     XHR.addEventListener("error", function(event) {
//       alert('Oups! Something goes wrong.');
//     });

//     XHR.open("POST", "processNewPost.php");


//     //insert non-usereditable properties here e.g. formData.append("serialnumber", serialNumber++);
//     XHR.send(new FormData(formElement));
//     // var queryString = $('#newPost').serialize();
//     // alert(queryString);

//     return false;
// }



//PROCESS NEW POST
// window.addEventListener('load', function () {

//   // These variables are used to store the form data
//   var artist = document.getElementById("artist");
//   var album = document.getElementById("album");
//   var song = document.getElementById("song");
//   var file = {
//         dom    : document.getElementById("image"),
//         binary : null
//       };
 
//   // Use the FileReader API to access file content
//   var reader = new FileReader();

//   // Because FileReader is asynchronous, store its
//   // result when it finishes to read the file
//   reader.addEventListener("load", function () {
//     file.binary = reader.result;
//   });

//   // At page load, if a file is already selected, read it.
//   if(file.dom.files[0]) {
//     reader.readAsBinaryString(file.dom.files[0]);
//   }

//   // If not, read the file once the user selects it.
//   file.dom.addEventListener("change", function () {
//     if(reader.readyState === FileReader.LOADING) {
//       reader.abort();
//     }
    
//     reader.readAsBinaryString(file.dom.files[0]);
//   });

//   // sendData is our main function
//   function sendData() {
//     // If there is a selected file, wait it is read
//     // If there is not, delay the execution of the function
//     if(!file.binary && file.dom.files.length > 0) {
//       setTimeout(sendData, 10);
//       return;
//     }

//     // To construct our multipart form data request,
//     // We need an XMLHttpRequest instance
//     var XHR = new XMLHttpRequest();

//     // We need a separator to define each part of the request
//     var boundary = "blob";

//     // Store our body request in a string.
//     var data = "";

//     // So, if the user has selected a file
//     if (file.dom.files[0]) {
//       // Start a new part in our body's request
//       data += "--" + boundary + "\r\n";

//       // Describe it as form data
//       data += 'content-disposition: form-data; '
//       // Define the name of the form data
//             + 'name="'         + file.dom.name          + '"; '
//       // Provide the real name of the file
//             + 'filename="'     + file.dom.files[0].name + '"\r\n';
//       // And the MIME type of the file
//       data += 'Content-Type: ' + file.dom.files[0].type + '\r\n';

//       // There's a blank line between the metadata and the data
//       data += '\r\n';
      
//       // Append the binary data to our body's request
//       data += file.binary + '\r\n';
//     }

//     // Text data is simpler
//     // Start a new part in our body's request
//     data += "--" + boundary + "\r\n";

//     // Say it's form data, and name it
//     data += 'content-disposition: form-data; name="' + artist.name + '"\r\n';
//     // There's a blank line between the metadata and the data
//     data += '\r\n';

//     // Append the text data to our body's request
//     data += artist.value + "\r\n";

//     // Once we are done, "close" the body's request
//     data += "--" + boundary + "--";
//     data += 'content-disposition: form-data; name="' + album.name + '"\r\n';
//     // There's a blank line between the metadata and the data
//     data += '\r\n';

//     // Append the text data to our body's request
//     data += album.value + "\r\n";

//     // Once we are done, "close" the body's request
//     data += "--" + boundary + "--";
//     data += 'content-disposition: form-data; name="' + song.name + '"\r\n';
//     // There's a blank line between the metadata and the data
//     data += '\r\n';

//     // Append the text data to our body's request
//     data += song.value + "\r\n";

//     // Once we are done, "close" the body's request
//     data += "--" + boundary + "--";

//     // Define what happens on successful data submission
// XHR.onreadystatechange = function() {
//   if (this.readyState == 4 && this.status == 200) {
//     alert("what");
//   }
// };

//     // Define what happens in case of error
//     XHR.addEventListener('error', function(event) {
//       alert('Oups! Something went wrong.');
//     });

//     // Set up our request
//     XHR.open('POST', 'processNewPost.php');

//     // Add the required HTTP header to handle a multipart form data POST request
//     XHR.setRequestHeader('Content-Type','multipart/form-data; boundary=' + boundary);
//     console.log(data);
//     // And finally, send our data.
//     XHR.send(data);
//   }

//   // Access our form...
//   var form = document.getElementById("newPost");

//   // ...to take over the submit event
//   form.addEventListener('submit', function (event) {
//     event.preventDefault();
//     sendData();
//   });
// });



function processProgress(requestObj) {
    if (requestObj.readyState === 4) {
        if (requestObj.status === 200) {
            /* retrieving response */
            let results = requestObj.responseText;
            console.log(results);
        }
    }
}
