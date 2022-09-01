<?php

require_once "models/Model.php";

//APIManager étendera model (héritage)
class APIManager extends Model {

    

    public function getDBItems($idFamille, $idItems){
        // remplace le WHERE
        $whereClause = "";
        //si un de ces 2 filtres est vrai, ou si l'un a bien une valeur, alors$whereClause aura la valeur WHERE
        if($idFamille !== -1 || $idItems !== -1) $whereClause .= "WHERE"; // -1 = accès à tous les animaux
        if($idItems !== -1) $whereClause.= "id_item = :idItems";
        //si l'on veut associer l'existence des 2 valeurs, àplacer entre les deux :
        if($idItems !== -1 && $idFamille ==! -1) $whereClause .= "AND";
        // renseigné dans les bindValue en dessous
        if($idFamille !== -1) $whereClause .= "ic.id_item IN (
            SELECT id_item FROM famille WHERE id_famille = idFamille
            )"; 
        
// SI id_famille_item ne fonctionne pas alors aller prendre id_famille sur la table famille
        $req = "SELECT * ic.id_item, nom_item, description_item, img_item, id_famille_item, id_besoin_eau, id_ensoleillement, id_entretien
 
        -- ForeignKeys de mysql =
        from `items_culture ic`  
        -- de la table items_culture, joins - issu de la table famille -  l'id_famille sur la colonne id_famille_item(de la table items_culture)
            left join `famille` on `id_famille` = `id_famille_item`
            left join `table_conseils` on `id_conseil` = `id_conseil_item`.$whereClause
            ";

        //héritage de l'instance grâce au model
        $statment = $this->getBdd()->prepare($req); //getBdd dans Model.php
        if($idItems !== -1) $statment->bindValue(":idItem", $idItems, PDO::PARAM_INT);
        if($idFamille !== -1) $statment->bindValue(":idFamille", $idFamille, PDO::PARAM_INT);

        $statment->execute();
        //récupération des lignes issues de la connexion
        $items = $statment->fetchAll(PDO::FETCH_ASSOC);//juste les champs sans les index pour FETC_ASSOC
        $statment->closeCursor();//finit la requête
        return $items;//renvoit les infos
    }



        //récup et tri par l'information Famille
    public function getDBFamilles($idFamille){
        echo $req = "SELECT * 
        from `famille`
            left join `famille` on `nom_famille` = `id_famille_item`
            -- left join `nom_item` on `id_item` = `id_item_item`
            WHERE
            ";
           //héritage de l'instance grâce au model
            $statment = $this->getBdd()->prepare($req);
            if($idFamille !== -1) $statment->bindValue(":idFamille", $idFamille, PDO::PARAM_INT);
            //on attend une constante de type entière en dernier paramètre
            $statment->execute();
            $famille = $statment->fetchAll(PDO::FETCH_ASSOC);
            $statment->closeCursor();
            return $famille;
    }
    //récup et tri par l'information Eau
    public function getDBWater($idEau){
        $req = "SELECT * 
        from `besoin_eau` 
        inner join `items_culture` on `id_besoin_eau` = `id_eau`
        -- inner join `besoin_eau` on `id_eau` = `id_item_eau`
        -- WHERE id_items_culture = :id_item
        ";
        $statment = $this->getBdd()->prepare($req); 
        $statment->bindValue(":id_item", $idEau, PDO::PARAM_INT);
        $statment->execute();
        $eau = $statment->fetchAll(PDO::FETCH_ASSOC);
        $statment->closeCursor();
        return $eau;
    }
        //récup et tri par l'information Facilité
    public function getDBEasy($idFacile){
        $req = "SELECT *
        -- dans la table facilite_entretien
        from `facilite_entretien`  
        -- jointure nom_de_la_table ON nom_de_la_colonne de la table précitée = nom de la colonne de la table à joindre (facilite_entretien ici)
        left join `id_facilite` on `niveau_entretien` = `id_entretien`
        -- left join `niveau_entretien` on `id_entretien_item` = `id_facilite`
        -- condition:  nom d'une colonne qui doit être égal à une colonne
        WHERE `id_items_culture` = `:id_item`
        ";
        $statment = $this->getBdd()->prepare($req); 
        $statment->bindValue(":id_item", $idFacile, PDO::PARAM_INT);
        $statment->execute();
        $facile = $statment->fetchAll(PDO::FETCH_ASSOC);
        $statment->closeCursor();
        return $facile;
    }
        //récup et tri par l'information Ensoleillement
    public function getDBSun($idSoleil){
        $req = "SELECT *
        
        from `ensoleillement`
        left join `nom_item` on `id_item` = `id_item_item`
        left join `ensoleillement` on `id_soleil` = `id_item_soleil`
        WHERE id_items_culture = :id_item
        ";

        $statment = $this->getBdd()->prepare($req); 
        $statment->bindValue(":id_item", $idSoleil, PDO::PARAM_INT);
        $statment->execute();
        $soleil = $statment->fetchAll(PDO::FETCH_ASSOC);
        $statment->closeCursor();
        return $soleil;
    }
}