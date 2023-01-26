<?php

namespace App\Models;


use Database\Connection;

class CategoryModel
{
    private static $mbd;

    function __construct()
    {
        self::$mbd = Connection::getInstance()->getDatabaseInstance();
    }

    public function getAll(){
        $sql = 'SELECT * FROM categorias';
        $stmt = self::$mbd->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public function getOne($id){
        $sql = 'SELECT * FROM categorias WHERE id =:id';

        $stmt = self::$mbd->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }


    public function insertCategory(Category $category){
        try{
            self::$mbd->beginTransaction();
            
            $sql = 'INSERT INTO categorias(nombreCategoria, descripcionCategoria, active) VALUES (:nombreCategoria, :descripcionCategoria, :active)';
            
            $stmt = self::$mbd->prepare($sql);

            $stmt->bindValue(":nombreCategoria", $category->nombreCategoria);
            $stmt->bindValue(":descripcionCategoria", $category->descripcionCategoria);
            $stmt->bindValue(":active", $category->active);

            $stmt->execute();

           
            self::$mbd->commit();

        }catch(\PDOException $e){
            self::$mbd->rollBack();
            return "Error: {$e->getMessage()}";
        }
    }

    public function updateCategory(Category $category, $id){
        try{
            self::$mbd->beginTransaction();
            
            $sql = 'UPDATE categorias SET  nombreCategoria= :nombreCategoria, descripcionCategoria= :descripcionCategoria, active= :active WHERE id= :idCategoria';
            

            $stmt = self::$mbd->prepare($sql);

            $stmt->bindValue(":idCategoria", $id);
            $stmt->bindValue(":nombreCategoria", $category->nombreCategoria);
            $stmt->bindValue(":descripcionCategoria", $category->descripcionCategoria);
            $stmt->bindValue(":active", $category->active);
            
            $stmt->execute();

            self::$mbd->commit();

            return $id;
        }catch(\PDOException $e){
            self::$mbd->rollBack();
            return "Error: {$e->getMessage()}";
        }
    }

    public function deleteCategory($id){
        try{
            self::$mbd->beginTransaction();

            $sql = 'DELETE FROM categorias WHERE id = :id';
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

class Category{
    public $nombreCategoria;
    public $descripcionCategoria;
    public $active;

    public function __construct($nombreCategoria, $descripcionCategoria, $active)
    {
        $this->nombreCategoria = $nombreCategoria;
        $this->descripcionCategoria = $descripcionCategoria;
        $this->active = $active;
    }
}