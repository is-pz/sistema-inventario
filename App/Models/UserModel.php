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

    public function getOne($id){
        $sql = 'SELECT * FROM usuarios WHERE id = :id';
        $stmt = self::$mbd->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
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
            self::$mbd->rollBack();
            return "Error: {$e->getMessage()}";
        }

    }

    public function updateUser(User $user, $id){
        try{
            self::$mbd->beginTransaction();
            
            $sql = 'UPDATE usuarios SET idRol= :idRol, name= :name, password= :password, imageUser= :imageUser, lastLogin= :lastLogin, active= :active WHERE id= :idUser';
            

            $stmt = self::$mbd->prepare($sql);

            $stmt->bindValue(":idRol", $user->idRol);
            $stmt->bindValue(":name", $user->name);
            $stmt->bindValue(":password", $user->password);
            $stmt->bindValue(":imageUser", $user->imageUser);
            $stmt->bindValue(":lastLogin", $user->lastLogin);
            $stmt->bindValue(":active", $user->active);
            $stmt->bindValue(":idUser", $id);
            
            $stmt->execute();

            self::$mbd->commit();

            return $id;

        }catch(\PDOException $e){
            self::$mbd->rollBack();
            return "Error: {$e->getMessage()}";
        }

    }

    public function deleteUser($id){
        try{
            self::$mbd->beginTransaction();

            $sql = 'DELETE FROM usuarios WHERE id = :id';
            $stmt = self::$mbd->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            self::$mbd->commit();

        }catch(\PDOException $e){
            self::$mbd->rollBack();
            var_dump($e->getMessage());
            die;
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

