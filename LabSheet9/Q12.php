
<?php

require_once "config/db.php";

$name = "%" . trim($_GET["name"] ?? "") . "%";

$category = "%" . trim($_GET["category"] ?? "") . "%";

$min = filter_var($_GET["min"] ?? 0, FILTER_VALIDATE_FLOAT);
$max = filter_var($_GET["max"] ?? 1000000, FILTER_VALIDATE_FLOAT);

if ($min === false || $max === false || $min < 0 || $max < $min) {
    exit("Invalid price range.");
}

$stmt = $conn->prepare(
    "SELECT * FROM products
     WHERE name LIKE ?
     AND category LIKE ?
     AND price BETWEEN ? AND ?"
);

$stmt->bind_param(
    "ssdd",
    $name,
    $category,
    $min,
    $max
);

$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    echo htmlspecialchars($row["name"], ENT_QUOTES, "UTF-8");
    echo " - ₹" . htmlspecialchars($row["price"], ENT_QUOTES, "UTF-8");
    echo "<br>";

}

?>

