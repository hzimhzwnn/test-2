<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['uID'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
   <?php
   include 'head.php';
   ?>
</head>
<?php
    include 'navBarUser.php';
    ?>

<body>
    
    
    <section class="introduction">
        <h1 class="custom-font">WELCOME TO LOVE HOME CHARITY</h1> 
        <div class="description">The Pertubuhan Kebajikan Kanak-Kanak Yatim dan Cacat Perlindungan Selangor, 
            also known as Love Home Charity is a shelter for physically impaired people, 
            mentally disabled children and vulnerable people who need support. 
            This center was established on August 30, 2018, to provide shelter and care for people with disabilities, 
            such as Down syndrome, mental illness and autism regardless of race and religion.</div>
            <div class="activities">
                <div class="activity"><img src="assets/images/1.jpg" alt="Activity 1"></div>
                <div class="activity"><img src="assets/images/charity.jpg" alt="Activity 4"></div>
                <div class="activity"><img src="assets/images/charity2.jpg" alt="Activity 3"></div>
                <div class="activity"><img src="assets/images/5.jpg" alt="Activity 5"></div>
                <div class="activity"><img src="assets/images/charity3.jpg" alt="Activity 5"></div>
            </div>
        </div>
    </section>

   
</body>
<footer>
        <p>© 2024 Love Home Charity. All rights reserved.<br>
        Contact us: <a href="mailto:info@lovehomecharity.org">info@lovehomecharity.org</a></p>
    </footer>
</html>
