window.onsubmit = validate;

function validate() {

    let username=document.getElementById("new_username").value;
    let pwd = document.getElementById("new_pwd").value;
    let verifypwd = document.getElementById("verify_pwd").value;
    let invalidMessages = "";

    if (username.length < 5) {
        console.log("username too short");
        invalidMessages += "<strong>Username not long enough; it must be at least 5 characters<br/></strong>";
    }

    if (pwd !== verifypwd) {
        console.log("password not equal");
        invalidMessages += "<strong>Passwords don't match<br/></strong>";
    }

    if (pwd.length < 8) {
        console.log("password too short");
        invalidMessages +="<strong>Passwords must be at least 8 characters long<br/></strong>";
    }

    invalidMessages += lookupUser(username, invalidMessages);
    if (invalidMessages !== "") {
        document.getElementById("errorText").innerHTML = invalidMessages;
        console.log(invalidMessages);
        return false;
    } else {
        let valuesProvided = "Are you sure you'd like to use these credentials? You won't be able to change your " +
            "username once confirmed.";

        window.confirm(valuesProvided);
    }
}

function lookupUser(username) {
    /*
    Ajax synchronous request for back end query of provided username to ensure not already taken
     */
    let requestObj = new XMLHttpRequest();

    let scriptUrl = "verifyUser.php";
    scriptUrl += "?username=";
    scriptUrl += username;
    let randomValueToAvoidCache = (new Date()).getTime();
    scriptUrl += "&randomValue=" + randomValueToAvoidCache;

    let asynch = false; // synchronous
    requestObj.open("GET", scriptUrl, asynch); // (will wait for response)

    requestObj.send(null);
    /* processing response */
    if (requestObj.status === 200) {
        let answer = requestObj.responseText;
        if (answer !== null) {
            console.log(answer);
            return answer;
        }
    } else {
        alert("Request Failed. " + requestObj.status);
    }
}
