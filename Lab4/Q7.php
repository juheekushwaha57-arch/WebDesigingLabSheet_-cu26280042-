<?php
// Develop a PHP script to retrieve and display all records from the `students` table inside a styled HTML table.[cite: 13]
$host = 'localhost';
$db   = 'college_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $stmt = $pdo->query("SELECT * FROM students");
    $students = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-family: Arial; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Student List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Enrollment Date</th>
        </tr>
        <?php if (!empty($students)) { foreach ($students as $row) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['enrollment_date']); ?></td>
        </tr>
        <?php } } else { ?>
        <tr><td colspan="4">No records found.</td></tr>
        <?php } ?>
    </table>
</body>
</html>

