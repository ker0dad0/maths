<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Yob</title>
            <link rel="stylesheet" href="style2.css">
            
            
            
            
        </head>
        <body>
            <header>
                <a href="../index2.php" class="logo"><span>B</span>YO</a>
                <div class="menuToggle"></div>
                
                
                
            
            <br>
            <br>
            <br>
            <br>
            <?php
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION["email"])){
    header("Location: ../Formulaire/connexion.php");
    exit();
}

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

// Récupérer les informations de l'utilisateur connecté
$email = $_SESSION["email"];
$sql = "SELECT prenom FROM utilisateurs WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nom_utilisateur = $row["prenom"];
} else {
    $nom_utilisateur = "Utilisateur inconnu";
}

mysqli_close($conn);
                    ?>


                    
<div class="profile">
            <div class="profile-button"><?php echo $nom_utilisateur; ?> <i class="fa fa-angle-down"></i></div>
            <div class="profile-dropdown">
                <ul>
                    <li><a href="../index2.php">Accueil</a></li>
                    <li><a href="ajouter_recettes.php">Ajouter recettes</a></li>
                    <li><a href="../recettes_préférées/recettes_preferes.php">Recettes préférées</a></li>
                    <li><a href="../notifications/notifications.php">Notifications</a></li>
                </ul>
                <a href="../Formulaire/deconnexion.php" class="btn-reserve">déconnexion</a>
            </div>
        </div>
                </header>
                <br><br><br><br>
            <section>
        <h1>Proposer une recette:</h1><br>
        <form action="insert_recette.php" method="POST">

             <label for="titre">Titre</label>
             <input type="text" name="titre"><br>
             <label for="description">Description:</label>
             <textarea name="description" placeholder="description" class="idd"></textarea><br>
             <label for="instr">Instructions:</label>
             <textarea name="instructions" placeholder="instructions"></textarea><br>
           <!--  <label for="prix">Prix:</label>
             <input type="number" name="prix"> -->
             <label for="ingredients">Ingrédients:</label>
             <div id="ingredients_container">
               <div class="ingredient">
                  <input type="text" name="ingredients[]" placeholder="ingrédient">
                 <input type="number" name="prix_ingredients[]" placeholder="prix">
                 <input type="number" name="quantite[]" placeholder="quantité">
                 <select id="unite" name="unite[]">
                   <option value=""></option>
                   <option value="Kg">Kg</option>
                   <option value="g">g</option>
                   <option value="L">L</option>
                   <option value="mL">mL</option>
                 </select>

               </div>
             </div>
             <br>
             <button type="button" id="ajouter_ingredient">Ajouter ingrédient</button><br>
             <input type="submit" name="Valider" value="Envoyer">
             <a href="../index2.php">Retour à la page d'accueil</a>
        </form>
    
        <script>
    var ingredients_container = document.getElementById('ingredients_container');
    var ajouter_ingredient = document.getElementById('ajouter_ingredient');

    ajouter_ingredient.addEventListener('click', function() {
        var ingredient = document.createElement('div');
        ingredient.classList.add('ingredient');
        ingredient.innerHTML = '<input type="text" name="ingredients[]" placeholder="ingrédient"><input type="number" name="prix_ingredients[]" placeholder="prix"><input type="number" name="quantite[]" placeholder="quantité"><select id="unite" name="unite[]"><option value=""></option><option value="Kg">Kg<option value="g">g<option value="L">L<option value="mL">mL';
        ingredients_container.appendChild(ingredient);
    });
</script>


	</section>

            <script src="../main.js"></script>
        </body>
    </html>




