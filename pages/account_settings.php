<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/account_settings.css">
</head>
<div class="headernav">
    <header>
        <h1>Twitter</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../pages/searchpage.html">Search</a></li>
            <li>
                <div class = "parent-item">
                    <a href="/community">Communities</a>
                    <ul class="dropdown">
                        <li class="item"><a href="#">Manage Communities </a></li>
                        <li class="item"><a href="#">Create Community</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class = "parent-item">
                    <a href="../pages/account_page.html">Account</a>
                    <ul class="dropdown">
                        <li class="item"><a href="../pages/account_settings.html">Manage Account</a></li>
                        <li class="item"><a href="../pages/manage_friends.html">Friends</a></li>
                        <li class="item"><a href="#">Communities</a></li>
                        <li class="item"><a href="../pages/saved_posts.html">Saved Posts</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="../pages/logout">Logout</a></li>
        </ul>
    </nav>
</div>
<body>
    <h1>Settings</h1>
    <div class="button-container">
        <!-- Buttons need functionality -->
        <!-- Each button will lead to either a cloned page or bring up a pop up -->
        <button>Upload Profile Picture</button>
        <button>Edit Profile</button>
        <button>Edit Account Information</button>
        <button>Notification Settings</button>
        <button>Manage Blocked Accounts</button>
    </div>
    <script src="accountSettingsValid.js"></script>
</body>
</html>