<?php

$zapis = new Card();
if ($_POST) {

    if ($zapis->new_queue()) {
        header('Location: ?mess="Записано"');
    } else {
        $id_card = $_POST['id_card'];
        header("Location: ?page=appointment&id_card=$id_card&mess=ошибка записи");
    }
}
// echo $zais->get_rm['date'];
$date1 = DateTime::createFromFormat('Y-m-d', $_GET['date'])->format('d.m.Y');
$date2 = DateTime::createFromFormat('d.m.Y', $date1)->format('Y-m-d');

?>
<div class="card_block">
    <form action="/do/card/change_status.php" method="post">
        <legend>Записать?</legend>
        <label for="id_card">Заявка: </label>
        <input name="id_card" type="number" value="<?= htmlspecialchars($_GET['id_card']) ?>" readonly>
        <br>
        <label for="id_fil">Состав: <?= htmlspecialchars($_GET['fil_name']) ?></label>
        <input name="id_fil" type="hidden" value="<?= htmlspecialchars($_GET['fil_id']) ?>" readonly>
        <br>
        <label for="date">Дата: </label>
        <input name="date" type="date" value="<?= $date2 ?>" readonly>
        <br>
        <label for="id_time">Время: <?= htmlspecialchars($_GET['time_str']) ?></label>
        <input name="id_time" type="hidden" value="<?= htmlspecialchars($_GET['time_id']) ?>" readonly>
        <br>
        <input name="time_str" type="hidden" value="<?= htmlspecialchars($_GET['time_str']) ?>" readonly>
        <br>
        <input name="new_status" type="hidden" value="in_queue" readonly>
        <br>
        <input type="submit" class="btn btn-success"></input>

    </form>

</div>