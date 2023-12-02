<?php
require('utils.php');
$movie_id = $_POST['movie_id']; // Assuming movie_id is passed as a query parameter

// Fetch movie data
$movies = getMovieInfo($movie_id);


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['update_movie'])){
       foreach($_POST as $name => $value): //iterate over all fields
        if($name != 'movie_id' && $name != 'lead_actor' && $name != 'genre'){ //cant call update on ID
            updateMovie($name,$value,$_POST['movie_id']);
        }
        elseif($name == 'lead_actor'){
            updateMovieLeadActor($value,$_POST['movie_id']);
        }
        elseif($name == 'genre'){
            updateMovieGenre($value,$_POST['movie_id']);
        }
        else{
            header("Location: admin.php");
        }
        endforeach;
    }
}

// Assuming only one movie is returned for a given movie_id
if (count($movies) > 0) {
    $movie = $movies[0]; // Get the first movie in the array

    $title = $movie['title'];
    $runtime = $movie['runtime'];
    $year = $movie['year'];
    $desc = $movie['description'];
    $age = $movie['age_rating'];
    $genre = getMovieGenre($movie['movie_id'])[0][0];
    $lead_actor = getMovieLeadActor($movie['movie_id'])[0][0];
} else {
    // Handle case where no movie is found
    echo "No movie found with ID: $movie_id";
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
    <form action="edit_movie.php" method="post"> <!-- Separate file for update logic -->
        <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
        <label for="title">Movie Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>"><br>

        <label for="runtime">Runtime:</label>
        <input type="text" id="runtime" name="runtime" value="<?php echo htmlspecialchars($runtime); ?>"><br>

        <label for="year">Year:</label>
        <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($year); ?>"><br>

        <label for="desc">Description:</label>
        <textarea id="desc" name="description"><?php echo htmlspecialchars($desc); ?></textarea><br>

        <label for="age">Age Rating:</label>
        <input type="text" id="age" name="age_rating" value="<?php echo htmlspecialchars($age); ?>"><br>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($genre); ?>"><br>

        <label for="lead">Lead Actor:</label>
        <input type="text" id="lead" name="lead_actor" value="<?php echo htmlspecialchars($lead_actor); ?>"><br>

        <input type="submit" name="update_movie" value="Submit">
    </form>
</body>
</html>
