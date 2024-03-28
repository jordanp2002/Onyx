<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="../css/createpost.css">
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
    <h3>Post Creation</h3>
    <div class="PostCreation">
        <form class ="titlePost" action = "../pages/postcreationhandle.php" method = "POST">
            <label for="postTitle" type="hidden"></label>
            <textarea id="postTitle" name="postTitle" rows="2" cols="50" maxlength="50" minlength="2" placeholder="Title here"></textarea>
            <label for="postContent" type="hidden"></label>
            <textarea id="postContent" name="postContent" rows="4" cols="50" maxlength="500" minlength="10" placeholder="Text here max 500 characters"></textarea>
            <label for="postCom" type = "hidden"></label>
            <input type ="text" id ="postCom" name = "postCom" placeholder = "Community">
            <br>
            <button class ="submit-button"type="submit">Submit</button>
            <button class ="delete-button"type="button">Delete</button>
        </form>
    </div>
    <script>
function validateForm(event) {
    var titleInput = document.getElementById('postTitle');
    var postInput = document.getElementById('postContent');

    // Post Title Validation
    var title = titleInput.value.trim();
    if (title.length < 2 || title.length > 50) {
        alert('Post title must be between 2 and 50 characters.');
        event.preventDefault();
        return;
    }

    // Post Content Validation
    var content = postInput.value.trim();
    if (content.length < 10 || content.length > 500) {
        alert('Post content must be between 10 and 500 characters.');
        event.preventDefault();
        return;
    }
}
document.querySelector('.titlePost').addEventListener('submit', validateForm);
</script>

</body>
</html>
