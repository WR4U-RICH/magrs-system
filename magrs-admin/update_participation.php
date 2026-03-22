<?php
require 'auth.php';
require 'config.php';

$id = $_POST['id'];

$sql = "UPDATE organizations
        SET level = :level,
            participation_start = :participation_start,
            renewal_date = :renewal_date
        WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':level' => $_POST['level'],
    ':participation_start' => $_POST['participation_start'],
    ':renewal_date' => $_POST['renewal_date'],
    ':id' => $id
]);

header("Location: org_detail.php?id=" . $id);
exit;
?>