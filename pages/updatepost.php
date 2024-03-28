<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="../css/createpost.css">
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
                    <a href="../pages/CommunitiesPage.php">Communities</a>
                    <ul class="dropdown">
                        <li class="item"><a href="#">Create Community</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class = "parent-item">
                    <a href="../pages/account_page.html">Account</a>
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
    if($admin != 1){
        header("Location: ../pages/home.php");
    }else{
        $threadID = $_GET['thread_id'];
        $selectPostQuery = "SELECT * FROM thread WHERE id = ?";
        $selectPostQ = mysqli_prepare($connection, $selectPostQuery);
        mysqli_stmt_bind_param($selectPostQ, "s", $threadID);
        mysqli_stmt_execute($selectPostQ);
        $postResult = mysqli_stmt_get_result($selectPostQ);
        $row = mysqli_fetch_assoc($postResult);
    }
    ?>
    <h3>Updating Post</h3>
    <div class="PostCreation">
        <form class ="titlePost" action = "../pages/updateposthandle.php" method = "POST">
            <input type="hidden" id="threadId" name="threadId" value="<?php echo $_GET['thread_id']; ?>">
            <label for="postTitle" type="hidden"></label>
            <textarea id="postTitle" name="postTitle" rows="2" cols="50" maxlength="50" minlength="2" placeholder="Replace Title Here, Old title: <?php echo $row['title']; ?>"></textarea>
            <label for="postContent" type="hidden"></label>
            <textarea id="postContent" name="postContent" rows="4" cols="50" maxlength="500" minlength="10" placeholder="Replace Content Here, Old content: <?php echo $row['content']; ?>"></textarea>
            <br>
            <button class ="submit-button"type="submit">Submit</button>
            <button class ="delete-button"type="button">Delete</button>
        </form>
    </div>
</body>
</html>