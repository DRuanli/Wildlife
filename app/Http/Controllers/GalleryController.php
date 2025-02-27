<?php
// Path: app/Http/Controllers/GalleryController.php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\Creature;

/**
 * GalleryController
 * 
 * Handles creature gallery display and interactions
 */
class GalleryController extends Controller
{
    /**
     * @var Creature $creatureModel
     */
    private $creatureModel;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Database connection
     */
    public function __construct($db)
    {
        parent::__construct($db);
        $this->creatureModel = new Creature($db);
    }
    
    /**
     * Display creature gallery
     * 
     * @return void
     */
    public function index()
    {
        // Get all creature species
        $creatures = $this->creatureModel->getAllSpecies();
        
        // Prepare view data
        $data = [
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('gallery/index', $data);
    }
}