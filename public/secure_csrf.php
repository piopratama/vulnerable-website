<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = true;
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }
    // Perform an action, e.g., change email
    $email = $_POST['email'];
    echo "Email changed to: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<form method="post">
    Email: <input type="text" name="email"><br>
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
    <input type="submit" value="Change Email">
</form>

<h3>SECURING AGAINST CSRF</h3>
<p>To secure against CSRF, include a CSRF token in your forms and verify this token on the server side:</p>
<pre>
&lt;form method="post"&gt;
    Email: &lt;input type="text" name="email"&gt;&lt;br&gt;
    &lt;input type="hidden" name="csrf_token" value="&lt;?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?&gt;"&gt;
    &lt;input type="submit" value="Change Email"&gt;
&lt;/form&gt;
</pre>
<p>The token is verified on the server side to ensure the request is legitimate.</p>
