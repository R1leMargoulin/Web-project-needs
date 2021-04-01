<!DOCTYPE html>
<html lang="en">
<?php 
include 'config.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needs.com</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fascinate&display=swap" rel="stylesheet">
    <link rel="stylesheet" href=<?=$URLStaticFiles?>vendors/bootstrap/css/bootstrap.min.css>
    <link rel="stylesheet" href=<?=$URLStaticFiles?>css/style.css>
    <link rel="stylesheet" href=<?=$URLStaticFiles?>css/responsive.css>
    <link rel="stylesheet" href=<?=$URLStaticFiles?>css/animation.css>
    <script src="https://kit.fontawesome.com/0c87a70838.js"></script>
</head>
<body class="bodyConnexion">
    <div class="shadow"></div>
    <div class="present">
        <h1 class="titreAccueil">Needs.com</h1>
        <h2 class="slogan">Le site N°1 de recherche de stages</h2>
        <div class="compte">
            <button type="button" class="btn btn-outline-light btn-lg btnConnexion">Connexion</button>
            <form class="formConnexion" method="post" action='./InConnection'>
                <i class="fas fa-arrow-left"></i>
                <fieldset>
                    <legend>Connexion</legend>
                    <input type="text" id="login" name="login" placeholder="Identifiant" required autocomplete="off"><br>
                    <input type="password" id="password" name="password" placeholder="Mot de passe" required autocomplete="off"><br>
                    <button type="submit" class="btn btn-outline-light btn-lg btnConnexionF" name="connectLogin" >Connexion</button>
                </fieldset>
            </form><br>
        </div>
    </div>
    <script type='text/javascript' src=<?=$URLStaticFiles?>vendors/jquery/jquery-ui.min.js></script>
    <script type="text/javascript" src=<?=$URLStaticFiles?>js/script.js ></script>
</body>
</html>