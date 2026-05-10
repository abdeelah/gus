<?php 
  $conn = new PDO("mysql:host=localhost;dbname=exam_planner", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>