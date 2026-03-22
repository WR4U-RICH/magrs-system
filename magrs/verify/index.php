<?php
define('MAGRS_SYSTEM', true);
require $_SERVER['DOCUMENT_ROOT'].'/magrs-admin/config.php';

$public_id = $_GET['id'] ?? '';

if(!$public_id){
    echo "Verification ID missing.";
    exit;
}

$stmt = $pdo->prepare("
    SELECT org_name, level, badge_active, participation_start
    FROM organizations
    WHERE public_id = ?
");

$stmt->execute([$public_id]);

$org = $stmt->fetch();

if(!$org){
    echo "Organization not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>MAGRS Credential Verification</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

body{
font-family:Arial;
max-width:700px;
margin:40px auto;
line-height:1.6;
}

.badge{
padding:20px;
background:#f5f5f5;
border:1px solid #ddd;
margin-top:30px;
}

.active{
color:green;
font-weight:bold;
}

.inactive{
color:red;
font-weight:bold;
}

</style>
</head>

<body>

<h1>MAGRS Credential Verification</h1>

<div class="badge">

<h2><?php echo htmlspecialchars($org['org_name']); ?></h2>

<p>
Participation Level:
<strong><?php echo $org['level']; ?></strong>
</p>

<p>
Badge Status:
<?php
if($org['badge_active']){
echo "<span class='active'>Active</span>";
}else{
echo "<span class='inactive'>Inactive</span>";
}
?>
</p>

<p>
Participation Start:
<?php echo htmlspecialchars($org['participation_start']); ?>
</p>

</div>

</body>
</html>