<?php require 'header.php'; ?>
<?php require 'config.php'; ?>

<?php

function generateMAGRSID($pdo) {

    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    while (true) {

        $id = '';

        for ($i = 0; $i < 5; $i++) {
            $id .= $chars[random_int(0, strlen($chars) - 1)];
        }

        $public_id = 'MAGRS-' . $id;

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM organizations WHERE public_id = ?");
        $stmt->execute([$public_id]);

        if ($stmt->fetchColumn() == 0) {
            return $public_id;
        }
    }
}

// 🔹 Capture referral + source
$referral = $_GET['ref'] ?? $_POST['referral_id'] ?? null;
$source = $_GET['src'] ?? $_POST['referral_source'] ?? null;

// 🔹 Validate referral
if ($referral) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM organizations WHERE public_id = ?");
    $stmt->execute([$referral]);

    if ($stmt->fetchColumn() == 0) {
        $referral = null;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $public_id = generateMAGRSID($pdo);
    
    $sql = "INSERT INTO organizations 
        (public_id, org_name, contact_name, email, phone, industry, status, level, badge_active, created_at, referred_by, referral_source) 
        VALUES 
        (:public_id, :org_name, :contact_name, :email, :phone, :industry, 'prospect', 0, 0, NOW(), :referred_by, :referral_source)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':public_id' => $public_id,
        ':org_name' => $_POST['org_name'],
        ':contact_name' => $_POST['contact_name'],
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone'],
        ':industry' => $_POST['industry'],
        ':referred_by' => $referral,
        ':referral_source' => $source
    ]);

    echo "<p>Organization created with ID: <strong>$public_id</strong></p>";

    if ($referral) {
        echo "<p class='muted'>Referred by: $referral</p>";
    }
}
?>

<h1>Create Organization</h1>

<form method="POST">

<input type="hidden" name="referral_id" value="<?php echo htmlspecialchars($referral); ?>">
<input type="hidden" name="referral_source" value="<?php echo htmlspecialchars($source); ?>">

<?php if ($referral): ?>
<p class="muted">
Referred by: <strong><?php echo htmlspecialchars($referral); ?></strong>
</p>
<?php endif; ?>

<p>
Organization Name<br>
<input type="text" name="org_name" required>
</p>

<p>
Contact Name<br>
<input type="text" name="contact_name">
</p>

<p>
Email<br>
<input type="email" name="email">
</p>

<p>
Phone<br>
<input type="text" name="phone">
</p>

<p>
Industry<br>
<input type="text" name="industry">
</p>

<p>
<button type="submit">Create Organization</button>
</p>

</form>

<?php require 'footer.php'; ?>