<?php
require 'config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$email || strlen($password) < 8 || $name === "") {
        $message = "Please enter valid details.";
    } else {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users(name,email,password)
             VALUES(?,?,?)"
        );

        $stmt->bind_param("sss", $name, $email, $hash);

        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Email already registered.";
        }
    }
}
?>

<h2>User Registration</h2>

<form method="POST" onsubmit="return validateRegister()">

<input type="text" name="name" id="name"
placeholder="Enter Name" required>

<input type="email" name="email"
placeholder="Enter Email" required>

<input type="password" name="password" id="password"
placeholder="Enter Password" required minlength="8">

<button type="submit">Register</button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>
