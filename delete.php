<?php
require 'db.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM modules WHERE id = ?");
    $stmt->execute([$id]);

}

header("Location: modules.php");
exit;
?>