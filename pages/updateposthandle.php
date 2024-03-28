<?php
    session_start();
    include 'databaseconnection.php';
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        $adminQuery = "SELECT * FROM Account WHERE username = ?";
        $adminQ = mysqli_prepare($connection, $adminQuery);
        mysqli_stmt_bind_param($adminQ, "s", $_SESSION['username']);
        mysqli_stmt_execute($adminQ);
        $accountResult = mysqli_stmt_get_result($adminQ);
        $row = mysqli_fetch_assoc($accountResult);
        $admin = $row['admin'];
    }
    if($admin != 1){
        header("Location: ../pages/home.php");
    }else{
        $threadID = $_POST['threadId'];
        $title = $_POST['postTitle'];
        $content = $_POST['postContent'];
        echo $threadID;
        $updatePostQuery = "UPDATE thread SET title = ?, content = ? WHERE id = ?";
        $updatePostQ = mysqli_prepare($connection, $updatePostQuery);
        mysqli_stmt_bind_param($updatePostQ, "sss", $title, $content,$threadID);
        mysqli_stmt_execute($updatePostQ);
        mysqli_stmt_close($updatePostQ);
        header("Location: ../pages/PostPage.php?thread_id=$threadID");
    }

?>