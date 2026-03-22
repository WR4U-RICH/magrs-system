<?php

define('MAGRS_SYSTEM', true);

require $_SERVER['DOCUMENT_ROOT'].'/magrs/includes/db.php';
require $_SERVER['DOCUMENT_ROOT'].'/magrs/includes/id-generator.php';

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $org_name = $_POST['org_name'];
    $contact_name = $_POST['contact_name'];
    $email = $_POST['email'];
    $industry = $_POST['industry'];

    $public_id = generate_magrs_id();

    $stmt = $pdo->prepare("
        INSERT INTO organizations
        (public_id, org_name, contact_name, email, industry, status, level, badge_active, created_at)
        VALUES
        (?, ?, ?, ?, ?, 'prospect', 0, 0, NOW())
    ");

    $stmt->execute([
        $public_id,
        $org_name,
        $contact_name,
        $email,
        $industry
    ]);

    $message = "Organization created. Credential ID: ".$public_id;

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Create Organization</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

body{
font-family:Arial;
max-width:700px;
margin:40px auto;
line-height:1.6;
}

input{
width:100%;
padding:10px;
margin-bottom:15px;
}

button{
padding:10px 20px;
}

.success{
background:#e8f5e9;
padding:15px;
margin-bottom:20px;
}

</style>

</head>

<body>

<h1>Create Organization</h1>

<?php if($message): ?>
<div class="success"><?php echo $message; ?></div>
<?php endif; ?>

<form method="POST">

<label>Organization Name</label>
<input name="org_name" required>

<label>Contact Name</label>
<input name="contact_name">

<label>Email</label>
<input name="email" type="email">

<label>Industry</label>
<input name="industry">

<button type="submit">Create Organization</button>

</form>

</body>
</html>