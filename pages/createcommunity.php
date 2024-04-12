<!DOCTYPE html>
<html>
<head>
    <title>Create Community</title>
    <link rel="stylesheet" href="../css/createpost.css">
    <link rel="stylesheet" href="../css/home.css">
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
            <li><?php echo $_SESSION['username']; ?><li>
            <li><a href="../pages/searchpage.php">Search</a></li>
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
    <h2>Community Creation</h2>
    <div class="PostCreation">
        <form class ="comPost" action = "../pages/comcreationhandle.php" method = "POST">
            <label for="comTitle" type="hidden"></label>
            <textarea id="comTitle" name="comTitle" rows="2" cols="50" placeholder="Enter community name here"></textarea>
            <label for="comDesc" type="hidden"></label>
            <textarea id="comDesc" name="comDesc" rows="8" cols="50" placeholder="Enter community description here (max 500 characters)"></textarea>
            <br>
            <button class ="submit-button"type="submit">Create Community</button>
            <button class ="delete-button"type="button">Back</button>
        </form>
    </div>
    <script>
    document.querySelector('.comPost').addEventListener('submit', function(event) {
    var titleInput = document.getElementById('comTitle');
    var descInput = document.getElementById('comDesc');

    var title = titleInput.value.trim();
    if (title.length < 2 || title.length > 50) {
        alert('Community title must be between 2 and 50 characters.');
        event.preventDefault();
        return;
    }

    var description = descInput.value.trim();
    if (description.length < 10 || description.length > 500) {
        alert('Community description must be between 10 and 500 characters.');
        event.preventDefault();
        return;
    }
    });
</script>
</body>
</html>