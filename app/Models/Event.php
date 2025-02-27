<?php
// app/Models/Event.php

namespace App\Models;

/**
 * Event Model
 * 
 * Handles database operations for the Events table
 */
class Event
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
     * Find an event by ID
     * 
     * @param int $id Event ID
     * @return array|false Event data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM Events
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all events
     * 
     * @param bool $includeInactive Whether to include inactive events
     * @return array Array of events
     */
    public function getAll($includeInactive = false)
    {
        $query = 'SELECT * FROM Events';
        
        if (!$includeInactive) {
            $now = date('Y-m-d H:i:s');
            $query .= " WHERE (start_date <= :now AND end_date >= :now)";
        }
        
        $query .= ' ORDER BY start_date DESC';
        
        $stmt = $this->db->prepare($query);
        
        if (!$includeInactive) {
            $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        }
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get active events
     * 
     * @return array Array of active events
     */
    public function getActiveEvents()
    {
        $now = date('Y-m-d H:i:s');
        
        $stmt = $this->db->prepare('
            SELECT *
            FROM Events
            WHERE start_date <= :now AND end_date >= :now
            ORDER BY end_date ASC
        ');
        
        $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get upcoming events
     * 
     * @return array Array of upcoming events
     */
    public function getUpcomingEvents()
    {
        $now = date('Y-m-d H:i:s');
        
        $stmt = $this->db->prepare('
            SELECT *
            FROM Events
            WHERE start_date > :now
            ORDER BY start_date ASC
        ');
        
        $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new event
     * 
     * @param array $eventData Event data
     * @return int|false The new event ID or false on failure
     */
    public function create($eventData)
    {
        $stmt = $this->db->prepare('
            INSERT INTO Events (
                name, description, start_date, end_date,
                rewards, created_at, updated_at
            ) VALUES (
                :name, :description, :start_date, :end_date,
                :rewards, NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':name', $eventData['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $eventData['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':start_date', $eventData['start_date'], \PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $eventData['end_date'], \PDO::PARAM_STR);
        
        // Convert rewards array to JSON
        $rewards = isset($eventData['rewards']) ? json_encode($eventData['rewards']) : null;
        $stmt->bindParam(':rewards', $rewards, \PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Update an event
     * 
     * @param int $id Event ID
     * @param array $eventData Event data to update
     * @return bool Success status
     */
    public function update($id, $eventData)
    {
        $allowedFields = ['name', 'description', 'start_date', 'end_date', 'rewards'];
        $updates = [];
        $params = [':id' => $id];
        
        foreach ($eventData as $field => $value) {
            if (in_array($field, $allowedFields)) {
                if ($field === 'rewards' && is_array($value)) {
                    $value = json_encode($value);
                }
                
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
            UPDATE Events
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
     * Delete an event
     * 
     * @param int $id Event ID
     * @return bool Success status
     */
    public function delete($id)
    {
        // Check if event has user participants
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as count
            FROM UserEvents
            WHERE event_id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            // Cannot delete event with participants
            return false;
        }
        
        // Delete event
        $stmt = $this->db->prepare('
            DELETE FROM Events
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Get event participation for a user
     * 
     * @param int $userId User ID
     * @param int $eventId Event ID
     * @return array|false Event participation data or false if not found
     */
    public function getUserParticipation($userId, $eventId)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM UserEvents
            WHERE user_id = :user_id AND event_id = :event_id
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $eventId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get active events for a user with participation info
     * 
     * @param int $userId User ID
     * @return array Active events with participation
     */
    public function getActiveEventsForUser($userId)
    {
        $now = date('Y-m-d H:i:s');
        
        $stmt = $this->db->prepare('
            SELECT e.*, 
                   ue.progress, ue.completed, ue.rewards_claimed,
                   CASE WHEN ue.id IS NOT NULL THEN 1 ELSE 0 END as participating
            FROM Events e
            LEFT JOIN UserEvents ue ON e.id = ue.event_id AND ue.user_id = :user_id
            WHERE e.start_date <= :now AND e.end_date >= :now
            ORDER BY e.end_date ASC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        $stmt->execute();
        
        $events = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Parse rewards JSON
        foreach ($events as &$event) {
            if (isset($event['rewards']) && $event['rewards']) {
                $event['rewards'] = json_decode($event['rewards'], true);
            } else {
                $event['rewards'] = [];
            }
        }
        
        return $events;
    }
    
    /**
     * Join an event
     * 
     * @param int $userId User ID
     * @param int $eventId Event ID
     * @return bool Success status
     */
    public function joinEvent($userId, $eventId)
    {
        // Check if event exists and is active
        $now = date('Y-m-d H:i:s');
        
        $stmt = $this->db->prepare('
            SELECT *
            FROM Events
            WHERE id = :id AND start_date <= :now AND end_date >= :now
        ');
        
        $stmt->bindParam(':id', $eventId, \PDO::PARAM_INT);
        $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        $stmt->execute();
        
        if (!$stmt->fetch()) {
            // Event not found or not active
            return false;
        }
        
        // Check if user is already participating
        $stmt = $this->db->prepare('
            SELECT *
            FROM UserEvents
            WHERE user_id = :user_id AND event_id = :event_id
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $eventId, \PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->fetch()) {
            // User is already participating
            return true;
        }
        
        // Join the event
        $stmt = $this->db->prepare('
            INSERT INTO UserEvents (
                user_id, event_id, progress, completed, rewards_claimed,
                created_at, updated_at
            ) VALUES (
                :user_id, :event_id, 0, 0, 0,
                NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $eventId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Update user progress in an event
     * 
     * @param int $userId User ID
     * @param int $eventId Event ID
     * @param int $progress Progress to add
     * @return bool Success status
     */
    public function updateProgress($userId, $eventId, $progress)
    {
        $this->db->beginTransaction();
        
        try {
            // Get current participation
            $stmt = $this->db->prepare('
                SELECT *
                FROM UserEvents
                WHERE user_id = :user_id AND event_id = :event_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':event_id', $eventId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $participation = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$participation) {
                // User is not participating, automatically join
                $this->joinEvent($userId, $eventId);
                $currentProgress = 0;
            } else {
                $currentProgress = (int)$participation['progress'];
            }
            
            // Get event details to check completion
            $stmt = $this->db->prepare('
                SELECT *
                FROM Events
                WHERE id = :id
            ');
            
            $stmt->bindParam(':id', $eventId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $event = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$event) {
                $this->db->rollBack();
                return false;
            }
            
            // Parse rewards to determine required progress
            $rewards = json_decode($event['rewards'], true);
            $requiredProgress = 100; // Default
            
            if (isset($rewards['required_progress'])) {
                $requiredProgress = (int)$rewards['required_progress'];
            }
            
            // Update progress
            $newProgress = $currentProgress + $progress;
            $completed = 0;
            
            if ($newProgress >= $requiredProgress) {
                $completed = 1;
            }
            
            $stmt = $this->db->prepare('
                UPDATE UserEvents
                SET progress = :progress,
                    completed = :completed,
                    updated_at = NOW()
                WHERE user_id = :user_id AND event_id = :event_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':event_id', $eventId, \PDO::PARAM_INT);
            $stmt->bindParam(':progress', $newProgress, \PDO::PARAM_INT);
            $stmt->bindParam(':completed', $completed, \PDO::PARAM_INT);
            
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
     * Claim rewards for a completed event
     * 
     * @param int $userId User ID
     * @param int $eventId Event ID
     * @return array|false Rewards claimed or false on failure
     */
    public function claimRewards($userId, $eventId)
    {
        $this->db->beginTransaction();
        
        try {
            // Check if user has completed the event and not claimed rewards
            $stmt = $this->db->prepare('
                SELECT ue.*, e.rewards
                FROM UserEvents ue
                JOIN Events e ON ue.event_id = e.id
                WHERE ue.user_id = :user_id 
                AND ue.event_id = :event_id
                AND ue.completed = 1
                AND ue.rewards_claimed = 0
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':event_id', $eventId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $participation = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$participation) {
                // Not eligible for rewards
                $this->db->rollBack();
                return false;
            }
            
            // Parse rewards
            $rewards = json_decode($participation['rewards'], true);
            
            if (!$rewards || empty($rewards)) {
                $this->db->rollBack();
                return false;
            }
            
            // Process different reward types
            $claimedRewards = [];
            
            // Coins reward
            if (isset($rewards['coins']) && $rewards['coins'] > 0) {
                $userModel = new User($this->db);
                $success = $userModel->updateCoins($userId, $rewards['coins']);
                
                if ($success) {
                    $claimedRewards['coins'] = $rewards['coins'];
                }
            }
            
            // Item rewards
            if (isset($rewards['items']) && is_array($rewards['items'])) {
                $itemModel = new Item($this->db);
                
                foreach ($rewards['items'] as $itemReward) {
                    if (isset($itemReward['id']) && isset($itemReward['quantity'])) {
                        $itemId = $itemReward['id'];
                        $quantity = $itemReward['quantity'];
                        
                        // Add item to user's inventory
                        $stmt = $this->db->prepare('
                            INSERT INTO UserItems (
                                user_id, item_id, quantity,
                                acquired_at, created_at, updated_at
                            ) VALUES (
                                :user_id, :item_id, :quantity,
                                NOW(), NOW(), NOW()
                            )
                            ON DUPLICATE KEY UPDATE
                                quantity = quantity + :quantity_update,
                                updated_at = NOW()
                        ');
                        
                        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
                        $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
                        $stmt->bindParam(':quantity', $quantity, \PDO::PARAM_INT);
                        $stmt->bindParam(':quantity_update', $quantity, \PDO::PARAM_INT);
                        
                        if ($stmt->execute()) {
                            // Get item details
                            $item = $itemModel->findById($itemId);
                            if ($item) {
                                $claimedRewards['items'][] = [
                                    'id' => $itemId,
                                    'name' => $item['name'],
                                    'quantity' => $quantity
                                ];
                            }
                        }
                    }
                }
            }
            
            // Creature rewards (special eggs, etc.)
            if (isset($rewards['creatures']) && is_array($rewards['creatures'])) {
                $creatureModel = new Creature($this->db);
                
                foreach ($rewards['creatures'] as $creatureReward) {
                    if (isset($creatureReward['species_id'])) {
                        // Create an egg of this species
                        $creatureData = [
                            'user_id' => $userId,
                            'species_id' => $creatureReward['species_id'],
                            'name' => null,
                            'stage' => 'egg',
                            'health' => 100,
                            'happiness' => 100,
                            'growth_progress' => 0,
                            'habitat_id' => null
                        ];
                        
                        $creatureId = $creatureModel->create($creatureData);
                        
                        if ($creatureId) {
                            $species = $creatureModel->findSpeciesById($creatureReward['species_id']);
                            if ($species) {
                                $claimedRewards['creatures'][] = [
                                    'id' => $creatureId,
                                    'name' => $species['name'],
                                    'rarity' => $species['rarity']
                                ];
                            }
                        }
                    }
                }
            }
            
            // Conservation impact rewards
            if (isset($rewards['conservation']) && $rewards['conservation'] > 0) {
                $partnerModel = new ConservationPartner($this->db);
                
                // Use the first available partner for simplicity
                $partners = $partnerModel->getAll();
                
                if (!empty($partners)) {
                    $partnerId = $partners[0]['id'];
                    $success = $partnerModel->recordConservationImpact(
                        $userId,
                        $partnerId,
                        'tree_planted',
                        $rewards['conservation'],
                        'event_reward'
                    );
                    
                    if ($success) {
                        $claimedRewards['conservation'] = $rewards['conservation'];
                    }
                }
            }
            
            // Mark rewards as claimed
            $stmt = $this->db->prepare('
                UPDATE UserEvents
                SET rewards_claimed = 1,
                    updated_at = NOW()
                WHERE user_id = :user_id AND event_id = :event_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':event_id', $eventId, \PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            $this->db->commit();
            return $claimedRewards;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    
    /**
     * Get event leaderboard
     * 
     * @param int $eventId Event ID
     * @param int $limit Number of top users to return
     * @return array Leaderboard data
     */
    public function getLeaderboard($eventId, $limit = 10)
    {
        $stmt = $this->db->prepare('
            SELECT ue.user_id, ue.progress, ue.completed,
                   u.username, u.avatar_url
            FROM UserEvents ue
            JOIN Users u ON ue.user_id = u.id
            WHERE ue.event_id = :event_id
            ORDER BY ue.progress DESC, ue.completed DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':event_id', $eventId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get user's rank in an event
     * 
     * @param int $userId User ID
     * @param int $eventId Event ID
     * @return int|false User's rank (position) or false if not participating
     */
    public function getUserRank($userId, $eventId)
    {
        // Get user's progress
        $stmt = $this->db->prepare('
            SELECT progress
            FROM UserEvents
            WHERE user_id = :user_id AND event_id = :event_id
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $eventId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $userEvent = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$userEvent) {
            return false;
        }
        
        $userProgress = (int)$userEvent['progress'];
        
        // Count users with higher progress
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as rank
            FROM UserEvents
            WHERE event_id = :event_id AND progress > :progress
        ');
        
        $stmt->bindParam(':event_id', $eventId, \PDO::PARAM_INT);
        $stmt->bindParam(':progress', $userProgress, \PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Rank is position + 1 (zero-indexed to one-indexed)
        return $result['rank'] + 1;
    }
}