<?php
session_start();

$_SESSION = []; // Remove all session variables

//Delete the session cookie (important for security)
if (ini_get("session.use cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy(); // destroy the session


header("Location: login.php"); // redirect to login
exit;
?>
