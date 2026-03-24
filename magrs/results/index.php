assessment_data FROM organizations WHERE public_id = ?");
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
    $ai_review = $assessment['ai_review'] ?? '';
    $ai_data_risk = $assessment['ai_data_risk'] ?? '';
    echo "<pre>";
print_r($assessment);
echo "</pre>";
exit;
}

// ----------------------
// SCORING
// ----------------------

$score = 0;

if ($ai_policy === 'no') $score += 2;
if ($ai_policy === 'unsure') $score += 1;

if ($ai_responsibility === 'undefined') $score += 2;
if ($ai_responsibility === 'employee') $score += 1;

if ($ai_review === 'never') $score += 2;
if ($ai_review === 'rarely') $score += 2;
if ($ai_review === 'sometimes') $score += 1;

if ($ai_data_risk === 'yes') $score += 2;
if ($ai_data_risk === 'unsure') $score += 1;

if ($ai_discussion === 'none') $score += 1;

// ----------------------
// CLASSIFICATION
// ----------------------

$tier = "";
$status = "";
$headline = "";
$meaning = "";
$risk = "";
$next = "";

// ----------------------
// CONTROLLED
// ----------------------
if ($score <= 2) {

    $tier = "controlled";

    $status = "Controlled AI Usage";
    
    $headline = "You are operating with defined accountability.";

    $meaning = "Your organization has taken meaningful steps to define responsibility and apply oversight to AI-assisted work.";

    $risk = "Risk is present but contained. The primary concern is consistency as AI usage expands.";

    $next = "Your next step is not correction—it is reinforcement. Formalize your practices and ensure they scale across teams.";

}

// ----------------------
// DEVELOPING
// ----------------------
elseif ($score <= 5) {

    $tier = "developing";

    $status = "Developing Governance";
    
    $headline = "You are operating with partial control.";

    $meaning = "Your organization is aware of AI use, but accountability and oversight are inconsistent.";

    $risk = "This creates uneven exposure. Some decisions may be well-managed, while others rely on assumption rather than control.";

    $next = "You need to standardize responsibility and introduce consistent review expectations across all AI-assisted work.";

}

// ----------------------
// HIGH RISK
// ----------------------
else {

    $tier = "high";

    $status = "Uncontrolled AI Usage";
    
    $headline = "You are operating without defined control.";

    $meaning = "AI is being used without clear accountability, consistent oversight, or defined responsibility.";

    $risk = "This creates direct organizational exposure. Decisions, communication, and outputs may carry risk without ownership.";

    $next = "Immediate action is required. Responsibility must be defined, and AI-assisted work must be brought under control.";

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
    font-size: 22px;
    font-weight: bold;
    margin-top: 10px;
}

.headline {
    font-size: 20px;
    margin: 20px 0;
}

.section {
    margin-top: 25px;
}

