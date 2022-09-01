<?php
require_once "./Securite.class.php";
require_once "./models/back/familles.manager.php";

class FamillesController{
    private $famillesManager;
    public function __construct(){
        $this->famillesManager = new famillesManager();
    }
    //vue de la page d'ajout de familles
    public function vue(){
        if(Securite::verifAccessSession()){
            // le controller va envoyer les datas dans la variable (travail issu de la partie manager-model du MVC), la vue parcourt les infos pour l'afficher
            $familles = $this->famillesManager->getFamilles();  
            require_once "views\famillesVisualisation.view.php";
        }else {
            throw new Exception("Vous n'avez pas le droit d'être là");
        }
    }
    // fonction de suppression et messages d'alerte
    public function suppression(){
        // tableau de vérification d'accès et alerte
        if(Securite::verifAccessSession()){
            // variable qui contient les id culture
            $idFamille = (int)Securite::secureHTML($_POST['id_famille']);
            // Si la famille demandée à la suppression contient des cultures, message d'alerte
            if($this->famillesManager->compterFamilles($idFamille) > 0){
                $_SESSION['alert'] = [
                    "message" => "la famille n'a pas été supprimée",
                    "type" => "alert-danger"
                ];
            }else{
                $this->famillesManager->deleteDBfamille($idFamille);
                $_SESSION['alert'] = [
                    "message" => "la famille est supprimée",
                    "type" => "alert-success"
                ];
            }
            // $this, pour accéder à l'attribut private/transformation en entier /On sécurise l'information postée avec la fonction secureHTML dans Securite.class.php
            header('Location: '.URL.'back/familles/visualisation');
        }else{
            throw new Exception("Vous n'avez pas le droit d'être là");
        } 
    }
    public function modification(){
        if(Securite::verifAccessSession()){
            $idFamille = (int)Securite::secureHTML($_POST['id_famille']);
            $nomFamille = (int)Securite::secureHTML($_POST['nom_famille']);
            $descriptionFamille = (int)Securite::secureHTML($_POST['description_famille']);
            $this->famillesManager->updateFamille($idFamille, $nomFamille, $descriptionFamille);
            
            $_SESSION['alert'] = [
                "message" => "la famille a été modifiée",
                "type" => "alert-success"
            ];

            header('Location: '.URL.'back/familles/visualisation');
        }else{
            throw new Exception("Vous n'avez pas le droit d'être là");
        } 
    }
    public function creationTemplate(){
        if(Securite::verifAccessSession()){
            require_once "views\familleCreation.view.php";
        }else {
            throw new Exception("Vous n'avez pas le droit d'être là");
        }
    }
    public function creationValidation(){
        if(Securite::verifAccessSession()){
            // traitement en bdd
            $nomFamille = (int)Securite::secureHTML($_POST['nom_famille']);
            $descriptionFamille = (int)Securite::secureHTML($_POST['description_famille']);
            $idFamille = $this->famillesManager->createFamille($nomFamille, $descriptionFamille);

            $_SESSION['alert'] = [
                "message" => "la famille a bien été créée avec l'identifiant : " .$idFamille,
                "type" => "alert-success"
            ];

            header('Location: '.URL.'back/familles/visualisation');
        }else {
            throw new Exception("Vous n'avez pas le droit d'être là");
        }
    }
}


