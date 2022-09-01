<?php
require_once "models/front/API.manager.php";
require_once "models/Model.php";

class APIController {
    
    //dédié aux requêtes API REST - instance de l'API manager dans le cas de l'instance du controller
    private $apiManager;
    public function __construct(){
        $this->apiManager = new APIManager();
    }
    // récupération d'une culture unik
    public function getItemUnik(){
        // le manager va récupérer les items et cette fonction va etre appelée dans API Manager
        $item = $this->apiManager->getDBItem();
        $tabResultat = $this->formatDataLignesItem();
        Model::sendJSON($this->formatDataLignesItems($item));
    }
    // récupération de toutes les cultures
    public function getDBItems($idFamille, $idItems){
        $items = $this->apiManager->getDBItems();
        $tabResultat = $this->formatDataLignesItems($idFamille, $idItems);
        Model::sendJSON($this->formatDataLignesItems($items));
    }
    public function getFamilles($idFamille){
        echo "données JSON des familles de plantes". $idFamille[2]." demandées";
        break;
        $lignesFamille = $this->apiManager->getDBFamilles($idFamille);
        Model::sendJSON($lignesFamille);
        // echo "<pre>";
        // print_r($idFamille);
        //  "</pre>";
    }
    private function formatDataLignesItems($ligne){
        $tab= [];
        foreach($lignes as $ligne){
            $tab[] = [
                "id" => $ligne['id_item'],
                "nom" => $ligne['nom_item'],
                "image"=> URL."public/images/".$ligne['item_image'],
                "description" => $ligne['description'],
                "facile" => $ligne['facilite_entretien'],
                "ensoleillement" => $ligne['besoin_soleil_ensoleillement'],
                "Eau"=> $ligne['besoin_besoin_eau'],
                "famille" => [
                    "id_famille" => $ligne['famille_id'],
                    "Nom_famille" => ['famille']
                ]
                ];
        }
    }
    public function getEasy(){
        $facile = $this->apiManager->getDBEasy();
        Model::sendJSON('$facile');
        echo "<pre>     ";
        print_r($facile); 
         "</pre>";
    }
    public function getWater(){
        $req = "SELECT *
        from besoin_eau";
        $water = $this->apiManager->getDBWater();
        Model::sendJSON('$eau');
        echo "<pre>     ";
        print_r($water); 
         "</pre>";
    }

    public function sendMessage(){
        header("Access-Control-Allow-Origin: permakids.com");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Accept, Content-type, Content-Lenght, X-CSRF-Token, Accept-Encoding, Authorization");
        header("Content-Type: application/json");

        /*décodage de ce qui est récupéré du front */
        $obj = json_decode(file_get_contents('php://input'));
        
        /* traitement du message reçu*/

        // $to = "contact@permakids.com";
        // $subject = "message en provenance de : " .$obj->nom;
        // $message = $obj->contenu;
        // $headers = "From : " .$obj->email;
        // mail($to, $subject, $message, $headers);

        /* Envoi d'un retour pour dire que le message est traité */        
        $messageRetour = [
            'from' => $obj->email,
            'to'=> "contact@permakids.com"
        ];
        echo json_encode("$messageRetour");
    }
}