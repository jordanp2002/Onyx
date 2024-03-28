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
        <h1>Onyx</h1>
    </header>
    <nav>
        <ul>
            <?php
                include 'databaseconnection.php';
                $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

                if (!$connection) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                if(!isset($_SESSION['username']) && empty($_SESSION['username'])) {
                    header("Location: ../pages/login.php");
                }
            
                if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                    $adminQuery = "SELECT * FROM Account WHERE username = ?";
                    $adminQ = mysqli_prepare($connection, $adminQuery);
                    mysqli_stmt_bind_param($adminQ, "s", $_SESSION['username']);
                    mysqli_stmt_execute($adminQ);
                    $accountResult = mysqli_stmt_get_result($adminQ);
                    $row = mysqli_fetch_assoc($accountResult);
                    $admin = $row['admin'];
                }
            ?>
            <li><?php echo $_SESSION['username']; ?><li>
            <li><a href="../pages/SearchPage.php">Search</a></li>
            <li>
                <div class = "parent-item">
                    <a href="../pages/CommunitiesPage.php">Communities</a>
                    <ul class="dropdown">
                        <li class="item"><a href="../pages/createcommunity.php">Create Community</a></li>
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
                        <?php
                        if($admin == 1){
                            echo "<li class='item'><a href='../pages/admin.php'>Admin</a></li>";
                        }
                        ?>
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
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = "flex";
    }
}
function closeModal() {
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        modal.style.display = "none"; 
    });
}
document.getElementById("editImageBtn").onclick = function() { 
    openModal("imagePopup");
};
document.getElementById("editUsernameBtn").onclick = function() {
     openModal("usernamePopup"); 
    };
document.getElementById("editPasswordBtn").onclick = function() { 
    openModal("passwordPopup"); 
};

document.querySelectorAll('.close').forEach(function(element) {
    element.onclick = function() {
        closeModal();
    };
});
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        closeModal();
    }
}
document.getElementById('usernamePopup form').onsubmit = function(event) {
    var newUsername = document.getElementById('newUsername').value.trim();
    if (newUsername.length < 4) {
        alert('Username must be at least 4 characters long.');
        event.preventDefault();
    }
};

document.getElementById('passwordPopup form').onsubmit = function(event) {
    var newPassword = document.getElementById('newPassword').value.trim();
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
};
</script>
</html>