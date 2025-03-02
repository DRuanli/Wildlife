<?php
// Path: app/Http/Controllers/AboutController.php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\ConservationPartner;

/**
 * AboutController
 * 
 * Handles about us pages and team information
 */
class AboutController extends Controller
{
    /**
     * @var ConservationPartner $conservationModel
     */
    private $conservationModel;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Database connection
     */
    public function __construct($db)
    {
        parent::__construct($db);
        $this->conservationModel = new ConservationPartner($db);
    }
    
    /**
     * Show the main about page
     * 
     * @return void
     */
    public function index()
    {
        // Get conservation partners for the impact section
        $partners = $this->conservationModel->getAll();
        
        $data = [
            'partners' => $partners,
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('about/index', $data);
    }
    
    /**
     * Show the team page
     * 
     * @return void
     */
    public function team()
    {
        $data = [
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('about/team', $data);
    }
    
    /**
     * Show the mission and values page
     * 
     * @return void
     */
    public function mission()
    {
        $data = [
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('about/mission', $data);
    }
    
    /**
     * Show the impact page
     * 
     * @return void
     */
    public function impact()
    {
        // Get conservation partners and impact data
        $partners = $this->conservationModel->getAll();
        $globalImpact = $this->conservationModel->getCommunityImpact();
        
        $data = [
            'partners' => $partners,
            'globalImpact' => $globalImpact,
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('about/impact', $data);
    }
    
    /**
     * Show the careers page
     * 
     * @return void
     */
    public function careers()
    {
        $data = [
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('about/careers', $data);
    }
}