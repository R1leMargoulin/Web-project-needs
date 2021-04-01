<!DOCTYPE html>
<html lang="en">
<?php 
include('./Controller/C_Verif_Autorisations.php');
include 'config.php';
noStudent();
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
            <form class="formInscription" method="POST" action="Saving">
                <i class="fas fa-arrow-left btnBack"></i>
                <fieldset>
                    <legend>Register</legend>
                    <section class='pageInscription'>
                        <div>
                            <label for='permission' class="labelPermission">Choose the permission</label><br>
                            <select id='permission' name='role'>
                                <option value='student' class='optionStudent'>student</option>
                                <option value='delegate' class='optionDelegate'>delegate</option>
                                <option value='tutor' class='optionPilote'>tutor</option>
                                <option value='admin' class='optionAdmin'>admin</option>
                            </select><br>
                            <input type="text" placeholder='First name' class='textBox' name='Fname'><br>
                            <input type="text" placeholder='Last name' class='textBox' name='Lname'><br>
                            <input type="date" placeholder='Birthdate' class='textBox' name='birthdate'><br>
                            <input type="text" placeholder='city' class='textBox' name='city'><br>
                            <input type="Email" placeholder='Email' class='textBox' name='mail'><br>
                            <input type="password" placeholder='Password' class='textBox' name='password'><br>
                            <select id='centres' name='campus'>
                                <option value="1">Rouen</option>
                                <option value="2">Nanterre</option>
                                <option value="3">Arras</option>
                                <option value="4">Caen</option>
                                <option value="5">Bordeaux</option>
                                <option value="6">Lyon</option>
                                <option value="7">Toulouse</option>
                                <option value="8">Orléans</option>
                                <option value="9">Lille</option>
                                <option value="10">Brest</option>
                                <option value="11">Saint-Nazaire</option>
                                <option value="12">Le Mans</option>
                                <option value="13">Reims</option>
                                <option value="14">Nancy</option>
                                <option value="15">Strasbourg</option>
                                <option value="16">Dijon</option>
                                <option value="17">Grenoble</option>
                                <option value="18">Nice</option>
                                <option value="19">Aix-en-Provence</option>
                                <option value="20">Montpelier</option>
                                <option value="21">Pau</option>
                                <option value="22">Angoulême</option>
                                <option value="23">La Rochelle</option>
                                <option value="24">Châteauroux</option>
                                <option value="25">Nantes</option>
                            </select>
                            <label></label>
                            <select id='promotion' name='promotion'>
                                <option value="1">A1</option>
                                <option value="2">A2</option>
                                <option value="3">A3</option>
                                <option value="4">A4</option>
                                <option value="5">A5</option>
                            </select></br></br>
                        </div>
                        <div class="block">
                            <h3>Delegate permission :</h3>
                            <hr>
                            <div class="checkbox listing">
                                <div class="labin">
                                    <label>SFx2 - Rechercher une entreprise</label>
                                    <input type="checkbox" name="SFx2">
                                </div>
                                <div class="labin">
                                    <label>SFx3 - Créer un entreprise</label>
                                    <input type="checkbox" name="SFx3">
                                </div>
                                <div class="labin">
                                    <label>SFx4 - Modifier une entreprise</label>
                                    <input type="checkbox" name="SFx4">
                                </div>
                                <div class="labin">
                                    <label>SFx5 - Evaluer une entreprise</label>
                                    <input type="checkbox" name="SFx5">
                                </div>
                                <div class="labin">
                                    <label>SFx6 - Supprimer une entreprise</label>
                                    <input type="checkbox" name="SFx6">
                                </div>
                                <div class="labin">
                                    <label>SFx7 - Consulter les stats des entreprises</label>
                                    <input type="checkbox" name="SFx7">
                                </div>
                                <div class="labin">
                                    <label>SFx8 - Rechercher une offre</label>
                                    <input type="checkbox" name="SFx8">
                                </div>
                                <div class="labin">
                                    <label>SFx9 - Créer une offre</label>
                                    <input type="checkbox" name="SFx9">
                                </div>
                                <div class="labin">
                                    <label>SFx10 - Modifier une offre</label>
                                    <input type="checkbox" name="SFx10">
                                </div>
                                <div class="labin">
                                    <label>SFx11 - Supprimer une offre</label>
                                    <input type="checkbox" name="SFx11">
                                </div>
                                <div class="labin">
                                    <label>SFx12 - Consulter les stats des offres</label>
                                    <input type="checkbox" name="SFx12">
                                </div>
                                <div class="labin">
                                    <label>SFx13 - Rechercher un compte pilote</label>
                                    <input type="checkbox" name="SFx13">
                                </div>
                                <div class="labin">
                                    <label>SFx14 - Créer un compte pilote</label>
                                    <input type="checkbox" name="SFx14">
                                </div>
                                <div class="labin">
                                    <label>SFx15 - Modifier un compte pilote</label>
                                    <input type="checkbox" name="SFx15">
                                </div>
                                <div class="labin">
                                    <label>SFx16 - Supprimer un compte pilote</label>
                                    <input type="checkbox" name="SFx16">
                                </div>
                                <div class="labin">
                                    <label>SFx17 - Rechercher un compte délégué</label>
                                    <input type="checkbox" name="SFx17">
                                </div>
                                <div class="labin">
                                    <label>SFx18 - Créer un compte délégué</label>
                                    <input type="checkbox" name="SFx18">
                                </div>
                                <div class="labin">
                                    <label>SFx19 - Modifier un compte délégué</label>
                                    <input type="checkbox" name="SFx19">
                                </div>
                                <div class="labin">
                                    <label>SFx20 - Supprimer un compte délégué</label>
                                    <input type="checkbox" name="SFx20">
                                </div>
                                <div class="labin">
                                    <label>SFx22 - Rechercher un compte étudiant</label>
                                    <input type="checkbox" name="SFx22">
                                </div>
                                <div class="labin">
                                    <label>SFx23 - Créer un compte étudiant</label>
                                    <input type="checkbox" name="SFx23">
                                </div>
                                <div class="labin">
                                    <label>SFx24 - Modifier un compte étudiant</label>
                                    <input type="checkbox" name="SFx24">
                                </div>
                                <div class="labin">
                                    <label>SFx25 - Supprimer un compte étudiant</label>
                                    <input type="checkbox" name="SFx25">
                                </div>
                                <div class="labin">
                                    <label>SFx26 - Consulter les stats des étudiants</label>
                                    <input type="checkbox" name="SFx26">
                                </div>
                                <div class="labin">
                                    <label>SFx32 - Informer de l'avancement de la candidature step 3</label>
                                    <input type="checkbox" name="SFx32">
                                </div>
                                <div class="labin">
                                    <label>SFx33 - Informer de l'avancement de la candidature step 4</label>
                                    <input type="checkbox" name="SFx33">
                                </div>                                
                            </div>
                        </div>
                    </section>

                    <button type="submit" name="submit" class="btn btn-outline-light btn-lg btnInscription">Register</button>
                </fieldset>
            </form><br>
            
        </div>
    </div>
    <script type='text/javascript' src=<?=$URLStaticFiles?>vendors/jquery/jquery-ui.min.js></script>
    <script type="text/javascript" src=<?=$URLStaticFiles?>js/script.js ></script>
    <?php
        if($_SESSION['role'] == "Pilote"){
            echo "<script type='text/javascript' src= ".$URLStaticFiles."js/pilote.js></script>";
        }
        elseif($_SESSION['role'] == "Délégué"){
            for($i=1;$i<36;$i++){
                if(in_array("sfx".$i,$_SESSION['tableAutorisation'])){
                      //il a le droit $i
                }
                else{
                      echo "<script type='module'>    
                            $.ajax({
                                  url: '".$URLStaticFiles."js/delegate.js',
                                  type: 'POST',
                                  dataType: 'script',
                            })
                            .done(function(script) {
                                  console.log(script);
                                  sfx".$i."();
                            })
                      </script>";
                }
          }
        }
    ?>
</body>
</html>