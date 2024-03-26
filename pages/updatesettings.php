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
        $userCheck = mysqli_prepare($connection, "SELECT * FROM Account WHERE username = ?");
        mysqli_stmt_bind_param($userCheck, "s", $newUsername);
        mysqli_stmt_execute($userCheck);
        $result = mysqli_stmt_get_result($userCheck);
        if (mysqli_num_rows($result) > 0) {
            echo "Username already exists.";
            exit();
        }
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
    } elseif ($_POST['action'] == 'updateProfilePicture' && !empty($_FILES['newProfilePicture'])) {
        $tmp = $_FILES['newProfilePicture']['tmp_name'];
        $image = file_get_contents($tmp);
        $stmt = mysqli_prepare($connection, "UPDATE Account SET pfp = ? WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "ss", $image, $userId);
        if (mysqli_stmt_execute($stmt)) {
            echo "Profile picture updated successfully.";
        } else {
            echo "Error updating profile picture.";
        }
    } else {
        echo "Invalid request.";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error getting request";
}
mysqli_close($connection);
?>
