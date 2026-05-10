<<?php
session_start();

// Si pas connecté, redirige vers login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$msg = '';

try {
    $conn = new PDO("mysql:host=localhost;dbname=exam_planner", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['submit'])) {

        $teacher             = $_POST['teacher'];
        $module_name         = $_POST['module_name'];
        $difficulty          = $_POST['difficulty'];
        $career_importance   = $_POST['career_importance'];
        $understanding_level = $_POST['understanding_level'];
        $exam_date           = $_POST['exam_date'];
        $progress            = $_POST['progress'];

        $sql = "INSERT INTO modules 
                ( user_id, module_name, teacher, difficulty, career_importance, progress, understanding_level, exam_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            $user_id,
            $module_name,
            $teacher,
            $difficulty,
            $career_importance,
            $progress,
            $understanding_level,
            $exam_date
        ]);

        $msg = "Module ajouté avec succès !";
    }

} catch (PDOException $e) {
    $msg = "Erreur : " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Module Registration</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: #f0f2f5;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      font-family: Arial, sans-serif;
    }
    .form-wrap {
      width: 100%;
      max-width: 600px;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 2rem;
    }
    h2 { font-size: 20px; margin-bottom: 1.5rem; color: #333; }
    .msg {
      background: #e6f4ea; color: #2d7a3a;
      border: 1px solid #b6dfbc; border-radius: 5px;
      padding: 10px 14px; margin-bottom: 1rem; font-size: 14px;
    }
    .err {
      background: #fdecea; color: #a32d2d;
      border: 1px solid #f5c1c1; border-radius: 5px;
      padding: 10px 14px; margin-bottom: 1rem; font-size: 14px;
    }
    .field { display: flex; flex-direction: column; margin-bottom: 1rem; }
    label { font-size: 13px; color: #555; margin-bottom: 5px; }
    input[type="text"], input[type="date"], select {
      height: 38px; padding: 0 10px;
      border: 1px solid #ccc; border-radius: 5px;
      font-size: 14px; color: #333; background: #fff; outline: none;
    }
    input:focus, select:focus { border-color: #4a90e2; }
    .row { display: flex; gap: 1rem; }
    .row .field { flex: 1; }
    button {
      width: 100%; height: 40px; margin-top: 1rem;
      background: #4a90e2; color: #fff;
      border: none; border-radius: 5px;
      font-size: 15px; cursor: pointer;
    }
    button:hover { background: #357abd; }
  </style>
</head>
<body>

<div class="form-wrap">
  <h2>Module Registration</h2>
  <p style="font-size:13px; color:#888; margin-bottom:1rem;">
    Connecté en tant que : <strong><?= $_SESSION['user_name'] ?></strong>
  </p>

  <?php if (isset($msg)): ?>
    <div class="<?= str_contains($msg, 'Erreur') ? 'err' : 'msg' ?>">
      <?= $msg ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="">

    <div class="row">

      <div class="field">
        <label for="module_name">Module Name</label>
        <input type="text" id="module_name" name="module_name" required>
      </div>
    </div>

    <div class="field">
      <label for="teacher">Teacher</label>
      <input type="text" id="teacher" name="teacher" required>
    </div>

    <div class="row">
      <div class="field">
        <label for="difficulty">Difficulty</label>
        <select id="difficulty" name="difficulty" required>
          <option value="">Select</option>
          <option value="Easy">Easy</option>
          <option value="Medium">Medium</option>
          <option value="Hard">Hard</option>
        </select>
      </div>
      <div class="field">
        <label for="career_importance">Career Importance</label>
        <select id="career_importance" name="career_importance" required>
          <option value="">Select</option>
          <option value="Low">Low</option>
          <option value="Medium">Medium</option>
          <option value="High">High</option>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="field">
        <label for="understanding_level">Understanding Level</label>
        <select id="understanding_level" name="understanding_level" required>
          <option value="">Select</option>
          <option value="Low">Low</option>
          <option value="Medium">Medium</option>
          <option value="High">High</option>
        </select>
      </div>
      <div class="field">
        <label for="progress">Progress (%)</label>
        <input type="text" id="progress" name="progress" required>
      </div>
    </div>

    <div class="field">
      <label for="exam_date">Exam Date</label>
      <input type="date" id="exam_date" name="exam_date" required>
    </div>

    <button type="submit" name="submit">Register</button>
  </form>
</div>
<a href="module.php"></a>
</body>
</html>