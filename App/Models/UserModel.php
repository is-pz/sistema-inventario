<?php

namespace App\Models;

use Database\Connection;
use PDOException;

class UserModel
{
    private static $mbd;
    
    function __construct()
    {
        self::$mbd = Connection::getInstance()->getDatabaseInstance();
    }

    public function getAll(){
        $sql = 'SELECT id, name, lastLogin, idRol, active FROM usuarios';
        $stmt = self::$mbd->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public function insertUser(User $user){
        try{
            self::$mbd->beginTransaction();
            
            $sql = 'INSERT INTO usuarios(idRol, name, password, imageUser, lastLogin, active) VALUES (:idRol, :name, :password, :imageUser, :lastLogin, :active)';
            

            $stmt = self::$mbd->prepare($sql);

            $stmt->bindValue(":idRol", $user->idRol);
            $stmt->bindValue(":name", $user->name);
            $stmt->bindValue(":password", $user->password);
            $stmt->bindValue(":imageUser", $user->imageUser);
            $stmt->bindValue(":lastLogin", $user->lastLogin);
            $stmt->bindValue(":active", $user->active);
            
            $stmt->execute();

            $id = self::$mbd->lastInsertId();

            self::$mbd->commit();

            return $id;

        }catch(\PDOException $e){
            self::$mbd->rollBasck();
            return "Error: {$e->getMessage()}";
        }

    }
}

class User{
    public $idRol;
    public $name;
    public $password;
    public $imageUser;
    public $lastLogin;
    public $active;

    public function __construct($idRol, $name, $password, $imageUser, $active, $lastLogin = null)
    {
        $this->idRol = $idRol;
        $this->name = $name;
        $this->password = $password;
        $this->imageUser = $imageUser;
        $this->lastLogin = $lastLogin;
        $this->active = $active;
    }
}

