<?php
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT * FROM orders
     WHERE user_id=?
     ORDER BY created_at DESC"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<h2>My Order History</h2>

<?php while ($order = $result->fetch_assoc()) { ?>

<div class="card p-3 mb-3">

<h4>Order #<?php echo $order['id']; ?></h4>

<p>Total: ₹<?php echo $order['total_amount']; ?></p>

<p>Status: <?php echo htmlspecialchars($order['status']); ?></p>

<p>Date: <?php echo $order['created_at']; ?></p>

</div>

<?php } ?>
