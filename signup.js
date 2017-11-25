window.onsubmit=validate;


function validate() {
    var username=document.getElementById("new_username").value;
	var pwd = document.getElementById("new_pwd").value;
    var veripwd = document.getElementById("verify_pwd").value;

    var invalidMess = "";

     if(username.length<5){
        invalidMess="Username not long enough, try again.";
    }

    if(pwd!==veripwd){
    	invalidMess="Password doesn't match";
    }

        if(pwd.length<8){
        invalidMess="Password not long enough, try again.";
    }

    if (invalidMessages !== "") {
        alert(invalidMessages);
        return false;
    } else {
        var valuesProvided = "Do you want to continue with this new membership?";

        if (window.confirm(valuesProvided))
            return true;
        else
            return false;
    }
}
