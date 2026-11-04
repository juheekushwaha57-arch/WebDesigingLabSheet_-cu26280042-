<?php
require_once '2.php';
$conn = Database::getInstance()->getConnection();

if(isset($_POST['reset_request'])) {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", strtotime("+30 minutes"));

    $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
    $stmt->execute([$token, $expiry, $email]);
    echo "Password reset link sent to your email. Token: $token";
}
?>
<form method="POST">
    <input type="email" name="email" placeholder="Enter your registered email" required>
    <button type="submit" name="reset_request">Request Password Reset</button>
</form>
