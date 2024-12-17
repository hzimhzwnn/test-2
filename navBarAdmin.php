<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="indexAdmin.php"><img src="assets/images/logonew.png" alt="logo" /></a>
</div>
<div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
    </button>
    <div class="search-field d-none d-md-block">
        <form class="d-flex align-items-center h-100" action="#">
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                    <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
            </div>
        </form>
    </div>
    <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                aria-expanded="false">
                <div class="nav-profile-img">
                    <img src="assets/images/faces-clipart/pic-4.png" alt="image">
                    <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                    <p class="mb-1 text-black"> <?php echo $_SESSION['aID']; ?></p>
                </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logoutAdmin.php">
                    <i class="mdi mdi-logout me-2 text-primary"></i> Log out </a>
            </div>
        </li>
        <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
        </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
        data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
    </button>
</div>
</nav>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item nav-profile">
                <a href="#" class="nav-link">
                    <div class="nav-profile-image">
                        <img src="assets/images/faces-clipart/pic-4.png" alt="profile">
                        <span class="login-status online"></span>
                        <!--change to offline or busy as needed-->
                    </div>
                    <div class="nav-profile-text d-flex flex-column">
                        <span class="font-weight-bold mb-2"><?php echo $_SESSION['aID']; ?></span>
                        <span class="text-secondary text-small">Love Home Charity Admin</span>
                    </div>
                    <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="indexAdmin.php">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#list-pages" aria-expanded="false"
                    aria-controls="list-pages">
                    <span class="menu-title">List</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-table-large menu-icon"></i>
                </a>
                <div class="collapse" id="list-pages">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="volunteerPage.php"> List Of Volunteer </a></li>
                        <li class="nav-item"> <a class="nav-link" href="activityPage.php"> List Of Activity </a></li>
                        <li class="nav-item"> <a class="nav-link" href="patientPage.php"> List Of Patient </a></li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#insertion-pages" aria-expanded="false"
                    aria-controls="insertion-pages">
                    <span class="menu-title">Insertion</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-plus-box menu-icon"></i>
                </a>
                <div class="collapse" id="insertion-pages">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="patientAdd.php"> Add New Patient </a></li>
                    </ul>
                </div>
            </li>


        </ul>
    </nav>