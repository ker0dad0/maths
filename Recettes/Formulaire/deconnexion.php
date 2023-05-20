<?php
session_start();
session_destroy(); // détruit toutes les données de session

header("Location: ../index.html"); // redirige l'utilisateur vers la page de connexion
exit();
?>
