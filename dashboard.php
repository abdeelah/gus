<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 80px auto; }
    </style>
</head>
<body>
    <h2>Dashboard</h2>
    <p>Welcome, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>!</p>
    <p>You are logged in.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
