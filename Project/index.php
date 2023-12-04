<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }

require("connect-db.php");
require("utils.php");

include('navbar.php');

?>

<?php
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

<h1> List of Movies </h1>

<form method="POST" action="index.php">
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

<div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <thead>
        <tr style="background-color:#B0B0B0">
            <th width="30%">Movie Title
            <th width="30%">Lead Actor
            <th width="30%">Age Rating
            <th width="30%">Genre
            <th width="30%">Runtime
            <th width="30%">Rating
            <th width="30%">Favorite
        </tr>
    </thead>
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
    </table>
</div>