<?php require 'header.php'; ?>
<?php require 'config.php'; ?>

<?php

$applicants = $pdo->query("SELECT * FROM organizations WHERE status='applicant' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

$prospects = $pdo->query("SELECT * FROM organizations WHERE status='prospect' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

$active = $pdo->query("SELECT * FROM organizations WHERE status='active' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

$suspended = $pdo->query("SELECT * FROM organizations WHERE status='suspended' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// 🔹 Referral leaderboard (now includes quality)
$refStats = $pdo->query("
    SELECT public_id, org_name, referral_credentials, referral_compliant
    FROM organizations
    WHERE referral_credentials > 0 OR referral_compliant > 0
    ORDER BY referral_compliant DESC, referral_credentials DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
<title>MAGRS Admin Console</title>

<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 40px;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f5f5f5;
    text-align: left;
}
</style>

</head>

<body>

<h2>Organization Registry</h2>

<!-- ===================== -->
<!-- REFERRAL SUMMARY -->
<!-- ===================== -->

<h3>Referral Activity</h3>

<table>
<tr>
<th>MAGRS ID</th>
<th>Organization</th>
<th>Credentialed</th>
<th>Compliant</th>
</tr>

<?php foreach ($refStats as $r): ?>
<tr>
<td><?php echo $r['public_id']; ?></td>
<td><?php echo $r['org_name']; ?></td>
<td><?php echo $r['referral_credentials']; ?></td>
<td><?php echo $r['referral_compliant']; ?></td>
</tr>
<?php endforeach; ?>

</table>

<!-- ===================== -->
<!-- APPLICANTS -->
<!-- ===================== -->

<h2>Applicants</h2>

<table>
<tr>
<th>ID</th>
<th>MAGRS ID</th>
<th>Organization</th>
<th>Contact</th>
<th>Email</th>
<th>Referred By</th>
<th>Source</th>
<th>Status</th>
<th>Actions</th>
</tr>

<?php foreach ($applicants as $org): ?>
<tr>
<td><?php echo $org['id']; ?></td>
<td><?php echo $org['public_id']; ?></td>
<td><a href="org_detail.php?id=<?php echo $org['id']; ?>"><?php echo $org['org_name']; ?></a></td>
<td><?php echo $org['contact_name']; ?></td>
<td><?php echo $org['email']; ?></td>
<td><?php echo $org['referred_by'] ?? '-'; ?></td>
<td><?php echo $org['referral_source'] ?? '-'; ?></td>
<td><?php echo $org['status']; ?></td>
<td>
<a href="update_status.php?id=<?php echo $org['id']; ?>&status=active">Approve</a> |
<a href="update_status.php?id=<?php echo $org['id']; ?>&status=suspended">Reject</a>
</td>
</tr>
<?php endforeach; ?>
</table>

<!-- ===================== -->
<!-- PROSPECTS -->
<!-- ===================== -->

<h2>Prospects</h2>

<table>
<tr>
<th>ID</th>
<th>MAGRS ID</th>
<th>Organization</th>
<th>Contact</th>
<th>Email</th>
<th>Referred By</th>
<th>Source</th>
<th>Status</th>
<th>Actions</th>
</tr>

<?php foreach ($prospects as $org): ?>
<tr>
<td><?php echo $org['id']; ?></td>
<td><?php echo $org['public_id']; ?></td>
<td><a href="org_detail.php?id=<?php echo $org['id']; ?>"><?php echo $org['org_name']; ?></a></td>
<td><?php echo $org['contact_name']; ?></td>
<td><?php echo $org['email']; ?></td>
<td><?php echo $org['referred_by'] ?? '-'; ?></td>
<td><?php echo $org['referral_source'] ?? '-'; ?></td>
<td><?php echo $org['status']; ?></td>
<td>
<a href="update_status.php?id=<?php echo $org['id']; ?>&status=active">Activate</a> |
<a href="update_status.php?id=<?php echo $org['id']; ?>&status=suspended">Suspend</a>
</td>
</tr>
<?php endforeach; ?>
</table>

<!-- ===================== -->
<!-- ACTIVE -->
<!-- ===================== -->

<h2>Active Organizations</h2>

<table>
<tr>
<th>ID</th>
<th>MAGRS ID</th>
<th>Organization</th>
<th>Contact</th>
<th>Email</th>
<th>Referred By</th>
<th>Source</th>
<th>Status</th>
<th>Actions</th>
</tr>

<?php foreach ($active as $org): ?>
<tr>
<td><?php echo $org['id']; ?></td>
<td><?php echo $org['public_id']; ?></td>
<td><a href="org_detail.php?id=<?php echo $org['id']; ?>"><?php echo $org['org_name']; ?></a></td>
<td><?php echo $org['contact_name']; ?></td>
<td><?php echo $org['email']; ?></td>
<td><?php echo $org['referred_by'] ?? '-'; ?></td>
<td><?php echo $org['referral_source'] ?? '-'; ?></td>
<td><?php echo $org['status']; ?></td>
<td>
<a href="update_status.php?id=<?php echo $org['id']; ?>&status=suspended">Suspend</a>
</td>
</tr>
<?php endforeach; ?>
</table>

<!-- ===================== -->
<!-- SUSPENDED -->
<!-- ===================== -->

<h2>Suspended Organizations</h2>

<table>
<tr>
<th>ID</th>
<th>MAGRS ID</th>
<th>Organization</th>
<th>Contact</th>
<th>Email</th>
<th>Referred By</th>
<th>Source</th>
<th>Status</th>
<th>Actions</th>
</tr>

<?php foreach ($suspended as $org): ?>
<tr>
<td><?php echo $org['id']; ?></td>
<td><?php echo $org['public_id']; ?></td>
<td><a href="org_detail.php?id=<?php echo $org['id']; ?>"><?php echo $org['org_name']; ?></a></td>
<td><?php echo $org['contact_name']; ?></td>
<td><?php echo $org['email']; ?></td>
<td><?php echo $org['referred_by'] ?? '-'; ?></td>
<td><?php echo $org['referral_source'] ?? '-'; ?></td>
<td><?php echo $org['status']; ?></td>
<td>
<a href="update_status.php?id=<?php echo $org['id']; ?>&status=active">Reactivate</a>
</td>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>

<?php require 'footer.php'; ?>