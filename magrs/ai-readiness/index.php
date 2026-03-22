<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<main>

<h1>AI Governance Readiness Assessment</h1>

<p>
Complete this short assessment to evaluate your organization’s readiness for AI governance.
</p>

<form method="POST" action="/magrs/ai-readiness/submit.php">

<!-- Hidden tracking -->
<input type="hidden" name="ref" value="<?php echo htmlspecialchars($_GET['ref'] ?? ''); ?>">
<input type="hidden" name="src" value="<?php echo htmlspecialchars($_GET['src'] ?? ''); ?>">

<h2>Organization Information</h2>

<p>
Organization Name<br>
<input type="text" name="org_name" required>
</p>

<p>
Contact Name<br>
<input type="text" name="contact_name" required>
</p>

<p>
Email<br>
<input type="email" name="email" required>
</p>

<p>
Role<br>
<input type="text" name="role">
</p>

<hr>

<h2>Assessment</h2>

<p>
1. Are employees using AI tools such as ChatGPT or Copilot?<br>
<label><input type="radio" name="ai_use" value="yes" required> Yes</label><br>
<label><input type="radio" name="ai_use" value="sometimes"> Sometimes</label><br>
<label><input type="radio" name="ai_use" value="no"> No</label>
</p>

<p>
2. Has leadership discussed AI use within the organization?<br>
<label><input type="radio" name="ai_discussion" value="formal" required> Yes, formally</label><br>
<label><input type="radio" name="ai_discussion" value="informal"> Informally</label><br>
<label><input type="radio" name="ai_discussion" value="none"> Not yet</label>
</p>

<p>
3. Does your organization have guidance for AI-assisted work?<br>
<label><input type="radio" name="ai_policy" value="yes" required> Yes</label><br>
<label><input type="radio" name="ai_policy" value="no"> No</label><br>
<label><input type="radio" name="ai_policy" value="unsure"> Unsure</label>
</p>

<p>
4. Who is responsible for work produced with AI assistance?<br>
<label><input type="radio" name="ai_responsibility" value="employee" required> Individual employee</label><br>
<label><input type="radio" name="ai_responsibility" value="supervisor"> Supervisor</label><br>
<label><input type="radio" name="ai_responsibility" value="leadership"> Organizational leadership</label><br>
<label><input type="radio" name="ai_responsibility" value="undefined"> Not clearly defined</label>
</p>

<br>

<button type="submit">Submit Assessment</button>

</form>

</main>

<?php include '../includes/footer.php'; ?>