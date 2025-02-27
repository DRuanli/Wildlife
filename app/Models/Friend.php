<?php
// app/Models/Friend.php

namespace App\Models;

/**
 * Friend Model
 * 
 * Handles database operations for the Friends table
 */
class Friend
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
     * Get a friendship by ID
     * 
     * @param int $id Friendship ID
     * @return array|false Friendship data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM Friends
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get friendship between two users
     * 
     * @param int $userId User ID
     * @param int $friendId Friend ID
     * @return array|false Friendship data or false if not found
     */
    public function getFriendship($userId, $friendId)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM Friends
            WHERE (user_id = :user_id AND friend_id = :friend_id)
            OR (user_id = :friend_id AND friend_id = :user_id)
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':friend_id', $friendId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get user's friends
     * 
     * @param int $userId User ID
     * @return array List of friends
     */
    public function getUserFriends($userId)
    {
        $stmt = $this->db->prepare('
            SELECT f.id, f.status, f.created_at, f.updated_at,
                   CASE 
                     WHEN f.user_id = :user_id THEN f.friend_id
                     ELSE f.user_id
                   END as friend_id,
                   CASE 
                     WHEN f.user_id = :user_id THEN 0
                     ELSE 1
                   END as is_received,
                   u.username, u.avatar_url, u.last_login_at
            FROM Friends f
            JOIN Users u ON (f.user_id = :user_id AND u.id = f.friend_id) OR (f.friend_id = :user_id AND u.id = f.user_id)
            WHERE (f.user_id = :user_id OR f.friend_id = :user_id)
            AND f.status = "accepted"
            ORDER BY u.username
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get pending friend requests for a user
     * 
     * @param int $userId User ID
     * @param bool $received Whether to get received requests (true) or sent requests (false)
     * @return array List of pending friend requests
     */
    public function getPendingRequests($userId, $received = true)
    {
        if ($received) {
            $stmt = $this->db->prepare('
                SELECT f.id, f.status, f.created_at, f.updated_at,
                       f.user_id as friend_id,
                       u.username, u.avatar_url
                FROM Friends f
                JOIN Users u ON f.user_id = u.id
                WHERE f.friend_id = :user_id
                AND f.status = "pending"
                ORDER BY f.created_at DESC
            ');
        } else {
            $stmt = $this->db->prepare('
                SELECT f.id, f.status, f.created_at, f.updated_at,
                       f.friend_id,
                       u.username, u.avatar_url
                FROM Friends f
                JOIN Users u ON f.friend_id = u.id
                WHERE f.user_id = :user_id
                AND f.status = "pending"
                ORDER BY f.created_at DESC
            ');
        }
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Send a friend request
     * 
     * @param int $userId User ID (sender)
     * @param int $friendId Friend ID (recipient)
     * @return int|false The new friendship ID or false on failure
     */
    public function sendRequest($userId, $friendId)
    {
        $this->db->beginTransaction();
        
        try {
            // Check if users are already friends or have a pending request
            $friendship = $this->getFriendship($userId, $friendId);
            
            if ($friendship) {
                $this->db->rollBack();
                return false;
            }
            
            // Create new friendship
            $stmt = $this->db->prepare('
                INSERT INTO Friends (
                    user_id, friend_id, status,
                    created_at, updated_at
                ) VALUES (
                    :user_id, :friend_id, "pending",
                    NOW(), NOW()
                )
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':friend_id', $friendId, \PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            $friendshipId = $this->db->lastInsertId();
            
            $this->db->commit();
            return $friendshipId;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    
    /**
     * Accept a friend request
     * 
     * @param int $friendshipId Friendship ID
     * @param int $userId User ID (must be the recipient)
     * @return bool Success status
     */
    public function acceptRequest($friendshipId, $userId)
    {
        $this->db->beginTransaction();
        
        try {
            // Get friendship
            $stmt = $this->db->prepare('
                SELECT *
                FROM Friends
                WHERE id = :id AND friend_id = :user_id AND status = "pending"
            ');
            
            $stmt->bindParam(':id', $friendshipId, \PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $friendship = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$friendship) {
                $this->db->rollBack();
                return false;
            }
            
            // Update friendship
            $stmt = $this->db->prepare('
                UPDATE Friends
                SET status = "accepted",
                    updated_at = NOW()
                WHERE id = :id
            ');
            
            $stmt->bindParam(':id', $friendshipId, \PDO::PARAM_INT);
            
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
     * Reject a friend request
     * 
     * @param int $friendshipId Friendship ID
     * @param int $userId User ID (must be the recipient)
     * @return bool Success status
     */
    public function rejectRequest($friendshipId, $userId)
    {
        $this->db->beginTransaction();
        
        try {
            // Get friendship
            $stmt = $this->db->prepare('
                SELECT *
                FROM Friends
                WHERE id = :id AND friend_id = :user_id AND status = "pending"
            ');
            
            $stmt->bindParam(':id', $friendshipId, \PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $friendship = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$friendship) {
                $this->db->rollBack();
                return false;
            }
            
            // Delete friendship
            $stmt = $this->db->prepare('
                DELETE FROM Friends
                WHERE id = :id
            ');
            
            $stmt->bindParam(':id', $friendshipId, \PDO::PARAM_INT);
            
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
     * Cancel a sent friend request
     * 
     * @param int $friendshipId Friendship ID
     * @param int $userId User ID (must be the sender)
     * @return bool Success status
     */
    public function cancelRequest($friendshipId, $userId)
    {
        $this->db->beginTransaction();
        
        try {
            // Get friendship
            $stmt = $this->db->prepare('
                SELECT *
                FROM Friends
                WHERE id = :id AND user_id = :user_id AND status = "pending"
            ');
            
            $stmt->bindParam(':id', $friendshipId, \PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $friendship = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$friendship) {
                $this->db->rollBack();
                return false;
            }
            
            // Delete friendship
            $stmt = $this->db->prepare('
                DELETE FROM Friends
                WHERE id = :id
            ');
            
            $stmt->bindParam(':id', $friendshipId, \PDO::PARAM_INT);
            
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
     * Remove a friend
     * 
     * @param int $userId User ID
     * @param int $friendId Friend ID
     * @return bool Success status
     */
    public function removeFriend($userId, $friendId)
    {
        $this->db->beginTransaction();
        
        try {
            // Get friendship
            $friendship = $this->getFriendship($userId, $friendId);
            
            if (!$friendship || $friendship['status'] !== 'accepted') {
                $this->db->rollBack();
                return false;
            }
            
            // Delete friendship
            $stmt = $this->db->prepare('
                DELETE FROM Friends
                WHERE id = :id
            ');
            
            $stmt->bindParam(':id', $friendship['id'], \PDO::PARAM_INT);
            
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
     * Check if two users are friends
     * 
     * @param int $userId User ID
     * @param int $friendId Friend ID
     * @return bool Whether users are friends
     */
    public function areFriends($userId, $friendId)
    {
        $friendship = $this->getFriendship($userId, $friendId);
        
        return $friendship && $friendship['status'] === 'accepted';
    }
    
    /**
     * Get friend status between two users
     * 
     * @param int $userId User ID
     * @param int $friendId Friend ID
     * @return string|false Status ('accepted', 'pending_sent', 'pending_received', 'none') or false on error
     */
    public function getFriendStatus($userId, $friendId)
    {
        $friendship = $this->getFriendship($userId, $friendId);
        
        if (!$friendship) {
            return 'none';
        }
        
        if ($friendship['status'] === 'accepted') {
            return 'accepted';
        }
        
        if ($friendship['status'] === 'pending') {
            if ($friendship['user_id'] === $userId) {
                return 'pending_sent';
            } else {
                return 'pending_received';
            }
        }
        
        return false;
    }
    
    /**
     * Find users that could be friends (suggestions)
     * 
     * @param int $userId User ID
     * @param int $limit Number of suggestions to return
     * @return array List of friend suggestions
     */
    public function getFriendSuggestions($userId, $limit = 5)
    {
        // Get friends of friends
        $stmt = $this->db->prepare('
            SELECT DISTINCT u.id, u.username, u.avatar_url
            FROM Friends f1
            JOIN Friends f2 ON (f1.user_id = f2.user_id OR f1.user_id = f2.friend_id OR f1.friend_id = f2.user_id OR f1.friend_id = f2.friend_id)
            JOIN Users u ON (f2.user_id = u.id OR f2.friend_id = u.id)
            WHERE (f1.user_id = :user_id OR f1.friend_id = :user_id)
            AND f1.status = "accepted"
            AND f2.status = "accepted"
            AND u.id != :user_id
            AND NOT EXISTS (
                SELECT 1
                FROM Friends f3
                WHERE (f3.user_id = :user_id AND f3.friend_id = u.id)
                OR (f3.user_id = u.id AND f3.friend_id = :user_id)
            )
            ORDER BY RAND()
            LIMIT :limit
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        $suggestions = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // If not enough suggestions, add some random users
        if (count($suggestions) < $limit) {
            $remaining = $limit - count($suggestions);
            
            $stmt = $this->db->prepare('
                SELECT u.id, u.username, u.avatar_url
                FROM Users u
                WHERE u.id != :user_id
                AND NOT EXISTS (
                    SELECT 1
                    FROM Friends f
                    WHERE (f.user_id = :user_id AND f.friend_id = u.id)
                    OR (f.user_id = u.id AND f.friend_id = :user_id)
                )
                AND u.id NOT IN (
                    SELECT id
                    FROM Users
                    WHERE id IN (' . implode(',', array_column($suggestions, 'id')) . ')
                )
                ORDER BY RAND()
                LIMIT :limit
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':limit', $remaining, \PDO::PARAM_INT);
            $stmt->execute();
            
            $randomUsers = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            $suggestions = array_merge($suggestions, $randomUsers);
        }
        
        return $suggestions;
    }
    
    /**
     * Get friends who are currently focusing
     * 
     * @param int $userId User ID
     * @return array List of friends currently focusing
     */
    public function getFriendsFocusing($userId)
    {
        $stmt = $this->db->prepare('
            SELECT u.id, u.username, u.avatar_url,
                   fs.start_time, fs.duration_minutes
            FROM Friends f
            JOIN Users u ON (f.user_id = :user_id AND u.id = f.friend_id) OR (f.friend_id = :user_id AND u.id = f.user_id)
            JOIN FocusSessions fs ON u.id = fs.user_id
            WHERE (f.user_id = :user_id OR f.friend_id = :user_id)
            AND f.status = "accepted"
            AND fs.end_time IS NULL
            AND fs.completed = 0
            ORDER BY fs.start_time ASC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Search for users to add as friends
     * 
     * @param int $userId User ID
     * @param string $query Search query
     * @param int $limit Number of results to return
     * @return array List of users matching the search
     */
    public function searchUsers($userId, $query, $limit = 10)
    {
        $searchTerm = "%{$query}%";
        
        $stmt = $this->db->prepare('
            SELECT u.id, u.username, u.avatar_url,
                   CASE
                       WHEN EXISTS (
                           SELECT 1
                           FROM Friends f
                           WHERE ((f.user_id = :user_id AND f.friend_id = u.id) OR (f.friend_id = :user_id AND f.user_id = u.id))
                           AND f.status = "accepted"
                       ) THEN "accepted"
                       WHEN EXISTS (
                           SELECT 1
                           FROM Friends f
                           WHERE (f.user_id = :user_id AND f.friend_id = u.id)
                           AND f.status = "pending"
                       ) THEN "pending_sent"
                       WHEN EXISTS (
                           SELECT 1
                           FROM Friends f
                           WHERE (f.friend_id = :user_id AND f.user_id = u.id)
                           AND f.status = "pending"
                       ) THEN "pending_received"
                       ELSE "none"
                   END as friendship_status
            FROM Users u
            WHERE u.id != :user_id
            AND u.username LIKE :query
            LIMIT :limit
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':query', $searchTerm, \PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}