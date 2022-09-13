<form action="index.php?pages=1" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <input class="form-control" type="text" name="userLogin" placeholder="Input Login">
    </div>
    <div class="form-group">
        <input class="form-control" type="password" name="userPass1" placeholder="Input Password">
    </div>
    <div class="form-group">
        <input class="form-control" type="password" name="userPass2" placeholder="Input Password again">
    </div>
    <div class="form-group">
        <input class="form-control" type="file" name="userImage" placeholder="Input Image">
    </div>
    <div class="form-group">
        <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
    </div>
    <div class="form-group">
        <input class="btn btn-success m-1" type="submit" name="UserClickSub" value="Create Account">
    </div>
</form>

<?php
if (isset($_POST['UserClickSub']))
{
    $login = $_POST['userLogin'];
    $login = trim($login);

    $pass1 = $_POST['userPass1'];
    $pass1 = trim($pass1);

    $pass2 = $_POST['userPass2'];
    $pass2 = trim($pass2);

    if ($pass1 != $pass2)
    {
        echo "<div>Password error</div>";
        exit();
    }

    if (is_uploaded_file($_FILES['userImage']['tmp_name']))
    {
        $path = "images/".$_FILES['userImage']['name'];
        move_uploaded_file($_FILES['userImage']['tmp_name'], $path);
        Tools::CreateUser($login, $pass1, $path);
    }
}





























