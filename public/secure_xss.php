<?php
$comments_file = '../includes/comments.txt';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
    file_put_contents($comments_file, $comment . "\n", FILE_APPEND);
    // Redirect to the same page to prevent resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$comments = file($comments_file, FILE_IGNORE_NEW_LINES);

foreach ($comments as $comment) {
    echo "Comment: " . $comment . "<br>";
}
?>
<form method="post">
    Comment: <textarea name="comment"></textarea><br>
    <input type="submit" value="Submit">
</form>

<h3>SECURING AGAINST CROSS-SITE SCRIPTING (XSS)</h3>
<p>This version of the script sanitizes user input to prevent XSS attacks:</p>
<pre>
$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
file_put_contents($comments_file, $comment . "\n", FILE_APPEND);
</pre>
<p>The <code>htmlspecialchars</code> function converts special characters to HTML entities, preventing the execution of injected scripts.</p>

<h3>TESTING THE SECURE SCRIPT</h3>
<p>To verify that the script is secure against XSS, try the following tests:</p>
<ol>
    <li>Test with a normal comment to ensure the functionality works as expected.</li>
    <li>Attempt XSS with <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code> as a comment. The script tags should be displayed as text and not executed.</li>
    <li>Attempt XSS with <code>&lt;img src=x onerror=alert('XSS')&gt;</code> as a comment. The <code>onerror</code> attribute should be displayed as text and not executed.</li>
</ol>
<p>These tests confirm that the script properly handles user input and is secure against XSS attacks.</p>
