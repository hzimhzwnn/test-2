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

if (isset($_GET['voluID'])) {
    $id = $_GET['voluID'];
    include 'db_conn.php';

    // Delete the volunteer record from the database
    $sql = "DELETE FROM volunteer WHERE voluID = '$id'";
    $result = $conn->query($sql);

    if ($result) {
        $successMessage = "Volunteer deleted successfully";
        header("Location: volunteerPage.php");
        exit;
    } else {
        $errorMessage = "Error deleting volunteer: ". $conn->error;
    }
} else {
    $errorMessage = "Invalid request";
}

header("Location: volunteerPage.php");
exit;
?>