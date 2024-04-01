<?php

if (isset($_GET['serch_fioreb'])) {
    $serch_fioreb = ($_GET['serch_fioreb']);
} else {
    $serch_fioreb = null;
}
// Получаем параметры для списка из объекта $list (ListMaker)
$lister = $list->make_list_param($serch_fioreb);

// var_dumpe($lister);
?>
<div class="list_block">
    <form id="list_search" action="/arm.php">
        <legend><b>Поиск по фамилии:</b></legend>
        <hr>
        <label for="serch_fioreb">Введите фамилию:</label>
        <input type="text" name="serch_fioreb">
        <button type="submit">Найти</button>
    </form>
</div>

<div class="list_head_div">
    <?php if ($serch_fioreb == null) : ?>
        <span class="list_head">
            Заявки - <?= $list->get_stat()['str'] ?>: количество <?= count($lister) ?><br>
            <span class="list_head_mini">(период выборки - 3 месяца)</span>
        </span>
    <?php else : ?>
        <span class="list_head">Заявки содержащие - <?= $serch_fioreb ?>: количество <?= count($lister) ?></span>
    <?php endif ?>
</div>

<!-- Получаем и выводим все записи из PDOStatment -->
<?php foreach ($lister as $k => $v) : ?>
    <a class="list_a" href="?page=check_card&id_card=<?= $v['id'] ?>">
        <div class="list_block">

            Номер: <b><?= $v['id'] ?></b><br>
            ФИО ребенка: <?= $v['fioreb'] ?><br>
            Дата рождения: <?= DateTime::createFromFormat('Y-m-d', $v['dateroj'])->format('d.m.Y') ?><br>
            Цель ПМПК: <?= $v['prich'] ?><br>

        </div>
    </a>
<?php endforeach ?>