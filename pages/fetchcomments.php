<?php
include 'databaseconnection.php';
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_GET['thread_id']) && isset($_GET['last_comment_id'])) {
    $thread_id = $_GET['thread_id'];
    $last_comment_id = $_GET['last_comment_id'];
    $sql = "SELECT post.post_id, post.content, post.account_id, Account.username, Account.pfp 
            FROM post 
            JOIN Account ON post.account_id = Account.id 
            WHERE post.thread_id = '$thread_id' AND post.post_id > '$last_comment_id' 
            ORDER BY post.post_id ASC";
    $result = mysqli_query($connection, $sql);
    $comments = [];
    while($row = mysqli_fetch_assoc($result)) {
        $encode = base64_encode($row['pfp']);
        $comments[] = [
            'post_id' => $row['post_id'],
            'content' => $row['content'],
            'account_id' => $row['account_id'],
            'username' => $row['username'], 
            'pfp' => $encode 
        ];
    }
    echo json_encode($comments);
} else {
    echo json_encode(["Error" => "Required parameters not provided"]);
}
mysqli_close($connection);
?>

