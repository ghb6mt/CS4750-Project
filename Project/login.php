<?php

session_start();

require "connect-db.php";
require "utils.php";

// echo isset($_POST['uname']);
// echo isset($_POST['password']);
if(isset($_POST['uname']) && isset($_POST['password'])){
    function validate($data){

        $data = trim($data);
 
        $data = stripslashes($data);
 
        $data = htmlspecialchars($data);
 
        return $data;
 
     }

     $uname = validate($_POST['uname']);
     $password = validate($_POST['password']);
     
     switch(login($uname, $password)){
        // LOGIN SUCCESSFUL
        case 1:
            $_SESSION['username'] = $uname;
            $_SESSION['is_admin'] = getUserAdmin($uname);
            if($_SESSION['is_admin']){
                $_SESSION['db_uname'] = 'dnj6xk_b';
                header('Location: admin.php');
                exit;
            }
            else{
                $_SESSION['db_uname'] = 'dnj6xk_c';
                header('Location: index.php');
                exit;
            }
        // MORE THAN ONE USER FOUND
        case -1:
           echo "<script> alert(\"More than one user found! Contact admin for help.\"); window.location.href=\"login.html\"; </script>";
            exit;
        // UNAME OR PASSWORD INCORRECT
        case -2:
            echo "<script> alert(\"Username or Password Incorrect\"); window.location.href=\"login.html\"; </script>";
            exit;
     }

     }
?>