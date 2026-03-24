<?php

require '../../magrs-admin/config.php';

// -----------------------------
// LOCAL SAFETY CHECK
// -----------------------------
if (!$pdo) {
    header("Location: /magrs/results/index.php");
    exit;
}

// -----------------------------
// COLLECT INPUT
// -----------------------------

$data = [
    'ai_use' => $_POST['ai_use'] ?? '',
    'ai_discussion' => $_POST['ai_discussion'] ?? '',
    'ai_policy' => $_POST['ai_policy'] ?? '',
    'ai_responsibility' => $_POST['ai_responsibility'] ?? '',
    'ai_review' => $_POST['ai_review'] ?? '',
    'ai_data_risk' => $_POST['ai_data_risk'] ?? ''
];

$assessment_json = json_encode($data);

$org_name = $_POST['org_name'] ?? '';
$contact_name = $_POST['contact_name'] ?? '';
$email = $_POST['email'] ?? '';
$role = $_POST['role'] ?? '';

$ref = $_POST['ref'] ?? null;
$src = $_POST['src'] ?? null;

// -----------------------------
// GENERATE ID
// -----------------------------

function generateMAGRSID($pdo) {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    do {
        $id = '';
        for ($i = 0; $i < 5; $i++) {
            $id .= $chars[random_int(0, strlen($chars) - 1)];
        }

        $public_id = 'MAGRS-' . $id;

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM organizations WHERE public_id = ?");
        $stmt->execute([$public_id]);

    } while ($stmt->fetchColumn() > 0);

    return $public_id;
}

// -----------------------------
// INSERT (simple version)
// -----------------------------

$public_id = generateMAGRSID($pdo);

$stmt = $pdo->prepare("
    INSERT INTO organizations 
    (public_id, org_name, contact_name, email, industry, assessment_data, status, created_at, referred_by, referral_source)
    VALUES (?, ?, ?, ?, ?, ?, 'prospect', NOW(), ?, ?)
");

$stmt->execute([
    $public_id,
    $org_name,
    $contact_name,
    $email,
    $role,
    $assessment_json,
    $ref,
    $src
]);

// -----------------------------
// REDIRECT
// -----------------------------

header("Location: /magrs/results/index.php?id=" . urlencode($public_id));
exit;