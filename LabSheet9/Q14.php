
<?php

$imageName = null;

if (isset($_FILES["image"]) &&
    $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        exit("Image upload failed.");
    }

    $file = $_FILES["image"];

    // Maximum file size: 2 MB
    if ($file["size"] > 2 * 1024 * 1024) {
        exit("Image must be smaller than 2 MB.");
    }

    // Verify actual image MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);

    $mime = $finfo->file($file["tmp_name"]);

    $allowedTypes = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];

    if (!isset($allowedTypes[$mime])) {
        exit("Only JPG, PNG and WEBP images are allowed.");
    }

    if (getimagesize($file["tmp_name"]) === false) {
        exit("Invalid image file.");
    }

    // Generate unique filename
    $imageName = bin2hex(random_bytes(16))
        . "." . $allowedTypes[$mime];

    $uploadDirectory = __DIR__ . "/uploads/";

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true);
    }

    if (!move_uploaded_file(
        $file["tmp_name"],
        $uploadDirectory . $imageName
    )) {
        exit("Unable to save image.");
    }
}

?>

