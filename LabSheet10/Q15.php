<?php
if(isset($_POST['upload'])) {
    $file = $_FILES['document'];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);

    if(in_array($mimeType, $allowedMimeTypes) && $file['size'] < 2000000) {
        $newName = uniqid() . "_" . basename($file['name']);
        // Store outside public root for absolute security
        $destination = "../secure_uploads/" . $newName;
        move_uploaded_file($file['tmp_name'], $destination);
        echo "File uploaded securely outside public web root.";
    } else {
        echo "Invalid file type or size exceeded.";
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="document" required>
    <button type="submit" name="upload">Upload Securely</button>
</form>
