<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
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
            <button>View Users</button>
        </div>
        <div class="community">
            <h3>Manage Communities</h1>
            <button>View Communities</button>
        </div>
        <div class="posts">
            <h3>Manage Posts</h1>
            <button>View Posts</button>
        </div>
    </div>
</body>
</html>