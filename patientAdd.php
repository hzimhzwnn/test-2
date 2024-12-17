<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['aID'])) {
    // Redirect to the login page
    header('Location: loginAdmin.php');
    exit();
}
?>

<?php
include 'db_conn.php';


$patientName = "";
$patientIcNum = "";
$patientGender = "";
$patientBirthDate = "";
$patientAge = "";
$patientIllness = "";
$patientReasonAdmission = "";
$addressLine1 = "";
$addressLine2 = "";
$addressPostcode = "";
$addressState = "";
$contactName = "";
$contactPhoneNo = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientName = isset($_POST["patientName"]) ? $_POST["patientName"] : "";
    $patientIcNum = isset($_POST["patientIcNum"]) ? $_POST["patientIcNum"] : "";
    $patientGender = isset($_POST["patientGender"]) ? $_POST["patientGender"] : "";
    $patientBirthDate = isset($_POST["patientBirthDate"]) ? $_POST["patientBirthDate"] : "";
    $patientAge = isset($_POST["patientAge"]) ? $_POST["patientAge"] : "";
    $patientIllness = isset($_POST["patientIllness"]) ? $_POST["patientIllness"] : "";
    $patientReasonAdmission = isset($_POST["patientReasonAdmission"]) ? $_POST["patientReasonAdmission"] : "";
    $addressLine1 = isset($_POST["addressLine1"]) ? $_POST["addressLine1"] : "";
    $addressLine2 = isset($_POST["addressLine2"]) ? $_POST["addressLine2"] : "";
    $addressPostcode = isset($_POST["addressPostcode"]) ? $_POST["addressPostcode"] : "";
    $addressState = isset($_POST["addressState"]) ? $_POST["addressState"] : "";
    $contactName = isset($_POST["contactName"]) ? $_POST["contactName"] : "";
    $contactPhoneNo = isset($_POST["contactPhoneNo"]) ? $_POST["contactPhoneNo"] : "";

    if (empty($patientName) || empty($patientIcNum) || empty($patientGender) || empty($patientBirthDate) || empty($patientAge) || empty($patientIllness) || empty($patientReasonAdmission) || empty($addressLine1) || empty($addressPostcode) || empty($addressState) || empty($contactName) || empty($contactPhoneNo)) {
        $errorMessage = "All the fields are required";
    } else {
        try {
            // Insert patient details
            

            // Insert address details
            $sql = "INSERT INTO address (addressLine1, addressLine2, addressPostcode, addressState) VALUES ('$addressLine1','$addressLine2','$addressPostcode','$addressState')";
            $conn->query($sql);
            $address_id = $conn->insert_id; // Get the inserted address ID

            // Insert contact person details
            $sql = "INSERT INTO contactperson (contactName, contactPhoneNo) VALUES ('$contactName','$contactPhoneNo')";
            $conn->query($sql);
            $contact_id = $conn->insert_id; // Get the inserted contact ID

           // Insert patient details with the obtained address and contact IDs
           $sql = "INSERT INTO patient (patientName, patientIcNum, patientGender, patientBirthDate, patientAge, patientIllness, patientReasonAdmission, addressID, contactID) 
           VALUES ('$patientName','$patientIcNum','$patientGender','$patientBirthDate','$patientAge','$patientIllness','$patientReasonAdmission','$address_id','$contact_id')";
   $conn->query($sql);

            // Update patient record with address and contact person IDs
           

            $successMessage = "Patient added successfully";

            // Reset form fields
            $patientName = "";
            $patientIcNum = "";
            $patientGender = "";
            $patientBirthDate = "";
            $patientAge = "";
            $patientIllness = "";
            $patientReasonAdmission = "";
            $addressLine1 = "";
            $addressLine2 = "";
            $addressPostcode = "";
            $addressState = "";
            $contactName = "";
            $contactPhoneNo = "";

            header("location: patientPage.php");
            exit;
        } catch (mysqli_sql_exception $e) {
            $errorMessage = "An error occurred: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
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
        <h2>Add New Patient</h2>

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
                    <input type="date" class="form-control" id="patientBirthDate" name="patientBirthDate" value="<?php echo $patientBirthDate ?>" onchange="calculateAge()">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Patient Age</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" id="patientAge" name="patientAge" value="<?php echo $patientAge ?>" readonly>
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
                <div class="offset-sm-3 col-sm-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-4">
                    <a href="patientPage.php" class="btn btn-outline-primary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
