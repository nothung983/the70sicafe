function removeAscent(str) {
    if (str === null || str === undefined) return str;
    str = str.toUpperCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    return str;
}
var usernameInput = document.getElementById("name");
var phoneInput = document.getElementById("phone");
var emailInput = document.getElementById("email");
var password = document.getElementById("pass"),
 confirm_password = document.getElementById("cpass");

function passValid(string) {
    var re = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/
    return re.test(string)
}

function validatePassword() {
    if (!passValid(password.value)) {
        password.setCustomValidity(
            "Password must be 8 characters (including letters and numbers, at least 1 capital letter and 1 special character)");
    } else {
        password.setCustomValidity('');
    }
    if (password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Unmatched Password");
    } else {
        confirm_password.setCustomValidity('');
    }
}

function usernameValid(string) {
    var re = /^[a-zA-Z !@#\$%\^\&*\)\(+=._-]{2,}$/g;
    return re.test(removeAscent(string));
}

function validateUsername() {
    if (!usernameValid(fullnameInput.value)) {
        usernameInput.setCustomValidity("Name from 2 characters, no special characters, no numbers");
    } else {
        usernameInput.setCustomValidity('');
    }
}

function phonevalid(string) {
    var re = /^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/
    return re.test(string)
}

function validatePhone() {
    if (!phonevalid(phoneInput.value)) {
        phoneInput.setCustomValidity("Invalid phone number");
    } else {
        phoneInput.setCustomValidity('');
    }
}

function emailValid(string) {
    var re = /^\S+@\S+\.\S+$/
    return re.test(string)
}

function validateEmail() {
    if (!emailValid(emailInput.value)) {
        emailInput.setCustomValidity("Invalid email");
    } else {
        emailInput.setCustomValidity('');
    }
}

usernameInput.onkeyup = validateUsername;
emailInput.onkeyup = validateEmail;
phoneInput.onkeyup = validatePhone;
password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;