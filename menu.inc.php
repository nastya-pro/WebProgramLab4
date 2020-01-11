<div class="left_menu">
    <?php $menu = array(
        "Главная" => "index.php?page=main",
        "ЛР1" => "index.php?page=1",
        "ЛР2" => "index.php?page=2",
        "ЛР3" => "index.php?page=3",
        "ЛР4" => "index.php?page=4",
        "Каталог" => "index.php?page=catalog");
    foreach ($menu as $link => $href) {
        echo "<li><a href=\"$href\">$link</a></li>";
    }
    ?>
</div>