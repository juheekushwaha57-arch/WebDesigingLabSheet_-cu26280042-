
<?php

require_once "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Enter a valid name and email.";

    } elseif (strlen($password) < 8) {

        $message = "Password must contain at least 8 characters.";

    } else {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, password)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param(
            "sss",
            $name,
            $email,
            $hashedPassword
        );

        if ($stmt->execute()) {

            $message = "Registration successful!";

        } else {

            $message = "Registration failed. Email may already exist.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>Create Account</h2>

    <p><?= htmlspecialchars($message) ?></p>

    <form method="POST">

        <input type="text"
               name="name"
               placeholder="Full Name"
               required>

        <input type="email"
               name="email"
               placeholder="Email Address"
               required>

        <input type="password"
               name="password"
               placeholder="Password (8 characters minimum)"
               required minlength="8">

        <button type="submit">Register</button>

    </form>

    <a href="login.php">Already have an account? Login</a>

</div>

</body>
</html>

