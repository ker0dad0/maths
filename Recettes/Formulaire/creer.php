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
<div>
                <header>
                    <div class="titre">
                        <h1>BYO</h1>
                        
                    </div>
                    
                </header>
    <section>
        <h1> Création du compte</h1>
        <form action="config.php" method="POST">
            <label for="nom">Nom</label>
            <input type="text" name="nom" required="required">
            <label for="prenom">Prenom</label>
            <input type="text" name="prenom" required="required">
            <label for="email">Adresse e-mail</label>
            <input type="text" name="email" required="required">
            <label for="password">Mot de passe</label>
            <input type="password" name="mdp" required="required">
            <label for="password">Confirmer le Mot de passe</label>
            <input type="password" name="mdp_confirme" required="required">
            <input type="submit" name="Valider1">
            <a href="connexion.php">Retour à la page de connexion</a>
            
    </section>
    
</body>
</html>