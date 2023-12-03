<?php

session_start();

if($_SESSION['is_admin'] == 0){
    header("Location: index.php");
}

require("connect-db.php");
require("utils.php");

include('navbaradmin.html');

//add if here to call right thing from utils

$movielist = allMovies();
$theaterlist = getAllTheaters();
$snackList = getAllSnacks();
$theater_ids = array();
$userList = getAllUsers($_SESSION['username']);

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
    elseif(!empty($_POST['delete_movie'])) {
        deleteMovie($_POST['movie_id']);    
    }
    elseif(!empty($_POST['add_showing'])) {
        $mytime = date("Y-m-d H:i:s", strtotime($_POST['time']));
        addMovieShowing($_POST['movie_id'],$_POST['theater_id'],$mytime,$_POST['room']);  
    }
    elseif(!empty($_POST['delete_showing'])){
        deleteMovieShowing($_POST['showing_id']);
    }
    elseif(!empty($_POST['add_snack'])){
        addSnack($_POST['movie_id'],$_POST['name'],$_POST['price'],$_POST['brand'],$_POST['type'],$_POST['calories']);
    }
    elseif(!empty($_POST['delete_snack'])){
        deleteSnack($_POST['snack_id'], $_POST['name'], $_POST['price'], $_POST['brand']);
    }
    elseif(!empty($_POST['delete_user'])){
       deleteUser($_POST['username']);
    }
    elseif(!empty($_POST['edit_user_role'])){
        swapUserRole($_POST['username'], $_POST['role']);
    }

    $movielist = allMovies();
    $theaterlist = getAllTheaters();
    $snackList = getAllSnacks();
    $theater_ids = array();
    $userList = getAllUsers($_SESSION['username']);
  }


?>

<!-- 
    This is the original everything we wrote by hand, but we used GPT to bootstrap it, just wanted to show the fact we
    wrote it all by hand and only used GPT for the bootstrapping    
