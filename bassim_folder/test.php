<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random User's Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <style>
        .profile-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .username {
            font-size: 20px;
            font-weight: bold;
        }
        .bio {
            margin-bottom: 10px;
        }
        .counts {
            margin-bottom: 10px;
        }
        .button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-friend {
            background-color: #4CAF50;
            color: white;
        }
        .block {
            background-color: #f44336;
            color: white;
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
                <li><a href="../pages/logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
<div class="profile-section">
    <img class="profile-img" src="/Users/rhythmtrivedi/Downloads/IMG_6500.JPG" alt="Profile Picture">
    <div class="username">User8253643</div>
    <div class="bio">Description for user would go here.</div>
    <div class="counts">
        <span>Followers: 133</span>
        <span>Following: 345</span>
        <span>Communities: 10</span>
    </div>

    <?php
        $user = $_SESSION['username'];
        $buttonClass = 'add-friend';
        $buttonText = 'Add Friend';

        $connection = mysqli_connect("localhost", "76966621", "Password123", "db_76966621");
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if(isset($_SESSION['username']) && isset($_GET['profile'])) {
            $profile = $_GET['profile'];
            $query = "SELECT id FROM Account WHERE username = ?";
            $query2 = "SELECT id FROM Account WHERE username = ?";

            $usernameQuery = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($usernameQuery, "s", $user);
            mysqli_stmt_execute($usernameQuery);
            $result1 = mysqli_stmt_get_result($usernameQuery);
                 
            $username2Query = mysqli_prepare($connection, $query2);
            mysqli_stmt_bind_param($username2Query,"s", $profile);
            mysqli_stmt_execute($username2Query);
            $result2 = mysqli_stmt_get_result($username2Query);

            if ($userIdRow = mysqli_fetch_assoc($result1) && $profileIdRow = mysqli_fetch_assoc($result2)) {
                $accountId = $userIdRow['id'];
                $profileId = $profileIdRow['id'];
                $query = 'SELECT * FROM Friends WHERE follower_id = ? AND followed_id = ?';
                
                $preparedQuery = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($preparedQuery,'ss', $accountId, $profileId);
                mysqli_stmt_execute($preparedQuery);
                $friendResult = mysqli_stmt_get_result($preparedQuery); 
                
                if(mysqli_num_rows($friendResult) > 0) {
                    $buttonClass = 'unfriend';
                    $buttonText = 'Remove Friend';
                } 
                mysqli_stmt_close($preparedQuery);
            }
        mysqli_stmt_close($usernameQuery);
        mysqli_stmt_close($username2Query);
    }
    mysqli_close($connection);
    ?>
    <button id="friendAction" class="<?php echo $buttonClass; ?>" onclick="toggleFriendship()"><?php echo $buttonText; ?></button>
    
    <button class="cancel">Block</button>
</div>

</body>
</html>
