<?php
session_start();
  require 'db.php';
$error = '';
$success = '';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name     = trim($_POST['name']);
        $email    = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($name) || empty($email) || empty($password)) {
            $error = "All fields are required.";
        } else {

            // Check if email exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $error = "Email already exists.";
            } else {

                // Hash password
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // Insert user
                $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hash]);

                $success = "Account created! You can now login.";
            }
        }
    }

} catch (PDOException $e) {
    $error = "Connection error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 80px auto; }
        input { display: block; width: 100%; padding: 8px; margin: 6px 0 14px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error   { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h2>Register</h2>

    <?php if ($error)   echo "<p class='error'>$error</p>"; ?>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>

    <form method="POST">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
   
</body>
</html>
