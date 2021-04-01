<?php
    include_once './Controller/C_database.php';

    
    class Stage{
        
        public function getAllStages(){
            global $db;
            session_start();
            $request = $db->query('SELECT idoffre, intitule_offre, description, nom_entreprise FROM offres_de_stage, entreprises WHERE offres_de_stage.IDENTREPRISE = entreprises.IDENTREPRISE AND NOT EXISTS (SELECT IDOFFRE FROM candidatures WHERE IDUTILISATEUR = '.$_SESSION['id'].' AND offres_de_stage.IDOFFRE = candidatures.IDOFFRE) AND NOT EXISTS (SELECT IDOFFRE FROM met_en_wishlist WHERE IDUTILISATEUR = '.$_SESSION['id'].' AND offres_de_stage.IDOFFRE = met_en_wishlist.IDOFFRE);');
            $getstages = $request->fetchAll();
            //$request = $db->query('SELECT nom_competence FROM competences, requerir WHERE competences.idcompetence = requerir.idcompetence AND idoffre = 43');
            //$getAllCompetences = $request->fetchAll();
            //foreach($getAllCompetences as $gac){
            //    echo $gac["nom_competence"];
            //}
            return $getstages;
        }
        public function research(){
            global $db;
            $request = $db->prepare("SELECT idoffre, intitule_offre, description, nom_entreprise FROM offres_de_stage, entreprises WHERE offres_de_stage.IDENTREPRISE = entreprises.IDENTREPRISE AND UPPER(intitule_offre) LIKE UPPER(?) AND NOT EXISTS (SELECT IDOFFRE FROM candidatures WHERE IDUTILISATEUR = ".$_SESSION['id']." AND offres_de_stage.IDOFFRE = candidatures.IDOFFRE) AND NOT EXISTS (SELECT IDOFFRE FROM met_en_wishlist WHERE IDUTILISATEUR = ".$_SESSION['id']." AND offres_de_stage.IDOFFRE = met_en_wishlist.IDOFFRE);");
            $request->execute(array("%".$this->intitule_offre."%"));
            $search = $request->fetchAll();
            return $search;
        }
        public function competences(){
            global $db;
            $request = $db->query('SELECT nom_competence FROM competences ORDER BY nom_competence ASC');
            $competences = $request->fetchAll();
            return $competences;
        }        
        /*public function places($db){
            $request = $db->query('SELECT nombres_places FROM offres_de_stage');
            $places = $request->fetchAll();
            return $places;
        }*/
        public function add($entreprise,$titre_stage, $description_stage,$nb_places,$centre,$promotion){
            global $db;
            $request = $db->prepare("INSERT INTO offres_de_stage (identreprise, intitule_offre, description, nombre_places) SELECT identreprise,:titre,:description,:places FROM entreprises where nom_entreprise=:entreprise");
            $request->execute(array('titre'=>$titre_stage,'description'=>$description_stage,'places'=>$nb_places,'entreprise'=>$entreprise));
            $result= $db->lastInsertId();
            $centre = $db->query('INSERT INTO prendre_place_a(idcentre, idoffre) SELECT idcentre,'.$result.' FROM centres WHERE nom_centre="'.$centre.'"');
            $rescentre = $centre->fetchAll();
            $promo = $db->query('INSERT INTO s_adresser_a(idpromotion, idoffre) SELECT idpromotion,'.$result.' FROM promotions WHERE nom_promotion="'.$promotion.'"');
            $respromo = $promo->fetchAll();
            $request= $db->query("SELECT COUNT(idcompetence) FROM competences");
            $i = $request->fetch(PDO::FETCH_NUM);
            return array($i, $result);
        }
        public function addCompt($i, $id){
            echo "il y a :".$i."compétences!!";
            echo "je suis la";
            global $db;
            $competence = $_POST['comp'.$i];
            echo $competence;
            $request = $db->query('INSERT INTO requerir(idcompetence, idoffre) SELECT idcompetence,'.$id.' FROM competences WHERE nom_competence="'.$competence.'"');

        }
        public function addCampus(){

        }
        public function addwishlist($titre, $description, $entreprise){
            global $db;
            session_start();
            $request = $db->query('INSERT INTO met_en_wishlist (idutilisateur, idoffre) SELECT '.$_SESSION["id"].', idoffre FROM offres_de_stage, entreprises WHERE offres_de_stage.identreprise = entreprises.identreprise AND intitule_offre="'.$titre.'" AND description="'.$description.'" AND nom_entreprise="'.$entreprise.'"');
        }
        public function removewishlist($titre, $description, $entreprise){
            global $db;
            session_start();
            $request = $db->query('DELETE FROM met_en_wishlist WHERE idutilisateur = '.$_SESSION["id"].' AND idoffre IN (SELECT idoffre FROM offres_de_stage, entreprises WHERE offres_de_stage.identreprise = entreprises.identreprise AND intitule_offre = "'.$titre.'" AND description = "'.$description.'" AND nom_entreprise = "'.$entreprise.'")');
        }
        public function Postulate($cv, $ldm){
            global $db;
            session_start();
            $request = $db->query('INSERT INTO candidatures (idoffre, idutilisateur, etat_avancement, statut, cv, ldm) SELECT idoffre, '.$_SESSION["id"].', 1, 1, "'.$cv.'", "'.$ldm.'" FROM offres_de_stage, entreprises WHERE offres_de_stage.identreprise = entreprises.identreprise AND intitule_offre = "'.$_SESSION["titre"].'" AND description = "'.$_SESSION["description"].'" AND nom_entreprise = "'.$_SESSION["entreprise"].'";');
            
        }
        public function getCompany(){
            global $db;
            $request= $db->query('SELECT nom_entreprise,identreprise FROM entreprises');
            $entreprise = $request->fetchAll();
            return $entreprise;
        }
        public function getCampus(){
            global $db;
            $request = $db->query('SELECT nom_centre FROM centres');
            $campus = $request->fetchAll();
            return $campus;
        }
        public function getPromos(){
            global $db;
            $request = $db->query('SELECT nom_promotion FROM promotions');
            $promos = $request->fetchAll();
            return $promos;
        }
        public function filter($debut){
            global $db;
            $request = $db->query($debut);
            $idOffre = $request->fetchAll();
            return $idOffre;
        }
        public function researchFilterComp(){
            global $db;
        }
    }
?>