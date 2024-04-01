<?php
error_reporting(-1);
// Файлы phpmailer
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

// Переменные, которые отправляет пользователь
$name = $_SESSION['fiorod'];
$email = $_SESSION['email_parrent'];
//$text = $_POST['message'];
// $file = $_FILES['myfile'];

// Формирование самого письма
$title = "Документы онлайн ГПМПК";
$body = "
<h2>Подача документов на ГПМПК онлайн</h2>
<b>Имя:</b> $name<br>
<b>Почта:</b> $email<br><br>
<b>Сообщение:</b>Документы приняты в обработку ГПМПК г.Омска<br>
<hr>
Вы получили данное письмо, птому что подали документы на ПМПК онлай.<br>
Если Вы не подавали документы на ПМПК, пожалуйста проигнорируйте это сообщение. Оно пришло Вам ошибочно.

";

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
  $mail->Password   = '24324324-'; // Пароль на почте
  $mail->SMTPSecure = 'ssl';
  $mail->Port       = 465;
  $mail->setFrom('pochta@mail.ru', 'ГПМПК г.Омск'); // Адрес самой почты и имя отправителя

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

// Отображение результата
//echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);
