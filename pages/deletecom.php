<?php
session_start();
include 'databaseconnection.php';
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $comId = $_POST['com_id'];
    if(isset($comId) && !empty($comId)){
    $adminQuery = "SELECT * FROM Account WHERE username = ?";
    $adminQ = mysqli_prepare($connection, $adminQuery);
    mysqli_stmt_bind_param($adminQ, "s", $_SESSION['username']);
    mysqli_stmt_execute($adminQ);
    $accountResult = mysqli_stmt_get_result($adminQ);
    $row = mysqli_fetch_assoc($accountResult);
    $admin = $row['admin'];
    if($admin == 1){
        $query = "DELETE FROM communities WHERE com_id = ?";
        $deleteQuery = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($deleteQuery, "i", $comId);
        mysqli_stmt_execute($deleteQuery);
        mysqli_stmt_close($deleteQuery);
        if(mysqli_affected_rows($connection) > 0){
            echo "success";
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