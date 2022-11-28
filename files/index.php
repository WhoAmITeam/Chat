<?php
    session_start();
    require_once '../settings/db.php';
    require_once '../settings/root.php';
    $connection = connect();

    if ($_SESSION['login'] == NULL) {
        header(rootway() . 'index.html');
    } else {
        header(rootway() . 'chat.php');
    }
?>