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
        $communityQuery = "SELECT COUNT(*) FROM community_membership WHERE account_id = ? AND com_id = ?";
        $communityQ = mysqli_prepare($connection, $communityQuery);
        mysqli_stmt_bind_param($communityQ, "ii", $accountId, $comId);
        mysqli_stmt_execute($communityQ);
        $comResult = mysqli_stmt_get_result($communityQ);
        $resultRow = mysqli_fetch_assoc($comResult);
        $count = $resultRow['COUNT(*)'];
        if ($count > 0) {
            $actionQuery = mysqli_prepare($connection, "DELETE FROM community_membership WHERE account_id = ? AND com_id = ?");
            mysqli_stmt_bind_param($actionQuery, "ii", $accountId, $comId);
            $response = 'join';
        } else {
            $actionQuery = mysqli_prepare($connection, "INSERT INTO community_membership (account_id, com_id) VALUES (?, ?)");
            mysqli_stmt_bind_param($actionQuery, "ii", $accountId, $comId);
            $response ='leave';
        }
        mysqli_stmt_execute($actionQuery);
        mysqli_stmt_close($actionQuery);
        echo $response;
    } else {
        echo "User not found";
    }
} else {
    echo "Error: Missing data";
}
?>


