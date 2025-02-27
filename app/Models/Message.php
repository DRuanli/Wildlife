<?php
// app/Models/Message.php

namespace App\Models;

/**
 * Message Model
 * 
 * Handles database operations for the Messages table
 */
class Message
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
     * Find a message by ID
     * 
     * @param int $id Message ID
     * @return array|false Message data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT m.*, 
                   sender.username as sender_username, 
                   sender.avatar_url as sender_avatar_url,
                   recipient.username as recipient_username, 
                   recipient.avatar_url as recipient_avatar_url
            FROM Messages m
            JOIN Users sender ON m.sender_id = sender.id
            JOIN Users recipient ON m.recipient_id = recipient.id
            WHERE m.id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get conversation between two users
     * 
     * @param int $userId First user ID
     * @param int $otherUserId Second user ID
     * @param int $page Page number
     * @param int $perPage Messages per page
     * @return array Conversation messages
     */
    public function getConversation($userId, $otherUserId, $page = 1, $perPage = 20)
    {
        $offset = ($page - 1) * $perPage;
        
        $stmt = $this->db->prepare('
            SELECT m.*, 
                   sender.username as sender_username, 
                   sender.avatar_url as sender_avatar_url
            FROM Messages m
            JOIN Users sender ON m.sender_id = sender.id
            WHERE (m.sender_id = :user_id AND m.recipient_id = :other_user_id)
            OR (m.sender_id = :other_user_id AND m.recipient_id = :user_id)
            ORDER BY m.created_at DESC
            LIMIT :limit OFFSET :offset
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':other_user_id', $otherUserId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get message count in a conversation
     * 
     * @param int $userId First user ID
     * @param int $otherUserId Second user ID
     * @return int Number of messages
     */
    public function getConversationCount($userId, $otherUserId)
    {
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as count
            FROM Messages
            WHERE (sender_id = :user_id AND recipient_id = :other_user_id)
            OR (sender_id = :other_user_id AND recipient_id = :user_id)
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':other_user_id', $otherUserId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }
    
    /**
     * Get user's conversations
     * 
     * @param int $userId User ID
     * @return array List of conversations with latest message
     */
    public function getUserConversations($userId)
    {
        $stmt = $this->db->prepare('
            SELECT 
                CASE
                    WHEN m.sender_id = :user_id THEN m.recipient_id
                    ELSE m.sender_id
                END as other_user_id,
                CASE
                    WHEN m.sender_id = :user_id THEN recipient.username
                    ELSE sender.username
                END as other_username,
                CASE
                    WHEN m.sender_id = :user_id THEN recipient.avatar_url
                    ELSE sender.avatar_url
                END as other_avatar_url,
                m.*,
                (SELECT COUNT(*) FROM Messages WHERE recipient_id = :user_id AND sender_id = other_user_id AND is_read = 0) as unread_count
            FROM Messages m
            JOIN Users sender ON m.sender_id = sender.id
            JOIN Users recipient ON m.recipient_id = recipient.id
            JOIN (
                SELECT 
                    CASE
                        WHEN sender_id = :user_id THEN recipient_id
                        ELSE sender_id
                    END as other_id,
                    MAX(created_at) as latest
                FROM Messages
                WHERE sender_id = :user_id OR recipient_id = :user_id
                GROUP BY other_id
            ) latest_msgs ON (latest_msgs.other_id = m.sender_id OR latest_msgs.other_id = m.recipient_id)
                           AND latest_msgs.latest = m.created_at
                           AND (m.sender_id = :user_id OR m.recipient_id = :user_id)
            ORDER BY m.created_at DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get unread message count for a user
     * 
     * @param int $userId User ID
     * @return int Number of unread messages
     */
    public function getUnreadCount($userId)
    {
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as count
            FROM Messages
            WHERE recipient_id = :user_id AND is_read = 0
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }
    
    /**
     * Send a message
     * 
     * @param array $messageData Message data
     * @return int|false The new message ID or false on failure
     */
    public function send($messageData)
    {
        $this->db->beginTransaction();
        
        try {
            // Check if users are friends
            $friendModel = new Friend($this->db);
            $areFriends = $friendModel->areFriends($messageData['sender_id'], $messageData['recipient_id']);
            
            if (!$areFriends) {
                // Users must be friends to send messages
                $this->db->rollBack();
                return false;
            }
            
            // Create message
            $stmt = $this->db->prepare('
                INSERT INTO Messages (
                    sender_id, recipient_id, content,
                    is_read, created_at, updated_at
                ) VALUES (
                    :sender_id, :recipient_id, :content,
                    0, NOW(), NOW()
                )
            ');
            
            $stmt->bindParam(':sender_id', $messageData['sender_id'], \PDO::PARAM_INT);
            $stmt->bindParam(':recipient_id', $messageData['recipient_id'], \PDO::PARAM_INT);
            $stmt->bindParam(':content', $messageData['content'], \PDO::PARAM_STR);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            $messageId = $this->db->lastInsertId();
            
            $this->db->commit();
            return $messageId;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    
    /**
     * Mark a message as read
     * 
     * @param int $id Message ID
     * @param int $userId User ID (must be the recipient)
     * @return bool Success status
     */
    public function markAsRead($id, $userId)
    {
        $stmt = $this->db->prepare('
            UPDATE Messages
            SET is_read = 1,
                updated_at = NOW()
            WHERE id = :id AND recipient_id = :user_id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Mark all messages from a sender as read
     * 
     * @param int $recipientId Recipient user ID
     * @param int $senderId Sender user ID
     * @return bool Success status
     */
    public function markAllAsRead($recipientId, $senderId)
    {
        $stmt = $this->db->prepare('
            UPDATE Messages
            SET is_read = 1,
                updated_at = NOW()
            WHERE recipient_id = :recipient_id 
            AND sender_id = :sender_id
            AND is_read = 0
        ');
        
        $stmt->bindParam(':recipient_id', $recipientId, \PDO::PARAM_INT);
        $stmt->bindParam(':sender_id', $senderId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Delete a message for a user
     * 
     * Note: This doesn't actually delete the message from the database,
     * but creates a record indicating the user has deleted it. This way,
     * the other user can still see the message in their conversation.
     * 
     * @param int $id Message ID
     * @param int $userId User ID
     * @return bool Success status
     */
    public function deleteForUser($id, $userId)
    {
        // TODO: Implement message deletion
        // This would require adding a 'deleted_by_sender' and 'deleted_by_recipient'
        // column to the Messages table.
        
        return false;
    }
    
    /**
     * Search user's messages
     * 
     * @param int $userId User ID
     * @param string $query Search query
     * @param int $limit Number of results to return
     * @return array List of messages matching the search
     */
    public function searchMessages($userId, $query, $limit = 10)
    {
        $searchTerm = "%{$query}%";
        
        $stmt = $this->db->prepare('
            SELECT m.*, 
                   CASE
                       WHEN m.sender_id = :user_id THEN recipient.username
                       ELSE sender.username
                   END as other_username,
                   CASE
                       WHEN m.sender_id = :user_id THEN m.recipient_id
                       ELSE m.sender_id
                   END as other_user_id
            FROM Messages m
            JOIN Users sender ON m.sender_id = sender.id
            JOIN Users recipient ON m.recipient_id = recipient.id
            WHERE (m.sender_id = :user_id OR m.recipient_id = :user_id)
            AND m.content LIKE :query
            ORDER BY m.created_at DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':query', $searchTerm, \PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get recent messages for a user
     * 
     * @param int $userId User ID
     * @param int $limit Number of messages to return
     * @return array Recent messages
     */
    public function getRecentMessages($userId, $limit = 5)
    {
        $stmt = $this->db->prepare('
            SELECT m.*, 
                   sender.username as sender_username, 
                   sender.avatar_url as sender_avatar_url,
                   recipient.username as recipient_username
            FROM Messages m
            JOIN Users sender ON m.sender_id = sender.id
            JOIN Users recipient ON m.recipient_id = recipient.id
            WHERE m.recipient_id = :user_id
            ORDER BY m.created_at DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}