<?php

//class abstraite non instaciable

abstract class Model {
    private static $pdo;
    //connexion à la bdd unique qui sera toujours utilisée
    private static function setBdd(){
        self::$pdo = new PDO("db5009252742.hosting-data.io;dbname=dbs7837957;charset=utf8","root","");
        //au dessus ---"root" ->login, ""-> mot de passe
        //gestion des erreurs de pdo
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }
    //connexion à la bdd une seul fois, on vérifie
    //si on n'a pas encore fait de connexion à la bdd :
    protected function getBdd(){
        if(self::$pdo === null){
            // retourne $pdo qui est déjà connecté, si déjà connecté bien sûr
            self::setBdd();
        }
        // retourne quoiqu'il en soit $pdo
        return self::$pdo;
    }
    //traduire en JSON
    public static function sendJSON($info){
        //dispo uniquement pour mon api
        header("Access-Control-Allow-Origin: http://https://florentneuville.com/appliCodee/index.html");
        header("Content-Type: application/json");
        echo json_encode($info);
    }
}