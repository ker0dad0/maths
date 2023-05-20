<?php
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION["email"])){
    header("Location: ../Formaulaire/connexion.php");
    exit();
}

// Récupérer l'ID de la recette depuis le formulaire
if(isset($_POST['recette_id'])) {
    $recette_id = $_POST['recette_id'];

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

    // Récupérer l'ID de l'utilisateur connecté
    $email = $_SESSION["email"];
    $sql = "SELECT id FROM utilisateurs WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $utilisateur_id = $row["id"];
    } else {
        die("Utilisateur inconnu");
    }

    // Ajouter la recette aux recettes préférées de l'utilisateur
    $sql = "INSERT INTO recettes_favoris (utilisateur_id, recette_id) VALUES ($utilisateur_id, $recette_id)";
    if (mysqli_query($conn, $sql)) {
        header('Location: ../index2.php' );
        
    } else {
        $sql = "DELETE FROM recettes_favoris WHERE recette_id = '$recette_id'";
        $result = mysqli_query($conn, $sql);
        header('Location: ../index2.php');
    }

    mysqli_close($conn);
} else {
    die("ID de recette manquant");
}
?>

