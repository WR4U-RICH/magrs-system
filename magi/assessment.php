<?php include $_SERVER['DOCUMENT_ROOT'].'/header.php'; ?>

<main>

<header>
  <div class="title">MAGI Assessment</div>
  <h1>Marshall AI Governance Integrator</h1>
  <p class="tagline">
    This assessment determines whether your organization is a fit for MAGI.
  </p>
</header>

<form method="post" action="/magi/submit-assessment.php">

<h2>Organization</h2>

<p>
  <label>Organization Name</label><br>
  <input type="text" name="org_name" required>
</p>

<p>
  <label>Your Name</label><br>
  <input type="text" name="name" required>
</p>

<p>
  <label>Email</label><br>
  <input type="email" name="email" required>
</p>

<p>
  <label>Organization Type</label><br>
  <input type="text" name="type" placeholder="MSP, Consultant, Agency, etc." required>
</p>

<h2>Access to Customers</h2>

<p>
  <label>How many active business clients or audience members do you reach?</label><br>
  <input type="text" name="reach" placeholder="e.g. 25 clients">
</p>

<p>
  <label>How often do you speak with decision-makers?</label><br>
  <input type="text" name="frequency" placeholder="Daily, weekly, etc.">
</p>

<p>
  <label>Are your clients using AI tools?</label><br>
  <input type="text" name="ai_usage">
</p>

<h2>Sales Readiness</h2>

<p>
  <label>What do you currently sell?</label><br>
  <textarea name="services"></textarea>
</p>

<p>
  <label>How comfortable are you introducing a new paid offering?</label><br>
  <input type="text" name="comfort">
</p>

<h2>Alignment</h2>

<p>
  <label>Why are you interested in MAGI?</label><br>
  <textarea name="why"></textarea>
</p>

<p>
  <label>How many businesses could you introduce to MAGRS in 90 days?</label><br>
  <input type="text" name="potential">
</p>

<h2>Commitment</h2>

<p>
  <label>Are you willing to become a Credentialed MAGRS organization before applying?</label><br>
  <input type="text" name="commitment" placeholder="Yes / No">
</p>

<p>
  <button type="submit">Submit Assessment</button>
</p>

</form>

<p class="muted">
  If your organization is a fit, you will be invited to proceed.
</p>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'].'/footer.php'; ?>