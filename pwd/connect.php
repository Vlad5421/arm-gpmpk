<?php

//VPS
$dsn = 'mysql:dbname=gpmpk;host=127.0.0.1;charset=UTF8';
$user = 'dbuser';
$password = '';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// local
// $dsn = 'mysql:dbname=gpmpk;host=127.0.0.1;charset=UTF8';
// $user = 'root';
// $password = '';
// $opt = [
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES   => false,
// ];

try {
    $bz = new PDO($dsn, $user, $password, $opt);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}



function var_dumpe($elem)
{
    echo ('<pre>');
    var_dump($elem);
    echo ('</pre>');
}
function print_arr($elem)
{
    echo ('<pre>');
    var_dump($elem);
    echo ('</pre>');
}
