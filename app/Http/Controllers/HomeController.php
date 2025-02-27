<?php

// Path: app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Core\Controller;

/**
 * HomeController
 * 
 * Handles the home page and landing pages
 */
class HomeController extends Controller
{
    /**
     * Show the home page
     * 
     * @return void
     */
    public function index()
    {
        // If user is logged in, redirect to dashboard
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            $this->redirect('/dashboard');  // Use explicit path instead of empty string
            return;
        }
        
        // Otherwise show the landing page
        $this->render('home/index');
    }
}