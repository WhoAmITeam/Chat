<?php
session_start();
require_once '../settings/db.php';
require_once '../settings/root.php';
$connection = connect();     //Проверка на вход в 
if (!empty($_SESSION['login'])) {
    header(rootway() . "chat.php");
    exit();
}
if(isset($_POST['btn'])){   //Проверяем, нажата кнопка или нет
    $login = $_POST['login'];
    $login = mysqli_real_escape_string($connection, $login);   //Защита от sql-инъекций
    $login = strip_tags($login);    //Защита от html
    $arrayy = ["'",'"',"@"," ", "/", "|", "\\", "*", ":", "<", ">"];
$login = str_replace($arrayy, "", trim($login));
    $query = "SELECT `login` FROM `user` WHERE `login` = '$login'"; //Запрос для проверки уникальности логина
    $verify = mysqli_query($connection, $query);
    $verify = mysqli_fetch_assoc($verify);
    if($login == "" OR mb_strlen($login) > 20 OR $login == $verify["login"]){
        header(rootway() . "reg.php"); //ПРОБЛЕМЫ С ЛОГИНОМ
        exit();
    }
    $password = $_POST['password'];
    $password = mysqli_real_escape_string($connection, $password);   //Защита от sql-инъекций
    //$password = strip_tags($password);    //Защита от html
    $password2 = $_POST['password2'];
    $password2 = mysqli_real_escape_string($connection, $password2);   //Защита от sql-инъекций
    //$password2 = strip_tags($password2);    //Защита от html
    if(mb_strlen($password) < 3 OR mb_strlen($password2) < 3 OR $password != $password2){
        header(rootway() . "reg.php"); //ПРОБЛЕМЫ С ПАРОЛЕМ
        exit();
    }
    $password = password_hash($password, PASSWORD_BCRYPT);  //Хэширование пароля
    $color_r = rand(20, 230);   //Генерация ргб
    $color_g = rand(20, 230);
    $color_b = rand(20, 230);
    $query = "INSERT INTO `user` (`id`, `login`, `password`, `color_r`, `color_g`, `color_b`) VALUES (NULL, '$login', '$password', '$color_r', '$color_g', '$color_b')";
    $recive = mysqli_query($connection, $query);
    $_SESSION['login'] = $login;

    $query = "SELECT `id` FROM `user` WHERE `login` = '$_SESSION[login]'"; // узнаём id пользователя по логину из сессии (он уникален)
    $recive = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($recive);

    $query = "INSERT INTO `setting` (`user_id`) VALUES ('$row[id]')"; // создаём сообщение, к которому прикрепим файл
    $recive = mysqli_query($connection, $query);

    header(rootway() . "chat.php");
    exit();
}
?>