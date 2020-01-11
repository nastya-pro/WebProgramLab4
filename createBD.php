<?php
function createAutoincrement($dbh, $tablename, $primarykey) {
    ibase_query($dbh, 'CREATE GENERATOR GEN_' . $tablename . '_PK;');
    ibase_query($dbh, 'CREATE TRIGGER INC_' . $primarykey . ' FOR ' . $tablename
        . chr(13) . 'ACTIVE BEFORE INSERT POSITION 0'
        . chr(13) . 'AS'
        . chr(13) . 'BEGIN'
        . chr(13) . 'IF (NEW.' . $primarykey . ' IS NULL) THEN'
        . chr(13) . 'NEW.' . $primarykey . '= GEN_ID(GEN_' . $tablename . '_PK, 1);'
        . chr(13) . 'END');
}

$host = "localhost:".dirname(__FILE__)."\base.fdb";
$user = "SYSDBA";
$pass = "masterkey";
ibase_query(IBASE_CREATE, "CREATE DATABASE '$host' USER '$user' PASSWORD '$pass' DEFAULT CHARACTER SET WIN1251");
ibase_close();
$dbh = ibase_connect($host, $user, $pass);
ibase_trans();
ibase_query($dbh, "CREATE TABLE USERS (login VARCHAR(40) NOT NULL, password VARCHAR(50) NOT NULL, email VARCHAR(30))") or die ("Сбой при доступе к БД: " . ibase_errmsg());
ibase_query($dbh, "CREATE TABLE ITEMS (id INTEGER NOT NULL, product VARCHAR(20) NOT NULL, country VARCHAR(20), description VARCHAR(100), image VARCHAR(30))") or die ("Сбой при доступе к БД: " . ibase_errmsg());
createAutoincrement($dbh, "ITEMS", "id");
ibase_commit();
echo '</br>База данных успешно создана!</br>';
?>
