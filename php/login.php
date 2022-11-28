<?php
session_start();
require_once '../settings/db.php';
require_once '../settings/root.php';
$connection = connect();     //Проверка на вход в аккаунт
if (!empty($_SESSION['login'])) {
    header(rootway() . "chat.php");
    exit();
}
if(isset($_POST['btn'])){   //Проверяем, нажата кнопка или нет
    $login = $_POST['login'];
    $login = mysqli_real_escape_string($connection, $login);
    $login = strip_tags($login);    
    $password = $_POST['password'];  
    $password = mysqli_real_escape_string($connection, $password);   //Защита от sql-инъекций
    //$password = strip_tags($password);      //Защита от html
    $query = "SELECT `login`, `password` FROM `user` WHERE `login` = '$login'";
    $verify = mysqli_query($connection, $query);
    $verify = mysqli_fetch_assoc($verify);
    if($login == $verify['login'] AND password_verify($password, $verify['password'])){
        $_SESSION['login'] = $login;
        header(rootway() . "chat.php");
        exit();
    }
    else{
        header(rootway() . "index.php"); //НЕПРАВИЛЬНЫЙ ЛОГИН ИЛИ ПАРОЛЬ
        exit();
    }
}