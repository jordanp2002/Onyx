<?php
session_start();
include 'databaseconnection.php';
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $userId = $_SESSION['username']; 
    if ($_POST['action'] == 'updateUsername' && !empty($_POST['newUsername'])) {
        $newUsername = $_POST['newUsername'];
        $stmt = mysqli_prepare($connection, "UPDATE Account SET username = ? WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "ss", $newUsername, $userId);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['username'] = $newUsername; 
            echo "Username updated successfully.";
        } else {
            echo "Error updating username.";
        }
    } elseif ($_POST['action'] == 'updatePassword' && !empty($_POST['newPassword'])) {
        $newPassword = $_POST['newPassword'];
        $stmt = mysqli_prepare($connection, "UPDATE Account SET pword = ? WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "ss", $newPassword, $userId);
        if (mysqli_stmt_execute($stmt)) {
            echo "Password updated successfully.";
        } else {
            echo "Error updating password.";
        }
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error getting request";
}
mysqli_close($connection);
?>
