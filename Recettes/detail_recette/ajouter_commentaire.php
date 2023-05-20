<?php
    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Récupérer les données du formulaire
        $note = $_POST['note'];
        $commentaire = $_POST['commentaire'];
        $id_recette = $_POST['id_recette'];
        
        session_start();
        // Connexion à la base de données
        $conn = mysqli_connect('localhost', 'root', '', 'recettes_byo');
        
        // Vérifier la connexion
        if (!$conn) {
            die("Erreur de connexion: " . mysqli_connect_error());
        }
        
        // Récupérer l'ID de l'utilisateur connecté
        $utilisateur_id = $_SESSION['email'];
        
        // Requête SQL pour récupérer l'ID de l'utilisateur connecté
        $sql = "SELECT id FROM utilisateurs WHERE email = '$utilisateur_id'";
        
        // Exécuter la requête SQL
        $result = mysqli_query($conn, $sql);
        
        // Vérifier si la requête a renvoyé un résultat
        if(mysqli_num_rows($result) > 0) {
            
            // Récupérer l'ID de l'utilisateur connecté
            $row = mysqli_fetch_assoc($result);
            $utilisateur_id = $row['id'];
            
            // Requête SQL pour insérer le commentaire dans la table 'commentaires'
            $sql = "INSERT INTO commentaires (commentaire, note, date_poste, utilisateur_id, recette_id)  VALUES ('$commentaire', '$note', NOW(), '$utilisateur_id', '$id_recette')";
            
            // Exécuter la requête SQL
            if (mysqli_query($conn, $sql)) {
                echo "Commentaire ajouté avec succès.";
            } else {
                echo "Erreur: " . mysqli_error($conn);
            }
            
        } else {
            // La requête n'a renvoyé aucun résultat, afficher une erreur
            echo "Erreur: Impossible de récupérer l'ID de l'utilisateur connecté.";
        }

        // Fermer la connexion
        mysqli_close($conn);
    }
?>

