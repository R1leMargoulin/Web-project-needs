<?php
include './Model/M_notifs.php';


/**
* @return bool
*/
function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

// Version affichenotif NON PAGINEE
/*
function afficherNotifs(){
    if ( is_session_started() === FALSE ) session_start();
    $user = new UserNotif;
    $Notifs = $user->getNotifs($_SESSION['id']);
    foreach($Notifs as $notif){
        echo("<div class='container'>");
            if($notif['vue'] == 0){
                echo("<div class='alert alert-primary notification'>");
                echo("<p class='idNotification'>".$notif['idnotification']."</p>");
                echo("<h2>Offre: ".$user->getoffre($notif['idcandidature'])."</h2>");
                echo("<p>".$notif['contenu']."</p>");
                echo("</div>");
             }
             elseif($notif['vue'] == 1){
                echo("<div class='alert alertLight'>");
                echo("<h2>Offre: ".$user->getoffre($notif['idcandidature'])."</h2>");
                echo("<p>".$notif['contenu']."</p>");
                echo("</div>");
             }

             echo("</div>");
    }
}
*/

    function afficherNotifs(){
        if ( is_session_started() === FALSE ) session_start();
        $user = new UserNotif;
        $Notifs = $user->getNotifs($_SESSION['id']);
        $nbNotifs = 0;
        foreach($Notifs as $r){
            $nbNotifs++;
        }
        for($i=0;  $i < $nbNotifs; $i++){
            echo("<div class='container'>");
            if(($i >= ($_SESSION['pageNotifs']*5)-5 && $i <= $_SESSION['pageNotifs']*5-1)){
                if($Notifs[$i]['vue'] == 0){
                    echo("<div class='alert alert-primary notification'>");
                    echo("<p class='idNotification'>".$Notifs[$i]['idnotification']."</p>");
                    echo("<h2>Offre: ".$user->getoffre($Notifs[$i]['idcandidature'])."</h2>");
                    echo("<p>".$Notifs[$i]['contenu']."</p>");
                    echo("</div>");
                 }
                 elseif($Notifs[$i]['vue'] == 1){
                    echo("<div class='alert alertLight'>");
                    echo("<h2>Offre: ".$user->getoffre($Notifs[$i]['idcandidature'])."</h2>");
                    echo("<p>".$Notifs[$i]['contenu']."</p>");
                    echo("</div>");
                 }

                 echo("</div>");
            }
        }
    }

    function notifications(){
        require './View/notifs.php';
    }

    function vueSurNotif($idNotif){
        $user = new UserNotif;
        $user->voirNotif($idNotif);
    }

    function cloche(){
        if ( is_session_started() === FALSE ) session_start();
        $location = "";
        $notifications = 0;
        $user = new UserNotif;
        $Notifs = $user->getNotifs($_SESSION['id']);
        foreach($Notifs as $notif){
            if($notif['vue'] == 1){
            }
            elseif($notif['vue'] == 0){
                $notifications++;
            }
        }
        if($notifications > 0){
            $location = "images/notif.png";
        }
        elseif($notifications == 0){
            $location = "images/no_notif.png";
        }
        return $location;
    }


    //pagination---------------------------------------------------------------------

    function nextPage(){
        if ( is_session_started() === FALSE ) session_start();
        $_SESSION['pageNotifs']++;
    }
    function previousPage(){
        if ( is_session_started() === FALSE ) session_start();
        $_SESSION['pageNotifs'] -= 1;
    }
    function resetPage(){
        if ( is_session_started() === FALSE ) session_start(); 
        $_SESSION['pageNotifs'] = 1;
    }

    function wichPage(){
        if ( is_session_started() === FALSE ) session_start();
        if(!isset($_SESSION['pageNotifs'])){
            $_SESSION['pageNotifs'] = 1;
        }
        echo $_SESSION['pageNotifs'];
    }
?>