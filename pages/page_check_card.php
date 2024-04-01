<?php

// echo 'Это страница проверки карточки записи и принятия решения<br><br>';
$checked_param = $list->make_checked_card($list->get_rm['id_card']);
$card = $checked_param['card'];
$parrent = $checked_param['parrent'];
$files = $checked_param['files'];
$doc_source = $checked_param['doc_source'];
// var_dumpe($files);
// var_dumpe($doc_source);
$status_str = $checked_param['status_str'];
if($checked_param['queue']){
    $card_queue = [];
    $card_queue['date'] = DateTime::createFromFormat('Y-m-d', $checked_param['queue']['date'])->format('d.m.Y');
    $card_queue['time'] = $checked_param['queue']['time']['time_start'];
}

// var_dumpe($card_queue['time']);

$pred_pmpk = $card['datepredpmpk'] != '0000-00-00' ? DateTime::createFromFormat('Y-m-d', $card['datepredpmpk'])->format('d.m.Y') : '-';
$card_created = DateTime::createFromFormat('Y-m-d H:i:s', $card['date'])->format('d.m.Y');
// var_dumpe($card_created);
?>

<div class="card_block">
    <div class="list_block_data ">

        <b>Номер заявки: <?= $card['id'] ?></b><br>
        <hr>
        ФИО ребенка: <?= nl2br(htmlspecialchars($card['fioreb'])) ?><br>
        Дата рождения: <?= DateTime::createFromFormat('Y-m-d', $card['dateroj'])->format('d.m.Y') ?><br>
        Орган направивший на ПМПК: <?= nl2br(htmlspecialchars($card['organnapr'])) ?><br>
        Цель ПМПК: <?= nl2br(htmlspecialchars($card['prich'])) ?><br>
        Образовательная организация: <?= nl2br(htmlspecialchars($card['school'])) ?><br>
        Класс/группа: <?= nl2br(htmlspecialchars($card['class'])) ?><br>
        Дата прохождения прошлого ПМПК: <?= $pred_pmpk ?><br>
        Наименование предыдущего ПМПК: <?= nl2br(htmlspecialchars($card['namepredpmpk']))   ?><br>
        Текущий статус: <span style="font-size: 15px; color:crimson; font-weight: bold;"><?= $status_str ?></span><br>
        Заявка создана: <span style="font-size: 15px; font-weight: bold;"><?= $card_created ?></span><br>
        <?php if ($checked_param['queue']) : ?>
            ПМПК назначено на: <span style="font-size: 15px; font-weight: bold;"><?= $card_queue['date'] ?></span>||<span style="font-size: 15px; font-weight: bold;"><?= $card_queue['time'] ?></span><br>
        <?php endif; ?>

    </div>

    <div class="list_block_data">
        <b>Данные родителя / законного представителя:</b><br>
        <hr>
        ФИО родителя: <?= nl2br(htmlspecialchars($parrent['fiorod'])) ?><br>
        Телефон: <?= nl2br(htmlspecialchars($parrent['number'])) ?><br>
        E-mail: <?= nl2br(htmlspecialchars($parrent['email'])) ?><br>

    </div>
</div>

<!-- ******НАЧАЛО БЛОКА С ФАЙЛАМИ***** -->
<div class="card_block">
    <div><b>Список файлов:</b><br>
        <?php echo $doc_source ? "<b>Источник файлов: архив</b><br>" : "<b>Источник файлов: веб-сервер</b><br>"; ?>
        <? if ($files) :?>

            <?php $url = $doc_source == "archive" ? "https://cloud.psygorodomsk.ru/" : ""; ?>
            <?php foreach ($files as $key => $value) : ?>
                <a href="<?= $url.$value ?>"><?= $value ?></a><br>
            <?php endforeach; ?>
        <? endif; ?>
        <br>
        <hr>

        <br> 1) Файлы с расширением PDF в слайдере не отображаются!
        <br> 2) Если навести курсор на изображение - автопрокрутка остановится.
        <br>
        <hr>
            Принять заявку и записать на ПМПК: <br>
        <a href="?page=appointment&id_card=<?= $card['id'] ?>" class="btn btn-success"><b>Записать заявку</b></a>
        <button id="reject_card_btn" class="btn btn-warning">отклонить</button>
        <hr>
        <!-- Форма для отклонения заявки -->
        <div id="reject_card">
            <form action="/do/card/change_status.php" method="post">
                <legend>Причины отклонения:</legend>
                <div class="form-group">
                    <label for="id_card">Номер заявки</label>
                    <input type="text" class="form-control" name="id_card" value="<?= $card['id'] ?>" readonly></input>
                </div>
                <div class="form-group unvisible">
                    <label for="new_status">новый статус</label>
                    <input type="hidden" class="form-control" name="new_status" value="rejected" readonly></input>
                </div>
                <div class="form-group">
                    <label for="comment">Комментарии</label>
                    <textarea class="form-control" name="comment" rows="5"></textarea>
                </div>

                <button type="submit" class="btn btn-warning">Отправить и отклонить</button>
            </form>
        </div>
        <!-- Конец формы для отклонения заявки -->


    </div>

    <!-- СЛАЙДЕР -->
    <?php
    if (!false == $files) {
        echo '<div id="carouselExampleIndicators" class="carousel slide"  data-interval="6000">'; // data-ride="carousel"
        echo '<ol class="carousel-indicators">';
        
        foreach ($files as $key => $value) {
            if ($key == 0) {
                echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $key . '" class="active"></li>';
            } else {
                echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $key . '"></li>';
            }
        }
        echo '</ol>';
        echo '<div class="carousel-inner" role="listbox">';
        foreach ($files as $key => $value) {
            if ($key == 0) {
                echo '<div class="carousel-item active" style="">';
                echo '<img src="' . $url.$value . '" class="d-block w-100" alt="img">';
                echo '</div>';
            } else {
                echo '<div class="carousel-item" style="">';
                echo '<img src=" ' . $url.$value . '" class="d-block w-100" alt="img">';
                echo '</div>';
            }
        }
        echo '</div>';

        echo '<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">';
        echo '    <span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '    <span class="sr-only">Previous</span>';
        echo '</a>';
        echo '<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">';
        echo '    <span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '    <span class="sr-only">Next</span>';
        echo '</a>';
        echo '</div>';
    } else {
        echo '<b> Для данной заявки файлы не загружены</b>';
    }

    ?>
    <!-- КОНЕЦ СЛАЙДЕРА -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="js/rejectCard.js"></script>
