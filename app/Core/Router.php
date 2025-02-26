<?php
// Path: app/Core/Router.php

namespace App\Core;

/**
 * Router Class
 * 
 * Handles routing of requests to appropriate controllers and methods
 */
class Router
{
    /**
     * @var array $routes List of registered routes
     */
    private $routes = [];
    
    /**
     * Add a route to the router
     * 
     * @param string $route Route pattern
     * @param string $controllerName Controller class name
     * @param string $methodName Controller method name
     * @return void
     */
    public function addRoute($route, $controllerName, $methodName)
    {
        $this->routes[$route] = [
            'controller' => $controllerName,
            'method' => $methodName
        ];
    }
    
    /**
     * Dispatch a request to the appropriate controller
     * 
     * @param string $uri Request URI
     * @param \PDO $db Database connection
     * @return void
     * @throws \Exception if route not found
     */
    public function dispatch($uri, $db)
    {
        // Remove trailing slash
        $uri = rtrim($uri, '/');
        
        // If URI is empty, use '/' as default
        if (empty($uri)) {
            $uri = '/';
        }
        
        // Check for exact route match
        if (isset($this->routes[$uri])) {
            $this->executeController($uri, [], $db);
            return;
        }
        
        // Check for dynamic routes with parameters
        foreach ($this->routes as $route => $handler) {
            $pattern = $this->convertRouteToRegex($route);
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove the full match
                
                // Extract named parameters
                $params = [];
                
                if (strpos($route, ':') !== false) {
                    preg_match_all('/:([a-zA-Z0-9_]+)/', $route, $paramNames);
                    $paramNames = $paramNames[1];
                    
                    foreach ($paramNames as $index => $name) {
                        $params[$name] = $matches[$index];
                    }
                }
                
                $this->executeController($route, $params, $db);
                return;
            }
        }
        
        // No route found
        $this->handleNotFound();
    }
    
    /**
     * Convert route pattern to regex
     * 
     * @param string $route Route pattern
     * @return string Regex pattern
     */
    private function convertRouteToRegex($route)
    {
        // Replace named parameters with regex capture groups
        $pattern = preg_replace('/:([a-zA-Z0-9_]+)/', '([^/]+)', $route);
        
        // Escape forward slashes and construct the regex
        $pattern = '#^' . str_replace('/', '\/', $pattern) . '$#';
        
        return $pattern;
    }
    
    /**
     * Execute a controller method
     * 
     * @param string $route Route pattern
     * @param array $params Route parameters
     * @param \PDO $db Database connection
     * @return void
     * @throws \Exception if controller or method not found
     */
    private function executeController($route, $params, $db)
    {
        $controllerName = $this->routes[$route]['controller'];
        $methodName = $this->routes[$route]['method'];
        
        // Check if controller exists
        $controllerClass = "\\App\\Http\\Controllers\\{$controllerName}";
        
        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller not found: {$controllerClass}");
        }
        
        // Create controller instance
        $controller = new $controllerClass($db);
        
        // Check if method exists
        if (!method_exists($controller, $methodName)) {
            throw new \Exception("Method not found: {$controllerClass}::{$methodName}");
        }
        
        // Call the controller method with parameters
        call_user_func_array([$controller, $methodName], [$params]);
    }
    
    /**
     * Handle 404 Not Found
     * 
     * @return void
     */
    private function handleNotFound()
    {
        http_response_code(404);
        
        if (file_exists(ROOT_PATH . '/resources/views/errors/404.php')) {
            require_once ROOT_PATH . '/resources/views/errors/404.php';
        } else {
            echo '<h1>404 Not Found</h1>';
            echo '<p>The requested page could not be found.</p>';
        }
        
        exit;
    }
}