<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Friends</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/manage_friends.css">
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
    <div class="friend-container">
        <div class="follower-list">
            <h1>Followers</h1>
            <div class="follower">
                <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="50px" height="50px">
                <h2>User 29375</h2>
                <button>Remove</button>
            </div>
            <div class="follower">
                <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="50px" height="50px">
                <h2>User 23986</h2>
                <button>Remove</button>
            </div>
            <div class="follower">
                <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="50px" height="50px">
                <h2>User 723834</h2>
                <button>Remove</button>
            </div>
            <div class="follower">
                <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="50px" height="50px">
                <h2>User 158622</h2>
                <button>Remove</button>
            </div>
            <div class="follower">
                <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="50px" height="50px">
                <h2>User 11243</h2>
                <button>Remove</button>
            </div>
            <!-- Add more as needed -->
        </div>
        <div class="following-list">
            <h1>Following</h1>
            <div class="following">
                <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="50px" height="50px">
                <h2>User 84936</h2>
                <button>Unfollow</button>
            </div>
            <div class="following">
                <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="50px" height="50px">
                <h2>User 23234</h2>
                <button>Unfollow</button>
            </div>
            <div class="following">
                <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="50px" height="50px">
                <h2>User 64323</h2>
                <button>Unfollow</button>
            </div>
            <div class="following">
                <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="50px" height="50px">
                <h2>User 824623</h2>
                <button>Unfollow</button>
            </div>
            <div class="following">
                <img src="../images/profilepic.png" alt="Profile Picture" class="profile_pic" width="50px" height="50px">
                <h2>User 128749</h2>
                <button>Unfollow</button>
            </div>
            <!-- Add more as needed -->
        </div>
    </div>  
</body>
</html>