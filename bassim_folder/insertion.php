<?php

$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $profileId = $_POST['profileId'];
    
    if() {
        $query = "INSERT INTO Follows (follower_id, followed_id) VALUES ($userId, $profileId)";
        $insertQuery = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($insertQuery, "s", $_userId);
        $success = mysqli_stmt_execute($insertQuery);
        mysqli_stmt_close($insertQuery);
        if ($success) {
            echo "success";
        } else { 
            echo "error";
        }
    } else if() {
        $query = "DELETE FROM Follows WHERE follower_id = $userId";
        $deleteQuery = mysqli_prepare($connection, $query); 
        mysqli_stmt_bind_param($deleteQuery, "s", $_userId);
        $success = mysqli_stmt_execute($deleteQuery);
        mysqli_stmt_close($deleteQuery);
        
        if($success) {
            echo "success";
        } else {
            echo "error";
        } 
    }    
}