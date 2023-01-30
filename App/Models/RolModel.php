<?php

namespace App\Models;

use Database\Connection;

class RolModel
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