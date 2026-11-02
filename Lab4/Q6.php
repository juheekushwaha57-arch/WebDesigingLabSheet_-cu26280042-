<?php
// Write a PHP script to insert a new student record into the `students` table using prepared statements to prevent SQL injection.[cite: 13]
$host = 'localhost';
$db   = 'college_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("INSERT INTO students (name, email) VALUES (:name, :email)");
    
    // Sample data insertion
    $name = "Rahul Sharma";
    $email = "rahul@example.com";
    
    $stmt->execute(['name' => $name, 'email' => $email]);
    echo "New student record inserted successfully using prepared statements!";
} catch (PDOException $e) {
    echo "Insertion failed: " . $e->getMessage();
}
?>
