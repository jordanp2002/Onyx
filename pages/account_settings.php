<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/account_settings.css">
</head>
<?php
    session_start();
?>
<div class="headernav">
    <header>
        <h1>Twitter</h1>
    </header>
    <nav>
        <ul>
            <li><?php echo $_SESSION['username']; ?><li>
            <li><a href="../pages/SearchPage.php">Search</a></li>
            <li>
                <div class = "parent-item">
                    <a href="../pages/CommunitiesPage.php">Communities</a>
                    <ul class="dropdown">
                        <li class="item"><a href="#">Create Community</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class = "parent-item">
                    <a href="../pages/account_page.php">Account</a>
                    <ul class="dropdown">
                        <li class="item"><a href="../pages/account_settings.php">Manage Account</a></li>
                        <li class="item"><a href="../pages/manage_friends.php">Friends</a></li>
                        <li class="item"><a href="../pages/saved_posts.php">Saved Posts</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </nav>
</div>
<body>
    <h1>Settings</h1>
    <div class="button-container">
        <button id="editImageBtn">Edit Profile Picture</button>
        <button id="editUsernameBtn">Edit Username</button>
        <button id="editPasswordBtn">Edit Password</button>
    </div>
    <div id="imagePopup" class="modal">
        <div class="popup-content">
            <span class="close" data-modal="imageModal">&times;</span>
            <form action="updatesettings.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="updateProfilePicture">
                <label for="newUsername">New Image: </label>
                <input type="file" id="newProfilePicture" name="newProfilePicture" required>
                <button type="submit">Update Profile Picture</button>
            </form>
        </div>
    </div>

    <div id="usernamePopup" class="modal">
        <div class="popup-content">
            <span class="close" data-modal="usernameModal">&times;</span>
            <form action="updatesettings.php" method="POST">
                <input type="hidden" name="action" value="updateUsername">
                <label for="newUsername">New Username:</label>
                <input type="text" id="newUsername" name="newUsername" required>
                <button type="submit">Update Username</button>
            </form>
        </div>
    </div>

    <div id="passwordPopup" class="modal">
        <div class="popup-content">
            <span class="close" data-modal="passwordModal">&times;</span>
            <form action="updatesettings.php" method="POST">
                <input type="hidden" name="action" value="updatePassword">
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="newPassword" required>
                <button type="submit">Update Password</button>
            </form>
        </div>
    </div>
</body>
<script>
document.getElementById('editUsernameBtn').onclick = function() {
    document.getElementById('usernamePopup').style.display = 'block';
};
document.getElementById('editPasswordBtn').onclick = function() {
    document.getElementById('passwordPopup').style.display = 'block';
};
document.getElementById('editImageBtn').onclick = function() {
    document.getElementById('imagePopup').style.display = 'block';
};
document.querySelectorAll('.close').forEach(closeBtn => {
    closeBtn.onclick = function() {
        document.getElementById(this.getAttribute('data-modal')).style.display = 'none';
    };
});
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = 'none';
    }
};

// Client-side validations
document.getElementById('usernamePopup form').onsubmit = function(event) {
    var newUsername = document.getElementById('newUsername').value.trim();
    if (newUsername.length < 4) {
        alert('Username must be at least 4 characters long.');
        event.preventDefault();
    }
};

document.getElementById('passwordPopup form').onsubmit = function(event) {
    var newPassword = document.getElementById('newPassword').value.trim();
    var oldPassword = document.getElementById('oldPassword').value.trim();
    var username = document.querySelector('.headernav header li').innerText.trim();
    
    if (newPassword.length < 8) {
        alert('Password must be at least 8 characters long.');
        event.preventDefault();
        return;
    }

    if (!/[A-Z]/.test(newPassword)) {
        alert('Password must contain at least one uppercase letter.');
        event.preventDefault();
        return;
    }

    if (newPassword.includes(username)) {
        alert('Password cannot contain the username.');
        event.preventDefault();
        return;
    }
};

</script>

</html>