<?php

session_start();

require("connect-db.php");
require("utils.php");

$movie_id = $_POST['id'];
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
    <p>Runtime: <?php echo $movie_info[0]['runtime'] ?></p>
    <p>Year: <?php echo $movie_info[0]['year'] ?></p>
    <p>Next Showing: </p>

</body>