<?php
session_start(); 
$connection = mysqli_connect('localhost', '76966621', 'Password123', 'db_76966621');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
$user = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['postTitle'];
    $postCon =$_POST['postContent'];
    $community = $_POST['postCom'];
    $accountIdQuery = "SELECT id FROM Account WHERE username = '$user'";
    $accountIdResult = mysqli_query($connection, $accountIdQuery);
    if ($accountIdRow = mysqli_fetch_assoc($accountIdResult)) {
        $accountId = $accountIdRow['id'];

        $comIdQuery = "SELECT com_id FROM communities WHERE name = ?";
        if ($stmt = $connection->prepare($comIdQuery)) {
            $stmt->bind_param("s", $community);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $comId = $row['com_id'];

                $insertQuery = "INSERT INTO thread (title, com_id, account_id, thread_like, thread_dislike, content) VALUES (?, ?, ?, 0, 0, ?)";
                if ($insertStmt = $connection->prepare($insertQuery)) {
                    $insertStmt->bind_param("siis", $title, $comId, $accountId, $postCon);
                    $insertStmt->execute();
                    if ($insertStmt->affected_rows > 0) {
                        $newThreadId = $insertStmt->insert_id;
                        header("Location: PostPage.php?thread_id=$newThreadId");
                        exit();
                    } else {
                        echo "Error: " . $connection->error;
                    }
                }
            } else {
                echo "Community not found.";
            }
        } else {
            echo "Error preparing community ID query: " . $connection->error;
        }
    } else {
        echo "Account not found.";
    }
}

?> 