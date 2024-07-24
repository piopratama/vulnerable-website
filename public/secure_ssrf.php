<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure SSRF</title>
</head>
<body>
    <h2>Fetch URL Content</h2>
    <form action="secure_ssrf.php" method="get">
        Enter URL to fetch:
        <input type="text" name="url" id="url">
        <input type="submit" value="Fetch">
    </form>

    <?php
    if (isset($_GET['url'])) {
        $url = $_GET['url'];

        // Allow only specific domains
        $allowed_domains = ['example.com'];
        $parsed_url = parse_url($url);
        if (in_array($parsed_url['host'], $allowed_domains)) {
            $response = file_get_contents($url);
            echo "<h3>Fetched Content:</h3>";
            echo "<pre>" . htmlspecialchars($response) . "</pre>";
        } else {
            echo "<p>URL not allowed.</p>";
        }
    }
    ?>
</body>
</html>
