function validate() {
	var username = document.getElementById("username").value;
    var pwd = document.getElementById("pwd").value;

    var invalidMessages = "";
    if(username.length<5){
    	invalidMess="Incorrect username: not enough characters.";
    }

		if(pwd.length<8){
    	invalidMess="Incorrect password: not enough characters.";
    }

    if (invalidMessages !== "") {
        alert(invalidMessages);
        return false;
    } else {
        var valuesProvided = "Is the information entered correct?";

        if (window.confirm(valuesProvided))
            return true;
        else
            return false;
    }
}
