<?php
namespace App;

class DB {
    static $conn;

    static function getConnect(){
        if(!self::$conn){
            $option = [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];
            self::$conn = new \PDO("mysql:host=localhost;dbname=housing2;charset=utf8mb4", "root", "", $option);
        }
        return self::$conn;
    }

    static function query($sql, $data = []){
        $q = self::getConnect()->prepare($sql);
        $q->execute($data);
        return $q;
    }

    static function fetch($sql, $data = []){
        return self::query($sql, $data)->fetch();
    }

    static function fetchAll($sql, $data = []){
        return self::query($sql, $data)->fetchAll();
    }
   
    static function find($table, $id){
        return self::fetch("SELECT * FROM $table WHERE id = ?", [$id]);
    }

    static function who($user_id){
        return self::fetch("SELECT * FROM users WHERE user_id = ?", [$user_id]);
    }
}