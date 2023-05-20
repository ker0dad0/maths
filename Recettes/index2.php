<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yob</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <header>
        <a href="#" class="logo"><span>B</span>YO</a>
        <div class="menuToggle"></div>
        
        <?php
        session_start();

        // Vérifier si l'utilisateur est connecté
        if(!isset($_SESSION["email"])){
            header("Location: Formulaire/connexion.php");
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
                    <li><a href="index2.php">Accueil</a></li>
                    <li><a href="ajouter_recettes/ajouter_recettes.php">Ajouter recettes</a></li>
                    <li><a href="recettes_préférées/recettes_preferes.php">Recettes préférées</a></li>
                    <li><a href="notifications/notifications.php">Notifications</a></li>
                </ul>
                <a href="Formulaire/deconnexion.php" class="btn-reserve">déconnexion</a>
            </div>
        </div><br><br>
        <div class="container-search">
            <input id="search-input" type="text" placeholder="Rechercher">
            <div class="search">
                <img src="ressources/logo-search.svg">
            </div>
        </div>
    </header>

    
    
        <!-- Code HTML -->
        <br><br><br><br>
<div class="container-recettes">
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

    // Récupérer les recettes de la base de données
    $sql = "SELECT * FROM recettes";
    $result = mysqli_query($conn, $sql);
    // Afficher chaque recette sous forme de carré
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<a href="detail_recette/detail_recette.php?id=' . $row['id'] . '">';
            echo '<div class="block-recette">';
            echo '<form method="post" action="recettes_préférées/recettes_favoris.php">';
            echo '<input type="hidden" name="recette_id" value="' . $row['id'] . '">';
            echo '<input type="submit" value="Sauvegarder">';
            echo '</form>';
            echo '<span class="overlay">' . $row['titre'] . '</span>';
            echo '<img src="ressources/logofood.png">';
            echo '</div>';
            
            echo '</a>';
            
        }
    } else {
        echo "Aucune recette trouvée";
    }

    mysqli_close($conn);
    ?>
</div>


            <script src="main.js"></script>
        </body>
    </html>