<?php
require '../config/db.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin'
) {
    exit("Access denied.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = (int)$_POST['order_id'];
    $status = $_POST['status'];

    $allowed = ['Pending', 'Shipped', 'Delivered'];

    if (in_array($status, $allowed, true)) {

        $stmt = $conn->prepare(
            "UPDATE orders SET status=? WHERE id=?"
        );

        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
    }
}

$result = $conn->query(
    "SELECT orders.*, users.name
     FROM orders
     JOIN users ON orders.user_id=users.id
     ORDER BY orders.id DESC"
);
?>

<h2>Customer Orders</h2>

<?php while ($order = $result->fetch_assoc()) { ?>

<p>
Order ID: <?php echo $order['id']; ?><br>

Customer: <?php echo htmlspecialchars($order['name']); ?><br>

Total: ₹<?php echo $order['total_amount']; ?><br>

Status: <?php echo htmlspecialchars($order['status']); ?>
</p>

<form method="POST">

<input type="hidden" name="order_id"
value="<?php echo $order['id']; ?>">

<select name="status">
<option>Pending</option>
<option>Shipped</option>
<option>Delivered</option>
</select>

<button type="submit">Update Status</button>

</form>

<hr>

<?php } ?>
