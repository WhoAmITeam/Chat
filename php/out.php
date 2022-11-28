<?php
    require_once '../settings/root.php';
    session_start();
    session_unset();
    session_destroy();
    header(rootway() . 'index.php');
    exit();
?>