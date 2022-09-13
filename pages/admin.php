<form action="index.php?pages=2" method="post" enctype="multipart/form-data">
    <label for="">Катнгория</label>
    <select name="cat_id">

        <?php
            $pdo = Tools::Connect();
            $list = $pdo->query("select * from categories");
            while ($row = $list->fetch())
            {
                echo '<option value="' . $row['id'] . '">' . $row['category'] . '</option>';
            }
        ?>
    </select>
    <div class="form-group">
        <label for="item_name">Name</label>
        <input type="text" class="" name="item_name">
    </div>
    <div class="form_group">
        <input type="number" name="price_in">
        <input type="number" name="price_sale">
    </div>
    <div class="form-group">
        <label for="info">Описание</label>
        <div>
            <textarea name="info" id="" cols="30" rows="10"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="image_path">Выбери картинку:</label>
        <input type="file" name="image_path">
    </div>
    <button type="submit" class="btn btn-primary" name="add">Добавить</button>
</form>

<?php
    if (isset($_POST['add']))
    {
        $path = "";
        if (is_uploaded_file($_FILES['image_path']['tmp_name']))
        {
            $path = "images/" . $_FILES['image_path']['name'];
            move_uploaded_file($_FILES['image_path']['tmp_name'], $path);
        }
        $cat_id = $_POST['cat_id'];
        $price_in = $_POST['price_in'];
        $price_sale = $_POST['price_sale'];
        $item_name = trim(htmlspecialchars($_POST['item_name']));
        $info = trim(htmlspecialchars($_POST['info']));
        $item = new Item($item_name, $cat_id, $price_in, $price_sale, $info, $path);
        $item->Add();
    }
?>






















