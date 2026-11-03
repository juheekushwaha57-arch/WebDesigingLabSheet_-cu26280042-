<?php
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Please login first.");
}

$user = $_SESSION['user_id'];

if (isset($_POST['book_id'])) {

    $book = (int)$_POST['book_id'];

    $stmt = $conn->prepare(
        "INSERT IGNORE INTO wishlist(user_id,book_id)
         VALUES(?,?)"
    );

    $stmt->bind_param("ii", $user, $book);
    $stmt->execute();
}

$stmt = $conn->prepare(
    "SELECT books.* FROM wishlist
     JOIN books ON wishlist.book_id=books.id
     WHERE wishlist.user_id=?"
);

$stmt->bind_param("i", $user);
$stmt->execute();

$result = $stmt->get_result();

echo "<h2>My Wishlist</h2>";

while ($book = $result->fetch_assoc()) {

    echo "<p>" .
        htmlspecialchars($book['title']) .
        "</p>";
}
?>
