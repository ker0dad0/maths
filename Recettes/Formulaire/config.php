<?php
session_start();
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recettes_byo";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$conn) {
    die("La connexion à la base de données a échoué: " . mysqli_connect_error());
}

// Traitement du formulaire de connexion
if (isset($_POST['Valider'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // Requête pour récupérer l'utilisateur correspondant à l'email et au mot de passe saisis
    $requete = "SELECT * FROM utilisateurs WHERE email='$email' AND mot_de_passe='$mdp'";
    $resultat = mysqli_query($conn, $requete);
    // Vérifier si l'utilisateur existe
    if (mysqli_num_rows($resultat) == 1) {
        // L'utilisateur existe, on le connecte en créant une session
        $_SESSION['email'] = $email;
        header('Location: ../index2.php'); // Redirection vers la page d'accueil après connexion
        exit();
    } else {
        // L'utilisateur n'existe pas ou les identifiants sont incorrects
        $message = "email ou mot de passe incorrects";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

// Traitement du formulaire de création de compte
if (isset($_POST['Valider1'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $mdp_confirme = $_POST['mdp_confirme'];

    // Vérifier que le mot de passe est bien confirmé
    if ($mdp != $mdp_confirme) {
        $message = "Les mots de passe ne correspondent pas";
        echo "<script type='text/javascript'>alert('$message');</script>";
        exit();
    }

    // Vérifier que l'email n'existe pas déjà dans la base de données
    $requete = "SELECT * FROM utilisateurs WHERE email='$email'";
    $resultat = mysqli_query($conn, $requete);
    if (mysqli_num_rows($resultat) > 0) {
        $message = "Cette adresse e-mail est déjà utilisée";
        echo "<script type='text/javascript'>alert('$message');</script>";
        exit();
    }

    // Insérer l'utilisateur dans la base de données
    $requete = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES ('$nom', '$prenom', '$email', '$mdp')";
    $resultat = mysqli_query($conn, $requete);

    if ($resultat) {
        // L'utilisateur a été créé avec succès
        $message = "Votre compte a été créé avec succès";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header('Location: connexion.php'); // Redirection vers la page de connexion après création de compte
        exit();
    } else {
        // Erreur lors de la création de l'utilisateur
        $message = "Une erreur s'est produite, veuillez réessayer";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}


?>