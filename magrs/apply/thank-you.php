<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<main>

<h1>Application Received</h1>

<p>
Thank you. Your MAGRS application has been received.
</p>

<p>
Your Organization ID:<br>
<strong><?php echo htmlspecialchars($_GET['id'] ?? ''); ?></strong>
</p>

<p>
We will review your submission and provide next steps shortly.
</p>

<a href="/magrs/">Return to MAGRS</a>

</main>

<?php include '../includes/footer.php'; ?>