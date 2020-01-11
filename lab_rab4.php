<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<?php
//Параметры подключения
$user = "SYSDBA";
$pass = "masterkey";
$host = "localhost:C:\base.fdb";
//Создание БД
ibase_query(IBASE_CREATE, "CREATE DATABASE '$host' USER '$user' PASSWORD '$pass'");
ibase_close();
echo 'База данных успешно создана!</br>';
echo 'Структура базы данных:</br>';
$dbh = ibase_connect($host, $user, $pass);
//Начало транзакции
ibase_trans();
//Создание таблиц
ibase_query($dbh, "CREATE TABLE Purchase (name VARCHAR(20), cost INTEGER, customer VARCHAR(20), date_purchase TIMESTAMP)") or die ("Сбой при доступе к БД: " . ibase_errmsg());
ibase_query($dbh, "CREATE TABLE Customer (name VARCHAR(20), age SMALLINT, date_born DATE, address VARCHAR(50), phone CHAR(11))") or die ("Сбой при доступе к БД: " . ibase_errcode());
ibase_commit();
//Вывод информации о таблицах
getTableInfo($host, $user, $pass);
ibase_trans();
echo '</br>Измененная структура базы данных:</br>';
//Изменение структуры таблицы
ibase_query($dbh, "ALTER TABLE Purchase ADD weight SMALLINT");
ibase_query($dbh, "ALTER TABLE Customer DROP age");
ibase_commit();
//Вывод информации о таблицах
getTableInfo($host, $user, $pass);

//Заполнение таблиц данными
ibase_query($dbh, "INSERT INTO Purchase (name,cost, weight, customer,date_purchase) VALUES ('Колбаса','7000','10','Ильин','2019.10.15 12:45:12')");
ibase_query($dbh, "INSERT INTO Purchase (name,cost, weight, customer,date_purchase) VALUES ('Макароны','2800','7','Медведева','2019.08.15 16:35:40')");
ibase_query($dbh, "INSERT INTO Purchase (name,cost, weight, customer,date_purchase) VALUES ('Картофель','2000','50','Ильин','2019.10.21 08:41:33')");
ibase_query($dbh, "INSERT INTO Purchase (name,cost, weight, customer,date_purchase) VALUES ('Курица','2700','9','Арсеньев','2019.10.06 10:34:41')");
ibase_query($dbh, "INSERT INTO Purchase (name,cost, weight, customer,date_purchase) VALUES ('Торт','3000','6','Романова','2019.08.23 11:33:13')");
ibase_query($dbh, "INSERT INTO Purchase (name,cost, weight, customer,date_purchase) VALUES ('Вишня','3200','8','Романова','2019.09.23 15:27:18')");
ibase_query($dbh, "INSERT INTO Customer (name,address,date_born,phone) VALUES ('Ильин','Москва','1979.12.25','89205683591')");
ibase_query($dbh, "INSERT INTO Customer (name,address,date_born,phone) VALUES ('Медведева','Суздаль','1980.08.20','89105789356')");
ibase_query($dbh, "INSERT INTO Customer (name,address,date_born,phone) VALUES ('Арсеньев','Рязань','1993.03.10','89156793206')");
ibase_query($dbh, "INSERT INTO Customer (name,address,date_born,phone) VALUES ('Романова','Тула','1987.06.15','89158990063')");
//Вывод содержимого таблиц
echo "</br>Таблица Purchase:</br><table border='1' width='60%'>
	<tr>
		<th width='30%'>Название товара</th>
		<th width='15%''>Цена, руб</th>
		<th width='15%''>Вес</th>
		<th width='20%'>Имя покупателя</th>
		<th width='20%'>Дата покупки</th>
	</tr>";
$result = ibase_query($dbh, "SELECT * FROM Purchase") or die ("Сбой при доступе к БД: " . ibase_errmsg());
while ($row = ibase_fetch_row($result))
{
    echo "<tr>
		<td>$row[0]</td>
		<td>$row[1]</td>
		<td>$row[2]</td>
		<td>$row[3]</td>
		<td>$row[4]</td></tr>";
}
echo '</table>';
echo "</br>Таблица Customer:</br><table border='1' width='60%'>
	<tr>
		<th width='20%'>Имя</th>
		<th width='35%''>Адрес</th>
		<th width='20%'>Дата рождения</th>
		<th width='25%''>Телефон</th>
	</tr>";
$result = ibase_query($dbh, "SELECT * FROM Customer") or die ("Сбой при доступе к БД: " . ibase_errmsg());
while ($row = ibase_fetch_row($result))
{
    echo "<tr>
		<td>$row[0]</td>
		<td>$row[1]</td>
		<td>$row[2]</td>
		<td>$row[3]</td></tr>";
}
echo '</table>';

//Вывод результатов первого запроса
echo "</br>Запрос №1:</br><table border='1' width='60%'>
	<tr>
		<th width='45%'>Название товара</th>
		<th width='20%''>Цена, руб</th>
		<th width='35%'>Дата покупки</th>
	</tr>";
$result = ibase_query($dbh, "SELECT name,cost,date_purchase FROM Purchase WHERE customer='Ильин' AND date_purchase BETWEEN '2019-10-01' AND '2019-10-31' AND cost>=5000") or die ("Сбой при доступе к БД: " . ibase_errmsg());
while ($row = ibase_fetch_row($result))
{
    echo "<tr>
		<td>$row[0]</td>
		<td>$row[1]</td>
		<td>$row[2]</td></tr>";
}
echo '</table>';

//Вывод результатов второго запроса
echo "</br>Запрос №2:</br><table border='1' width='60%'>
	<tr>
		<th width='20%'>Имя</th>
		<th width='30%''>Телефон</th>
		<th width='20%'>Цена</th>
		<th width='30%'>Дата покупки</th>
	</tr>";
$result = ibase_query($dbh, "SELECT C.name,C.phone,P.Sum_purchase,P.Max_date FROM Customer C, (SELECT customer,SUM(cost),MAX(date_purchase) FROM Purchase GROUP BY customer) AS P (customer,Sum_purchase,Max_date) WHERE P.customer=C.name") or die ("Сбой при доступе к БД: " . ibase_errmsg());
while ($row = ibase_fetch_row($result))
{
    echo "<tr>
		<td>$row[0]</td>
		<td>$row[1]</td>
		<td>$row[2]</td>
		<td>$row[3]</td></tr>";
}
echo '</table>';

echo '</br>База данных успешно удалена!</br>';
//Удаление БД
ibase_drop_db();
?>