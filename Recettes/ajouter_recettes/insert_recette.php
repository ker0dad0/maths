<?php
session_start();
// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION["email"])){
  header("Location: ../Formulaire/connexion.php");
  exit();
}
// Vérifier si le formulaire a été soumis
if(isset($_POST['Valider'])){

    // Récupérer les données soumises par l'utilisateur
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $instructions = $_POST['instructions'];
    $cout_estime = 0;
    $moyenne = 0;
  
    // Connexion à la base de données
    $connexion = new PDO('mysql:host=localhost;dbname=recettes_byo', 'root', '');
  // Récupérer les informations de l'utilisateur connecté
  $email = $_SESSION["email"];
  $requete = $connexion->prepare("SELECT id FROM utilisateurs WHERE email=?");
  $requete->execute(array($email));
  $resultat = $requete->fetch();
  $id_utilisateur = $resultat['id'];
 


  $etat = "en cours de validation";
  


   // Ajouter la recette à la table "recettes"
   $requete = $connexion->prepare("INSERT INTO etat_ajout (id_utilisateur, titre, descriptions, instructions, cout_estime, etat) VALUES ('$id_utilisateur', '$titre', '$description', '$instructions', '$cout_estime', '$etat')");
   $requete->execute(array($id_utilisateur, $titre, $description, $instructions, $cout_estime, $etat));

  

   $requete = $connexion->prepare("INSERT INTO recettes_interm (id_utilisateur, titre, descriptions, instructions, cout_estime, moyenne) VALUES ('$id_utilisateur', '$titre', '$description', '$instructions', '$cout_estime', '$moyenne')");
   $requete->execute(array($titre, $description, $instructions, $cout_estime));

   //$requete = $connexion->prepare("INSERT INTO recettes (titre, descriptions, instructions, cout_estime) VALUES ('$titre', '$description', '$instructions', '$cout_estime')");
   //$requete->execute(array($titre, $description, $instructions, $cout_estime));
    // Récupérer l'identifiant de la recette nouvellement insérée
    $recette_id = $connexion->lastInsertId();
  
    // Parcourir tous les ingrédients soumis par l'utilisateur et les ajouter à la table "ingredients"
    for($i=0; $i<count($_POST['ingredients']); $i++){
      $ingredient = $_POST['ingredients'][$i];
      $prix_ingredient = $_POST['prix_ingredients'][$i];
      $quantite = $_POST['quantite'][$i];
      $unite = $_POST['unite'][$i];
      $cout_estime += $prix_ingredient;
      // Ajouter l'ingrédient à la table "ingredients"
      $requete = $connexion->prepare("INSERT INTO ingredients (nom, prix) VALUES ('$ingredient', '$prix_ingredient')");
      $requete->execute(array($ingredient, $prix_ingredient));
  
      // Récupérer l'identifiant de l'ingrédient nouvellement inséré
      $ingredient_id = $connexion->lastInsertId();
     
  
      // Ajouter l'association entre la recette et l'ingrédient à la table "recettes_ingredients"
      $requete = $connexion->prepare('INSERT INTO recettes_ingredients (recette_id, ingredient_id, quantite, unite) VALUES (?, ?, ?, ?)');
      $requete->execute(array($recette_id, $ingredient_id, $quantite, $unite));
    }
    //update cout estime
    $requete = $connexion->prepare("UPDATE recettes_interm SET cout_estime = '$cout_estime' ORDER BY id DESC LIMIT 1;");
    $requete->execute(array($titre, $description, $instructions, $cout_estime));

    $requete = $connexion->prepare("UPDATE etat_ajout SET cout_estime = '$cout_estime' ORDER BY id DESC LIMIT 1;");
    $requete->execute(array($id_utilisateur, $titre, $description, $instructions, $cout_estime));



   //$requete = $connexion->prepare("UPDATE recettes SET cout_estime = '$cout_estime' ORDER BY id DESC LIMIT 1;");
   //$requete->execute(array($titre, $description, $instructions, $cout_estime));

    // Rediriger l'utilisateur vers la page d'accueil
    header('Location: ../index2.php');
    exit();
  }


?>
