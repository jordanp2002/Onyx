<?php
session_start();
include 'databaseconnection.php';
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    $title = $_POST['comTitle'];
    $postCon = $_POST['comDesc'];
    $tmp = $_FILES['image']['tmp_name'];
    $image = file_get_contents($tmp); 

    $insertCommunityQuery = "INSERT INTO communities (name, descrip, image) VALUES (?, ?, ?)";
    if ($comQ = mysqli_prepare($connection, $insertCommunityQuery)) {
        mysqli_stmt_bind_param($comQ, "sss", $title, $postCon, $image);
        mysqli_stmt_execute($comQ);
        $newComId = mysqli_insert_id($connection); 
        $accountIdQuery = "SELECT id FROM Account WHERE username = ?";
        if ($accountQ = mysqli_prepare($connection, $accountIdQuery)) {
            mysqli_stmt_bind_param($accountQ, "s", $_SESSION['username']);
            mysqli_stmt_execute($accountQ);
            $result = mysqli_stmt_get_result($accountQ);
            if ($row = mysqli_fetch_assoc($result)) {
                $accountId = $row['id'];
                $insertMembershipQuery = "INSERT INTO community_membership (account_id, com_id) VALUES (?, ?)";
                if ($memberQ = mysqli_prepare($connection, $insertMembershipQuery)) {
                    mysqli_stmt_bind_param($memberQ, "ii", $accountId, $newComId);
                    mysqli_stmt_execute($memberQ);
                    header("Location: JoinableCommunityPage.php?com_id=$newComId");
                    echo "Community created and membership added.";
                }
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
    mysqli_close($connection);
} else {
    echo "Error Invalid Request";
}
?>
