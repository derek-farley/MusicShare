window.onsubmit=validate;

/* This function must return true or false */
/* If true the data will be sent to the server */
/* If false the data will not be sent to the server */
function validate() {
	var pwd = document.getElementById("pwd").value;
    var veripwd = document.getElementById("veri_pwd").value;

    var invalidMess = "";
    if(pwd!==veripwd){
    	invalidMess="Password doesn't match";
    }

    if (invalidMessages !== "") {
        alert(invalidMessages);
        return false;
    } else {
        var valuesProvided = "Do you want to submit the form data";
        
        if (window.confirm(valuesProvided))
            return true;
        else    
            return false;
    }
}