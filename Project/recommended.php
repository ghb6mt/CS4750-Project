<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Recommendations</title>

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
        ?>

        <h1><?php echo $_SESSION['username'] . "'s Favorites"; ?></h1>

        <div class="row justify-content-center">
            <table class="table table-bordered table-striped" style="width:70%">
                <?php $favorites = getUserFavorites($_SESSION['username']) ?>
                <?php foreach ($favorites as $fav): ?>
                    <tr>
                        <?php $link = "movie.php?movie_id=". $fav['movie_id'];?>
                        <?php $mov = getMovieInfo($fav['movie_id']); ?>
                        <td><?php echo "<a href='$link'>".$mov[0]['title']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <br>
        <h1>Recommended for You</h1>

        <div class="row justify-content-center">
            <table class="table table-bordered table-striped" style="width:70%">
                <?php $recommendations = getRecommendations($_SESSION['username']) ?>
                <?php foreach ($recommendations as $rec): ?>
                    <tr>
                        <?php $link = "movie.php?movie_id=". $rec[0];?>
                        <?php $mov = getMovieInfo($rec[0]); ?>
                        <td><?php echo "<a href='$link'>".$mov[0]['title']; ?></td>
                    </tr>
                <?php endforeach; ?>
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
 <!-- 
 <?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }

require("connect-db.php");
require("utils.php");

include('navbar.php');

if(!isset($_SESSION['username'])){
    header("Location: login.html");
}
?>

<h1> <?php echo $_SESSION['username'] . "'s Favorites"; ?> </h1>

<div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <?php $favorites = getUserFavorites($_SESSION['username']) ?>
    <?php foreach ($favorites as $fav): ?>
        <tr>
            <?php $link = "movie.php?movie_id=". $fav['movie_id'];?>
            <?php $mov = getMovieInfo($fav['movie_id']); ?>
            <td><?php echo "<a href='$link'>".$mov[0]['title']; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>

<h1> Recommended for You </h1>

<div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <?php $recommendations = getRecommendations($_SESSION['username']) ?>
    <?php foreach ($recommendations as $rec): ?>
        <tr>
            <?php $link = "movie.php?movie_id=". $rec[0];?>
            <?php $mov = getMovieInfo($rec[0]); ?>
            <td><?php echo "<a href='$link'>".$mov[0]['title']; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>
                -->