<?php
// app/Models/Item.php

namespace App\Models;

/**
 * Item Model
 * 
 * Handles database operations for the Items table
 */
class Item
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
     * Find an item by ID
     * 
     * @param int $id Item ID
     * @return array|false Item data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM Items
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        $item = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($item && isset($item['conservation_impact'])) {
            $item['conservation_impact'] = json_decode($item['conservation_impact'], true);
        }
        
        return $item;
    }
    
    /**
     * Get all items
     * 
     * @param bool $includeUnavailable Whether to include items that are not currently available
     * @return array Array of items
     */
    public function getAll($includeUnavailable = false)
    {
        try {
            $query = 'SELECT * FROM Items';
            
            if (!$includeUnavailable) {
                $now = date('Y-m-d H:i:s');
                $query .= " WHERE (available_from IS NULL OR available_from <= :now)
                        AND (available_until IS NULL OR available_until >= :now)";
            }
            
            $query .= ' ORDER BY rarity, name';
            
            $stmt = $this->db->prepare($query);
            
            if (!$includeUnavailable) {
                $stmt->bindValue(':now', $now, \PDO::PARAM_STR);
            }
            
            $stmt->execute();
            
            $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            // Parse JSON fields
            foreach ($items as &$item) {
                if (isset($item['conservation_impact'])) {
                    $item['conservation_impact'] = json_decode($item['conservation_impact'], true);
                }
            }
            
            return $items;
        } catch (\PDOException $e) {
            // Log error and return empty array
            error_log("Error in Item->getAll(): " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get items by type
     * 
     * @param string $type Item type
     * @return array Array of items
     */
    public function getByType($type)
    {
        $now = date('Y-m-d H:i:s');
        
        $stmt = $this->db->prepare('
            SELECT *
            FROM Items
            WHERE type = :type
            AND (available_from IS NULL OR available_from <= :now)
            AND (available_until IS NULL OR available_until >= :now)
            ORDER BY rarity, price
        ');
        
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        $stmt->execute();
        
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Parse JSON fields
        foreach ($items as &$item) {
            if (isset($item['conservation_impact'])) {
                $item['conservation_impact'] = json_decode($item['conservation_impact'], true);
            }
        }
        
        return $items;
    }
    
    /**
     * Get featured items
     * 
     * @param int $limit Maximum number of items to return
     * @return array Array of featured items
     */
    public function getFeatured($limit = 5)
    {
        $now = date('Y-m-d H:i:s');
        
        $stmt = $this->db->prepare('
            SELECT i.*
            FROM Items i
            JOIN FeaturedItems fi ON i.id = fi.item_id
            WHERE (fi.start_date IS NULL OR fi.start_date <= :now)
            AND (fi.end_date IS NULL OR fi.end_date >= :now)
            AND (i.available_from IS NULL OR i.available_from <= :now)
            AND (i.available_until IS NULL OR i.available_until >= :now)
            ORDER BY fi.priority DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Parse JSON fields
        foreach ($items as &$item) {
            if (isset($item['conservation_impact'])) {
                $item['conservation_impact'] = json_decode($item['conservation_impact'], true);
            }
        }
        
        return $items;
    }
    
    /**
     * Get daily deals
     * 
     * @param int $limit Maximum number of deals to return
     * @return array Array of daily deal items
     */
    public function getDailyDeals($limit = 5)
    {
        $today = date('Y-m-d');
        $now = date('Y-m-d H:i:s');
        
        // Calculate seed for consistent daily deals
        $seed = date('Ymd');
        $this->db->query("SET @seed = {$seed}");
        
        $stmt = $this->db->prepare('
            SELECT i.*, 
                   dd.discount_percentage,
                   ROUND(i.price * (1 - dd.discount_percentage / 100)) as discounted_price
            FROM Items i
            JOIN DailyDeals dd ON i.id = dd.item_id
            WHERE dd.deal_date = :today
            AND (i.available_from IS NULL OR i.available_from <= :now)
            AND (i.available_until IS NULL OR i.available_until >= :now)
            ORDER BY dd.priority DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':today', $today, \PDO::PARAM_STR);
        $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        $deals = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // If no deals are scheduled for today, generate random deals
        if (empty($deals)) {
            $stmt = $this->db->prepare('
                SELECT i.*,
                       FLOOR(20 + (RAND() * 30)) as discount_percentage,
                       ROUND(i.price * (1 - (20 + (RAND() * 30)) / 100)) as discounted_price
                FROM Items i
                WHERE i.price > 100
                AND (i.available_from IS NULL OR i.available_from <= :now)
                AND (i.available_until IS NULL OR i.available_until >= :now)
                AND i.rarity IN ("uncommon", "rare", "legendary")
                ORDER BY RAND()
                LIMIT :limit
            ');
            
            $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->execute();
            
            $deals = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        // Parse JSON fields
        foreach ($deals as &$deal) {
            if (isset($deal['conservation_impact'])) {
                $deal['conservation_impact'] = json_decode($deal['conservation_impact'], true);
            }
        }
        
        return $deals;
    }
    
    /**
     * Get recently viewed items for a user
     * 
     * @param int $userId User ID
     * @param int $limit Maximum number of items to return
     * @return array Array of recently viewed items
     */
    public function getRecentlyViewed($userId, $limit = 5)
    {
        $stmt = $this->db->prepare('
            SELECT i.*, iv.viewed_at
            FROM Items i
            JOIN ItemViews iv ON i.id = iv.item_id
            WHERE iv.user_id = :user_id
            ORDER BY iv.viewed_at DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Parse JSON fields
        foreach ($items as &$item) {
            if (isset($item['conservation_impact'])) {
                $item['conservation_impact'] = json_decode($item['conservation_impact'], true);
            }
        }
        
        return $items;
    }
    
    /**
     * Record that a user viewed an item
     * 
     * @param int $userId User ID
     * @param int $itemId Item ID
     * @return bool Success status
     */
    public function recordItemView($userId, $itemId)
    {
        // Check if this item view already exists
        $stmt = $this->db->prepare('
            SELECT id
            FROM ItemViews
            WHERE user_id = :user_id AND item_id = :item_id
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->fetch()) {
            // Update existing view
            $stmt = $this->db->prepare('
                UPDATE ItemViews
                SET viewed_at = NOW()
                WHERE user_id = :user_id AND item_id = :item_id
            ');
        } else {
            // Insert new view
            $stmt = $this->db->prepare('
                INSERT INTO ItemViews (user_id, item_id, viewed_at)
                VALUES (:user_id, :item_id, NOW())
            ');
        }
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Add an item to user's inventory
     * 
     * @param int $userId User ID
     * @param int $itemId Item ID
     * @param int $quantity Quantity to add
     * @return bool Success status
     */
    public function addToUserInventory($userId, $itemId, $quantity = 1)
    {
        // Check if this item is already in the user's inventory
        $stmt = $this->db->prepare('
            SELECT id, quantity
            FROM UserItems
            WHERE user_id = :user_id AND item_id = :item_id
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $userItem = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($userItem) {
            // Update existing inventory item
            $newQuantity = $userItem['quantity'] + $quantity;
            
            $stmt = $this->db->prepare('
                UPDATE UserItems
                SET quantity = :quantity,
                    updated_at = NOW()
                WHERE id = :id
            ');
            
            $stmt->bindParam(':id', $userItem['id'], \PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $newQuantity, \PDO::PARAM_INT);
        } else {
            // Insert new inventory item
            $stmt = $this->db->prepare('
                INSERT INTO UserItems (
                    user_id, item_id, quantity,
                    acquired_at, created_at, updated_at
                ) VALUES (
                    :user_id, :item_id, :quantity,
                    NOW(), NOW(), NOW()
                )
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, \PDO::PARAM_INT);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Get user's inventory
     * 
     * @param int $userId User ID
     * @return array Array of inventory items
     */
    public function getUserInventory($userId)
    {
        $stmt = $this->db->prepare('
            SELECT ui.*, i.name, i.description, i.type, i.rarity
            FROM UserItems ui
            JOIN Items i ON ui.item_id = i.id
            WHERE ui.user_id = :user_id
            ORDER BY ui.acquired_at DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Add an item to user's wishlist
     * 
     * @param int $userId User ID
     * @param int $itemId Item ID
     * @return bool Success status
     */
    public function addToWishlist($userId, $itemId)
    {
        // Check if this item is already in the user's wishlist
        $stmt = $this->db->prepare('
            SELECT id
            FROM UserWishlist
            WHERE user_id = :user_id AND item_id = :item_id
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->fetch()) {
            // Already in wishlist
            return true;
        }
        
        // Add to wishlist
        $stmt = $this->db->prepare('
            INSERT INTO UserWishlist (
                user_id, item_id, added_at
            ) VALUES (
                :user_id, :item_id, NOW()
            )
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Remove an item from user's wishlist
     * 
     * @param int $userId User ID
     * @param int $itemId Item ID
     * @return bool Success status
     */
    public function removeFromWishlist($userId, $itemId)
    {
        $stmt = $this->db->prepare('
            DELETE FROM UserWishlist
            WHERE user_id = :user_id AND item_id = :item_id
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Get user's wishlist
     * 
     * @param int $userId User ID
     * @return array Array of wishlist items
     */
    public function getWishlist($userId)
    {
        $stmt = $this->db->prepare('
            SELECT i.*, uw.added_at
            FROM Items i
            JOIN UserWishlist uw ON i.id = uw.item_id
            WHERE uw.user_id = :user_id
            ORDER BY uw.added_at DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Parse JSON fields
        foreach ($items as &$item) {
            if (isset($item['conservation_impact'])) {
                $item['conservation_impact'] = json_decode($item['conservation_impact'], true);
            }
        }
        
        return $items;
    }
    
    /**
     * Check if an item is in a user's wishlist
     * 
     * @param int $userId User ID
     * @param int $itemId Item ID
     * @return bool True if in wishlist, false otherwise
     */
    public function isInWishlist($userId, $itemId)
    {
        $stmt = $this->db->prepare('
            SELECT id
            FROM UserWishlist
            WHERE user_id = :user_id AND item_id = :item_id
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch() !== false;
    }
    
    /**
     * Search for items by name
     * 
     * @param string $query Search query
     * @return array Array of matching items
     */
    public function search($query)
    {
        $searchTerm = "%{$query}%";
        $now = date('Y-m-d H:i:s');
        
        $stmt = $this->db->prepare('
            SELECT *
            FROM Items
            WHERE (name LIKE :query OR description LIKE :query)
            AND (available_from IS NULL OR available_from <= :now)
            AND (available_until IS NULL OR available_until >= :now)
            ORDER BY rarity, name
        ');
        
        $stmt->bindParam(':query', $searchTerm, \PDO::PARAM_STR);
        $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        $stmt->execute();
        
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Parse JSON fields
        foreach ($items as &$item) {
            if (isset($item['conservation_impact'])) {
                $item['conservation_impact'] = json_decode($item['conservation_impact'], true);
            }
        }
        
        return $items;
    }
    
    /**
     * Filter items by criteria
     * 
     * @param array $filters Associative array of filter criteria
     * @return array Array of filtered items
     */
    public function filter($filters)
    {
        $query = 'SELECT * FROM Items WHERE 1=1';
        $params = [];
        
        // Current time for availability check
        $now = date('Y-m-d H:i:s');
        $query .= " AND (available_from IS NULL OR available_from <= :now)
                   AND (available_until IS NULL OR available_until >= :now)";
        $params[':now'] = $now;
        
        // Type filter
        if (!empty($filters['type'])) {
            $query .= " AND type = :type";
            $params[':type'] = $filters['type'];
        }
        
        // Rarity filter
        if (!empty($filters['rarity'])) {
            $query .= " AND rarity = :rarity";
            $params[':rarity'] = $filters['rarity'];
        }
        
        // Price range filter
        if (!empty($filters['min_price'])) {
            $query .= " AND price >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }
        
        if (!empty($filters['max_price'])) {
            $query .= " AND price <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }
        
        // Limited edition filter
        if (isset($filters['is_limited_edition']) && $filters['is_limited_edition']) {
            $query .= " AND is_limited_edition = 1";
        }
        
        // Add ordering
        if (!empty($filters['order_by'])) {
            $orderColumn = 'name'; // Default
            $orderDirection = 'ASC'; // Default
            
            switch ($filters['order_by']) {
                case 'price_asc':
                    $orderColumn = 'price';
                    $orderDirection = 'ASC';
                    break;
                case 'price_desc':
                    $orderColumn = 'price';
                    $orderDirection = 'DESC';
                    break;
                case 'newest':
                    $orderColumn = 'available_from';
                    $orderDirection = 'DESC';
                    break;
                case 'rarity':
                    // Custom ordering for rarity
                    $orderColumn = "FIELD(rarity, 'common', 'uncommon', 'rare', 'legendary', 'mythical')";
                    $orderDirection = 'ASC';
                    break;
            }
            
            $query .= " ORDER BY {$orderColumn} {$orderDirection}";
        } else {
            $query .= " ORDER BY rarity, name";
        }
        
        // Add limit
        if (!empty($filters['limit'])) {
            $query .= " LIMIT :limit";
            $params[':limit'] = $filters['limit'];
        }
        
        $stmt = $this->db->prepare($query);
        
        foreach ($params as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue($key, $value, \PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value, \PDO::PARAM_STR);
            }
        }
        
        $stmt->execute();
        
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Parse JSON fields
        foreach ($items as &$item) {
            if (isset($item['conservation_impact'])) {
                $item['conservation_impact'] = json_decode($item['conservation_impact'], true);
            }
        }
        
        return $items;
    }
}