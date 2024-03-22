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
<?php
    session_start();
?>
<body>
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
<div class="search-bar">
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET"> 
        <input type="text" id = "searchTerm" name="searchTerm" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
</div>
<?php
$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];
    $searchTerm = "%" . $searchTerm . "%";

    $query = "SELECT title, content,username, thread.id AS threadid FROM thread JOIN Account on thread.account_id = Account.id WHERE title LIKE ?";
    $tweet = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($tweet, "s", $searchTerm);
    mysqli_stmt_execute($tweet);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="tweet">';
            echo '<img src="profile1.jpg" alt="Profile Picture">';
            echo '<div>';
            echo '<div class="username"><a href="PostPage.php?thread_id=' . $row['threadid'] . '" style="text-decoration: none; color: black;">' . $row['title'] . ' By ' . $row['username'] . '</a></div>';
            echo '<p>'. $row['content'].'</p>';
            echo '</div>';
            echo '</div>';
        }
    }else{
        echo "no entries found";
    }
    mysqli_close($connection);
}
?>
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
</body>
</html>
