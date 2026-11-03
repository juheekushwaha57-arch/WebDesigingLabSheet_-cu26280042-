<?php
require '../config/db.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin'
) {
    exit("Access denied.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $image = trim($_POST['image']);

    if (
        $title === "" || $author === "" ||
        $price < 0 || $stock < 0
    ) {
        exit("Invalid book details.");
    }

    $stmt = $conn->prepare(
        "INSERT INTO books
        (title,author,category,price,stock,image)
        VALUES(?,?,?,?,?,?)"
    );

    $stmt->bind_param(
        "sssd is",
        $title,
        $author,
        $category,
        $price,
        $stock,
        $image
    );

    if ($stmt->execute()) {
        echo "Book added successfully!";
    }
}
?>

<h2>Add New Book</h2>

<form method="POST">

<input name="title" placeholder="Book Title" required>

<input name="author" placeholder="Author" required>

<input name="category" placeholder="Category">

<input type="number" step="0.01"
name="price" placeholder="Price" required>

<input type="number"
name="stock" placeholder="Stock" required>

<input name="image" placeholder="Image filename">

<button type="submit">Add Book</button>

</form>
