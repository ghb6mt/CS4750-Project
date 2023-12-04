<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }

require "connect-db.php";
require "utils.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $users = getAllUsernames();
    if(!in_array($_POST['uname'],$users)){
        createUser($_POST['uname'],$_POST['first_name'],$_POST['last_name'],$_POST['password'],$_POST['email'],$_POST['phone_number']);
        header("Location: login.html");
    }
    else{
        echo "Username Already Exists!";
    }
}


?>



<html>
    <head>
        <title>New Account</title>
    </head>
<body>
    <form action="newaccount.php" method="POST">
        <input type="text" name="uname" placeholder="User Name" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="first_name" placeholder="First Name" required><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br>
        <input type="text" name="email" placeholder="Email" required><br>
        <input type="text" name="phone_number" placeholder="Phone Number" required><br>
        <button type="submit">Create Account</button>
    </form>
    <a href="login.html">Back To Login</a>
</body>
</html>