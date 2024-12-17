<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['aID'])) {
  // Redirect to the login page
  header('Location: loginAdmin.php');
  exit();
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
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <?php
      include 'navBarAdmin.php';
      ?>

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-account-multiple"></i>
              </span> List Of Patients
            </h3>
          </div>
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul>
          </nav>
          <div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card ">
                <div class="card shadow p-3 bg-body-tertiary rounded">
                  <div class="card-body">
                    <!--add anything here-->
                    <h2>List of Patients</h2>
                    <br>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <form class="form-inline" method="GET" action="">
                          <div class="form-group">
                            <input type="text" class="form-control" id="search" name="search"
                              placeholder="Enter search keyword"
                              value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                          </div>
                          <button type="submit" class="btn btn-primary ml-2">Search</button>
                          <?php if (isset($_GET['search'])): ?>
                            <a class="btn btn-secondary ml-2" href="?">Reset Search</a>
                          <?php endif; ?>
                        </form>
                      </div>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-hover">
            <thead>
                <tr class="table-dark">
                    <th>Name</th>
                    <th>IC Number</th>
                    <th>Gender</th>
                    <th>Birth Date</th>
                    <th>Age</th>
                    <th>Illness</th>
                    <th>Reason for Admission</th>
                    <th>Address Line 1</th>
                    <th>Address Line 2</th>
                    <th>Postcode</th>
                    <th>State</th>
                    <th>Contact Name</th>
                    <th>Contact Phone No</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_conn.php';

                $limit = 10; // Number of records to show per page
                $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page from URL
                $start = ($page - 1) * $limit; // Calculate the starting record for pagination

                // Prepare the search query if a keyword is provided
                $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
                $searchQuery = '';
                if (!empty($searchKeyword)) {
                    $searchQuery = "WHERE patientName LIKE '%$searchKeyword%' OR patientIcNum LIKE '%$searchKeyword%' OR patientGender LIKE '%$searchKeyword%' OR patientBirthDate LIKE '%$searchKeyword%' OR patientAge LIKE '%$searchKeyword%' OR patientIllness LIKE '%$searchKeyword%' OR patientReasonAdmission LIKE '%$searchKeyword%' OR addressLine1 LIKE '%$searchKeyword%' OR addressLine2 LIKE '%$searchKeyword%' OR addressPostcode LIKE '%$searchKeyword%' OR addressState LIKE '%$searchKeyword%' OR contactName LIKE '%$searchKeyword%' OR contactPhoneNo LIKE '%$searchKeyword%' ";
                }

                // Query to fetch limited records based on the search query
                $countQuery = "SELECT COUNT(*) AS total FROM patient LEFT JOIN address ON patient.addressID = address.addressID LEFT JOIN contactperson ON patient.contactID = contactperson.contactID $searchQuery";
                $resultCount = $conn->query($countQuery);
                $rowCount = $resultCount->fetch_assoc()['total'];
                $totalPages = ceil($rowCount / $limit); // Calculate total pages

                // Fetch data for the current page
                $query = "SELECT patient.*, address.addressLine1, address.addressLine2, address.addressPostcode, address.addressState, contactperson.contactName, contactperson.contactPhoneNo FROM patient LEFT JOIN address ON patient.addressID = address.addressID LEFT JOIN contactperson ON patient.contactID = contactperson.contactID $searchQuery LIMIT $start, $limit";
                $result = $conn->query($query);

                if (!$result) {
                    die("Invalid query: " . $conn->error);
                }

                // Read data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "
                  <tr>
                  <th scope='row'>{$row['patientName']}</th>
                  <td>{$row['patientIcNum']}</td>
                  <td>{$row['patientGender']}</td>
                  <td>{$row['patientBirthDate']}</td>
                  <td>{$row['patientAge']}</td>
                  <td>{$row['patientIllness']}</td>
                  <td>{$row['patientReasonAdmission']}</td>
                  <td>{$row['addressLine1']}</td>
                  <td>{$row['addressLine2']}</td>
                  <td>{$row['addressPostcode']}</td>
                  <td>{$row['addressState']}</td>
                  <td>{$row['contactName']}</td>
                  <td>{$row['contactPhoneNo']}</td>
                  <td>
                  <a type='button' class='btn btn-gradient-dark btn-icon-text' href='patientEdit.php?patientID={$row['patientID']}'> Edit <i class='mdi mdi-file-check btn-icon-append'></i></a>
                  <a type='button' class='btn btn-gradient-danger btn-icon-text' onclick='return confirm(\"Are you sure you want to delete this patient?\")' href='patientDelete.php?patientID={$row['patientID']}'> Delete <i class='mdi mdi-delete'></i></a>
                  </td>
                  </tr>
                  ";
                }
                ?>
            </tbody>
        </table>

                      <?php if ($rowCount > $limit): ?>
                        <ul class="pagination justify-content-center mt-4">
                          <?php if ($page > 1): ?>
                            <li class="page-item">
                              <a class="page-link"
                                href="?page=<?php echo ($page - 1); ?><?php echo !empty($searchKeyword) ? '&search=' . $searchKeyword : ''; ?>">Previous</a>
                            </li>
                          <?php endif; ?>
                          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                              <a class="page-link"
                                href="?page=<?php echo $i; ?><?php echo !empty($searchKeyword) ? '&search=' . $searchKeyword : ''; ?>"><?php echo $i; ?></a>
                            </li>
                          <?php endfor; ?>
                          <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                              <a class="page-link"
                                href="?page=<?php echo ($page + 1); ?><?php echo !empty($searchKeyword) ? '&search=' . $searchKeyword : ''; ?>">Next</a>
                            </li>
                          <?php endif; ?>
                        </ul>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
              <div class="container-fluid d-flex justify-content-between">
                <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © GreenTech.com
                  2021</span>
              </div>
            </footer>
            <!-- partial -->
          </div>
          <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
      </div>

      <?php
      include 'javaScript.php';
      ?>

</body>

</html>