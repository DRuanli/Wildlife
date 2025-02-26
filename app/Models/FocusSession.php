<?php
// app/Models/FocusSession.php

namespace App\Models;

/**
 * FocusSession Model
 * 
 * Handles database operations for the FocusSessions table
 */
class FocusSession
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
     * Find a focus session by ID
     * 
     * @param int $id Session ID
     * @return array|false Session data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM FocusSessions
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get recent sessions by user ID
     * 
     * @param int $userId User ID
     * @param int $limit Number of sessions to return
     * @return array Session data
     */
    public function getRecentByUserId($userId, $limit = 5)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM FocusSessions
            WHERE user_id = :user_id
            ORDER BY start_time DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get today's sessions by user ID
     * 
     * @param int $userId User ID
     * @return array Session data
     */
    public function getTodaySessionsByUserId($userId)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM FocusSessions
            WHERE user_id = :user_id
            AND DATE(start_time) = CURDATE()
            ORDER BY start_time DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get sessions by date range
     * 
     * @param int $userId User ID
     * @param string $startDate Start date (Y-m-d format)
     * @param string $endDate End date (Y-m-d format)
     * @return array Session data
     */
    public function getSessionsByDateRange($userId, $startDate, $endDate)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM FocusSessions
            WHERE user_id = :user_id
            AND DATE(start_time) BETWEEN :start_date AND :end_date
            ORDER BY start_time DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $startDate, \PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get daily focus time for date range
     * 
     * @param int $userId User ID
     * @param string $startDate Start date (Y-m-d format)
     * @param string $endDate End date (Y-m-d format)
     * @return array Daily focus time
     */
    public function getDailyFocusTime($userId, $startDate, $endDate)
    {
        $stmt = $this->db->prepare('
            SELECT 
                DATE(start_time) as date,
                SUM(duration_minutes) as total_minutes,
                COUNT(*) as session_count
            FROM FocusSessions
            WHERE user_id = :user_id
            AND completed = 1
            AND DATE(start_time) BETWEEN :start_date AND :end_date
            GROUP BY DATE(start_time)
            ORDER BY date
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $startDate, \PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new focus session
     * 
     * @param array $sessionData Session data
     * @return int|false The new session ID or false on failure
     */
    public function create($sessionData)
    {
        $stmt = $this->db->prepare('
            INSERT INTO FocusSessions (
                user_id, start_time, duration_minutes,
                creature_id, platform,
                created_at, updated_at
            ) VALUES (
                :user_id, :start_time, :duration_minutes,
                :creature_id, :platform,
                NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':user_id', $sessionData['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':start_time', $sessionData['start_time'], \PDO::PARAM_STR);
        $stmt->bindParam(':duration_minutes', $sessionData['duration_minutes'], \PDO::PARAM_INT);
        $stmt->bindParam(':creature_id', $sessionData['creature_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':platform', $sessionData['platform'], \PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Complete a focus session
     * 
     * @param int $id Session ID
     * @param array $completionData Completion data (end_time, focus_score, etc)
     * @return bool Success status
     */
    public function complete($id, $completionData)
    {
        // Start transaction
        $this->db->beginTransaction();
        
        try {
            // Update session
            $stmt = $this->db->prepare('
                UPDATE FocusSessions
                SET end_time = :end_time,
                    focus_score = :focus_score,
                    coins_earned = :coins_earned,
                    completed = 1,
                    updated_at = NOW()
                WHERE id = :id
            ');
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':end_time', $completionData['end_time'], \PDO::PARAM_STR);
            $stmt->bindParam(':focus_score', $completionData['focus_score'], \PDO::PARAM_INT);
            $stmt->bindParam(':coins_earned', $completionData['coins_earned'], \PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            // Get session data
            $session = $this->findById($id);
            
            if (!$session) {
                $this->db->rollBack();
                return false;
            }
            
            // Update user's focus stats
            $userModel = new User($this->db);
            $userModel->updateFocusStats($session['user_id'], $session['duration_minutes']);
            
            // Add coins to user
            $userModel->updateCoins($session['user_id'], $completionData['coins_earned']);
            
            // If a creature was selected for this session, update its growth
            if ($session['creature_id']) {
                $creatureModel = new Creature($this->db);
                $creatureGrowth = max(1, floor($session['duration_minutes'] / 5)); // 1 growth point per 5 minutes
                $creatureModel->increaseGrowth($session['creature_id'], $creatureGrowth);
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
     * Cancel a focus session
     * 
     * @param int $id Session ID
     * @return bool Success status
     */
    public function cancel($id)
    {
        $stmt = $this->db->prepare('
            UPDATE FocusSessions
            SET end_time = NOW(),
                completed = 0,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Get user's focus stats
     * 
     * @param int $userId User ID
     * @return array Focus stats
     */
    public function getUserStats($userId)
    {
        // Get total sessions and time
        $stmt = $this->db->prepare('
            SELECT 
                COUNT(*) as total_sessions,
                SUM(duration_minutes) as total_minutes,
                AVG(focus_score) as avg_focus_score,
                SUM(coins_earned) as total_coins,
                MAX(duration_minutes) as longest_session
            FROM FocusSessions
            WHERE user_id = :user_id
            AND completed = 1
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $stats = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Get current streak
        $stmt = $this->db->prepare('
            SELECT streak_days
            FROM Users
            WHERE id = :user_id
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        $stats['streak_days'] = $user['streak_days'] ?? 0;
        
        return $stats;
    }
}