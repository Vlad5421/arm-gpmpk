<link rel="stylesheet" href="../css/bootstrap.min.css">
<?php
require_once('../funcs.php');
require_once('../pwd/connect.php');
$reg = save_parrent();
if (!false == $reg) header('Location: /index.php');
else echo 'Профиль с указанным E-mail уже существует. Введите его в форме авторизации: <br>
	<a href="/"><button class="btn btn-success">Аворизоваться</button></a>';


?>