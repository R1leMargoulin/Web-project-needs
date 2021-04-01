<?php
    include './Model/M_stages.php';
    $stage = new Stage();
    function home(){
        global $stage;
        //$res = $stage->getAllStages();
        $skills = $stage->competences();
        $company = $stage->getCompany();
        $campus = $stage->getCampus();
        session_start();
        $debut = 'SELECT offres_de_stage.idoffre, intitule_offre, description, nom_entreprise, nom_centre, nom_promotion FROM offres_de_stage, competences, entreprises, requerir, centres, promotions, prendre_place_a, s_adresser_a WHERE offres_de_stage.identreprise = entreprises.identreprise AND NOT EXISTS (SELECT IDOFFRE FROM candidatures WHERE IDUTILISATEUR = '.$_SESSION['id'].' AND offres_de_stage.IDOFFRE = candidatures.IDOFFRE) AND NOT EXISTS (SELECT IDOFFRE FROM met_en_wishlist WHERE IDUTILISATEUR = '.$_SESSION['id'].' AND offres_de_stage.IDOFFRE = met_en_wishlist.IDOFFRE) AND prendre_place_a.idcentre = centres.idcentre AND prendre_place_a.idoffre = offres_de_stage.idoffre AND s_adresser_a.idpromotion = promotions.idpromotion AND s_adresser_a.idoffre = offres_de_stage.idoffre';

        if(isset($_POST['entreprise'])){
            if($_POST['entreprise'] != ""){
                $nom_entreprise = $_POST['entreprise'];
                $entreprise = ' AND nom_entreprise = "'.$nom_entreprise.'"';
                $debut = $debut.$entreprise;
            }
            if($_POST['competences'] != ""){
                $nom_competence = $_POST['competences'];
                $competence = ' AND offres_de_stage.idoffre = requerir.idoffre AND requerir.idcompetence = competences.idcompetence AND nom_competence = "'.$nom_competence.'"';
                $debut = $debut.$competence;
            }
            if($_POST['localite'] != ""){
                $campus = $_POST['localite'];
                $centre = ' AND nom_centre = "'.$campus.'"';
                $debut = $debut.$centre;
            }
            if($_POST['promo'] != ""){
                $promotion = $_POST['promo'];
                $promo = ' AND nom_promotion = "'.$promotion.'"';
                $debut = $debut.$promo;
            }
            if($_POST['nbrPlace'] != ""){
                $nb = $_POST['nbrPlace'];
                $nb_place = ' AND nombre_places = "'.$nb.'"';
                $debut = $debut.$nb_place;
            }
            
        };
        if (isset($_POST["search"])){
            $intitule = $_POST['search'];
            $intitule_offre = ' AND UPPER(intitule_offre) LIKE UPPER("%'.$intitule.'%")';
            $debut = $debut.$intitule_offre;
        }
        $debut = $debut.' GROUP BY offres_de_stage.idoffre'; 
        $res = $stage->filter($debut);
        
        
        //$res_places = $stage->places($db);
        require('./View/home.php');
    }
    function NewInternship(){
        global $stage;
        $competences= $stage->competences();
        $company =$stage->getCompany();
        $campus =$stage->getCampus();
        $promos = $stage->getPromos();
        if(isset($_POST['stage'])){
            $j = $stage->add($_POST['entreprise'],$_POST['titre_stage'],$_POST['description'],$_POST['nb_place'],$_POST['Centre'],$_POST['Promos']);
            for($i=0;$i<=$j[0][0];$i++){
                if(isset($_POST['comp'.$i])){
                    $stage->addCompt($i,$j[1]);
                }
            }
            header('Location:https://needs.com');
        }
        require('./View/addOffre.php');
    }
    function Add($titre, $description, $entreprise){
        global $stage;
        $stage->addwishlist($titre, $description, $entreprise);
    }
    function Remove($titre, $description, $entreprise){
        global $stage;
        $stage->removewishlist($titre, $description, $entreprise);
    }
    function postulate(){
        global $stage;
        if (isset($_POST["sub_postulate"])){
            $CVName = "";
            $LDMName = "";
            $maxsize= 10000000;
            $ValidExt= '.pdf';
            if($_FILES["cv"]['error']>0){
                echo 'une erreur est survenu lors du transfert';
                die;
            }
            $sizeFile = $_FILES["cv"]['size'];
            if($sizeFile>$maxsize){
                echo"la taille du ficher est supérieure à la taille maximum";
                die;
            }
            $CVName = $_FILES['cv']['name'];
            $LDMName = $_FILES['cv']['name'];
            $CVExt = '.'. strtolower(substr(strrchr($CVName,'.'),1));
            $LDMExt = '.'. strtolower(substr(strrchr($LDMName,'.'),1));

            if($CVExt != $ValidExt){
                echo "L'extension du fichier n'est pas acceptée";
                die;
            }
            $tmpCVName = $_FILES['cv']['tmp_name'];
            $tmpLDMName = $_FILES['motiv']['tmp_name'];
            $uniqueNameCV = md5(uniqid(rand(), true));
            $uniqueNameLDM = md5(uniqid(rand(), true));
            $CVName = "../VH_2/Uploaded_files/".$uniqueNameCV.$CVExt;
            echo $CVName;
            $LDMName = "../VH_2/Uploaded_files/".$uniqueNameLDM.$LDMExt;
            $CVresult = move_uploaded_file($tmpCVName,$CVName);
            $LDMresult = move_uploaded_file($tmpLDMName,$LDMName);
        
        $stage->Postulate($CVName, $LDMName);
        }
        header("Location:Home");
    }
    function stage($titre, $description, $entreprise){
            session_start();
            $_SESSION['titre']= $titre;
            $_SESSION['description']= $description;
            $_SESSION['entreprise']= $entreprise;
        }

    function detailOffre($idOffre, $idUser){
        global $db;
        $queryDetail = $db->prepare("CALL afficher(:idOffre, :idUser)");
        $queryDetail->execute(array('idOffre'=>$idOffre, 'idUser'=> $idUser));
        $count = $queryDetail->ColumnCount();
        $table = $queryDetail->fetch();
        return array($table,$count);
    }

    /*$tableDetail = detailOffre($idoffre, $iduser);
    for ($i=0; $i = (count($tableDetail)-3);$i++){
        $echo($tableDetail['nom_competence'.$i].'  ');
    }*/
    function AfficherCompetences($idOffre){
        $StringReturn = "";
        $tableDetail = detailOffre($idOffre, $_SESSION['id']); 
        for ($i=0; $i < (($tableDetail[1])-3);$i++){ 
            $StringReturn = $StringReturn.$tableDetail[0]['nom_competence'.$i].' / ';
        } 
        return $StringReturn;
    }
    function compare(){
        global $stage;
        $Offres = $stage->getAllStages();
        require './View/compare.php';
    }
?>