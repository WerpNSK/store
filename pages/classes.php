<?php

    class Tools
    {
        static function Connect($host = "localhost:3306", $user = "admin", $pass = "admin", $dbname = "store")
        {
            $connect = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8;';
            $option = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
            );
            try {
                $pdo = new PDO($connect, $user, $pass, $option);
                return $pdo;
            } catch
            (PDOException $ex) {
                echo $ex->getMessage();
                return false;
            }
        }
    }

?>