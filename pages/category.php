<form action="index.php?pages=3" method="post">
    <div class="row" style="margin-right: 10px;">
        <select name="catid" class="pull-right" onchange="getItemsCat(this.value)">
            <option value="0">Select category...</option>

            <?php
                $pdo = Tools::Connect();
                $ps = $pdo->prepare("select * from categories");
                $ps->execute();
                while ($row = $ps->fetch())
                {
                    echo '<option value="' . $row['id'] . '">' . $row['category'] . '</option>';
                }
            ?>
        </select>
    </div>

    <?php
        echo '<div class="row" id="result" style="margin-right: 10px;">';
        $items = Item::GetItems();
        foreach ($items as $item)
        {
            $item->Draw();
        }
        echo '</div>'
    ?>
</form>

<script>
    function getItemsCat(cat) {
        if (cat == "") {
            document.getElementById('result').innerHTML = "";
        }
        //creating AJAX object
        if (window.XMLHttpRequest)
            ajaxObj = new XMLHttpRequest();
        else {
            ajaxObj = new ActiveXObject('Microsoft.XMLHTTP');
        }
        ajaxObj.onreadystatechange = function () {
            if (ajaxObj.readyState == 4 && ajaxObj.status == 200) {
                document.getElementById('result').innerHTML = ajaxObj.responseText;
            }
        }

        //preparing post AJAX request
        ajaxObj.open('post', 'post/lists.php', true);
        ajaxObj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxObj.send("cat=" + cat);
    }

    function createCookie(uname, id)
    {
        let date = new Date(new Date().getTime()+60*1000*30);
        document.cookie = uname+"="+id"; path=/;expires=" + date.toUTCString();
    }
</script>