<head>
    <title>Admin Page</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    
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
    <form method="post" action="admin.php">
        Movie ID: <input type="text" name="movie_id"><br>
        Theater ID: <input type="text" name="theater_id"><br>
        Time: <input type="datetime-local" name="time"><br>
        Room: <input type = "text" name="room"></input><br>
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

    <h2>Add Snack</h2>
    <form method="post" action="admin.php">
        Name: <input type="text" name="name"><br>
        Price: <input type="text" name="price"><br>
        Brand: <input type="text" name="brand"><br>
        Type: <input type="text" name="type"><br>
        Calories: <input type="text" name="calories"><br>
        Movie ID: <input type="text" name="movie_id"><br>
        <input type="submit" name="add_snack" value="Add Snack">
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
                    <form action="admin.php" method="post" style="display: inline;">
                        <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                        <button type="submit" name="delete_movie" value="delete" class="btn btn-danger">Delete</button>
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
                    <form action="admin.php" method="post" style="display: inline;">
                        <input type="hidden" name="showing_id" value="<?php echo $showing['showing_id']; ?>">
                        <button type="submit" name="delete_showing" value="delete_showing" class="btn btn-danger">Delete</button>
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
                    <form action="admin.php" method="post" style="display: inline;">
                        <input type="hidden" name="snack_id" value="<?php echo $snack['snack_id']; ?>">
                        <input type="hidden" name="name" value="<?php echo $snack['name']; ?>">
                        <input type="hidden" name="name" value="<?php echo $snack['price']; ?>">
                        <input type="hidden" name="name" value="<?php echo $snack['brand']; ?>">
                        <input type="hidden" name="name" value="<?php echo $snack['type']; ?>">
                        <button type="submit" name="delete_snack" value="delete_snack" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <h3><?php echo $_SESSION['username'];?></h3>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Admin Dashboard</h1>
        <div class="card mt-4">
            <div class="card-body">
                <h3 class="card-title">Add Movie</h2>
                <form method="post" action="admin.php">
                    Title: <input type="text" name="title" class="form-control"><br>
                    Runtime: <input type="text" name="runtime" class="form-control"><br>
                    Year: <input type="text" name="year" class="form-control"><br>
                    Description: <textarea name="desc" class="form-control"></textarea><br>
                    Age Rating: <input type="text" name="age" class="form-control"><br>
                    Genre: <input type="text" name="genre" class="form-control"><br>
                    Lead Actor: <input type="text" name="lead" class="form-control"><br>
                    <input type="submit" name="add_movie" value="Add Movie" class="btn btn-primary">
                </form>
            </div>
        </div>

        <div class="card mt-4">
        <div class="card-body">
        <h2 class="card-title">Add Showing</h2>
        <form method="post" action="admin.php">
            Movie ID: <input type="text" name="movie_id" class="form-control"><br>
            Theater ID: <input type="text" name="theater_id" class="form-control"><br>
            Time: <input type="datetime-local" name="time" class="form-control"><br>
            Room: <input type="text" name="room" class="form-control"></input><br>
            <input type="submit" name="add_showing" value="Add Showing" class="btn btn-primary">
        </form>
        </div>
        </div>

        <div class="card mt-4">
        <div class="card-body">
        <h2 class="card-title">Add Theater</h2>
        <form method="post" action="admin.php">
            City <input type="text" name="city" class="form-control"><br>
            Street: <input type="text" name="street" class="form-control"><br>
            State: <input type="text" name="state" class="form-control"><br>
            Company: <input type="text" name="company" class="form-control"><br>
            Zip Code: <input type="text" name="zip" class="form-control"><br>
            <input type="submit" name="add_theater" value="Add Theater" class="btn btn-primary">
        </form>
        </div>
        </div>

           <div class="card mt-4">
           <div class="card-body">
        <h2 class="card-title">Add Snack</h2>
        <form method="post" action="admin.php">
            Name: <input type="text" name="name" class="form-control"><br>
            Price: <input type="text" name="price" class="form-control"><br>
            Brand: <input type="text" name="brand" class="form-control"><br>
            Type: <input type="text" name="type" class="form-control"><br>
            Calories: <input type="text" name="calories" class="form-control"><br>
            Movie ID: <input type="text" name="movie_id" class="form-control"><br>
            <input type="submit" name="add_snack" value="Add Snack" class="btn btn-primary">
        </form>
           </div>
           </div>

        <h3 class="mt-4">List of Movies</h3>
        <div class="row justify-content-center">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
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
                            <form action="admin.php" method="post" style="display: inline;">
                                <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                                <button type="submit" name="delete_movie" value="delete" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- List of Theaters Table -->
        <h3 class="mt-4">List of Theaters</h3>
        <div class="row justify-content-center">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
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

        <h3 class="mt-4">List of Showings</h3>
        <div class="row justify-content-center">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
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
                            <form action="admin.php" method="post" style="display: inline;">
                                <input type="hidden" name="showing_id" value="<?php echo $showing['showing_id']; ?>">
                                <button type="submit" name="delete_showing" value="delete_showing" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- List of Snacks Table -->
        <h3 class="mt-4">List of Snacks</h3>
        <div class="row justify-content-center">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th width="20%">Movie</th>
                        <th width="15%">Snack Name</th>
                        <th width="10%">Price</th>
                        <th width="15%">Brand</th>
                        <th width="10%">Type</th>
                        <th width="10%">Calories</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($snackList as $snack): ?>
                        <tr>
                            <?php $movie = getMovieInfo($snack['movie_id']); ?>
                            <td><?php echo $movie[0]['title']; ?></td>
                            <td><?php echo $snack['name']; ?></td>
                            <td><?php echo $snack['price'] ?></td>
                            <td><?php echo $snack['brand']; ?></td>
                            <td><?php echo $snack['type']; ?></td>
                            <td><?php echo $snack['calories']; ?></td>
                            <td>
                                <!-- <form action="edit_snack.php" method="post" style="display: inline;">
                                    <input type="hidden" name="snack_id" value="<?php echo $snack['snack_id']; ?>">
                                    <button type="submit" name="action" value="edit_snack" class="btn btn-warning">Edit</button>
                                </form> Got rid of this form cause of issues trying to update it with the table-->
                                <form action="admin.php" method="post" style="display: inline;">
                                    <input type="hidden" name="snack_id" value="<?php echo $snack['snack_id']; ?>">
                                    <input type="hidden" name="name" value="<?php echo $snack['name']; ?>">
                                    <input type="hidden" name="price" value="<?php echo $snack['price']; ?>">
                                    <input type="hidden" name="brand" value="<?php echo $snack['brand']; ?>">
                                    <input type="hidden" name="type" value="<?php echo $snack['type']; ?>">
                                    <button type="submit" name="delete_snack" value="delete_snack" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <h3 class="mt-4">List of Users</h3>
        <div class="row justify-content-center">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th width="20%">Username</th>
                        <th width="15%">Is Admin</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userList as $user): ?>
                        <tr>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['is_admin']; ?></td>
                            <td>
                            <form action="admin.php" method="post" style="display: inline;">
                                    <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                                    <input type="hidden" name="role" value="<?php echo $user['is_admin']; ?>">
                                    <button type="submit" name="edit_user_role" value="edit_user_role" class="btn btn-warning">Switch Role</button>
                                </form>
                                <form action="admin.php" method="post" style="display: inline;">
                                    <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                                    <button type="submit" name="delete_user" value="delete_user" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>




    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap dropdowns) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
