<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yob</title>
    <link rel="stylesheet" href="styleadm1.css">
</head>
<body>
    <header>
        <a href="#" class="logo"><span>B</span>YO</a>
        <div class="menuToggle"></div>
        
    </header>
    <br><br><br><br><br>
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
        $sql = "SELECT * FROM recettes_interm";
        $result = mysqli_query($conn, $sql);
        // Afficher chaque recette sous forme de carré
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '<a href="detail_recette1.php?id=' . $row['id'] . '">';
                echo '<div class="block-recette">';
                echo '<span class="overlay">' . $row['titre'] . '</span>';
                echo '<form method="post" action="ordre.php">';
                echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                echo '<div class="actions">';
                echo '<button type="submit" name="action1" value="accepter" class="btn-accepter">Accepter</button>';
                echo '<button type="submit" name="action2" value="refuser" class="btn-refuser">Refuser</button>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
                echo '</a>';
            }
        } else {
            echo " Pas de nouvelles recettes proposées ";
        }

        mysqli_close($conn);
        ?>
    </div>

    <script src="../main.js"></script>
</body>
</html>

