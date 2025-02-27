<?php
// app/Models/Achievement.php

namespace App\Models;

/**
 * Achievement Model
 * 
 * Handles database operations for the Achievements table
 */
class Achievement
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
     * Find an achievement by ID
     * 
     * @param int $id Achievement ID
     * @return array|false Achievement data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM Achievements
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all achievements
     * 
     * @param string|null $requirementType Filter by requirement type
     * @return array Array of achievements
     */
    public function getAll($requirementType = null)
    {
        $query = 'SELECT * FROM Achievements';
        
        if ($requirementType) {
            $query .= ' WHERE requirement_type = :requirement_type';
        }
        
        $query .= ' ORDER BY requirement_type, requirement_value';
        
        $stmt = $this->db->prepare($query);
        
        if ($requirementType) {
            $stmt->bindParam(':requirement_type', $requirementType, \PDO::PARAM_STR);
        }
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new achievement
     * 
     * @param array $achievementData Achievement data
     * @return int|false The new achievement ID or false on failure
     */
    public function create($achievementData)
    {
        $stmt = $this->db->prepare('
            INSERT INTO Achievements (
                name, description, icon_url,
                requirement_type, requirement_value,
                created_at, updated_at
            ) VALUES (
                :name, :description, :icon_url,
                :requirement_type, :requirement_value,
                NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':name', $achievementData['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $achievementData['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':icon_url', $achievementData['icon_url'], \PDO::PARAM_STR);
        $stmt->bindParam(':requirement_type', $achievementData['requirement_type'], \PDO::PARAM_STR);
        $stmt->bindParam(':requirement_value', $achievementData['requirement_value'], \PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Update an achievement
     * 
     * @param int $id Achievement ID
     * @param array $achievementData Achievement data to update
     * @return bool Success status
     */
    public function update($id, $achievementData)
    {
        $allowedFields = ['name', 'description', 'icon_url', 'requirement_type', 'requirement_value'];
        $updates = [];
        $params = [':id' => $id];
        
        foreach ($achievementData as $field => $value) {
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
            UPDATE Achievements
            SET {$updateStr}
            WHERE id = :id
        ");
        
        foreach ($params as $param => $value) {
            if (is_int($value)) {
                $stmt->bindValue($param, $value, \PDO::PARAM_INT);
            } else {
                $stmt->bindValue($param, $value, \PDO::PARAM_STR);
            }
        }
        
        return $stmt->execute();
    }
    
    /**
     * Delete an achievement
     * 
     * @param int $id Achievement ID
     * @return bool Success status
     */
    public function delete($id)
    {
        // Check if achievement has been earned by any users
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as count
            FROM UserAchievements
            WHERE achievement_id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            // Cannot delete achievement that has been earned
            return false;
        }
        
        // Delete achievement
        $stmt = $this->db->prepare('
            DELETE FROM Achievements
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Get achievements earned by a user
     * 
     * @param int $userId User ID
     * @return array User's achievements
     */
    public function getUserAchievements($userId)
    {
        $stmt = $this->db->prepare('
            SELECT a.*, ua.earned_at
            FROM Achievements a
            JOIN UserAchievements ua ON a.id = ua.achievement_id
            WHERE ua.user_id = :user_id
            ORDER BY ua.earned_at DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all achievements with earned status for a user
     * 
     * @param int $userId User ID
     * @return array All achievements with earned status
     */
    public function getAllWithEarnedStatus($userId)
    {
        $stmt = $this->db->prepare('
            SELECT a.*, 
                   CASE WHEN ua.id IS NOT NULL THEN 1 ELSE 0 END as earned,
                   ua.earned_at
            FROM Achievements a
            LEFT JOIN UserAchievements ua ON a.id = ua.achievement_id AND ua.user_id = :user_id
            ORDER BY a.requirement_type, a.requirement_value
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Award an achievement to a user
     * 
     * @param int $userId User ID
     * @param int $achievementId Achievement ID
     * @return bool Success status
     */
    public function awardToUser($userId, $achievementId)
    {
        // Check if user already has this achievement
        $stmt = $this->db->prepare('
            SELECT id
            FROM UserAchievements
            WHERE user_id = :user_id AND achievement_id = :achievement_id
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':achievement_id', $achievementId, \PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->fetch()) {
            // User already has this achievement
            return true;
        }
        
        // Award the achievement
        $stmt = $this->db->prepare('
            INSERT INTO UserAchievements (
                user_id, achievement_id, earned_at,
                created_at, updated_at
            ) VALUES (
                :user_id, :achievement_id, NOW(),
                NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':achievement_id', $achievementId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Check and award focus time achievements for a user
     * 
     * @param int $userId User ID
     * @return array Newly awarded achievements
     */
    public function checkFocusTimeAchievements($userId)
    {
        $this->db->beginTransaction();
        
        try {
            // Get user's total focus time
            $stmt = $this->db->prepare('
                SELECT total_focus_time
                FROM Users
                WHERE id = :user_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$user) {
                $this->db->rollBack();
                return [];
            }
            
            $focusTime = (int)$user['total_focus_time'];
            
            // Get focus time achievements
            $stmt = $this->db->prepare('
                SELECT a.*
                FROM Achievements a
                LEFT JOIN UserAchievements ua ON a.id = ua.achievement_id AND ua.user_id = :user_id
                WHERE a.requirement_type = "focus_time"
                AND a.requirement_value <= :focus_time
                AND ua.id IS NULL
                ORDER BY a.requirement_value
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':focus_time', $focusTime, \PDO::PARAM_INT);
            $stmt->execute();
            
            $achievements = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $awarded = [];
            
            foreach ($achievements as $achievement) {
                $success = $this->awardToUser($userId, $achievement['id']);
                
                if ($success) {
                    $awarded[] = $achievement;
                }
            }
            
            $this->db->commit();
            return $awarded;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return [];
        }
    }
    
    /**
     * Check and award creature collection achievements for a user
     * 
     * @param int $userId User ID
     * @return array Newly awarded achievements
     */
    public function checkCreatureAchievements($userId)
    {
        $this->db->beginTransaction();
        
        try {
            // Get user's creature counts
            $creatureModel = new Creature($this->db);
            $counts = $creatureModel->countByStage($userId);
            
            // Get creature collection achievements
            $stmt = $this->db->prepare('
                SELECT a.*
                FROM Achievements a
                LEFT JOIN UserAchievements ua ON a.id = ua.achievement_id AND ua.user_id = :user_id
                WHERE a.requirement_type = "creatures_collected"
                AND a.requirement_value <= :creature_count
                AND ua.id IS NULL
                ORDER BY a.requirement_value
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':creature_count', $counts['total'], \PDO::PARAM_INT);
            $stmt->execute();
            
            $achievements = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $awarded = [];
            
            foreach ($achievements as $achievement) {
                $success = $this->awardToUser($userId, $achievement['id']);
                
                if ($success) {
                    $awarded[] = $achievement;
                }
            }
            
            // Check for mythical creature achievements
            if ($counts['mythical'] > 0) {
                $stmt = $this->db->prepare('
                    SELECT a.*
                    FROM Achievements a
                    LEFT JOIN UserAchievements ua ON a.id = ua.achievement_id AND ua.user_id = :user_id
                    WHERE a.requirement_type = "mythical_creatures"
                    AND a.requirement_value <= :mythical_count
                    AND ua.id IS NULL
                    ORDER BY a.requirement_value
                ');
                
                $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
                $stmt->bindParam(':mythical_count', $counts['mythical'], \PDO::PARAM_INT);
                $stmt->execute();
                
                $mythicalAchievements = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                
                foreach ($mythicalAchievements as $achievement) {
                    $success = $this->awardToUser($userId, $achievement['id']);
                    
                    if ($success) {
                        $awarded[] = $achievement;
                    }
                }
            }
            
            $this->db->commit();
            return $awarded;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return [];
        }
    }
    
    /**
     * Check and award streak achievements for a user
     * 
     * @param int $userId User ID
     * @return array Newly awarded achievements
     */
    public function checkStreakAchievements($userId)
    {
        $this->db->beginTransaction();
        
        try {
            // Get user's streak
            $stmt = $this->db->prepare('
                SELECT streak_days
                FROM Users
                WHERE id = :user_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$user) {
                $this->db->rollBack();
                return [];
            }
            
            $streakDays = (int)$user['streak_days'];
            
            // Get streak achievements
            $stmt = $this->db->prepare('
                SELECT a.*
                FROM Achievements a
                LEFT JOIN UserAchievements ua ON a.id = ua.achievement_id AND ua.user_id = :user_id
                WHERE a.requirement_type = "streak_days"
                AND a.requirement_value <= :streak_days
                AND ua.id IS NULL
                ORDER BY a.requirement_value
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':streak_days', $streakDays, \PDO::PARAM_INT);
            $stmt->execute();
            
            $achievements = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $awarded = [];
            
            foreach ($achievements as $achievement) {
                $success = $this->awardToUser($userId, $achievement['id']);
                
                if ($success) {
                    $awarded[] = $achievement;
                }
            }
            
            $this->db->commit();
            return $awarded;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return [];
        }
    }
    
    /**
     * Check all achievement types for a user
     * 
     * @param int $userId User ID
     * @return array Newly awarded achievements
     */
    public function checkAllAchievements($userId)
    {
        $awarded = [];
        
        // Check focus time achievements
        $focusAchievements = $this->checkFocusTimeAchievements($userId);
        $awarded = array_merge($awarded, $focusAchievements);
        
        // Check creature collection achievements
        $creatureAchievements = $this->checkCreatureAchievements($userId);
        $awarded = array_merge($awarded, $creatureAchievements);
        
        // Check streak achievements
        $streakAchievements = $this->checkStreakAchievements($userId);
        $awarded = array_merge($awarded, $streakAchievements);
        
        return $awarded;
    }
}