<?php
error_reporting(-1);
// Файлы phpmailer
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

// Формирование самого письма
$title = "Документы онлайн ГПМПК";

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
  $mail->Username   = 'pmpk_omsk@mail.ru'; // Логин на почте
  $mail->Password   = '2eMZkH6EbpjygZy5HFt9'; // Пароль на почте
  $mail->SMTPSecure = 'ssl';
  $mail->Port       = 465;
  $mail->setFrom('pmpk_omsk@mail.ru', 'ГПМПК г.Омска'); // Адрес самой почты и имя отправителя

  // Получатель письма
  $mail->addAddress("$email");
  // $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

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
// echo '<br>вот проверочная строка<br>';
// Отображение результата
// echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);
