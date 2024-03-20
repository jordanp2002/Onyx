<?php

$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Account WHERE username = '$username' AND pword = '$password'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;

        header('Location: home.php');
        exit;
    } else {
        echo "Invalid username or password";
    }
}
?>