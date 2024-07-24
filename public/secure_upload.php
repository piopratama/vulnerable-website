<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure File Upload</title>
</head>
<body>
    <h2>Upload File</h2>
    <form action="secure_upload.php" method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>

    <h3>Securing File Upload</h3>
    <p>This version of the script uses several security measures to prevent file upload vulnerabilities:</p>
    <ol>
        <li>Files are stored outside the web root for added security.</li>
        <li>File size is restricted to prevent large file uploads.</li>
        <li>Only specific file types (JPG, JPEG, PNG, GIF) are allowed.</li>
        <li>Uploaded files are given unique names to avoid conflicts and potential execution.</li>
    </ol>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Directory where files will be stored outside the web root for security
    $target_dir = "../uploads/"; // Ensure this directory exists and is writable
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Generate a unique name for the file to avoid conflicts
        $new_file_name = uniqid() . "." . $fileType;
        $target_file = $target_dir . $new_file_name;

        // Move the uploaded file to the secure directory
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
