<?php
// app/Models/Habitat.php

namespace App\Models;

/**
 * Habitat Model
 * 
 * Handles database operations for the Habitats table
 */
class Habitat
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
     * Find a habitat by ID
     * 
     * @param int $id Habitat ID
     * @return array|false Habitat data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT h.*, COUNT(c.id) AS creature_count
            FROM Habitats h
            LEFT JOIN Creatures c ON c.habitat_id = h.id
            WHERE h.id = :id
            GROUP BY h.id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find habitats by user ID
     * 
     * @param int $userId User ID
     * @return array Habitats data
     */
    public function findByUserId($userId)
    {
        $stmt = $this->db->prepare('
            SELECT h.*, COUNT(c.id) AS creature_count
            FROM Habitats h
            LEFT JOIN Creatures c ON c.habitat_id = h.id
            WHERE h.user_id = :user_id
            GROUP BY h.id
            ORDER BY h.created_at DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new habitat
     * 
     * @param array $habitatData Habitat data
     * @return int|false The new habitat ID or false on failure
     */
    public function create($habitatData)
    {
        $stmt = $this->db->prepare('
            INSERT INTO Habitats (
                user_id, type, level, expansion_level, decorations,
                created_at, updated_at
            ) VALUES (
                :user_id, :type, :level, :expansion_level, :decorations,
                NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':user_id', $habitatData['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':type', $habitatData['type'], \PDO::PARAM_STR);
        $stmt->bindParam(':level', $habitatData['level'], \PDO::PARAM_INT);
        $stmt->bindParam(':expansion_level', $habitatData['expansion_level'], \PDO::PARAM_INT);
        
        // Convert decorations array to JSON
        $decorations = isset($habitatData['decorations']) ? json_encode($habitatData['decorations']) : null;
        $stmt->bindParam(':decorations', $decorations, \PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Update a habitat
     * 
     * @param int $id Habitat ID
     * @param array $habitatData Habitat data to update
     * @return bool Success status
     */
    public function update($id, $habitatData)
    {
        $allowedFields = ['level', 'expansion_level', 'decorations'];
        $updates = [];
        $params = [':id' => $id];
        
        foreach ($habitatData as $field => $value) {
            if (in_array($field, $allowedFields)) {
                // Handle JSON fields
                if ($field === 'decorations' && is_array($value)) {
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
            UPDATE Habitats
            SET {$updateStr}
            WHERE id = :id
        ");
        
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Delete a habitat
     * 
     * @param int $id Habitat ID
     * @return bool Success status
     */
    public function delete($id)
    {
        // Check if habitat has creatures
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as count
            FROM Creatures
            WHERE habitat_id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            // Cannot delete habitat with creatures
            return false;
        }
        
        // Delete habitat
        $stmt = $this->db->prepare('
            DELETE FROM Habitats
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Upgrade habitat level
     * 
     * @param int $id Habitat ID
     * @return bool Success status
     */
    public function upgradeLevel($id)
    {
        $stmt = $this->db->prepare('
            UPDATE Habitats
            SET level = level + 1,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Expand habitat size
     * 
     * @param int $id Habitat ID
     * @return bool Success status
     */
    public function expandSize($id)
    {
        $stmt = $this->db->prepare('
            UPDATE Habitats
            SET expansion_level = expansion_level + 1,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Add decoration to habitat
     * 
     * @param int $id Habitat ID
     * @param int $decorationId Decoration ID
     * @return bool Success status
     */
    public function addDecoration($id, $decorationId)
    {
        // Get current decorations
        $stmt = $this->db->prepare('
            SELECT decorations
            FROM Habitats
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        $habitat = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$habitat) {
            return false;
        }
        
        // Parse decorations JSON
        $decorations = [];
        if ($habitat['decorations']) {
            $decorations = json_decode($habitat['decorations'], true);
            if (!is_array($decorations)) {
                $decorations = [];
            }
        }
        
        // Add new decoration
        $decorations[] = $decorationId;
        
        // Update decorations
        $stmt = $this->db->prepare('
            UPDATE Habitats
            SET decorations = :decorations,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $decorationsJson = json_encode($decorations);
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':decorations', $decorationsJson, \PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    /**
     * Count habitats by type for a user
     * 
     * @param int $userId User ID
     * @return array Count of each habitat type
     */
    public function countByType($userId)
    {
        $stmt = $this->db->prepare('
            SELECT type, COUNT(*) as count
            FROM Habitats
            WHERE user_id = :user_id
            GROUP BY type
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $counts = [
            'forest' => 0,
            'ocean' => 0,
            'mountain' => 0,
            'sky' => 0,
            'cosmic' => 0,
            'enchanted' => 0,
            'total' => 0
        ];
        
        foreach ($results as $row) {
            $counts[$row['type']] = (int)$row['count'];
            $counts['total'] += (int)$row['count'];
        }
        
        return $counts;
    }
}