<?php
require 'config.php';

$today = new DateTime();
$cutoff = (new DateTime())->modify('-90 days');

$stmt = $pdo->query("SELECT id, billing_status FROM organizations");

while ($org = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $org_id = $org['id'];
    $billing = $org['billing_status'];

    // Get most recent report
    $reportStmt = $pdo->prepare("
        SELECT submitted_at 
        FROM monthly_reports 
        WHERE org_id = :org_id AND submitted = 1 
        ORDER BY submitted_at DESC 
        LIMIT 1
    ");

    $reportStmt->execute([':org_id' => $org_id]);
    $lastReport = $reportStmt->fetch(PDO::FETCH_ASSOC);

    $badgeActive = 1;

    if ($billing !== 'paid') {
        $badgeActive = 0;
    }

    if (!$lastReport) {
        $badgeActive = 0;
    } else {
        $reportDate = new DateTime($lastReport['submitted_at']);
        if ($reportDate < $cutoff) {
            $badgeActive = 0;
        }
    }

    $update = $pdo->prepare("
        UPDATE organizations 
        SET badge_active = :badge 
        WHERE id = :org_id
    ");

    $update->execute([
        ':badge' => $badgeActive,
        ':org_id' => $org_id
    ]);
}

echo "Verification status updated.";