<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SSRF Vulnerability</title>
</head>
<body>
    <h2>Fetch URL Content</h2>
    <form action="ssrf.php" method="get">
        Enter URL to fetch:
        <input type="text" name="url" id="url">
        <input type="submit" value="Fetch">
    </form>

    <?php
    if (isset($_GET['url'])) {
        $url = $_GET['url'];
        $response = file_get_contents($url);
        echo "<h3>Fetched Content:</h3>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    }
    ?>
</body>
</html>

<h3>SERVER-SIDE REQUEST FORGERY (SSRF)</h3>
<p>SSRF attacks exploit the server to perform requests to arbitrary domains, potentially exposing internal services or sensitive data. To test this vulnerability:</p>
<ol>
    <li>Access the SSRF form by navigating to <code>http://localhost/vulnerable-website/public/ssrf.php</code>.</li>
    <li>Enter <code>file:///C:/Windows/system32/drivers/etc/hosts</code> to get information about the server</li>
</ol>
<p>This vulnerability occurs because the server blindly fetches content from any URL provided by the user, allowing attackers to access internal services or sensitive data.</p>
