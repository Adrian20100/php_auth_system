<?php

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookie', 1);

session_start();
require_once "/xampp/htdocs/auth-system/config/db.php";

//Logged users shouldn't see login page
if(isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit;
}

$error = ""; //To store feedback for the user

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            $_SESSION["user_id"] = $user["id"];
            header("Location: ../dashboard.php");
            exit;
       
        }
   
    }
    $error = "Invalid email or password"; // Generic error message for security

   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <label>
                Email:
                <input type="email" name="email" required>
            </label><br><br>

            <label>
                Password:
                <input type="password" name="password" required>
            </label><br><br>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>