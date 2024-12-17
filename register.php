<?php
include 'db_conn.php';

$name = "";
$org = "";
$phoneno = "";
$email = "";
$username = "";
$password = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = isset($_POST["volunteer-name"]) ? $_POST["volunteer-name"] : "";
	$org = isset($_POST["volunteer-org"]) ? $_POST["volunteer-org"] : "";
	$phoneno = isset($_POST["phone-number"]) ? $_POST["phone-number"] : "";
	$email = isset($_POST["email"]) ? $_POST["email"] : "";
	$username = isset($_POST["username"]) ? $_POST["username"] : "";
	$password = isset($_POST["password"]) ? $_POST["password"] : "";

	if (empty($name) || empty($org) || empty($phoneno) || empty($email) || empty($username) || empty($password)) {
		$errorMessage = "All the fields are required";
	} else {
		try {

			$sql = "INSERT INTO volunteer ( voluName, voluOrg, voluPhone, voluEmail, voluUsername, voluPassword) VALUES ('$name', '$org', '$phoneno', '$email', '$username', '$password')";
			$conn->query($sql);


			$successMessage = "You have been added into the volunteer list.";

			$name = "";
			$org = "";
			$phoneno = "";
			$email = "";
			$username = "";
			$password = "";

			header("location: ../prototype/register.php");
			exit;
		} catch (mysqli_sql_exception $e) {
			if ($e->getCode() == 1062) {
				$errorMessage = "This person already in the volunteer list.";

			} else {
				$errorMessage = "An error occurred: " . $e->getMessage();
			}
		}
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
	<div id="volunteer" class="form-container">
		<h2>Sign-Up As Volunteer</h2>
		<form method="POST" id="volunteer-form">
			<!-- <input type="text" id="volunteer-id" name="volunteer-id" placeholder="Volunteer ID/IC" read> -->
			<div class="error" id="id-error"></div>
			<input type="text" id="volunteer-name" name="volunteer-name" placeholder="Volunteer Name" required>
			<div class="error" id="name-error"></div>
			<input type="text" id="volunteer-org" name="volunteer-org"
				placeholder="Enter your organization name (if any)">
			<div class="error" id="org-error"></div>
			<input type="text" id="phone-number" name="phone-number" placeholder="Phone Number">
			<div class="error" id="phone-error"></div>
			<input type="email" id="email" name="email" placeholder="Email" required>
			<div class="error" id="email-error"></div>
			<input type="text" id="username" name="username" placeholder="Username" required>
			<div class="error" id="username-error"></div>
			<input type="password" id="password" name="password" placeholder="Password" required>
			<div class="error" id="password-error"></div>
			<button type="submit">Sign Up</button>
		</form>
		<p>Existing user?</p>
		<a href="login.php"><button type="button">Login</button></a>
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