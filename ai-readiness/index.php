<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<main>

<h1>MAGRS AI Governance Readiness Assessment</h1>

<p>
This 7-minute assessment evaluates how your organization manages responsibility, visibility, and risk in AI-assisted work.
</p>

<form method="POST" action="/magrs/ai-readiness/submit.php">

<input type="hidden" name="ref" value="<?php echo htmlspecialchars($_GET['ref'] ?? ''); ?>">
<input type="hidden" name="src" value="<?php echo htmlspecialchars($_GET['src'] ?? ''); ?>">

<h2>Organization Information</h2>

<p>Organization Name<br><input type="text" name="org_name" required></p>
<p>Contact Name<br><input type="text" name="contact_name" required></p>
<p>Email<br><input type="email" name="email" required></p>
<p>Role<br><input type="text" name="role"></p>

<hr>

<h2>1. Visibility</h2>

<p>
Do you know where AI tools are being used?<br>
<label><input type="radio" name="ai_visibility" value="full" required> Fully tracked</label><br>
<label><input type="radio" name="ai_visibility" value="partial"> Some awareness</label><br>
<label><input type="radio" name="ai_visibility" value="none"> No visibility</label>
</p>

<p>
Are new AI tools introduced with oversight?<br>
<label><input type="radio" name="ai_tool_control" value="controlled" required> Yes</label><br>
<label><input type="radio" name="ai_tool_control" value="informal"> Sometimes</label><br>
<label><input type="radio" name="ai_tool_control" value="none"> No</label>
</p>

<h2>2. Accountability</h2>

<p>
Who is responsible for AI-assisted work?<br>
<label><input type="radio" name="ai_accountability" value="defined" required> Clearly assigned</label><br>
<label><input type="radio" name="ai_accountability" value="shared"> Informal</label><br>
<label><input type="radio" name="ai_accountability" value="undefined"> Not defined</label>
</p>

<p>
Are responsibilities documented?<br>
<label><input type="radio" name="ai_accountability_docs" value="yes" required> Yes</label><br>
<label><input type="radio" name="ai_accountability_docs" value="partial"> Partially</label><br>
<label><input type="radio" name="ai_accountability_docs" value="no"> No</label>
</p>

<h2>3. Policy</h2>

<p>
Do you have AI usage policies?<br>
<label><input type="radio" name="ai_policy" value="enforced" required> Enforced</label><br>
<label><input type="radio" name="ai_policy" value="exists"> Exists</label><br>
<label><input type="radio" name="ai_policy" value="none"> None</label>
</p>

<p>
Are employees trained on AI usage?<br>
<label><input type="radio" name="ai_training" value="yes" required> Yes</label><br>
<label><input type="radio" name="ai_training" value="limited"> Limited</label><br>
<label><input type="radio" name="ai_training" value="none"> No</label>
</p>

<h2>4. Decision Authority</h2>

<p>
Who approves AI-assisted decisions?<br>
<label><input type="radio" name="ai_decision" value="controlled" required> Formal approval</label><br>
<label><input type="radio" name="ai_decision" value="informal"> Informal</label><br>
<label><input type="radio" name="ai_decision" value="none"> None</label>
</p>

<p>
Is escalation defined?<br>
<label><input type="radio" name="ai_escalation" value="yes" required> Yes</label><br>
<label><input type="radio" name="ai_escalation" value="unclear"> Unclear</label><br>
<label><input type="radio" name="ai_escalation" value="no"> No</label>
</p>

<h2>5. Data Risk</h2>

<p>
Is sensitive data used in AI tools?<br>
<label><input type="radio" name="ai_data_risk" value="controlled" required> Controlled</label><br>
<label><input type="radio" name="ai_data_risk" value="uncertain"> Possibly</label><br>
<label><input type="radio" name="ai_data_risk" value="exposed"> Yes</label>
</p>

<p>
Are restrictions enforced on data use?<br>
<label><input type="radio" name="ai_data_controls" value="strict" required> Strict</label><br>
<label><input type="radio" name="ai_data_controls" value="partial"> Partial</label><br>
<label><input type="radio" name="ai_data_controls" value="none"> None</label>
</p>

<h2>6. Review & Oversight</h2>

<p>
Are AI outputs reviewed?<br>
<label><input type="radio" name="ai_review" value="always" required> Always</label><br>
<label><input type="radio" name="ai_review" value="sometimes"> Sometimes</label><br>
<label><input type="radio" name="ai_review" value="never"> Never</label>
</p>

<p>
Are decisions audited?<br>
<label><input type="radio" name="ai_audit" value="yes" required> Yes</label><br>
<label><input type="radio" name="ai_audit" value="rare"> Rarely</label><br>
<label><input type="radio" name="ai_audit" value="no"> No</label>
</p>

<br><br>

<button type="submit">Submit Assessment</button>

</form>

</main>

<?php include '../includes/footer.php'; ?>