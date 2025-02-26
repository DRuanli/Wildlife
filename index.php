<?php
/***
 * 
 */

// Include the configuration file
define('ROOT_PATH', __DIR__);

//Load environment variables
require_once ROOT_PATH . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//Error reporting based on environment
if ($_ENV['APP_ENV'] === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}


// Start session
session_start();

// Include the router
require_once ROOT_PATH . '/app/router.php';

// Initialize the database connection
$db = new App\Database\Connection(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

// Get the current URI
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Initialize router
$router = new App\Core\Router();

// Register routes
$routes = getRoutes();
foreach ($routes as $route => $handler) {
    list($controller, $method) = explode('@', $handler);
    $router->addRoute($route, $controller, $method);
}

// Dispatch the request
try {
    $router->dispatch($requestUri, $db);
} catch (Exception $e) {
    // Log error
    error_log($e->getMessage());
    
    // Show error page based on environment
    if ($_ENV['APP_ENV'] === 'production') {
        require_once ROOT_PATH . '/resources/views/errors/500.php';
    } else {
        echo '<h1>Error</h1>';
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }
}