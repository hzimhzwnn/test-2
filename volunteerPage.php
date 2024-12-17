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
              </span> List Of Volunteer
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
                    <h2>List of Volunteer</h2>
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
                            <th>Organization</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Password</th>
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
                            $searchQuery = "WHERE voluName LIKE '%$searchKeyword%' OR voluOrg LIKE '%$searchKeyword%' OR voluPhone LIKE '%$searchKeyword%' OR voluEmail LIKE '%$searchKeyword%' OR voluUsername LIKE '%$searchKeyword%' ";
                          }

                          // Query to fetch limited records based on the search query
                          $countQuery = "SELECT COUNT(*) AS total FROM volunteer $searchQuery";
                          $resultCount = $conn->query($countQuery);
                          $rowCount = $resultCount->fetch_assoc()['total'];
                          $totalPages = ceil($rowCount / $limit); // Calculate total pages
                          
                          // Fetch data for the current page
                          $query = "SELECT * FROM volunteer $searchQuery LIMIT $start, $limit";
                          $result = $conn->query($query);

                          if (!$result) {
                            die("Invalid query: " . $conn->error);
                          }

                          // Read data of each row
                          while ($row = $result->fetch_assoc()) {
                            echo "
                      <tr>
                      <th scope='row'>{$row['voluName']}</th>
                      <td>{$row['voluOrg']}</td>
                      <td>{$row['voluPhone']}</td>
                      <td>{$row['voluEmail']}</td>
                      <td>{$row['voluUsername']}</td>
                      <td>{$row['voluPassword']}</td>
                      <td>
                      <a type='button' class='btn btn-gradient-dark btn-icon-text' href='volunteerEdit.php?voluID={$row['voluID']}'> Edit <i class='mdi mdi-file-check btn-icon-append'></i></a>
                      <a type='button' class='btn btn-gradient-danger btn-icon-text' onclick='return confirm(\"Are you sure you want to delete this client?\")' href='volunteerDelete.php?voluID={$row['voluID']}'> Delete <i class='mdi mdi-delete'></i></a>
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