
<?php

require_once "config/db.php";

$limit = 5;

$page = max(1, (int)($_GET["page"] ?? 1));

$offset = ($page - 1) * $limit;

$search = trim($_GET["search"] ?? "");
$category = trim($_GET["category"] ?? "");

$minPrice = $_GET["min_price"] ?? "";
$maxPrice = $_GET["max_price"] ?? "";

$sortOptions = [
    "name" => "name",
    "price" => "price",
    "category" => "category",
    "stock" => "stock"
];

$sort = $_GET["sort"] ?? "id";
$order = strtoupper($_GET["order"] ?? "ASC");

$sortColumn = $sortOptions[$sort] ?? "id";
$order = in_array($order, ["ASC", "DESC"], true)
    ? $order : "ASC";

$sql = "SELECT * FROM products
        WHERE name LIKE ?
        AND category LIKE ?";

$types = "ss";

$params = [
    "%$search%",
    "%$category%"
];

if ($minPrice !== "" && is_numeric($minPrice)) {

    $sql .= " AND price >= ?";
    $types .= "d";
    $params[] = (float)$minPrice;
}

if ($maxPrice !== "" && is_numeric($maxPrice)) {

    $sql .= " AND price <= ?";
    $types .= "d";
    $params[] = (float)$maxPrice;
}

// Count records
$countSql = "SELECT COUNT(*) AS total FROM products
             WHERE name LIKE ?
             AND category LIKE ?";

$countTypes = "ss";
$countParams = ["%$search%", "%$category%"];

if ($minPrice !== "" && is_numeric($minPrice)) {
    $countSql .= " AND price >= ?";
    $countTypes .= "d";
    $countParams[] = (float)$minPrice;
}

if ($maxPrice !== "" && is_numeric($maxPrice)) {
    $countSql .= " AND price <= ?";
    $countTypes .= "d";
    $countParams[] = (float)$maxPrice;
}

$countStmt = $conn->prepare($countSql);
$countStmt->bind_param($countTypes, ...$countParams);
$countStmt->execute();

$total = $countStmt->get_result()->fetch_assoc()["total"];

$totalPages = max(1, ceil($total / $limit));

// Fetch products
$sql .= " ORDER BY $sortColumn $order LIMIT ? OFFSET ?";

$types .= "ii";

$params[] = $limit;
$params[] = $offset;

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();

function e($value) {
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        "UTF-8"
    );
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>Available Products</h2>

    <form method="GET">

        <input type="text"
               name="search"
               placeholder="Search product"
               value="<?= e($search) ?>">

        <input type="text"
               name="category"
               placeholder="Category"
               value="<?= e($category) ?>">

        <input type="number"
               name="min_price"
               placeholder="Minimum Price"
               step="0.01"
               value="<?= e($minPrice) ?>">

        <input type="number"
               name="max_price"
               placeholder="Maximum Price"
               step="0.01"
               value="<?= e($maxPrice) ?>">

        <button type="submit">Search</button>

    </form>

    <br>

    <table>

        <tr>
            <th>
                <a href="?sort=name&order=ASC">Name ↑</a>
                <a href="?sort=name&order=DESC">↓</a>
            </th>

            <th>Category</th>

            <th>
                <a href="?sort=price&order=ASC">Price ↑</a>
                <a href="?sort=price&order=DESC">↓</a>
            </th>

            <th>Stock</th>

            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>

        <tr>

            <td><?= e($row["name"]) ?></td>

            <td><?= e($row["category"]) ?></td>

            <td>₹<?= e($row["price"]) ?></td>

            <td><?= e($row["stock"]) ?></td>

            <td>

                <a href="edit_product.php?id=<?= (int)$row["id"] ?>">
                    Edit
                </a>

                <form method="POST"
                      action="delete_product.php"
                      onsubmit="return confirm('Delete this product?');"
                      style="display:inline">

                    <input type="hidden"
                           name="id"
                           value="<?= (int)$row["id"] ?>">

                    <button type="submit">Delete</button>

                </form>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

    <br>

    <!-- PAGINATION -->

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>

        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>">
            <?= $i ?>
        </a>

    <?php endfor; ?>

    <br><br>

    <a href="dashboard.php">Back to Dashboard</a>

</div>

</body>
</html>

