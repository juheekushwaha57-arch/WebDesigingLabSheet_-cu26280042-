<?php

$email = $_POST["email"];

$sql = "SELECT * FROM users
        WHERE email = '$email'";

$result = $conn->query($sql);

?>
<?php

$email = $_POST["email"];

$stmt = $conn->prepare(
    "SELECT * FROM users WHERE email = ?"
);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();

?>
