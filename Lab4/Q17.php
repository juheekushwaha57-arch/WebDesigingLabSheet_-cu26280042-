<?php

require "connection.php";

header('Content-Type: text/csv; charset=utf-8');

header(
    'Content-Disposition: attachment; filename=students.csv'
);

$output = fopen('php://output', 'w');

fputcsv($output, [
    'ID',
    'Name',
    'Email',
    'Enrollment Date'
]);

$stmt = $pdo->query("SELECT * FROM students");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['email'],
        $row['enrollment_date']
    ]);
}

fclose($output);

exit;

?>
