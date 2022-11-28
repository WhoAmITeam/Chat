<?php
session_start();
require_once 'settings/db.php';
require_once 'settings/root.php';
$connection = connect();
if (empty($_SESSION['login'])) {
header(rootway() . "index.php");
exit();
}

?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Загрузка  -->
<input type="submit" onclick="history.back();" value="Назад"><br><br>
<form action="php/files.php" method="POST" id="file-upload-form" class="uploader" enctype="multipart/form-data">
	<input id="file-upload" type="file" name="file">

	<label for="file-upload" id="file-drag">
		<img id="file-image" src="#" alt="Preview" class="hidden">
		<div id="start">
			<i class="fa fa-download" aria-hidden="true"></i>
			<div>Выберите файл или перетащите его сюда</div>
			<div id="notimage" class="hidden">Пожалуйста, выберите изображение</div>
			<span id="file-upload-btn" class="btn btn-primary">Выбрать файл</span>
		</div>
		<div id="response" class="hidden">
			<div id="messages"></div>
			<progress class="progress" id="file-progress" value="0">
				<span>0</span>%
			</progress>
		</div>
	</label>
	<br><br>
	<input type="submit" name="btn">
</form>

	<script src="js/script.js"></script>
</body>
</html>