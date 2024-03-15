<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="../css/createpost.css">
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
    <h3>Post Creation</h3>
    <div class="PostCreation">
        <form class ="titlePost">
            <label for="postTitle" type="hidden"></label>
            <textarea id="postTitle" name="postTitle" rows="2" cols="50" maxlength="50" minlength="2" placeholder="Title here"></textarea>
        </form>
        <form class = "post">
            <label for="postContent" type="hidden"></label>
            <textarea id="postContent" name="postContent" rows="4" cols="50" maxlength="500" minlength="10" placeholder="Text here max 500 characters"></textarea>
            <br>
            <button class ="submit-button"type="submit">Submit</button>
            <button class ="delete-button"type="button">Delete</button>
        </form>
    </div>
</body>
</html>
