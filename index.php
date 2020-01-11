<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Дорога вкуса</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>
    <?php
    ob_start();
    header("Content-Type: text/html; charset=windows-1251");
    header("Cache-control: no-store");
    if (!isset($_COOKIE['dateVisit']))
    setcookie('dateVisit',date('Y-m-d H:i:s'),time()+0xFFFFFFF);
    ?>
</head>
<body>
<?php
require 'base_reg.php';
require 'lib.inc.php';
require 'auth.php';
$page = "";
if (!empty($_GET['page']))
    $page = $_GET['page'];
if ($page == 'reg')
{
    include 'registration.php';
    exit;
}
if (isset($_SESSION['user_login']) and $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) {
    require 'top.inc.php' ?>
    <div class="main">
        <?php require 'menu.inc.php' ?>
        <div class="content">
            <?php
            switch ($page) {
                case 'main':
                    include 'main.php';
                    break;
                case '1':
                    include 'lab_rab1.php';
                    break;
                case '2':
                    include 'lab_rab2.php';
                    break;
                case '3':
                    include 'lab_rab3.php';
                    break;
                case '4':
                    include 'lab_rab4.php';
                    break;
                case 'catalog':
                    include 'catalog.php';
                    break;
                case 'add':
                    include 'add.php';
                    break;
                case 'item':
                    include 'item.php';
                    break;
                case 'edit':
                    include 'edit.php';
                    break;
            }
            ?>
        </div>
    </div>
    <?php require 'bottom.inc.php';
}
?>
</body>
</html>
<?php
ob_end_flush();
?>
