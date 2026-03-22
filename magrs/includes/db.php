<?php
if(!defined('MAGRS_SYSTEM')) exit;

$host = "localhost";
$dbname = "rkm_magrs";
$username = "rkm_magrs_admin";
$password = "P@$$4MagrsDb";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed.");
}

?>