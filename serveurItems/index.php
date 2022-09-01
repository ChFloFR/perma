 <?php
session_start();
//http://localhost/...
//https://www.florentneuville.com/...

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") ."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

//pour une seule récupération _once pour ne pas recevoir plusieurs fois les mêmes données
require_once "controllers/front/API.controller.php";
require_once "controllers/back/admin.controller.php";
require_once "controllers/back/cultures.controller.php";
require_once "controllers/back/familles.controller.php";
require_once "controllers/back/utile.php";
$apiController = new APIController();
$adminController = new AdminController();
$culturesController = new CulturesController();
$famillesController = new FamillesController();


//gestionnaire d'exception et de routes
try{
    if(empty($_GET['page'])){
        throw new Exception("la page n'existe pas");
    }else{
        //lecture et découpage de l'url et filtre pour sécuriser ce qui sortira sur le GET
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        if(empty($url[0]) || empty($url[1])) throw new Exception ("la page n'existe pas");
        //ROUTAGE FRONT
        //on sécurise les url par l'obligation d'avoir un des éléments front ou back à l'intérieur
        switch($url[0]){
            case "front" : 
                switch($url[1]){
                    case "items" : $apiController ->getItems($idFamille, $idItems);
                    break;
                    case "item":
                        if(empty($url[2])) throw new Exception("L'identifiant de la culture est manquant");
                        $apiController -> getItemUnik($url[2]);
                        break;
                        if(!isset($url[2]) || isset($url[3])){
                            //bien sûr les -1 n'existent pas
                            $apiController -> getItems(-1, -1);
                        }else{
                            //donc je veux les infos trouvées dans $url[2] & $url[3]
                            //on transforme les infos ($url[2] & $url[3]) - string - en int 
                            $apiController -> getItems((int)$url[2], $url[3]);
                            // $apiController ->getItems();
                        }
                            break;
                            case "famille" : 
                            //double contrôle sur l'url, il nous faut déjà une information
                                if(empty($url[2])) throw new Exception("id famille invalide");
                                $apiController->getFamilles($url[2]);
                            break;
                            // case "Conseils" : $apiController->getConseils();
                            // break;
                            case "Facilité" : $apiController->getEasy();
                            break;
                            case "sendMessage": $apiController->sendMessage();
                            break;
                            default : throw new Exception("la page n'existe pas demandée");
                    }
                    break;
                    case "back" : 
                        switch($url[1]){
                            case "login" : $adminController->getPageLogin(); 
                            break;
                            case "connexion" : $adminController->connexion();
                            break;
                            case "admin" : $adminController->getAccueilAdmin();
                            break;
                            case "deconnexion" : $adminController->deconnexion();
                            break;
                            // case "familles" : 
                            //     switch($url[2]){
                            //         case "visualition" : $famillesController->vue();
                            //         break;
                            //         case "création" : echo "creation";
                            //         break;
                            //         case "validationSuppression" : $famillesController->suppression();
                            //         break;
                            //         default :  throw new Exception("la page n'existe pas");
                            //     }
                            //     break;
                            // default : throw new Exception("la page n'existe pas");
                            case "familles" : 
                                switch($url[2]){
                                    case "visualisation" : $famillesController->vue();
                                    break;
                                    case "validationSuppression" : $famillesController->suppression();
                                    break;
                                    case "validationModification" : $famillesController->modification();
                                    break;
                                    case "creation" : $famillesController->creationTemplate();
                                    break;
                                    case "creationValidation" : $famillesController->creationValidation();
                                    break;
                                    default :  throw new Exception("la page n'existe pas");
                                }
                            case "cultures" : 
                                switch($url[2]){
                                    case "visualisation" : $culturesController->vue();
                                    break;
                                    case "validationSuppression" : $culturesController->suppression();
                                    break;
                                    case "validationModification" : $culturesController->modificationValidation();
                                    break;
                                    case "creation" : $culturesController->creation();
                                    break;
                                    case "creationValidation" : $culturesController->creationValidation();
                                    break;
                                    case "modification" : $culturesController->modification($url[3]);
                                    break;
                                    default :  throw new Exception("la page n'existe pas");
                                    }    
                            break;
                            // default : throw new Exception("la page n'existe pas");
                        }
                    break;
                    default : throw new Exception("la page n'existe pas");
                    }
                }
}catch(Exception $e){
    $msg = $e -> getMessage();
    echo $msg;
    // message + lien vers page de login
    echo "<a href='".URL."back/login'>login</a>";
    }


?>