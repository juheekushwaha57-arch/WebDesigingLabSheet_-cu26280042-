
<?php

$allowedColumns = [
    "name",
    "price",
    "category",
    "stock"
];

$column = $_GET["sort"] ?? "name";

if (!in_array($column, $allowedColumns, true)) {
    $column = "name";
}

$order = strtoupper($_GET["order"] ?? "ASC");

if (!in_array($order, ["ASC", "DESC"], true)) {
    $order = "ASC";
}

$sql = "SELECT * FROM products
        ORDER BY $column $order";

$result = $conn->query($sql);

?>

