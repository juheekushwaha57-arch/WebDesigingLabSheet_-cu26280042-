
<?php

session_start();

require_once "config/db.php";

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// ADD PRODUCT TO CART

if (isset($_POST["add"])) {

    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT);

    if (!$id || !$quantity || $quantity < 1) {
        exit("Invalid product or quantity.");
    }

    $stmt = $conn->prepare(
        "SELECT id, name, price, stock
         FROM products WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $product = $stmt->get_result()->fetch_assoc();

    if (!$product) {
        exit("Product not found.");
    }

    $currentQuantity = $_SESSION["cart"][$id] ?? 0;

    if ($currentQuantity + $quantity > $product["stock"]) {

        exit("Not enough stock available.");

    }

    $_SESSION["cart"][$id] = $currentQuantity + $quantity;

}

// UPDATE QUANTITY

if (isset($_POST["update"])) {

    $id = (int)($_POST["id"] ?? 0);
    $quantity = (int)($_POST["quantity"] ?? 0);

    if ($quantity <= 0) {

        unset($_SESSION["cart"][$id]);

    } else {

        $stmt = $conn->prepare(
            "SELECT stock FROM products WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $product = $stmt->get_result()->fetch_assoc();

        if ($product && $quantity <= $product["stock"]) {

            $_SESSION["cart"][$id] = $quantity;

        } else {

            exit("Requested quantity exceeds stock.");
        }
    }
}

// REMOVE PRODUCT

if (isset($_POST["remove"])) {

    $id = (int)($_POST["id"] ?? 0);

    unset($_SESSION["cart"][$id]);
}

$total = 0;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>My Shopping Cart</h2>

    <?php foreach ($_SESSION["cart"] as $id => $quantity): ?>

        <?php

        $stmt = $conn->prepare(
            "SELECT * FROM products WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $product = $stmt->get_result()->fetch_assoc();

        if (!$product) {
            unset($_SESSION["cart"][$id]);
            continue;
        }

        $subtotal = $product["price"] * $quantity;

        $total += $subtotal;

        ?>

        <div class="cart-item">

            <h3>
                <?= htmlspecialchars($product["name"], ENT_QUOTES, "UTF-8") ?>
            </h3>

            <p>Price: ₹<?= $product["price"] ?></p>

            <p>Subtotal: ₹<?= $subtotal ?></p>

            <form method="POST">

                <input type="hidden" name="id"
                       value="<?= (int)$id ?>">

                <input type="number"
                       name="quantity"
                       min="1"
                       max="<?= (int)$product["stock"] ?>"
                       value="<?= (int)$quantity ?>">

                <button name="update">Update</button>

                <button name="remove">Remove</button>

            </form>

        </div>

        <hr>

    <?php endforeach; ?>

    <h3>Total Amount: ₹<?= number_format($total, 2) ?></h3>

    <a href="products.php">Continue Shopping</a>

    <br><br>

    <a href="checkout.php">Proceed to Checkout</a>

</div>

</body>
</html>

