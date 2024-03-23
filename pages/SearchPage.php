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
        .search-results {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .results {
            flex-basis: 48%; 
            margin-bottom: 20px; 
        }

        .tweets, .communities {
            padding: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .search-bar {
            margin-bottom: 20px;
        }
        .results img {
            max-width: 100%;
            height: auto;
        }
        .search-bar input[type="text"] {
            justify-content: center;
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #black;
            border-radius: 5px;
            width: 80%;
        }
        .search-bar button {
            padding: 10px 20px;
            background-color: #6c6281;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #6c6281;
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
                <li><?php echo $_SESSION['username']; ?><li>
                <li><a href="../pages/searchpage.php">Search</a></li>
                <li>
                    <div class = "parent-item">
                        <a href="../pages/CommunitiesPage.php">Communities</a>
                        <ul class="dropdown">
                            <li class="item"><a href="#">Manage Communities </a></li>
                            <li class="item"><a href="../pages/createcommunity.php">Create Community</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class = "parent-item">
                        <a href="../pages/account_page.php">Account</a>
                        <ul class="dropdown">
                            <li class="item"><a href="../pages/account_settings.php">Manage Account</a></li>
                            <li class="item"><a href="../pages/manage_friends.php">Friends</a></li>
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
<div class="search-results">
    <div class="results tweets">
    <h2 class = "tweets"> Tweets </h2> 
<?php
$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];
    $searchTerm = "%" . $searchTerm . "%";

    $query = "SELECT title, content,username, pfp, thread.id AS threadid FROM thread JOIN Account on thread.account_id = Account.id WHERE title LIKE ?";
    $tweet = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($tweet, "s", $searchTerm);
    mysqli_stmt_execute($tweet);
    $result = mysqli_stmt_get_result($tweet);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="tweet">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['pfp']) . '" alt="Profile Picture">';
            echo '<div>';
            echo '<div class="username"><a href="PostPage.php?thread_id=' . $row['threadid'] . '" style="text-decoration: none; color: black;">' . $row['title'] . ' By ' . $row['username'] . '</a></div>';
            echo '<p>'. $row['content'].'</p>';
            echo '</div>';
            echo '</div>';
        }
    }else{
        echo "no entries found";
    }
?>
    </div>
    <div class="results communities">
    <h2 class = "tweets"> Communities </h2> 
<?php
    $comquery = "SELECT name,descrip,com_id FROM communities WHERE name LIKE ? OR descrip LIKE ?";
    $communitySearch = mysqli_prepare($connection, $comquery);
    mysqli_stmt_bind_param($communitySearch, "ss", $searchTerm, $searchTerm);
    mysqli_stmt_execute($communitySearch);
    $result = mysqli_stmt_get_result($communitySearch);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="community">';
            echo '<img src="community_icon.jpg" alt="Community Icon">';
            echo '<div>';
            echo '<div class="community-name"><a href="JoinableCommunityPage.php?com_id=' . $row['com_id'] . '" style="text-decoration: none; color: black;">' . $row['name'] . ' By ' . $row['username'] . '</a></div>';
            echo '<p>'. $row['descrip'].'</p>';
            echo '</div>';
            echo '</div>';
        }
    }else{
        echo "No communities found.";
    }
    mysqli_close($connection);
}
?>
    </div>
</div>
</body>
</html>
