<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['aID'])) {
    // Redirect to the login page
  header('Location: loginAdmin.php');
  exit();
}

include "db_conn.php";
// Perform queries or fetch data from your database to retrieve the necessary values
$totalVolunteers = 0;
$totalPatients = 0;
$totalActivities = 0;

// Retrieve total clients
$totalVolunteersQuery = "SELECT COUNT(*) AS total_Volunteers FROM volunteer";
$totalVolunteersResult = $conn->query($totalVolunteersQuery);
if ($totalVolunteersResult) {
  $totalVolunteersRow = $totalVolunteersResult->fetch_assoc();
  $totalVolunteers = $totalVolunteersRow['total_Volunteers'];
}

// Retrieve total reservations made by clients
$totalPatientsQuery = "SELECT COUNT(*) AS total_patient FROM patient";
$totalPatientsResult = $conn->query($totalPatientsQuery);
if ($totalPatientsResult) {
  $totalPatientsRow = $totalPatientsResult->fetch_assoc();
  $totalPatients = $totalPatientsRow['total_patient'];
}

// Retrieve total feedback given
$totalActivitiesQuery = "SELECT COUNT(*) AS activity FROM proposedactivity";
$totalActivitiesResult = $conn->query($totalActivitiesQuery);
if ($totalActivitiesResult) {
  $totalActivitiesRow = $totalActivitiesResult->fetch_assoc();
  $totalActivities = $totalActivitiesRow['activity'];
}

// Fetch total pending reservations
$sqlPending = "SELECT COUNT(*) AS totalPending FROM proposedactivity WHERE activityStatus = 'not_started'";
$resultPending = $conn->query($sqlPending);
$rowPending = $resultPending->fetch_assoc();
$totalPending = $rowPending['totalPending'];

$sqlInProgress = "SELECT COUNT(*) AS totalInProgress FROM proposedactivity WHERE activityStatus = 'in_progress'";
$resultInProgress = $conn->query($sqlInProgress);
$rowInProgress = $resultInProgress->fetch_assoc();
$totalInProgress = $rowInProgress['totalInProgress'];

$sqlCompleted = "SELECT COUNT(*) AS totalCompleted FROM proposedactivity WHERE activityStatus = 'completed'";
$resultCompleted = $conn->query($sqlCompleted);
$rowCompleted = $resultCompleted->fetch_assoc();
$totalCompleted = $rowCompleted['totalCompleted'];

$sqlOnHold = "SELECT COUNT(*) AS totalOnHold FROM proposedactivity WHERE activityStatus = 'on_hold'";
$resultOnHold = $conn->query($sqlOnHold);
$rowOnHold = $resultOnHold->fetch_assoc();
$totalOnHold = $rowOnHold['totalOnHold'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <?php
  include 'headAdmin.php';
  ?>
</head>
<body>
  <div class="container-scroller">
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <?php
      include 'navBarAdmin.php';
      ?>

    </nav>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <i class="mdi mdi-home"></i>
            </span> Dashboard
          </h3>
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul>
          </nav>
        </div>

        <div class="row">
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white shadow p-3 bg-body-tertiary rounded">
              <div class="card-body">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Volunteers <i class="mdi mdi-chart-line mdi-24px float-right"></i></h4>
                <h2 class="mb-5"><?php echo $totalVolunteers; ?> Volunteers</h2>
              </div>
            </div>
          </div>
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white shadow p-3 bg-body-tertiary rounded">
              <div class="card-body">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Patients<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i></h4>
                <h2 class="mb-5"><?php echo $totalPatients; ?> Patients</h2>
              </div>
            </div>
          </div>
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white shadow p-3 bg-body-tertiary rounded">
              <div class="card-body">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Proposed Activity <i class="mdi mdi-diamond mdi-24px float-right"></i></h4>
                <h2 class="mb-5"><?php echo $totalActivities; ?> Proposed Activity</h2>
              </div>
            </div>
          </div>
        </div>

         <div class="row">
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-warning card-img-holder text-white shadow p-3 bg-body-tertiary rounded">
              <div class="card-body">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Pending Activities </h4>
                <h2 class="mb-5"><?php echo $totalPending; ?> Still Pending</h2>
              </div>
            </div>
          </div>
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white shadow p-3 bg-body-tertiary rounded">
              <div class="card-body">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Approved Activities</h4>
                <h2 class="mb-5"><?php echo $totalCompleted; ?> Approved</h2>
              </div>
            </div>
          </div>
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white shadow p-3 bg-body-tertiary rounded">
              <div class="card-body">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total In-Progress Activities </h4>
                <h2 class="mb-5"><?php echo $totalInProgress; ?> In-Progress</h2>
              </div>
            </div>
          </div>
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white shadow p-3 bg-body-tertiary rounded">
              <div class="card-body">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total On-Hold Activities </h4>
                <h2 class="mb-5"><?php echo $totalOnHold; ?> On-Hold</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
      <!-- partial:partials/_footer.html -->
      <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
          <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © GreenTech.com 2021</span>
        </div>
      </footer>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>

  <!-- page-body-wrapper ends -->
</div>
<?php
include 'javascriptAdmin.php';
?>
<script>
  const mysql = require('mysql');

              // Create a connection to the database
  const connection = mysqli.createConnection({
              host: 'localhost', // Replace with your host
              user: 'root', // Replace with your MySQL username
              password: '', // Replace with your MySQL password
              database: 'bus_transportation', // Replace with your database name
            });

              // Connect to the database
  connection.connect((err) => {
    if (err) {
      console.error('Error connecting to the database: ' + err.stack);
      return;
    }
    console.log('Connected to the database.');

              // Query to retrieve data from the 'clients' table
    const query = 'SELECT * FROM volunteer';

              // Execute the query
    connection.query(query, (err, results) => {
      if (err) {
        console.error('Error executing the query: ' + err.stack);
        return;
      }

              // Retrieve the client data from the results
      const Volunteers = results;

              // Calculate the total number of clients
      const totalVolunteers = Volunteers.length;

              // Display the total client count in the HTML element
      const totalVolunteersElement = document.getElementById('totalVolunteers');
      totalVolunteersElement.textContent = totalVolunteers;

    });
  });

              // Close the database connection
  connection.end();

</script>
</body>
</html>