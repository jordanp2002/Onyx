<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <style>
        .search-bar {
            margin-top: 20px;
            margin-bottom: 20px;
            margin-left: 2%;
        }
        .tweet {
            border: 1px solid black;
            padding: 10px;
            margin-bottom: 20px;
            display: flex;
            background-color: #8758FF;
            box-shadow: 0 4px 10px rgba(0,0,0,0.4);
            border-radius: 5px;
            
        }
        .tweet p{
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            max-width: 250px;
        }
        .tweet img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .community img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .community{
            border: 1px solid black;
            padding: 10px;
            margin-bottom: 20px;
            display: flex;
            background-color: #8758FF;
            box-shadow: 0 4px 10px rgba(0,0,0,0.4);
            border-radius: 5px;
        }
        .
        .tweet .username {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .search-results {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .search-results h2{
            background-color: #181818;
            color : white;
            text-shadow: rgba(255, 255, 255, 0.392) 1px 1px 1px;
        }
        .results {
            flex-basis: 44%; 
            margin-bottom: 20px; 
        }

        .tweets , .communities {
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.6);
            background-color: #8758FF;
            border-radius: 5px;
            margin-left: 2%;
            margin-right: 2%;
            text-decoration: none;
        }
        .search-bar {
        justify-content: center;  
      

        }
        .search-bar input[type="text"] {
        padding: 10px;
        border-radius: 5px;
        width: calc(100% - 145px);
        margin-right: 10px; 
        border: 3px solid #8758F1;
        background-color: #181818;
        color: white;
        }
        .search-bar button {
        padding: 10px 20px;
        background-color: #8758FF;
        color: white;
        border: none;
        border-radius: 5px;  
        }
        .search-bar button:hover {
        background-color: #8758F1;
        }

    </style>
</head>
<?php
    session_start();
?>
<body>
    <div class="headernav">
        <header>
            <h1>Onyx</h1>
        </header>
        <nav>
            <ul><?php
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
                <li><a href="../pages/logout">Logout</a></li>
            </ul>
        </nav>
    </div>
<div class="search-bar">
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET"> 
        <input type="text" id = "searchTerm" name="searchTerm" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
</div>
<div class="search-results">
    <div class="results tweets">
    <h2 class = "tweets"> Tweets </h2> 
<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['searchTerm'])) {
        $searchTerm = $_GET['searchTerm'];
        $searchTerm = "%" . $searchTerm . "%";

        $query = "SELECT title, content, username, pfp, thread.id AS threadid FROM thread JOIN Account on thread.account_id = Account.id WHERE title LIKE ? OR content LIKE ? OR username LIKE ?";
        $tweet = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($tweet, "sss", $searchTerm, $searchTerm, $searchTerm);
        mysqli_stmt_execute($tweet);
        $result = mysqli_stmt_get_result($tweet);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="tweet">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['pfp']) . '" alt="Profile Picture">';
                echo '<div><a href="PostPage.php?thread_id=' . $row['threadid'] . '"style="text-decoration: none; color: black;">';
                echo '<div class="username">' . $row['title'] . ' By ' . $row['username'] . '</div>';
                echo '<p>'. $row['content'].'</p>';
                echo '</a></div>';
                echo '</div>';
            }
        }else{
            echo "no entries found";
        }
        mysqli_stmt_close($tweet);
    }
?>
    </div>
    <div class="results communities">
        <h2 class = "tweets"> Communities </h2> 
<?php
    $comquery = "SELECT name,descrip,com_id FROM communities WHERE name LIKE ? OR descrip LIKE ?";
    $communitySearch = mysqli_prepare($connection, $comquery);
    mysqli_stmt_bind_param($communitySearch, "ss", $searchTerm, $searchTerm);
    mysqli_stmt_execute($communitySearch);
    $result = mysqli_stmt_get_result($communitySearch);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="community"><a href="JoinableCommunityPage.php?com_id='.$row['com_id'].'" style="text-decoration: none; color: black;">';
            echo '<div>';
            echo '<div class="community-name">' . $row['name'] . '</div>';
            echo '<p>'. $row['descrip'].'</p>';
            echo '</div>';
            echo '</a></div>';
        }
    }else{
        echo "No communities found.";
    }
    mysqli_stmt_close($communitySearch);
    mysqli_close($connection);
?> 
    </div>
</div>
<script>
    document.getElementById('searchTerm').addEventListener('submit', function(e) {
       var searchTerm = document.getElementById('searchTerm').value;
       var searchTermInput = document.getElementById('searchTerm');

       var specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
         if (specialChars.test(searchTerm)) {
              alert("Please enter a valid search term.");
              e.preventDefault();
              return false;
         }
    });
</script>
</body>
</html>
