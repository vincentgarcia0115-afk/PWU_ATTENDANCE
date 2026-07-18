<?php
session_start();

if(
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
){
    header("Location: index.php");
    exit();
}

$timeout = 1800;

if(
    isset($_SESSION['last_activity']) &&
    (time() - $_SESSION['last_activity']) > $timeout
){
    session_unset();
    session_destroy();

    header("Location: index.php");
    exit();
}

$_SESSION['last_activity'] = time();
?>