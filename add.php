<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['product']) && !empty($_POST['country']) && !empty($_POST['description'])) {
        $product = clearData($_POST['product']);
        $dbh = ibase_connect($host, $user, $pass);
        $total_items = ibase_fetch_row(ibase_query("SELECT COUNT(*) FROM ITEMS WHERE product='$product'"));
        if ($total_items[0] < 1) {
            $country = clearData($_POST['country']);
            $description = clearData($_POST['description']);
            $uploadlink = uploadImage();
            $query = "INSERT INTO ITEMS (PRODUCT,COUNTRY,DESCRIPTION,IMAGE) VALUES ('$product','$country','$description','$uploadlink')";
            ibase_query($dbh, $query) or die ("Сбой при доступе к БД: " . ibase_errmsg());
            header("Location: index.php?page=catalog");
        } else echo 'Такой продукт уже добавлен';
    } else echo 'Полностью заполните форму';
}
?>
<form method='POST' action='index.php?page=add' enctype="multipart/form-data">
    <p>Продукт:<input type='text' name='product'></p>
    <p>Страна:<input type='text' name='country'></p>
    <p>Описание:<input type="text" name="description"></p>
    <p>Изображение: <input type='file' name='uploadfile' accept="image/jpeg"></p>
    <p><input type='submit' value='Добавить'></p>
</form>

