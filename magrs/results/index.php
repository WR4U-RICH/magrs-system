<?php

require '../../magrs-admin/config.php';

$id = $_GET['id'] ?? null;

// -----------------------------
// LOCAL MODE (no DB)
// -----------------------------
if (!$pdo) {

    // Simulated data for local testing
    $ai_use = 'yes';
    $ai_discussion = 'informal';
    $ai_policy = 'no';
    $ai_responsibility = 'undefined';

} else {

    if (!$id) {
        die("No ID provided.");
    }

    $stmt = $pdo->prepare("SELECT assessment_data FROM organizations WHERE public_id = ?");
    $stmt->execute([$id]);
    $org = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$org) {
        die("Record not found.");
    }

    $assessment = json_decode($org['assessment_data'], true);

    $ai_use = $assessment['ai_use'] ?? '';
    $ai_discussion = $assessment['ai_discussion'] ?? '';
    $ai_policy = $assessment['ai_policy'] ?? '';
    $ai_responsibility = $assessment['ai_responsibility'] ?? '';
}

// ----------------------
// CLASSIFICATION
// ----------------------

$status = "Unstructured Usage";
$meaning = "";
$risk = "";
$next = "";

if ($ai_discussion === 'none' && $ai_policy === 'no') {

    $status = "Unstructured Usage";

    $meaning = "AI use is likely happening informally without visibility or oversight.";

    $risk = "Work may be produced using AI without defined responsibility, creating exposure to errors, compliance issues, and reputational risk.";

    $next = "Establish awareness of AI use and begin defining responsibility for AI-assisted work.";

}
elseif ($ai_policy === 'no' || $ai_responsibility === 'undefined') {

    $status = "Developing Awareness";

    $meaning = "Your organization has begun recognizing AI use, but governance and accountability are not yet clearly defined.";

    $risk = "AI-assisted work may lack clear ownership, increasing the risk of incorrect decisions and unmanaged liability.";

    $next = "Define responsibility and introduce basic governance structure for AI-assisted work.";

}
elseif ($ai_discussion === 'formal' || $ai_discussion === 'informal') {

    $status = "Emerging Governance";

    $meaning = "AI use is being discussed and partially understood, but governance is still evolving.";

    $risk = "Without structured processes, governance may be inconsistent across teams or individuals.";

    $next = "Standardize governance practices and implement consistent oversight across the organization.";
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

.section {
    margin-top: 25px;
}

.cta {
    margin-top: 40px;
    padding: 20px;
    border: 1px solid #ccc;
    background: #f5f5f5;
}

.button {
    display: inline-block;
    padding: 12px 20px;
    background: #0055aa;
    color: #fff;
    text-decoration: none;
    margin-top: 15px;
}
</style>

</head>

<body>

<h1>MAGRS Assessment Result</h1>

<?php if (!$pdo): ?>
<p style="color:#888;"><em>Local preview mode (simulated data)</em></p>
<?php endif; ?>

<p>Your current AI governance status:</p>

<div class="status">
<?php echo htmlspecialchars($status); ?>
</div>

<div class="section">
<strong>What this means</strong><br>
<?php echo htmlspecialchars($meaning); ?>
</div>

<div class="section">
<strong>Risk</strong><br>
<?php echo htmlspecialchars($risk); ?>
</div>

<div class="section">
<strong>Recommended Next Step</strong><br>
<?php echo htmlspecialchars($next); ?>
</div>

<div class="section">

<strong>Your Position Today</strong><br>

<?php echo htmlspecialchars($status); ?> means your organization is currently operating without fully defined accountability for AI-assisted work.

</div>

<?php if ($id): ?>

<div class="section">

<strong>Your Referral ID</strong><br>

Share this ID with other organizations:<br><br>

<div style="font-size:18px; font-weight:bold;">
<?php echo htmlspecialchars($id); ?>
</div>

<p style="font-size:0.9em; color:#666;">
Referral activity will be tracked and may unlock future benefits within the MAGRS system.
</p>

</div>

<?php endif; ?>

<p style="margin-top:10px;">
Share this link:<br>
https://marshall.net/magrs/ai-readiness/?ref=<?php echo urlencode($id); ?>
</p>

<div class="cta">

<strong>The Accountability Gap</strong><br><br>

Artificial intelligence may assist decision-making, but responsibility always remains with humans.

<br><br>

Right now, your organization is operating in a state where AI-assisted work may not have clearly defined accountability.

<br><br>

As adoption accelerates, organizations that establish governance early are significantly better positioned than those that delay.

<br><br>

<strong>Next Step</strong><br>

MAGRS provides a simple structure to define responsibility, establish oversight, and maintain ongoing accountability.

<br><br>

Initial Readiness Review: $85<br>
Annual Participation: $295

<br><br>

<a class="button" href="/magrs/join/">Start My Readiness Review</a>

</div>
<p style="font-size: 0.9em; color:#666; margin-top:10px;">
No obligation. Results are private.
</p>
</body>
</html>