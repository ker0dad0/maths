<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BYO</title>
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
            header("Location: ../Formaulaire/connexion.php");
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
                    <li><a href="../ajouter_recettes/ajouter_recettes.php">Ajouter recettes</a></li>
                    <li><a href="../recettes_préférées/recettes_preferes.php">Recettes préférées</a></li>
                    <li><a href="notifications.php">Notifications</a></li>
                </ul>
                <a href="../Formulaire/deconnexion.php" class="btn-reserve">déconnexion</a>
            </div>
        </div>
    </header><br><br><br><br><br><br><br>
<center>
<div class="notifications">
  <h2>Notifications</h2>
  <br>
  <ul>
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

      // Récupérer les notifications de l'utilisateur connecté
$email = $_SESSION["email"];
$sql = "SELECT id FROM utilisateurs WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$id_utilisateur = $row["id"];

$sql = "SELECT * FROM etat_ajout WHERE id_utilisateur='$id_utilisateur'";
$result = mysqli_query($conn, $sql);



      if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            $titre = $row["titre"];
            $etat = $row["etat"];
            echo "<p>---------------------------------</p>";
            echo "<li class=\"$etat\">etat:La recette \"$titre\"  est actuellement  \"$etat\"</li>";
          }
      } else {
          echo "<li>Pas de notifications</li>";
      }

      mysqli_close($conn);
    ?>
  </ul>
</div>

<center>

    </body>
    </html>

