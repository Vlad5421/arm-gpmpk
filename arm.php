<?php
#error_reporting(-1);
session_start();
require_once('pwd/connect.php');
require_once('class/ListMaker.php');
require_once 'class/Card.php';

// print_arr($_SESSION);


$list = new ListMaker();

// echo 'get_page()';
// var_dumpe($list->get_page());
// echo 'get_stat()';
// var_dumpe($list->get_stat());
// echo '$get_rm';
// var_dumpe($list->get_rm);

$mess = (isset($_GET['mess'])) ? $_GET['mess'] : NULL;
//$stule = file_get_contents('css/bootstrap.min.css');
//$stule1 = file_get_contents('css/arm.css');

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="/css/arm.css" rel="stylesheet" type="text/css">


    <meta charset="UTF-8">
    <title>Управление заявками ПМПК</title>
</head>

<body>
    <div class="mywrapper">
        <!--  Вставили верхнее меню  -->
        <?php include_once "blocks/menu_arm.html" ?>
        <div class="telo">
            <!--  Вставили левое меню  -->
            <div class="left_nav">
                <?php
                    if ($_SESSION['user']) {
                        include_once "blocks/left_arm.html";
                    }
                    
                ?>
            </div>
            <div class="workspace">
                <?= $mess ?>
                <?php require_once $list->get_page() ?>

            </div>
        </div>
        <!-- Вставили футер -->
        <?php include_once "blocks/footer.html" ?>
    </div>
</body>

</html>
