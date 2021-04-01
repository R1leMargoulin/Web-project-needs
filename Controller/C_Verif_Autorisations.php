<?php
if(!isset($_SESSION)){
    session_start();
}
function noStudent(){
    switch($_SESSION['idRole']):
        case 3:
            header("Location: /");
            break;
        endswitch;
        
}

function noStudentNoPilote(){
    switch($_SESSION['idRole']):
        case 3:
            header("Location: /");
            break;
        case 2:
            header("Location: /");
            break;
        endswitch;
        
}

function sfx8VerifHome(){
    switch($_SESSION['role']):
        case 'Délégué':
            if (!in_array("sfx8", $_SESSION['tableAutorisation'])){
                header("Location: Account");
            }
            break;

        endswitch;
}

function sfx9VerifAddOffre(){
    switch($_SESSION['role']):
        case 'Délégué':
            if (!in_array("sfx9", $_SESSION['tableAutorisation'])){
                header("Location: Account");
            }
            break;

        endswitch;
}

?>
