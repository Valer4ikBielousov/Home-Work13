<?php

// require from database "bloger" with PHP (PDO) on mySQL
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'bloger');
function connect()
{
    try {
        static $bloger = null;
        if (is_null($bloger)) {

            $bloger = new PDO('mysql:host=127.0.0.1;dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER, DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
        }
        return $bloger;
    } catch (PDOException $e) {
        return false;
    }

}


