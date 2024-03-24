function validateForm() {
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // Check if username is empty
    if (username.trim() === "") {
        alert("Please enter a username");
        return false;
    }

    // Check if email is empty and is a valid email format
    if (email.trim() === "") {
        alert("Please enter an email");
        return false;
    } else if (!validateEmail(email)) {
        alert("Please enter a valid email");
        return false;
    }

    // Check if password is empty
    if (password.trim() === "") {
        alert("Please enter a password");
        return false;
    }

    // If all validations pass, submit the form
    document.getElementById("profileForm").submit();
}

// Function to validate email format
function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}