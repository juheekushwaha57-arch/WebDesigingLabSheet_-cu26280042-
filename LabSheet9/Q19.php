
<?php

session_start();

require_once "config/db.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

if (empty($_SESSION["cart"])) {
    exit("Your shopping cart is empty.");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    ?>

    <h2>Checkout</h2>

    <form method="POST">

        <input type="text"
               name="address"
               placeholder="Shipping Address"
               required>

        <button type="submit">
            Place Order
        </button>

    </form>

    <?php

    exit();
}

$address = trim($_POST["address"] ?? "");

if ($address === "") {
    exit("Please enter your shipping address.");
}

$userId = (int)$_SESSION["user_id"];

$cart = $_SESSION["cart"];

try {

    // START TRANSACTION

    $conn->begin_transaction();

    $total = 0;

    $items = [];

    // LOCK PRODUCT RECORDS AND CHECK STOCK

    foreach ($cart as $id => $quantity) {

        $id = (int)$id;
        $quantity = (int)$quantity;

        if ($id < 1 || $quantity < 1) {
            throw new Exception("Invalid cart item.");
        }

        $stmt = $conn->prepare(
            "SELECT id, price, stock
             FROM products
             WHERE id = ?
             FOR UPDATE"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $product = $stmt->get_result()->fetch_assoc();

        if (!$product) {
            throw new Exception("Product not found.");
        }

        if ($quantity > $product["stock"]) {
            throw new Exception("Insufficient product stock.");
        }

        $subtotal = $product["price"] * $quantity;

        $total += $subtotal;

        $items[] = [
            "id" => $id,
            "quantity" => $quantity,
            "price" => $product["price"],
            "subtotal" => $subtotal
        ];
    }

    // INSERT ORDER RECORDS

    foreach ($items as $item) {

        $stmt = $conn->prepare(
            "INSERT INTO orders
            (user_id, product_id, quantity, total_price)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iiid",
            $userId,
            $item["id"],
            $item["quantity"],
            $item["subtotal"]
        );

        $stmt->execute();

        // UPDATE STOCK

        $update = $conn->prepare(
            "UPDATE products
             SET stock = stock - ?
             WHERE id = ? AND stock >= ?"
        );

        $update->bind_param(
            "iii",
            $item["quantity"],
            $item["id"],
            $item["quantity"]
        );

        $update->execute();

        if ($update->affected_rows !== 1) {
            throw new Exception("Stock update failed.");
        }
    }

    // SAVE TRANSACTION

    $conn->commit();

    $_SESSION["cart"] = [];

    echo "<h2>Order Placed Successfully!</h2>";

    echo "<p>Total Amount: ₹" .
         number_format($total, 2) . "</p>";

    echo "<a href='products.php'>Continue Shopping</a>";

} catch (Throwable $e) {

    // CANCEL TRANSACTION

    $conn->rollback();

    error_log($e->getMessage());

    echo "Order could not be completed. Please try again.";

}

?>

