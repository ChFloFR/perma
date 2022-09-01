<?php
// Dans ce fichier, vérification de ce qui se passe dans les formulaires mais aussi que l'utilisateur possède bien des accès admin
    class Securite{
        public static function secureHTML($string){
            // pour éviter les injections
            return htmlentities($string);
        }

        //fonction de vérification d'accès -- validera ou non la page d'administration de menu.php
        public static function verifAccessSession(){
            // si les variables de sessions ne sont pas vides, contient-elle les infos admin alors renvoit VRAI
            return (!empty($_SESSION['access']) && $_SESSION['access'] === "admin");
        }   
     }
    //  Cette class et ces fonctions pourront être appelées n'importe où