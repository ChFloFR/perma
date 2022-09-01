<?php
require_once "models/Model.php";

class EauxManager extends Model{
    public function getEaux(){
        $req = "SELECT * from besoin_eau";
        $statment = $this->getBdd()->prepare($req);
        $statment->execute();
        $eau = $statment->fetchAll(PDO::FETCH_ASSOC);
        $statment->closeCursor();
        return $eau;
    }
}