<?php
include 'utils.php';  // Include your utils.php file

if(isset($_POST['add_movie'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $runtime = $_POST['runtime'];
    $year = $_POST['year'];
    $desc = $_POST['desc'];
    $age = $_POST['age'];
    $genre = $_POST['genre'];
    $lead = $_POST['lead'];

    // Call the function from utils.php to add movie

    addMovie($title, $runtime, $year, $desc, $age, $genre, $lead);    
    
    header("Location: localhost/admin.html");
    exit;
    // You can add code here to confirm the movie was added or handle errors
}
?>