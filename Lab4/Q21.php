<?php

$password = "admin123";

// Generate password hash
$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

echo "Password Hashed Successfully!";

echo "<br>";

// Verify password
if (password_verify(
    "admin123",
    $hashedPassword
)) {

    echo "Password Verified Successfully!";

} else {

    echo "Invalid Password!";

}

?>
