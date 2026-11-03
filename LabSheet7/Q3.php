<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "online_bookstore";

$conn = new mysqli(
    $host,
    $user,
    $password,
    $database
);

if ($conn->connect_error) {
    die("Database connection failed");
}

$conn->set_charset("utf8mb4");

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    session_start();
}
?>
