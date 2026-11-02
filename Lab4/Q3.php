<?php

$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli(
    $servername,
    $username,
    $password
);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

echo "MySQL Connected Successfully!<br>";

$sql = "CREATE DATABASE IF NOT EXISTS college_db";

if ($conn->query($sql) === TRUE) {
    echo "Database college_db created successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

?>
