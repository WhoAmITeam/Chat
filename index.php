<?php
	session_start();
	require_once 'settings/db.php';
	require_once 'settings/root.php'; //Проверка на вход в аккаунт
	if (!empty($_SESSION['login'])) {
		header(rootway() . "chat.php");
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>CRINGE.ME | Авторизация </title>
	<link rel="shortcut icon" href="src/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/global.css">
</head>
<body>
<!-- Шапка -->
	<header>
		<div class="header-center">
			<img src="src/logo.png" width="64vw" height="64vh">
			<a href="#">CRINGE.ME CHAT</a>
		</div>
	</header>
<!-- Основное содержание -->
	<main>
		<div class="container">
			<!-- РЕАЛИЗОВАТЬ
				Во время отправки формы пользователем с медленным соединением сети
				должна блокироваться возможность изменения данных формы до момента
				получения ответа от сервера.
            -->
			<form action="php/login.php" method="post">
				<input type="text" name="login"
					   placeholder="Введите логин..."
					   pattern="[A-Za-zА-Яа-яЁё]{1, 20}"
					   minlength="1" maxlength="20"
					   autocomplete="on"
					   required autofocus><br>
				<input type="password" name="password"
					   placeholder="Введите пароль..."
					   pattern="[A-Za-z]{3, 255}"
					   minlength="3" maxlength="255"
					   autocomplete="off"
					   required><br>
				<input type="submit" name="btn" value="Войти">
			</form>
			<hr>
			<button class="btn_link" onclick="window.location.href = 'reg.php';">Зарегестрироваться 🡦</button>

		</div>
	</main>
<!-- Подвал страницы -->
	<footer>
        © Copyright «Cringe.ME» 2022 — Все права защищены. <a href="titles.php">Титры</a>
	</footer>

</body>
</html>