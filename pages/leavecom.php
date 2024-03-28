<?php
session_start();
include 'databaseconnection.php';
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_SESSION['username'], $_POST['com_id'])) {
    $username = $_SESSION['username'];
    $comId = $_POST['com_id'];
    $accountIdQuery = "SELECT id FROM Account WHERE username = ?";
    $accountQ = mysqli_prepare($connection, $accountIdQuery);
    mysqli_stmt_bind_param($accountQ, "s", $username);
    mysqli_stmt_execute($accountQ);
    $result = mysqli_stmt_get_result($accountQ);
    if ($row = mysqli_fetch_assoc($result)) {
        $accountId = $row['id'];
        $communityQuery = "DELETE FROM community_membership WHERE com_id = ? AND account_id = ?";
        $communityQ = mysqli_prepare($connection, $communityQuery);
        mysqli_stmt_bind_param($communityQ, "ii", $comId, $accountId);
        mysqli_stmt_execute($communityQ);
        if(mysqli_affected_rows($connection) > 0){
            echo 'success';
        }else{
            echo 'fail';
        }
    }else {
        echo "User not found";
    }
    mysqli_stmt_close($accountQ);
    mysqli_stmt_close($communityQ);
    mysqli_close($connection);
}


?>