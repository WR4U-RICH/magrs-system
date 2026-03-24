<?php

require '../../magrs-admin/config.php';

// -----------------------------
// COLLECT INPUT
// -----------------------------

$org_name = trim($_POST['org_name'] ?? '');
$contact_name = trim($_POST['contact_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$role = trim($_POST['role'] ?? '');

// Basic validation
if (!$org_name || !$contact_name || !$email) {
    die("Missing required fields.");
}

// -----------------------------
// LOCAL MODE SAFETY
// -----------------------------
if (!$pdo) {
    header("Location: /magrs/apply/thank-you.php?id=LOCAL-TEST");
    exit;
}

// -----------------------------
// GENERATE MAGRS ID
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
// CHECK EXISTING BY EMAIL
// -----------------------------

$stmt = $pdo->prepare("SELECT id, public_id FROM organizations WHERE email = ?");
$stmt->execute([$email]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing) {

    // UPDATE EXISTING → move to applicant
    $stmt = $pdo->prepare("
        UPDATE organizations 
        SET 
            org_name = ?, 
            contact_name = ?, 
            industry = ?, 
            status = 'applicant'
        WHERE email = ?
    ");

    $stmt->execute([
        $org_name,
        $contact_name,
        $role,
        $email
    ]);

    $public_id = $existing['public_id'];

} else {

    // CREATE NEW APPLICANT
    $public_id = generateMAGRSID($pdo);

    $stmt = $pdo->prepare("
        INSERT INTO organizations 
        (public_id, org_name, contact_name, email, industry, status, created_at)
        VALUES (?, ?, ?, ?, ?, 'applicant', NOW())
    ");

    $stmt->execute([
        $public_id,
        $org_name,
        $contact_name,
        $email,
        $role
    ]);
}

// -----------------------------
// REDIRECT
// -----------------------------

header("Location: /magrs/apply/thank-you.php?id=" . urlencode($public_id));
exit;