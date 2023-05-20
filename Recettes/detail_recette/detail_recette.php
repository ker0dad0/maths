<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de la recette</title>
    <link rel="stylesheet" href="style4.css">
    

    
</head>
<body>
<div class="container-recette">
    <header>
         <div class="titre">
         <a href="../index2.php" class="logo"><span>B</span>YO</a>
                        
         </div>
                    
    </header>
    <br>
    <?php
    session_start();
    // Vérifier si l'utilisateur est connecté
    if(!isset($_SESSION["email"])){
        header("Location: ../Formaulaire/connexion.php");
        exit();
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "recettes_byo";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Vérifier la connexion à la base de données
    if (!$conn) {
        die("Connexion échouée: " . mysqli_connect_error());
    }
    // Récupérer les informations de la recette sélectionnée
    if(isset($_GET["id"])) {
        $id_recette = $_GET["id"];
        $sql = "SELECT * FROM recettes WHERE id = $id_recette";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $nom_recette = $row["titre"];
            $instructions = $row["instructions"];
            $description = $row["descriptions"];
            $prix = $row["cout_estime"];
    
            // Récupérer la liste des ingrédients pour la recette
            $sql = "SELECT i.nom, ri.quantite, ri.unite, i.prix FROM recettes_ingredients ri JOIN ingredients i ON ri.ingredient_id = i.id WHERE ri.recette_id = $id_recette;";
            $result = mysqli_query($conn, $sql);
        } else {
            echo "Aucune recette trouvée";
            exit();
        }
    } else {
        echo "Aucune recette sélectionnée";
        exit();
    }
    ?>
    
    <main>

                    <div class="block-instruction">
                        <div class="info">
                           
                           <center> <p>Coût Estimé: <?php echo $prix; ?></p> 
                            <div class="descriptions">
                            <p>Description: <br><br><?php echo $description; ?></p>
                            </div>
                        </div>    
                        <div class="ingredients">
                            <button class="btn-ingredient" type="button">Ingredients</button>
                            <div class="liste-ingredient">
                                <h4>Pour une personne:</h4>
                                <ul>
                                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                                         <li><?php echo $row['quantite'] . ' ' . $row['unite'] . ' ' . $row['nom']; ?></li>
                                    <?php endwhile; ?>
                               </ul>                    
                            </div>   
                        </div>
                        <div class="instructions">
                            <h3>ETAPES<img src="../ressources/flecheBlack.svg"></h3>
                            <ul>
                                <li>Instructions:</li>
                                <li> <?php echo $instructions; ?></li><br><br>
                               <?php
                                    // Calcul de la moyenne des notes
                                    $sql = "SELECT AVG(note) as moyenne FROM commentaires WHERE recette_id = $id_recette";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $moyenne = round($row['moyenne'], 2);
                                    $sql_update = "UPDATE recettes SET moyenne = '$moyenne' WHERE id = $id_recette";
                                    $result = mysqli_query($conn, $sql_update);
                               ?>
                               <center><li>Moyenne de la recette: <?php echo $moyenne ?>/5</li></center>
                           </ul>                        
                        </div> </center>

                    </div>        
     </main>
     <center>
    <div class="commentaires">
        <h3>Commentaires</h3>
        <form action="ajouter_commentaire.php" method="post"> 
            <label for="commentaire">Commentaire:</label>
            <br>
            <textarea name="commentaire" id="commentaire" cols="30" rows="5"></textarea>
            <br>
            <div class="rating">
    <input type="radio" id="star5" name="note" value="5">
    <label for="star5">Top</label>
    <input type="radio" id="star4" name="note" value="4">
    <label for="star4">Bien</label>
    <input type="radio" id="star3" name="note" value="3">
    <label for="star3">Moyen</label>
    <input type="radio" id="star2" name="note" value="2">
    <label for="star2">Normal</label>
    <input type="radio" id="star1" name="note" value="1">
    <label for="star1">NULL</label>
</div>
            <br>
            <input type="hidden" name="id_recette" value="<?php echo $id_recette; ?>">
            <button type="submit">Poster</button>
        </form><br>
        <div class="liste-commentaires">
            <?php
            // Récupérer les commentaires pour la recette
            $sql = "SELECT c.*, u.prenom FROM commentaires c JOIN utilisateurs u ON c.utilisateur_id = u.id WHERE c.recette_id = $id_recette ORDER BY c.date_poste DESC";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) == 0) {
                echo "Aucun commentaire pour cette recette";
            } else {
                while($row = mysqli_fetch_assoc($result)) {
                    $note = $row['note'];
                    $commentaire = $row['commentaire'];
                    $date_poste = $row['date_poste'];
                    $prenom_utilisateur = $row['prenom'];
                    echo "<div class='commentaire'>
                              <p><strong>$prenom_utilisateur:</strong></p><br>
                              <p>Note: $note/5</p>
                              <p>Commentaire: $commentaire</p>
                              <p>Date de poste: $date_poste</p>
                          </div>";
                }
            }
            ?>
        </div>
    </div>
</center>
<script src="../script.js/recettes.js"></script>
<script src="../main.js"></script>

</body>
</html>