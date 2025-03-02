<?php
// app/Http/Controllers/PodcastController.php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\Podcast;

/**
 * PodcastController
 * 
 * Handles podcast functionality
 */
class PodcastController extends Controller
{
    /**
     * @var Podcast $podcastModel
     */
    private $podcastModel;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Database connection
     */
    public function __construct($db)
    {
        parent::__construct($db);
        $this->podcastModel = new Podcast($db);
    }
    
    /**
     * Display podcast index page
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function index($params = [])
    {
        // Get filter parameters
        $categorySlug = isset($params['category']) ? $params['category'] : null;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 6; // Number of podcasts per page
        
        $filters = [
            'search' => $search
        ];
        
        // Filter by category if provided
        if ($categorySlug) {
            $category = $this->podcastModel->findCategoryBySlug($categorySlug);
            if ($category) {
                $filters['category_id'] = $category['id'];
            }
        }
        
        // Get podcasts
        $offset = ($page - 1) * $perPage;
        $podcasts = $this->podcastModel->getAll($filters, $perPage, $offset);
        
        // Get total count for pagination
        $totalPodcasts = $this->podcastModel->getCount($filters);
        $totalPages = ceil($totalPodcasts / $perPage);
        
        // Get featured podcast for hero section
        $featuredPodcast = $this->podcastModel->getFeatured();
        
        // Get all categories for filter tabs
        $categories = $this->podcastModel->getAllCategories();
        
        // Get all hosts for about section
        $hosts = $this->podcastModel->getAllHosts();
        
        // Prepare data for view
        $data = [
            'podcasts' => $podcasts,
            'featuredPodcast' => $featuredPodcast,
            'categories' => $categories,
            'hosts' => $hosts,
            'search' => $search,
            'currentCategory' => $categorySlug,
            'pagination' => [
                'current' => $page,
                'total' => $totalPages,
                'perPage' => $perPage,
                'totalItems' => $totalPodcasts
            ],
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('podcast/index', $data);
    }
    
    /**
     * Display a specific podcast
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function view($params = [])
    {
        $slug = isset($params['slug']) ? $params['slug'] : null;
        
        if (!$slug) {
            $this->redirect('/podcast');
            return;
        }
        
        // Get podcast by slug
        $podcast = $this->podcastModel->findBySlug($slug);
        
        if (!$podcast) {
            $this->setFlashMessage('Podcast not found', 'danger');
            $this->redirect('/podcast');
            return;
        }
        
        // Get related podcasts in the same category
        $relatedPodcasts = [];
        if ($podcast['category_id']) {
            $filters = [
                'category_id' => $podcast['category_id']
            ];
            
            // Exclude current podcast
            $relatedPodcasts = array_filter(
                $this->podcastModel->getAll($filters, 3),
                function($item) use ($podcast) {
                    return $item['id'] != $podcast['id'];
                }
            );
        }
        
        // Prepare data for view
        $data = [
            'podcast' => $podcast,
            'relatedPodcasts' => $relatedPodcasts,
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('podcast/view', $data);
    }
    
    /**
     * Display podcasts by category
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function category($params = [])
    {
        $categorySlug = isset($params['slug']) ? $params['slug'] : null;
        
        if (!$categorySlug) {
            $this->redirect('/podcast');
            return;
        }
        
        // Redirect to index with category filter
        $this->redirect('/podcast?category=' . urlencode($categorySlug));
    }
    
    /**
     * API endpoint to load more podcasts
     * 
     * @return void
     */
    public function loadMore()
    {
        // Get JSON input
        $input = $this->getJsonInput();
        
        // Get filter parameters
        $categorySlug = isset($input['category']) ? $input['category'] : null;
        $search = isset($input['search']) ? trim($input['search']) : '';
        $page = isset($input['page']) ? (int)$input['page'] : 1;
        $perPage = isset($input['perPage']) ? (int)$input['perPage'] : 6;
        
        $filters = [
            'search' => $search
        ];
        
        // Filter by category if provided
        if ($categorySlug) {
            $category = $this->podcastModel->findCategoryBySlug($categorySlug);
            if ($category) {
                $filters['category_id'] = $category['id'];
            }
        }
        
        // Get podcasts
        $offset = ($page - 1) * $perPage;
        $podcasts = $this->podcastModel->getAll($filters, $perPage, $offset);
        
        // Get total count for pagination
        $totalPodcasts = $this->podcastModel->getCount($filters);
        $totalPages = ceil($totalPodcasts / $perPage);
        
        // Return JSON response
        $this->jsonResponse([
            'success' => true,
            'podcasts' => $podcasts,
            'pagination' => [
                'current' => $page,
                'total' => $totalPages,
                'perPage' => $perPage,
                'totalItems' => $totalPodcasts
            ]
        ]);
    }
}