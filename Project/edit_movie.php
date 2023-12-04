<?php
require('utils.php');
include('navbar.php');
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
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<a href="admin.php">Back To Admin Dashboard</a>
    <form action="edit_movie.php" method="post"> <!-- Separate file for update logic -->
    <div class="mb-3">
        <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
        <label for="title">Movie Title:</label>
        <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>"><br>
    </div>
    <div class="mb-3">
        <label for="runtime">Runtime:</label>
        <input type="text" id="runtime" class="form-control" name="runtime" value="<?php echo htmlspecialchars($runtime); ?>"><br>
    </div>
    <div class="mb-3">
        <label for="year">Year:</label>
        <input type="text" id="year" class="form-control" name="year" value="<?php echo htmlspecialchars($year); ?>"><br>
    </div>
    <div class="mb-3">
        <label for="desc">Description:</label>
        <textarea id="desc" class="form-control" name="description"><?php echo htmlspecialchars($desc); ?></textarea><br>
    </div>
    <div class="mb-3">
        <label for="age">Age Rating:</label>
        <input type="text" class="form-control" id="age" name="age_rating" value="<?php echo htmlspecialchars($age); ?>"><br>
    </div>
    <div class="mb-3">
        <label for="genre">Genre:</label>
        <input type="text" class="form-control" id="genre" name="genre" value="<?php echo htmlspecialchars($genre); ?>"><br>
    </div>
    <div class="mb-3">
        <label for="lead">Lead Actor:</label>
        <input type="text" class="form-control" id="lead" name="lead_actor" value="<?php echo htmlspecialchars($lead_actor); ?>"><br>
    </div>
        <input type="submit" name="update_movie" class="btn btn-primary" value="Submit">
    </form>
</body>
 <!-- Bootstrap JS and Popper.js (required for Bootstrap dropdowns) -->
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</html>
