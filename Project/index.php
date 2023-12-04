<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Your Movie List</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">

        <?php
            if (session_status() == PHP_SESSION_NONE) { 
                session_start(); 
            }

            require("connect-db.php");
            require("utils.php");
            
            if(!isset($_SESSION['username'])){
                header("Location: login.html");
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(!empty($_POST['favorite_movie'])){
                favoriteMovie($_POST['username'],$_POST['movie_id']);
                header("Location: index.php");
                }
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $query = "";
                if(isset($_POST['title'])) {
                    $title = $_POST['title'];
                    $title = stripslashes($title);
                    if(empty($query)) {
                        $query = "SELECT * FROM movies NATURAL JOIN genres NATURAL JOIN lead_actors WHERE title LIKE '%$title%'";
                    }
                    else {
                        $query = $query . " AND title LIKE '%$title%'";
                    }
                }
                if(isset($_POST['actor'])) {
                    $actor = $_POST['actor'];
                    $actor = stripslashes($actor);
                    if(empty($query)) {
                        $query = "SELECT * FROM movies NATURAL JOIN genres NATURAL JOIN lead_actors WHERE lead_actor LIKE '%$actor%'";
                    }
                    else {
                        $query = $query . " AND lead_actor LIKE '%$actor%'";
                    }
                }
                if(isset($_POST['rating'])) {
                    $rating = $_POST['rating'];
                    if ($rating != "none") {
                        if(empty($query)) {
                            $query = "SELECT * FROM movies NATURAL JOIN genres NATURAL JOIN lead_actors WHERE age_rating = '$rating'";
                        }
                        else {
                            $query = $query . " AND age_rating = '$rating'";
                        }
                    }
                }
                if(isset($_POST['genre'])) {
                    $genre = $_POST['genre'];
                    if ($genre != "none") {
                        if(empty($query)) {
                            $query = "SELECT * FROM movies NATURAL JOIN genres NATURAL JOIN lead_actors WHERE genre = '$genre'";
                        }
                        else {
                            $query = $query . " AND genre = '$genre'";
                        }
                    }
                }
                if(isset($_POST['runtime'])) {
                    if (is_numeric($_POST['runtime'])) {
                        $runtime = intval($_POST['runtime']);
                        if(empty($query)) {
                            $query = "SELECT * FROM movies NATURAL JOIN genres NATURAL JOIN lead_actors WHERE runtime < $runtime";
                        }
                        else {
                            $query = $query . " AND runtime < $runtime";
                        }
                    }
                }
                $statement = $db->prepare($query);
                $statement->execute();
                $filtered = $statement->fetchAll();
                $statement->closeCursor();
            } 
            else {
                $filtered = allMovies();
            }
        ?>

        <h1 class="mt-4 mb-4">List of Movies</h1>

        <form method="POST" action="index.php" class="mb-4">
            <input type="text" name="title" placeholder="Search by movie title">
            <input type="text" name="actor" placeholder="Search by lead actor">
            <select name="rating" id="rating">
                <option value="none">Age Rating</option>
                <option value="g">G</option>
                <option value="pg">PG</option>
                <option value="pg-13">PG-13</option>
                <option value="r">R</option>
            </select>
            <select name="genre" id="genre">
                <option value="none">Genre</option>
                <option value="action">Action</option>
                <option value="adventure">Adventure</option>
                <option value="comedy">Comedy</option>
                <option value="drama">Drama</option>
                <option value="musical">Musical</option>
                <option value="sports">Sports</option>
            </select>
            <input type="text" name="runtime" placeholder="Runtime less than...">
            <input type="submit" value="Search">
        </form>

        <div class="row justify-content-center">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" width="20%">Movie Title</th>
                        <th scope="col" width="20%">Lead Actor</th>
                        <th scope="col" width="10%">Age Rating</th>
                        <th scope="col" width="10%">Genre</th>
                        <th scope="col" width="10%">Runtime</th>
                        <th scope="col" width="10%">Rating</th>
                        <th scope="col" width="20%">Favorite</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filtered as $movie): ?>
                        <tr>
                            <?php $link = "movie.php?movie_id=". $movie['movie_id'];?>
                                <td><?php echo "<a href='$link'>".$movie['title']; ?></td>
                                <?php $leadActor = getMovieLeadActor($movie['movie_id']); ?>
                                <td><?php echo $leadActor[0][0] ?></td>
                                <td><?php echo $movie['age_rating']; ?></td>
                                <?php $genres = getMovieGenre($movie['movie_id']); ?>
                                <td><?php echo $genres[0][0] ?></td>
                                <td><?php echo $movie['runtime']; ?></td>
                                <?php $avg_rating = getAverageRatingForMovie($movie['movie_id'])?>
                                <td><?php 
                                    if (is_numeric($avg_rating[0])) {
                                        echo $avg_rating[0];
                                    } else {
                                        echo "Not Rated";
                                    }
                                    
                                ?></td>
                                <td>
                                    <?php $favorites = getUserFavorites($_SESSION['username']);
                                    $favorites = array_column($favorites,'movie_id');
                                    if(!in_array($movie['movie_id'],$favorites)){?>
                                    <form action="index.php" method="post" style="display: inline;">
                                            <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                                            <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                                            <button type="submit" name="favorite_movie" value="favorite_movie" class="btn btn-warning">Favorite</button>
                    </form>
            <?php }
            else{
                echo "Already Favorited!";}?>
            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-JN8Y+58Z4mFCiDOpFu4iGzr1D+kbIMZ0qTNQgqXuZl5/IpkABDK/9KtS2FVxkVx"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>
</html>