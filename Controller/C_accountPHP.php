<?php 
      include_once './Controller/C_database.php';
      include './Model/M_account.php';
      include 'config.php';
      session_start();
      $mode;

      if(isset($_POST['infogenerales'])){
            $mode="infogenerales";
      }
      elseif(isset($_POST['modifProfil'])){
            $mode="modifProfil";
      }
      elseif(isset($_POST['wishlist'])){
            $mode="wishlist";
      }
      elseif(isset($_POST['allPilote'])){
            $mode = "allPilote";
      }
      elseif(isset($_POST['allDelegate'])){
            $mode = "allDelegate";
      }
      elseif(isset($_POST['allStudent'])){
            $mode = "allStudent";
      }
      elseif(isset($_POST['Note_Entreprise'])){
            $mode= "rate";
      }
      elseif(isset($_POST['CreateAccount'])){
            header('Location: Register');
            exit;
      }
      elseif(isset($_POST['CreateCompany'])){
            $mode="CreateCompany";
      }
      elseif(isset($_POST['CreateInternship'])){
            header('Location: NewInternShip');
      }
      elseif(isset($_POST['Postulate'])){
            $mode="postulate";
      }
      else{
            $mode="infogenerales";
      }

      if(isset($_POST['deconnexion'])){
            session_destroy();
            header('Location: ./');
            exit;
      }

      if(isset($_POST['modifProfilValided'])){
            global $db;
            $requestModifProfil = $db->prepare('UPDATE utilisateurs SET nom = :nom, prenom = :prenom, age = :age, adresse = :adresse WHERE idutilisateur = :iduser');
            $requestModifProfil->execute(array('nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'age' => $_POST['age'], 'adresse' => $_POST['adresse'], 'iduser' => $_SESSION['id'] ));

            $requestUpdatSession = $db->prepare('SELECT idutilisateur,idrole,mail,mdp,nom,prenom,age,adresse,visible FROM utilisateurs WHERE idutilisateur = :iduser');
            $requestUpdatSession->execute(array('iduser' => $_SESSION['id']));
            $NEWinfoUser = $requestUpdatSession->fetch();

            $_SESSION['nom'] = $NEWinfoUser['nom'];
            $_SESSION['prenom'] = $NEWinfoUser['prenom'];
            $_SESSION['age'] = $NEWinfoUser['age'];
            $_SESSION['adresse'] = $NEWinfoUser['adresse'];

            header('Location: ./Account');
            exit();
      }
      //idutilisateur,idrole,mail,mdp,nom,prenom,age,adresse,visible

      switch($_SESSION['role']){
            case "Administrateur":
                  global $db;
                  $admin = new AccountAdmin(1);
                  $showPilote = $admin->afficher(2);
                  $showStudent = $admin->afficher(3);
                  $delegate = new AccountDelegate();
                  $showDelegate = $delegate->afficherDelegate();
                  break;
                  
            case "Pilote":
                  echo "<script type='text/javascript' src='".$URLStaticFiles."vendors/jquery/jquery-ui.min.js'></script>";
                  echo "<script type='text/javascript' src='".$URLStaticFiles."js/pilote.js'></script>";
                  $pilote = new AccountPilote(2);
                  $showStudent = $pilote->afficher(3);
                  $delegate = new AccountDelegate();
                  $showDelegate = $delegate->afficherDelegate();

                  break;
            case "Etudiant":
                  echo "<script type='text/javascript' src='".$URLStaticFiles."vendors/jquery/jquery-ui.min.js'></script>";
                  echo "<script type='text/javascript' src='".$URLStaticFiles."js/student.js'></script>";
                  break;
            case "Délégué":
                  if(1==1){
                        header('Access-Control-Allow-Origin: https://needs.com');
                        //exit;
                  }
                  global $db;
                  $admin = new AccountAdmin(1);
                  $showPilote = $admin->afficher(2);
                  $showStudent = $admin->afficher(3);
                  $delegate = new AccountDelegate();
                  $showDelegate = $delegate->afficherDelegate();
                  echo "<script type='text/javascript' src='".$URLStaticFiles."vendors/jquery/jquery-ui.min.js'></script>";
                  echo "<script type='text/javascript' src='".$URLStaticFiles."js/delegate.js'></script>";
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
                  break;
                              
      }
      //notation entreprise:
      if(isset($_POST['envoiNote'])){
            $note = $_POST['stars'];
            $com = $_POST['commentaire'];
            $identreprise = $_POST['identreprise'];
            switch($_SESSION['role']){
                  case "Administrateur":
                        $user = new AccountAdmin($_SESSION['idRole']);
                        $user->noterEntreprise($_SESSION['id'], $note, $com, $identreprise);
                        break;
                  case "Pilote":
                        $user = new AccountPilote($_SESSION['idRole']);
                        $user->noterEntreprise($_SESSION['id'], $note, $com, $identreprise);
                        break;
                  case "Etudiant":
                        $user = new AccountStudent($_SESSION['idRole']);
                        $user->noterEntreprise($_SESSION['id'], $note, $com, $identreprise);
                        break;
                  case "Délégué":
                        $user = new AccountDelegate($_SESSION['idRole']);
                        $user->noterEntreprise($_SESSION['id'], $note, $com, $identreprise);
                        break;
            }
      }

      //Ajout entreprise
      if(isset($_POST['addCompany'])){
            $nomEntreprise = $_POST['nomentreprise'];
            switch($_SESSION['role']){
                  case "Administrateur":
                        $user = new AccountAdmin($_SESSION['idRole']);
                        $user->AjouterEntreprise($nomEntreprise);
                        break;
                  case "Pilote":
                        $user = new AccountPilote($_SESSION['idRole']);
                        $user->AjouterEntreprise($nomEntreprise);
                        break;
                  case "Etudiant":
                        $user = new AccountStudent($_SESSION['idRole']);
                        $user->AjouterEntreprise($nomEntreprise);
                        break;
                  case "Délégué":
                        $user = new AccountDelegate($_SESSION['idRole']);
                        $user->AjouterEntreprise($nomEntreprise);
                        break;
            }
      }

?>
