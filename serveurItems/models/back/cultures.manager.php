<?php
require_once "models/Model.php";

class CulturesManager extends Model{
    public function getCultures(){
        $req = "SELECT * from items_culture";
        $statment = $this->getBdd()->prepare($req);
        $statment->execute();
        $cultures = $statment->fetchAll(PDO::FETCH_ASSOC);
        $statment->closeCursor();
        return $cultures;
    }
        public function deleteDBculture($idCulture){
        $req = "Delete from items_cultures where id_item= :idCulture";
        $statment = $this->getBdd()->prepare($req);
        $statment->bindValue("idCulture", $idCulture, PDO::PARAM_INT);
        $statment->execute();
        $statment->closeCursor();
    }
    public function updateCulture($id_item, $nom_item, $description_culture, $image, $famille){
        // dans les requetes ci -dessous, d'abord le nom de colonne BBD qui prend la valeur de la variable indiquée :variable
        // le nom de la culture = :nom_item de la bdd... etc
        $req="Update items_culture( 
        set nom_item = :nom_item, description_culture = :description_item, img_item = :image, id_famille_item = :famille
        where id_item= :idCulture";
                $statment = $this->getBdd()->prepare($req);
        $statment->bindValue(":idCulture", $id_item, PDO::PARAM_INT);
        $statment->bindValue(":nom_item", $nom_item, PDO::PARAM_STR);
        $statment->bindValue(":famille", $famille, PDO::PARAM_INT);
        $statment->bindValue(":description_item", $description_culture, PDO::PARAM_STR);
        $statment->bindValue(":image", $image, PDO::PARAM_STR);
        $statment->execute();
        $statment->closeCursor();
    }
        public function createCulture($idCulture, $nom_item, $description_item, $image, $famille){
        $req = "Insert into items_culture (nom_item, description_item, img_item, id_famille_item) values(:nom_item, :description_item, :img_item, :id_famille_item)";
        $statment = $this->getBdd()->prepare($req);
        // $statment->bindValue(":id_item", $idCulture, PDO::PARAM_INT);
        $statment->bindValue(":nom_item", $nom_item, PDO::PARAM_STR);
        $statment->bindValue(":id_famille_item", $famille, PDO::PARAM_INT);
        $statment->bindValue(":description_item", $description_item, PDO::PARAM_STR);
        $statment->bindValue(":img_item", $image, PDO::PARAM_STR);
        $statment->execute();
        $statment->closeCursor();
        return $this->getBdd()->lastInsertId();
    }
    public function getCulture($nom_item){
        $req = "SELECT ic.id_item, nom_item, id_famille_item, description_item, id_besoin_eau, id_entretien, id_ensoleillement from items_culture ic
            inner join famille on items_culture.id_famille_item=famille.id_famille
            inner join besoin_eau on items_culture.id_besoin_eau=besoin_eau.id_eau
            inner join ensoleillement on items_culture.id_ensoleillement=ensoleillement.id_soleil
            inner join facilite_entretien on items_culture.id_entretien=facilite_entretien.id_facilite
            -- est ce l'id_conseil à attraper ou l'id_item de la table_conseils ?
            inner join table_conseils on items_culture.id_conseil_item=table_conseils.id_conseil
            WHERE items_culture.id_item = :idCulture";
            
            $statment = $this->getBdd()->prepare($req);
            $statment->bindValue(":nom_item", $nom_item, PDO::PARAM_INT);
            $statment->execute();
            $lignesCulture = $statment->fetchAll(PDO::FETCH_ASSOC);
            $statment->closeCursor();
            return $lignesCulture;
    }
    // récupération de l'image de l'item pour la supprimer par le biais du cultures.controller.php

    public function getImageCulture($idCulture){
        // sélection de la colonne image de la table principale des cultures que je lie à l'id de ce dernier en paramètre de fonction
        $req = "SELECT img_item from items_culture where id_item = :idCulture";
        $statment = $this->getBdd()->prepare($req);
        $statment->bindValue(":idCulture", $idCulture, PDO::PARAM_INT);
        $statment->execute();
        $image = $statment->fetch(PDO::FETCH_ASSOC);
        $statment->closeCursor();
        return $image['img_item'];
        // on récupère simplement le nom de l'image
        // le cultures.controller.php fera la fonction unlik pour supprimer l'image du serveur
    }
}