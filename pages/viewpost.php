
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
    <?php
        include 'databaseconnection.php';
            $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }
            if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                $adminQuery = "SELECT * FROM Account WHERE username = ?";
                $adminQ = mysqli_prepare($connection, $adminQuery);
                mysqli_stmt_bind_param($adminQ, "s", $_SESSION['username']);
                mysqli_stmt_execute($adminQ);
                $accountResult = mysqli_stmt_get_result($adminQ);
                $row = mysqli_fetch_assoc($accountResult);
                $admin = $row['admin'];
            }
            ?>
    <nav>
        <ul>
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
                        <?php
                        if($admin == 1){
                            echo "<li class='item'><a href='../pages/admin.php'>Admin</a></li>";
                        }
                        ?>
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
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            if($admin == 1){
                $query = "SELECT * FROM thread";
                $preparedQuery = mysqli_prepare($connection, $query);
                mysqli_stmt_execute($preparedQuery);
                $result = mysqli_stmt_get_result($preparedQuery);
                echo "<table>";
                echo "<tr>";
                echo "<th>Thread Title</th>";
                echo "<th>Thread Content</th>";
                echo "<th>Delete</th>";
                echo "</tr>";
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['content']."</td>";
                    echo "<td>";
                    echo "<button onclick='deleteCommunity(".$row['id'].")'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "You are not an admin";
            }
            echo "<script>
            function deleteCommunity(postId) {
                if(confirm('Are you sure you want to delete this community?')) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'deletepost.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (this.status == 200) {
                            if(this.responseText == 'postsuccess') {
                                alert('Post deleted successfully.');
                                location.reload();
                            }else if(this.responseText == 'You do not have permission to delete this post') {
                                alert('You do not have permission to delete this post');
                            }else if(this.responsText == 'Error Invalid Request') {
                                alert('Error Invalid Request');
                            }
                        }else{
                            alert('Error deleting post');
                        }
                    };
                    xhr.send('post_id=' + postId);
                }
            }
            </script>";
        }
    ?>
</body>
</html>
