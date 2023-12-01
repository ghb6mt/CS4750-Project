<?php

session_start();

include "connect-db.php";

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
            
        // MORE THAN ONE USER FOUND
        case -1:
        
        // UNAME OR PASSWORD INCORRECT
        case -2:
            
     }

     }
?>