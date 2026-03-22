<?php

require __DIR__ . '/config.php';

// Get raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate payload
if (!$data || !isset($data['data']['fields'])) {
    http_response_code(400);
    echo "Invalid payload";
    exit;
}

$fields = $data['data']['fields'];

// Initialize variables
$contact_name = '';
$email = '';
$org_name = '';
$role = '';

// Extract values
foreach ($fields as $field) {
    $label = strtolower($field['label'] ?? '');
    $value = trim($field['value'] ?? '');

    if (strpos($label, 'name') !== false) {
        $contact_name = $value;
    }

    if (strpos($label, 'email') !== false) {
        $email = $value;
    }

    if (strpos($label, 'organization') !== false) {
        $org_name = $value;
    }

    if (strpos($label, 'role') !== false) {
        $role = $value;
    }
}

// Fallback
if (empty($org_name)) {
    $org_name = 'Unknown Organization';
}

// Generate ID
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

$public_id = generateMAGRSID($pdo);

// INSERT (original working structure)
$stmt = $pdo->prepare("
    INSERT INTO organizations 
    (public_id, org_name, contact_name, email, phone, industry, status, created_at)
    VALUES (?, ?, ?, ?, '', ?, 'prospect', NOW())
");

$stmt->execute([
    $public_id,
    $org_name,
    $contact_name,
    $email,
    $role
]);

http_response_code(200);
echo "OK";