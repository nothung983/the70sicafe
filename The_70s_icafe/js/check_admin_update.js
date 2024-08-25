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

var new_password = document.getElementById("new_pass"),
    confirm_password = document.getElementById("confirm_pass");
var Admin_name = document.getElementById("name");

function Admin_nameValid(string) {
    var re = /^[a-zA-Z !@#\$%\^\&*\)\(+=._-]{2,}$/g;
    return re.test(removeAscent(string));
}
  
function validateAdmin_name() {
    // Check if admin name is empty
    if (!Admin_nameValid(fullnameInput.value)) {
        Admin_nameInput.setCustomValidity("Name from 2 characters, no special characters, no numbers");
    } else {
        Admin_nameInput.setCustomValidity('');
    }
}
  
  
function passValid(string) {
    var re = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/
    return re.test(string)
}

function validatePassword() {
    // Check if password is empty
    if (!passValid(new_password.value)) {
        new_password.setCustomValidity(
            "Password must be 8 characters (including letters and numbers, at least 1 capital letter and 1 special character)");
    } else {
        new_password.setCustomValidity('');
    }
    // Check if password and confirm password match
    if (new_password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Unmatched Password");
    } else {
        confirm_password.setCustomValidity('');
    }
}

Admin_nameInput.onkeyup = validateAdmin_name;
new_password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;