<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'app_errors.log');

function customErrorPage($code) {
    http_response_code($code);
    if($code == 404) echo "<h1>404 - Page Not Found</h1>";
    if($code == 500) echo "<h1>500 - Internal Server Error</h1>";
}
// Example triggering custom 404 error display
customErrorPage(404);
?>
