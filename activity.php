<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['uID'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit();
}

include 'db_conn.php';

$name = "";
$type = "";
$startdate = "";
$enddate = "";
$status = "not_started"; // Set status as 'test'
$voluid = $_SESSION['uID'];

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST["name"]);
    $type = trim($_POST["type"]);
    $startdate = trim($_POST["startdate"]);
    $enddate = trim($_POST["enddate"]);
    // Check if all fields are filled
    if (empty($name) || empty($type) || empty($startdate) || empty($enddate)) {
        $errorMessage = "All the fields are required";
    } else {
        try {
            // Check if volunteer ID exists in the volunteer table
            $voluCheckQuery = "SELECT * FROM volunteer WHERE voluID = ?";
            $voluStmt = $conn->prepare($voluCheckQuery);
            $voluStmt->bind_param("i", $voluid);
            $voluStmt->execute();
            $voluResult = $voluStmt->get_result();

            if ($voluResult->num_rows > 0) {
                // Prepared statement to insert data
                $stmt = $conn->prepare("INSERT INTO proposedactivity (activityName, activityType, activityStart, activityEnd, activityStatus, volunteerID) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssi", $name, $type, $startdate, $enddate, $status, $voluid);

                if ($stmt->execute()) {
                    $successMessage = "Your activity has been submitted.";

                    // Reset form fields
                    $name = "";
                    $type = "";
                    $startdate = "";
                    $enddate = "";

                    // Redirect after successful submission
                    header("Location: ../prototype/activityList.php");
                    exit();
                } else {
                    $errorMessage = "An error occurred: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $errorMessage = "Invalid volunteer ID.";
            }

            $voluStmt->close();
        } catch (mysqli_sql_exception $e) {
            $errorMessage = "An error occurred: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php'; ?>
</head>

<body>
    <?php include 'navBarUser.php'; ?>

    <?php if (!empty($errorMessage)): ?>
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong><?php echo $errorMessage; ?></strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
    <?php endif; ?>

    <div id="volunteer" class="form-container">
        <h2>Propose Volunteering Activity</h2>
        <form id="activity-form" method="POST" action="">
            <input type="text" id="name" name="name" placeholder="Activity Name"
                value="<?php echo htmlspecialchars($name); ?>" required>
            <div class="error" id="title-error"></div>
            <input type="text" id="type" name="type" placeholder="Activity Type"
                value="<?php echo htmlspecialchars($type); ?>" required>
            <div class="error" id="description-error"></div>
            <input type="date" id="startdate" name="startdate" value="<?php echo htmlspecialchars($startdate); ?>"
                required>
            <div class="error" id="date-error"></div>
            <input type="date" id="enddate" name="enddate" value="<?php echo htmlspecialchars($enddate); ?>" required>
            <div class="error" id="date-error"></div>
            <input type="hidden" id="voluID" name="voluID" value="<?php echo htmlspecialchars($voluid); ?>" readonly>
            <div class="error" id="organizer-error"></div>
            
            
            <button type="submit">Submit Proposal</button>
        </form>
    </div>

    <?php include 'javascript.php'; ?>
</body>
<footer>
    <p>© 2024 Love Home Charity. All rights reserved.<br>
        Contact us: <a href="mailto:info@lovehomecharity.org">info@lovehomecharity.org</a></p>
</footer>

</html>
