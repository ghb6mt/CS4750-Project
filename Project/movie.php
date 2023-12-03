<?php

session_start();

require("connect-db.php");
require("utils.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $movie_id = $_POST['id'];
    if(!empty($_POST['rate_movie'])){
        rateMovie($_SESSION['username'],$movie_id, $_POST['stars'], $_POST['comment']);
    }
}
elseif(isset($_GET['movie_id'])){
    $movie_id = $_GET['movie_id'];
}
include('navbar.php')
?>

<head>
    <title>Movie Page</title>
</head>
<body>
    <h1>Movie Page</h1>
    <?php $movie_info = getMovieInfo($movie_id); ?>
    <p><?php echo $movie_info[0]['title'] ?></p>
    <p><?php echo $movie_info[0]['description'] ?></p>
    <?php $movie_genre = getMovieGenre($movie_id); ?>
    <p>Genre: <?php echo $movie_genre[0][0] ?></p>
    <?php $movie_lead_actor = getMovieLeadActor($movie_id); ?>
    <p>Lead Actor: <?php echo $movie_lead_actor[0][0] ?></p>
    <p>Rating: <?php echo $movie_info[0]['age_rating'] ?></p>
    <p>Runtime: <?php echo $movie_info[0]['runtime'] ?> minutes</p>
    <p>Year: <?php echo $movie_info[0]['year'] ?></p>
    <p>Rating: <?php 
                if (is_numeric($avg_rating[0])) {
                    echo $avg_rating[0];
                } else {
                    echo "Not Rated";
                } ?></p>
    <p> Exclusive Movie Snack: </p>
    <?php $snack = getSnacksForMovie($movie_id); ?>
    <div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <thead>
        <tr style="background-color:#B0B0B0">
            <th width="30%">Name
            <th width="30%">Price
            <th width="30%">Brand
            <th width="30%">Type
            <th width="30%">Calories
        </tr>
    </thead>
        <tr>
            <td><?php echo $snack[0]['name']; ?></td>
            <td><?php echo $snack[0]['price']; ?></td>
            <td><?php echo $snack[0]['brand']; ?></td>
            <td><?php echo $snack[0]['type']; ?></td>
            <td><?php echo $snack[0]['calories']; ?></td>
    </tr>
    </table>
    <p>Next Showings: </p>
    <?php $showtimes = getSpecificMovieShowings($movie_id); ?>
    <div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <thead>
        <tr style="background-color:#B0B0B0">
            <th width="30%">Time
            <th width="30%">Room
            <th width="30%">City
            <th width="30%">Street
            <th width="30%">State
            <th width="30%">ZIP Code
        </tr>
    </thead>
    <?php foreach ($showtimes as $show): ?>
        <tr>
            <td><?php echo $show['time']; ?></td>
            <td><?php echo $show['room']; ?></td>
            <?php $theater_name = getTheater($show['theater_id']); ?>
            <td><?php echo $theater_name[0]['city']; ?></td>
            <td><?php echo $theater_name[0]['street']; ?></td>
            <td><?php echo $theater_name[0]['state']; ?></td>
            <?php $zc = getZipCode($theater_name[0]['city'], $theater_name[0]['street'], $theater_name[0]['state']); ?>
            <td><?php echo $zc[0][0]; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>

    <?php
    if(!empty(hasUserRated($_SESSION['username'],$movie_id))){
        echo "Already rated this movie!";
    }
    else{?>
        <form action="movie.php" method="post">
        <input type="hidden" name="id" value="<?php echo $movie_id ?>">
        <label for="stars">Number of Stars:</label>
        <input type="number" id="stars" name="stars" required><br>

        <label for="comment">Comment</label>
        <textarea name="comment" id="comment" required></textarea><br>


        <input type="submit" name="rate_movie" value="Submit">
    </form>
   <?php } ?>
    </div>

    <p>Ratings: </p>
    <?php $movie_ratings = getRatingsForMovie($movie_id); ?>
    <div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <thead>
        <tr style="background-color:#B0B0B0">
            <th width="30%">Number of Stars
            <th width="30%">Comment
        </tr>
    </thead>
    <?php foreach ($movie_ratings as $rate): ?>
        <tr>
            <td><?php echo $rate['number_of_stars']; ?></td>
            <td><?php echo $rate['comment']; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
</body>