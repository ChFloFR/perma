<?php
require_once "./Securite.class.php";
require_once "./models/back/cultures.manager.php";
// appelle du manager famille pour pouvoir proposer la famille à laquelle appartient la culture lors de la création.
require_once "./models/back/familles.manager.php";
require_once "./models/back/eau.manager.php";
require_once "./controllers/back/utile.php";
require_once "./models/back/facilite.manager.php";

class CulturesController{
    private $culturesManager;
    public function __construct(){
        $this->culturesManager = new CulturesManager();
    }
    //vue de la page d'ajout de cultures
    public function vue(){
        if(Securite::verifAccessSession()){
            $cultures = $this->culturesManager->getCultures();  
            require_once "views\culturesVisualisation.view.php";
        }else {
            throw new Exception("Vous n'avez pas le droit d'être là");
        }
    }
    public function suppression(){
        if(Securite::verifAccessSession()){
            $idCulture = (int)Securite::secureHTML($_POST['id_item']);
            // requete qui récupère le nom de l'image [cf culturemanager]
            $image = $this->culturesManager->getImageCulture($idCulture);
            unlink("public/images".$image);
 
            // nécessité d'ajouter la suppression sur la table conseil ?
            $this->culturesManager->deleteDBculture($idCulture);
            $_SESSION['alert'] = [
                    "message" => "la culture n'a pas été supprimée",
                    "type" => "alert-danger"
                ];
            header('Location: '.URL.'back/cultures/visualisation');
        }else{
            throw new Exception("Vous n'avez pas le droit d'être là");
        }
    }
    // dans la création d'une culture il faut proposer la famille à laquelle elle appartient
    public function creation(){
        if(Securite::verifAccessSession()){
            $famillesManager = new FamillesManager();
            $familles = $famillesManager->getFamilles();
            // dans la table besoin_eau : id_eau & besoin_besoin_eau
            $eauxManager = new EauxManager();
            $eaux = $eauxManager->getEaux();
            // dans la table ensoleillement : id_soleil & besoin_besoin_ensoleillement
            // $soleilManager = new
            // dans la table facilite_entretien : id_facilite & niveau_entretien
            // $entretienManager = 

            require_once "views/cultureCreation.view.php";
        }else{
            throw new Exception("Vous n'avez pas le droit d'être là");
        }
    }
    public function creationValidation(){
        if(Securite::verifAccessSession()){
            $id_item = Securite::secureHTML($_POST["id_item"]);
            $nom_item = Securite::secureHTML($_POST["nom_item"]);
            $description_culture = Securite::secureHTML($_POST["description_culture"]);
            $image = "";
            if($_FILES['image']['size']>0){
                $repertoire = "public/images/";
                $image = ajoutImage($_FILES['image'], $repertoire);

            }
            $famille = (int)Securite::secureHTML($_POST["id_famille_item"]);
            $idFamille = $this->culturesManager->createCulture($id_item, $nom_item, $description_culture, $famille, $image);

            // $famillesManager = new FamillesManager();
            // CREER TABLE CULTURES_FAMILLES POUR CONTINUER CODE CI DESSOUS
            // if(!empty($_POST['famille][]'))
            //     $famillesManager->addFamilleCulture($idCulture,1);

            // $_SESSION['alert'] = [
            //    "message" => "la culture a été crée avec l'id :".$idCulture,
            //    "type" => "alert-danger"
            // ];

            header('Location: '.URL.'back/cultures/visualisation');


        }else{
            throw new Exception("Vous n'avez pas le droit d'être là");
        }
    }
    public function modification($id_item){
                
        if(Securite::verifAccessSession()){
            $famillesManager = new FamillesManager();
            $familles = $famillesManager->getFamilles();
            $eauxManager = new EauxManager();
            $eaux = $eauxManager->getEaux();
            $faciliteManager = new FacilitesManager();
            $facilites = $facilitesManager->getFacilites();
            // $soleilManager = new SoleilManager();

            $lignesCulture = $this->culturesManager->getCulture((int)Securite::secureHTML($id_item));
            $tabEau = [];
            foreach($lignesCulture as $eau){
                $tabEau[]=$eau['id_eau'];
            }
            // j'attrape les 7 premières informations qui m'intéressent
            $culture = array_slice($lignesCulture[0],0, 7);
            $tabSoleil = [];
            foreach($lignesCulture as $soleil){
                $tabSoleil[]=$soleil['id_soleil'];
            }
            $tabFacile = [];
            foreach($lignesCulture as $facilite){
                $tabFacile[]=$facilite['id_facilite'];
            }
            require_once "views/cultureModification.view.php";
        }else{
            throw new Exception("Vous n'avez pas le droit d'être là");
        }
    }
        public function modificationValidation(){
            if(Securite::verifAccessSession()){
                //besoin de récupérer l'id de l'item (la cutlure)
            $id_item = Securite::secureHTML($_POST['$id_item']);
            $nom_item = Securite::secureHTML($_POST["nom_item"]);
            $description_culture = Securite::secureHTML($_POST["description_item"]);
            // récupération de l'image actuelle en BDD
            $image = $this->culturesManager->getImageCulture($id_item);
            // si demandé et si il y a qqchose dans ce fichier, je veux le remplacer
            if($_FILES['image']['size']>0){
                // suppression de l'image actuelle ci_dessous si on veut (mais je garde les images)
                // unlink("public/images".$image);
                // puis je mets la nouvelle
                $repertoire = ":public/image/"; 
                $image =ajoutImage($_FILES['image'], $repertoire);
                
            }
            $famille = (int)Securite::secureHTML($_POST["id_famille_item"]);
            // la fonction update se trouve dans le manager, ici on lui donne les paramètres qu'elle doit contenir seulement 
            $this->culturesManager->updateCulture($id_item, $nom_item, $description_culture, $image, $famille);

            // $eaux = [
            //     1 => !empty($_POST['eau-1']),
            //     2 => !empty($_POST['eau-2']),
            //     3 => !empty($_POST['eau-3'])
            // ];

            $_SESSION['alert'] = [
                "message" => " La culture est modifiée",
                "type" => "alert-success"
            ];
            header('Location: '.URL.'back/cultures/visualisation');
        }else{
            throw new Exception("Vous n'avez pas le droit d'être là");
        }
    }
}

