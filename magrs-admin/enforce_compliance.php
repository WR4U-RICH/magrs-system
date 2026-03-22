<?php
require 'config.php';

function getQuarter($date) {
    $month = date('n', strtotime($date));
    return ceil($month / 3);
}

$current_year = date('Y');
$current_quarter = getQuarter(date('Y-m-d'));

$stmt = $pdo->query("
    SELECT id, public_id, referred_by, last_report_quarter, billing_status, compliance_credited 
    FROM organizations
");

while ($org = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $badge = 1;

    if ($org['billing_status'] !== 'paid') {
        $badge = 0;
    }

    if (!$org['last_report_quarter']) {
        $badge = 0;
    } else {

        preg_match('/(\d{4})Q(\d)/', $org['last_report_quarter'], $matches);

        $report_year = intval($matches[1]);
        $report_quarter = intval($matches[2]);

        $quarters_since =
            ($current_year - $report_year) * 4 +
            ($current_quarter - $report_quarter);

        if ($quarters_since > 1) {
            $badge = 0;
        }
    }

    // 🔹 Update badge status
    $update = $pdo->prepare("
        UPDATE organizations
        SET badge_active = :badge
        WHERE id = :id
    ");

    $update->execute([
        ':badge' => $badge,
        ':id' => $org['id']
    ]);

    // 🔥 NEW: Compliance referral credit
    if (
        $badge == 1 && 
        !empty($org['referred_by']) && 
        $org['compliance_credited'] == 0
    ) {

        // Increment referrer's compliance credit
        $credit = $pdo->prepare("
            UPDATE organizations
            SET referral_compliant = referral_compliant + 1
            WHERE public_id = :ref_id
        ");

        $credit->execute([
            ':ref_id' => $org['referred_by']
        ]);

        // Mark this org as credited (prevent duplicates)
        $mark = $pdo->prepare("
            UPDATE organizations
            SET compliance_credited = 1
            WHERE id = :id
        ");

        $mark->execute([
            ':id' => $org['id']
        ]);
    }
}

echo "Compliance check complete.";
?>