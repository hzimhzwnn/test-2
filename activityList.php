<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['uID'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit();
}

// Include the necessary files
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php'; ?>
    <style>
        /* Optional: Custom styles for table */
       

        
    </style>
</head>

<body>
    <?php include 'navBarUser.php'; ?>

    <div class="container mt-4">
        <h2>Activity List</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Activity Name</th>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (isset($_SESSION['uID']) && is_numeric($_SESSION['uID'])) {
                    // Sanitize volunteerID (optional, depending on your validation needs)
                    $volunteerID = mysqli_real_escape_string($conn, $_SESSION['uID']);

                    // Query to fetch activities for a specific volunteerID
                    $sql = "SELECT * FROM proposedactivity WHERE volunteerID = $volunteerID";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['activityName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['activityType']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['activityStart']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['activityEnd']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['activityStatus']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No activities found for this volunteer.</td></tr>";
                    }

                    // Close connection
                    mysqli_close($conn);
                } else {
                    echo "<tr><td colspan='6'>Invalid volunteer ID.</td></tr>";
                }


                ?>
            </tbody>
        </table>
    </div>

    <?php include 'javascript.php'; ?>
</body>
<footer>
    <div class="container">
        <p>© 2024 Love Home Charity. All rights reserved.<br>
            Contact us: <a href="mailto:info@lovehomecharity.org">info@lovehomecharity.org</a></p>
    </div>
</footer>

</html>