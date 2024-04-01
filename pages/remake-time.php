<?php

require_once "class/TimeRemaker.php";
// Тайм мейкер
$tm = new TimeRemaker($bz);

if (isset($_GET['id']) && $_GET['id'] != null ){
    $tm->setMakingTime($_GET['id']);
    $time = $tm->getMakingTime();
    $method = "remakeTime";
} else {
    $method = "makeNewTime";
}

if (!empty($_POST)){
    $rez = $tm->$method($_POST['time1'], $_POST['time2']);
    $timeMaked = "yes";
}

?>

<?php if($timeMaked == "yes"): ?>
<div class="alert alert-success">"Элемент расписания изменён. <a href="/?page=list-times" style="color: white"><b>Проверить</b></a></div>
<?php endif;?>
<div class="card_block"">
    <form method="post">
        <legend>Изменение элемнта расписания: <?php echo $time["time_start"]; ?> - <?php echo $time["time_end"];?></legend>
        <div class="form-group">
            <label for="time1">Введите время начала:</label>
            <input type="text" name="time1" class="form-control" id="time1" aria-describedby="time1" placeholder="пример 9:00" required>
        </div>
        <div class="form-group">
            <label for="time2">Введите время окончания:</label>
            <input type="text" name="time2" class="form-control" id="time2" aria-describedby="time2" placeholder="пример 9:40" required>
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
</div>
