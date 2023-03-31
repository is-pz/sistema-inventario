<?php

namespace Database;

use PDOException;

class Connection {
    private static  $instance;
    private static  $connection;


    private function __construct()
    {
        $this->make_connection();
    }

    //Regresa instancia de la clase 
    public static function getInstance(){
        //Verifica si es una instancia de si misma
        if(!self::$instance instanceof self){
            self::$instance = new self();
        }

        return self::$instance;
    }

    //Conexion con la base de datos
    private function make_connection(){
        try{
            $connection = new \PDO('mysql:host=localhost;dbname=sistema_inv', 'root', ''); //TODO: Los datos deben de cambiarse al .env
           
            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            $setNames = $connection->prepare("SET NAMES 'utf8'");
            $setNames->execute();

            self::$connection = $connection;
        }catch(\PDOException $e){
            die("Error de conexión {$e->getMessage()}");
        }
    }

    //Regresa la conexion con la base de datos
    public function getDatabaseInstance(){
        return self::$connection;
    }

}