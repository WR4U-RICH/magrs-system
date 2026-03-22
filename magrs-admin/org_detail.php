<?php
require 'header.php';
require 'config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM organizations WHERE id = :id");
$stmt->execute([':id' => $id]);

$org = $stmt->fetch(PDO::FETCH_ASSOC);

// 🔹 Count credentialed referrals
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM organizations 
    WHERE referred_by = :public_id AND status = 'active'
");
$stmt->execute([':public_id' => $org['public_id']]);
$referral_count = $stmt->fetchColumn();

// 🔹 Count total referred
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM organizations 
    WHERE referred_by = :public_id
");
$stmt->execute([':public_id' => $org['public_id']]);
$total_referred = $stmt->fetchColumn();

// 🔹 Campaign source (auto-generated per org)
$source = "ORG-" . $org['public_id'];

// 🔹 Referral link with campaign tracking
$ref_link = "https://marshall.net/magrs-admin/create_org.php?ref=" 
    . urlencode($org['public_id']) 
    . "&src=" . urlencode($source);
?>

<h1>Organization Detail</h1>

<p><strong>MAGRS ID:</strong> <?php echo $org['public_id']; ?></p>

<p><strong>Organization:</strong> <?php echo $org['org_name']; ?></p>

<p><strong>Contact:</strong> <?php echo $org['contact_name']; ?></p>

<p><strong>Email:</strong> <?php echo $org['email']; ?></p>

<p><strong>Phone:</strong> <?php echo $org['phone']; ?></p>

<p><strong>Industry:</strong> <?php echo $org['industry']; ?></p>

<p><strong>Status:</strong> <?php echo $org['status']; ?></p>

<p>
<strong>Referred By:</strong>
<?php echo $org['referred_by'] ? htmlspecialchars($org['referred_by']) : '-'; ?>
</p>

<h2>Referral Activity</h2>

<p><strong>Total Referred:</strong> <?php echo $total_referred; ?></p>

<p><strong>Credentialed Referrals:</strong> <?php echo $referral_count; ?></p>

<p style="font-size: 0.9em; color: #666;">
Referral activity accumulates based on organizations that enter and progress through the MAGRS system.
</p>

<h3>Your Referral Link</h3>

<input 
    type="text" 
    value="<?php echo htmlspecialchars($ref_link); ?>" 
    style="width:100%; padding:8px;" 
    readonly
    onclick="this.select();"
/>

<p style="font-size: 0.9em; color: #666;">
Includes tracking to measure referral performance.
</p>

<p>
<strong>Verification URL:</strong><br>

<a href="https://marshall.net/magrs/verify/<?= htmlspecialchars($org['public_id']) ?>" target="_blank">
https://marshall.net/magrs/verify/<?= htmlspecialchars($org['public_id']) ?>
</a>
</p>

<h2>Participation Settings</h2>

<form method="POST" action="update_participation.php">

<input type="hidden" name="id" value="<?php echo $org['id']; ?>">

<p>
Level<br>
<input type="number" name="level" value="<?php echo $org['level']; ?>">
</p>

<p>
Participation Start<br>
<input type="date" name="participation_start" value="<?php echo $org['participation_start']; ?>">
</p>

<p>
Renewal Date<br>
<input type="date" name="renewal_date" value="<?php echo $org['renewal_date']; ?>">
</p>

<p>
<button type="submit">Update Participation</button>
</p>

</form>

<p>
<a href="update_status.php?id=<?php echo $org['id']; ?>&status=prospect">Set Prospect</a> |
<a href="update_status.php?id=<?php echo $org['id']; ?>&status=active">Activate</a> |
<a href="update_status.php?id=<?php echo $org['id']; ?>&status=suspended">Suspend</a>
</p>

<p><strong>Level:</strong> <?php echo $org['level']; ?></p>

<p><strong>Created:</strong> <?php echo $org['created_at']; ?></p>

<p><strong>Badge Active:</strong> <?php echo $org['badge_active'] ? 'Yes' : 'No'; ?></p>

<p>
<a href="update_badge.php?id=<?php echo $org['id']; ?>&badge=1">Activate Badge</a> |
<a href="update_badge.php?id=<?php echo $org['id']; ?>&badge=0">Deactivate Badge</a>
</p>

<p><strong>Badge Preview:</strong></p>

<a href="https://marshall.net/magrs/verify/<?php echo $org['public_id']; ?>" target="_blank">
<img src="/images/magrs-badge.png" style="width:160px;">
</a>

<p><strong>Website Embed Code:</strong></p>

<textarea style="width:100%;height:90px;">
<a href="https://marshall.net/magrs/verify/<?php echo $org['public_id']; ?>" target="_blank">
<img src="https://marshall.net/images/magrs-badge.png" alt="MAGRS Participating Organization">
</a>
</textarea>

<p>
<a href="dashboard.php">← Back to Dashboard</a>
</p>

<?php require 'footer.php'; ?>