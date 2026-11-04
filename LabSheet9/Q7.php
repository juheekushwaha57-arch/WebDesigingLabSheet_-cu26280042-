
<?php

require_once "config/db.php";
require_once "includes/auth.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $price = filter_var($_POST["price"] ?? null, FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST["stock"] ?? null, FILTER_VALIDATE_INT);
    $description = trim($_POST["description"] ?? "");

    if (
        $name === "" ||
        $category === "" ||
        $price === false ||
        $price < 0 ||
        $stock === false ||
        $stock < 0
    ) {

        $message = "Please enter valid product details.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO products
            (name, category, description, price, stock)
            VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssdi",
            $name,
            $category,
            $description,
            $price,
            $stock
        );

        if ($stmt->execute()) {

            $message = "Product added successfully!";

        } else {

            $message = "Unable to add product.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>Add New Product</h2>

    <p><?= htmlspecialchars($message) ?></p>

    <form method="POST">

        <input type="text" name="name"
               placeholder="Product Name" required>

        <input type="text" name="category"
               placeholder="Category" required>

        <textarea name="description"
                  placeholder="Description"></textarea>

        <input type="number" name="price"
               placeholder="Price"
               min="0" step="0.01" required>

        <input type="number" name="stock"
               placeholder="Stock"
               min="0" required>

        <button type="submit">Add Product</button>

    </form>

</div>

</body>
</html>

