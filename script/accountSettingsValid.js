 // Function to toggle form visibility
 function toggleForm() {
    var form = document.getElementById('editAccountForm');
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

// Function to validate the form
function validateForm() {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();

    // Perform validation checks
    if (username === '') {
        alert('Please enter a username.');
        return false;
    }

    if (email === '') {
        alert('Please enter an email address.');
        return false;
    } else if (!isValidEmail(email)) {
        alert('Please enter a valid email address.');
        return false;
    }

    if (password === '') {
        alert('Please enter a password.');
        return false;
    }

    if (confirmPassword === '') {
        alert('Please confirm your password.');
        return false;
    } else if (password !== confirmPassword) {
        alert('Passwords do not match. Please re-enter your password.');
        return false;
    }

    // If all checks pass, form is valid
    return true;
}

// Function to validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Event listener for form submission
document.getElementById('editAccountForm').addEventListener('submit', function(event) {
    if (!validateForm()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});