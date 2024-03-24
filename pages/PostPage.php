<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <style>
        .post {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .post-header {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .post-subheader {
            margin-bottom: 10px;
        }
        .post-content {
            margin-bottom: 10px;
        }
        .button {
            padding: 5px 10px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .like, .dislike, .repost, .comment, .save {
            background-color: #3498db;
            color: white;
        }
        .comment-section {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .comment {
            margin-bottom: 10px;
        }
        .comment-buttons {
            margin-top: 10px;
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
<h2>User78347643’s Post</h2>
<div class="post">
    <div class="post-header">Gears of Government President’s Award winners</div>
    <div class="post-content">
        <p>Today, the Administration announces the winners of the Gears of Government President’s Award. This program recognizes the contributions of individuals and teams across the federal workforce who make a profound difference in the lives of the American people.</p>
        <p>By Sondra Ainsworth and Constance Lu</p>
        <p>September 30, 2020</p>
    </div>
    <div class="post-buttons">
        <button class="button like">Like</button>
        <button class="button dislike">Dislike</button>
        <button class="button repost">Repost</button>
        <button class="button comment">Comment</button>
        <button class="button save">Save</button>
    </div>
</div>
<div class="comment-section">
    <div class="comment">
        <div>User8253643:</div>
        <p>This is a very cool post! Thanks for sharing!</p>
        <div class="comment-buttons">
            <button class="button like">Like</button>
            <button class="button dislike">Dislike</button>
        </div>
    </div>
</div>
<script src="postPageValid.js"></script>
</body>
</html>
