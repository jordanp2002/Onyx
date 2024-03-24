<?php

$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['accountId'];
    $profileId = $_POST['profileId'];

    $friendQuery = "SELECT COUNT(*) FROM Follows WHERE follower_id = ? AND followed_id = ?";
    $friendQ = mysqli_prepare($connection, $friendQuery);
        mysqli_stmt_bind_param($friendQ, "ii", $userId, $profileId);
        mysqli_stmt_execute($friendQ);
        $friendResult = mysqli_stmt_get_result($friendQ);
        $resultRow = mysqli_fetch_assoc($friendResult);
        $count = $resultRow['COUNT(*)'];
        if($count > 0){
            $query = "DELETE FROM Follows WHERE follower_id = ? AND followed_id = ?";
            $deleteQuery = mysqli_prepare($connection, $query); 
            mysqli_stmt_bind_param($deleteQuery, "ii", $userId, $profileId);
            mysqli_stmt_execute($deleteQuery);
            mysqli_stmt_close($deleteQuery);
            echo 'not success';
            
        } else {
            $query = "INSERT INTO Follows (follower_id, followed_id) VALUES (?, ?)";
            $insertQuery = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($insertQuery, "ii", $userId, $profileId);
            mysqli_stmt_execute($insertQuery);
            mysqli_stmt_close($insertQuery);
            echo 'success';
        }  
        mysqli_stmt_close($friendQ);  
} else {
    echo "Error Invalid Request";
}
?>