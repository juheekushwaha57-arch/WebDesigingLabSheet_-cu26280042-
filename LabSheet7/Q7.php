<?php
require 'config/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("Invalid book ID");
}

$stmt = $conn->prepare(
    "SELECT * FROM books WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$book = $stmt->get_result()->fetch_assoc();

if (!$book) {
    exit("Book not found");
}
?>

<h1><?php echo htmlspecialchars($book['title']); ?></h1>

<p>Author:
<?php echo htmlspecialchars($book['author']); ?></p>

<p>Price: ₹<?php echo $book['price']; ?></p>

<p>Available Stock: <?php echo $book['stock']; ?></p>

<p>
<?php echo nl2br(htmlspecialchars($book['description'])); ?>
</p>

<form action="cart.php" method="POST">
<input type="hidden" name="book_id"
value="<?php echo $book['id']; ?>">

<input type="number" name="quantity"
value="1" min="1" max="<?php echo $book['stock']; ?>">

<button type="submit" name="add_to_cart">
Add to Cart
</button>
</form>
