<?php

session_start();

require("connect-db.php");
require("utils.php");

$list = getAllMovieInfo();
?>