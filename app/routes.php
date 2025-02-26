<?php
// Path: app/Core/Controller.php

namespace App\Database;

/**
 * Database Connection Class
 * 
 * Manages database connections using PDO
 */
class Connection extends \PDO
{
    /**
     * Constructor
     * 
     * @param string $host Database host
     * @param string $dbname Database name
     * @param string $username Database username
     * @param string $password Database password
     */
    public function __construct($host, $dbname, $username, $password)
    {
        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
        
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ];
        
        try {
            parent::__construct($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            // Log error but don't expose sensitive info
            error_log('Database connection failed: ' . $e->getMessage());
            throw new \Exception('Database connection failed. Please try again later.');
        }
    }
    function getRoutes() {
        return [
            '/' => 'HomeController@index',
            '/auth/login' => 'AuthController@showLogin',
            '/auth/login/process' => 'AuthController@login',
            '/auth/register' => 'AuthController@showRegister',
            '/auth/register/process' => 'AuthController@register',
            '/auth/logout' => 'AuthController@logout',
            '/dashboard' => 'DashboardController@index'
        ];
    }
}