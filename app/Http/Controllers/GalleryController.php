<?php
// app/Http/Controllers/GalleryController.php

namespace App\Http\Controllers;

use App\Core\Controller;

class GalleryController extends Controller
{
    /**
     * Display the gallery page
     * 
     * @return void
     */
    public function index()
    {
        // Read creature data from JSON file
        $jsonPath = ROOT_PATH . '/resources/data/gallery.json';
        $creatures = [];
        
        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
            $creatures = json_decode($jsonContent, true) ?: [];
        }
        
        $data = [
            'creatures' => $creatures,
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('gallery/index', $data);
    }
    
    /**
     * Get creature details for AJAX request
     * 
     * @return void
     */
    public function getCreatureDetails()
    {
        // Read creature data from JSON file
        $jsonPath = ROOT_PATH . '/resources/data/gallery.json';
        $creatures = [];
        
        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
            $creatures = json_decode($jsonContent, true) ?: [];
        }
        
        // Get creature ID from request
        $requestData = $this->getJsonInput();
        $creatureId = isset($requestData['creature_id']) ? (int)$requestData['creature_id'] : null;
        
        // Find the creature by ID
        $creature = null;
        foreach ($creatures as $c) {
            if ($c['id'] == $creatureId) {
                $creature = $c;
                break;
            }
        }
        
        if ($creature) {
            $this->jsonResponse([
                'success' => true,
                'creature' => $creature
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Creature not found'
            ], 404);
        }
    }
}