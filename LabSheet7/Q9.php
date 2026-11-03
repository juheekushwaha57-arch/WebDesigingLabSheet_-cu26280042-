<?php
require 'config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if ($email) {

        $stmt = $conn->prepare(
            "SELECT * FROM users WHERE email=?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify(
            $password, $user['password']
        )) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            header("Location: index.php");
            exit;

        } else {
            $message = "Invalid email or password.";
        }
    }
}
?>

<h2>User Login</h2>

<form method="POST">
<input type="email" name="email"
placeholder="Email" required>

<input type="password" name="password"
placeholder="Password" required>

<button type="submit">Login</button>
</form>

<p><?php echo htmlspecialchars($message); ?></p>
