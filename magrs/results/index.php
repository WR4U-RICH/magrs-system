<?php

require '../../magrs-admin/config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("No ID provided.");
}

// Get organization
$stmt = $pdo->prepare("SELECT assessment_data FROM organizations WHERE public_id = ?");
$stmt->execute([$id]);
$org = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$org) {
    die("Record not found.");
}

// Decode assessment JSON
$assessment = json_decode($org['assessment_data'], true);

// Default values
$ai_use = $assessment['ai_use'] ?? '';
$ai_discussion = $assessment['ai_discussion'] ?? '';
$ai_policy = $assessment['ai_policy'] ?? '';
$ai_responsibility = $assessment['ai_responsibility'] ?? '';

// Classification
$status = "Unstructured Usage";

if ($ai_policy === 'no' || $ai_responsibility === 'undefined') {
    $status = "Developing Awareness";
}
elseif ($ai_discussion === 'formal' || $ai_discussion === 'informal') {
    $status = "Emerging Governance";
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>MAGRS Assessment Result</title>
<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    max-width: 800px;
    margin: 40px auto;
    line-height: 1.6;
}
.status {
    font-size: 24px;
    font-weight: bold;
    margin: 20px 0;
}
</style>
</head>

<body>

<h1>MAGRS Assessment Result</h1>

<p>Your readiness status:</p>

<div class="status">
<?php echo htmlspecialchars($status); ?>
</div>

<p>
This reflects your organization’s current level of AI governance awareness.
</p>

<p>
<a href="/magrs/join/">Continue to Participation →</a>
</p>

</body>
</html>