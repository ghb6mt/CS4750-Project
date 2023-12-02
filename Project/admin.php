<?php

session_start();

require("connect-db.php");
require("utils.php");

//add if here to call right thing from utils

$movielist = allMovies();
$theaterlist = getAllTheaters();
$snackList = getAllSnacks();
$theater_ids = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['add_theater'])){
       addTheater($_POST['city'],$_POST['street'],$_POST['state'],$_POST['company'],$_POST['zip']);
    }
    elseif(!empty($_POST['add_movie'])) {
        // Retrieve form data
        $mytitle = $_POST['title'];
        $myruntime = $_POST['runtime'];
        $myyear = $_POST['year'];
        $mydesc = $_POST['desc'];
        $myage = $_POST['age'];
        $mygenre = $_POST['genre'];
        $mylead = $_POST['lead'];

        // Call the function from utils.php to add movie
    
        addMovie($mytitle, $myruntime, $myyear, $mydesc, $myage, $mygenre, $mylead);    
    }
    elseif(!empty($_POST['delete_theater'])) {
        deleteTheater($_POST['theater_id']);    
    }

    $movielist = allMovies();
    $theaterlist = getAllTheaters();
    $snackList = getAllSnacks();
    $theater_ids = array();
  }


?>

<head>
    <title>Admin Page</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Form to Add Movies -->
    <div class='card-body'>
    <h3 class="card-title">Add Movie</h2>
    <form method="post" action="admin.php">
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

    <h2>Add Theater</h2>
    <form method="post" action="admin.php">
        City <input type="text" name="city"><br>
        Street: <input type="text" name="street"><br>
        State: <input type="text" name="state"><br>
        Company: <input type="text" name="company"><br>
        Zip Code: <input type="text" name="zip"><br>
        <input type="submit" name="add_theater" value="Add Theater">
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
                    <form action="edit_movie.php" method="post" style="display: inline;">
                        <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                        <button type="submit" name="action" value="edit" class="btn btn-warning">Edit</button>
                    </form>
                    <form action="delete_movie.php" method="post" style="display: inline;">
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
                <th width="30%">Company</th>
                <th width="30%">City</th>
                <th width="30%">Street</th>
                <th width="30%">State</th>
                <th width="30%">Theater ID</th>
                <th width="30%">Actions</th>
            </tr>
        </thead>
        <?php foreach ($theaterlist as $theater): ?>
            <tr>
                <?php $company = getTheaterCompany($theater['theater_id']); array_push($theater_ids,$theater['theater_id']); ?>
                <td><?php echo $company[0]['company']?></td>
                <td><?php echo $theater['city']; ?></td>
                <td><?php echo $theater['street']; ?></td>
                <td><?php echo $theater['state']; ?></td>
                <td><?php echo $theater['theater_id']; ?></td>
                <td>
                    <form action="admin.php" method="post" style="display: inline;">
                        <input type="hidden" name="theater_id" value="<?php echo $theater['theater_id']; ?>">
                        <button type="submit" name="delete_theater" value="delete_theater" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>


<h3>List of Showings</h3>
<div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
        <thead>
            <tr style="background-color:#B0B0B0">
                <th width="30%">Movie</th>
                <th width="30%">Theater</th>
                <th width="30%">City</th>
                <th width="30%">Street</th>
                <th width="30%">State</th>
                <th width="30%">Time</th>
                <th width="30%">Room</th>
                <th width="30%">Actions</th>
            </tr>
        </thead>
        <?php 
        $showingList = getAllShowings(); // Fetch all showings
        foreach ($showingList as $showing): ?>
            <tr>
                <?php 
                $movie = getMovieInfo($showing['movie_id']); 
                $theaterComp = getTheaterCompany($showing['theater_id']); 
                $theater = getTheater($showing['theater_id']); 
                ?>
                <td><?php echo $movie[0]['title'];?></td>
                <td><?php echo $theaterComp[0]['company']; ?></td>
                <td><?php echo $theater[0]['city']; ?></td>
                <td><?php echo $theater[0]['street']; ?></td>
                <td><?php echo $theater[0]['state']; ?></td>
                <td><?php echo $showing['time']; ?></td>
                <td><?php echo $showing['room']; ?></td>
                <td>
                    <form action="edit_showing.php" method="post" style="display: inline;">
                        <input type="hidden" name="showing_id" value="<?php echo $showing['showing_id']; ?>">
                        <button type="submit" name="action" value="edit_showing" class="btn btn-warning">Edit</button>
                    </form>
                    <form action="delete_showing.php" method="post" style="display: inline;">
                        <input type="hidden" name="showing_id" value="<?php echo $showing['showing_id']; ?>">
                        <button type="submit" name="action" value="delete_showing" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>




<h3>List of Snacks</h3>
<div class="row justify-content center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
        <thead>
            <tr style="background-color:#B0B0B0">
                <th width="30%">Movie</th>
                <th width="30%">Snack Name</th>
                <th width="30%">Price</th>
                <th width="30%">Brand</th>
                <th width="30%">Type</th>
                <th width="30%">Calories</th>
                <th width="30%">Actions</th>
            </tr>
        </thead>
        <?php foreach ($snackList as $snack): ?>
            <tr>
                <?php $movie = getMovieInfo($snack['movie_id']); ?>
                <td><?php echo $movie[0]['title'];?></td>
                <td><?php echo $snack['name']; ?></td>
                <td><?php echo $snack['price'] ?></td>
                <td><?php echo $snack['brand']; ?></td>
                <td><?php echo $snack['type']; ?></td>
                <td><?php echo $snack['calories']; ?></td>
                <td>
                    <form action="edit_snack.php" method="post" style="display: inline;">
                        <input type="hidden" name="snack_id" value="<?php echo $snack['snack_id']; ?>">
                        <button type="submit" name="action" value="edit_snack" class="btn btn-warning">Edit</button>
                    </form>
                    <form action="delete_snack.php" method="post" style="display: inline;">
                        <input type="hidden" name="snack_id" value="<?php echo $snack['snack_id']; ?>">
                        <button type="submit" name="action" value="delete_snack" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
