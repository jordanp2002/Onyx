<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communities Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }
        .tweets {
            flex: 1;
            margin-right: 20px;
        }
        .tweet {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
        .tweet img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .your-communities {
            flex: 0 0 300px;
        }
        .community {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .community img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
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
            <li><?php echo $_SESSION['username']; ?></li>
            <li><a href="../pages/SearchPage.php">Search</a></li>
            <li>
                <div class = "parent-item">
                    <a href="../pages/CommunitiesPage.php">Communities</a>
                    <ul class="dropdown">
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
                        <li class="item"><a href="../pages/saved_posts.php">Saved Posts</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </nav>
</div>
<body>
    <?php
    include 'databaseconnection.php';
    $user = $_SESSION['username'];
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $query = "SELECT c.name, c.descrip,c.com_id
            FROM Account a
            JOIN community_membership cm ON a.id = cm.account_id
            JOIN communities c ON cm.com_id = c.com_id
            WHERE a.username = '$username'";
            $result = mysqli_query($connection, $query);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='post'>";
                    echo "<h3>" . $row['name'] . "</h3>";
                    echo "<figure>";
                    echo "<p>" . $row['descrip'] . "</p>";
                    echo "</figure>";
                    echo "<input type='hidden' class='comId' value='" . $row['com_id'] . "'>";
                    echo "<button onclick='toggleMembership(" . $row['com_id'] . ")'>Leave</button>";
                    
                }
            }else{
                echo "No communities found";
            }
            mysqli_close($connection);
        }
    ?>
        </div>
        <hr>
    
</div>
    <script>
        function toggleMembership(comId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "leavecom.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var responseText = this.responseText.trim().toLowerCase();
                    if(responseText === 'success'){
                        console.log('successful delete')
                        removePostDiv(comId);
                    } else {
                        console.error('Failed to leave community:');
                    }
                }{
                    console.error('Unsuccessful response')
                }
            };
            xhr.send("com_id=" + encodeURIComponent(comId));
        }
        function removePostDiv(comId) {
            var inputs = document.querySelectorAll('.comId');
            comId = String(comId);
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value === comId) {
                    var postDiv = inputs[i].closest('.post');
                    if (postDiv) {
                        postDiv.remove();
                        break; 
                    }
                }
            }
        }
    </script>
</body>
</html>
