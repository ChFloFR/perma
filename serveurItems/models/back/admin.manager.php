<?php

require_once "./models/Model.php";

class AdminManager extends Model{
    // la fonction va aller chercher le mdp en fonction du login
    private function getPasswordUser($login){
        $req= 'SELECT * from users WHERE login = :login';
        //connexion à la bdd
        $statment = $this->getBdd()->prepare($req);
        //bindValue pour placer le login
        $statment->bindValue(":login", $login,PDO::PARAM_STR);
        $statment->execute();
        //récuperation les informations exécutées -- FETCH_ASSOC pour éviter d'avoir 2 fois les infos
        $admin = $statment->fetch(PDO::FETCH_ASSOC);
        $statment->closeCursor();
        //renvoit simplement du mdp
        return $admin['password'];
    }
    //on pourrait renvoyer la fonction ci-dessus dans l'admin.controller mais pour plus de sécurité, on va faire une fonction qui dira si la connexion est autorisée ou pas : [renverra un booleen]
    public function isConnexionValid($login, $password){
        //je récupère le mdp en BDD, en envoyant le login
        $passwordDB = $this->getPasswordUser($login);
        //compare le mdp envoyé par le formulaire avec celui de la bdd, 
        return password_verify($password, $passwordDB);
    }
}
?>