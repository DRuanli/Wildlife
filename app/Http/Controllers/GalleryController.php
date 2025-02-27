<?php
namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\Creature;

class GalleryController extends Controller
{
    private $creatureModel;
    
    public function __construct($db)
    {
        parent::__construct($db);
        $this->creatureModel = new Creature($db);
    }
    
    public function index()
    {
        $data = [
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('gallery/index', $data);
    }
}