<?php

$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'];
    $password = $_POST['password'];


    session_start();
    $query = "INSERT INTO Account (username, pword) VALUES (?, ?)";
    $signup = mysqli_prepare($connection, $query);
    if ($signup) {
        mysqli_stmt_bind_param($signup, "ss", $username, $password);
        $result = mysqli_stmt_execute($signup);
        if ($result) {
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
    
            header('Location: home.php');
            exit;
        } else {
            echo "Error: Could not execute query: " . mysqli_error($connection);
        }
        mysqli_stmt_close($signup);
    } else {
        echo "Invalid Information";
    }
    mysqli_close($connection);
}
?>