<?php
        function connect(){
            include 'config.php';
            try
            {
                $db = new PDO('mysql:host=localhost;dbname='.$DatabaseName.';charset='.$charset.'', $UserName, $UserPassword);
            }
            catch (Exception $e)
            {
                die('Erreur : ' . $e->getMessage());
            }
            return $db;
        }
?>