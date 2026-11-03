<?php
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    exit("Your cart is empty.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $address = trim($_POST['address']);
    $user_id = $_SESSION['user_id'];

    if ($address === "") {
        exit("Shipping address is required.");
    }

    try {
        $conn->begin_transaction();

        $total = 0;
        $items = [];

        foreach ($_SESSION['cart'] as $id => $qty) {

            $stmt = $conn->prepare(
                "SELECT price, stock FROM books
                 WHERE id=? FOR UPDATE"
            );

            $stmt->bind_param("i", $id);
            $stmt->execute();

            $book = $stmt->get_result()->fetch_assoc();

            if (!$book || $qty > $book['stock'] || $qty < 1) {
                throw new Exception("Book stock unavailable.");
            }

            $total += $book['price'] * $qty;

            $items[] = [
                'id' => $id,
                'qty' => $qty,
                'price' => $book['price']
            ];
        }

        $stmt = $conn->prepare(
            "INSERT INTO orders
             (user_id,total_amount,shipping_address)
             VALUES(?,?,?)"
        );

        $stmt->bind_param("ids", $user_id, $total, $address);
        $stmt->execute();

        $order_id = $conn->insert_id;

        foreach ($items as $item) {

            $stmt = $conn->prepare(
                "INSERT INTO order_items
                 (order_id,book_id,quantity,price)
                 VALUES(?,?,?,?)"
            );

            $stmt->bind_param(
                "iiid",
                $order_id,
                $item['id'],
                $item['qty'],
                $item['price']
            );

            $stmt->execute();

            $stmt = $conn->prepare(
                "UPDATE books SET stock=stock-?
                 WHERE id=? AND stock>=?"
            );

            $stmt->bind_param(
                "iii",
                $item['qty'],
                $item['id'],
                $item['qty']
            );

            $stmt->execute();

            if ($stmt->affected_rows !== 1) {
                throw new Exception("Stock update failed.");
            }
        }

        $conn->commit();

        $_SESSION['cart'] = [];
        $_SESSION['last_order_id'] = $order_id;

        header("Location: invoice.php?id=" . $order_id);
        exit;

    } catch (Throwable $e) {

        $conn->rollback();
        $message = "Order could not be placed. Please check stock and try again.";
    }
}
?>

<h2>Checkout</h2>

<form method="POST">

<label>Shipping Address</label>

<textarea name="address" required></textarea>

<button type="submit">Place Order</button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>
