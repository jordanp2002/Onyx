<?php
include 'databaseconnection.php';
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $tmp = $_FILES['image']['tmp_name'];
    $image = file_get_contents($tmp);

    $password = md5($password);
    $checkQuery = "SELECT * FROM Account WHERE username = '$username' OR email = '$email'";
    $check = mysqli_query($connection, $checkQuery);
    if (mysqli_num_rows($check) > 0) {
        echo "Username/Email already exists";
        echo '<a href="../pages/signup.php">Go back</a>';
    } else{
            if (isset($_FILES['image'])) {
            session_start();
            $query = "INSERT INTO Account (username, pword,pfp, email) VALUES (?, ?, ?, ?)";
            $signup = mysqli_prepare($connection, $query);
            if ($signup) {
                mysqli_stmt_bind_param($signup, "ssss", $username, $password,$image, $email);
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
    }
}else{
    echo 'error';
}
?>