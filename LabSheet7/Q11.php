if (isset($_POST['update_cart'])) {

    foreach ($_POST['quantities'] as $id => $qty) {

        $id = filter_var($id, FILTER_VALIDATE_INT);
        $qty = filter_var($qty, FILTER_VALIDATE_INT);

        if (!$id || !$qty || $qty < 1) {
            continue;
        }

        $stmt = $conn->prepare(
            "SELECT stock FROM books WHERE id=?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $book = $stmt->get_result()->fetch_assoc();

        if ($book && $qty <= $book['stock']) {
            $_SESSION['cart'][$id] = $qty;
        }
    }
}
