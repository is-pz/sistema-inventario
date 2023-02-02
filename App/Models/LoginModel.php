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

    public function getData($name){
        $sql = "SELECT * FROM usuarios WHERE NombreUsuario = ? ";
        $stmt = self::$mbd->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->execute();
        $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $row;
    }

}
