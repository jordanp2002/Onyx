<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/account_page.css">
    <link rel="stylesheet" href="../css/randomuser.css">
</head>
<?php
    session_start();
    if(!isset($_SESSION['username']) && empty($_SESSION['username'])) {
        header("Location: ../pages/login.php");
    }
?>
<div class="headernav">
    <header>
        <h1><a href="home.php"> Onyx </a></h1>    </header>
    <nav>
        <ul>
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
    <div class="profile-section">
        <div class="profile_pic">
            <?php 
                include 'databaseconnection.php';
                if(isset($_SESSION['username']) && isset($_SESSION ['username'])) {
                    $user = $_SESSION['username'];
                    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                    if (!$connection) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $query = "SELECT 
                        (SELECT COUNT(*) FROM Follows WHERE followed_id = acc.id) AS followers,
                        (SELECT COUNT(*) FROM Follows WHERE follower_id = acc.id) AS following,
                        (SELECT COUNT(*) FROM community_membership WHERE account_id = acc.id) AS communities,
                        acc.pfp AS pfp
                      FROM Account acc
                      WHERE acc.username = ?";
                    $preparedQuery = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($preparedQuery, "s", $user);
                    mysqli_stmt_execute($preparedQuery);
                    $result = mysqli_stmt_get_result($preparedQuery);
                    $row = mysqli_fetch_assoc($result);
                    if($row) {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['pfp']) . '" alt="Profile Picture">';
                        echo "<div class='counts'>";
                        echo "<p>Followers: " . $row['followers'] . "</p>";
                        echo "<p>Following: " . $row['following'] . "</p>";
                        echo "<p>Communities: " . $row['communities'] . "</p>";
                        echo "</div>";
                    }
                }
            ?>  
        </div>
        <div class="profile_info">
            <p>Username: <?php echo $_SESSION['username']; ?></p>
        </div>
    </div>
</body>
</html>