<?php

session_start();
require_once "config/db.php"; //Root level file

//1.Gatekeeper Check
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

//2.Fetch User Data
$userId = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$isAdmin = ($user['role'] === 'admin');

if (!$user) {
    //Safety check: If user was deleted from DB but session still exists
    session_destroy();
    header("Location: auth/login.php");
    exit; 
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | <?php echo htmlspecialchars($user['username']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php if ($isAdmin): ?>
    <div style="background: #e1f5fe; padding: 10px; border-left: 5px solid #03a9f4; margin-top: 10px;">
        <strong>Admin Control Panel:</strong>
        <ul>
            <li><a href="admin_users.php">Manage users</a></li>
            <li><a href="admin_settings.php">System Settings</a></li>
        </ul>
    </div>
<?php endif; ?>
    <div class="container" style="max-width: 600px;">
        <h1>Welcome back, <?php echo htmlspecialchars($user['username']); ?></h1>

        <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 5px solid #b6b6b6;">
            <h3>Your Profile Dashboard:</h3>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <p>This is your private dashboard area.</p>

        <hr>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="index.php" style="flex: 1;"><button type="button" style="background-color: #7F8c8d; border-radius: 4px; cursor: pointer;">Home</button></a>
            <a href="auth/logout.php" style="flex: 1"><button type="button" style="background-color: black; color: white; border: 1px solid black; border-radius: 4px; cursor: pointer;" >Logout</button></a>
        </div>
    </div>
    
</body>
</html>