.cta {
    margin-top: 40px;
    padding: 20px;
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
<p style="color:#888;"><em>Local preview mode</em></p>
<?php endif; ?>

<div class="status">
<?php echo htmlspecialchars($status); ?>
</div>

<div class="headline">
<?php echo htmlspecialchars($headline); ?>
</div>

<p style="font-size: 0.9em; color:#666;">
Risk Score: <?php echo $score; ?>
</p>

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

<?php if ($id): ?>
<div class="section">
<strong>Your Referral ID</strong><br>
<strong><?php echo htmlspecialchars($id); ?></strong>

<p style="font-size:0.9em; color:#666;">
https://marshall.net/magrs/ai-readiness/?ref=<?php echo urlencode($id); ?>
</p>
</div>
<?php endif; ?>

<div class="cta">

<?php if ($tier === "controlled"): ?>

<strong>Maintain Your Position</strong><br><br>

You are ahead of most organizations.

The risk now is not failure—it is drift.

<br><br>

MAGRS ensures your governance remains consistent as AI adoption grows.

<a class="button" href="/magrs/join/">Strengthen My Governance</a>

<?php elseif ($tier === "developing"): ?>

<strong>Close the Gaps</strong><br><br>

You are already exposed—you just don’t feel it yet.

<br><br>

MAGRS provides structure where assumptions currently exist.

<a class="button" href="/magrs/join/">Establish Control</a>

<?php else: ?>

<strong>Regain Control</strong><br><br>

AI is already influencing outcomes in your organization.

Right now, that influence is not controlled.

<br><br>

MAGRS provides immediate structure to define responsibility and reduce exposure.

<a class="button" href="/magrs/join/">Start My Readiness Review</a>

<?php endif; ?>

</div>

</body>
</html><?php

require '../../magrs-admin/config.php';

$id = $_GET['id'] ?? null;

// -----------------------------
// DEFAULTS (fail-safe)
// -----------------------------
$ai_use = '';
$ai_discussion = '';
$ai_policy = '';
$ai_responsibility = '';
$ai_review = '';
$ai_data_risk = '';

// -----------------------------
// LOCAL MODE OR DB MODE
// -----------------------------
if (!$pdo || !$id) {

    // Local fallback (ensures page always works)
    $ai_use = 'yes';
    $ai_discussion = 'informal';
    $ai_policy = 'no';
    $ai_responsibility = 'undefined';
    $ai_review = 'rarely';
    $ai_data_risk = 'yes';

} else {

    $stmt = $pdo->prepare("SELECT assessment_data FROM organizations WHERE public_id = ?");
    $stmt->execute([$id]);
    $org = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($org && !empty($org['assessment_data'])) {

        $assessment = json_decode($org['assessment_data'], true);

        // Safe assignment
        $ai_use = $assessment['ai_use'] ?? '';
        $ai_discussion = $assessment['ai_discussion'] ?? '';
        $ai_policy = $assessment['ai_policy'] ?? '';
        $ai_responsibility = $assessment['ai_responsibility'] ?? '';
        $ai_review = $assessment['ai_review'] ?? '';
        $ai_data_risk = $assessment['ai_data_risk'] ?? '';
    }
}

// ----------------------
// SCORING ENGINE
// ----------------------

$score = 0;

// Policy
if ($ai_policy === 'no') $score += 2;
elseif ($ai_policy === 'unsure') $score += 1;

// Responsibility
if ($ai_responsibility === 'undefined') $score += 2;
elseif ($ai_responsibility === 'employee') $score += 1;

// Review
if ($ai_review === 'never' || $ai_review === 'rarely') $score += 2;
elseif ($ai_review === 'sometimes') $score += 1;

// Data Risk
if ($ai_data_risk === 'yes') $score += 2;
elseif ($ai_data_risk === 'unsure') $score += 1;

// Leadership discussion
if ($ai_discussion === 'none') $score += 1;

// ----------------------
// CLASSIFICATION
// ----------------------

$tier = '';
$status = '';
$headline = '';
$meaning = '';
$risk = '';
$next = '';

// CONTROLLED
if ($score <= 2) {

    $tier = "controlled";

    $status = "Controlled AI Usage";
    $headline = "You are operating with defined accountability.";

    $meaning = "Your organization has established clear responsibility and oversight for AI-assisted work.";
    $risk = "Risk exists, but it is contained and manageable.";
    $next = "Maintain discipline. Formalize practices and ensure consistency across all teams.";

}

// DEVELOPING
elseif ($score <= 5) {

    $tier = "developing";

    $status = "Developing Governance";
    $headline = "You are operating with partial control.";

    $meaning = "Your organization is aware of AI use, but accountability and review are inconsistent.";
    $risk = "This creates uneven exposure across decisions, outputs, and teams.";
    $next = "Standardize accountability and introduce consistent review practices.";

}

// HIGH RISK
else {

    $tier = "high";

    $status = "Uncontrolled AI Usage";
    $headline = "You are operating without defined control.";

    $meaning = "AI is being used without clear ownership or consistent oversight.";
    $risk = "This creates direct organizational exposure across communication, decisions, and outputs.";
    $next = "Immediate action required. Define responsibility and implement governance controls.";

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
    font-size: 22px;
    font-weight: bold;
    margin-top: 10px;
}

.headline {
    font-size: 20px;
    margin: 20px 0;
}

.section {
    margin-top: 25px;
}

.cta {
    margin-top: 40px;
    padding: 20px;
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

<div class="status">
<?php echo htmlspecialchars($status); ?>
</div>

<div class="headline">
<?php echo htmlspecialchars($headline); ?>
</div>

<p style="font-size: 0.9em; color:#666;">
Risk Score: <?php echo $score; ?>
</p>

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

<?php if ($id): ?>
<div class="section">
<strong>Your Referral ID</strong><br>
<strong><?php echo htmlspecialchars($id); ?></strong>

<p style="font-size:0.9em; color:#666;">
https://marshall.net/magrs/ai-readiness/?ref=<?php echo urlencode($id); ?>
</p>
</div>
<?php endif; ?>

<div class="cta">

<?php if ($tier === "controlled"): ?>

<strong>Maintain Your Position</strong><br><br>
You are ahead of most organizations.<br><br>
<a class="button" href="/magrs/join/">Strengthen My Governance</a>

<?php elseif ($tier === "developing"): ?>

<strong>Close the Gaps</strong><br><br>
You are already exposed—you just don’t feel it yet.<br><br>
<a class="button" href="/magrs/join/">Establish Control</a>

<?php else: ?>

<strong>Regain Control</strong><br><br>
AI is influencing outcomes without structure.<br><br>
<a class="button" href="/magrs/join/">Start My Readiness Review</a>

<?php endif; ?>

</div>

</body>
</html>