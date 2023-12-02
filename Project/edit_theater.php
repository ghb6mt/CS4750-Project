<?php
require('utils.php');
$theater_id = $_POST['theater_id']; // Assuming theater_id is passed as a query parameter

// Fetch theater data
$theater = getTheater($theater_id)[0]; // Assuming such a function exists


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['update_theater'])){
       
    }
}


// Check if theater data is returned
if ($theater) {
    $company = getTheaterCompany($theater['theater_id'])[0]['company'];
    $city = $theater['city'];
    $street = $theater['street'];
    $state = $theater['state'];
    // Add other fields if available and needed
} else {
    // Handle case where no theater is found
    echo "No theater found with ID: $theater_id";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Theater</title>
    <!-- Include any other necessary HTML headers here -->
</head>
<body>
    <form action="update_theater.php" method="post"> <!-- Separate file for update logic -->
        <input type="hidden" name="theater_id" value="<?php echo $theater_id; ?>">
        <label for="company">Company:</label>
        <input type="text" id="company" name="company" value="<?php echo htmlspecialchars($company); ?>"><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>"><br>

        <label for="street">Street:</label>
        <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($street); ?>"><br>

        <label for="state">State:</label>
        <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($state); ?>"><br>

        <!-- Add other form fields if needed -->

        <input type="submit" name= "update_theater" value="Submit">
    </form>
</body>
</html>
