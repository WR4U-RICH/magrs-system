<?php
require 'config.php';

$id = $_GET['id'];
$status = $_GET['status'];

// Get current organization (we need referred_by BEFORE updating)
$stmt = $pdo->prepare("SELECT public_id, referred_by, status FROM organizations WHERE id = :id");
$stmt->execute([':id' => $id]);
$org = $stmt->fetch(PDO::FETCH_ASSOC);

// Update status
$sql = "UPDATE organizations SET status = :status WHERE id = :id";
$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':status' => $status,
    ':id' => $id
]);

// 🔹 Referral credit logic (ONLY when moving to active)
if ($status === 'active' && $org && !empty($org['referred_by'])) {

    // Prevent double-counting if already active
    if ($org['status'] !== 'active') {

        $stmt = $pdo->prepare("
            UPDATE organizations
            SET referral_credentials = referral_credentials + 1
            WHERE public_id = :ref_id
        ");

        $stmt->execute([
            ':ref_id' => $org['referred_by']
        ]);
    }
}

header("Location: dashboard.php");
exit;
?>