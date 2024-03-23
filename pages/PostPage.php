<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <style>
        .post {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .post-header {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .post-subheader {
            margin-bottom: 10px;
        }
        .post-content {
            margin-bottom: 10px;
        }
        .button {
            padding: 5px 10px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .like, .dislike, .repost, .comment, .save {
            background-color: #3498db;
            color: white;
        }
        #comment-section {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .comment {
            margin-bottom: 10px;
        }
        .comment-buttons {
            margin-top: 10px;
        }
        #comment-section img {
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
    <div class="post">
    <?php
        $user = $_SESSION['username'];
        $connection = mysqli_connect("localhost", "76966621", "Password123", "db_76966621");
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if (isset($_GET['thread_id'])) {
            $threadId = $_GET['thread_id'];
            $threadQuery = "SELECT title, content, name, thread.com_id AS comId FROM thread JOIN communities ON thread.com_id = communities.com_id WHERE id = ?";
            $tweet = mysqli_prepare($connection, $threadQuery);
            if ($tweet) {
                mysqli_stmt_bind_param($tweet, "i", $threadId);
                mysqli_stmt_execute($tweet);
                $result = mysqli_stmt_get_result($tweet);
                if ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="post-header">' . $row['title'] . '</div>';
                    echo '<div class="post-content">';
                    echo '<p>' . $row['content']. '</p>';
                    echo '<p><a href="JoinableCommunityPage.php?com_id=' . $row['comId'] . '" style="text-decoration: none; color: black;">' . $row['name'] . '</a></p>';
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
        <button class="button like">Like</button>
        <button class="button dislike">Dislike</button>
        <input type="hidden" id ="thread_id" name="thread_id" value="<?php echo $threadId; ?>">
        <button class="button repost">Repost</button>
        <button class="button comment" onclick="openCommentForm()">Comment</button>
    <?php
    ?>

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
<div id = "comment-section">
<?php
$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');
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
                echo "No comments found or No comments have been added";
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['pfp']) . '" alt="Profile Picture">';
                    echo '<p><a href="RandomUserPage.php?profile=' . $row['username'] . '" style="text-decoration: none; color: black;"> '.$row['username']. '-' . $row['content'] . "</a></p>";
                    echo '<button class="button like">Like</button>';
                    echo '<button class="button dislike">Dislike</button>';
                    echo '</br>';
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
      displayComment(this.responseText);
      closeCommentForm();
  };
  xhr.send("comment=" + encodeURIComponent(comment) + "&thread_id=" + encodeURIComponent(threadId));
}

function displayComment(comment) {
  var commentsSection = document.getElementById("comment-section");
  if (!commentsSection) {
    console.error("Comment section not found");
    return;
  }
  var newComment = document.createElement("p");
  var likeButton = document.createElement("button");
  likeButton.innerHTML = "Like";
  likeButton.className = "button like";
  var dislikeButton = document.createElement("button");
  dislikeButton.innerHTML = "Dislike";
  dislikeButton.className = "button dislike"; 
  newComment.innerHTML = comment; 
  commentsSection.appendChild(newComment);
  commentsSection.appendChild(likeButton);
  commentsSection.appendChild(dislikeButton);
}
</script>
</html>
