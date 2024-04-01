<?php 
error_reporting(-1);







?>

<form action="send.php" method="post" >
	<label for="mail"> мыло
		<input type="email" name="mail">
	</label><br>
	<label for="1"> Имя
		<input type="text" name="name">
	</label>
	<br>
	<label for="message"> текст
		<textarea name="message" id="message" cols="30" rows="10"></textarea>
	</label>
	<br>
	<button type="send">отправить</button>
</form>