<link rel="manifest" href="manifest.json">
<?php
    include "config.php";
    include "route.php";
    include "Controller/C_stages.php";
    include "Controller/C_user.php";
    include "Controller/C_login.php";
    include "Controller/C_notifs.php";

    define('BASEPATH', '/');

    Route::add('/', function(){
        login();
    });
    Route::add('/InConnection', function(){
        require('Model/M_login.php');
    },"post");
    Route::add('/Home', function() {
        home();
    });
    Route::add('/Saving', function(){
        Register();
    },"post");
    Route::add('/Add', function() {
        Add($_POST["titre"], $_POST["description"], $_POST["entreprise"]);
    },"post");
    Route::add('/Remove', function() {
        Remove($_POST["titre"], $_POST["description"], $_POST["entreprise"]);
    },"post");
    Route::add('/Postulate', function() {
        postulate();
    },"post");
    Route::add('/stagesession', function() {
        stage($_POST["titre"], $_POST["description"], $_POST["entreprise"]);
    },"post");
    Route::add('/stageCompetences', function() {
        stage($_POST["idOffre"]);
    },"post");
    Route::add('/Home', function() {
        home();
    },"post");
    Route::add('/NewInternShip', function(){
        NewInternship();
    });
    Route::add('/NewInternShip', function(){
        NewInternship();
    },"post");
    Route::add('/Account', function(){
        require('View/account.php');
    });
    Route::add('/Account', function(){
        require('View/account.php');
    },"post");
    Route::add('/Register', function(){
        require('View/register.php');
    });
    Route::add('/Unvisible', function(){
        UnvisibleAccount( $_POST["nom"], $_POST["prenom"], $_POST["age"]);
    },"post");
    Route::add('/Visible', function(){
        VisibleAccount( $_POST["nom"], $_POST["prenom"], $_POST["age"]);
    },"post");
    Route::add('/Compare', function(){
        compare();
    });
    Route::add('/Notifs', function(){
        notifications();
    });
    Route::add('/Notifs', function(){
        notifications();
    },"post");
    Route::add('/notifVue', function(){
        vueSurNotif($_POST['idNotif']);
    },"post");
    Route::add('/pagePlus', function(){
        nextPage();
    },"post");
    Route::add('/pageMoins', function(){
        previousPage();
    },"post");
    Route::add('/pageReset', function(){
        resetPage();
    },"post");

    Route::run(BASEPATH);
?>
<script type="text/javascript" src="installSW.js"></script>
