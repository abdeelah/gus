<?php
$dbname = 'abc';
$user = 'root';
$password = '';
$host = 'localhost';
try {
$conn = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);

$name = $_POST['name'];
$prename = $_POST['prename'];
$password = $_POST['password'];

$result = $conn->prepare("INSERT INTO ABCTABLE(A,B,C)VALUES(?,?,?)");
$sql = $result->execute([$name,$prename,$password]);
} catch (PDOException $e) {
    echo"erreur". $e->getMessage();
}


$newlink = $conn->prepare("SELECT name,prename,password FROM ABCTABLE");
$newlink-> execute();
$rows = $newlink->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $row){
      echo $row["name"] . '';
       echo  $row["prename"] . "<br>";
}