<?php
// Write a PHP script that checks Apache server environment variables and server software details using `$_SERVER` superglobal.[cite: 13]
echo "<h2>Server Environment Details</h2>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Server Name: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "Server Protocol: " . $_SERVER['SERVER_PROTOCOL'] . "<br>";
echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "Client IP Address: " . $_SERVER['REMOTE_ADDR'] . "<br>";
?>
