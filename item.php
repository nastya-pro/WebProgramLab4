<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $id = clearData($_GET['id']);
    $dbh = ibase_connect($host, $user, $pass);
    $query = "SELECT * FROM ITEMS WHERE id='$id'";
    $result = ibase_query($dbh, $query) or die("Сбой при доступе к БД: " . ibase_errmsg());
    $row = ibase_fetch_row($result);
}
?>
<br/>
<a href='index.php?page=catalog' style='margin-left:40px'>Назад</a>
<a href='index.php?page=edit&id=<?=$row[0]?>' style='margin-left:20px'>Редактировать</a>
<br/><br/>
<table class="data_table" border="1">
    <tr>
        <th width="20%" bgcolor="#ff7f50">Продукт</th>
        <td colspan="2" width="45%" style="padding:0px 0px 0px 5px;"><?= $row[1] ?></td>
        <td rowspan="6"><img src="<?= $row[4] ?>" width="100%" height="100%"></td>
    </tr>
    <tr>
        <th width="15%" bgcolor="#ff7f50">Страна</th>
        <td colspan="2" style="padding:0px 0px 0px 5px;"><?= $row[2] ?></td>
    </tr>
    <tr height="250">
        <th width="15%" bgcolor="#ff7f50">Описание</th>
        <td colspan="2" style="padding:0px 0px 0px 5px;"><?= $row[3] ?></td>
    </tr>
</table>
<br/>
