var $ = function (id) {
    return document.getElementById(id);
}

function checkPassword() {

    var password = parseFloat($("password").value); 
    var verify_password = parseFloat($("verify_password").value);

    if (password !== verify_password) {
        alert("Password fields do not match");
        return false;
    }

    return true;
};