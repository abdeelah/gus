<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Tableau</title>
     <meta name="color-scheme" content="light">
      <style>
        html, body {
            background: #f0f2f5 !important;
            color: #333 !important;
        }
       /* ===== TABLE BIGGER ===== */
table {
    width: 95%;
    margin: 40px auto;
    border-collapse: collapse;
    background: white !important;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    font-family: monospace;
}

th {
    background-color: #d96459 !important;
    color: white !important;
    padding: 20px 30px;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    letter-spacing: 2px;
}

td {
    padding: 18px 30px;
    font-size: 18px;
    color: #d96459 !important;
    background: white !important;
    text-align: center;
    border-bottom: 1px solid #fde8e6;
}

/* ===== أرقام فالوسط ===== */
td:first-child {
    font-size: 22px;
    font-weight: bold;
    color: #d96459 !important;
    text-align: center;
}

tr:nth-child(even) td {
    background-color: #fdf0ef !important;
}

tr:hover td {
    background-color: #fde8e6 !important;
    transition: background 0.2s;
}
    </style>
</head>
<body>
<table >
    <tr>
        <th>ID</th>
        <th>Produit</th>
        <th>Le prix à l'unité</th>
        <th> prix d'achat </th>
        <th>Le prix de vente</th>
        <th>Category</th>
        <th>Quantite</th>
    </tr>

<?php
$host = "sql305.byetcluster.com";
$username = "if0_41690153";
$password = "Fn2zWYHUqvtE";
$dbname = "if0_41690153_hanout";

$check = mysqli_connect($host, $username, $password, $dbname);
if ($check->connect_error) {
    die("❌ Connection failed: " . $check->connect_error);
}

$sql = "SELECT ID, Produit, prix_unitaire, prix_achat, prix_vente, category, Quantite FROM produits";
$result = $check->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $row["ID"] . "</td>
            <td>" . $row["Produit"] . "</td>
            <td>" . $row["prix_unitaire"] . "</td>
            <td>" . $row["prix_achat"] . "</td>
            <td>" . $row["prix_vente"] . "</td>
            <td>" . $row["category"] . "</td>
            <td>" . $row["Quantite"] . "</td>
          </tr>";
}
} else {
    echo "<tr><td colspan='6'>No results found</td></tr>";
}

$check->close();
?>

</table>
</body>
</html>