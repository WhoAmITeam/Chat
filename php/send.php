<?php

session_start();

// Проверка в аккаунте ли мы
if($_SESSION['login'] == NULL)
{
    exit();
}


//подключаемся к базе
require_once '../settings/db.php'; 
$connection = connect();


//берём отправленный текст
$text = $_GET["send"]; 
$text = mysqli_real_escape_string($connection, $text);
$text = strip_tags($text, '<a>');

if($text == '')
{
    exit();
}

//узнаем логин
$login = $_SESSION["login"];




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


// Добавляем в базу
$query = "INSERT INTO `message` (`text`, `user_id`, `show_login`) 
          VALUES ('". $text ."','". $user_id_value['id'] ."', '". $show_login_value['show_login'] ."');";
mysqli_query($connection, $query);

?>

