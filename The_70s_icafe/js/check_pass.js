var new_password = document.getElementById("new_pass"),
    confirm_password = document.getElementById("confirm_pass");


function passValid(string) {
    var re = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/
    return re.test(string)
}

function validatePassword() {
    if (!passValid(new_password.value)) {
        new_password.setCustomValidity(
            "Password must be 8 characters (including letters and numbers, at least 1 capital letter and 1 special character)");
    } else {
        new_password.setCustomValidity('');
    }
    if (new_password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Unmatched Password");
    } else {
        confirm_password.setCustomValidity('');
    }
}

new_password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;