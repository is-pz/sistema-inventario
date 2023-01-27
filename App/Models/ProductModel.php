<?php

namespace App\Models;

use Database\Connection;

class ProductModel
{
    private static $mbd;

    function __construct()
    {
        self::$mbd = Connection::getInstance()->getDatabaseInstance();
    }

    public function getAll(){
        $sql = 'SELECT * FROM productos';
        $stmt = self::$mbd->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public function getOne($id){
        $sql = 'SELECT * FROM productos WHERE id =:id';

        $stmt = self::$mbd->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }


    public function insertProduct(Product $product){
        try{
            self::$mbd->beginTransaction();
            
            $sql = 'INSERT INTO productos(idCategoria, noSerie , nombreProducto, precioCosto , precioPublico, descripcionProducto, stock, active, create_at) VALUES (:idCategoria, :noSerie, :nombreProducto, :precioCosto, :precioPublico, :descripcionProducto, :stock, :active, :create_at)';
            
            $stmt = self::$mbd->prepare($sql);

            $stmt->bindValue(":idCategoria", $product->idCategoria);
            $stmt->bindValue(":noSerie", $product->noSerie);
            $stmt->bindValue(":nombreProducto", $product->nombreProducto);
            $stmt->bindValue(":precioCosto", $product->precioCosto);
            $stmt->bindValue(":precioPublico", $product->precioPublico);
            $stmt->bindValue(":descripcionProducto", $product->descripcionProducto);
            $stmt->bindValue(":stock", $product->stock);
            $stmt->bindValue(":active", $product->active);
            $stmt->bindValue(":create_at", $product->create_at);

            $stmt->execute();

            self::$mbd->commit();

        }catch(\PDOException $e){
            self::$mbd->rollBack();
            var_dump($e->getMessage());
            die;
            return "Error: {$e->getMessage()}";
        }
    }

    public function updateProduct(Product $product, $id){
        try{
            self::$mbd->beginTransaction();
            
            $sql = 'UPDATE productos SET idCategoria =:idCategoria, noSerie =:noSerie, nombreProducto= :nombreProducto, precioCosto =:precioCosto, precioPublico =:precioPublico, descripcionProducto= :descripcionProducto, stock =:stock , active= :active WHERE id= :idProducto';
            

            $stmt = self::$mbd->prepare($sql);

            $stmt->bindValue(":idProducto", $id);
            $stmt->bindValue(":idCategoria", $product->idCategoria);
            $stmt->bindValue(":noSerie", $product->noSerie);
            $stmt->bindValue(":nombreProducto", $product->nombreProducto);
            $stmt->bindValue(":precioCosto", $product->precioCosto);
            $stmt->bindValue(":precioPublico", $product->precioPublico);
            $stmt->bindValue(":descripcionProducto", $product->descripcionProducto);
            $stmt->bindValue(":stock", $product->stock);
            $stmt->bindValue(":active", $product->active);
            
            $stmt->execute();

            self::$mbd->commit();

            return $id;
        }catch(\PDOException $e){
            self::$mbd->rollBack();
            return "Error: {$e->getMessage()}";
        }
    }

    public function deleteProduct($id){
        try{
            self::$mbd->beginTransaction();

            $sql = 'DELETE FROM productos WHERE id = :id';
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

class Product{
    public $idCategoria;
    public $noSerie;
    public $nombreProducto;
    public $precioCosto;
    public $precioPublico;
    public $descripcionProducto;
    public $stock;
    public $active;
    public $create_at;

    public function __construct($idCategoria, $noSerie, $nombreProducto, $precioCosto, $precioPublico, $descripcionProducto, $stock, $active)
    {
        $this->idCategoria = $idCategoria;
        $this->noSerie = $noSerie;
        $this->nombreProducto = $nombreProducto;
        $this->precioCosto = $precioCosto;
        $this->precioPublico = $precioPublico;
        $this->descripcionProducto = $descripcionProducto;
        $this->stock = $stock;
        $this->active = $active;
        $this->create_at = date('Y-m-d H:i:s');
    }
}
