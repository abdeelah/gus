<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tableau</title>
    <meta name="color-scheme" content="light">
    <style>
        html, body { background: #f0f2f5 !important; color: #333 !important; }
        table {
            width: 95%; margin: 40px auto; border-collapse: collapse;
            background: white !important; border-radius: 12px;
            overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: monospace;
        }
        th { background-color: #d96459 !important; color: white !important; padding: 20px 30px; font-size: 20px; font-weight: bold; text-align: center; letter-spacing: 2px; }
        td { padding: 18px 30px; font-size: 18px; color: #d96459 !important; background: white !important; text-align: center; border-bottom: 1px solid #fde8e6; }
        td:first-child { font-size: 22px; font-weight: bold; color: #d96459 !important; text-align: center; }
        tr:nth-child(even) td { background-color: #fdf0ef !important; }
        tr:hover td { background-color: #fde8e6 !important; transition: background 0.2s; }
       .btn-delete { background: #d96459; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 15px; }
        .btn-delete:hover { background: #b94a40; }
        .btn-edit { background: #d96459; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 15px; }
        .btn-edit:hover { background: #b94a40; }
    </style>
</head>
<body>
<table>
    <tr>
        <th>ID</th>
        <th>Teacher</th>
        <th>Module name</th>
        <th>difficulty</th>
        <th>Carrer Importance</th>
        <th>Understanding Level</th>
        <th>Exam Date</th>
        <th>Progress</th>
    </tr>

<?php
session_start();
require 'db.php';
if(!isset($_SESSION['user_id'])){
    header("location:login.php") ;
    exit;
}

$user_id = $_SESSION["user_id"];

$sql = $conn->prepare("SELECT id,teacher,module_name,difficulty,career_importance,understanding_level,exam_date,progress from modules where user_id = ?");
$sql->execute([$user_id]);

$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $row){
        echo "<tr>
                 <td>" . $row["id"] . "</td>
                <td>" . $row["teacher"] . "</td>
                <td>" . $row["module_name"] . "</td>
                <td>" . $row["difficulty"] . "</td>
                <td>" . $row["career_importance"] . "</td>
                <td>" . $row["understanding_level"] . "</td>
                <td>" . $row["exam_date"] . "</td>
                 <td>" . $row["progress"] . "</td>
                <td>
                <a href='delete.php?id=" . $row["id"] . "' 
                       onclick=\"return confirm('Aree uuu sureee???????')\">
                        <button class='btn-delete'>🗑️ Delete</button>
                 </a>
                 </td><td>
                 <a href='edit.php?id=" .  $row["id"] .
                  "<button class='btn-edit'>✏️ Edit</button>
                </a>
                </td>
              </tr>";
    }
?>
</table>
</body>
</html>