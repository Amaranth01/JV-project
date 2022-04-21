<?php

namespace App\Model;

use App\Config;
use PDO;
use PDOException;

class DB
{
    private static ?PDO $pdoObject = null;

    /**
     * @return PDO
     */
    public static function getPDO(): PDO
    {
        if(self::$pdoObject === null) {
            try {
                $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=' . Config::DB_CHARSET;
                self::$pdoObject = new PDO($dsn, Config::DB_USERNAME, Config::DB_PASSWORD);
                self::$pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdoObject ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
            catch (PDOException $err) {
                die();
            }
        }

        return self::$pdoObject;
    }
}