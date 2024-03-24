<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <style>
        .search-bar {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .tweet {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .tweet img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .tweet .username {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
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
<div class="search-bar">
    <input type="text" placeholder="Search...">
    <button>Search</button>
</div>
<h2>Trending Now on Twitter</h2>
<div class="tweet">
    <img src="profile1.jpg" alt="Profile Picture">
    <div>
        <div class="username">User82732</div>
        <p>Today, the Administration announces the winners of the Gears of Government President’s Award. This program recognizes the contributions of individuals and teams across the federal workforce who make a profound difference in the lives of the American people.</p>
    </div>
</div>
<div class="tweet">
    <img src="profile2.jpg" alt="Profile Picture">
    <div>
        <div class="username">User27364</div>
        <p>Today, the Administration announces the winners of the Gears of Government President’s Award. This program recognizes the contributions of individuals and teams across the federal workforce who make a profound difference in the lives of the American people.</p>
    </div>
</div>
<script src="SearchPageValid.js"></script>
</body>
</html>
