<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    include($file);
} else {
    echo "Welcome to the homepage!";
}

header("Location: " . $_SERVER['PHP_SELF']);
exit();
?>
<ul>
    <li><a href="?file=about.php">About</a></li>
    <li><a href="?file=contact.php">Contact</a></li>
</ul>

<h3>DIRECTORY TRAVERSAL</h3>
<p>Try to access sensitive files by manipulating the file parameter:</p>
<ol>
    <li>Access <a href="?file=about.php">about.php</a></li>
    <li>Access <a href="?file=contact.php">contact.php</a></li>
    <li>Try accessing a sensitive file: <a href="?file=../includes/secret.php">../includes/secret.php</a></li>
</ol>
<p>
    This happens because the programmer includes the file directly without validation:
    <pre>
    if (isset($_GET['file'])) {
        $file = $_GET['file'];
        include($file);
    }
    </pre>
</p>
