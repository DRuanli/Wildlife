<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Core\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $this->requireAuth(); // Ensure user is authenticated
        $this->render('dashboard/index');
    }
}