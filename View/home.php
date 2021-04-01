<!DOCTYPE html>
<html lang="en">
<?php 
include('./Controller/C_Verif_Autorisations.php');
include 'config.php';
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
    <body class="homeBody">
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
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Account">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Compare">Compare</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Notifs"><img class ="cloche" src=<?=$URLStaticFiles.cloche(); ?>></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        <div class="recherche_p">
            <form class="form-inline my-2 my-lg-0" method='POST'>
                <div class="recherche-barr">
                    <input class="recherche-input" type="search" placeholder="Recherche" aria-label="Search" name="search">
                    <label class="recherche-icone" name="validSearch">
                        <i class="fas fa-search"></i>
                    </label>
                </div>
        <div class="filter">
            <div>
                <select name="competences" id="competences_select">
                        <option value="">--Skills--</option>
                        <?php
                            foreach($skills as $ski){
                                echo '<option value='.$ski["nom_competence"].'>'.$ski["nom_competence"].'</option>';
                            }
                        ?>
                    </select>
                    <select name="entreprise" id="entreprise_select">
                        <option value="">--Company--</option>
                        <?php
                            foreach($company as $com){
                                echo '<option value='.$com["nom_entreprise"].'>'.$com["nom_entreprise"].'</option>';
                            }
                        ?>
                    </select>
                    <select name="localite" id="localite_data">
                        <option value="">--City--</option>
                        <?php
                            foreach($campus as $cam){
                                echo '<option value='.$cam["nom_centre"].'>'.$cam["nom_centre"].'</option>';
                            }
                        ?>
                    </select>
            </div>
            <div>
                <select name="promo" id="promo_select">
                    <option value="">--Promotion--</option>
                    <option value="A1">A1</option>
                    <option value="A2">A2</option>
                    <option value="A3">A3</option>
                    <option value="A4">A4</option>
                    <option value="A5">A5</option>
                </select>
                <select name="nbrPlace" id="nbrPlace_select">
                    <option value="">--Numbers of place--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
                
                
            </form>
            </div>
        </div>
    </header>
        <div class="stock">
            <div class="stages"><!-- Affichage en scroll des offres de stage-->
            <?php
                    foreach($res as $r){
                        echo '<div class="stage"><h2 class="titre">'.$r["intitule_offre"].'</h2><i class="far fa-heart"></i><p class="description">'.$r['description'].'</p><br><h5 class="entreprise">'.$r["nom_entreprise"].'</h5><p class="idCompetence">'.AfficherCompetences($r["idoffre"]).'</p></div>';
                    }
            ?>
            </div>
            <div class="affichage"> <!-- Affichage de l'offre de stage sélectionnée au click-->
                    
            </div>
        </div>
        <script type='text/javascript' src=<?=$URLStaticFiles?>vendors/jquery/jquery-ui.min.js></script>
        <script type="text/javascript" src=<?=$URLStaticFiles?>js/script.js></script>
        <?php
            if($_SESSION['role'] == "Pilote"){
                echo "<script type='text/javascript' src=<?=$URLStaticFiles?>js/pilote.js></script>";
            }
            if($_SESSION['role'] == "Délégué"){
                echo "<script type='text/javascript' src=<?=$URLStaticFiles?>js/delegate.js></script>";
            }
        ?>
        
    </body>
</html>

