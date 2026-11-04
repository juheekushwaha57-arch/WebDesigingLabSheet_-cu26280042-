
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

?>

<?php

require_once "includes/auth.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Welcome to Dashboard</h1>

    <h2>
        Hello,
        <?= htmlspecialchars($_SESSION["user_name"]) ?>!
    </h2>

    <p>You have successfully logged in.</p>

    <a href="products.php">View Products</a>

    <br><br>

    <a href="add_product.php">Add Product</a>

    <br><br>

    <a href="cart.php">Shopping Cart</a>

    <br><br>

    <a href="logout.php">Logout</a>

</div>

</body>
</html>

