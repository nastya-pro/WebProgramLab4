<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['login_reg']) && !empty($_POST['password_1']) && !empty($_POST['password_2']) && !empty($_POST['email'])) {
        if ($_POST['password_1'] == $_POST['password_2']) {
            $login_reg = clearData($_POST['login_reg']);
            $hash_password = md5(clearData($_POST['password_1']));
            $dbh = ibase_connect($host, $user, $pass);
            $email = $_POST['email'];
            $query = "INSERT INTO USERS (LOGIN,PASSWORD,EMAIL) VALUES ('$login_reg','$hash_password','$email')";
            if (ibase_query($dbh, $query)) header("Location: index.php");
            else echo "Сбой при вставке данных: " . ibase_errmsg();
        } else echo 'Пароли не совпадают';
    } else echo 'Полностью заполните форму';
}
?>

<div class="auth">
    <h3>Регистрация</h3>
    <table class="data_table">
        <tr>
            <td>
                <form method="POST">
                    <p>Логин: <input type="text" name="login_reg" style="margin-left:95px"></p>
                    <p>Пароль: <input type="password" name="password_1" style="margin-left:90px"></p>
                    <p>Повторите пароль: <input type="password" name="password_2" style="margin-left:16px"></p>
                    <p>Email: <input type="text" name="email" style="margin-left:105px"></p>
                    <p><input type="submit"></p>
                </form>
            </td>
        </tr>
    </table>
</div>