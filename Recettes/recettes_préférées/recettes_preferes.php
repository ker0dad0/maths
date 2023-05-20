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
            <a href="../index2.php" class="logo"><span>B</span>YO</a>
        <div class="menuToggle"></div>
        
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
        $sql = "SELECT * FROM utilisateurs WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $nom_utilisateur = $row["prenom"];
            $id1 = $row["id"];
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
                    <li><a href="../ajouter_recettes/ajouter_recettes.php">Ajouter recettes</a></li>
                    <li><a href="../recettes_préférées/recettes_preferes.php">Recettes préférées</a></li>
                    <li><a href="../notifications/notifications.php">Notifications</a></li>
                </ul>
                <a href="../Formulaire/deconnexion.php" class="btn-reserve">déconnexion</a>
            </div>
        </div>
            </header>
            <br><br>
        <!-- Code HTML -->
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
    $sql = "SELECT * FROM recettes r JOIN recettes_favoris rf ON r.id = rf.recette_id WHERE rf.utilisateur_id = '$id1'";

    $result = mysqli_query($conn, $sql);
    // Afficher chaque recette sous forme de carré
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<a href="../detail_recette/detail_recette.php?id=' . $row['id'] . '">';
            echo '<div class="block-recette">';
            echo '<span class="overlay">' . $row['titre'] . '</span>';
            echo '<img src="../ressources/logofood.png">';
            echo '</div>';
            echo '</a>';
        }
    }
    else {
        echo "Aucune recette trouvée";
    }

    mysqli_close($conn);
    ?>
</div>


            <script src="../main.js"></script>
        </body>
    </html>