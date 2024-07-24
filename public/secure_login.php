<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Secure SQL query using prepared statements
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<p>Executed SQL query: SELECT id, username FROM users WHERE username='?' AND password='?'</p>";

    if ($result->num_rows > 0) {
        echo "<h2>RESULT</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<p>ID: " . $row['id'] . " - Username: " . $row['username'] . "</p>";
        }
        echo "========================================================================";
    } else {
        echo "Invalid username or password.";
    }

    // Redirect to the same page to prevent resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<form method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>

<h3>SECURING AGAINST SQL INJECTION</h3>
<p>This version of the script uses prepared statements to prevent SQL Injection:</p>
<pre>
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, username FROM users WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
</pre>
<p>Prepared statements ensure that user input is treated as data, not as part of the SQL query, preventing SQL Injection attacks.</p>

<h3>TESTING THE SECURE SCRIPT</h3>
<p>To verify that the script is secure against SQL Injection, try the following tests:</p>
<ol>
    <li>Test with valid credentials to ensure the normal login functionality works.</li>
    <li>Attempt SQL Injection with <code>admin' OR '1'='1</code> as the username and any password. The login should fail and display "Invalid username or password."</li>
    <li>Attempt SQL Injection with <code>admin' UNION SELECT 1, @@version -- </code> as the username and any password. The login should fail and display "Invalid username or password."</li>
    <li>Attempt SQL Injection with <code>admin' UNION SELECT 1, DATABASE() -- </code> as the username and any password. The login should fail and display "Invalid username or password."</li>
    <li>Attempt SQL Injection with <code>admin' UNION SELECT table_name, NULL FROM information_schema.tables WHERE table_schema = DATABASE() -- </code> as the username and any password. The login should fail and display "Invalid username or password."</li>
    <li>Attempt SQL Injection with <code>admin' UNION SELECT id, CONCAT(username, ':', password), NULL FROM users -- </code> as the username and any password. The login should fail and display "Invalid username or password."</li>
</ol>
<p>These tests confirm that the script properly handles user input and is secure against SQL Injection attacks.</p>
