<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
session_unset();
session_destroy();
session_write_close();
header("Location: login.html");
?>