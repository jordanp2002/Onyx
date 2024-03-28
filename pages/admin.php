<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/admin.css">
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
            }else{
                header("Location: ../pages/login.php");
            }
            ?>

            <li><?php echo $_SESSION['username']; ?><li>
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
                    <a href="../pages/account_page.html">Account</a>
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

<body>
    <h1 style="color: white; text-align: center; margin-top: 1em;">Admin Dashboard</h1>
     <div class="admin-container">
        <div class="wrapper">
                <div class="manage">
                    <h3>Manage All Users</h1> 
                    <button><a href ="viewusers.php"> view users </a></button>
                </div>
                <div class="manage">
                    <h3>Manage All Communities</h1>
                    <button><a href ="viewcommunities.php"> view communities</a></button>
                </div>
                <div class="manage">
                    <h3>Manage All Posts</h1>
                    <button><a href ="viewpost.php"> view posts</a></button>
                </div>
        </div>
        <div class="search">
            <div class="search-bar">
                <form>
                    <input type="text" name="search" id="search" placeholder="Search for user,tweet or community">
                    <button type="submit">Search</button>
                </form>
            </div>
            <h2 style="color: white; text-align: center; margin-top: 1em;"> Search Results </h2>
            <div class="search-results">
                <div class = "results">
                    <table>
                    <tr>
                        <th>Tweet</th>
                        <th>Action</th>
                    </tr>
            <?php
            if($admin != 1){
                header("Location: ../pages/home.php");
            }
            if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['search'])) {
                $searchTerm = $_GET['search'];
                $searchTerm = "%" . $searchTerm . "%";

                $query = "SELECT title, content, username, thread.id AS threadid FROM thread JOIN Account on thread.account_id = Account.id WHERE title LIKE ?";
                $tweet = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($tweet, "s", $searchTerm);
                mysqli_stmt_execute($tweet);
                $result = mysqli_stmt_get_result($tweet);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td><a href ='updatepost.php?thread_id=". $row['threadid'] . "'>" . $row['title'] . "</a></td>";
                        echo "<td><button onclick='deleteTweet(" . $row['threadid'] . ")'>Delete</button></td>";
                        echo "</tr>";
                    }
                }else{
                    echo "no entries found";
                }
                echo "<script>
                function deleteTweet(postId) {
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
            ?>        </table>
                </div>
                <div class="results">
                    <table>
                    <tr>
                        <th>Community</th>
                        <th>Action</th>
                    </tr>
            <?php
            $comquery = "SELECT name,descrip,com_id FROM communities WHERE name LIKE ? OR descrip LIKE ?";
            $communitySearch = mysqli_prepare($connection, $comquery);
            mysqli_stmt_bind_param($communitySearch, "ss", $searchTerm, $searchTerm);
            mysqli_stmt_execute($communitySearch);
            $result = mysqli_stmt_get_result($communitySearch);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><a href ='JoinableCommunityPage.php?com_id=". $row['com_id'] . "'>" . $row['name'] . "</a></td>";
                    echo "<td><button onclick='deleteCommunity(" . $row['com_id'] . ")'>Delete</button></td>";
                    echo "</tr>";
                }
            }else{
                echo "No communities found.";
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
        
        ?>   
            </table>
            </div>
            <div class = "results">
                    <table>
                    <tr>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['search'])) {
                $searchTerm = $_GET['search'];
                $searchTerm = "%" . $searchTerm . "%";
                $query = "SELECT username,id FROM Account WHERE username LIKE ?";
                $tweet = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($tweet, "s", $searchTerm);
                mysqli_stmt_execute($tweet);
                $result = mysqli_stmt_get_result($tweet);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td><a href ='RandomUserPage.php?profile=". $row['username'] . "'>" . $row['username'] . "</a></td>";
                        echo "<td><button onclick='deleteUser(" . $row['id'] . ")'>Delete</button></td>";
                        echo "</tr>";
                    }
                }else{
                    echo "no entries found";
                }
                echo "<script>
                function deleteUser(accId) {
                    if(confirm('Are you sure you want to delete this user?')) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'deleteuser.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (this.status == 200) {
                                if(this.responseText == 'usersuccess') {
                                    alert('user deleted successfully.');
                                    location.reload();
                                }else if(this.responseText == 'You do not have permission to delete this user') {
                                    alert('You do not have permission to delete this user');
                                }else if(this.responsText == 'Error Invalid Request') {
                                    alert('Error Invalid Request');
                                }
                            }else{
                                alert('Error deleting user');
                            }
                        };
                        xhr.send('user_id=' + accId);
                    }
                }
                </script>";
            }
            mysqli_close($connection);
            ?>       
            </table>
            </div>
        </div>
    </div>
</body>
</html>