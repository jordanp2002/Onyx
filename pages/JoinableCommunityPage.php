<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joinable Community Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <style>
        body {
            background-color: white;
        }
        .tweets {
            flex: 1;
            margin-right: 20px;
        }
        .tweet {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
        .tweet img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .community-info {
            flex: 0 0 300px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }
        .community-info h2 {
            margin-bottom: 10px;
        }
        .community-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .join-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
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
                        <a href="../pages/account_page.php">Account</a>
                        <ul class="dropdown">
                            <li class="item"><a href="../pages/account_settings.php">Manage Account</a></li>
                            <li class="item"><a href="../pages/manage_friends.php">Friends</a></li>
                            <li class="item"><a href="#">Communities</a></li>
                            <li class="item"><a href="../pages/saved_posts.php">Saved Posts</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="../pages/logout">Logout</a></li>
            </ul>
        </nav>
    </div>

        <div class="tweet">
            <img src="/Users/rhythmtrivedi/Downloads/IMG_6500.JPG" alt="Profile Picture">

            <div>
                <div class="username">User82732</div>
                <p>This is a tweet from User82732 within the community.</p>
            </div>

        </div>

        <div class="tweet">
            <img src="/Users/rhythmtrivedi/Downloads/IMG_6500.JPG" alt="Profile Picture">

            <div>
                <div class="username">User27364</div>
                <p>This is a tweet from User27364 within the community.</p>
            </div>
    </div>

    <div class="community-info">
        <h2>Community Name</h2>
        <img src="/Users/rhythmtrivedi/Documents/Jagermeister-Logo.png" alt="Community Picture">
        <button class="join-button">Join Community</button>
    </div>
    
</body>
</html>
