<?php
require('utils.php');
$sid = $_POST['showing_id']; // Assuming movie_id is passed as a query parameter

// Fetch movie data
$showings = getSingleShowing($sid);


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['update_showing'])){
       foreach($_POST as $name => $value): //iterate over all fields
        if($name == 'time'){
            $mytime = date("Y-m-d H:i:s", strtotime($_POST['time']));
            echo updateMovieShowing($name,$mytime,$_POST['showing_id']);
        }
        elseif($name != 'update_showing' && $name != 'time' && $name != 'showing_id'){
            echo updateMovieShowing($name,$value,$_POST['showing_id']);
        }
        else{
            header("Location: admin.php");
        }
        endforeach;
    }
}

// Assuming only one movie is returned for a given movie_id
if (count($showings) > 0) {
    $showing = $showings[0]; // Get the first movie in the array

    $movie_id = $showing['movie_id'];
    $theater_id = $showing['theater_id'];
    $time = $showing['time'];
    $room = $showing['room'];
} else {
    // Handle case where no movie is found
    echo "No showing found with ID: $sid";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Movie</title>
    <!-- Include any other necessary HTML headers here -->
</head>
<body>
    <a href="admin.php">Back To Admin Dashboard</a>
    <form action="edit_showing.php" method="post"> <!-- Separate file for update logic -->
        <input type="hidden" name="showing_id" value="<?php echo $sid; ?>">
        <label for="title">Movie ID:</label>
        <input type="text" id="movie_id" name="movie_id" value="<?php echo htmlspecialchars($movie_id); ?>"><br>

        <label for="tid">Theater ID:</label>
        <input type="text" id="theater_id" name="theater_id" value="<?php echo htmlspecialchars($theater_id); ?>"><br>

        <label for="time">Time:</label>
        <input type="datetime-local" id="time" name="time" value="<?php echo htmlspecialchars($time); ?>"><br>

        <label for="room">Room:</label>
        <input type="text" id="room" name="room" value="<?php echo htmlspecialchars($room); ?>"><br>

        <input type="submit" name="update_showing" value="Submit">
    </form>
</body>
</html>
