<?php
require_once "models/Model.php";

class FamillesManager extends Model{
    public function getFamilles(){
        $req = "SELECT * from familles_items";
        $statment = $this->getBdd()->prepare($req);
        $statment->execute();
        $familles = $statment->fetchAll(PDO::FETCH_ASSOC);
        $statment->closeCursor();
        return $familles;
    }
    public function deleteDBfamille($idFamille){
        $req = "Delete from famille where id_famille= :idFamille";
        $statment = $this->getBdd()->prepare($req);
        $statment->bindValue("idFamille", $idFamille, PDO::PARAM_INT);
        $statment->execute();
        $statment->closeCursor();

    }
    public function compterFamilles($idFamille){
        // je compte le nombre de ligne de la table items_cultures, je renomme en nb 
        // jointure de la table famille en comparaison avec la table cultures pour savoir combien de cultures sont attachées à ladite famille
        // $req = " Select count(*) as 'nb'
        // from famille f inner join items_cultures ic on ic.id_famille = f.id_famille where f.id_famille = :idCultures";
        $req = "Select count(*) as 'nb' from items_cultures where id_famille = :idCultures";
        $statment = $this->getBdd()->prepare($req);
        $statment->bindValue("idCultures", $idFamilles, PDO::PARAM_INT);
        $statment->execute();
        $resultat = $statment->fetch(PDO::FETCH_ASSOC).
        $statment->closeCursor();
        return $resultat['nb'];
    } 
    // fonction de modification de Famille
    public function updateFamille($idFamille, $nomFamille, $descriptionFamille){
        $req = "Update famille set nom_famille = :nom, description_famille = :description where id_famille= :idFamille";
        $statment = $this->getBdd()->prepare($req);
        $statment->bindValue(":idFamille", $idFamille, PDO::PARAM_INT);
        $statment->bindValue(":nomFamille", $nomFamille, PDO::PARAM_STR);
        $statment->bindValue(":descriptionFamille", $descriptionFamille, PDO::PARAM_STR);
        $statment->execute();
        $statment->closeCursor();
    }
    public function createFamille($nomFamille, $descriptionFamille){
        $req = "Insert into famille (nom_famille, description_famille) values(:nomFamille, :descriptionFamille)";
        $statment = $this->getBdd()->prepare($req);
        $statment->bindValue(":nomFamille", $nomFamille, PDO::PARAM_STR);
        $statment->bindValue(":descriptionFamille", $descriptionFamille, PDO::PARAM_STR);
        $statment->execute();
        $statment->closeCursor();
        return $this->getBdd()->lastInsertId();

    }
    //+++++ tri des cultures par famille++++++
    // créer une table cultures_familles
    public function addFamilleCulture($idCulture, $idFamille){
        $req = "Insert into cultures_familles (id_item, id_famille_item) values(:id_item, :id_famille_item)";
        $statment = $this->getBdd()->prepare($req);
        $statment->bindValue(":id_item", $idCulture, PDO::PARAM_STR);
        $statment->bindValue(":id_famille_item", $idFamille, PDO::PARAM_INT);
        $statment->execute();
        $statment->closeCursor();
    }
}