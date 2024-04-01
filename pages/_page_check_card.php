<?php
error_reporting(-1);
require_once 'pwd/connect.php';
require_once 'funcs.php';

$inid = $_GET['id'];

if ($_GET['status_card'] == 'rejected') {
    $serch_table = 'zapis_card_rejected';
} elseif ($_GET['status_card'] == 'arhived') {
    $serch_table = 'zapis_card_arhiv';
} else $serch_table = 'zapis_card';

// Получаем из БД данные карточки записи
$row = mysqli_query($db, "SELECT * FROM $serch_table WHERE id = $inid");
$card_data = mysqli_fetch_array($row, MYSQLI_ASSOC);
// Получаем из БД ДАННЫЕ О РОДИТЕЛЕ
$id_p = $card_data['id_parrent'];
$query = "SELECT * FROM parrents WHERE id = '$id_p'";
$parrent_data = mysqli_fetch_array(mysqli_query($db, $query), MYSQLI_ASSOC);
?>
<div style="font-size: 14px; padding: 0 15px;">

    Запись номер: <?= $inid ?> ;<br>
    Дата записи: <?= date("d.m.Y", strtotime($card_data['date'])) ?><br>
    Запись офрмлена от имени: <?= $parrent_data['fiorod'] ?>;<br>
    Телефон: <?= $parrent_data['number'] ?> Email: <?= $parrent_data['email'] ?>;<br>

</div>
<div class="message">
    <div>ФИО ребенка: <?= nl2br(htmlspecialchars($card_data['fioreb'])) ?></div>
    <div>Дата рождения: <?= nl2br(htmlspecialchars($card_data['dateroj'])) ?></div>
    <div>Орган направивший на ПМПК: <?= nl2br(htmlspecialchars($card_data['organnapr'])) ?></div>
    <div>Причина направления на ПМПК: <?= nl2br(htmlspecialchars($card_data['prich'])) ?></div>
    <div>Образовательная организация: <?= nl2br(htmlspecialchars($card_data['school'])) ?></div>
    <div>Класс/группа: <?= nl2br(htmlspecialchars($card_data['class'])) ?></div>
    <div>Дата прохождения прошлого ПМПК: <?= nl2br(htmlspecialchars($card_data['datepredpmpk'])) ?></div>
    <div>Наименование предыдущего ПМПК: <?= nl2br(htmlspecialchars($card_data['namepredpmpk'])) ?></div>
</div>

<?php
// Проверка папка с файлами создана по номеру или по id
$dir = "files/" . $card_data['id_parrent'] . "/" . $inid;


// Вывод списка файлов для заявки
// $files = glob("$dir/*.*");
// foreach ($files as $file) {
//   echo basename($file) . "  --  <a href=\"" . $file . "\"> Перейти</a><br>";
// }

echo "<div style=\"font-size: 15px; margin: 5px 15px;\"> Всего загружено документов: " . count(glob("$dir/*.*")) . "</div>";


// Формируем циклический вывод файлов из папки с файлами
echo '<div class="polaroid">';
if (count(glob("$dir/*.*")) == '0') {
    echo '<hr><br>К данной заявке документов не загружено<br><hr>';
} else {
    foreach (glob("$dir/*.*") as $key => $file) {
        echo "<img src=\"$file\" alt=\"Скан документа\">";
    }
}
echo '<br><a href="forms_arm/do_arm/reject_scans.php?fiorod=' . $parrent_data['fiorod'] . '&email=' . $parrent_data['email'] . '&id_card=' . $inid . '"><b>отклонить и запросить сканы</b></a>';
echo "</div>";

?>
<hr>
<a href="arm.php?do=get_queue&address_id=1&id_card=<?= $inid ?>"><button class="button_form">Записать на Мира</button></a>
<a href="arm.php?do=get_queue&address_id=2&id_card=<?= $inid ?>"><button class="button_form">Записать на Куйбышева</button></a>
<a href="arm.php?do=del_duble&id_card=<?= $inid ?>"><button class="button_form">Удалить - это повтор</button></a>
<a href="forms_arm/do_arm/to_arhiv.php?id_card=<?= $inid ?>"><button class="button_form">Переместить в архив</button></a>

<br><a href=../<?= $dir ?>>Если изображений нет, нажмите СЮДА</a> <!-- </div> -->