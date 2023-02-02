<?php

namespace App\Models;

use Database\Connection;

class LoginModel
{
    private static $mbd;

    function __construct()
    {
        self::$mbd = Connection::getInstance()->getDatabaseInstance();
    }

    public function getOne($name){
        $sql = "SELECT * FROM usuarios WHERE name =:nombreUsuario ";
        $stmt = self::$mbd->prepare($sql);
        $stmt->bindValue(':nombreUsuario', $name);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row;
    }

}
