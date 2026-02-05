<?php

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookie', 1);

session_start();
require_once "/xampp/htdocs/auth-system/config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT id, password FROM users WHERE email = ?"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            header("Location: ../dashboard.php");
            exit;
        } else {
            echo "Invalid credentials";
        }
    } else {
        echo "Invalid credentials";
    }

    session_start();
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
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
    
</body>
</html>