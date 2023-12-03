<?php
require('utils.php');
$snack_id = $_POST['snack']; // Assuming theater_id is passed as a query parameter

// Fetch theater data
$snack= getSnack($snack_id)[0]; // Assuming such a function exists


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['update_snack'])){
        
    }
}


// Check if theater data is returned
if ($snack) {
    $name = $snack['name'];
    $price = $snack['price'];
    $brand = $snack['brand'];
    $type = $snack['type'];
    $calories = $snack['calories'];
    $movie_id = $snack['movie_id'];

    // Add other fields if available and needed
} else {
    // Handle case where no theater is found
    echo "No snack found with ID: $snack_id";
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
        <label for="company">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"><br>

        <label for="city">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>"><br>

        <label for="city">Brand:</label>
        <input type="text" id="brand" name="brand" value="<?php echo htmlspecialchars($brand); ?>"><br>

        <label for="street">Type:</label>
        <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($type); ?>"><br>

        <label for="state">Calories:</label>
        <input type="text" id="calories" name="calories" value="<?php echo htmlspecialchars($calories); ?>"><br>

        <label for="state">Movie ID:</label>
        <input type="text" id="movie_id" name="movie_id" value="<?php echo htmlspecialchars($movie_id); ?>"><br>

        <!-- Add other form fields if needed -->

        <input type="submit" name= "update_snack" value="Submit">
    </form>
</body>
</html>
