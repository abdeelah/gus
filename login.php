<?php
session_start();
  require 'db.php';
$error = '';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $email    = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            $error = "All fields are required.";
        } else {

            // جلب user
            $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
            $stmt->execute([$email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {

                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                header("Location: dashboard.php");
                exit;

            } else {
                $error = "Incorrect email or password.";
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
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 80px auto; }
        input { display: block; width: 100%; padding: 8px; margin: 6px 0 14px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Login</h2>

    <?php if ($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>No account? <a href="register.php">Register</a></p>
</body>
</html>
