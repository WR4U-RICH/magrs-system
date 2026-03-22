<?php

require '../../magrs-admin/config.php';

// 🔹 Capture referral + source (GET takes priority, then POST)
$ref = $_GET['ref'] ?? $_POST['ref'] ?? null;
$src = $_GET['src'] ?? $_POST['src'] ?? null;

// 🔹 Validate referral (must exist)
if ($ref) {
    $check = $pdo->prepare("SELECT COUNT(*) FROM organizations WHERE public_id = ?");
    $check->execute([$ref]);
    if ($check->fetchColumn() == 0) {
        $ref = null;
    }
}

// Get form values safely
$org_name = trim($_POST['org_name'] ?? '');
$contact_name = trim($_POST['contact_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$role = trim($_POST['role'] ?? '');

// Basic validation
if (!$org_name || !$contact_name || !$email) {
    die("Missing required fields.");
}

// Generate unique MAGRS ID
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

// ==============================
// CHECK FOR EXISTING RECORD
// ==============================

$stmt = $pdo->prepare("SELECT id, public_id FROM organizations WHERE email = ?");
$stmt->execute([$email]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing) {

    // UPDATE existing record
    $stmt = $pdo->prepare("
        UPDATE organizations 
        SET org_name = ?, contact_name = ?, industry = ?, status = 'applicant'
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

    // CREATE new record
    $public_id = generateMAGRSID($pdo);

    $stmt = $pdo->prepare("
        INSERT INTO organizations 
        (public_id, org_name, contact_name, email, industry, status, created_at, referred_by, referral_source)
        VALUES (?, ?, ?, ?, ?, 'applicant', NOW(), ?, ?)
    ");

    $stmt->execute([
        $public_id,
        $org_name,
        $contact_name,
        $email,
        $role,
        $ref,
        $src
    ]);
}

// ==============================
// 🔥 NEW: APPLICATION CREDIT
// ==============================

if ($ref) {
    $stmt = $pdo->prepare("
        UPDATE organizations
        SET referral_assessments = referral_assessments + 1
        WHERE public_id = ?
    ");
    $stmt->execute([$ref]);
}

// ==============================
// SEND EMAIL
// ==============================

$to = $email;
$subject = "MAGRS Application Received";

$message = "
Hello $contact_name,

Your application for the Marshall AI Governance Readiness Standard (MAGRS) has been received.

Your Organization ID: $public_id

Next Step:

To begin your readiness process, complete your initial review:

Initial Readiness Review: $85

You may proceed here:
https://marshall.net/magrs/join/

This step provides access to:
- Readiness framework
- Application materials
- Participation onboarding

The Marshall Principle:
Artificial intelligence may assist decision-making, but responsibility always remains with humans.

— Richard Marshall
marshall.net
";

$headers = "From: richard@marshall.net\r\n";
$headers .= "Reply-To: richard@marshall.net\r\n";

mail($to, $subject, $message, $headers);

// ==============================
// REDIRECT
// ==============================

header("Location: /magrs/apply/thank-you.php?id=" . urlencode($public_id));
exit;