<?php
require_once 'logik/appointment_logik.php';

echo $call_d . '<br>';
echo $first_d;
?>



<div class="card_block" style="display: block;">
    <div>
        <?php if (false) : ?>
            <br>количество дней в текущем месяце - <?= $call_d ?>
            <br>день недели первый день месяца - <?= $first_d ?><br>
            Дата: <?= $d . '.' . $m . '.' . $y ?><br>
            Филиалы<br>
            составы комиссий на филиалах<br>

            для каждого состава нужно:<br>
            количество возможных записей и их "время" - формируем сетку<br>
            заняты и свободные времена<br>
        <?php endif; ?>
        <div id="calendar_wrap">
            <div class="calendar">
                <?php
                $i = 1;
                $den = function ($e) {
                    global $m;
                    global $y;
                    return str_pad($e, 2, '0', STR_PAD_LEFT) . "." . $m . "." . $y;
                };
                $str_cal = function ($e) {
                    global $den;
                    global $d;
                    global $m;
                    global $y;
                    global $link_str;
                    global $j;
                    $class = ($e == $d) ? "days_now" : "days";
                    $red_class = (($j % 7) == 0) ? 'class = "red_day"' : '';
                    return "<a href='$link_str&d=$e&m=$m&y=$y'><div id=\"$class\" $red_class>" . $den($e) . "<br>Занято: " . zapisiFromDate($e, $m, $y) . "</div></a>";
                };

                echo '<div id="calendar_row_wrap">';
                echo '<div id="calendar_row">';
                echo "<div class=\"red_day\">Воскресенье</div>";
                echo "<div id=\"days_w\">Понедельник</div>";
                echo "<div id=\"days_w\">Вторник</div>";
                echo "<div id=\"days_w\">Среда</div>";
                echo "<div id=\"days_w\">Четверг</div>";
                echo "<div id=\"days_w\">Пятница</div>";
                echo "<div id=\"days_w\">Суббота</div>";
                echo "</div>";
                echo '<div id="calendar_row">';
                for ($j = 0; $j <= ($call_d + $first_d - 1); $j++) {
                    if ($j < $first_d and $first_d != 0) {
                        echo "<div id=\"days\">__</div>";
                    } else {
                        if ((($j + 1) % 7) == 0) {
                            echo $str_cal($i) . "</div>";
                            echo '<div id="calendar_row">';
                            $i++;
                        } else {
                            echo $str_cal($i);
                            $i++;
                        }
                        if ($j == ($call_d + $first_d - 1)) {
                            echo '</div>';
                        }
                    }
                }
                // Блок перемотки месца и даты
                echo "<a href='$link_str&m=" . ($m - 1) . "&y=$prev_y'><<Предыдущий месц<<</a> || ";
                echo "<a href='$link_str&d=$prev_d&m=$prev_m&y=$prev_y'>$prev_d.$prev_m.$prev_y</a> ---<b> $d.$m.$y </b>--- <a href='$link_str&d=$n_d&m=$n_m&y=$n_y'>$n_d.$n_m.$n_y</a>";
                echo " || <a href='$link_str&m=" . ($m + 1) . "&y=$n_y'>>>Следующий месяц>></a>";
                echo '</div>'; // Закрывается calendar_row_wrap
                echo "<hr>";

                // Вставляем времена для записи
                $date = $y . "-" . $m . "-" . $d;
                $times = get_tim();

                // Перебор адресов
                foreach (get_adrs() as $k => $v) {
                    echo $adr_adr = $v['address'] . "<br>";
                    $fil_to_adr = get_fil_to_adr($v['id']);
                    // Перебор филиалов (составов) по адресам
                    foreach ($fil_to_adr as $k1 => $fili) {
                        echo "<div class=\"time_row\">";
                        echo "<div class=\"time_row_head\">";
                        echo $fili['name'] . "<br>";
                        $zap = queue_to_fil($date, $fili['id']); // записи на филиале в дату
                        echo "Всего записей " . $zap['count'] . "<br>";
                        echo "</div>";
                        $br = 1;
                        echo '<div iclass="zapisi_wrap"><div class="zapisi_line">';
                        foreach ($times as $key => $time) {
                            if (!false == ($z = check_queue($date, $fili['id'], $time['id']))) {
                                echo '<div class="zapisi_done">';
                                echo $time['time_start'] . "-" . $time['time_end'] . "<hr>" . $z['id_card'];
                                echo "</div>";
                            } else {
                                echo '<div class="zapisi">';
                                echo $time['time_start'] . "-" . $time['time_end'] . "<hr>";
                                echo "<a href=\"?page=appointment_end&new_status=in_queue&date=" . $date . "&time_id=" . $time['id'] . "&time_str=" . $time['time_start'] . "-" . $time['time_end'] . "&fil_id=" . $fili['id'] . "&fil_name=" . $fili['name'] . "&id_card=" . $list->get_rm['id_card'] . "\">Записать</a>";

                                echo "</div>";
                            }

                            echo ($br % 2 == 0) ? '</div><div class="zapisi_line">' : null;
                            $br++;
                        }
                        echo "</div>"; //zapisi_line
                        echo "</div>"; //zapisi_wrap
                        echo "</div>"; // time_row
                    }
                }
                ?>
                <!-- Конец блока с временами для записи -->
            </div>
        </div>
    </div>
</div>