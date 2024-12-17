<?php
include 'db_conn.php';
session_start();

// Check if the user is already logged in
if (isset($_SESSION['aID'])) {
    // Redirect to the admin home page
  header('Location: indexAdmin.php');
  exit();
}

$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform login validation
  $adminID = $_POST['aID'];
  $adminPass = $_POST['aPass'];

    // Validate id and password

  $query = "SELECT * FROM administrator WHERE adminUsername='$adminID' AND adminPassword='$adminPass'"; 
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
        // Login successful, store user information in session
    $_SESSION['aID'] = $adminID;

        // Redirect to the home page
    header('Location: indexAdmin.php');
    exit();
  } else {
        // Invalid credentials
    $errorMessage = 'Invalid admin ID or Password.';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'headAdmin.php';
    ?>
</head>

<body>
  <div class="container-scroller ">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5 shadow p-3 bg-body-tertiary rounded">
              <div class="brand-logo">
                <img src="assets/images/logonew.png" class="align-items-center">
              </div>
              <h4>LOVE HOME CHARITY</h4>
              <h6 class="font-weight-light">Log in to continue.</h6>
              <form class="pt-3" method="POST" >

                <?php
                if (!empty($errorMessage)){
                  echo"
                  <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                  <strong>$errorMessage</strong>
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div> 
                  ";
                }
                ?>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg shadow-sm p-3 bg-body-tertiary rounded" name="aID" placeholder="Admin ID">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg shadow-sm p-3 bg-body-tertiary rounded" name="aPass" placeholder="Password">
                </div>

                <div class="row mb-3">
                  <div class = "col-sm-6 d-grid">
                    <button type="submit" class="btn btn-block btn btn-gradient-dark font-weight-medium auth-form-btn shadow-sm p-3 bg-body-tertiary rounded">LOG IN</button>
                  </div>
                  <div class="col-sm-6 d-grid">
                    <a class="btn btn-primary" href="../prototype/index.php" role="button">MAIN PAGE</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <?php
    include 'javaScript.php';
    ?>
  </body>


</html>