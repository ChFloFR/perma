<?php
require_once "models/Model.php";

class SoleilsManager extends Model{
    public function getSoleils(){
        $req = "SELECT * from ensoleillement";
        $statment = $this->getBdd()->prepare($req);
        $statment->execute();
        $soleils = $statment->fetchAll(PDO::FETCH_ASSOC);
        $statment->closeCursor();
        return $soleils;
    }
}
