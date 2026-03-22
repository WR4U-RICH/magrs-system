<?php
require 'auth.php';
require 'config.php';

$id = $_GET['id'];
$badge = $_GET['badge'];

$sql = "UPDATE organizations
        SET badge_active = :badge
        WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':badge' => $badge,
    ':id' => $id
]);

header("Location: org_detail.php?id=" . $id);
exit;
?>