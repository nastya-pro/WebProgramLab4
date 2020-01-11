<?php
$file_path = 'img/';
$id = clearData($_GET['id']);
$dbh = ibase_connect($host, $user, $pass);
$result = ibase_query($dbh, "SELECT * FROM ITEMS WHERE id='$id'") or die ("Сбой при доступе к БД: " . ibase_errmsg());
$row = ibase_fetch_row($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['product']) && !empty($_POST['country']) && !empty($_POST['description'])) {
        $product = clearData($_POST['product']);
        $total_items = ibase_fetch_row(ibase_query("SELECT COUNT(*) FROM ITEMS WHERE PRODUCT='$product' AND id<>'$id'"));
        if ($total_items[0] < 1) {
            $country = clearData($_POST['country']);
            $description = clearData($_POST['description']);
            if (($product <> $row[1]) or (!empty($_FILES['uploadfile']['name']))) {
                if ($product <> $row[1]) {
                    rename($row[4], $file_path . $product . '.jpg');
                }
                $uploadlink = uploadImage();
                $query = "UPDATE ITEMS SET PRODUCT='$product',COUNTRY='$product',DESCRIPTION='$description',IMAGE='$uploadlink' WHERE id='$id'";
            } else {
                $query = "UPDATE ITEMS SET PRODUCT='$product',COUNTRY='$product',DESCRIPTION='$description'WHERE id='$id'";
            }
            ibase_query($dbh, $query) or die ("Сбой при доступе к БД: " . ibase_errmsg());

            header("Location: index.php?page=catalog");
        } else echo 'Такой продукт уже добавлен';
    } else echo 'Полностью заполните форму';
}
?>

<h3>Редактировать продукт</h3>
<table align='center'>
    <tr>
        <td>
            <form method='POST' ENCTYPE='multipart/form-data'>
                <p>Продукт:<input type='text' name='product' value='<?= $row[1] ?>'></p>
                <p>Страна:<input type='text' name='country' value='<?= $row[2] ?>'></p>
                <p>Описание:<textarea name='description' cols='70' rows='10'
                                      style='resize:none'><?= $row[3] ?></textarea></p>
                <p>Изображение: <input type='file' name='uploadfile' accept="image/jpeg"></p>
                <p><input type='submit' value='Сохранить'></p>
            </form>
        </td>
    </tr>
</table>