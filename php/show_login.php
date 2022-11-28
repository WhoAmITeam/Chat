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

//узнаем логин
$login = $_SESSION["login"];

$status = 1;

if($_GET['val'] == 0){
    $status = 0;
}



//получаем user_id
$query = "SELECT id 
          FROM user 
          WHERE login = '". $login ."';";
$user_id = mysqli_query($connection, $query);
$user_id_value = mysqli_fetch_assoc($user_id);

$query = "UPDATE `setting` set `show_login` = '$status' WHERE `user_id` = '$user_id_value[id]'";
mysqli_query($connection, $query);

//получаем show_login
$query = "SELECT show_login 
          FROM setting 
          WHERE user_id = '". $user_id_value['id'] ."';";
$show_login = mysqli_query($connection, $query); 
$show_login_value = mysqli_fetch_assoc($show_login);

echo $show_login_value['show_login'];

?>