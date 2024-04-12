<?php
session_start();
include 'databaseconnection.php';
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_SESSION['username']) && isset($_POST['thread_id'])) {
    $accountName = $_SESSION['username'];
    $threadId = $_POST['thread_id'];
    $query = "SELECT id FROM Account WHERE username = ?";
    $usernameQuery = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($usernameQuery, "s", $accountName);
    mysqli_stmt_execute($usernameQuery);
    $result = mysqli_stmt_get_result($usernameQuery);
    if ($row = mysqli_fetch_assoc($result)) {
        $accountId = $row['id'];
        $savedQuery = "SELECT COUNT(*), thread_like, thread_dislike FROM likes WHERE account_id = ? AND thread_id = ?";
        $saveQ = mysqli_prepare($connection, $savedQuery);
        mysqli_stmt_bind_param($saveQ, "ii", $accountId, $threadId);
        mysqli_stmt_execute($saveQ);
        $saveResult = mysqli_stmt_get_result($saveQ);
        $resultRow = mysqli_fetch_assoc($saveResult);
        $count = $resultRow['COUNT(*)'];
        if ($count > 0) {
            if($resultRow['thread_like'] == 1){
                $actionQuery = mysqli_prepare($connection, "UPDATE likes SET thread_like = 0 WHERE account_id = ? AND thread_id = ?");
                mysqli_stmt_bind_param($actionQuery, "ii", $accountId, $threadId);
                mysqli_stmt_execute($actionQuery);
                $response = 'like';
            } else {
                $actionQuery = mysqli_prepare($connection, "UPDATE likes SET thread_like = 1 WHERE account_id = ? AND thread_id = ?");
                mysqli_stmt_bind_param($actionQuery, "ii", $accountId, $threadId);
                mysqli_stmt_execute($actionQuery);
                $response = 'unlike';
            }
        } else {
            $actionQuery = mysqli_prepare($connection, "INSERT INTO likes (account_id, thread_id, thread_like, thread_dislike) VALUES (?, ?, 1, 0)");
            mysqli_stmt_bind_param($actionQuery, "ii", $accountId, $threadId);
            $response ='unlike';
        }
        mysqli_stmt_execute($actionQuery);
        mysqli_stmt_close($actionQuery);
        echo $response;
        
    } else{
        echo "Error preparing statement: " . mysqli_error($connection);
    }
} else {
    echo "Error Invalid Request";
}

?>