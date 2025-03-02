<?php
// app/Models/Podcast.php

namespace App\Models;

/**
 * Podcast Model
 * 
 * Handles database operations for the Podcasts table
 */
class Podcast
{
    /**
     * @var \PDO $db Database connection
     */
    private $db;
    
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
     * Find a podcast by ID
     * 
     * @param int $id Podcast ID
     * @return array|false Podcast data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT p.*, c.name as category_name, c.slug as category_slug,
                   h.name as host_name, h.title as host_title, h.bio as host_bio, h.image_url as host_image_url
            FROM Podcasts p
            LEFT JOIN PodcastCategories c ON p.category_id = c.id
            LEFT JOIN PodcastHosts h ON p.host_id = h.id
            WHERE p.id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find a podcast by slug
     * 
     * @param string $slug Podcast slug
     * @return array|false Podcast data or false if not found
     */
    public function findBySlug($slug)
    {
        $stmt = $this->db->prepare('
            SELECT p.*, c.name as category_name, c.slug as category_slug,
                   h.name as host_name, h.title as host_title, h.bio as host_bio, h.image_url as host_image_url
            FROM Podcasts p
            LEFT JOIN PodcastCategories c ON p.category_id = c.id
            LEFT JOIN PodcastHosts h ON p.host_id = h.id
            WHERE p.slug = :slug
        ');
        
        $stmt->bindParam(':slug', $slug, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all podcasts with optional filtering
     * 
     * @param array $filters Optional filters (category_id, featured, search)
     * @param int $limit Number of podcasts to return
     * @param int $offset Offset for pagination
     * @return array Array of podcasts
     */
    public function getAll($filters = [], $limit = 10, $offset = 0)
    {
        $params = [];
        $whereConditions = [];
        
        // Base query
        $sql = '
            SELECT p.*, c.name as category_name, c.slug as category_slug,
                   h.name as host_name, h.title as host_title, h.image_url as host_image_url
            FROM Podcasts p
            LEFT JOIN PodcastCategories c ON p.category_id = c.id
            LEFT JOIN PodcastHosts h ON p.host_id = h.id
            WHERE 1=1
        ';
        
        // Apply category filter
        if (isset($filters['category_id']) && $filters['category_id']) {
            $whereConditions[] = 'p.category_id = :category_id';
            $params[':category_id'] = $filters['category_id'];
        }
        
        // Apply category slug filter
        if (isset($filters['category_slug']) && $filters['category_slug']) {
            $whereConditions[] = 'c.slug = :category_slug';
            $params[':category_slug'] = $filters['category_slug'];
        }
        
        // Apply featured filter
        if (isset($filters['featured']) && $filters['featured']) {
            $whereConditions[] = 'p.featured = :featured';
            $params[':featured'] = $filters['featured'];
        }
        
        // Apply search filter
        if (isset($filters['search']) && $filters['search']) {
            $searchTerm = '%' . $filters['search'] . '%';
            $whereConditions[] = '(p.title LIKE :search OR p.description LIKE :search)';
            $params[':search'] = $searchTerm;
        }
        
        // Add where conditions to query
        if (!empty($whereConditions)) {
            $sql .= ' AND ' . implode(' AND ', $whereConditions);
        }
        
        // Add ordering
        $sql .= ' ORDER BY p.publish_date DESC';
        
        // Add limit and offset
        $sql .= ' LIMIT :limit OFFSET :offset';
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;
        
        // Prepare and execute the query
        $stmt = $this->db->prepare($sql);
        
        // Bind parameters
        foreach ($params as $param => $value) {
            if (is_int($value)) {
                $stmt->bindValue($param, $value, \PDO::PARAM_INT);
            } else {
                $stmt->bindValue($param, $value, \PDO::PARAM_STR);
            }
        }
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get total count of podcasts with filters
     * 
     * @param array $filters Optional filters (category_id, featured, search)
     * @return int Count of podcasts
     */
    public function getCount($filters = [])
    {
        $params = [];
        $whereConditions = [];
        
        // Base query
        $sql = '
            SELECT COUNT(*) as total
            FROM Podcasts p
            LEFT JOIN PodcastCategories c ON p.category_id = c.id
            WHERE 1=1
        ';
        
        // Apply category filter
        if (isset($filters['category_id']) && $filters['category_id']) {
            $whereConditions[] = 'p.category_id = :category_id';
            $params[':category_id'] = $filters['category_id'];
        }
        
        // Apply category slug filter
        if (isset($filters['category_slug']) && $filters['category_slug']) {
            $whereConditions[] = 'c.slug = :category_slug';
            $params[':category_slug'] = $filters['category_slug'];
        }
        
        // Apply featured filter
        if (isset($filters['featured']) && $filters['featured']) {
            $whereConditions[] = 'p.featured = :featured';
            $params[':featured'] = $filters['featured'];
        }
        
        // Apply search filter
        if (isset($filters['search']) && $filters['search']) {
            $searchTerm = '%' . $filters['search'] . '%';
            $whereConditions[] = '(p.title LIKE :search OR p.description LIKE :search)';
            $params[':search'] = $searchTerm;
        }
        
        // Add where conditions to query
        if (!empty($whereConditions)) {
            $sql .= ' AND ' . implode(' AND ', $whereConditions);
        }
        
        // Prepare and execute the query
        $stmt = $this->db->prepare($sql);
        
        // Bind parameters
        foreach ($params as $param => $value) {
            if (is_int($value)) {
                $stmt->bindValue($param, $value, \PDO::PARAM_INT);
            } else {
                $stmt->bindValue($param, $value, \PDO::PARAM_STR);
            }
        }
        
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return (int) $result['total'];
    }
    
    /**
     * Get featured podcast
     * 
     * @return array|false Featured podcast or false if not found
     */
    public function getFeatured()
    {
        $stmt = $this->db->prepare('
            SELECT p.*, c.name as category_name, c.slug as category_slug,
                   h.name as host_name, h.title as host_title, h.bio as host_bio, h.image_url as host_image_url
            FROM Podcasts p
            LEFT JOIN PodcastCategories c ON p.category_id = c.id
            LEFT JOIN PodcastHosts h ON p.host_id = h.id
            WHERE p.featured = 1
            ORDER BY p.publish_date DESC
            LIMIT 1
        ');
        
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all podcast categories
     * 
     * @return array Array of categories
     */
    public function getAllCategories()
    {
        $stmt = $this->db->prepare('
            SELECT c.*, COUNT(p.id) as podcast_count
            FROM PodcastCategories c
            LEFT JOIN Podcasts p ON c.id = p.category_id
            GROUP BY c.id
            ORDER BY c.name
        ');
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find a category by slug
     * 
     * @param string $slug Category slug
     * @return array|false Category data or false if not found
     */
    public function findCategoryBySlug($slug)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM PodcastCategories
            WHERE slug = :slug
        ');
        
        $stmt->bindParam(':slug', $slug, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all podcast hosts
     * 
     * @return array Array of hosts
     */
    public function getAllHosts()
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM PodcastHosts
            ORDER BY name
        ');
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Format duration from seconds to human-readable format
     * 
     * @param int $seconds Duration in seconds
     * @return string Formatted duration (e.g., "45 min" or "1 hr 20 min")
     */
    public static function formatDuration($seconds)
    {
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $minutes %= 60;
        
        if ($hours > 0) {
            return "{$hours} hr {$minutes} min";
        }
        
        return "{$minutes} min";
    }
}