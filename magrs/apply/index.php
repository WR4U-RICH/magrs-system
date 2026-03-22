<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<main>

<h1>MAGRS Participation Application</h1>

<p>
This application confirms your organization’s intent to participate in the Marshall AI Governance Readiness Standard (MAGRS).
</p>

<h2>Before You Continue</h2>

<ul>
<li>You have completed the AI readiness assessment</li>
<li>You understand the purpose of MAGRS</li>
<li>You are prepared to maintain quarterly reporting</li>
</ul>

<h2>Participation Overview</h2>

<p>
Initial Readiness Review: <strong>$85</strong><br>
Annual Participation: <strong>$295</strong>
</p>

<h2>Application</h2>

<form method="post" action="/magrs/apply/submit.php">

<label>Organization Name</label><br>
<input type="text" name="org_name" required><br><br>

<label>Contact Name</label><br>
<input type="text" name="contact_name" required><br><br>

<label>Email</label><br>
<input type="email" name="email" required><br><br>

<label>Role</label><br>
<input type="text" name="role"><br><br>

<label>
<input type="checkbox" required>
I understand that participation includes quarterly reporting requirements
</label><br><br>

<button type="submit">Submit Application</button>

</form>

<p class="muted">
Submission does not obligate payment. Next steps will be provided upon review.
</p>

</main>

<?php include '../includes/footer.php'; ?>