<?php

session_start();

require("connect-db.php");
require("utils.php");

$movielist = getAllMovieInfo();
?>

<h3>List of Movies</h3>
<div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <thead>
        <tr style="background-color:#B0B0B0">
            <th width="30%">Title
            <th width="30%">Age Rating
            <th width="30%">Runtime
        </tr>
    </thead>
    <?php foreach ($movielist as $movie): ?>
        <tr>
            <td><?php echo $movie['title']; ?></td>
            <td><?php echo $movie['age_rating']; ?></td>
            <td><?php echo $movie['runtime']; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>