<?php
session_start();
include 'databaseconnection.php';
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profileId = $_POST['profileId'];
    $username = $_SESSION['username'];

    $accountIdSelect = "SELECT id FROM Account WHERE username = ?";
    $accountIdQuery = mysqli_prepare($connection, $accountIdSelect);
    mysqli_stmt_bind_param($accountIdQuery, "s", $username);
    mysqli_stmt_execute($accountIdQuery);
    $accountIdResult = mysqli_stmt_get_result($accountIdQuery);
    $resultRow = mysqli_fetch_assoc($accountIdResult);
    $userId = $resultRow['id'];
    if(!empty($userId) && !empty($profileId)){
        $friendQuery = "SELECT COUNT(*) FROM Follows WHERE follower_id = ? AND followed_id = ?";
        $friendQ = mysqli_prepare($connection, $friendQuery);
        mysqli_stmt_bind_param($friendQ, "ii", $profileId, $userId);
        mysqli_stmt_execute($friendQ);
        $friendResult = mysqli_stmt_get_result($friendQ);
        $resultRow = mysqli_fetch_assoc($friendResult);
        $count = $resultRow['COUNT(*)'];
        if($count > 0){
            $query = "DELETE FROM Follows WHERE follower_id = ? AND followed_id = ?";
            $deleteQuery = mysqli_prepare($connection, $query); 
            mysqli_stmt_bind_param($deleteQuery, "ii", $profileId, $userId);
            mysqli_stmt_execute($deleteQuery);
            mysqli_stmt_close($deleteQuery);
            echo 'success';
        }else{
            echo 'not success';
        }
    }else{
        echo 'not success';
    }
} else {
    echo "Error Invalid Request";
}

?>