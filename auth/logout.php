<?php
session_start();

$_SESSION = []; // Remove all session variables

session_destroy(); // destroy the session


header("Location: login.php"); // redirect to login
exit;
?>
