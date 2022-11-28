<?php
	session_start();
	require_once 'settings/db.php';
	require_once 'settings/root.php';
	$connection = connect();
	if (empty($_SESSION['login'])) {
	header(rootway() . "index.php");
	exit();
}
	if(isset($_POST['exit'])){
	$_SESSION['login'] = NULL;
	header(rootway() . 'php/out.php');
}
?>

<!DOCTYPE HTML>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>CRINGE.ME | Чат</title>
	<link rel="shortcut icon" href="src/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/global.css">
</head>

<body>
<!-- Шапка -->
	<header>
		<div class="header-center">
			<img src="src/logo.png" width="64vw" height="64vh">
			<a href="#">CRINGE.ME CHAT</a>
			<button id="exit" name="exit" onclick="window.location.href = 'php/out.php';">Выход</button>
		</div>
	</header>
<!-- Основное содержание -->
<div class="zone">
	<button name="attach" id="attach" onclick="window.location.href = 'files.php';">
        <img src="src/paper-clip.png" width="10px" height="10px">
	</button>
	<input type="text" id="message-text"
		   autofocus required
		   minlength="1" maxlength="1000"
		   placeholder="Напишите сообщение...">
	<input type="submit" onclick="send()" value="➥"> <span id="mod"><?php
	//узнаем логин
$login = $_SESSION["login"];
$login = mysqli_real_escape_string($connection, $login);
$login = strip_tags($login);



//получаем user_id
$query = "SELECT id 
          FROM user 
          WHERE login = '". $login ."';";
$user_id = mysqli_query($connection, $query);
$user_id_value = mysqli_fetch_assoc($user_id);


//получаем show_login
$query = "SELECT show_login 
          FROM setting 
          WHERE user_id = '". $user_id_value['id'] ."';";
$show_login = mysqli_query($connection, $query); 
$show_login_value = mysqli_fetch_assoc($show_login);
if($show_login_value['show_login']){
	?>
		<input type="submit" onclick="ch(0)" value="<?php echo $_SESSION['login']; ?>">
	<?php
}else{
	?>
		
		<input type="submit" onclick="ch(1)" value="Аноним">
	<?php
}
	?></span>
	<hr>

	<div id="content">

	</div>
	

<!-- Подвал страницы -->
	<footer>
		© Copyright «Cringe.ME» 2022 — Все права защищены. <a href="titles.php">Титры</a>
	</footer>
	<script src="js/jq.js"></script>
	<script>
		var login = '<?php echo $_SESSION['login']; ?>';
		function loop(){
			$.ajax({
            method: "GET",
            url: "php/recv.php",
            dataType: "text",
            data: {},
            success: function(value){  
                $('#content').html(value);
	        }
        });
			setTimeout(loop, 1000);
		}

		loop();
		

		function send(){
			var val = $('#message-text').val();
			if(val != ''){
				$.ajax({
            method: "GET",
            url: "php/send.php",
            dataType: "text",
            data: {send: val},
            success: function(value){  
	        }
        });
		}
		$('#message-text').val('');
			}

			function ch(status){
				$.ajax({
            method: "GET",
            url: "php/show_login.php",
            dataType: "text",
            data: {val: status},
            success: function(value){ 
				if(value == 1){
					$('#mod').html('<input type="submit" onclick="ch(0)" value="' + login + '">');
				}else{
					$('#mod').html('<input type="submit" onclick="ch(1)" value="Аноним">');
				}
	        }
        });
			}

			$(document).ready(function() {
  $('input').keydown(function(e) {
    if(e.keyCode === 13) {
		send();
    }
  });
});
		
	</script>
</body>
</html>