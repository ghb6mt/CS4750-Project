<?php

session_start();

require("connect-db.php");
require("utils.php");

$movielist = allMovies();
?>

<h3>List of Movies</h3>
<div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <thead>
        <tr style="background-color:#B0B0B0">
            <th width="30%">Movie Title
            <th width="30%">Lead Actor
            <th width="30%">Age Rating
            <th width="30%">Genre
            <th width="30%">Runtime
        </tr>
    </thead>
    <?php foreach ($movielist as $movie): ?>
        <tr>
            <td><?php echo $movie['title']; ?></td>
            <?php $leadActor = getMovieLeadActor($movie['movie_id']); ?>
            <td><?php echo $leadActor[0][0] ?></td>
            <td><?php echo $movie['age_rating']; ?></td>
            <?php $genres = getMovieGenre($movie['movie_id']); ?>
            <td><?php echo $genres[0][0] ?></td>
            <td><?php echo $movie['runtime']; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>

<form method="POST" action="movie.php">
    <pre>Insert Movie ID: <input type="number" name="id"> </pre>
    <input type="submit" value="Go to Movie Page">
</form>