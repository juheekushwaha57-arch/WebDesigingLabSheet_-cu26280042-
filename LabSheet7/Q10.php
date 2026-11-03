<?php
require 'config/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add book
if (isset($_POST['add_to_cart'])) {

    $id = filter_input(
        INPUT_POST, 'book_id', FILTER_VALIDATE_INT
    );

    $qty = filter_input(
        INPUT_POST, 'quantity', FILTER_VALIDATE_INT
    );

    if ($id && $qty && $qty > 0) {

        $stmt = $conn->prepare(
            "SELECT stock FROM books WHERE id=?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $book = $stmt->get_result()->fetch_assoc();

        if ($book && $qty <= $book['stock']) {

            $current = $_SESSION['cart'][$id] ?? 0;

            if ($current + $qty <= $book['stock']) {
                $_SESSION['cart'][$id] = $current + $qty;
            } else {
                echo "Not enough stock available.";
            }

        } else {
            echo "Invalid book or insufficient stock.";
        }
    }
}

// Remove book
if (isset($_GET['remove'])) {

    $id = filter_input(
        INPUT_GET, 'remove', FILTER_VALIDATE_INT
    );

    if ($id) {
        unset($_SESSION['cart'][$id]);
    }
}

// Display cart
$total = 0;

foreach ($_SESSION['cart'] as $id => $qty) {

    $stmt = $conn->prepare(
        "SELECT * FROM books WHERE id=? AND stock>0"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $book = $stmt->get_result()->fetch_assoc();

    if ($book) {

        $subtotal = $book['price'] * $qty;
        $total += $subtotal;

        echo htmlspecialchars($book['title']);
        echo " - ₹" . number_format($subtotal, 2);
        echo " - Quantity: " . $qty;

        echo " <a href='cart.php?remove=$id'>Remove</a><br>";
    }
}

echo "<h3>Total: ₹" . number_format($total, 2) . "</h3>";

echo "<a href='checkout.php'>Proceed to Checkout</a>";
?>
