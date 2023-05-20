<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de la recette</title>
    <link rel="stylesheet" href="stylee1.css">
    

    
</head>
<body>
<div class="container-recette">
<header>
         <div class="titre">
         <a class="logo"><span>B</span>YO</a>
                        
         </div>
                    
    </header>
    <br>
    <?php
   

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
        $sql = "SELECT * FROM recettes_interm WHERE id = $id_recette";
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

<script src="../script.js/recettes.js"></script>
<script src="../main.js"></script>

</body>
</html>