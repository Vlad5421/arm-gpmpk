<?php
require_once '../pwd/connect.php';
session_start();

function check_password($count_rows, $pass)
{
    // Проверяем пароль
    if (password_verify($pass, $count_rows['password'])) {
        unset($count_rows['password']);
        $_SESSION['user'] = $count_rows;
        $mes = 'lgoin_ok';
    } else {
        $mes = 'Неверный пароль.';
    }
    return $mes;
}


function login_user()
{
    global $bz;
    $login = $_POST['email'];
    $password = $_POST['password'];

    // Проверяем наличие пользователя с таким email-ом
    $count = $bz->prepare("SELECT COUNT(0) AS 'row_count' FROM users WHERE `email` = ?");
    $count->execute([$login]);
    $count_rows = $count->fetch();

    if ($count_rows['row_count'] > 0) {  // Если пользователь есть в БД
        // Получаем массив с данными юзера
        $count = $bz->prepare("SELECT * FROM users WHERE `email` = ?");
        $count->execute([$login]);
        $count_rows = $count->fetch();
        $message = check_password($count_rows, $password);  // Проверяем пароль
    } else {
        $message = 'Такого пользователя не существует.';
    }

    return $message;
}



$message = login_user();

header("Location: ../arm.php?mess=$message");
