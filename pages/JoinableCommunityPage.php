<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joinable Community Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <style>
        body {
            background-color: #181818;
            font-family: 'Roboto', sans-serif;
        }
        .headernav{
            margin-bottom: 20px;
        }
        .tweet {
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #8758FF;
            margin-left : 20%;
            margin-right : 20%;

        }
        .tweet img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .community-info {
            box-shadow: 4px 4px 8px 8px rgba(135, 13, 216, 0.6);
            width: 100%;
            padding-bottom: 10px;
            padding-left: 40px;
            padding-top: 10px;
            background-color: #8758FF;
            position : fixed;
            bottom: 0;
            display: grid;
            grid-template-columns: auto 1fr;
        }
        .community-info h2 {
            margin-bottom: 10px;
            
        }
        .join-button {
            justify-self: end;
            margin-right: 10%;
            padding-left: 40px;
            padding-right: 40px;
            background-color: #4CAF50;
            color: white;
            border: none;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .leave-button{
            justify-self: end;
            margin-right : 10%;
            padding-left: 40px;
            padding-right: 40px;
            background-color: red;
            color: white;
            border: none;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;

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
        <ul>
            <li><?php echo $_SESSION['username']; ?><li>
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
    <?php
    include 'databaseconnection.php';
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['com_id'])) {
        $comId = $_GET['com_id'];
        $query = "SELECT title, content, username,pfp FROM communities 
        JOIN thread ON communities.com_id = thread.com_id 
        JOIN Account ON thread.account_id = Account.id 
        WHERE communities.com_id = ?";
        $tweetQuery = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($tweetQuery, "s", $comId);
        mysqli_stmt_execute($tweetQuery);
        $result = mysqli_stmt_get_result($tweetQuery);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="tweet">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['pfp']) . '" alt="Profile Picture">';
                echo '<div>';
                    echo '<div class="username">'. $row['username'].'</div>';
                    echo '<p>'. $row['title'] .'</p>';
                   echo '<p>'. $row['content'] .'</p>';
                echo'</div>';
            echo '</div>';
            }
        }else{
            echo "no entries found";
        }
    }
    ?>
    <?php
        $query = "SELECT name FROM communities WHERE com_id =?";
        $nameQuery = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($nameQuery, "i", $comId);
        mysqli_stmt_execute($nameQuery);
        $result = mysqli_stmt_get_result($nameQuery);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="community-info">';
                echo '<h2>' . $row['name'].'</h2>';
                
            }
        }else{
            echo "no entries found";
        }
    ?>
    <?php
        $isMember = false;
        $buttonText = "Join Community";
        $comId = $_GET['com_id'];
        $buttonClass = "join-button";
        if (isset($_SESSION['username']) && $comId !== null) {
            $username = $_SESSION['username'];
            $query = "SELECT id FROM Account WHERE username = ?";
            $accountIdQuery = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($accountIdQuery, "s", $username);
            mysqli_stmt_execute($accountIdQuery);
            $accountIdResult = mysqli_stmt_get_result($accountIdQuery);
            if ($accountIdRow = mysqli_fetch_assoc($accountIdResult)) {
                $accountId = $accountIdRow['id'];
                $query2 = "SELECT * FROM community_membership WHERE account_id = ? AND com_id = ?";
                $membershipQuery = mysqli_prepare($connection, $query2);
                mysqli_stmt_bind_param($membershipQuery, "ii", $accountId, $comId);
                mysqli_stmt_execute($membershipQuery);
                $membershipResult = mysqli_stmt_get_result($membershipQuery);
                if (mysqli_num_rows($membershipResult) > 0) {
                    $isMember = true;
                    $buttonText = "Leave";
                    $buttonClass = "leave-button";
                }
                mysqli_stmt_close($membershipQuery);
            }
            mysqli_stmt_close($accountIdQuery);
        }
        ?>
    <input type="hidden" id="comId" name="comId" value="<?php echo $comId; ?>">
    <button id="communityAction" class="<?php echo $buttonClass; ?>" onclick="toggleMembership()">
        <?php echo $buttonText; ?>
    </button>
    </div>
<script>
function toggleMembership() {
    var xhr = new XMLHttpRequest();
    var comId = document.getElementById("comId").value;
    xhr.open("POST", "joincom.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
            var btn = document.getElementById("communityAction");
            var responseText = this.responseText.trim().toLowerCase();
            if (responseText === 'leave') {
                btn.innerHTML = "Leave";
                btn.style.backgroundColor = "red";
            } else if (responseText === 'join') {
                btn.innerHTML = "Join Community";
                btn.style.backgroundColor = "#4CAF50"; 
            }
    };
    xhr.send("com_id=" +  encodeURIComponent(comId));
}
</script>
</div>
</body>
</html>
