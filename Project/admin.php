<?php

session_start();

require("connect-db.php");
require("utils.php");

$movielist = allMovies();
$theaterlist = getAllTheaters();
?>

<head>
    <title>Admin Page</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Form to Add Movies -->
    <div class='card-body'>
    <h3 class="card-title">Add Movie</h2>
    <form method="post" action="addmovie.php">
        Title: <input type="text" name="title"><br>
        Runtime: <input type="text" name="runtime"><br>
        Year: <input type="text" name="year"><br>
        Description: <textarea name="desc"></textarea><br>
        Age Rating: <input type="text" name="age"><br>
        Genre: <input type="text" name="genre"><br>
        Lead Actor: <input type="text" name="lead"><br>
        <input type="submit" name="add_movie" value="Add Movie">
    </form>
</div>
    <h2>Add Showing</h2>
    <form method="post" action="addshowing.php">
        Movie ID: <input type="text" name="movie_id"><br>
        Theater ID: <input type="text" name="runtime"><br>
        Time: <input type="text" name="year"><br>
        Room: <textarea name="desc"></textarea><br>
        <input type="submit" name="add_showing" value="Add Showing">
    </form>


    <h3>List of Movies</h3>
    <div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
        <thead>
            <tr style="background-color:#B0B0B0">
                <th width="30%">Movie Title</th>
                <th width="30%">Movie ID</th>
                <th width="30%">Lead Actor</th>
                <th width="30%">Age Rating</th>
                <th width="30%">Genre</th>
                <th width="30%">Runtime</th>
                <th width="30%">Actions</th>
            </tr>
        </thead>
        <?php foreach ($movielist as $movie): ?>
            <tr>
                <td><?php echo $movie['title']; ?></td>
                <td><?php echo $movie['movie_id']; ?></td>
                <?php $leadActor = getMovieLeadActor($movie['movie_id']); ?>
                <td><?php echo $leadActor[0][0]; ?></td>
                <td><?php echo $movie['age_rating']; ?></td>
                <?php $genres = getMovieGenre($movie['movie_id']); ?>
                <td><?php echo $genres[0][0]; ?></td>
                <td><?php echo $movie['runtime']; ?></td>
                <td>
                    <form action="edit_or_delete.php" method="post" style="display: inline;">
                        <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                        <button type="submit" name="action" value="edit" class="btn btn-warning">Edit</button>
                    </form>
                    <form action="edit_or_delete.php" method="post" style="display: inline;">
                        <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                        <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>



    <h3>List of Theaters</h3>
<div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <thead>
        <tr style="background-color:#B0B0B0">
            <th width="30%">Company
            <th width="30%">City
            <th width="30%">Street
            <th width="30%">State
            <th width="30%">Theater ID
        </tr>
    </thead>
    <?php foreach ($theaterlist as $theater): ?>
        <tr>
        <?php $company = getTheaterCompany($theater['theater_id']); ?>
            <td><?php echo $company[0]['company']?></td>
            <td><?php echo $theater['city']; ?></td>
            <td><?php echo $theater['street']; ?></td>
            <td><?php echo $theater['state']; ?></td>
            <td><?php echo $theater['theater_id']; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>