<?php
require_once "models/Model.php";

class FacilitesManager extends Model{
    public function getFacilites(){
        $req = "SELECT * from facilite_entretien";
        $statment = $this->getBdd()->prepare($req);
        $statment->execute();
        $facilites = $statment->fetchAll(PDO::FETCH_ASSOC);
        $statment->closeCursor();
        return $facilites;
    }
    // public function deleteDBfacilite($idFacilite){
    //     $req = "Delete from facilite_entretien where id_facilite= :idFacilite";
    //     $statment = $this->getBdd()->prepare($req);
    //     $statment->bindValue("idFacilite", $idFacilite, PDO::PARAM_INT);
    //     $statment->execute();
    //     $statment->closeCursor();

    // }
    // public function compterFacilites($idFacilite){
    //     // je compte le nombre de ligne de la table items_cultures, je renomme en nb 
    //     // jointure de la table facilite en comparaison avec la table cultures pour savoir combien de cultures sont attachées à ladite facilite
    //     // $req = " Select count(*) as 'nb'
    //     // from facilite f inner join items_cultures ic on ic.id_facilite = f.id_facilite where f.id_facilite = :idCultures";
    //     $req = "Select count(*) as 'nb' from items_cultures where id_facilite = :idCultures";
    //     $statment = $this->getBdd()->prepare($req);
    //     $statment->bindValue("idCultures", $idFacilite, PDO::PARAM_INT);
    //     $statment->execute();
    //     $resultat = $statment->fetch(PDO::FETCH_ASSOC).
    //     $statment->closeCursor();
    //     return $resultat['nb'];
    // } 
    // // fonction de modification de Facilite
    // public function updateFacilite($idFacilite, $nomFacilite, $descriptionFacilite){
    //     $req = "Update facilite set nom_facilite = :nom, description_facilite = :description where id_facilite= :idFacilite";
    //     $statment = $this->getBdd()->prepare($req);
    //     $statment->bindValue(":idFacilite", $idFacilite, PDO::PARAM_INT);
    //     $statment->bindValue(":nomFacilite", $nomFacilite, PDO::PARAM_STR);
    //     $statment->bindValue(":descriptionFacilite", $descriptionFacilite, PDO::PARAM_STR);
    //     $statment->execute();
    //     $statment->closeCursor();
    // }
    // public function createFacilite($nomFacilite, $descriptionFacilite){
    //     $req = "Insert into facilite (nom_facilite, description_facilite) values(:nomFacilite, :descriptionFacilite)";
    //     $statment = $this->getBdd()->prepare($req);
    //     $statment->bindValue(":nomFacilite", $nomFacilite, PDO::PARAM_STR);
    //     $statment->bindValue(":descriptionFacilite", $descriptionFacilite, PDO::PARAM_STR);
    //     $statment->execute();
    //     $statment->closeCursor();
    //     return $this->getBdd()->lastInsertId();

    // }
    //+++++ tri des cultures par facilite++++++
    // créer une table cultures_facilites
    // public function addFaciliteCulture($idCulture, $idFacilite){
    //     $req = "Insert into cultures_facilites (id_item, id_facilite_item) values(:id_item, :id_facilite_item)";
    //     $statment = $this->getBdd()->prepare($req);
    //     $statment->bindValue(":id_item", $idCulture, PDO::PARAM_STR);
    //     $statment->bindValue(":id_facilite_item", $idFacilite, PDO::PARAM_INT);
    //     $statment->execute();
    //     $statment->closeCursor();
    // }
}