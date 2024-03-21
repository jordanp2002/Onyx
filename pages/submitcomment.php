<?php
session_start();
$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['comment'], $_POST['thread_id']) && !empty($_SESSION['username'])) {
    $content = $_POST['comment'];
    $threadId = $_POST['thread_id'];
    $user = $_SESSION['username'];
    $accountIdQuery = "SELECT id FROM Account WHERE username = '$user'";
    $accountIdResult = mysqli_query($connection, $accountIdQuery);
    if ($accountIdRow = mysqli_fetch_assoc($accountIdResult)) {
        $accountId = $accountIdRow['id'];
            $insertQuery = "INSERT INTO post (content, thread_id, account_id, post_like, post_dislike) VALUES (?, ?, ?, 0, 0)";
            if ($stmt = mysqli_prepare($connection, $insertQuery)) {
                mysqli_stmt_bind_param($stmt, "sii", $content, $threadId, $accountId);
                if (mysqli_stmt_execute($stmt)) {
                    echo $content;
                } else {
                    echo "Error: " . mysqli_error($connection);
                }
            } else {
                echo "Error preparing statement: " . mysqli_error($connection);
            }
        } else {
            echo "Missing comment, thread ID, or user session.";
        }
}
mysqli_close($connection);
?>

