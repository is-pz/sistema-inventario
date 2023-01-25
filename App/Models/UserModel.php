<?php

namespace App\Models;

use Database\Connection;

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

}
