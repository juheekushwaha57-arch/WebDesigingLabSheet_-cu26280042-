<?php
session_start();
$max_attempts = 3;
$lockout_time = 300; // 5 minutes

if (isset($_SESSION['lockout']) && time() < $_SESSION['lockout']) {
    die("Account temporarily locked due to multiple failed logins. Try again later.");
}

// Simulated failed login check
$_SESSION['failed_attempts'] = ($_SESSION['failed_attempts'] ?? 0) + 1;
if ($_SESSION['failed_attempts'] >= $max_attempts) {
    $_SESSION['lockout'] = time() + $lockout_time;
    echo "Too many failed attempts. Account locked for 5 minutes.";
} else {
    echo "Invalid login attempt " . $_SESSION['failed_attempts'] . " of $max_attempts.";
}
?>
