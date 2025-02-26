<?php
// Place this file in your project root (diagnostic.php)

// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Wildlife Haven Diagnostic Tool</h1>";

// Check PHP version
echo "<h2>PHP Environment</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Required: PHP 8.1 or higher<br>";

// Check autoloading
echo "<h2>Autoloading Check</h2>";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    echo "✓ Autoloader found<br>";
} catch (Exception $e) {
    echo "✗ Autoloader error: " . $e->getMessage() . "<br>";
    echo "Run 'composer install' to set up autoloading<br>";
}

// Check critical directories
echo "<h2>Directory Structure</h2>";
$directories = [
    '/app',
    '/app/Core',
    '/app/Database',
    '/app/Http',
    '/app/Http/Controllers',
    '/app/Models', 
    '/app/Services',
    '/resources',
    '/resources/views',
    '/resources/views/auth',
    '/resources/views/layouts',
    '/resources/views/errors',
];

foreach ($directories as $dir) {
    $fullPath = __DIR__ . $dir;
    if (is_dir($fullPath)) {
        echo "✓ {$dir} directory exists<br>";
    } else {
        echo "✗ {$dir} directory missing<br>";
    }
}

// Check critical files
echo "<h2>Critical Files</h2>";
$files = [
    '/index.php',
    '/app/routes.php',
    '/app/Core/Router.php',
    '/app/Core/Controller.php',
    '/app/Database/Connection.php',
    '/app/Http/Controllers/AuthController.php',
    '/app/Http/Controllers/HomeController.php',
    '/resources/views/auth/login.php',
    '/resources/views/layouts/header.php',
    '/resources/views/layouts/footer.php',
];

foreach ($files as $file) {
    $fullPath = __DIR__ . $file;
    if (file_exists($fullPath)) {
        echo "✓ {$file} exists<br>";
    } else {
        echo "✗ {$file} missing<br>";
    }
}

// Test database connection
echo "<h2>Database Connection</h2>";
try {
    // Load environment variables
    if (file_exists(__DIR__ . '/.env')) {
        echo "✓ .env file exists<br>";
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        
        echo "Attempting database connection with:<br>";
        echo "Host: " . ($_ENV['DB_HOST'] ?? 'Not defined') . "<br>";
        echo "Database: " . ($_ENV['DB_NAME'] ?? 'Not defined') . "<br>";
        echo "User: " . ($_ENV['DB_USER'] ?? 'Not defined') . "<br>";
        
        try {
            $db = new \App\Database\Connection(
                $_ENV['DB_HOST'] ?? '',
                $_ENV['DB_NAME'] ?? '',
                $_ENV['DB_USER'] ?? '',
                $_ENV['DB_PASS'] ?? ''
            );
            echo "✓ Database connection successful<br>";
        } catch (\Exception $e) {
            echo "✗ Database connection failed: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "✗ .env file missing<br>";
    }
} catch (\Exception $e) {
    echo "✗ Environment setup error: " . $e->getMessage() . "<br>";
}

// Check class loading
echo "<h2>Class Loading Test</h2>";
$classes = [
    'App\\Core\\Router',
    'App\\Core\\Controller',
    'App\\Database\\Connection',
    'App\\Http\\Controllers\\AuthController',
    'App\\Http\\Controllers\\HomeController',
];

foreach ($classes as $class) {
    try {
        if (class_exists($class)) {
            echo "✓ Class {$class} loaded successfully<br>";
        } else {
            echo "✗ Class {$class} not found<br>";
        }
    } catch (\Exception $e) {
        echo "✗ Error checking {$class}: " . $e->getMessage() . "<br>";
    }
}

// Route validation
echo "<h2>Route Configuration</h2>";
try {
    include_once __DIR__ . '/app/routes.php';
    if (function_exists('getRoutes')) {
        $routes = getRoutes();
        echo "✓ Route function found with " . count($routes) . " routes<br>";
        
        echo "<ul>";
        foreach ($routes as $route => $handler) {
            echo "<li>{$route} => {$handler}</li>";
        }
        echo "</ul>";
    } else {
        echo "✗ getRoutes() function not found in routes.php<br>";
    }
} catch (\Exception $e) {
    echo "✗ Error loading routes: " . $e->getMessage() . "<br>";
}

echo "<p>End of diagnostic report</p>";