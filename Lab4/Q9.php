<?php
// Implement a PHP script to delete a specific student record from the database using a URL parameter (`GET` request).[cite: 13]
$host = 'localhost';
$db   = 'college_db';
$user = 'root';
$pass = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$id]);

        echo "Student with ID $id deleted successfully!";
    } catch (PDOException $e) {
        echo "Deletion failed: " . $e->getMessage();
    }
} else {
    echo "Please provide a student ID in the URL parameter, e.g., ?id=1";
}
?>
