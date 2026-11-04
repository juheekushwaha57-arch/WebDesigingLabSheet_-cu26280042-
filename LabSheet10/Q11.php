<?php
$email = "test@example.com";
$url = "https://example.com";
$int = "42";

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Valid Email: " . htmlspecialchars($email) . "<br>";
}
if (filter_var($url, FILTER_VALIDATE_URL)) {
    echo "Valid URL: " . htmlspecialchars($url) . "<br>";
}
if (filter_var($int, FILTER_VALIDATE_INT)) {
    echo "Valid Integer: " . intval($int) . "<br>";
}
?>
