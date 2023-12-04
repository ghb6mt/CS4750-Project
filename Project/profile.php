<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Profile Page</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-5">

        <?php
            if (session_status() == PHP_SESSION_NONE) { 
                session_start(); 
            }
            if (!isset($_SESSION['username'])) {
                header("Location: login.html");
            }
            require("connect-db.php");
            require("utils.php");
            $user = getUserInfo($_SESSION['username']);
            $user = $user[0];
        ?>

        <h1>Profile Page</h1>

        <div class="row mt-4">
            <div class="col-md-6">
                <h3>Name:</h3>
                <p><?php echo $user['first_name'] . " " . $user['last_name'];?></p>

                <h3>Email:</h3>
                <p><?php echo $user['email_address'];?></p>

                <h3>Phone:</h3>
                <p><?php echo $user['phone_number'];?></p>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-JN8Y+58Z4mFCiDOpFu4iGzr1D+kbIMZ0qTNQgqXuZl5/IpkABDK/9KtS2FVxkVx"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>
</html>

<!-- 
<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }
require("connect-db.php");
require("utils.php");
include('navbar.php');
$user = getUserInfo($_SESSION['username']);
$user = $user[0];
?>

<head>
    <title>Profile Page</title>
</head>
<body>
    <h3>Name: <?php echo $user['first_name'] . " " . $user['last_name'];?></h3>
    <h3>Email: <?php echo $user['email_address'];?></h3>
    <h3>Phone: <?php echo $user['phone_number'];?></h3>
</body>
        -->
