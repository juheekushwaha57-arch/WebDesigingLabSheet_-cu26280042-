<?php
require 'config/db.php';

$result = $conn->query(
    "SELECT * FROM books WHERE stock > 0 ORDER BY id DESC LIMIT 8"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Bookstore</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">

<a class="navbar-brand" href="index.php">
Online Bookstore
</a>

<div class="navbar-nav ms-auto">
<a class="nav-link" href="index.php">Home</a>
<a class="nav-link" href="search.php">Books</a>
<a class="nav-link" href="cart.php">Cart</a>
<a class="nav-link" href="login.php">Login</a>
<a class="nav-link" href="register.php">Register</a>
</div>

</div>
</nav>

<div class="container mt-4">

<div class="banner text-center">
<h1>Welcome to Online Bookstore</h1>
<p>Discover your next favorite book!</p>

<form action="search.php" method="GET">
<input type="text" name="search"
placeholder="Search books..." required>
<button class="btn btn-primary">Search</button>
</form>
</div>

<h2 class="mt-5 mb-4">Featured Books</h2>

<div class="row">

<?php while($book = $result->fetch_assoc()) { ?>

<div class="col-md-3 mb-4">

<div class="card book-card">

<img src="images/<?php echo htmlspecialchars($book['image']); ?>"
class="card-img-top" height="220"
alt="Book cover">

<div class="card-body">

<h5>
<?php echo htmlspecialchars($book['title']); ?>
</h5>

<p>
Author: <?php echo htmlspecialchars($book['author']); ?>
</p>

<p>Price: ₹<?php echo $book['price']; ?></p>

<a href="book.php?id=<?php echo $book['id']; ?>"
class="btn btn-primary">View Details</a>

</div>
</div>
</div>

<?php } ?>

</div>
</div>

</body>
</html>
