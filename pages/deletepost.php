<?php
session_start();

$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $postId = $_POST['post_id'];
    if(isset($postId) && !empty($postId)){
    $adminQuery = "SELECT * FROM Account WHERE username = ?";
    $adminQ = mysqli_prepare($connection, $adminQuery);
    mysqli_stmt_bind_param($adminQ, "s", $_SESSION['username']);
    mysqli_stmt_execute($adminQ);
    $accountResult = mysqli_stmt_get_result($adminQ);
    $row = mysqli_fetch_assoc($accountResult);
    $admin = $row['admin'];
    if($admin == 1){
        $query = "DELETE FROM thread WHERE id = ?";
        $deleteQuery = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($deleteQuery, "i", $postId);
        mysqli_stmt_execute($deleteQuery);
        mysqli_stmt_close($deleteQuery);
        if(mysqli_affected_rows($connection) > 0){
            echo "postsuccess";
        } else {
            echo "not success";
        }
    } else {
        echo "You do not have permission to delete this community";
    }
    } else {
        echo "Error Invalid Request";
    }
}
?>