<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communities Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/communities.css">
</head>
<?php
    session_start();
?>
<div class="headernav">
    <header>
        <h1>Onyx</h1>
    </header>
    <nav>
        <ul>
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
            <li><?php echo $_SESSION['username']; ?></li>
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
    <H1>Communities</H1>
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
                echo "<table class='communities-table'>";
                echo "<thead><tr><th>Name</th><th>Description</th><th>Action</th></tr></thead>";
                echo "<tbody>";
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['descrip'] . "</td>";
                    echo "<input type='hidden' class='comId' value='" . $row['com_id'] . "'>";
                    echo "<td><button onclick='toggleMembership(" . $row['com_id'] . ")'>Leave</button></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No communities found";
            }
            mysqli_close($connection);
        }
    ?>
        </div>
    
</div>
    <script>
        function toggleMembership(comId) {
            console.log(comId);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "leavecom.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var responseText = this.responseText.trim().toLowerCase();
                    if(responseText === 'success'){
                        console.log('successful delete')
                        removePostDiv(comId);
                    } else if(responseText === 'fail'){
                        console.error('Failed to leave community:');
                    }else if (responseText === 'here'){
                        console.log('problem is here');
                    }
                }else{
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
                    var tableRow = inputs[i].closest('tr');
                    if (tableRow) {
                        tableRow.remove();
                        break;
                    }
                    }
                }
        }
    </script>
</body>
</html>
