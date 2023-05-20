<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de connexion</title>
    <link rel="stylesheet" href="style1.css">
    
</head>
<body>
<div class="container-recette">
                <header>
                    <div class="titre">
                        <h1>BYO</h1>
                    </div>
                    
                </header>
    <section>
        <h1> Connexion</h1>
        <br>
        <form action="config.php" method="POST">
            <label for="email">Adresse e-mail</label>
            <input type="text" name="email"  required="required"><br>
            <label for="password">Mot de passe</label>
            <input type="password" name="mdp"  required="required"><br>
            <input type="submit" name="Valider" value="Se connecter">
            <a href="creer.php">Créer un nouveau compte</a>
    </section>
    
</body>
</html>