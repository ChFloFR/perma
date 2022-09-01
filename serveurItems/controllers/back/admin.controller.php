<?php

require "./controllers/back/Securite.class.php";
//l'admin récupère les informations de connexion du manager
require "./models/back/admin.manager.php";

class AdminController{
    private $adminManager;

        public function __construct()
    {
        $this->adminManager = new AdminManager();
    }

    public function getPageLogin(){
        require_once "views/login.view .php"
    }
    public function connexion(){
        //méthode la plus sécurisée en cours : PASSWORD_DEFAULT -- hash crypte le mdp
        echo password_hash("admin09", PASSWORD_DEFAULT);

        // LA LIGNE CI DESSUS DEVRA ETRE SUPPRIMEE

        //si login et password ne sont pas vides, que les informations ont été saisies avant de vérifier en BDD
        if(!empty($_POST['login']) && !empty($_POST['password'])){
            $login = Securite::secureHTML($_POST['login']);
            $password = Securite::secureHTML($_POST['password']);
            if($this->adminManager->isConnexionValid($login, $password)){
                //je mets l'information admin dans la session de l'utilisateur
                $_SESSION['access' = "admin"];
                header('Location : ' .URL."back/admin");
            }else{
                //si la connexion n'a pas fonctionnée, retour à la page de connexion
                header('Location : ' .URL."back/login");
            }
        }
    }
    public function getAccueilAdmin(){
        // si verifAccess est TRUE -- si TRUE accès la vue admin en menu.php 
        if(Securite::verifAccessSession()){
        require "views/accueilAdmin.view.php";
    }else{
        header('Location: '.URL."back/login");
        }
    }
    public function deconnexion(){
        //supprime la variable de session et retourne sur la page de login
        session_destroy();
        header('Location :' .URL."back/login");
    }
}


