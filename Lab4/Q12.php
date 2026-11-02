<?php
// Implement user authentication in PHP by verifying submitted username and password against stored MySQL database records.[cite: 13]
$host = 'localhost';
$db   = 'college_db';
$user = 'root';
$pass = '';

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $userData = $stmt->fetch();

        if ($userData && password_verify($password, $userData['password'])) {
            $message = "Login successful! Welcome " . htmlspecialchars($username);
        } else {
            $message = "Invalid username or password!";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <form method="POST">
        <h2>User Authentication</h2>
        <p><?php echo $message; ?></p>
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
