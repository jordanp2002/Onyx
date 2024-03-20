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
                    <a href="../pages/account_page.php">Account</a>
                    <ul class="dropdown">
                        <li class="item"><a href="../pages/account_settings.php">Manage Account</a></li>
                        <li class="item"><a href="../pagesmanage_friends.php">Friends</a></li>
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
    <div class = "layout-container">
        <div class ="CreatePost">
        <?php
            if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                echo "<p>Logged in as: " . htmlspecialchars($_SESSION['username']) . "</p>";
            }
            ?>
            <h2>Create Post</h2>
            <a href = "../pages/createpost.php">
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
            <?php
            if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                $connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');

                if (!$connection) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $username = $_SESSION['username'];
                $query = "SELECT t.id AS thread_id, t.title,t.content, t.com_id, t.account_id, t.thread_like, t.thread_dislike
                FROM Account a
                JOIN community_membership cm ON a.id = cm.account_id
                JOIN thread t ON cm.com_id = t.com_id
                WHERE a.username = '$username'";
                $result = mysqli_query($connection, $query);

                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='post'>";
                        echo "<h3>" . $row['title'] . "</h3>";
                        echo "<figure>";
                        echo "<p>" . $row['content'] . "</p>";
                        echo "<figcaption>" . $row['account_id'] . " </figcaption>";
                        echo "</figure>";
                        echo "<button class='button' id = 'like-button'>Like</button>";
                        echo "<button class='button' id ='dislike-button'>Dislike</button>";
                        echo "<button class='button'>Comment</button>";
                        echo "<button class='button' id='repost-button'>Repost</button>";
                        echo "<button class='button' id='save-button'>Save</button>";
                        echo "</div>";
                        echo "<hr>";
                    }
                }else{
                    echo "No posts found";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>