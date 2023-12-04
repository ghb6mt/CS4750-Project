<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }

?>

<!DOCTYPE html>
<html>
<head>
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #e27743;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 10px 70px;
  font-size: 20px;
  font-family: sans-serif;
  text-decoration: none;
}

li a:hover {
  background-color: #e25743;
}

</style>
</head>
<body>

<ul>
  <li><img src="cinemavision.png" width = "125" height = "63" alt="CinemaVision Logo"></li>
  <li><a class="active" href="index.php">MOVIES</a></li>
  <li><a href="recommended.php">RECOMMENDED FOR YOU</a></li>
  <li><a href="logout.php">LOGOUT</a></li>
  <?php if($_SESSION['is_admin'] == 1){
    ?> 
    <li><a href="admin.php">ADMIN PAGE</a></li>
 <?php } ?>
  <li><a href="profile.php"><img src="profile.png" width = "50" height = "50" alt="Profile"></a></li>
</ul>

</body>
</html>