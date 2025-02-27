<?php
// Path: app/Core/Controller.php

namespace App\Core;

/**
 * Base Controller
 * 
 * Provides common functionality for all controllers
 */
class Controller
{
    /**
     * @var \PDO $db Database connection
     */
    protected $db;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Database connection
     */
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    /**
     * Render a view
     * 
     * @param string $view View file path (without .php extension)
     * @param array $data Data to pass to the view
     * @return void
     */
    protected function render($view, $data = [])
    {
        // Extract data to make variables available in view
        extract($data);
        
        // Define the full path to the view file
        $viewFile = ROOT_PATH . '/resources/views/' . $view . '.php';
        
        // Check if view file exists
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: {$viewFile}");
        }
        
        // Include the view file
        require_once $viewFile;
    }
    
    /**
     * Redirect to a URL
     * 
     * @param string $url URL to redirect to
     * @return void
     */
    protected function redirect($url)
    {
        // If URL starts with a slash, prepend the base path
        if (strpos($url, '/') === 0) {
            $url = BASE_URL . $url;
        }
        
        header("Location: {$url}");
        exit;
    }
    
    /**
     * Set flash message for the next request
     * 
     * @param string $message Message text
     * @param string $type Message type (success, danger, warning, info)
     * @return void
     */
    protected function setFlashMessage($message, $type = 'info')
    {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
    
    /**
     * Get JSON from request body
     * 
     * @return array|null Decoded JSON or null on failure
     */
    protected function getJsonInput()
    {
        $json = file_get_contents('php://input');
        return json_decode($json, true);
    }
    
    /**
     * Send JSON response
     * 
     * @param mixed $data Data to encode as JSON
     * @param int $statusCode HTTP status code
     * @return void
     */
    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Check if user is authenticated
     * 
     * @return bool
     */
    protected function isAuthenticated()
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Require authentication to access a method
     * 
     * @return void
     * @throws \Exception if user is not authenticated
     */
    protected function requireAuth()
    {
        if (!$this->isAuthenticated()) {
            $this->setFlashMessage('Please log in to access this page.', 'warning');
            $this->redirect('/auth/login');
        }
    }
}