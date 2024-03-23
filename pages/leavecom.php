<?php
session_start();

$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');

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
            echo 'error did not delete';
        }
    }else {
        echo "User not found";
    }
}

?>