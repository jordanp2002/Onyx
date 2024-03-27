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
            <?php
                include 'databaseconnection.php';
                $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

                if (!$connection) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                if(!isset($_SESSION['username']) && empty($_SESSION['username'])) {
                    header("Location: ../pages/login.php");
                }
            ?>
            <li><?php echo $_SESSION['username']; ?><li>
            <li><a href="../pages/searchpage.php">Search</a></li>
            <li>
                <div class = "parent-item">
                    <a href="../pages/CommunitiesPage.php">Communities</a>
                    <ul class="dropdown">
                        <li class="item"><a href="../pages/createcommunity.php">Create Community</a></li>
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
    <h2>Community Creation</h2>
    <div class="PostCreation">
        <form class ="comPost" action = "../pages/comcreationhandle.php" method = "POST">
            <label for="comTitle" type="hidden"></label>
            <textarea id="comTitle" name="comTitle" rows="2" cols="50" maxlength="50" minlength="2" placeholder="Enter community name here"></textarea>
            <label for="comDesc" type="hidden"></label>
            <textarea id="comDesc" name="comDesc" rows="8" cols="50" maxlength="500" minlength="10" placeholder="Enter community description here (max 500 characters)"></textarea>
            <br>
            <button class ="submit-button"type="submit">Create Community</button>
            <button class ="delete-button"type="button">Back</button>
        </form>
    </div>
</body>
</html>