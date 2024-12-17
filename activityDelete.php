<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['aID'])) {
    // Redirect to the login page
    header('Location: loginAdmin.php');
    exit();
}

$successMessage = "";
$errorMessage = "";

if (isset($_GET['activityID'])) {
    $id = $_GET['activityID'];
    include 'db_conn.php';

    // Delete the proposed activity record from the database
    $sql = "DELETE FROM proposedactivity WHERE activityID = '$id'";
    $result = $conn->query($sql);

    if ($result) {
        $successMessage = "Proposed activity deleted successfully";
        header("Location: activityPage.php");
        exit;
    } else {
        $errorMessage = "Error deleting proposed activity: ". $conn->error;
    }
} else {
    $errorMessage = "Invalid request";
}

header("Location: activityPage.php");
exit;
?>