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
        $sql = 'SELECT id, nombreRol, descripcionRol, active FROM roles';
        $stmt = self::$mbd->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

}
