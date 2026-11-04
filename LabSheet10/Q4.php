<?php
$request = $_SERVER['REQUEST_URI'];
$basePath = '/your-project/public/';
$route = str_replace($basePath, '', $request);

switch ($route) {
    case '':
    case 'home':
        echo "Home Controller Action";
        break;
    case 'products':
        echo "Products Controller Action";
        break;
    default:
        http_response_code(404);
        echo "Page Not Found";
        break;
}
?>
