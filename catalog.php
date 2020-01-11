<form method='POST'>
<table border='1' width='300'>
    <tr>
        <th width='30%'>Продукт</th>
        <th width='20%'>Страна</th>
        <th width='20%'>Описание</th>
        <th width='10%'></th>
    </tr>
<?php
$dbh = ibase_connect($host, $user, $pass);
//Инициализация переменных
//$product = "";
//$country = "";
//$description = "";
//$uploadlink = "";
if (isset($_POST['delete']) && isset($_POST['cbs'])) {
    $cbs = $_POST['cbs'];
    $count = count($_POST['cbs']);
    for ($i = 0; $i < $count; $i++) {
        $del = $cbs[$i];
        $result = ibase_query($dbh, "SELECT * FROM ITEMS WHERE ID='$del'") or die("Сбой при доступе к БД: " . ibase_errmsg());
        $row = ibase_fetch_row($result);
        if (!empty($row[4])) {
            unlink($row[4]);
        }
        ibase_query($dbh, "DELETE FROM ITEMS WHERE ID='$del'") or die("Сбой при доступе к БД: " . ibase_errmsg());
    }
}
$query = "SELECT * FROM ITEMS ORDER BY PRODUCT";
$result = ibase_query($dbh, $query) or die ("Сбой при доступе к БД: " . ibase_errmsg());
while ($row = ibase_fetch_row($result))
    echo "<tr>
<td><a href='index.php?page=item&id=$row[0]'>$row[1]</a></td>
<td>$row[2]</td>
<td>$row[3]</td>
<td>
<input type='checkbox' name='cbs[]' value=$row[0] />
</td></tr>"
?>
</table>
<br/>
<input id='delete' type='submit' class='button' name='delete' value='Удалить' style="float:left;margin-right:40px"/>
</form>
<button onclick="location.href='index.php?page=add';">Добавить</button>