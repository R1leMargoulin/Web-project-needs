<?php
class UserNotif{
    public function getNotifs($idUser){
        global $db;
        $queryNotif = $db->prepare("SELECT idnotification, idcandidature, contenu, vue FROM notifications WHERE idutilisateur = :iduser ORDER BY vue ASC");
        $queryNotif->execute(array('iduser'=> $idUser));
        $table = $queryNotif->fetchAll();
        return $table;
    }
    public function getOffre($idCandidature){
        global $db;
        $queryCandid = $db->prepare("SELECT idoffre, intitule_offre FROM offres_de_stage WHERE idoffre = (SELECT idoffre FROM candidatures WHERE idcandidature = :idcand)");
        $queryCandid->execute(array('idcand'=> $idCandidature));
        $result = $queryCandid->fetch();
        $name = $result['intitule_offre'];
        return $name;
    }
    
    public function voirNotif($idNotif){
        global $db;
        $queryVu = $db->prepare('UPDATE notifications SET vue = 1 WHERE idnotification = :idnotif');
        $queryVu->execute(array('idnotif'=>$idNotif));
    }
}

?>