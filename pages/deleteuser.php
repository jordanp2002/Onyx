<?php
session_start();
include 'databaseconnection.php';
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $userId = $_POST['user_id'];
    if(isset($userId) && !empty($userId)){
    $adminQuery = "SELECT * FROM Account WHERE username = ?";
    $adminQ = mysqli_prepare($connection, $adminQuery);
    mysqli_stmt_bind_param($adminQ, "s", $_SESSION['username']);
    mysqli_stmt_execute($adminQ);
    $accountResult = mysqli_stmt_get_result($adminQ);
    $row = mysqli_fetch_assoc($accountResult);
    $admin = $row['admin'];
    if($admin == 1){
        $query = "DELETE FROM Account WHERE id = ?";
        $deleteQuery = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($deleteQuery, "i", $userId);
        mysqli_stmt_execute($deleteQuery);
        mysqli_stmt_close($deleteQuery);
        if(mysqli_affected_rows($connection) > 0){
            echo "usersuccess";
        } else {
            echo "not success";
        }
    } else {
        echo "You do not have permission to delete this user";
    }
    } else {
        echo "Error Invalid Request";
    }
}
?>