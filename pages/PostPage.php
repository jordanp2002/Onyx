<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #181818;
        color: #333;
    }

    .headernav header h1, .headernav nav ul li {
        display: inline-block;
        margin-right: 20px;
    }

    .post {
        background-color: #8758FF;
        padding: 20px;
        margin-top: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-left: 20%;
        margin-right: 20%;
    }
    .post-header {
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 24px;
        color: #181818;
        display: flex;
        justify-content: center;
        align-items: center;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .post-content {
        color: #181818;
        margin-bottom: 20px;
    }
    .hover:hover{
        text-decoration: underline;
    }
    .button {
        padding: 10px 15px;
        margin-right: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .button:hover {
        opacity: 0.8;
    }
    .post-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        overflow : scroll;
    }
    .like, .dislike, .repost, .comment, .save, .unsave {
        background-color: #181818;
        color: white;
    }
    .button like, .button dislike, .button unlike, .button undislike {
        background-color: #181818;
        color: white;
    }
    .popup {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0,0.4);
    }

    .popup-content {
        background-color: #8758FF;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        border-radius: 8px;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    #comment-section {
            margin-top: 20px;
            padding-top: 10px;
        }
    .comment-text {
            padding : 10px;
            align-items: center;
            justify-content: center;
            background-color: #8758FF;
            margin-left: 25%;
            margin-right: 25%;
            border-radius: 8px;
    }
    .comment-buttons {
            margin-top: 10px;
    }
    #comment-section img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
    }
    .thread-fig{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
        border : 2px solid black;
        box-shadow: 0 2px 4px rgba(0,0,0,0.4);
    }
    .post p {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .comment-text {
    display: grid;
    grid-template-columns: 40px 2fr;
    margin-bottom: 5px;
    }
    .comment-content {
        grid-column: span 2;
        margin-left: 40px;
        color : #181818;
    }
    


    </style>
</head>
<?php
session_start();
?>
<body>
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
    <div class="post">
    <?php
        if (isset($_GET['thread_id'])) {
            $threadId = $_GET['thread_id'];
            $threadQuery = "SELECT 
            thread.title, 
            thread.content, 
            communities.name, 
            thread.com_id AS comId, 
            COALESCE(SUM(likes.thread_like), 0) AS likes, 
            COALESCE(SUM(likes.thread_dislike), 0) AS dislikes
            FROM thread
            LEFT JOIN communities ON thread.com_id = communities.com_id
            LEFT JOIN likes ON thread.id = likes.thread_id
            WHERE thread.id = ?
            GROUP BY thread.id;";
            $tweet = mysqli_prepare($connection, $threadQuery);
            if ($tweet) {
                mysqli_stmt_bind_param($tweet, "i", $threadId);
                mysqli_stmt_execute($tweet);
                $result = mysqli_stmt_get_result($tweet);
                if ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="post-header">' . $row['title'] . '</div>';
                    echo '<div class="post-content">';
                    echo '<figure class = "thread-fig">';
                    echo '<p>' . $row['content']. '</p>';
                    echo '</figure>';
                    echo '<p class ="hover"><a href="JoinableCommunityPage.php?com_id=' . $row['comId'] . '" style="text-decoration: none; color: black;"> Community: ' . $row['name'] . '</a></p>';
                    echo '<p id = "likes"> post likes: ' . $row['likes'] . ' post dislikes: ' . $row['dislikes'] . '<p>';
                } else {
                    echo "Thread not found.";
                }
                mysqli_stmt_close($tweet);
            } else {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
            echo "No thread ID provided.";
        }
    ?>
    
    </div>
    <div class="post-buttons">
        <input type="hidden" id ="thread_id" name="thread_id" value="<?php echo $threadId; ?>">
        <?php
        $isSaved = False;
        $buttonTextSave = "Save";
        $threadId = $_GET['thread_id'];
        $buttonClassSave = "button save";
        $buttonLikeText = "Like";
        $buttonDislikeText = "Dislike";
        $buttonClassLike = "button like";
        $buttonClassDislike = "button dislike";
        if (isset($_SESSION['username']) && $threadId !== null) {
            $username = $_SESSION['username'];
            $query = "SELECT id FROM Account WHERE username = ?";
            $accountIdQuery = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($accountIdQuery, "s", $username);
            mysqli_stmt_execute($accountIdQuery);
            $accountIdResult = mysqli_stmt_get_result($accountIdQuery);
            if ($accountIdRow = mysqli_fetch_assoc($accountIdResult)) {
                $accountId = $accountIdRow['id'];
                $likeQuery = "SELECT * FROM likes WHERE account_id = ? AND thread_id = ?";
                $query2 = "SELECT * FROM saved_threads WHERE account_id = ? AND thread_id = ?";
                $membershipQuery = mysqli_prepare($connection, $query2);
                mysqli_stmt_bind_param($membershipQuery, "ii", $accountId, $threadId);
                mysqli_stmt_execute($membershipQuery);
                $membershipResult = mysqli_stmt_get_result($membershipQuery);
                $likeQ = mysqli_prepare($connection, $likeQuery);
                mysqli_stmt_bind_param($likeQ, "ii", $accountId, $threadId);
                mysqli_stmt_execute($likeQ);
                $likeResult = mysqli_stmt_get_result($likeQ);
                if (mysqli_num_rows($membershipResult) > 0) {
                    $isSaved = true;
                    $buttonTextSave = "Unsave";
                    $buttonClassSave = "button unsave";
                }
                if(mysqli_num_rows($likeResult) > 0){
                    $likeRow = mysqli_fetch_assoc($likeResult);
                    if($likeRow['thread_like'] == 1){
                        $buttonLikeText = "Unlike";
                        $buttonClassLike = "button unlike";
                    }else if($likeRow['thread_dislike'] == 1){
                        $buttonDislikeText = "Undislike";
                        $buttonClassDislike = "button dislike";
                    }
                }else{

                }
                mysqli_stmt_close($membershipQuery);
            }
            mysqli_stmt_close($accountIdQuery);
        }
        mysqli_close($connection);
        ?>
        <input type="hidden" id ="thread_id2" name="thread_id2" value="<?php echo $threadId; ?>">
        <button class="<?php echo $buttonClassLike; ?>" id= "likeBtn" onclick = "newLike()"><?php echo $buttonLikeText; ?></button>
        <button class="<?php echo $buttonClassDislike; ?>"id = "dislikeBtn" onclick ="newDislike()"><?php echo $buttonDislikeText; ?></button>
        <button id ="saveBtn" class="<?php echo $buttonClassSave; ?>" onclick= "toggleSave()"><?php echo $buttonTextSave; ?></button>
        <button class="button comment" onclick="openCommentForm()">Comment</button>
        <script>
            function newLike(){
                var xhr = new XMLHttpRequest();
                var threadId = document.getElementById("thread_id2").value;
                xhr.open("POST", "likepost.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    var btn = document.getElementById("likeBtn");
                    var responseText = this.responseText.trim().toLowerCase();
                    if (responseText === 'unlike') {
                        btn.innerHTML = "unlike";
                    }else if (responseText === 'like') {
                        btn.innerHTML = "like";
                    }
                };
                xhr.onerror = function() {
                    console.error("Request failed.");
                };
                xhr.send("thread_id=" +  encodeURIComponent(threadId));
            }
            function newDislike(){
                var xhr = new XMLHttpRequest();
                var threadId = document.getElementById("thread_id2").value;
                xhr.open("POST", "dislikepost.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    var btn = document.getElementById("dislikeBtn");
                    var responseText = this.responseText.trim().toLowerCase();
                    if (responseText === 'undislike') {
                        btn.innerHTML = "Undislike";
                    }else if (responseText === 'dislike') {
                        btn.innerHTML = "Dislike";
                    }
                };
                xhr.onerror = function() {
                    console.error("Request failed.");
                };
                xhr.send("thread_id=" +  encodeURIComponent(threadId));
            }
            function toggleSave(){
                var xhr = new XMLHttpRequest();
                var threadId = document.getElementById("thread_id2").value;
                xhr.open("POST", "savepost.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    var btn = document.getElementById("saveBtn");
                    var responseText = this.responseText.trim().toLowerCase();
                    if (responseText === 'unsave') {
                        btn.innerHTML = "Unsave";
                    } else if (responseText === 'save') {
                        btn.innerHTML = "Save"; 
                    }
                };
                xhr.onerror = function() {
                    console.error("Request failed.");
                };
                xhr.send("thread_id=" +  encodeURIComponent(threadId));
                };
        </script>
        <div id="commentFormPopup" class="popup">
            <div class="popup-content">
                <span class="close" onclick="closeCommentForm()">&times;</span>
                <form id="commentForm">
                    <label for="comment">Comment:</label>
                    <input type="hidden" id ="thread_id" name="thread_id" value="<?php echo $threadId; ?>">
                    <textarea id="comment" name="comment" rows="4" cols="50"></textarea>
                    <button type="button" id="commentSubmitButton">Submit Comment</button>
                </form>
            </div>`
        </div>
    </div>
</div>
<div id="comment-section">
    <?php
    include 'databaseconnection.php';
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (!$connection) {
        die("Connection failed: " . mysqli_error($connection));
    }
        if (isset($_GET['thread_id'])) {
            $threadId = $_GET['thread_id'];
            $commentQuery = "SELECT Account.username, post.content , Account.pfp
                            FROM post 
                            JOIN Account ON post.account_id = Account.id 
                            WHERE post.thread_id = ?";
            $comment = mysqli_prepare($connection, $commentQuery);
            if ($comment) {
                mysqli_stmt_bind_param($comment, "i", $threadId);
                mysqli_stmt_execute($comment);
                $result = mysqli_stmt_get_result($comment);
                if (mysqli_num_rows($result) === 0) {
                    echo "<p>No Fetching Comments.</p>";
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="comment-text">';
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['pfp']) . '" alt="Profile Picture">';
                        echo '<p class ="hover"><a href="RandomUserPage.php?profile=' . $row['username'] . '" style="text-decoration: none; color: black;"> '.$row['username']. "</a></p>";
                        echo '<div class="comment-content">';
                        echo '<p>' . $row['content'] . '</p>';
                        echo '</div>';

                        echo '</div>';
                    }
                }
                mysqli_stmt_close($comment);
            } else {
                echo "Error preparing statement: " . mysqli_error($connection);
            }
        } else {
            echo "No thread ID provided.";
        }
?>
</div>
</body>
<script>
var isLoggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;
document.getElementById('commentSubmitButton').addEventListener('click', function() {
    if (!isLoggedIn) {
        window.location.href = 'login.php'; 
    } else {
        submitComment();
    }
});
function openCommentForm() {
  document.getElementById("commentFormPopup").style.display = "block";
}

function closeCommentForm() {
  document.getElementById("commentFormPopup").style.display = "none";
}

function submitComment() {
  var comment = document.getElementById("comment").value;
  var threadId = document.getElementById("thread_id").value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "submitcomment.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function() {
      closeCommentForm();
  };
  xhr.send("comment=" + encodeURIComponent(comment) + "&thread_id=" + encodeURIComponent(threadId));
}
let lastCommentId = localStorage.getItem('lastCommentId') || 0;
function fetchNewComments() {
    var threadId = document.getElementById("thread_id").value;
    console.log("lastCommentId before request:", lastCommentId);
    console.log("Fetching new comments for thread " + threadId);
    var xhr = new XMLHttpRequest();
    xhr.open("GET", `fetchcomments.php?thread_id=${encodeURIComponent(threadId)}&last_comment_id=${lastCommentId}`, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
    if (this.status == 200) {
        var comments = JSON.parse(this.responseText);
        if(comments.length > 0) {
            comments.forEach(comment => {
                console.log("postId" + comment.post_id)
                if(comment.post_id > lastCommentId) {
                    displayFetch(comment);
                }
                lastCommentId = comment.post_id;
                localStorage.setItem('lastCommentId', lastCommentId);
            });
        } else {
            console.log("No new comments found");
        }
    }
}; 
xhr.send(); 
}
function displayFetch(comment) {
    var commentDiv = document.createElement("div");
    commentDiv.className = "comment-text";

    var img = document.createElement("img");
    img.src = "data:image/jpeg;base64," + comment.pfp;
    img.alt = "Profile Picture";
    img.style.width = '35px'; 
    img.style.height = '35px'; 
    commentDiv.appendChild(img);

    var userLink = document.createElement("a");
    userLink.href = "RandomUserPage.php?profile=" + comment.username;
    userLink.style.textDecoration = "none";
    userLink.style.color = "black";
    userLink.textContent = comment.username;

    var userPara = document.createElement("p");
    userPara.appendChild(userLink);
    commentDiv.appendChild(userPara);

    var contentDiv = document.createElement("div");
    contentDiv.className = "comment-content";

    var commentPara = document.createElement("p");
    commentPara.textContent = comment.content;
    contentDiv.appendChild(commentPara);
    commentDiv.appendChild(contentDiv);

    var commentsSection = document.getElementById("comment-section");
    commentsSection.appendChild(commentDiv);
}

setInterval(fetchNewComments, 1000);
</script>
</html>
