<?php
// app/Models/ForumPost.php

namespace App\Models;

/**
 * ForumPost Model
 * 
 * Handles database operations for the ForumPosts table
 */
class ForumPost
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
     * Find a post by ID
     * 
     * @param int $id Post ID
     * @return array|false Post data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT p.*, u.username, u.avatar_url
            FROM ForumPosts p
            JOIN Users u ON p.user_id = u.id
            WHERE p.id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get threads (top-level posts) in a category
     * 
     * @param int $categoryId Category ID
     * @param int $page Page number
     * @param int $perPage Items per page
     * @return array Array of threads
     */
    public function getThreadsInCategory($categoryId, $page = 1, $perPage = 20)
    {
        $offset = ($page - 1) * $perPage;
        
        $stmt = $this->db->prepare('
            SELECT p.*, u.username, u.avatar_url,
                   (SELECT COUNT(*) FROM ForumPosts WHERE parent_post_id = p.id) as reply_count,
                   (SELECT MAX(created_at) FROM ForumPosts WHERE parent_post_id = p.id) as last_reply_at
            FROM ForumPosts p
            JOIN Users u ON p.user_id = u.id
            WHERE p.category_id = :category_id AND p.parent_post_id IS NULL
            ORDER BY p.is_pinned DESC, p.created_at DESC
            LIMIT :limit OFFSET :offset
        ');
        
        $stmt->bindParam(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get total thread count in a category
     * 
     * @param int $categoryId Category ID
     * @return int Thread count
     */
    public function getThreadCount($categoryId)
    {
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as count
            FROM ForumPosts
            WHERE category_id = :category_id AND parent_post_id IS NULL
        ');
        
        $stmt->bindParam(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return (int)$result['count'];
    }
    
    /**
     * Get replies to a thread
     * 
     * @param int $threadId Thread (parent post) ID
     * @param int $page Page number
     * @param int $perPage Items per page
     * @return array Array of replies
     */
    public function getReplies($threadId, $page = 1, $perPage = 20)
    {
        $offset = ($page - 1) * $perPage;
        
        $stmt = $this->db->prepare('
            SELECT p.*, u.username, u.avatar_url
            FROM ForumPosts p
            JOIN Users u ON p.user_id = u.id
            WHERE p.parent_post_id = :thread_id
            ORDER BY p.created_at ASC
            LIMIT :limit OFFSET :offset
        ');
        
        $stmt->bindParam(':thread_id', $threadId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get total reply count for a thread
     * 
     * @param int $threadId Thread ID
     * @return int Reply count
     */
    public function getReplyCount($threadId)
    {
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as count
            FROM ForumPosts
            WHERE parent_post_id = :thread_id
        ');
        
        $stmt->bindParam(':thread_id', $threadId, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return (int)$result['count'];
    }
    
    /**
     * Create a new thread (top-level post)
     * 
     * @param array $threadData Thread data
     * @return int|false The new thread ID or false on failure
     */
    public function createThread($threadData)
    {
        $stmt = $this->db->prepare('
            INSERT INTO ForumPosts (
                user_id, category_id, title, content,
                is_pinned, is_locked, views_count,
                created_at, updated_at
            ) VALUES (
                :user_id, :category_id, :title, :content,
                :is_pinned, :is_locked, 0,
                NOW(), NOW()
            )
        ');
        
        $isPinned = isset($threadData['is_pinned']) ? (bool)$threadData['is_pinned'] : false;
        $isLocked = isset($threadData['is_locked']) ? (bool)$threadData['is_locked'] : false;
        
        $stmt->bindParam(':user_id', $threadData['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $threadData['category_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':title', $threadData['title'], \PDO::PARAM_STR);
        $stmt->bindParam(':content', $threadData['content'], \PDO::PARAM_STR);
        $stmt->bindParam(':is_pinned', $isPinned, \PDO::PARAM_BOOL);
        $stmt->bindParam(':is_locked', $isLocked, \PDO::PARAM_BOOL);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Create a reply to a thread
     * 
     * @param array $replyData Reply data
     * @return int|false The new reply ID or false on failure
     */
    public function createReply($replyData)
    {
        $this->db->beginTransaction();
        
        try {
            // Get thread info to check if it's locked
            $stmt = $this->db->prepare('
                SELECT *
                FROM ForumPosts
                WHERE id = :thread_id AND parent_post_id IS NULL
            ');
            
            $stmt->bindParam(':thread_id', $replyData['parent_post_id'], \PDO::PARAM_INT);
            $stmt->execute();
            
            $thread = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$thread) {
                // Thread not found
                $this->db->rollBack();
                return false;
            }
            
            if ($thread['is_locked']) {
                // Cannot reply to locked thread
                $this->db->rollBack();
                return false;
            }
            
            // Create reply
            $stmt = $this->db->prepare('
                INSERT INTO ForumPosts (
                    user_id, category_id, parent_post_id,
                    content, views_count,
                    created_at, updated_at
                ) VALUES (
                    :user_id, :category_id, :parent_post_id,
                    :content, 0,
                    NOW(), NOW()
                )
            ');
            
            $stmt->bindParam(':user_id', $replyData['user_id'], \PDO::PARAM_INT);
            $stmt->bindParam(':category_id', $thread['category_id'], \PDO::PARAM_INT);
            $stmt->bindParam(':parent_post_id', $replyData['parent_post_id'], \PDO::PARAM_INT);
            $stmt->bindParam(':content', $replyData['content'], \PDO::PARAM_STR);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            $replyId = $this->db->lastInsertId();
            
            // Update thread's updated_at timestamp
            $stmt = $this->db->prepare('
                UPDATE ForumPosts
                SET updated_at = NOW()
                WHERE id = :thread_id
            ');
            
            $stmt->bindParam(':thread_id', $replyData['parent_post_id'], \PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            $this->db->commit();
            return $replyId;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    
    /**
     * Update a post
     * 
     * @param int $id Post ID
     * @param array $postData Post data to update
     * @return bool Success status
     */
    public function update($id, $postData)
    {
        $allowedFields = ['title', 'content', 'is_pinned', 'is_locked'];
        $updates = [];
        $params = [':id' => $id];
        
        foreach ($postData as $field => $value) {
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
            UPDATE ForumPosts
            SET {$updateStr}
            WHERE id = :id
        ");
        
        foreach ($params as $param => $value) {
            if (is_bool($value)) {
                $stmt->bindValue($param, $value, \PDO::PARAM_BOOL);
            } elseif (is_int($value)) {
                $stmt->bindValue($param, $value, \PDO::PARAM_INT);
            } else {
                $stmt->bindValue($param, $value, \PDO::PARAM_STR);
            }
        }
        
        return $stmt->execute();
    }
    
    /**
     * Delete a post
     * 
     * @param int $id Post ID
     * @return bool Success status
     */
    public function delete($id)
    {
        $this->db->beginTransaction();
        
        try {
            // Check if post is a thread with replies
            $stmt = $this->db->prepare('
                SELECT COUNT(*) as count
                FROM ForumPosts
                WHERE parent_post_id = :id
            ');
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($result['count'] > 0) {
                // Cannot delete thread with replies
                $this->db->rollBack();
                return false;
            }
            
            // Delete post
            $stmt = $this->db->prepare('
                DELETE FROM ForumPosts
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
     * Increment view count for a thread
     * 
     * @param int $id Thread ID
     * @return bool Success status
     */
    public function incrementViewCount($id)
    {
        $stmt = $this->db->prepare('
            UPDATE ForumPosts
            SET views_count = views_count + 1
            WHERE id = :id AND parent_post_id IS NULL
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Pin or unpin a thread
     * 
     * @param int $id Thread ID
     * @param bool $pinned Whether to pin or unpin
     * @return bool Success status
     */
    public function setPinned($id, $pinned)
    {
        $stmt = $this->db->prepare('
            UPDATE ForumPosts
            SET is_pinned = :is_pinned,
                updated_at = NOW()
            WHERE id = :id AND parent_post_id IS NULL
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':is_pinned', $pinned, \PDO::PARAM_BOOL);
        
        return $stmt->execute();
    }
    
    /**
     * Lock or unlock a thread
     * 
     * @param int $id Thread ID
     * @param bool $locked Whether to lock or unlock
     * @return bool Success status
     */
    public function setLocked($id, $locked)
    {
        $stmt = $this->db->prepare('
            UPDATE ForumPosts
            SET is_locked = :is_locked,
                updated_at = NOW()
            WHERE id = :id AND parent_post_id IS NULL
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':is_locked', $locked, \PDO::PARAM_BOOL);
        
        return $stmt->execute();
    }
    
    /**
     * Move a thread to a different category
     * 
     * @param int $id Thread ID
     * @param int $newCategoryId New category ID
     * @return bool Success status
     */
    public function moveThread($id, $newCategoryId)
    {
        $this->db->beginTransaction();
        
        try {
            // Check if thread exists
            $stmt = $this->db->prepare('
                SELECT *
                FROM ForumPosts
                WHERE id = :id AND parent_post_id IS NULL
            ');
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            
            if (!$stmt->fetch()) {
                // Thread not found
                $this->db->rollBack();
                return false;
            }
            
            // Check if category exists
            $categoryModel = new ForumCategory($this->db);
            if (!$categoryModel->findById($newCategoryId)) {
                // Category not found
                $this->db->rollBack();
                return false;
            }
            
            // Update thread
            $stmt = $this->db->prepare('
                UPDATE ForumPosts
                SET category_id = :category_id,
                    updated_at = NOW()
                WHERE id = :id
            ');
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':category_id', $newCategoryId, \PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            // Update replies
            $stmt = $this->db->prepare('
                UPDATE ForumPosts
                SET category_id = :category_id
                WHERE parent_post_id = :thread_id
            ');
            
            $stmt->bindParam(':thread_id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':category_id', $newCategoryId, \PDO::PARAM_INT);
            
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
     * Search forum posts
     * 
     * @param string $query Search query
     * @param int $categoryId Optional category ID to filter by
     * @param int $page Page number
     * @param int $perPage Items per page
     * @return array Array of matching posts
     */
    public function search($query, $categoryId = null, $page = 1, $perPage = 20)
    {
        $offset = ($page - 1) * $perPage;
        $searchTerm = "%{$query}%";
        
        $sql = '
            SELECT p.*, u.username, u.avatar_url,
                   c.name as category_name,
                   CASE WHEN p.parent_post_id IS NULL THEN 1 ELSE 0 END as is_thread
            FROM ForumPosts p
            JOIN Users u ON p.user_id = u.id
            JOIN ForumCategories c ON p.category_id = c.id
            WHERE (p.title LIKE :query OR p.content LIKE :query)
        ';
        
        if ($categoryId) {
            $sql .= ' AND p.category_id = :category_id';
        }
        
        $sql .= '
            ORDER BY p.created_at DESC
            LIMIT :limit OFFSET :offset
        ';
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':query', $searchTerm, \PDO::PARAM_STR);
        
        if ($categoryId) {
            $stmt->bindParam(':category_id', $categoryId, \PDO::PARAM_INT);
        }
        
        $stmt->bindParam(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get user's recent posts
     * 
     * @param int $userId User ID
     * @param int $limit Number of posts to return
     * @return array User's recent posts
     */
    public function getUserRecentPosts($userId, $limit = 5)
    {
        $stmt = $this->db->prepare('
            SELECT p.*, c.name as category_name,
                   CASE WHEN p.parent_post_id IS NULL THEN p.title 
                   ELSE (SELECT title FROM ForumPosts WHERE id = p.parent_post_id) END as thread_title,
                   CASE WHEN p.parent_post_id IS NULL THEN p.id 
                   ELSE p.parent_post_id END as thread_id
            FROM ForumPosts p
            JOIN ForumCategories c ON p.category_id = c.id
            WHERE p.user_id = :user_id
            ORDER BY p.created_at DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get recent threads across all categories
     * 
     * @param int $limit Number of threads to return
     * @return array Recent threads
     */
    public function getRecentThreads($limit = 5)
    {
        $stmt = $this->db->prepare('
            SELECT p.*, u.username, u.avatar_url, c.name as category_name,
                   (SELECT COUNT(*) FROM ForumPosts WHERE parent_post_id = p.id) as reply_count
            FROM ForumPosts p
            JOIN Users u ON p.user_id = u.id
            JOIN ForumCategories c ON p.category_id = c.id
            WHERE p.parent_post_id IS NULL
            ORDER BY p.created_at DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get popular threads (most viewed or replied to)
     * 
     * @param int $limit Number of threads to return
     * @param string $sortBy Field to sort by ('views' or 'replies')
     * @return array Popular threads
     */
    public function getPopularThreads($limit = 5, $sortBy = 'views')
    {
        $orderBy = 'p.views_count DESC';
        
        if ($sortBy === 'replies') {
            $orderBy = 'reply_count DESC';
        }
        
        $stmt = $this->db->prepare("
            SELECT p.*, u.username, u.avatar_url, c.name as category_name,
                   (SELECT COUNT(*) FROM ForumPosts WHERE parent_post_id = p.id) as reply_count
            FROM ForumPosts p
            JOIN Users u ON p.user_id = u.id
            JOIN ForumCategories c ON p.category_id = c.id
            WHERE p.parent_post_id IS NULL
            ORDER BY {$orderBy}, p.created_at DESC
            LIMIT :limit
        ");
        
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}