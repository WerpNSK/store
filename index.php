<?php
    /*
    include_once("pages/classes.php");
    include_once("pages/createDB.php");
    $connect = Tools::Connect();

    $connect->exec($categories);
    $connect->exec($subCategories);
    $connect->exec($items);
    $connect->exec($image);
    $connect->exec($roles);
    $connect->exec($customer);
    $connect->exec($sale);
    */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Store</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.bundle.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <?php include_once("pages/classes.php"); ?>
            <?php include_once("pages/menu.php"); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?php
                if (isset($_GET['pages'])) {
                    $page = $_GET['pages'];
                    if ($page == 1) include_once('pages/registration.php');
                    if ($page == 2) include_once ('pages/admin.php');
                    if ($page == 3) include_once ('pages/category.php');
                    if ($page == 4) include_once ('pages/cart.php');
                }
                /*
                $pages = $_GET['pages'];
                if ($pages == 1)
                {
                    include_once('pages/registration.php');
                }
                */
            ?>
        </div>
    </div>
</div>
</body>
</html>
