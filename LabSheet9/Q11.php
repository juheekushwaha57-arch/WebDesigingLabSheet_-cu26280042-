$limit = 5;

$page = max(1, (int)($_GET["page"] ?? 1));

$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM products
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ii", $limit, $offset);

$stmt->execute();

$result = $stmt->get_result();
