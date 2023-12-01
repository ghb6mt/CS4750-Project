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
            if($_SESSION['is_admin']){
                header('Location: localhost/admin.html');
                exit;
            }
            else{
                header('localhost/index.html');
                exit;
            }
        // MORE THAN ONE USER FOUND
        case -1:
            header('Location: http://www.geico.com/');
            exit;
        // UNAME OR PASSWORD INCORRECT
        case -2:
            header('Location: http://www.geico.com/');
            exit;
     }

     }
?>