<?php
// app/Models/ForumCategory.php

namespace App\Models;

/**
 * ForumCategory Model
 * 
 * Handles database operations for the ForumCategories table
 */
class ForumCategory
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
     * Find a forum category by ID
     * 
     * @param int $id Category ID
     * @return array|false Category data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM ForumCategories
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all top-level forum categories
     * 
     * @return array Array of categories
     */
    public function getTopLevelCategories()
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM ForumCategories
            WHERE parent_category_id IS NULL
            ORDER BY order_index ASC
        ');
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get subcategories of a category
     * 
     * @param int $parentId Parent category ID
     * @return array Array of subcategories
     */
    public function getSubCategories($parentId)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM ForumCategories
            WHERE parent_category_id = :parent_id
            ORDER BY order_index ASC
        ');
        
        $stmt->bindParam(':parent_id', $parentId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get category hierarchy
     * 
     * @return array Hierarchical array of categories
     */
    public function getCategoryHierarchy()
    {
        // Get all categories
        $stmt = $this->db->prepare('
            SELECT c.*, 
                   COUNT(p.id) as post_count
            FROM ForumCategories c
            LEFT JOIN ForumPosts p ON c.id = p.category_id AND p.parent_post_id IS NULL
            GROUP BY c.id
            ORDER BY c.order_index ASC
        ');
        
        $stmt->execute();
        $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Organize into hierarchy
        $hierarchy = [];
        $childrenMap = [];
        
        // First pass: create mapping of parent to children
        foreach ($categories as $category) {
            $parentId = $category['parent_category_id'];
            
            if (!isset($childrenMap[$parentId])) {
                $childrenMap[$parentId] = [];
            }
            
            $childrenMap[$parentId][] = $category;
        }
        
        // Second pass: build hierarchy starting with top-level categories
        if (isset($childrenMap[null])) {
            foreach ($childrenMap[null] as $topCategory) {
                $hierarchy[] = $this->buildCategoryTree($topCategory, $childrenMap);
            }
        }
        
        return $hierarchy;
    }
    
    /**
     * Recursively build category tree
     * 
     * @param array $category Current category
     * @param array $childrenMap Mapping of parent IDs to children
     * @return array Category with children
     */
    private function buildCategoryTree($category, $childrenMap)
    {
        $categoryId = $category['id'];
        $result = $category;
        
        if (isset($childrenMap[$categoryId])) {
            $result['children'] = [];
            
            foreach ($childrenMap[$categoryId] as $child) {
                $result['children'][] = $this->buildCategoryTree($child, $childrenMap);
            }
        }
        
        return $result;
    }
    
    /**
     * Create a new forum category
     * 
     * @param array $categoryData Category data
     * @return int|false The new category ID or false on failure
     */
    public function create($categoryData)
    {
        $stmt = $this->db->prepare('
            INSERT INTO ForumCategories (
                name, description, order_index, parent_category_id,
                created_at, updated_at
            ) VALUES (
                :name, :description, :order_index, :parent_category_id,
                NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':name', $categoryData['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $categoryData['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':order_index', $categoryData['order_index'], \PDO::PARAM_INT);
        
        if (isset($categoryData['parent_category_id']) && $categoryData['parent_category_id']) {
            $stmt->bindParam(':parent_category_id', $categoryData['parent_category_id'], \PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':parent_category_id', null, \PDO::PARAM_NULL);
        }
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Update a forum category
     * 
     * @param int $id Category ID
     * @param array $categoryData Category data to update
     * @return bool Success status
     */
    public function update($id, $categoryData)
    {
        $allowedFields = ['name', 'description', 'order_index', 'parent_category_id'];
        $updates = [];
        $params = [':id' => $id];
        
        foreach ($categoryData as $field => $value) {
            if (in_array($field, $allowedFields)) {
                $updates[] = "{$field} = :{$field}";
                $params[":{$field}"] = $value;
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $updates[] = "updated_at = NOW()";
        $updateStr = implode(', ', $updates);
        
        $stmt = $this->db->prepare("
            UPDATE ForumCategories
            SET {$updateStr}
            WHERE id = :id
        ");
        
        foreach ($params as $param => $value) {
            if ($param === ':parent_category_id' && $value === null) {
                $stmt->bindValue($param, $value, \PDO::PARAM_NULL);
            } elseif (is_int($value)) {
                $stmt->bindValue($param, $value, \PDO::PARAM_INT);
            } else {
                $stmt->bindValue($param, $value, \PDO::PARAM_STR);
            }
        }
        
        return $stmt->execute();
    }
    
    /**
     * Delete a forum category
     * 
     * @param int $id Category ID
     * @return bool Success status
     */
    public function delete($id)
    {
        $this->db->beginTransaction();
        
        try {
            // Check if category has children
            $children = $this->getSubCategories($id);
            
            if (!empty($children)) {
                // Cannot delete category with children
                $this->db->rollBack();
                return false;
            }
            
            // Check if category has posts
            $stmt = $this->db->prepare('
                SELECT COUNT(*) as count
                FROM ForumPosts
                WHERE category_id = :id
            ');
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($result['count'] > 0) {
                // Cannot delete category with posts
                $this->db->rollBack();
                return false;
            }
            
            // Delete category
            $stmt = $this->db->prepare('
                DELETE FROM ForumCategories
                WHERE id = :id
            ');
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            $this->db->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    
    /**
     * Reorder categories
     * 
     * @param array $orderMap Mapping of category IDs to order indices
     * @return bool Success status
     */
    public function reorderCategories($orderMap)
    {
        $this->db->beginTransaction();
        
        try {
            foreach ($orderMap as $categoryId => $orderIndex) {
                $stmt = $this->db->prepare('
                    UPDATE ForumCategories
                    SET order_index = :order_index,
                        updated_at = NOW()
                    WHERE id = :id
                ');
                
                $stmt->bindParam(':id', $categoryId, \PDO::PARAM_INT);
                $stmt->bindParam(':order_index', $orderIndex, \PDO::PARAM_INT);
                
                if (!$stmt->execute()) {
                    $this->db->rollBack();
                    return false;
                }
            }
            
            $this->db->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    
    /**
     * Get category statistics
     * 
     * @param int $categoryId Category ID
     * @return array Category statistics
     */
    public function getCategoryStats($categoryId)
    {
        // Get direct post count
        $stmt = $this->db->prepare('
            SELECT 
                COUNT(*) as total_threads,
                COUNT(DISTINCT user_id) as unique_posters,
                SUM(views_count) as total_views,
                MAX(created_at) as latest_post_date
            FROM ForumPosts
            WHERE category_id = :category_id
            AND parent_post_id IS NULL
        ');
        
        $stmt->bindParam(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $stats = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Get reply count
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as total_replies
            FROM ForumPosts p1
            JOIN ForumPosts p2 ON p1.id = p2.parent_post_id
            WHERE p1.category_id = :category_id
            AND p1.parent_post_id IS NULL
        ');
        
        $stmt->bindParam(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $replyStats = $stmt->fetch(\PDO::FETCH_ASSOC);
        $stats['total_replies'] = $replyStats['total_replies'];
        
        // Get subcategory stats recursively
        $subcategories = $this->getSubCategories($categoryId);
        $stats['subcategories'] = [];
        
        foreach ($subcategories as $subcategory) {
            $stats['subcategories'][$subcategory['id']] = $this->getCategoryStats($subcategory['id']);
            
            // Add subcategory stats to total
            $stats['total_threads'] += $stats['subcategories'][$subcategory['id']]['total_threads'];
            $stats['total_replies'] += $stats['subcategories'][$subcategory['id']]['total_replies'];
            $stats['total_views'] += $stats['subcategories'][$subcategory['id']]['total_views'];
            
            // Update latest post date if subcategory has a more recent post
            if ($stats['latest_post_date'] < $stats['subcategories'][$subcategory['id']]['latest_post_date']) {
                $stats['latest_post_date'] = $stats['subcategories'][$subcategory['id']]['latest_post_date'];
            }
        }
        
        return $stats;
    }
}