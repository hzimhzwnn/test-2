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
$patientName = "";
$patientIcNum = "";
$patientGender = "";
$patientBirthDate = "";
$patientAge = "";
$patientIllness = "";
$patientReasonAdmission = "";
$addressID = "";
$contactID = "";

$addressLine1 = "";
$addressLine2 = "";
$addressPostcode = "";
$addressState = "";

$contactName = "";
$contactPhoneNo = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the data of the patient

    if (!isset($_GET["patientID"])) {
        header("location: patientPage.php");
        exit;
    }

    $id = $_GET["patientID"];

    // read the row of the selected patient from the database table
    $sql = "SELECT * FROM patient WHERE patientID = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: patientPage.php");
        exit;
    }

    $patientName = $row['patientName'];
    $patientIcNum = $row['patientIcNum'];
    $patientGender = $row['patientGender'];
    $patientBirthDate = $row['patientBirthDate'];
    $patientAge = $row['patientAge'];
    $patientIllness = $row['patientIllness'];
    $patientReasonAdmission = $row['patientReasonAdmission'];
    $addressID = $row['addressID'];
    $contactID = $row['contactID'];

    // Fetch address details
    $sql = "SELECT * FROM address WHERE addressID = '$addressID'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row) {
        $addressLine1 = $row['addressLine1'];
        $addressLine2 = $row['addressLine2'];
        $addressPostcode = $row['addressPostcode'];
        $addressState = $row['addressState'];
    }

    // Fetch contact person details
    $sql = "SELECT * FROM contactperson WHERE contactID = '$contactID'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row) {
        $contactName = $row['contactName'];
        $contactPhoneNo = $row['contactPhoneNo'];
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // POST method: Update the data of the patient

    $id = $_POST['id'];
    $patientName = $_POST['patientName'];
    $patientIcNum = $_POST['patientIcNum'];
    $patientGender = $_POST['patientGender'];
    $patientBirthDate = $_POST['patientBirthDate'];
    $patientAge = $_POST['patientAge'];
    $patientIllness = $_POST['patientIllness'];
    $patientReasonAdmission = $_POST['patientReasonAdmission'];
    $addressLine1 = $_POST['addressLine1'];
    $addressLine2 = $_POST['addressLine2'];
    $addressPostcode = $_POST['addressPostcode'];
    $addressState = $_POST['addressState'];
    $contactName = $_POST['contactName'];
    $contactPhoneNo = $_POST['contactPhoneNo'];

    do {
        if (empty($id) || empty($patientName) || empty($patientIcNum) || empty($patientGender) || empty($patientBirthDate) || empty($patientAge) || empty($patientIllness) || empty($patientReasonAdmission) || empty($addressLine1) || empty($addressPostcode) || empty($addressState) || empty($contactName) || empty($contactPhoneNo)) {
            $errorMessage = "All the fields are required";
            break;
        }

        // Update patient details
        $sql = "UPDATE patient SET patientName = '$patientName', patientIcNum = '$patientIcNum', patientGender = '$patientGender', patientBirthDate = '$patientBirthDate', patientAge = '$patientAge', patientIllness = '$patientIllness', patientReasonAdmission = '$patientReasonAdmission' WHERE patientID = '$id'";
        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        // Update address details
        $sql = "UPDATE address SET addressLine1 = '$addressLine1', addressLine2 = '$addressLine2', addressPostcode = '$addressPostcode', addressState = '$addressState' WHERE addressID = '$addressID'";
        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        // Update contact person details
        $sql = "UPDATE contactperson SET contactName = '$contactName', contactPhoneNo = '$contactPhoneNo' WHERE contactID = '$contactID'";
        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $successMessage = "Patient updated correctly";

        header("location: patientPage.php");
        exit;
    } while (false);
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include 'headAdmin.php'; ?>
    <script>
        function calculateAge() {
            const birthDate = new Date(document.getElementById("patientBirthDate").value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            document.getElementById("patientAge").value = age;
        }
    </script>
</head>

<body>
    <div class="container my-5">
        <h2>Edit Patient</h2>

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
                <label class="col-sm-3 col-form-label">Patient Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="patientName" value="<?php echo $patientName ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Patient IC Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="patientIcNum" value="<?php echo $patientIcNum ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Patient Gender</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="patientGender" value="<?php echo $patientGender ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Patient Birth Date</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="patientBirthDate" value="<?php echo $patientBirthDate ?>" onchange="calculateAge()">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Patient Age</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="patientAge" value="<?php echo $patientAge ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Patient Illness</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="patientIllness" value="<?php echo $patientIllness ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Reason for Admission</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="patientReasonAdmission" value="<?php echo $patientReasonAdmission ?>">
                </div>
            </div>

            <h3>Address</h3>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address Line 1</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="addressLine1" value="<?php echo $addressLine1 ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address Line 2</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="addressLine2" value="<?php echo $addressLine2 ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Postcode</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="addressPostcode" value="<?php echo $addressPostcode ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">State</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="addressState" value="<?php echo $addressState ?>">
                </div>
            </div>

            <h3>Contact Person</h3>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contact Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contactName" value="<?php echo $contactName ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contact Phone Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contactPhoneNo" value="<?php echo $contactPhoneNo ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="patientPage.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
