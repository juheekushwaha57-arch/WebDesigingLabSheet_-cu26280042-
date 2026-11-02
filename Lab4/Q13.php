<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_FILES['image']) ||
        $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        exit("File upload failed.");
    }

    $file = $_FILES['image'];

    $allowed = ['jpg', 'jpeg', 'png'];

    $extension = strtolower(
        pathinfo($file['name'], PATHINFO_EXTENSION)
    );

    if ($file['size'] > 2 * 1024 * 1024) {
        exit("File size must be below 2 MB.");
    }

    if (!in_array($extension, $allowed, true)) {
        exit("Invalid file extension.");
    }

    $mime = mime_content_type($file['tmp_name']);

    if (!in_array($mime, [
        'image/jpeg',
        'image/png'
    ], true)) {
        exit("Invalid image type.");
    }

    $filename = bin2hex(random_bytes(16)) .
                "." . $extension;

    $destination = __DIR__ . "/uploads/" . $filename;

    if (move_uploaded_file(
        $file['tmp_name'],
        $destination
    )) {
        echo "Image Uploaded Successfully!";
    } else {
        echo "Upload Failed!";
    }
}
?>

<form method="POST" enctype="multipart/form-data">

    Select Image:
    <input type="file" name="image" required>

    <button type="submit">Upload</button>

</form>
