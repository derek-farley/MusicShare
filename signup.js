window.onsubmit=validate;

/* This function must return true or false */
/* If true the data will be sent to the server */
/* If false the data will not be sent to the server */
function validate() {
	var pwd = document.getElementById("newpwd").value;
    var veripwd = document.getElementById("verify_pwd").value;

    var invalidMess = "";
    if(pwd!==veripwd){
    	invalidMess="Password doesn't match";
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
