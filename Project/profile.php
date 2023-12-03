<?php

session_start();
require("connect-db.php");
require("utils.php");
include('navbar.html');
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