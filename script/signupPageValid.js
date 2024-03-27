
function validateForm(e) {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    if (username.length < 4) {
        alert('Username must be at least 4 characters long.');
        e.preventDefault();
        return false;
    }
    if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        e.preventDefault();
        return false;
    }
    if (password.search(/[A-Z]/) < 0) {
        alert('Password must contain at least one uppercase letter.');
        e.preventDefault();
        return false;
    }
    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        e.preventDefault();
        return false;
    }
    if (password.includes(username)) {
        alert('Password cannot contain the username.');
        e.preventDefault();
        return false;
    }
    return true;
}