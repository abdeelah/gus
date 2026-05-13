<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$sql = $conn->prepare("SELECT module_name, exam_date FROM modules WHERE user_id = ? ORDER BY exam_date ASC");
$sql->execute([$_SESSION['user_id']]);
$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background: #f5f5f5;
        }

        .container { text-align: center; }

        h1 {
            font-size: 22px;
            font-weight: 500;
            color: #1e293b;
            margin-bottom: 0.4rem;
        }

        h1 span { color: #2563eb; }

        p {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 1.5rem;
        }

        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 2rem;
        }

        a {
            text-decoration: none;
            padding: 9px 18px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #fff;
            font-size: 14px;
        }

        .add { color: #1e293b; }
        .logout { color: #dc2626; }

        .modules {
            margin-top: 1.5rem;
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .module-row {
            padding: 10px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            font-size: 14px;
            color: #1e293b;
            display: flex;
            justify-content: space-between;
        }

        .module-row span { color: #94a3b8; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>!</h1>
        <p>Session active</p>
        <div class="actions">
            <a href="add_module.php" class="add">+ Add module</a>
            <a href="logout.php" class="logout">Logout</a>
            <a href="module.php" class="add">Liste of Modules </a>
        </div>

        <div class="modules">
            <?php foreach ($rows as $row): ?>
                <div class="module-row">
                    <?= htmlspecialchars($row["module_name"]) ?>
                    <span><?= htmlspecialchars($row["exam_date"]) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html> 