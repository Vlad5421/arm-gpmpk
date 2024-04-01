<?php

require_once "class/TimeRemaker.php";
$tm = new TimeRemaker($bz);
$timeMake = "/?page=remake-time";
$i=0;
//require 'forms/list-times-form.php';
?>

<div class="card_block" style="flex-direction: column; justify-content: flex-start ">
<?php foreach ($tm->get_times()as $time): ?>
    <?php $i+=1; ?>
    <div class="zapisi" style="margin: 10px; display: inline-block; width: 15%">
        <a href="<?php echo $timeMake; ?>&id=<?php echo $time['id']; ?>"><?php echo $time["time_start"]; ?> - <?php echo $time["time_end"];?></a>
    </div>
    <?php if($i == 5){ echo "<br>"; $i=0;}?>
<?php endforeach; ?>
    <br>
    <a href="/?page=remake-time"><div id="days_w" style="width: max-content">+ Добавить новый</div></a>
</div>
