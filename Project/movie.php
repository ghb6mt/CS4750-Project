<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Movie Page</title>

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
            if (!isset($_SESSION['username'])) {
                header("Location: login.html");
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $movie_id = $_POST['id'];
                if(!empty($_POST['rate_movie'])){
                   echo rateMovie($_SESSION['username'],$movie_id, $_POST['stars'], $_POST['comment']);
                }
            }
            elseif(isset($_GET['movie_id'])){
                $movie_id = $_GET['movie_id'];
            }

            $movie_info = getMovieInfo($movie_id);
            $movie_genre = getMovieGenre($movie_id);
            $movie_lead_actor = getMovieLeadActor($movie_id);
            $snackList = getSnacksForMovie($movie_id);
            $showtimes = getSpecificMovieShowings($movie_id);
            $movie_ratings = getRatingsForMovie($movie_id);
            $avg_rating = getAverageRatingForMovie($movie_id);
        ?>

        <h1><?php echo $movie_info[0]['title'] ?></h1>

        <!-- Movie Information -->
        <div class="row">
            <div class="col-md-6">
                <p><?php echo $movie_info[0]['description'] ?></p>
                <p>Genre: <?php echo $movie_genre[0][0] ?></p>
                <p>Lead Actor: <?php echo $movie_lead_actor[0][0] ?></p>
                <p>Rating: <?php echo $movie_info[0]['age_rating'] ?></p>
                <p>Runtime: <?php echo $movie_info[0]['runtime'] ?> minutes</p>
                <p>Year: <?php echo $movie_info[0]['year'] ?></p>
                <p>Rating: <td><?php 
                    if (is_numeric($avg_rating[0])) {
                        echo $avg_rating[0];
                    } else {
                        echo "Not Rated";
                    }
                ?></td></p>
            </div>
            <div class="col-md-6">
                <!-- Exclusive Movie Snack -->
                <h3>Exclusive Movie Snack</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Brand</th>
                            <th>Type</th>
                            <th>Calories</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($snackList as $snack): ?>
                            <tr>
                                <td><?php echo $snack['name']; ?></td>
                                <td><?php echo $snack['price']; ?></td>
                                <td><?php echo $snack['brand']; ?></td>
                                <td><?php echo $snack['type']; ?></td>
                                <td><?php echo $snack['calories']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Next Showings -->
        <h2>Next Showings</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Room</th>
                    <th>City</th>
                    <th>Street</th>
                    <th>State</th>
                    <th>ZIP Code</th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>

        <!-- User Rating Form -->
        <h2>Rate This Movie</h2>
        <?php if (!empty(hasUserRated($_SESSION['username'], $movie_id))): ?>
            <p>Already rated this movie!</p>
        <?php else: ?>
            <form action="movie.php" method="post">
                <input type="hidden" name="id" value="<?php echo $movie_id ?>">
                <label for="stars">Number of Stars:</label>
                <input type="number" id="stars" name="stars" required><br>

                <label for="comment">Comment</label>
                <textarea name="comment" id="comment" required></textarea><br>

                <input type="submit" name="rate_movie" value="Submit" class="btn btn-primary">
            </form>
        <?php endif; ?>

        <!-- Ratings -->
        <h2>Ratings</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Number of Stars</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movie_ratings as $rate): ?>
                    <tr>
                        <td><?php echo $rate['number_of_stars']; ?></td>
                        <td><?php echo $rate['comment']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-JN8Y+58Z4mFCiDOpFu4iGzr1D+kbIMZ0qTNQgqXuZl5/IpkABDK/9KtS2FVxkVx"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JzjwEOj0VaCUfy/Ap41SssHXRuoZ5WJSyI99aSGDAe2I/DtFq3cxn2r7RDiJdDWA"
        crossorigin="anonymous"></script>

</body>
</html>

<!-- 
<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }

require("connect-db.php");
require("utils.php");
if(!isset($_SESSION['username'])){
    header("Location: login.html");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $movie_id = $_POST['id'];
    if(!empty($_POST['rate_movie'])){
       echo rateMovie($_SESSION['username'],$movie_id, $_POST['stars'], $_POST['comment']);
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
    <?php $snackList = getSnacksForMovie($movie_id); ?>
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
    <?php foreach ($snackList as $snack): ?>
        <tr>
            <td><?php echo $snack['name']; ?></td>
            <td><?php echo $snack['price']; ?></td>
            <td><?php echo $snack['brand']; ?></td>
            <td><?php echo $snack['type']; ?></td>
            <td><?php echo $snack['calories']; ?></td>
    </tr>
    <?php endforeach; ?>
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
-->
