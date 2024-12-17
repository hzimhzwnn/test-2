<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['aID'])) {
    // Redirect to the login page
    header('Location: loginAdmin.php');
    exit();
}

include 'db_conn.php';

$id = "";
$activityName = "";
$activityType = "";
$activityStart = "";
$activityEnd = "";
$activityStatus = "";
$volunteerId = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the data of the activity

    if (!isset($_GET["activityID"])) {
        header("location: activityPage.php");
        exit;
    }

    $id = $_GET["activityID"];

    // read the row of the selected activity from the database table
    $sql = "SELECT * FROM proposedactivity WHERE activityID = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: activityPage.php");
        exit;
    }

    $activityName = $row['activityName'];
    $activityType = $row['activityType'];
    $activityStart = $row['activityStart'];
    $activityEnd = $row['activityEnd'];
    $activityStatus = $row['activityStatus'];
    $volunteerId = $row['volunteerId'];
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // POST method: Update the data of the activity

    $id = $_POST['id'];
    $activityName = $_POST['activityName'];
    $activityType = $_POST['activityType'];
    $activityStart = $_POST['activityStart'];
    $activityEnd = $_POST['activityEnd'];
    $activityStatus = $_POST['activityStatus'];
    $volunteerId = $_POST['volunteerId'];

    do {
        if (empty($id) || empty($activityName) || empty($activityType) || empty($activityStart) || empty($activityEnd) || empty($activityStatus) || empty($volunteerId)) {
            $errorMessage = "All the fields are required";
            break;
        }

        $sql = "UPDATE proposedactivity SET activityName = '$activityName', activityType = '$activityType', activityStart = '$activityStart', activityEnd = '$activityEnd', activityStatus = '$activityStatus', volunteerId = '$volunteerId' WHERE activityID = '$id'";
        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $successMessage = "Activity updated correctly";

        header("location: activityPage.php");
        exit;
    } while (false);
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include 'headAdmin.php'; ?>
</head>

<body>
    <div class="container my-5">
        <h2>Edit Activity</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div> 
            ";
        }

        if (!empty($successMessage)) {
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>$successMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div> 
            ";
        }
        ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">ACTIVITY NAME</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="activityName" value="<?php echo $activityName ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">ACTIVITY TYPE</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="activityType" value="<?php echo $activityType ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">ACTIVITY START</label>
                <div class="col-sm-6">
                    <input type="datetime-local" class="form-control" name="activityStart" value="<?php echo $activityStart ?>">
    </div>
    </form>
    </div>
</body>

</html>