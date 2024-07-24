<?php
$whitelist = ['about.php', 'contact.php'];

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    if (in_array($file, $whitelist)) {
        include($file);
    } else {
        echo "Invalid file.";
    }
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

<h3>SECURING AGAINST DIRECTORY TRAVERSAL</h3>
<p>This version of the script uses a whitelist to prevent directory traversal attacks:</p>
<pre>
$whitelist = ['about.php', 'contact.php'];

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    if (in_array($file, $whitelist)) {
        include($file);
    } else {
        echo "Invalid file.";
    }
}
</pre>
<p>The whitelist ensures only specific files can be included, preventing arbitrary file inclusion.</p>
<p>
    By using a whitelist, we limit the files that can be included to those we explicitly allow.
    This prevents attackers from accessing sensitive files on the server.
</p>
