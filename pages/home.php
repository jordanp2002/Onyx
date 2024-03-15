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
            <li><a href="../pages/searchpage">Search</a></li>
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
                    <a href="../pages/account_page">Account</a>
                    <ul class="dropdown">
                        <li class="item"><a href="../pages/account_settings">Manage Account</a></li>
                        <li class="item"><a href="../pagesmanage_friends">Friends</a></li>
                        <li class="item"><a href="#">Communities</a></li>
                        <li class="item"><a href="../pages/saved_posts">Saved Posts</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="../pages/logout">Logout</a></li>
        </ul>
    </nav>
</div>

<body>
    <div class = "layout-container">
        <div class ="CreatePost">
            <h2>Create Post</h2>
            <a href = "../pages/createpost.html">
                <button class="button" id = "create-post-button">Create Post</button>
            </a>
            <h2>Filter</h2>
                <label for="dateFilter">Filter by Date:</label>
                <select id="dateFilter">
                <option value="all">All Dates</option>
                <option value="date-descending">Lastest</option>
                <option value="date-ascending">Oldest</option>
                </select>
        </div>
        <div class="Feed">
            <h2>Feed</h2>
            <div class="post">
                <h3>Example Post 3</h3>
                <figure>
                    <p>Hello this is an example post for our twitter/reddit clone</p>
                    <figcaption>Author: Jordan</figcaption>
                </figure>
                <p>Date Posted: <time datetime="2024-02-10"></time></p>
                <button class="button" id = "like-button">Like</button>
                <button class="button" id ="dislike-button">Dislike</button>
                <button class="button">Comment</button>
                <button class="button" id="repost-button">Repost</button>
                <button class="button" id="save-button">Save</button>
            </div>
            <hr> 
            <div class="post">
                <h3>Example Post 2</h3>
                <figure>
                    <p>Hello this is an example post for our twitter/reddit clone</p>
                    <figcaption>Author: Jordan</figcaption>
                </figure>
                <p>Date Posted: <time datetime="2024-02-10"></time></p>
                <button class="button" id = "like-button-1">Like</button>
                <button class="button" id ="dislike-button-1">Dislike</button>
                <button class="button">Comment</button>
                <button class="button" id="repost-button-1">Repost</button>
                <button class="button" id="save-button-1">Save</button>
            </div>
            <hr> 
            <div class="post">
                <h3>Post Title</h3>
                <figure>
                    <p>Hello this is an example post for our twitter/reddit clone</p>
                    <figcaption>Author: Jordan</figcaption>
                </figure>
                <p>Date Posted: <time datetime="2024-02-10"></time></p>
                <button class="button" id ="like-button-2">Like</button>
                <button class="button" id ="dislike-button-2">Dislike</button>
                <button class="button">Comment</button>
                <button class="button" id="repost-button-2">Repost</button>
                <button class="button" id="save-button-2">Save</button>
            </div>
        </div>
    </div>
</body>
</html>