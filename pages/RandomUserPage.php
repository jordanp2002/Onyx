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
            <ul><?php
                include 'databaseconnection.php';
                $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

                if (!$connection) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                if(!isset($_SESSION['username']) && empty($_SESSION['username'])) {
                    header("Location: ../pages/login.php");
                }
                ?>
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
    <div class="username"><?php echo $_SESSION['username'] ?></div>
    <?php
    include 'databaseconnection.php';
    if(isset($_SESSION['username']) && isset($_GET['profile'])) {
        $profile = $_GET['profile'];
        echo $profile;
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
        mysqli_stmt_bind_param($preparedQuery, "s", $profile);
        mysqli_stmt_execute($preparedQuery);
        $result = mysqli_stmt_get_result($preparedQuery);
        $row = mysqli_fetch_assoc($result);
        if($row) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['pfp']) . '" alt="Profile Picture">';
            echo "<div class='counts'>";
            echo "<span>Followers: " . $row['followers'] . "</span>";
            echo "<span>Following: " . $row['following'] . "</span>";
            echo "<span>Communities: " . $row['communities'] . "</span>";
            echo "</div>";
        }

    }
    ?>
    <?php
        include 'databaseconnection.php';
        $user = $_SESSION['username'];
        
        $buttonClass = 'add-friend';
        $buttonText = 'Add Friend';
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if(isset($_SESSION['username']) && isset($_GET['profile'])) {
            $profile = $_GET['profile'];
            echo $profile;
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
            $userIdRow = mysqli_fetch_assoc($result1);
            $profileIdRow = mysqli_fetch_assoc($result2);
            if ($userIdRow && $profileIdRow) {
                $accountId = $userIdRow['id'];
                $profileId = $profileIdRow['id'];
                echo $profileId;
                echo $accountId;
                $friendQuery = 'SELECT * FROM Follows WHERE follower_id = ? AND followed_id = ?';
                
                $preparedQuery = mysqli_prepare($connection, $friendQuery);
                mysqli_stmt_bind_param($preparedQuery,'ii', $accountId, $profileId);
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
    <input type = "hidden" id = "profileId" value = "<?php echo $profileId; ?>">
    <input type = "hidden" id = "accountId" value = "<?php echo $accountId; ?>">
    <button id="friendAction" class="<?php echo $buttonClass; ?>" onclick="toggleFriendship()"><?php echo $buttonText; ?></button>
    <script>
        function toggleFriendship() {
            var accountId = document.getElementById('accountId').value;
            var profileId = document.getElementById('profileId').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'insertFollow.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if(xhr.status === 200) {
                    var response = this.responseText;
                    if(response === 'success') {
                        var button = document.getElementById('friendAction');
                        if(button.classList.contains('add-friend')) {
                            button.classList.remove('add-friend');
                            button.classList.add('unfriend');
                            button.innerText = 'Remove Friend';
                        } else if(response === 'not success'){
                            button.classList.remove('unfriend');
                            button.classList.add('add-friend');
                            button.innerText = 'Add Friend';
                        }
                    }
                }
            }  
            xhr.send('accountId=' + encodeURIComponent(accountId) + '&profileId=' + encodeURIComponent(profileId));      
        }
    </script>
</div>
</body>
</html>