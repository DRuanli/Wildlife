<?php
// app/helpers.php

if (!function_exists('url')) {
    /**
     * Generate a URL for the application
     * 
     * @param string $path Path relative to the base URL
     * @return string Full URL
     */
    function url($path = '')
    {
        // Remove leading slash if present
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }
        
        return BASE_URL . '/' . $path;
    }
}

if (!function_exists('asset')) {
    /**
     * Generate a URL for an asset
     * 
     * @param string $path Path relative to the assets directory
     * @return string Full URL to the asset
     */
    function asset($path)
    {
        // Remove leading slash if present
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }
        
        return BASE_URL . '/assets/' . $path;
    }
}
