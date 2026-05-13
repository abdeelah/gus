<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$plan = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch modules
    $sql = $conn->prepare("SELECT module_name, teacher, difficulty, career_importance, progress, understanding_level, exam_date FROM modules WHERE user_id = ?");
    $sql->execute([$_SESSION['user_id']]);
    $modules = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (empty($modules)) {
        $error = "No modules found. Please add modules first.";
    } else {
        // Build prompt
        $moduleList = "";
        foreach ($modules as $m) {
            $moduleList .= "- Module: {$m['module_name']} | Teacher: {$m['teacher']} | Difficulty: {$m['difficulty']} | Career Importance: {$m['career_importance']} | Progress: {$m['progress']}% | Understanding: {$m['understanding_level']}% | Exam Date: {$m['exam_date']}\n";
        }

        $prompt = "I am a student with the following modules:\n\n$moduleList\nBased on this data, create a structured 7-day revision plan. Prioritize modules with close exam dates, high difficulty, low progress, and low understanding level. Be specific about what to study each day and for how long.";

        // Call GitHub Models API
$token = getenv('GITHUB_TOKEN');
        $data = [
            "messages" => [
                ["role" => "system", "content" => "You are an expert academic study planner. Create clear, realistic, and motivating study plans."],
                ["role" => "user", "content" => $prompt]
            ],
            "model" => "gpt-4o-mini",
            "max_tokens" => 1500
        ];

        $ch = curl_init("https://models.inference.ai.azure.com/chat/completions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        $plan = $result['choices'][0]['message']['content'] ?? "";

        if ($plan) {
            // Save to study_plans table
         $save = $conn->prepare("INSERT INTO study_plans (user_id, generated_plan) VALUES (?, ?)");
            $save->execute([$_SESSION['user_id'], $plan]);
        } else {
            $error = "Failed to generate plan. Check your API token.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Study Plan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 860px;
            margin: 40px auto;
            background: #f5f5f5;
            padding: 20px;
        }
        h1 { color: #2563eb; margin-bottom: 0.3rem; }
        p { color: #94a3b8; font-size: 13px; margin-bottom: 1.5rem; }
        .btn {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }
        .btn:hover { background: #1d4ed8; }
        .plan {
            margin-top: 2rem;
            background: #fff;
            padding: 24px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            white-space: pre-wrap;
            line-height: 1.8;
            font-size: 14px;
            color: #1e293b;
        }
        .error {
            color: #dc2626;
            margin-top: 1rem;
        }
        a {
            display: inline-block;
            margin-bottom: 20px;
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <a href="dashboard.php">← Back to Dashboard</a>
    <h1>📚 AI Study Plan</h1>
    <p>Generate a personalized 7-day revision plan based on your modules.</p>

    <form method="POST">
        <button type="submit" class="btn">✨ Generate My Study Plan</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($plan): ?>
        <div class="plan"><?= htmlspecialchars($plan) ?></div>
    <?php endif; ?>
</body>
</html>