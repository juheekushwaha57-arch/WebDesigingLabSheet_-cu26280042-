<?php
require 'config/db.php';

$search = trim($_GET['search'] ?? '');

$keyword = "%".$search."%";

$stmt = $conn->prepare(
    "SELECT * FROM books
     WHERE stock > 0
     AND (title LIKE ? OR author LIKE ? OR category LIKE ?)"
);

$stmt->bind_param(
    "sss",
    $keyword,
    $keyword,
    $keyword
);

$stmt->execute();

$result = $stmt->get_result();
?>

<h2>Search Results</h2>

<?php while ($book = $result->fetch_assoc()) { ?>

<div class="card p-3 mb-3">

<h4><?php echo htmlspecialchars($book['title']); ?></h4>

<p>Author: <?php echo htmlspecialchars($book['author']); ?></p>

<p>Price: ₹<?php echo $book['price']; ?></p>

<a href="book.php?id=<?php echo $book['id']; ?>">
View Book
</a>

</div>

<?php } ?>
