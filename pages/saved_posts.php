<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Posts</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/saved_post.css">

</head>
<?php
session_start();
?>
<div class="headernav">
    <header>
        <h1><a href="home.php"> Onyx </a></h1>    
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
            <li><a href="../pages/SearchPage.php">Search</a></li>
            <li>
                <div class = "parent-item">
                    <a>Communities</a>
                    <ul class="dropdown">
                        <li class="item"><a href="../pages/CommunitiesPage.php">Your Communities</a></li>
                        <li class="item"><a href="../pages/createcommunity.php">Create Community</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class = "parent-item">
                <a>Account</a>
                    <ul class="dropdown">
                        <li class="item"><a href="../pages/account_page.php">View Account</a></li>
                        <li class="item"><a href="../pages/account_settings.php">Manage Account</a></li>
                        <li class="item"><a href="../pages/manage_friends.php">Friends</a></li>
                        <li class="item"><a href="../pages/saved_posts.php">Saved Posts</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </nav>
</div>
<body>
    <h1>Saved Posts</h1>
    <div class="saved-posts">
        <?php
        include 'databaseconnection.php';
        session_start();
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $accountName = $_SESSION['username'];
        if(isset($accountName) && isset($_SESSION['username'])) {
            $query = "SELECT id FROM Account WHERE username = ?";
            $usernameQuery = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($usernameQuery, "s", $accountName);
            mysqli_stmt_execute($usernameQuery);
            $result = mysqli_stmt_get_result($usernameQuery);
            if ($row = mysqli_fetch_assoc($result)) {
                $accountId = $row['id'];
                $savedQuery = "SELECT thread_id FROM saved_threads WHERE account_id = ?";
                $saveQ = mysqli_prepare($connection, $savedQuery);
                mysqli_stmt_bind_param($saveQ, "i", $accountId);
                mysqli_stmt_execute($saveQ);
                $saveResult = mysqli_stmt_get_result($saveQ);
                while ($resultRow = mysqli_fetch_assoc($saveResult)) {
                    $threadId = $resultRow['thread_id'];
                    $threadQuery = "SELECT * FROM thread WHERE id = ?";
                    $threadQ = mysqli_prepare($connection, $threadQuery);
                    mysqli_stmt_bind_param($threadQ, "i", $threadId);
                    mysqli_stmt_execute($threadQ);
                    $threadResult = mysqli_stmt_get_result($threadQ);
                    if ($threadRow = mysqli_fetch_assoc($threadResult)) {
                        echo "<div class='post'>";
                        echo '<p><a href="PostPage.php?thread_id=' . $threadRow['id'] . '" style="text-decoration: none; color: black;">' . $threadRow['title'].'</a></p>';
                        echo "<p>" . $threadRow['content'] . "</p>";
                        echo "</form>";
                        echo "</div>";
                    }
                }
                mysqli_stmt_close($saveQ);
                mysqli_stmt_close($threadQ);
            }
        }
        ?>
    </div>
</body>
</html>