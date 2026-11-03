<?php
require '../config/db.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin'
) {
    exit("Access denied.");
}
?>

<h1>Admin Dashboard</h1>

<a href="add_book.php">Add New Book</a><br><br>

<a href="manage_books.php">Manage Books</a><br><br>

<a href="orders.php">Manage Orders</a><br><br>

<a href="sales_report.php">Sales Reports</a>
