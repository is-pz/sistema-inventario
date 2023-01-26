<?php

namespace App\Models;

use Database\Connection;

class RolesModel
{
    private static $mbd;
    
    function __construct()
    {
        self::$mbd = Connection::getInstance()->getDatabaseInstance();
    }

    public function getAll(){
        $sql = 'SELECT * FROM roles';
        $stmt = self::$mbd->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public function getOne($id){
        $sql = 'SELECT * FROM roles WHERE id =:id';

        $stmt = self::$mbd->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function insertRol(Rol $rol){
        try{
            self::$mbd->beginTransaction();
            
            $sql = 'INSERT INTO roles(nombreRol, descripcionRol, active) VALUES (:nombreRol, :descripcionRol, :active)';
            

            $stmt = self::$mbd->prepare($sql);

            $stmt->bindValue(":nombreRol", $rol->nombreRol);
            $stmt->bindValue(":descripcionRol", $rol->descripcionRol);
            $stmt->bindValue(":active", $rol->active);

            $stmt->execute();

           
            self::$mbd->commit();

        }catch(\PDOException $e){
            self::$mbd->rollBack();
            return "Error: {$e->getMessage()}";
        }
    }

    public function updateRol(Rol $rol, $id){
        try{
            self::$mbd->beginTransaction();
            
            $sql = 'UPDATE roles SET  nombreRol= :nombreRol, descripcionRol= :descripcionRol, active= :active WHERE id= :idRol';
            

            $stmt = self::$mbd->prepare($sql);

            $stmt->bindValue(":idRol", $id);
            $stmt->bindValue(":nombreRol", $rol->nombreRol);
            $stmt->bindValue(":descripcionRol", $rol->descripcionRol);
            $stmt->bindValue(":active", $rol->active);
            
            $stmt->execute();

            self::$mbd->commit();

            return $id;
        }catch(\PDOException $e){
            self::$mbd->rollBack();
            return "Error: {$e->getMessage()}";
        }
    }

    public function deleteRol($id){
        try{
            self::$mbd->beginTransaction();

            $sql = 'DELETE FROM roles WHERE id = :id';
            $stmt = self::$mbd->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            self::$mbd->commit();

        }catch(\PDOException $e){
            self::$mbd->rollBack();
            return "Error: {$e->getMessage()}";
        }
    }
}

class Rol
{
    public $nombreRol;
    public $descripcionRol;
    public $active;

    public function __construct($nombreRol, $descripcionRol, $active)
    {
        $this->nombreRol = $nombreRol;
        $this->descripcionRol = $descripcionRol;
        $this->active = $active;
    }
}