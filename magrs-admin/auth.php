<?php
session_start();

if (!isset($_SESSION['user_id'])) {

    // remember requested page
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];

    header("Location: login.php");
    exit;
}
?>