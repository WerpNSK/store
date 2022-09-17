<?php



    echo '<form action="index.php?pages=4" method="post">';
    $ruser = '';
    if (!isset($_SESSION['reg']) || $_SESSION['reg'] == "")
    {
        $ruser = "cart";
    } else
    {
        $ruser = $_SESSION['reg'];
    }

    $total = 0;

    foreach ($_COOKIE as $k => $v)
    {
        $pos = strpos($k, "_");
        if (substr($k, 0, $pos) == $ruser)
        {
            echo  "9";
            $id = substr($k, $pos + 1);
            $item = Item::Show($id);
            $total += $item->price_sale;
            $item->DrawForCart();
        }
    }

    echo '<hr>';
    echo "<span>Total cost is: </span> <span>" . $total . "</span>";
    echo '<button type="submit" class="btn btn-success" name="suborder" style="margin-left: 150px:">Purchase order</button>';
    echo '</form>';

    if (isset($_POST['suborder']))
    {
        foreach ($_COOKIE as $k => $v)
        {
            $pos = strpos($k, "_");
            if (substr($k, 0, $pos) == $ruser)
            {
                $id = substr($k, $pos + 1);
                $item = Item::Show($id);
                $item->Sale();

            }
        }
        echo "<script>";
        echo "function DeleteAll(uname){";
?>


        let theCookies = document.cookie.split(";");
        for (let i =1; i<=theCookies.length; i++)
        {
            if (theCookies[i-1].indexOf(uname) === 1)
            {

                let theCookie=theCookies[i-1].split('=');
                let date = new Date(new Date().getTime()-60000);
                document.cookie= theCookie[0]+"=id; path=/; expires=" + date.toUTCString();
            }
        }

}
<?php
        echo "DeleteAll('$ruser');";
        echo "window.location=document.URL;";
        echo "</script>";
    }
?>

<script >
    function createCookie(uname, id) {
        let date = new Date(new Date().getTime() + 60 * 1000 * 30);
        document.cookie = uname + "=" + id+"; path=/;expires=" + date.toUTCString();
    }

    function eraseCookie(uname)
    {
        let theCookies = document.cookie.split(';');
        for (let i = 1; i<= theCookies.length; i++)
        {
            if (theCookies[i-1].indexOf(uname) === 1)
            {
                let theCookie = theCookies[i-1].split('=');
                let date = new Date(new Date().getTime()-60000);
                document.cookie = theCookie[0]+"=id; path=/; expires=" +date.toUTCString();
            }
        }
    }
</script>