<?php
include 'databaseconnection.php';
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$thread_id = isset($_GET['thread_id']) ? $_GET['thread_id'] : '';

$thread_id = mysqli_real_escape_string($conn, $thread_id);
$sql = "SELECT content FROM post WHERE thread_id = '$thread_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $content = $row['content'];
        if($content) {
            echo $content;
        }else{
            echo "No comments found";
        }
    }
} else {
    echo "No comments found";
}

mysqli_close($conn);
?>
