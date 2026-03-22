<?php
require 'config.php';

$org_id = $_POST['org_id'];
$year = $_POST['year'];
$quarter = $_POST['quarter'];

$stmt = $pdo->prepare("
UPDATE quarterly_reports
SET submitted = 1,
submitted_at = NOW()
WHERE org_id = :org_id
AND report_year = :year
AND report_quarter = :quarter
");

$stmt->execute([
':org_id' => $org_id,
':year' => $year,
':quarter' => $quarter
]);

$quarter_string = $year . "Q" . $quarter;

$stmt = $pdo->prepare("
UPDATE organizations
SET last_report_quarter = :q
WHERE id = :org_id
");

$stmt->execute([
':q' => $quarter_string,
':org_id' => $org_id
]);

echo "Report submitted successfully.";
?>