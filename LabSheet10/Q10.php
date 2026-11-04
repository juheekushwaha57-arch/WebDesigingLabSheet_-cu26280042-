<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true, // set true if using HTTPS
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
// Prevent session fixation after login
session_regenerate_id(true);
echo "Secure session configured and ID regenerated.";
?>
