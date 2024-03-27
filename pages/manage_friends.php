<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Friends</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/manage_friends.css">
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
            <li><a href="../pages/SearchPage.php">Search</a></li>
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
                        <li class="item"><a href="../pages/saved_posts.php">Saved Posts</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </nav>
</div>
<body>
    <div class="friend-container">
        <div class="follower-list">
            <h1>Followers</h1>
            <?php
                $username = $_SESSION['username'];
                $sql = "SELECT Account.username, Account.pfp,Account.id as FollowerId FROM Account 
                        JOIN Follows ON Account.id = Follows.follower_id 
                        WHERE Follows.followed_id = (SELECT id FROM Account WHERE username = ?)";
                $followQuery = mysqli_prepare($connection, $sql);
                mysqli_stmt_bind_param($followQuery, "s", $username);
                mysqli_stmt_execute($followQuery);
                $result = mysqli_stmt_get_result($followQuery);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $encode = base64_encode($row['pfp']);
                        echo "<div class='follower'>";
                        echo "<img src='data:image/jpeg;base64," . $encode . "' alt='Profile Picture' class='profile_pic' width='35px' height='35px'>";
                        echo "<h2>" . $row['username'] . "</h2>";
                        echo "<input type='hidden' class='FollowerId' value='" . $row['FollowerId'] . "'>";
                        echo "<td><button onclick='toggleFollower(" . $row['FollowerId'] . ")'>Unfollow</button></td>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <div class="following-list">
            <h1>Following</h1>
            <?php 
                $username = $_SESSION['username'];
                $sql = "SELECT Account.username, Account.pfp,Account.id as FollowingId FROM Account 
                        JOIN Follows ON Account.id = Follows.followed_id 
                        WHERE Follows.follower_id = (SELECT id FROM Account WHERE username = ?)";
                $followingQuery = mysqli_prepare($connection, $sql);
                mysqli_stmt_bind_param($followingQuery, "s", $username);
                mysqli_stmt_execute($followingQuery);
                $result = mysqli_stmt_get_result($followingQuery);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $encode = base64_encode($row['pfp']);
                        echo "<div class='following'>";
                        echo "<img src='data:image/jpeg;base64," . $encode . "' alt='Profile Picture' class='profile_pic' width='35px' height='35px'>";
                        echo "<h2>" . $row['username'] . "</h2>";
                        echo "<input type='hidden' class='FollowingId' value='" . $row['FollowingId'] . "'>";
                        echo "<td><button onclick='toggleFriendShip(" . $row['FollowingId'] . ")'>Unfollow</button></td>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </div> 
    <script> 
    function toggleFriendShip(Id) {
            console.log(Id);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deleteFollow.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var responseText = this.responseText.trim().toLowerCase();
                    if(responseText === 'success'){
                        console.log('successful delete')
                        removeFollowing(Id);
                    } else if(responseText === 'not success'){
                        console.error('Failed to delete follow');
                    }
                }else{
                    console.error('Unsuccessful response')
                }
            };
            xhr.send("profileId=" + encodeURIComponent(Id));
        }
    function removeFollowing(id){
        var inputs = document.querySelectorAll('.FollowingId'); 
            Id = String(id);
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value === Id) {
                    var div = inputs[i].closest('div');
                    if (div) {
                        div.remove();
                        break;
                    }
                    }
            }
    }
    function removeFollow(id){
        var inputs = document.querySelectorAll('.FollowerId'); 
            Id = String(id);
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value === Id) {
                    var div = inputs[i].closest('div');
                    if (div) {
                        div.remove();
                        break;
                    }
                    }
            }
    }
    function toggleFollower(Id) {
            console.log(Id);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deleteFollower.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var responseText = this.responseText.trim().toLowerCase();
                    if(responseText === 'success'){
                        console.log('successful delete')
                        removeFollow(Id);
                    } else if(responseText === 'not success'){
                        console.error('Failed to delete follow');
                    }
                }else{
                    console.error('Unsuccessful response')
                }
            };
            xhr.send("profileId=" + encodeURIComponent(Id));
        }
    </script>
</body>
</html>