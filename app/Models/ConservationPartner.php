<?php
// app/Models/ConservationPartner.php

namespace App\Models;

/**
 * ConservationPartner Model
 * 
 * Handles database operations for the ConservationPartners table
 */
class ConservationPartner
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
     * Find a conservation partner by ID
     * 
     * @param int $id Conservation partner ID
     * @return array|false Conservation partner data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM ConservationPartners
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all conservation partners
     * 
     * @return array Array of conservation partners
     */
    public function getAll()
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM ConservationPartners
            ORDER BY name
        ');
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new conservation partner
     * 
     * @param array $partnerData Conservation partner data
     * @return int|false The new conservation partner ID or false on failure
     */
    public function create($partnerData)
    {
        $stmt = $this->db->prepare('
            INSERT INTO ConservationPartners (
                name, description, website_url, logo_url,
                focus_to_impact_ratio, created_at, updated_at
            ) VALUES (
                :name, :description, :website_url, :logo_url,
                :focus_to_impact_ratio, NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':name', $partnerData['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $partnerData['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':website_url', $partnerData['website_url'], \PDO::PARAM_STR);
        $stmt->bindParam(':logo_url', $partnerData['logo_url'], \PDO::PARAM_STR);
        $stmt->bindParam(':focus_to_impact_ratio', $partnerData['focus_to_impact_ratio'], \PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Update a conservation partner
     * 
     * @param int $id Conservation partner ID
     * @param array $partnerData Conservation partner data to update
     * @return bool Success status
     */
    public function update($id, $partnerData)
    {
        $allowedFields = ['name', 'description', 'website_url', 'logo_url', 'focus_to_impact_ratio'];
        $updates = [];
        $params = [':id' => $id];
        
        foreach ($partnerData as $field => $value) {
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
            UPDATE ConservationPartners
            SET {$updateStr}
            WHERE id = :id
        ");
        
        foreach ($params as $param => $value) {
            if (is_int($value)) {
                $stmt->bindValue($param, $value, \PDO::PARAM_INT);
            } elseif (is_float($value)) {
                $stmt->bindValue($param, $value, \PDO::PARAM_STR);
            } else {
                $stmt->bindValue($param, $value, \PDO::PARAM_STR);
            }
        }
        
        return $stmt->execute();
    }
    
    /**
     * Delete a conservation partner
     * 
     * @param int $id Conservation partner ID
     * @return bool Success status
     */
    public function delete($id)
    {
        // Check if partner has any conservation records
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as count
            FROM Conservation
            WHERE partner_organization_id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            // Cannot delete partner with conservation records
            return false;
        }
        
        // Delete partner
        $stmt = $this->db->prepare('
            DELETE FROM ConservationPartners
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Record conservation impact
     * 
     * @param int $userId User ID
     * @param int $partnerId Partner ID
     * @param string $type Conservation type
     * @param float $amount Impact amount
     * @param string $triggeredBy What triggered this impact
     * @return int|false The new conservation record ID or false on failure
     */
    public function recordConservationImpact($userId, $partnerId, $type, $amount, $triggeredBy)
    {
        $stmt = $this->db->prepare('
            INSERT INTO Conservation (
                user_id, partner_organization_id, type,
                amount, triggered_by, created_at, updated_at
            ) VALUES (
                :user_id, :partner_id, :type,
                :amount, :triggered_by, NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':partner_id', $partnerId, \PDO::PARAM_INT);
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, \PDO::PARAM_STR);
        $stmt->bindParam(':triggered_by', $triggeredBy, \PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Get user's conservation impact
     * 
     * @param int $userId User ID
     * @return array User's conservation impact by type
     */
    public function getUserImpact($userId)
    {
        // Get total impact by type
        $stmt = $this->db->prepare('
            SELECT type, SUM(amount) as total
            FROM Conservation
            WHERE user_id = :user_id
            GROUP BY type
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $impact = [
            'tree_planted' => 0,
            'donation' => 0,
            'habitat_protected' => 0
        ];
        
        foreach ($results as $row) {
            $impact[$row['type']] = (float)$row['total'];
        }
        
        // Get additional details
        $stmt = $this->db->prepare('
            SELECT c.*, cp.name as partner_name
            FROM Conservation c
            JOIN ConservationPartners cp ON c.partner_organization_id = cp.id
            WHERE c.user_id = :user_id
            ORDER BY c.created_at DESC
            LIMIT 10
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $impact['recent_activities'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $impact;
    }
    
    /**
     * Get community conservation impact
     * 
     * @return array Community conservation impact by type
     */
    public function getCommunityImpact()
    {
        // Get total impact by type
        $stmt = $this->db->prepare('
            SELECT type, SUM(amount) as total
            FROM Conservation
            GROUP BY type
        ');
        
        $stmt->execute();
        
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $impact = [
            'tree_planted' => 0,
            'donation' => 0,
            'habitat_protected' => 0
        ];
        
        foreach ($results as $row) {
            $impact[$row['type']] = (float)$row['total'];
        }
        
        // Get top contributors
        $stmt = $this->db->prepare('
            SELECT u.id, u.username, COUNT(*) as contributions, SUM(c.amount) as total_impact
            FROM Conservation c
            JOIN Users u ON c.user_id = u.id
            GROUP BY u.id
            ORDER BY total_impact DESC
            LIMIT 10
        ');
        
        $stmt->execute();
        
        $impact['top_contributors'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Get recent activities
        $stmt = $this->db->prepare('
            SELECT c.*, u.username, cp.name as partner_name
            FROM Conservation c
            JOIN Users u ON c.user_id = u.id
            JOIN ConservationPartners cp ON c.partner_organization_id = cp.id
            ORDER BY c.created_at DESC
            LIMIT 10
        ');
        
        $stmt->execute();
        
        $impact['recent_activities'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $impact;
    }
    
    /**
     * Calculate focus minutes to conservation impact
     * 
     * @param int $focusMinutes Number of focus minutes
     * @param int $partnerId Partner ID
     * @return array Potential impact
     */
    public function calculatePotentialImpact($focusMinutes, $partnerId)
    {
        $partner = $this->findById($partnerId);
        
        if (!$partner) {
            return false;
        }
        
        $impact = $focusMinutes * $partner['focus_to_impact_ratio'];
        
        return [
            'partner_id' => $partnerId,
            'partner_name' => $partner['name'],
            'focus_minutes' => $focusMinutes,
            'potential_impact' => round($impact, 2)
        ];
    }
    
    /**
     * Convert focus sessions to conservation impact
     * 
     * This method would be called periodically to convert accumulated
     * focus time into conservation impact
     * 
     * @param int $userId User ID
     * @param int $partnerId Partner ID
     * @param int $focusMinutes Number of focus minutes to convert
     * @return bool Success status
     */
    public function convertFocusToConservation($userId, $partnerId, $focusMinutes)
    {
        $this->db->beginTransaction();
        
        try {
            $partner = $this->findById($partnerId);
            
            if (!$partner) {
                $this->db->rollBack();
                return false;
            }
            
            // Calculate impact based on partner's ratio
            $impactAmount = $focusMinutes * $partner['focus_to_impact_ratio'];
            
            // Determine impact type based on partner
            // This is just an example - actual logic would depend on your partners
            $impactType = 'tree_planted'; // Default
            
            if (stripos($partner['name'], 'ocean') !== false) {
                $impactType = 'habitat_protected';
            } elseif (stripos($partner['name'], 'fund') !== false) {
                $impactType = 'donation';
            }
            
            // Record the impact
            $success = $this->recordConservationImpact(
                $userId,
                $partnerId,
                $impactType,
                $impactAmount,
                'focus_session'
            );
            
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
}