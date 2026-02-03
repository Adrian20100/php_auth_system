<?php
require_once "/xampp/htdocs/auth-system/config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare (
        "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration succesful";

    } else {
        echo "Eroor: email already exists";
    }

   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Create an account</h2>

    <form method="POST" action="">
        <label>
            Username:
            <input type="text" name="username" required>
        </label><br><br>

        <label>
            Email:
            <input type="text" name="email" required>
        </label><br><br>

        <label>
            Password:
            <input type="password" name="password" required>
        </label><br><br>

        <button type="submit">Register</button>
    </form>
    
</body>
</html>