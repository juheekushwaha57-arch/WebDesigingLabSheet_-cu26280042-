<?php
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Please login first.");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    exit("Invalid invoice ID.");
}

$stmt = $conn->prepare(
    "SELECT * FROM orders
     WHERE id=? AND user_id=?"
);

$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();

$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    exit("Invoice not found.");
}

$stmt = $conn->prepare(
    "SELECT books.title, order_items.quantity,
            order_items.price
     FROM order_items
     JOIN books ON books.id=order_items.book_id
     WHERE order_items.order_id=?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$items = $stmt->get_result();
?>

<h1>Bookstore Invoice</h1>

<h3>Invoice Number: <?php echo $order['id']; ?></h3>

<p>Date: <?php echo $order['created_at']; ?></p>

<p>Shipping Address:
<?php echo htmlspecialchars($order['shipping_address']); ?>
</p>

<table border="1" cellpadding="10">

<tr>
<th>Book</th>
<th>Quantity</th>
<th>Price</th>
<th>Total</th>
</tr>

<?php while ($item = $items->fetch_assoc()) { ?>

<tr>
<td><?php echo htmlspecialchars($item['title']); ?></td>
<td><?php echo $item['quantity']; ?></td>
<td>₹<?php echo $item['price']; ?></td>
<td>₹<?php echo $item['quantity'] * $item['price']; ?></td>
</tr>

<?php } ?>

</table>

<h3>
Grand Total: ₹<?php echo $order['total_amount']; ?>
</h3>

<button onclick="window.print()">Print Invoice</button>
