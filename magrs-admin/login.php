<?php
session_start();
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND status = 'active'");
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if (isset($_SESSION['redirect_after_login'])) {

    $redirect = $_SESSION['redirect_after_login'];
    unset($_SESSION['redirect_after_login']);

    header("Location: " . $redirect);

} else {

    header("Location: dashboard.php");
}

exit;

    } else {
        $error = "Invalid login.";
    }
}
?>

<h1>MAGRS Admin Login</h1>

<?php if ($error): ?>
<p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">

<p>
Email<br>
<input type="email" name="email" required>
</p>

<p>
Password<br>
<input type="password" name="password" required>
</p>

<p>
<button type="submit">Login</button>
</p>

</form>