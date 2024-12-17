<?php
include 'db_conn.php';
session_start();

// Check if the user is already logged in
if (isset($_SESSION['uID'])) {
    // Redirect to the user home page
    header('Location: indexAfter.php');
    exit();
}

$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform login validation
    $userName = $_POST['uName'];
    $userPass = $_POST['uPass'];


    // Validate id and password

    $query = "SELECT * FROM volunteer WHERE voluUsername='$userName' AND voluPassword='$userPass'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $info = mysqli_fetch_array($result); // returns a row from a recordset

        // Login successful, store user information in session
        $_SESSION['uID'] = $info['voluID'];
        $_SESSION['voluName'] = $info['voluName'];  // assign field in username to session [user]

        // Redirect to the home page
        header('Location: activity.php');
        exit();
    } else {
        // Invalid credentials
        $errorMessage = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'head.php';
    ?>
</head>

<body>
    <?php
    include 'navBar.php';
    ?>

    <?php
    if (!empty($errorMessage)) {
        echo "
		<div class='alert alert-warning alert-dismissible fade show' role='alert'>
		<strong>$errorMessage</strong>
		</div>
		";
    }
    ?>
    <?php
    if (!empty($successMessage)) {
        echo "
		<div class='alert alert-success alert-dismissible fade show' role='alert'>
		<strong>$successMessage</strong>
		<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
		</div> 
		";
    }
    ?>
    <div class="form-container">
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="uName" placeholder="Username" required>
            <input type="password" name="uPass" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        

        <div class="error" id="name-error"></div>
        <label for="">Login as ADMINISTRATOR</label>
        <a href="loginAdmin.php"><button type=" button">Admin</button></a>
    </div>
    
    <?php
    include 'javascript.php';
    ?>
</body>
<footer>
    <p>© 2024 Love Home Charity. All rights reserved.<br>
        Contact us: <a href="mailto:info@lovehomecharity.org">info@lovehomecharity.org</a></p>
</footer>

</html>