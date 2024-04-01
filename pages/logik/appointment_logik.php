<?php
error_reporting(-1);

// echo 'Это страница проверки карточки записи и принятия решения<br><br>';
$checked_param = $list->make_checked_card($list->get_rm['id_card']);
$card = $checked_param['card'];
$parrent = $checked_param['parrent'];
$files = $checked_param['files'];
$status_str = $checked_param['status_str'];

$pred_pmpk = $card['datepredpmpk'] != '0000-00-00' ? DateTime::createFromFormat('Y-m-d', $card['datepredpmpk'])->format('d.m.Y') : '-';

//////////////////////////////
// Логика для календаря
/////////////////////////////

$link_str = "?page=" . $list->get_rm['page'] . "&id_card=" . $list->get_rm['id_card'];
// var_dumpe($list->get_rm);
$m = (isset($_GET['m'])) ? $_GET['m'] : date('m');
$m = str_pad($m, 2, '0', STR_PAD_LEFT);
$y = (isset($_GET['y'])) ? $_GET['y'] : date('Y');
$y = str_pad($y, 2, '0', STR_PAD_LEFT);
$d = (isset($_GET['d'])) ? (($_GET['d'] <= cal_days_in_month(CAL_GREGORIAN, $m, $y)) ? $_GET['d'] : date('d')) : date('d');


$prev_y = ($m == 1  && $d == 1) ? ($y - 1) : $y;
$prev_m = ($d == 1) ? ((($m - 1) < 1) ? 12 : $m - 1) : $m;
$prev_d = ($d == 1) ? (cal_days_in_month(CAL_GREGORIAN, $prev_m, $y)) : ($d - 1);


$n_d = (($d + 1) > cal_days_in_month(CAL_GREGORIAN, $m, $y)) ? 1 : ($d + 1);
$n_m = ($n_d == 1) ? ((($m + 1) > 12) ? 1 : ($m + 1)) : $m;
$n_y = ($d == 31 && $m == 12) ? ($y + 1) : $y;


$call_d = cal_days_in_month(CAL_GREGORIAN, $m, $y);
$first_d = date("w", strtotime("$y-$m-1"));


///////////////////////////////////
// Логика для табло записей
/////////////////////////////////


function all_q_to_date($date)
{
    global $bz;
    $all_zap = $bz->prepare("SELECT COUNT(0) AS 'count_zap' FROM pmpk_queue WHERE `date` = ?");
    $all_zap->execute([$date]);
    $all_zap_row = $all_zap->fetch();
    return ($all_zap_row['count_zap']);
}
function queue_to_fil($date, $fil_id)
{
    global $bz;
    $count_zap = $bz->prepare("SELECT COUNT(0) AS 'count_zap' FROM pmpk_queue WHERE `date` = ? and id_filial = ?");
    $arr_zap = $bz->prepare("SELECT * FROM pmpk_queue WHERE `date` = ? and id_filial = ?");
    $count_zap->execute([$date, $fil_id]);
    $count_zap_row = $count_zap->fetch();

    $arr_zap->execute([$date, $fil_id]);
    $arr_zap_row = $arr_zap->fetchAll();

    return (array('count' => $count_zap_row['count_zap'], 'arr' => $arr_zap_row));
}
function get_tim()
{
    global $bz;
    $tim = $bz->query("SELECT * FROM pmpk_time");
    $tim->execute();
    $tim_row = $tim->fetchAll();
    return $tim_row;
}
function get_adrs()
{
    global $bz;
    $fils = $bz->query("SELECT * FROM pmpk_address");
    $fils->execute();
    $fils_row = $fils->fetchAll();
    return $fils_row;
}

function get_fil_to_adr($id_adr)
{
    global $bz;
    $fils = $bz->prepare("SELECT * FROM pmpk_filial WHERE `id_address` = ?");
    $fils->execute([$id_adr]);
    $fils_row = $fils->fetchAll();
    return $fils_row;
}
function check_queue($date, $fil, $id_time)
{
    global $bz;
    $queue = $bz->prepare("SELECT id_card FROM pmpk_queue WHERE `date` = :dates AND id_filial = :id_fil AND id_time = :id_time");
    $queue->execute([':dates' => $date, ':id_fil' => $fil, 'id_time' => $id_time]);
    $queue_row = $queue->fetch();
    return $queue_row;
}
function zapisiFromDate($d, $m, $y)
{
    global $bz;
    $data = $y . "-" . $m . "-" . $d;
    $count_queue = $bz->prepare("SELECT COUNT(0) AS 'count_queue' FROM pmpk_queue WHERE `date` = '$data'");
    $count_queue->execute();
    return $count_queue->fetch()['count_queue'];
}
