<?php
// app/Models/Creature.php

namespace App\Models;

/**
 * Creature Model
 * 
 * Handles database operations for the Creatures table
 */
class Creature
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
     * Find a creature by ID
     * 
     * @param int $id Creature ID
     * @return array|false Creature data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT c.*, cs.name as species_name, cs.description as species_description, 
                   cs.habitat_type, cs.rarity, cs.real_world_inspiration, cs.conservation_fact
            FROM Creatures c
            JOIN CreatureSpecies cs ON c.species_id = cs.id
            WHERE c.id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find creatures by user ID
     * 
     * @param int $userId User ID
     * @return array Creatures data
     */
    public function findByUserId($userId)
    {
        $stmt = $this->db->prepare('
            SELECT c.*, cs.name as species_name, cs.habitat_type, cs.rarity
            FROM Creatures c
            JOIN CreatureSpecies cs ON c.species_id = cs.id
            WHERE c.user_id = :user_id
            ORDER BY c.created_at DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find creatures by habitat ID
     * 
     * @param int $habitatId Habitat ID
     * @return array Creatures data
     */
    public function findByHabitatId($habitatId)
    {
        $stmt = $this->db->prepare('
            SELECT c.*, cs.name as species_name, cs.habitat_type, cs.rarity
            FROM Creatures c
            JOIN CreatureSpecies cs ON c.species_id = cs.id
            WHERE c.habitat_id = :habitat_id
            ORDER BY c.stage DESC, c.created_at DESC
        ');
        
        $stmt->bindParam(':habitat_id', $habitatId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new egg/creature
     * 
     * @param array $creatureData Creature data
     * @return int|false The new creature ID or false on failure
     */
    public function create($creatureData)
    {
        $stmt = $this->db->prepare('
            INSERT INTO Creatures (
                user_id, species_id, name, stage, health, happiness,
                growth_progress, habitat_id, created_at, updated_at
            ) VALUES (
                :user_id, :species_id, :name, :stage, :health, :happiness,
                :growth_progress, :habitat_id, NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':user_id', $creatureData['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':species_id', $creatureData['species_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':name', $creatureData['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':stage', $creatureData['stage'], \PDO::PARAM_STR);
        $stmt->bindParam(':health', $creatureData['health'], \PDO::PARAM_INT);
        $stmt->bindParam(':happiness', $creatureData['happiness'], \PDO::PARAM_INT);
        $stmt->bindParam(':growth_progress', $creatureData['growth_progress'], \PDO::PARAM_INT);
        $stmt->bindParam(':habitat_id', $creatureData['habitat_id'], \PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Update a creature
     * 
     * @param int $id Creature ID
     * @param array $creatureData Creature data to update
     * @return bool Success status
     */
    public function update($id, $creatureData)
    {
        $allowedFields = ['name', 'stage', 'health', 'happiness', 'growth_progress', 'habitat_id', 'hatched_at', 'last_interaction_at'];
        $updates = [];
        $params = [':id' => $id];
        
        foreach ($creatureData as $field => $value) {
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
            UPDATE Creatures
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
     * Hatch an egg
     * 
     * @param int $id Creature ID
     * @param string $name Optional name for the creature
     * @return bool Success status
     */
    public function hatchEgg($id, $name = null)
    {
        $this->db->beginTransaction();
        
        try {
            // Get the creature
            $stmt = $this->db->prepare('
                SELECT * FROM Creatures
                WHERE id = :id AND stage = "egg"
            ');
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            
            $creature = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$creature) {
                $this->db->rollBack();
                return false;
            }
            
            // Update the creature
            $updateData = [
                'stage' => 'baby',
                'hatched_at' => date('Y-m-d H:i:s'),
                'growth_progress' => 0
            ];
            
            if ($name) {
                $updateData['name'] = $name;
            }
            
            $success = $this->update($id, $updateData);
            
            if (!$success) {
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
     * Evolve a creature to the next stage
     * 
     * @param int $id Creature ID
     * @return bool Success status
     */
    public function evolve($id)
    {
        $this->db->beginTransaction();
        
        try {
            // Get the creature
            $stmt = $this->db->prepare('
                SELECT c.*, cs.growth_stages
                FROM Creatures c
                JOIN CreatureSpecies cs ON c.species_id = cs.id
                WHERE c.id = :id AND c.stage != "mythical"
            ');
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            
            $creature = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$creature) {
                $this->db->rollBack();
                return false;
            }
            
            // Determine next stage
            $stages = ['egg', 'baby', 'juvenile', 'adult', 'mythical'];
            $currentIndex = array_search($creature['stage'], $stages);
            $nextStage = $stages[$currentIndex + 1];
            
            // Update the creature
            $updateData = [
                'stage' => $nextStage,
                'growth_progress' => 0,
                'health' => 100,
                'happiness' => 100
            ];
            
            $success = $this->update($id, $updateData);
            
            if (!$success) {
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
     * Increase creature growth progress
     * 
     * @param int $id Creature ID
     * @param int $amount Amount to increase
     * @return bool Success status
     */
    public function increaseGrowth($id, $amount)
    {
        $this->db->beginTransaction();
        
        try {
            // Get the creature
            $stmt = $this->db->prepare('
                SELECT c.*, cs.growth_stages
                FROM Creatures c
                JOIN CreatureSpecies cs ON c.species_id = cs.id
                WHERE c.id = :id AND c.stage != "mythical"
            ');
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            
            $creature = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$creature) {
                $this->db->rollBack();
                return false;
            }
            
            // Parse growth stages
            $growthStages = json_decode($creature['growth_stages'], true);
            $currentStage = $creature['stage'];
            
            // If the creature is still an egg, handle hatching
            if ($currentStage === 'egg') {
                $requiredGrowth = $growthStages['egg'] ?? 100;
                $newProgress = $creature['growth_progress'] + $amount;
                
                if ($newProgress >= $requiredGrowth) {
                    // Automatically hatch the egg
                    $this->hatchEgg($id);
                } else {
                    // Just update progress
                    $stmt = $this->db->prepare('
                        UPDATE Creatures
                        SET growth_progress = growth_progress + :amount,
                            updated_at = NOW()
                        WHERE id = :id
                    ');
                    
                    $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
                    $stmt->bindParam(':amount', $amount, \PDO::PARAM_INT);
                    $stmt->execute();
                }
                
                $this->db->commit();
                return true;
            }
            
            // For other stages, check if evolution is needed
            $requiredGrowth = $growthStages[$currentStage] ?? 200;
            $newProgress = $creature['growth_progress'] + $amount;
            
            if ($newProgress >= $requiredGrowth) {
                // Evolve to the next stage
                $this->evolve($id);
            } else {
                // Just update progress
                $stmt = $this->db->prepare('
                    UPDATE Creatures
                    SET growth_progress = growth_progress + :amount,
                        updated_at = NOW(),
                        last_interaction_at = NOW()
                    WHERE id = :id
                ');
                
                $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
                $stmt->bindParam(':amount', $amount, \PDO::PARAM_INT);
                $stmt->execute();
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
     * Feed a creature to increase health
     * 
     * @param int $id Creature ID
     * @param int $amount Amount to increase health (default 10)
     * @return bool Success status
     */
    public function feed($id, $amount = 10)
    {
        $stmt = $this->db->prepare('
            UPDATE Creatures
            SET health = LEAST(health + :amount, 100),
                last_interaction_at = NOW(),
                updated_at = NOW()
            WHERE id = :id AND stage != "egg"
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Play with a creature to increase happiness
     * 
     * @param int $id Creature ID
     * @param int $amount Amount to increase happiness (default 10)
     * @return bool Success status
     */
    public function play($id, $amount = 10)
    {
        $stmt = $this->db->prepare('
            UPDATE Creatures
            SET happiness = LEAST(happiness + :amount, 100),
                last_interaction_at = NOW(),
                updated_at = NOW()
            WHERE id = :id AND stage != "egg"
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Move a creature to a different habitat
     * 
     * @param int $id Creature ID
     * @param int $habitatId New habitat ID
     * @return bool Success status
     */
    public function moveToHabitat($id, $habitatId)
    {
        $this->db->beginTransaction();
        
        try {
            // Verify the habitat exists and belongs to the same user
            $stmt = $this->db->prepare('
                SELECT c.user_id, h.id, h.user_id as habitat_user_id, h.type, cs.habitat_type
                FROM Creatures c
                JOIN CreatureSpecies cs ON c.species_id = cs.id
                JOIN Habitats h ON h.id = :habitat_id
                WHERE c.id = :id
            ');
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':habitat_id', $habitatId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$result || $result['user_id'] !== $result['habitat_user_id']) {
                $this->db->rollBack();
                return false;
            }
            
            // Check if habitat type matches creature's preferred habitat
            $habitatMatch = ($result['type'] === $result['habitat_type']);
            
            // Move the creature
            $stmt = $this->db->prepare('
                UPDATE Creatures
                SET habitat_id = :habitat_id,
                    happiness = LEAST(happiness + :happiness_mod, 100),
                    updated_at = NOW()
                WHERE id = :id
            ');
            
            $happinessMod = $habitatMatch ? 10 : -5; // Bonus if habitat matches, penalty if not
            
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':habitat_id', $habitatId, \PDO::PARAM_INT);
            $stmt->bindParam(':happiness_mod', $happinessMod, \PDO::PARAM_INT);
            
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
     * Count creatures by stage for a user
     * 
     * @param int $userId User ID
     * @return array Count of creatures by stage
     */
    public function countByStage($userId)
    {
        $stmt = $this->db->prepare('
            SELECT stage, COUNT(*) as count
            FROM Creatures
            WHERE user_id = :user_id
            GROUP BY stage
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $counts = [
            'egg' => 0,
            'baby' => 0,
            'juvenile' => 0,
            'adult' => 0,
            'mythical' => 0,
            'total' => 0
        ];
        
        foreach ($results as $row) {
            $counts[$row['stage']] = (int)$row['count'];
            $counts['total'] += (int)$row['count'];
        }
        
        return $counts;
    }

    /**
     * Get all creature species
     * 
     * @return array Array of creature species
     */
    public function getAllSpecies()
    {
        $stmt = $this->db->prepare('
            SELECT * FROM CreatureSpecies
            ORDER BY rarity, name
        ');
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find a creature species by ID
     * 
     * @param int $id Species ID
     * @return array|false Species data or false if not found
     */
    public function findSpeciesById($id)
    {
        $stmt = $this->db->prepare('
            SELECT * FROM CreatureSpecies
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find creature species by habitat type
     * 
     * @param string $habitatType Habitat type
     * @return array Species data
     */
    public function findSpeciesByHabitatType($habitatType)
    {
        $stmt = $this->db->prepare('
            SELECT * FROM CreatureSpecies
            WHERE habitat_type = :habitat_type
            ORDER BY rarity, name
        ');
        
        $stmt->bindParam(':habitat_type', $habitatType, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}