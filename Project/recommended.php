<?php

session_start();

require("connect-db.php");
require("utils.php");

include('navbar.php');

?>

<?php
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