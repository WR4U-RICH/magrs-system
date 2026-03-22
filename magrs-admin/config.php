<?php

$host = "localhost";
$dbname = "rkm_magrs";
$username = "rkm_magrs_admin";
$password = "P@$$4MagrsDb";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>