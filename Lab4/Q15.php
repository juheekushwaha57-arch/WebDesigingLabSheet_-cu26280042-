<?php

session_start();

$_SESSION['username'] = "Rahul";

echo "Session Created Successfully!";

echo "<br>";

echo "Welcome " . htmlspecialchars(
    $_SESSION['username']
);

?>
