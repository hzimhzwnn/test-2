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

if (isset($_GET['patientID'])) {
    $id = $_GET['patientID'];
    include 'db_conn.php';

    // Delete the patient record from the database
    $sql = "DELETE FROM patient WHERE patientID = '$id'";
    $result = $conn->query($sql);

    if ($result) {
        $successMessage = "Patient deleted successfully";
        header("Location: patientPage.php");
        exit;
    } else {
        $errorMessage = "Error deleting patient: " . $conn->error;
    }
} else {
    $errorMessage = "Invalid request";
}

header("Location: patientPage.php");
exit;
?>
