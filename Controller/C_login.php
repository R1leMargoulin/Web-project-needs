<?php
    function login(){
        session_start();
        if(isset($_SESSION['id'])){
            header('Location: ./Home');
            exit;
        }else{
            require('./View/login.php');
        }
    }   
?>