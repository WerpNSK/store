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

        static function CreateUser($name, $pass, $image)
        {
            if ($name == "" || $pass == "")
            {
                echo "<h1>Error !!!</h1>";
                return false;
            }
            if (strlen($name) < 3 || strlen($pass) < 3)
            {
                echo "<h1>Error, pass and name must > 3</h1>";
                return false;
            }
            $obj = new Customers($name, $pass, 0, 0, $image);
            $obj->intoDB();
            return true;
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

    class Item
    {
        public $id;
        public $item_name;
        public $cat_id;
        public $price_in;
        public $price_sale;
        public $info;
        public $rate;
        public $image_path;
        public $action;

        function __construct($item_name, $cat_id, $price_in, $price_sale, $info, $image_path, $rate = 0, $action = 0, $id = 0)
        {
            $this->item_name = $item_name;
            $this->cat_id = $cat_id;
            $this->price_in = $price_in;
            $this->price_sale = $price_sale;
            $this->info = $info;
            $this->image_path = $image_path;
            $this->rate = $rate;
            $this->action = $action;
            $this->id = $id;
        }

        function Add()
        {
            try
            {
                $pdo = Tools::Connect();
                $select = $pdo->prepare("
                insert into items (item_name, cat_id, price_in, price_sale, info, image_path, rate, action)
                values (:item_name, :cat_id, :price_in, :price_sale, :info, :image_path, :rate, :action);
                ");
                $ar = (array)$this;
                array_shift($ar);
                $select->execute($ar);
            }
            catch (PDOException $ex)
            {
                echo "Some error..." . $ex->getMessage();
                return false;
            }
        }

        static function Show($id)
        {
            $item1 = null;
            try
            {
                $pdo = Tools::Connect();

                $ps = $pdo->prepare("select * from items where id=?");
                $ps->execute(array($id));
                $row = $ps->fetch();
                $item1 = new Item($row['item_name'], $row['cat_id'], $row['price_in'],
                    $row['price_sale'], $row['info'], $row['image_path'], $row['rate'], $row['action'], $row['id']);
                return $item1;
            }
            catch (PDOException $ex)
            {
                echo "Error!!! " . $ex->getMessage();
                return false;
            }
        }

        static function GetItems($cat_id = 0)
        {
            $items = null;
            try
            {
                $pdo = Tools::Connect();
                if ($cat_id == 0)
                {
                    $select = $pdo->prepare("select * from items;");
                    $select->execute();
                } else
                {
                    $select = $pdo->prepare("select * from items where cat_id=?");
                    $select->execute(array($cat_id));
                }
                while ($row = $select->fetch())
                {
                    /*
                    $item = new Item($row['item_name'], $row['cat_id'], $row['price_in'],
                        $row['price_sale'], $row['info'], $row['image_path'], $row['rate'], $row['action'], $row['id']);
                    */
                    $item = Item::Show($row['id']);
                    $items[] = $item;
                }
                return $items;
            }
            catch (PDOException $ex)
            {
                echo "Error!!! " . $ex->getMessage();
                return false;
            }
        }

        function Draw()
        {
            echo "<div class='col-3 container' style='height:350px;margin:2px;'>";
            //itemInfo.php contains detailed info about product
            echo "<div class='row' style='margin-top:2px; background-color:#ffd2aa;'>";
            echo "<a href='pages/itemInfo.php?name=" . $this->id . "'class='pull-left' style='margin-left:10px;''target='_blank'>";
            echo $this->item_name;
            echo "</a>";
            echo "<span class='pull-right' style='margin-right:10px;'>";
            echo $this->rate . "&nbsp;rate";
            echo "</span>";
            echo "</div>";
            echo "<div style='height:100px; margin-top:2px;' class='row'>";
            echo "<img src='" . $this->image_path . " 'height='100px'  />";
            echo "<span class='pull-right' style='margin-left:10px; color:red; font-size:16pt;'>";
            echo "$&nbsp;" . $this->price_sale;
            echo "</span>";
            echo "</div>";
            echo "<div class='row' style='margin-top:30px;'>";
            echo "<p class='text-left col-xs-12' style='background-color:lightblue; overflow:auto; height:60px;'>";
            echo $this->info;
            echo "</p>";
            echo "</div>";
            echo "<div class='row' style='margin-top:2px;'>";
            //creating cookies for the cart
            //will be explained later
            $ruser = '';
            if (!isset($_SESSION['reg']) || $_SESSION['reg'] == "")
            {
                $ruser = "cart_" . $this->id;
            } else
            {
                $ruser = $_SESSION['reg'] . "_" . $this->id;
            }
            echo "<button class='btn btn-success col-xsoffset-12 col-xs-12' 
            onclick=createCookie('" . $ruser . "','" . $this->id . "')>Add To My Cart</button>";
            echo "</div>";
            echo "</div>";
        }

        function DrawForCart()
        {
            echo "<div calss='row' style='margin:2px;'>";
            echo '<img src="' . $this->image_path . '" width="100" height="100" class="col-2">';
            echo "<span style='margin-right:10px; backgroud-color:#ddeeaa; color:blue; font-size:16pt' class='col-3'>";
            echo "&#8381&nbsp;" . $this->price_sale;
            echo "</span>";
            $ruser = "";
            if (!isset($_SESSION['reg']) || $_SESSION['reg'] == "")
            {
                $ruser = "cart_" . $this->id;
            } else
            {
                $ruser = $_SESSION['reg'] . "_" . $this->id;
            }
            echo "<button class='col-1 btn btn-danger' style='margin-left:10px;' onclick=eraseCookie('" . $ruser . "');>x</button>";
            echo "</div>";
        }


        function Sale()
        {

        }
    }

?>