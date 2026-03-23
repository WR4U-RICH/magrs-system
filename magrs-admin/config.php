<?php

// Detect environment
$host = $_SERVER['HTTP_HOST'] ?? '';
$is_local = (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false);

// -----------------------------
// LOCAL MODE (no database)
// -----------------------------
if ($is_local) {

    $pdo = null;

} else {

    // -----------------------------
    // PRODUCTION DATABASE
    // -----------------------------
    $db_host = "localhost";
    $db_name = "rkm_magrs";
    $db_user = "rkm_magrs_admin";
    $db_pass = "P@$$4MagrsDb";

    try {
        $pdo = new PDO(
            "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
            $db_user,
            $db_pass
        );

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {

        die("Database connection failed: " . $e->getMessage());

    }
}

?>