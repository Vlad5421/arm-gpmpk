<?php
error_reporting(-1);
// Файлы phpmailer
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

// Переменные, которые отправляет пользователь
// $name = $_GET['fiorod'];
// $email = $_GET['email'];
// $id_card = $_GET['id_card'];
//$text = $_POST['message'];
// $file = $_FILES['myfile'];

// Формирование самого письма
$title = "Документы онлайн ГПМПК";
// $body = "
// <h2>Подача документов на ГПМПК онлайн</h2>
// <b>Имя:</b> $name<br>
// <b>Почта:</b> $email<br><br>
// <b>Сообщение:<br>
// <b>Заявка: $id_card<b><br>
// Ваша заявка на ГПМПК г. Омска отклонена. Заявка не содержит необходимых документов и/или документы оформлены не в соответствии с требованиями утвержденного перечня и форм документов для прохождения комиссии. Для дозагрузки документов в свой  архив на ГПМПК г. Омска необходимо перейти по ссылке:
// <br>https://гпмпк.рф<br>
// авторизоваться по номеру телефона, указанного в заявке, внизу страницы выбрать ранее созданную заявку и
// дозагрузить необходимый (ые) документ (ы), оформленные в соответствии с утвержденными требованиями.
// С уважением, ГПМПК г. Омска.
// <hr>
// Если Вы не подавали документы на ГПМПК г. Омска, пожалуйста проигнорируйте это сообщение. Оно пришло Вам ошибочно.
// ";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
  $mail->isSMTP();
  $mail->CharSet = "UTF-8";
  $mail->SMTPAuth   = true;
  //$mail->SMTPDebug = 2;
  $mail->Debugoutput = function ($str, $level) {
    $GLOBALS['status'][] = $str;
  };

  // Настройки вашей почты
  $mail->Host       = 'smtp.mail.ru'; // SMTP сервера вашей почты
  $mail->Username   = 'pochta@mail.ru'; // Логин на почте
  $mail->Password   = '343434343-'; // Пароль на почте
  $mail->SMTPSecure = 'ssl';
  $mail->Port       = 465;
  $mail->setFrom('pochta@mail.ru', 'ГПМПК г.Омска'); // Адрес самой почты и имя отправителя

  // Получатель письма
  $mail->addAddress("$email");
  // $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

  // Прикрипление файлов к письму
  // if (!empty($file['name'][0])) {
  //     for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
  //         $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
  //         $filename = $file['name'][$ct];
  //         if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
  //             $mail->addAttachment($uploadfile, $filename);
  //             $rfile[] = "Файл $filename прикреплён";
  //         } else {
  //             $rfile[] = "Не удалось прикрепить файл $filename";
  //         }
  //     }   
  // }
  // Отправка сообщения
  $mail->isHTML(true);
  $mail->Subject = $title;
  $mail->Body = $body;

  // Проверяем отравленность сообщения
  if ($mail->send()) {
    $result = "success";
  } else {
    $result = "error";
  }
} catch (Exception $e) {
  $result = "error";
  $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}
echo '<br>вот проверочная строка<br>';
// Отображение результата
var_dump(json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]));
