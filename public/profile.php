<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $sql = "UPDATE users SET username='$username' WHERE id=1";
    $conn->query($sql);
    echo "Username updated!";
}
?>
<form method="post">
    New Username: <input type="text" name="username"><br>
    <input type="submit" value="Update">
</form>
