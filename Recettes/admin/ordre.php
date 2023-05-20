<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recettes_byo";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion à la base de données
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}




// Si l'administrateur a cliqué sur "Accepter"
if (isset($_POST['action1'])) {
    // Récupérer l'id de la recette à insérer
    $id_recette = $_POST['id'];
    
    // Insérer la recette dans la table "recettes"
    $sql_insert = "INSERT INTO recettes SELECT * FROM recettes_interm WHERE id = $id_recette";
    mysqli_query($conn, $sql_insert);
    
    // Supprimer la recette de la table "recettes_interm"
    $sql_delete = "DELETE FROM recettes_interm WHERE id = $id_recette";
    mysqli_query($conn, $sql_delete);


   // mise à jour l'état de la recette à ajouter
   $resultat = mysqli_query($conn, "SELECT MAX(id) FROM etat_ajout");
   $row = mysqli_fetch_array($resultat);
   $id = $row[0];
   $sql = "UPDATE etat_ajout SET etat = 'Acceptée' WHERE id = $id";
   mysqli_query($conn, $sql);
    
}

// Si l'administrateur a cliqué sur "Refuser"
if (isset($_POST['action2'])) {
    // Récupérer l'id de la recette à supprimer
    $id_recette = $_POST['id'];
    
    // Supprimer la recette de la table "recettes_interm"
    $sql_delete = "DELETE FROM recettes_interm WHERE id = $id_recette";
    mysqli_query($conn, $sql_delete);

    
  // mise à jour l'état de la recette à ajouter
  $resultat = mysqli_query($conn, "SELECT MAX(id) FROM etat_ajout");
  $row = mysqli_fetch_array($resultat);
  $id = $row[0];
  $sql = "UPDATE etat_ajout SET etat = 'Refusée' WHERE id = $id";
  mysqli_query($conn, $sql);
    
}

header('Location: admin.php');

?>