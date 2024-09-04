function leftClick() {
    document.getElementById("btn").style.left = "0";
    document.getElementById("status").value = "A"; // Set status to Admin
}

function rightClick() {
    document.getElementById("btn").style.left = "50%";
    document.getElementById("status").value = "M"; // Set status to Member
}

function togglePassword() {
    var passwordField = document.getElementById("password");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}