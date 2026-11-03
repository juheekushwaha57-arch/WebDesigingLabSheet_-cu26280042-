<?php
require 'config/db.php';

$limit = 8;

$page = max(
    1,
    filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1
);

$offset = ($page - 1) * $limit;

$total = $conn->query(
    "SELECT COUNT(*) AS total FROM books WHERE stock > 0"
)->fetch_assoc()['total'];

$totalPages = ceil($total / $limit);

$stmt = $conn->prepare(
    "SELECT * FROM books
     WHERE stock > 0
     LIMIT ? OFFSET ?"
);

$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();

$result = $stmt->get_result();

while ($book = $result->fetch_assoc()) {

    echo "<h3>" .
        htmlspecialchars($book['title']) .
        "</h3>";
}

for ($i = 1; $i <= $totalPages; $i++) {

    echo "<a href='books.php?page=$i'>$i</a> ";
}
?>
