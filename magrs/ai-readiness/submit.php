<?php

require __DIR__ . '/../../magrs-admin/config.php';

// ----------------------
// INPUTS
// ----------------------

$org_name = trim($_POST['org_name'] ?? '');
$contact_name = trim($_POST['contact_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$role = trim($_POST['role'] ?? '');

$ref = $_POST['ref'] ?? null;
$src = $_POST['src'] ?? null;

if (!$org_name || !$contact_name || !$email) {
    die("Missing required fields.");
}

// ----------------------
// ASSESSMENT DATA
// ----------------------

$assessment = [
    'ai_visibility' => $_POST['ai_visibility'] ?? '',
    'ai_tool_control' => $_POST['ai_tool_control'] ?? '',
    'ai_accountability' => $_POST['ai_accountability'] ?? '',
    'ai_accountability_docs' => $_POST['ai_accountability_docs'] ?? '',
    'ai_policy' => $_POST['ai_policy'] ?? '',
    'ai_training' => $_POST['ai_training'] ?? '',
    'ai_decision' => $_POST['ai_decision'] ?? '',
    'ai_escalation' => $_POST['ai_escalation'] ?? '',
    'ai_data_risk' => $_POST['ai_data_risk'] ?? '',
    'ai_data_controls' => $_POST['ai_data_controls'] ?? '',
    'ai_review' => $_POST['ai_review'] ?? '',
    'ai_audit' => $_POST['ai_audit'] ?? ''
];

$assessment_json = json_encode($assessment);

// ----------------------
// LOCAL MODE (NO DB)
// ----------------------

if (!$pdo) {

    // simulate ID
    $public_id = "LOCAL-" . substr(md5(time()), 0, 6);

    // store temporarily in session
    session_start();
    $_SESSION['assessment'] = $assessment;

    header("Location: /magrs/results/index.php?id=" . urlencode($public_id));
    exit;
}

// ----------------------
// LIVE MODE (DB)
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

$stmt = $pdo->prepare("SELECT id, public_id FROM organizations WHERE email = ?");
$stmt->execute([$email]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing) {

    $stmt = $pdo->prepare("
        UPDATE organizations 
        SET org_name = ?, contact_name = ?, industry = ?, assessment_data = ?, status = 'applicant'
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

    $public_id = generateMAGRSID($pdo);

    $stmt = $pdo->prepare("
        INSERT INTO organizations 
        (public_id, org_name, contact_name, email, industry, status, assessment_data, created_at)
        VALUES (?, ?, ?, ?, ?, 'applicant', ?, NOW())
    ");

    $stmt->execute([
        $public_id,
        $org_name,
        $contact_name,
        $email,
        $role,
        $assessment_json
    ]);
}

header("Location: /magrs/results/index.php?id=" . urlencode($public_id));
exit;