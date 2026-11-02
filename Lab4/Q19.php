<?php

require "connection.php";

try {

    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        "INSERT INTO students
        (name, email, enrollment_date)
        VALUES (?, ?, ?)"
    );

    $stmt->execute([
        "Amit Kumar",
        "amit@gmail.com",
        "2026-11-02"
    ]);

    $studentId = $pdo->lastInsertId();

    $stmt2 = $pdo->prepare(
        "UPDATE students
         SET email = ?
         WHERE id = ?"
    );

    $stmt2->execute([
        "amit123@gmail.com",
        $studentId
    ]);

    $pdo->commit();

    echo "Transaction Completed Successfully!";

} catch (PDOException $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "Transaction Failed!";
}

?>
