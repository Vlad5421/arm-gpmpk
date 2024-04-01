<?php
error_reporting(-1);
session_start();
require_once('../../pwd/connect.php');
require_once('../../class/Card.php');

$card1 = new ListMaker();
$card = new Card();

if (isset($_GET['time_str'])) {
    $time_str = htmlspecialchars($_GET['time_str']);
} elseif (isset($_POST['time_str'])) {
    $time_str = $_POST['time_str'];
}



if (!empty($card->post_rm['id_fil']) && $card->post_rm['id_fil'] < 3) {
    $address = 'пр-т Мира, д.165А';
} else {
    $address = 'ул. Куйбышева, д.27/7';
}

$data = $card->get_parrent_email_from_idcard();
$id_card = $data[0];
$parr_name = $data[1]['fiorod'];
$comment = $data[2];
$email = $data[1]['email'];


if ($card->post_rm['new_status'] == 'rejected') {
    // Текст письма для rejected
    $body = "
<h2>Подача документов на ГПМПК онлайн</h2>
<b>Имя:</b> $parr_name<br>
<b>Почта:</b> $email<br><br>
<b>Сообщение</b>:<br>
<b>Заявка: $id_card</b><br>
Ваша заявка на ПМПК г. Омска отклонена.
<hr>
<br> Комментарий проверяющего:<br>
$comment <br><br>
<hr>
Заявка не содержит необходимых документов и/или документы оформлены не в соответствии с требованиями утвержденного перечня и форм документов для прохождения комиссии. Для дозагрузки документов необходимо перейти по ссылке:
<br>https://гпмпк.рф<br>
авторизоваться, в ашем профиле зайти в раздел \"Мои заявки\", выбрать ранее созданную заявку и
дозагрузить необходимый (ые) документ (ы), оформленные в соответствии с утвержденными требованиями.<br>
С уважением, ГПМПК г. Омска.
<hr>
Если Вы не подавали документы на ГПМПК г. Омска, пожалуйста проигнорируйте это сообщение. Оно пришло Вам ошибочно.
";
    $mess = ($card->change_status()) ? 'Заявка отклонена' : 'Ошибка изменения статуса';
} elseif ($card->post_rm['new_status'] == 'in_queue') {
    $body = "
<h2>Подача документов на ГПМПК онлайн</h2>
<b>Имя:</b> $parr_name<br>
<b>Почта:</b> $email<br><br>
<b>Сообщение:</b><br>
<b>Заявка: $id_card</b><br>
Ваша заявка на ПМПК г. Омска Принята.
<hr>
Дата комиссии: " . DateTime::createFromFormat('Y-m-d', $card->post_rm['date'])->format('d.m.Y') . ",<br>
назначенное время: $time_str,<br>
Адрес: $address,
<br>
Внимание!!! Для прохождения ПМПК при себе необходимо иметь все документы, копии которых были загружены онлайн.<br>
При отсутствии документов комиссия проведена не будет!
<br>--<br>
С уважением, ГПМПК г. Омска.
<hr>
Если Вы не подавали документы на ГПМПК г. Омска, пожалуйста проигнорируйте это сообщение. Оно пришло Вам ошибочно.
";
    $mess = ($card->new_queue()) ? 'Заявка записана' : ($card->new_queue());
}


require_once 'send.php';

header("Location: ../../arm.php?mess=$mess");
