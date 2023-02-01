<?php

namespace App\Models;

use Database\Connection;


class SellModel
{
    private static $mbd;

    function __construct()
    {
        self::$mbd = Connection::getInstance()->getDatabaseInstance();
    }

    public function getAll(){
        $sql = 'SELECT * FROM ventas';
        $stmt = self::$mbd->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public function getOne($id){
        $sql = 'SELECT * FROM ventas WHERE id =:id';

        $stmt = self::$mbd->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }


    public function insertSell(Sell $sell){
        try{
            self::$mbd->beginTransaction();
            
            $sql = 'INSERT INTO ventas(idProducto, idUsuario , nombreProducto, cantidadVendido ,precioProducto , precioVenta, descripcionVenta, sell_at) VALUES (:idProducto, :idUsuario, :nombreProducto, :cantidadVendido, :precioProducto, :precioVenta, :descripcionVenta, :sell_at)';
            
            $stmt = self::$mbd->prepare($sql);

            $stmt->bindValue(":idProducto", $sell->idProducto);
            $stmt->bindValue(":idUsuario", $sell->idUsuario);
            $stmt->bindValue(":nombreProducto", $sell->nombreProducto);
            $stmt->bindValue(":cantidadVendido", $sell->cantidadVendido);
            $stmt->bindValue(":precioProducto", $sell->precioProducto);
            $stmt->bindValue(":precioVenta", $sell->precioVenta);
            $stmt->bindValue(":descripcionVenta", $sell->descripcionVenta);
            $stmt->bindValue(":sell_at", $sell->sell_at);

            $stmt->execute();

            self::$mbd->commit();

        }catch(\PDOException $e){
            self::$mbd->rollBack();
            var_dump($e->getMessage());
            die;
            return "Error: {$e->getMessage()}";
        }
    }

    public function updateSell(Sell $sell, $id){
        try{
            self::$mbd->beginTransaction();
            
            $sql = 'UPDATE ventas SET idProducto =:idProducto, idUsuario =:idUsuario, nombreProducto= :nombreProducto, cantidadVendido=:cantidadVendido, precioProducto =:precioProducto, precioVenta =:precioVenta, descripcionVenta= :descripcionVenta, sell_at= :sell_at WHERE id= :idVenta';
            

            $stmt = self::$mbd->prepare($sql);

            $stmt->bindValue(":idVenta", $id);
            $stmt->bindValue(":idProducto", $sell->idProducto);
            $stmt->bindValue(":idUsuario", $sell->idUsuario);
            $stmt->bindValue(":nombreProducto", $sell->nombreProducto);
            $stmt->bindValue(":cantidadVendido", $sell->cantidadVendido);
            $stmt->bindValue(":precioProducto", $sell->precioProducto);
            $stmt->bindValue(":precioVenta", $sell->precioVenta);
            $stmt->bindValue(":descripcionVenta", $sell->descripcionVenta);
            $stmt->bindValue(":sell_at", $sell->sell_at);
            
            $stmt->execute();

            self::$mbd->commit();

            return $id;
        }catch(\PDOException $e){
            self::$mbd->rollBack();
            return "Error: {$e->getMessage()}";
        }
    }

    public function deleteSell($id){
        try{
            self::$mbd->beginTransaction();

            $sql = 'DELETE FROM ventas WHERE id = :id';
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

class Sell{
    public $idProducto;
    public $idUsuario;
    public $nombreProducto;
    public $cantidadVendido;
    public $precioProducto;
    public $precioVenta;
    public $descripcionVenta;
    public $sell_at;

    public function __construct($idProducto, $idUsuario, $nombreProducto, $cantidadVendido, $precioProducto, $precioVenta, $descripcionVenta)
    {
        $this->idProducto = $idProducto;
        $this->idUsuario = $idUsuario;
        $this->nombreProducto = $nombreProducto;
        $this->cantidadVendido = $cantidadVendido;
        $this->precioProducto = $precioProducto;
        $this->precioVenta = $precioVenta;
        $this->descripcionVenta = $descripcionVenta;
        $this->sell_at = date('Y-m-d H:i:s');
    }
}
