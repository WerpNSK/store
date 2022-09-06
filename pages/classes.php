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
            try
            {
                $pdo = new PDO($connect, $user, $pass, $option);
                return $pdo;
            }
            catch
            (PDOException $ex)
            {
                echo $ex->getMessage();
                return false;
            }
        }
    }

    class Customers
    {
        public $id;
        public $login;
        public $pass;
        public $total;
        public $discount;
        public $image_path;
        public $role_id;

        function __construct($login, $pass, $total, $discount, $imagePath, $id = 0)
        {
            $this->id = $id;
            $this->login = $login;
            $this->pass = $pass;
            $this->total = $total;
            $this->discount = $discount;
            $this->image_path = $imagePath;
            $this->role_id = 2;
        }

        function intoDB()
        {
            try
            {
                $connect = Tools::Connect();
                $select = $connect->prepare("insert into customer(login,pass,role_id,discount,total,image_path)
                                            values (:login,:pass,:role_id,:discount,:total,:image_path);");
                $ar = (array)$this;
                array_shift($ar);
                $select->execute($ar);
            }
            catch (Exception $ex)
            {
                echo $ex->getMessage();
                return false;
            }
        }

        static function fromDB($id)
        {
            $user = null;
            try
            {
                $connect = Tools::Connect();
                $ps = $connect->prepare("select * from customer where id=?;");
                $ps->execute(array($id));
                $row = $ps->fetch();
                $user = new Customers($row['login'], $row['pass'], $row['total'], $row['discount'], $row['image_path'], $row['id']);
                return $user;
            }
            catch (PDOException $ex)
            {
                echo 'Error ' . $ex->getMessage();
                return false;
            }
        }
    }


?>