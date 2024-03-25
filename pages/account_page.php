<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/account_page.css">
    <script src="accountPageValid.js"></script>
    

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
    <div class="profile">
        <div class="profile_pic">
            <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="300px" height="300px">
            <p>141 Followers</p>
            <p>123 Following</p>
            <p>12 Communities</p>
            <p>0 Posts</p>
        </div>
        <div class="profile_info">
            <h1>User 883934</h1>
            <h2>Super duper long description here insert im writing random stuff to make it look long</h2>
        </div>
    </div>
</body>
</html>