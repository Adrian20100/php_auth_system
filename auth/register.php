<?php
//Relative path to jump out of 'auth' and into 'config'
require_once "../config/db.php";

$message = "";
$messageClass = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare (
        "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        $message = "Registration succesfull! You can now log in.";
        $messageClass = "success-green"; //Matches a CSS color we defined

    } else {
        $message = "Error: this email is already registered.";
        $messageClass = "error-red"; 
    }

   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h2>Create an account</h2>

        <?php if($message):?>
            <div class="message" style="color: white; background-color: var(--<?php echo $messageClass;?>); padding: 10px; border-radius: 4px; margin-bottom: 10px;">
                <?php echo $message; ?>
            </div>
            <?php endif; ?>

        <form method="POST" action="">
            <label>Username:</label>
                <input type="text" name="username" placeholder="Choose a username" required>
         

            <label>Email:</label>
                <input type="text" name="email" placeholder="email@example.com" required>
            

            <label>Password:</label>
                <input type="password" name="password" placeholder="Min. 8 characters" required>
            

            <button type="submit">Register</button>
        </form>
    </div>
    
    <script src="../script.js"></script>
</body>
</html>