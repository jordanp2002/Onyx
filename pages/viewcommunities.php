
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/viewpost.css">
</head>
<?php
session_start();
?>
<div class="headernav">
    <header>
        <h1><a href="home.php"> Onyx </a></h1>    </header>
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
                $query = "SELECT * FROM communities";
                $preparedQuery = mysqli_prepare($connection, $query);
                mysqli_stmt_execute($preparedQuery);
                $result = mysqli_stmt_get_result($preparedQuery);
                echo "<table>";
                echo "<tr>";
                echo "<th>Community Name</th>";
                echo "<th>Community Description</th>";
                echo "<th>Delete</th>";
                echo "</tr>";
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['descrip']."</td>";
                    echo "<td>";
                    echo "<button onclick='deleteCommunity(".$row['com_id'].")'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                mysqli_stmt_close($preparedQuery);
                echo "</table>";
            } else {
                echo "You are not an admin";
            }
            echo "<script>
            function deleteCommunity(comId) {
                if(confirm('Are you sure you want to delete this community?')) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'deletecom.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (this.status == 200) {
                            if(this.responseText == 'success') {
                                alert('Post deleted successfully.');
                                location.reload();
                            }else if(this.responseText == 'You do not have permission to delete this community') {
                                alert('You do not have permission to delete this community');
                            }else if(this.responsText == 'Error Invalid Request') {
                                alert('Error Invalid Request');
                            }
                        }else{
                            alert('There was an error deleting the community');
                        }
                    };
                    xhr.send('com_id=' + comId);
                }
            }
            </script>";
        }
    ?>
</body>
</html>

