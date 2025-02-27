<?php
/**
 * Wildlife Haven - Main Application Entry Point
 * 
 * This file serves as the front controller for the Wildlife Haven application,
 * embodying Japandi aesthetic principles of simplicity, natural harmony,
 * and purposeful design throughout the user experience.
 * 
 * The Japandi approach combines Japanese minimalism with Scandinavian functionality,
 * creating a calm, balanced interface that focuses on what matters most.
 */

// Define root path constant for consistent file referencing
define('ROOT_PATH', __DIR__);

// Define base URL for consistent path handling across the application
$basePath = $config['app']['base_path'] ?? '/Wildlife';
define('BASE_URL', $basePath);

// Load composer autoloader for class management
require_once ROOT_PATH . '/vendor/autoload.php';

// Load environment variables from .env file
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Site configuration - establish visual harmony
$config = [
    // Japandi-inspired color palette
    'colors' => [
        'primary' => '#6A8D73',    // Muted sage green - natural & calming
        'secondary' => '#F4F0E6',  // Warm off-white - creates breathing space
        'accent' => '#D7C0AE',     // Warm wooden accent
        'text' => '#2D2D2A',       // Soft charcoal for readable text
        'subtle' => '#E8E4DC'      // Light neutral for subtle dividers
    ],
    // Clean, intentional typography choices
    'fonts' => [
        'primary' => "'Nunito', sans-serif",     // Primary sans-serif with gentle curves
        'headings' => "'Noto Serif', serif",     // Light serif for headings
    ],
    // Base application information
    'app' => [
        'name' => $_ENV['APP_NAME'] ?? 'Wildlife Haven',
        'url' => $_ENV['APP_URL'] ?? 'http://localhost',
        'env' => $_ENV['APP_ENV'] ?? 'development',
        'debug' => (bool)($_ENV['APP_DEBUG'] ?? true),
        'base_path' => '/Wildlife'
    ]
];

// Configure error handling based on environment
// Japandi principle: Show only what's necessary, but make it meaningful
if ($config['app']['env'] === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Start session for user state management
session_start();

// Include application routes
require_once ROOT_PATH . '/app/routes.php';

try {
    // Initialize database connection
    // Connecting to data sources with intentionality
    $db = new App\Database\Connection(
        $_ENV['DB_HOST'],
        $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    );

    // Get the current URI
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    // Remove base path from URI for clean route matching
    $basePath = $config['app']['base_path'];
    if (strpos($requestUri, $basePath) === 0) {
        $requestUri = substr($requestUri, strlen($basePath));
    }
    
    // Ensure URI starts with / for consistency
    if (empty($requestUri) || $requestUri[0] !== '/') {
        $requestUri = '/' . $requestUri;
    }
    
    // Initialize router - the pathway through our digital space
    $router = new App\Core\Router();

    // Register routes - connecting spaces with purpose
    $routes = getRoutes();
    foreach ($routes as $route => $handler) {
        list($controller, $method) = explode('@', $handler);
        $router->addRoute($route, $controller, $method);
    }

    // Dispatch the request to appropriate controller
    // This embodies the Japandi principle of "every element has a purpose"
    $router->dispatch($requestUri, $db);
    
} catch (\Exception $e) {
    // Log error for administrators
    error_log($e->getMessage());
    
    // Display serene error page aligned with Japandi aesthetic
    // Showing only what's necessary, with ample negative space
    if ($config['app']['env'] === 'production') {
        // Production error page - clean, minimal, calming
        http_response_code(500);
        require_once ROOT_PATH . '/resources/views/errors/500.php';
    } else {
        // Development error page - more detailed but still clean
        http_response_code(500);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error - Wildlife Haven</title>
            <link rel="icon" href="<?= $basePath ?>/favicon.ico" type="image/x-icon">
            <style>
                /* Japandi-inspired error page styling */
                body {
                    font-family: <?= $config['fonts']['primary'] ?>;
                    background-color: <?= $config['colors']['secondary'] ?>;
                    color: <?= $config['colors']['text'] ?>;
                    line-height: 1.6;
                    padding: 2rem;
                    margin: 0;
                }
                .container {
                    max-width: 800px;
                    margin: 0 auto;
                    background-color: #fff;
                    padding: 2rem;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
                }
                h1 {
                    font-family: <?= $config['fonts']['headings'] ?>;
                    font-weight: 300;
                    font-size: 2rem;
                    margin-top: 0;
                    color: <?= $config['colors']['primary'] ?>;
                    border-bottom: 1px solid <?= $config['colors']['subtle'] ?>;
                    padding-bottom: 1rem;
                }
                .error-message {
                    background-color: <?= $config['colors']['subtle'] ?>;
                    padding: 1rem;
                    border-radius: 4px;
                    margin: 1rem 0;
                }
                .error-trace {
                    font-family: monospace;
                    font-size: 0.875rem;
                    background-color: #f8f8f8;
                    padding: 1rem;
                    overflow-x: auto;
                    border-radius: 4px;
                    margin-top: 1rem;
                }
                .back-link {
                    display: inline-block;
                    margin-top: 1.5rem;
                    color: <?= $config['colors']['primary'] ?>;
                    text-decoration: none;
                    border-bottom: 1px solid;
                }
                .back-link:hover {
                    opacity: 0.8;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>An error occurred</h1>
                <p>Something went wrong while processing your request. This issue has been logged.</p>
                
                <div class="error-message">
                    <?= htmlspecialchars($e->getMessage()) ?>
                </div>
                
                <div class="error-trace">
                    <?= nl2br(htmlspecialchars($e->getTraceAsString())) ?>
                </div>
                
                <a href="<?= $basePath ?>/" class="back-link">Return to home page</a>
            </div>
        </body>
        </html>
        <?php
    }
}
?>