<?php
header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        echo json_encode(["status" => "success", "data" => "Fetching products"]);
        break;
    case 'POST':
        echo json_encode(["status" => "success", "message" => "Product created"]);
        break;
    case 'PUT':
        echo json_encode(["status" => "success", "message" => "Product updated"]);
        break;
    case 'DELETE':
        echo json_encode(["status" => "success", "message" => "Product deleted"]);
        break;
}
?>
