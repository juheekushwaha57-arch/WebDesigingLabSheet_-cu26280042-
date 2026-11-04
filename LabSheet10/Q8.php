<?php
// API Security Header Check
$headers = getallheaders();
$token = $headers['Authorization'] ?? '';

if ($token !== "Bearer secret_token_123") {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}
echo json_encode(["success" => "Access granted to secure API endpoint"]);
?>
