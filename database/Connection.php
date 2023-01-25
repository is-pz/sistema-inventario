<?php

namespace Database;

use PDOException;

class Connection {
    private static object $instance;
    private static object $connection;


    private function __construct()
    {
        $this->make_connection();
    }

    //Regresa instancia de la clase 
    public static function getInstance(): object{
        //Verifica si es una instancia de si misma
        if(!self::$instance instanceof self){
            self::$instance = new self();
        }

        return self::$instance;
    }

    //Conexion con la base de datos
    private function make_connection(): void{
        try{
            $connection = new \PDO('mysql:host=localhost;dbname=sistema_inv', 'root', '');

            $setNames = $connection->prepare("SET NAMES 'utf-8'");
            $setNames->execute();

            $this->connection = $connection;
        }catch(\PDOException $e){
            die("Error de conexión {$e->getMessage()}");
        }
    }

    //Regresa la conexion con la base de datos
    public function getDatabaseInstance(): object{
        return $this->connection;
    }

}