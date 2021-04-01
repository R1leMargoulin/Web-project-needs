<!DOCTYPE html>
<html lang="en">
<?php 
include('./Controller/C_Verif_Autorisations.php');
include './config.php';
sfx8VerifHome();
?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Needs, le site numéro 1 des recherches de stage">
        <title>Home</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Fascinate&display=swap" rel="stylesheet">
        <link rel="stylesheet" href=<?=$URLStaticFiles?>vendors/bootstrap/css/bootstrap.min.css>
        <link rel="stylesheet" href=<?=$URLStaticFiles?>css/style.css>
        <link rel="stylesheet" href=<?=$URLStaticFiles?>css/responsive.css>
        <link rel="stylesheet" href=<?=$URLStaticFiles?>css/animation.css>
        <script src="https://kit.fontawesome.com/0c87a70838.js"></script>
    </head>
    <body>
    <header>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img class ="logo"src=<?=$URLStaticFiles?>images/logo.png></a>
            <div class ="d-md-none mobile" data-toggle="collapse" data-target="#navbarResponsive">
                <div class = 'bg-dark line1' data-toggle="collapse" data-target="#navbarResponsive"></div>
                <div class = 'bg-dark line2' data-toggle="collapse" data-target="#navbarResponsive"></div>
                <div class = 'bg-dark line3' data-toggle="collapse" data-target="#navbarResponsive"></div>
            </div>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Account">Account</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="Compare">Compare</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Notifs"><img class ="cloche" src=<?=$URLStaticFiles.cloche(); ?>></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </header>
    <div class="containCompare">
        <div class="compareItem">
            <h2 class="Nstage">Offre de stage N°1</h2>
                <div class="compareScroll">
            <?php
                foreach($Offres as $o){
                    echo '<div class="Offre"><h2 class="titre">'.$o["intitule_offre"].'</h2><p class="description">'.$o['description'].'</p><br><h5 class="entreprise">'.$o["nom_entreprise"].'</h5><p class="idCompetence">'.AfficherCompetences($o["idoffre"]).'</p></div>';
                }
            ?>
                </div>
        </div>
        <div class="compareItem">
            <h2 class="Nstage">Offre de stage N°2</h2>
                <div class="compareScroll">
            <?php
                foreach($Offres as $o){
                    echo '<div class="Offre"><h2 class="titre">'.$o["intitule_offre"].'</h2><p class="description">'.$o['description'].'</p><br><h5 class="entreprise">'.$o["nom_entreprise"].'</h5><p class="idCompetence">'.AfficherCompetences($o["idoffre"]).'</p></div>';
                }
            ?>
                </div>
        </div>
    </div>
    <script type='text/javascript' src=<?=$URLStaticFiles?>vendors/jquery/jquery-ui.min.js></script>
    <script type="text/javascript" src=<?=$URLStaticFiles?>js/script.js></script>
    </body>
