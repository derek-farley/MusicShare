window.onsubmit=validate;


function validate() {
	var pwd = document.getElementById("new_pwd").value;
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
