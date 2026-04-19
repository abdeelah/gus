<?php
$host = "sql305.byetcluster.com";
$username = "if0_41690153";
$password = "Fn2zWYHUqvtE";
$dbname = "if0_41690153_hanout";

if (isset($_POST['push'])) {
    
    // ===== connexion =====
    $check = mysqli_connect($host, $username, $password, $dbname);
    if ($check->connect_error) {
        die("❌ Connection failed: " . $check->connect_error);
    }

    // ===== كياخد les valeurs =====
    $Produit       = $_POST['Produit'];
    $prix_unitaire = $_POST['prix_unitaire'];
    $prix_achat    = $_POST['prix_achat'];
    $prix_vente    = $_POST['prix_vente'];
    $category      = $_POST['category'];
    $quantite      = $_POST['quantite'];

    // ===== INSERT =====
    $sql = "INSERT INTO produits (Produit, prix_unitaire, prix_achat, prix_vente, category, Quantite) 
            VALUES ('$Produit', '$prix_unitaire', '$prix_achat', '$prix_vente', '$category', '$quantite')";

    if ($check->query($sql) === TRUE) {
        echo "✅ Produit ajouté avec succès!";
    } else {
        echo "❌ Erreur: " . $check->error;
    }

    $check->close();
}
?>