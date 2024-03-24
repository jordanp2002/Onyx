function validateForm() {
    var image = document.getElementById('image').value;
    var name = document.getElementById('name').value.trim();
    var lastname = document.getElementById('lastname').value.trim();
    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    if (!image) {
        alert('Please upload an image.');
        return false;
    }

    if (!name) {
        alert('Please enter your first name.');
        return false;
    }

    if (!lastname) {
        alert('Please enter your last name.');
        return false;
    }

    if (!email) {
        alert('Please enter your email.');
        return false;
    }

    if (!password) {
        alert('Please enter a password.');
        return false;
    }

    if (!confirmPassword) {
        alert('Please confirm your password.');
        return false;
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return false;
    }

    return true;
}