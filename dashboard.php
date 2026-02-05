<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}
?>

<h1>Welcome to the dashboard</h1>
<p>You are logged in</p>
<a href="auth/logout.php">Logout</a>