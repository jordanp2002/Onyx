<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
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
            <li><a href="../pages/searchpage.php">Search</a></li>
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
                        <li class="item"><a href="../pages/account_settings.php">Manage Account</a></li>
                        <li class="item"><a href="../pages/manage_friends.php">Friends</a></li>
                        <li class="item"><a href="#">Communities</a></li>
                        <li class="item"><a href="../pages/saved_posts.php">Saved Posts</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </nav>
</div>

<body>
    <h2>Admin Dashboard</h2>

     <div class="admin-container">
        <div class="search">
            <form>
                <input type="text" name="search" id="search" placeholder="Search for user">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="user">
            <h3>Manage Users</h1> 
            <button><a href ="viewusers.php"> view users </a></button>
        </div>
        <div class="community">
            <h3>Manage Communities</h1>
            <button><a href ="viewcommunities.php"> view communities</a></button>
        </div>
        <div class="posts">
            <h3>Manage Posts</h1>
            <button><a href ="viewpost.php"> view posts</a></button>
        </div>
    </div>
</body>
</html>