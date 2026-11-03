<?php
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Please login first.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = $_SESSION['user_id'];
    $book = (int)$_POST['book_id'];
    $rating = (int)$_POST['rating'];
    $comment = trim($_POST['comment']);

    if ($rating < 1 || $rating > 5) {
        exit("Invalid rating.");
    }

    $stmt = $conn->prepare(
        "INSERT INTO reviews
         (user_id,book_id,rating,comment)
         VALUES(?,?,?,?)
         ON DUPLICATE KEY UPDATE
         rating=VALUES(rating),
         comment=VALUES(comment)"
    );

    $stmt->bind_param(
        "iiis",
        $user,
        $book,
        $rating,
        $comment
    );

    $stmt->execute();

    echo "Review submitted successfully!";
}
?>

<h2>Write a Review</h2>

<form method="POST">

<input type="number" name="book_id"
placeholder="Book ID" required>

<select name="rating">
<option value="5">5 Stars</option>
<option value="4">4 Stars</option>
<option value="3">3 Stars</option>
<option value="2">2 Stars</option>
<option value="1">1 Star</option>
</select>

<textarea name="comment"
placeholder="Write your review"></textarea>

<button type="submit">Submit Review</button>

</form>
