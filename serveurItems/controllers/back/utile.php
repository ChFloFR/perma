<?php

// FONCTION POUR AJOUTER LES IMAGES AUX ITEMS

function ajoutImage($file, $dir){
    // y a t-il bien un fichier dans $file
    if(!isset($file['name']) || empty($file['name']))
        throw new Exception("Vous devez indiquer une image");
    // si le répertoire n'existe pas alors création avec mkdir sur le serveur
    if(!file_exists($dir)) mkdir($dir,0777);

    // gestion des extensions
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    // va permettre l'ajout d'un chiffre si le fichier a un nom qui existe déjà -> ajoutera un chiffre à son nom
    $random = rand(0,9999);
    // la ligne exécute cette ordre -> chemin du répertoire $dir chiffre aléatoire $random _ puis nom du fichier
    $target_file = $dir.$random."_".$file['name'];
    // on vérifie si le fichier est bien une image et si il possède bien une des extensions requises
    if(!getimagesize($file["tmp_name"]))
        throw new Exception("le fichier n'est pas image");
    if($extension !== "jpg" && $extension!== "jpeg" && $extension==!"png");
        throw new Exception("Le fichier existe déjà");
    // on vérifie à nouveau si le fichier existe déjà
    if(file_exists($target_file))
        throw new Exception("le fichier existe déjà");
    // on vérifie si le fichier n'est pas trop gros
    if($file['size'] > 500000)
        throw new Exception("Le fichier est trop gros");
    // puis on met le fichier dans le répertoire choisi
    if(!move_uploaded_file($file['tmp_name'], $target_file))
    // message si dysfonctionnement
        throw new Exception("l'ajout de l'image n'a pas fonctionné");
    // sinon renvoit de l'image
    else return ($random."_".$file['name']);
    
}