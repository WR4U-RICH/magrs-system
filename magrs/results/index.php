<?php
session_start();

// ----------------------
// INPUT
// ----------------------

$id = $_GET['id'] ?? null;

// ----------------------
// LOAD DATA (LOCAL SAFE)
// ----------------------

$assessment = $_SESSION['assessment'] ?? [];

// ----------------------
// DEFAULTS (prevent warnings)
// ----------------------

$score = 0;
$tier = '';
$status = '';
$headline = '';
$meaning = '';
$risk = '';
$next = '';

// ----------------------
// SCORING (12 question model)
// ----------------------

function risk($value, $map) {
    return $map[$value] ?? 0;
}

$score += risk($assessment['ai_visibility'] ?? '', [
    'full' => 0, 'partial' => 1, 'none' => 2
]);

$score += risk($assessment['ai_tool_control'] ?? '', [
    'controlled' => 0, 'informal' => 1, 'none' => 2
]);

$score += risk($assessment['ai_accountability'] ?? '', [
    'defined' => 0, 'shared' => 1, 'undefined' => 2
]);

$score += risk($assessment['ai_accountability_docs'] ?? '', [
    'yes' => 0, 'partial' => 1, 'no' => 2
]);

$score += risk($assessment['ai_policy'] ?? '', [
    'enforced' => 0, 'exists' => 1, 'none' => 2
]);

$score += risk($assessment['ai_training'] ?? '', [
    'yes' => 0, 'limited' => 1, 'none' => 2
]);

$score += risk($assessment['ai_decision'] ?? '', [
    'controlled' => 0, 'informal' => 1, 'none' => 2
]);

$score += risk($assessment['ai_escalation'] ?? '', [
    'yes' => 0, 'unclear' => 1, 'no' => 2
]);

$score += risk($assessment['ai_data_risk'] ?? '', [
    'controlled' => 0, 'uncertain' => 1, 'exposed' => 2
]);

$score += risk($assessment['ai_data_controls'] ?? '', [
    'strict' => 0, 'partial' => 1, 'none' => 2
]);

$score += risk($assessment['ai_review'] ?? '', [
    'always' => 0, 'sometimes' => 1, 'never' => 2
]);

$score += risk($assessment['ai_audit'] ?? '', [
    'yes' => 0, 'rare' => 1, 'no' => 2
]);

// ----------------------
// CLASSIFICATION
// ----------------------

if ($score <= 4) {

    $tier = "controlled";
    $status = "Controlled AI Usage";
    $headline = "You are operating with defined accountability.";

    $meaning = "Your organization has established visibility, ownership, and oversight.";
    $risk = "Risk exists, but it is contained and manageable.";
    $next = "Maintain consistency and formalize governance practices.";

} elseif ($score <= 12) {

    $tier = "developing";
    $status = "Developing Governance";
    $headline = "You have awareness, but control is inconsistent.";

    $meaning = "AI use is present, but governance is uneven.";
    $risk = "This creates exposure across decisions and outputs.";
    $next = "Standardize responsibility and implement consistent review.";

} else {

    $tier = "uncontrolled";
    $status = "Uncontrolled AI Usage";
    $headline = "You are operating without defined control.";

    $meaning = "AI is being used without clear accountability or oversight.";
    $risk = "This creates direct organizational exposure.";
    $next = "Immediate action required to establish governance.";

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
.status { font-size: 22px; font-weight: bold; margin-top: 10px; }
.headline { font-size: 20px; margin: 20px 0; }
.section { margin-top: 25px; }
.cta { margin-top: 40px; padding: 20px; background: #f5f5f5; }
.button {
    display: inline-block;
    padding: 12px 20px;
    background: #0055aa;
    color: #fff;
    text-decoration: none;
}
</style>

</head>

<body>

<h1>MAGRS Assessment Result</h1>

<div class="status"><?php echo htmlspecialchars($status); ?></div>
<div class="headline"><?php echo htmlspecialchars($headline); ?></div>

<p style="color:#666;">Risk Score: <?php echo $score; ?></p>

<div class="section">
<strong>What this means</strong><br>
<?php echo htmlspecialchars($meaning); ?>
</div>

<div class="section">
<strong>Exposure</strong><br>
<?php echo htmlspecialchars($risk); ?>
</div>

<div class="section">
<strong>Required Action</strong><br>
<?php echo htmlspecialchars($next); ?>
</div>

<div class="section">
<strong>Your Referral ID</strong><br>
<strong><?php echo htmlspecialchars($id); ?></strong>
</div>

<div class="cta">

<?php if ($tier === "controlled"): ?>

<strong>Maintain Your Position</strong><br><br>
<a class="button" href="/magrs/join/">Strengthen Governance</a>

<?php elseif ($tier === "developing"): ?>

<strong>Close the Gaps</strong><br><br>
<a class="button" href="/magrs/join/">Establish Control</a>

<?php else: ?>

<strong>Regain Control</strong><br><br>
<a class="button" href="/magrs/join/">Start Readiness Review</a>

<?php endif; ?>

</div>

</body>
</html>