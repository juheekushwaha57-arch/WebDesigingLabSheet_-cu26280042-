<?php
// Write a PHP script to update an existing student's email address in the database based on their student ID.[cite: 13]
$host = 'localhost';
$db   = 'college_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = 1; // Example student ID
    $newEmail = "new_rahul@example.com";

    $sql = "UPDATE students SET email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $newEmail, 'id' => $id]);

    echo "Student email updated successfully!";
} catch (PDOException $e) {
    echo "Update failed: " . $e->getMessage();
}
?>
