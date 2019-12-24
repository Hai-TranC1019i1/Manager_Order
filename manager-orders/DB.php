<?php

define("DB_DSN", 'mysql:host=localhost;dbname=classicmodels');
define("DB_USER", "root");
define("DB_PASS", "@Haitran123");

class DB
{

    private static $objInstance;


    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {

        if (!self::$objInstance) {
            self::$objInstance = new PDO(DB_DSN, DB_USER, DB_PASS);
            self::$objInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$objInstance;

    }

    final public static function __callStatic($chrMethod, $arrArguments)
    {

        $objInstance = self::getInstance();

        return call_user_func_array(array($objInstance, $chrMethod), $arrArguments);

    }

    public static function insert($strPrepare, $data)
    {
        $stmt = self::$objInstance->prepare($strPrepare);

        $stmt->execute((array)$data);

    }

    public static function update($strPrepare, $data)
    {

        $stmt = self::$objInstance->prepare($strPrepare);

        $stmt->setFetchMode(PDO::FETCH_OBJ);

        $stmt->execute((array)$data);
    }

    public static function getData($strPrepare, $data=null)
    {
        //Tạo Prepared Statement
        $stmt = self::$objInstance->prepare($strPrepare);

        $stmt->setFetchMode(PDO::FETCH_OBJ);

        $stmt->execute((array)$data);

        $arr = [];

        while ($order = $stmt->fetch()) {
            array_push($arr, $order);
        }

        return $arr;
    }

}
