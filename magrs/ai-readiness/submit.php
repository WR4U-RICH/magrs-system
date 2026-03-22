<?php

require '../../magrs-admin/config.php';

// ----------------------
// Collect form data
// ----------------------

$org_name = trim($_POST['org_name'] ?? '');
$contact_name = trim($_POST['contact_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$role = trim($_POST['role'] ?? '');

$ref = $_POST['ref'] ?? null;
$src = $_POST['src'] ?? null;

// Assessment answers
$assessment = [
    'ai_use' => $_POST['ai_use'] ?? null,
    'ai_discussion' => $_POST['ai_discussion'] ?? null,
    'ai_policy' => $_POST['ai_policy'] ?? null,
    'ai_responsibility' => $_POST['ai_responsibility'] ?? null
];

$assessment_json = json_encode($assessment);

// ----------------------
// Basic validation
// ----------------------

if (!$org_name || !$contact_name || !$email) {
    die("Missing required fields.");
}

// ----------------------
// Generate MAGRS ID
// ----------------------

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

// ----------------------
// Check existing org
// ----------------------

$stmt = $pdo->prepare("SELECT id, public_id FROM organizations WHERE email = ?");
$stmt->execute([$email]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing) {

    // Update existing
    $stmt = $pdo->prepare("
        UPDATE organizations 
        SET org_name = ?, contact_name = ?, industry = ?, status = 'applicant', assessment_data = ?
        WHERE email = ?
    ");

    $stmt->execute([
        $org_name,
        $contact_name,
        $role,
        $assessment_json,
        $email
    ]);

    $public_id = $existing['public_id'];

} else {

    // Insert new
    $public_id = generateMAGRSID($pdo);

    $stmt = $pdo->prepare("
        INSERT INTO organizations 
        (public_id, org_name, contact_name, email, phone, industry, status, created_at, referred_by, referral_source, assessment_data)
        VALUES (?, ?, ?, ?, '', ?, 'prospect', NOW(), ?, ?, ?)
    ");

    $stmt->execute([
        $public_id,
        $org_name,
        $contact_name,
        $email,
        $role,
        $ref,
        $src,
        $assessment_json
    ]);
}

// ----------------------
// Redirect to results
// ----------------------

header("Location: /magrs/results/?id=" . urlencode($public_id));
exit;