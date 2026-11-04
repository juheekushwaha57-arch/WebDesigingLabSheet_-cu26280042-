
<?php

require_once "config/db.php";
require_once "includes/auth.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("Invalid product ID.");
}

$stmt = $conn->prepare(
    "SELECT * FROM products WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    exit("Product not found.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $price = filter_var($_POST["price"] ?? null, FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST["stock"] ?? null, FILTER_VALIDATE_INT);

    if (
        $name === "" ||
        $category === "" ||
        $price === false ||
        $price < 0 ||
        $stock === false ||
        $stock < 0
    ) {

        $message = "Invalid product information.";

    } else {

        $update = $conn->prepare(
            "UPDATE products
             SET name = ?, category = ?, price = ?, stock = ?
             WHERE id = ?"
        );

        $update->bind_param(
            "ssdii",
            $name,
            $category,
            $price,
            $stock,
            $id
        );

        if ($update->execute()) {

            header("Location: products.php");
            exit();

        } else {

            $message = "Unable to update product.";
        }
    }
}

function escape($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>Edit Product</h2>

    <p><?= escape($message) ?></p>

    <form method="POST">

        <input type="text"
               name="name"
               value="<?= escape($product["name"]) ?>"
               required>

        <input type="text"
               name="category"
               value="<?= escape($product["category"]) ?>"
               required>

        <input type="number"
               name="price"
               step="0.01"
               min="0"
               value="<?= escape($product["price"]) ?>"
               required>

        <input type="number"
               name="stock"
               min="0"
               value="<?= escape($product["stock"]) ?>"
               required>

        <button type="submit">Update Product</button>

    </form>

</div>

</body>
</html>

