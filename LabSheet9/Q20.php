
<?php

require_once "config/db.php";

header("Content-Type: application/json; charset=UTF-8");

$query = trim($_GET["q"] ?? "");

if (strlen($query) < 2) {

    echo json_encode([]);

    exit();
}

$search = "%" . $query . "%";

$stmt = $conn->prepare(
    "SELECT id, name, price
     FROM products
     WHERE name LIKE ?
     LIMIT 10"
);

$stmt->bind_param("s", $search);

$stmt->execute();

$result = $stmt->get_result();

$products = [];

while ($row = $result->fetch_assoc()) {

    $products[] = [
        "id" => (int)$row["id"],
        "name" => $row["name"],
        "price" => $row["price"]
    ];

}

echo json_encode(
    $products,
    JSON_HEX_TAG |
    JSON_HEX_APOS |
    JSON_HEX_QUOT |
    JSON_HEX_AMP
);

?>

