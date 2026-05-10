<!DOCTYPE html>
<html>
    <head>
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

<?php
require 'db.php';

 $id = $_GET['id'];
$sql = $conn->prepare("select * from modules where id = ?");
$sql->execute(['$id']);

$module = $sql->fetch(PDO::FETCH_ASSOC);
?>
<form method="POST" action="">

  <input type="hidden" name="id" value="<?= $module['id'] ?>">

  <div class="row">
    <div class="field">
      <label for="module_name">Module Name</label>
      <input type="text" id="module_name" name="module_name" required value="<?= $module['module_name'] ?>">
    </div>
  </div>

  <div class="field">
    <label for="teacher">Teacher</label>
    <input type="text" id="teacher" name="teacher" required value="<?= $module['teacher'] ?>">
  </div>

  <div class="row">
    <div class="field">
      <label for="difficulty">Difficulty</label>
      <select id="difficulty" name="difficulty" required>
        <option value="">Select</option>
        <option value="Easy"   <?= $module['difficulty']==='Easy'   ? 'selected' : '' ?>>Easy</option>
        <option value="Medium" <?= $module['difficulty']==='Medium' ? 'selected' : '' ?>>Medium</option>
        <option value="Hard"   <?= $module['difficulty']==='Hard'   ? 'selected' : '' ?>>Hard</option>
      </select>
    </div>
    <div class="field">
      <label for="career_importance">Career Importance</label>
      <select id="career_importance" name="career_importance" required>
        <option value="">Select</option>
        <option value="Low"    <?= $module['career_importance']==='Low'    ? 'selected' : '' ?>>Low</option>
        <option value="Medium" <?= $module['career_importance']==='Medium' ? 'selected' : '' ?>>Medium</option>
        <option value="High"   <?= $module['career_importance']==='High'   ? 'selected' : '' ?>>High</option>
      </select>
    </div>
  </div>

  <div class="row">
    <div class="field">
      <label for="understanding_level">Understanding Level</label>
      <select id="understanding_level" name="understanding_level" required>
        <option value="">Select</option>
        <option value="Low"    <?= $module['understanding_level']==='Low'    ? 'selected' : '' ?>>Low</option>
        <option value="Medium" <?= $module['understanding_level']==='Medium' ? 'selected' : '' ?>>Medium</option>
        <option value="High"   <?= $module['understanding_level']==='High'   ? 'selected' : '' ?>>High</option>
      </select>
    </div>
    <div class="field">
      <label for="progress">Progress (%)</label>
      <input type="number" id="progress" name="progress" required value="<?= $module['progress'] ?>">
    </div>
  </div>

  <div class="field">
    <label for="exam_date">Exam Date</label>
    <input type="date" id="exam_date" name="exam_date" required value="<?= $module['exam_date'] ?>">
  </div>

  <button type="submit" name="update">Update</button>

</form>
<?php

if (isset($_POST['update'])) {

    $stmt = $conn->prepare("
        UPDATE modules 
        SET module_name = ?, teacher = ?, difficulty = ?, career_importance = ?, understanding_level = ?, progress = ?, exam_date = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $_POST['module_name'],
        $_POST['teacher'],
        $_POST['difficulty'],
        $_POST['career_importance'],
        $_POST['understanding_level'],
        $_POST['progress'],
        $_POST['exam_date'],
        $_POST['id']
    ]);

    header("Location: modules.php");
    exit;
}
?>
</body>
</html>