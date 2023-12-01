<?php

session_start();

require "connect-db.php";
require "utils.php";

echo $_POST['password'];
// echo isset($_POST['uname']);
// echo isset($_POST['password']);
if(isset($_POST['uname']) && isset($_POST['password'])){
    echo '<p>hi</p>';
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
            header('Location: http://www.amazon.com/');
            exit;
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