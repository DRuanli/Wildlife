<?php
/***
 * Wildlife Haven - Main entry point
 */

// Define root path
define('ROOT_PATH', __DIR__);

// Load autoloader
require_once ROOT_PATH . '/vendor/autoload.php';

// Load environment variables
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Error reporting based on environment
if ($_ENV['APP_ENV'] === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Start session
session_start();

// Include the routes
require_once ROOT_PATH . '/app/routes.php';

try {
    // Initialize the database connection
    $db = new App\Database\Connection(
        $_ENV['DB_HOST'],
        $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    );

    // Get the current URI
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Remove base path from URI
    $basePath = '/Wildlife';
    define('BASE_URL', $basePath);

    // Strip base path from URI if present
    if (strpos($requestUri, $basePath) === 0) {
        $requestUri = substr($requestUri, strlen($basePath));
    }

    // Ensure URI starts with /
    if (empty($requestUri) || $requestUri[0] !== '/') {
        $requestUri = '/' . $requestUri;
    }
    
    // Initialize router
    $router = new App\Core\Router();

    // Register routes
    $routes = getRoutes();
    foreach ($routes as $route => $handler) {
        list($controller, $method) = explode('@', $handler);
        $router->addRoute($route, $controller, $method);
    }

    // Dispatch the request
    $router->dispatch($requestUri, $db);
    
} catch (Exception $e) {
    // Log error
    error_log($e->getMessage());
    
    // Show error page based on environment
    if ($_ENV['APP_ENV'] === 'production') {
        if (file_exists(ROOT_PATH . '/resources/views/errors/500.php')) {
            require_once ROOT_PATH . '/resources/views/errors/500.php';
        } else {
            echo '<h1>Server Error</h1>';
            echo '<p>Sorry, something went wrong. Please try again later.</p>';
        }
    } else {
        echo '<h1>Error</h1>';
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }
}