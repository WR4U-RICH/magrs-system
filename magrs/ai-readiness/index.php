<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<main>

<h1>AI Governance Readiness Assessment</h1>

<p>
This assessment evaluates your organization’s visibility, control, and accountability in AI-assisted work.
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

<!-- Q1 -->
<p>
1. Do you have visibility into how AI tools are used across your organization?<br>
<label><input type="radio" name="ai_visibility" value="full" required> Full visibility</label><br>
<label><input type="radio" name="ai_visibility" value="partial"> Partial visibility</label><br>
<label><input type="radio" name="ai_visibility" value="none"> No visibility</label>
</p>

<!-- Q2 -->
<p>
2. Are AI tools approved and controlled?<br>
<label><input type="radio" name="ai_tool_control" value="controlled" required> Approved tools only</label><br>
<label><input type="radio" name="ai_tool_control" value="informal"> Informal usage</label><br>
<label><input type="radio" name="ai_tool_control" value="none"> No control</label>
</p>

<!-- Q3 -->
<p>
3. Is responsibility for AI-assisted work clearly defined?<br>
<label><input type="radio" name="ai_accountability" value="defined" required> Clearly defined</label><br>
<label><input type="radio" name="ai_accountability" value="shared"> Shared responsibility</label><br>
<label><input type="radio" name="ai_accountability" value="undefined"> Not defined</label>
</p>

<!-- Q4 -->
<p>
4. Is accountability documented?<br>
<label><input type="radio" name="ai_accountability_docs" value="yes" required> Documented</label><br>
<label><input type="radio" name="ai_accountability_docs" value="partial"> Partially documented</label><br>
<label><input type="radio" name="ai_accountability_docs" value="no"> Not documented</label>
</p>

<!-- Q5 -->
<p>
5. Do you have a formal AI usage policy?<br>
<label><input type="radio" name="ai_policy" value="enforced" required> Enforced</label><br>
<label><input type="radio" name="ai_policy" value="exists"> Exists but not enforced</label><br>
<label><input type="radio" name="ai_policy" value="none"> No policy</label>
</p>

<!-- Q6 -->
<p>
6. Are employees trained on AI usage risks?<br>
<label><input type="radio" name="ai_training" value="yes" required> Formal training</label><br>
<label><input type="radio" name="ai_training" value="limited"> Limited awareness</label><br>
<label><input type="radio" name="ai_training" value="none"> No training</label>
</p>

<!-- Q7 -->
<p>
7. Are AI-assisted decisions reviewed?<br>
<label><input type="radio" name="ai_decision" value="controlled" required> Controlled usage</label><br>
<label><input type="radio" name="ai_decision" value="informal"> Informal use</label><br>
<label><input type="radio" name="ai_decision" value="none"> No oversight</label>
</p>

<!-- Q8 -->
<p>
8. Is there a process for escalating AI-related issues?<br>
<label><input type="radio" name="ai_escalation" value="yes" required> Defined escalation</label><br>
<label><input type="radio" name="ai_escalation" value="unclear"> Unclear process</label><br>
<label><input type="radio" name="ai_escalation" value="no"> No escalation path</label>
</p>

<!-- Q9 -->
<p>
9. Is sensitive data protected from AI exposure?<br>
<label><input type="radio" name="ai_data_risk" value="controlled" required> Controlled data use</label><br>
<label><input type="radio" name="ai_data_risk" value="uncertain"> Uncertain exposure</label><br>
<label><input type="radio" name="ai_data_risk" value="exposed"> Data exposure risk</label>
</p>

<!-- Q10 -->
<p>
10. Are there controls on what data can be used with AI?<br>
<label><input type="radio" name="ai_data_controls" value="strict" required> Strict controls</label><br>
<label><input type="radio" name="ai_data_controls" value="partial"> Partial controls</label><br>
<label><input type="radio" name="ai_data_controls" value="none"> No controls</label>
</p>

<!-- Q11 -->
<p>
11. Is AI-generated output reviewed before use?<br>
<label><input type="radio" name="ai_review" value="always" required> Always reviewed</label><br>
<label><input type="radio" name="ai_review" value="sometimes"> Sometimes reviewed</label><br>
<label><input type="radio" name="ai_review" value="never"> Never reviewed</label>
</p>

<!-- Q12 -->
<p>
12. Are AI usage practices audited or reviewed periodically?<br>
<label><input type="radio" name="ai_audit" value="yes" required> Regular audits</label><br>
<label><input type="radio" name="ai_audit" value="rare"> Rare audits</label><br>
<label><input type="radio" name="ai_audit" value="no"> No audits</label>
</p>

<br>

<button type="submit">Submit Assessment</button>

</form>

</main>

<?php include '../includes/footer.php'; ?>