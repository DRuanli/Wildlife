<?php
// app/Models/Item.php

namespace App\Models;

/**
 * Item Model
 * 
 * Handles database operations for the Items table
 */
class Item
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
     * Find an item by ID
     * 
     * @param int $id Item ID
     * @return array|false Item data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM Items
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all items
     * 
     * @param bool $includeUnavailable Whether to include unavailable items
     * @return array Array of items
     */
    public function getAll($includeUnavailable = false)
    {
        $query = 'SELECT * FROM Items';
        
        if (!$includeUnavailable) {
            $now = date('Y-m-d H:i:s');
            $query .= " WHERE (available_from IS NULL OR available_from <= :now) 
                        AND (available_until IS NULL OR available_until >= :now)";
        }
        
        $query .= ' ORDER BY type, price, name';
        
        $stmt = $this->db->prepare($query);
        
        if (!$includeUnavailable) {
            $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        }
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get items by type
     * 
     * @param string $type Item type (habitat_decoration, creature_accessory, consumable)
     * @param bool $includeUnavailable Whether to include unavailable items
     * @return array Array of items
     */
    public function getByType($type, $includeUnavailable = false)
    {
        $query = 'SELECT * FROM Items WHERE type = :type';
        
        if (!$includeUnavailable) {
            $now = date('Y-m-d H:i:s');
            $query .= " AND (available_from IS NULL OR available_from <= :now) 
                        AND (available_until IS NULL OR available_until >= :now)";
        }
        
        $query .= ' ORDER BY price, name';
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        
        if (!$includeUnavailable) {
            $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        }
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get limited edition items
     * 
     * @param bool $onlyAvailable Whether to only include currently available items
     * @return array Array of limited edition items
     */
    public function getLimitedEdition($onlyAvailable = true)
    {
        $query = 'SELECT * FROM Items WHERE is_limited_edition = 1';
        
        if ($onlyAvailable) {
            $now = date('Y-m-d H:i:s');
            $query .= " AND (available_from IS NULL OR available_from <= :now) 
                        AND (available_until IS NULL OR available_until >= :now)";
        }
        
        $query .= ' ORDER BY available_until, price, name';
        
        $stmt = $this->db->prepare($query);
        
        if ($onlyAvailable) {
            $stmt->bindParam(':now', $now, \PDO::PARAM_STR);
        }
        
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new item
     * 
     * @param array $itemData Item data
     * @return int|false The new item ID or false on failure
     */
    public function create($itemData)
    {
        $stmt = $this->db->prepare('
            INSERT INTO Items (
                type, name, description, price, rarity,
                is_limited_edition, conservation_impact,
                available_from, available_until,
                created_at, updated_at
            ) VALUES (
                :type, :name, :description, :price, :rarity,
                :is_limited_edition, :conservation_impact,
                :available_from, :available_until,
                NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':type', $itemData['type'], \PDO::PARAM_STR);
        $stmt->bindParam(':name', $itemData['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $itemData['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':price', $itemData['price'], \PDO::PARAM_INT);
        $stmt->bindParam(':rarity', $itemData['rarity'], \PDO::PARAM_STR);
        $stmt->bindParam(':is_limited_edition', $itemData['is_limited_edition'], \PDO::PARAM_BOOL);
        $stmt->bindParam(':conservation_impact', $itemData['conservation_impact'], \PDO::PARAM_STR);
        $stmt->bindParam(':available_from', $itemData['available_from'], \PDO::PARAM_STR);
        $stmt->bindParam(':available_until', $itemData['available_until'], \PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Update an item
     * 
     * @param int $id Item ID
     * @param array $itemData Item data to update
     * @return bool Success status
     */
    public function update($id, $itemData)
    {
        $allowedFields = [
            'type', 'name', 'description', 'price', 'rarity', 
            'is_limited_edition', 'conservation_impact', 
            'available_from', 'available_until'
        ];
        
        $updates = [];
        $params = [':id' => $id];
        
        foreach ($itemData as $field => $value) {
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
            UPDATE Items
            SET {$updateStr}
            WHERE id = :id
        ");
        
        foreach ($params as $param => $value) {
            if (is_int($value)) {
                $stmt->bindValue($param, $value, \PDO::PARAM_INT);
            } elseif (is_bool($value)) {
                $stmt->bindValue($param, $value, \PDO::PARAM_BOOL);
            } else {
                $stmt->bindValue($param, $value, \PDO::PARAM_STR);
            }
        }
        
        return $stmt->execute();
    }
    
    /**
     * Delete an item
     * 
     * @param int $id Item ID
     * @return bool Success status
     */
    public function delete($id)
    {
        // Check if item is owned by any users
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as count
            FROM UserItems
            WHERE item_id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            // Cannot delete item that is owned by users
            return false;
        }
        
        // Delete item
        $stmt = $this->db->prepare('
            DELETE FROM Items
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Purchase an item for a user
     * 
     * @param int $userId User ID
     * @param int $itemId Item ID
     * @param int $quantity Quantity to purchase (default 1)
     * @return bool Success status
     */
    public function purchaseForUser($userId, $itemId, $quantity = 1)
    {
        $this->db->beginTransaction();
        
        try {
            // Get item
            $stmt = $this->db->prepare('
                SELECT *
                FROM Items
                WHERE id = :id
            ');
            
            $stmt->bindParam(':id', $itemId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $item = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$item) {
                $this->db->rollBack();
                return false;
            }
            
            // Check if item is available
            $now = date('Y-m-d H:i:s');
            if (
                ($item['available_from'] && $item['available_from'] > $now) ||
                ($item['available_until'] && $item['available_until'] < $now)
            ) {
                $this->db->rollBack();
                return false;
            }
            
            // Get user
            $userModel = new User($this->db);
            $user = $userModel->findById($userId);
            
            if (!$user) {
                $this->db->rollBack();
                return false;
            }
            
            // Check if user has enough coins
            $totalPrice = $item['price'] * $quantity;
            if ($user['coins_balance'] < $totalPrice) {
                $this->db->rollBack();
                return false;
            }
            
            // Check if user already has this item
            $stmt = $this->db->prepare('
                SELECT *
                FROM UserItems
                WHERE user_id = :user_id AND item_id = :item_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $userItem = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($userItem) {
                // Update quantity
                $stmt = $this->db->prepare('
                    UPDATE UserItems
                    SET quantity = quantity + :quantity,
                        updated_at = NOW()
                    WHERE user_id = :user_id AND item_id = :item_id
                ');
                
                $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
                $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $quantity, \PDO::PARAM_INT);
                
                if (!$stmt->execute()) {
                    $this->db->rollBack();
                    return false;
                }
            } else {
                // Insert new user item
                $stmt = $this->db->prepare('
                    INSERT INTO UserItems (
                        user_id, item_id, quantity,
                        acquired_at, created_at, updated_at
                    ) VALUES (
                        :user_id, :item_id, :quantity,
                        NOW(), NOW(), NOW()
                    )
                ');
                
                $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
                $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $quantity, \PDO::PARAM_INT);
                
                if (!$stmt->execute()) {
                    $this->db->rollBack();
                    return false;
                }
            }
            
            // Deduct coins from user
            if (!$userModel->updateCoins($userId, -$totalPrice)) {
                $this->db->rollBack();
                return false;
            }
            
            // Record transaction
            $stmt = $this->db->prepare('
                INSERT INTO Transactions (
                    user_id, type, amount, currency,
                    description, reference_id,
                    created_at, updated_at
                ) VALUES (
                    :user_id, "spending", :amount, "coins",
                    :description, :reference_id,
                    NOW(), NOW()
                )
            ');
            
            $description = "Purchased {$quantity} x {$item['name']}";
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':amount', $totalPrice, \PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
            $stmt->bindParam(':reference_id', $itemId, \PDO::PARAM_STR);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            // Handle conservation impact if applicable
            if (!empty($item['conservation_impact'])) {
                // TODO: Implement conservation impact logic
                // This would involve creating a record in the Conservation table
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
     * Get user items
     * 
     * @param int $userId User ID
     * @return array Array of user items with item details
     */
    public function getUserItems($userId)
    {
        $stmt = $this->db->prepare('
            SELECT ui.*, i.name, i.description, i.type, i.rarity
            FROM UserItems ui
            JOIN Items i ON ui.item_id = i.id
            WHERE ui.user_id = :user_id
            ORDER BY ui.acquired_at DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get user items by type
     * 
     * @param int $userId User ID
     * @param string $type Item type
     * @return array Array of user items of the specified type
     */
    public function getUserItemsByType($userId, $type)
    {
        $stmt = $this->db->prepare('
            SELECT ui.*, i.name, i.description, i.type, i.rarity
            FROM UserItems ui
            JOIN Items i ON ui.item_id = i.id
            WHERE ui.user_id = :user_id AND i.type = :type
            ORDER BY i.rarity, i.name
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':type', $type, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Equip an item to a creature
     * 
     * @param int $userId User ID
     * @param int $itemId Item ID
     * @param int $creatureId Creature ID
     * @return bool Success status
     */
    public function equipItem($userId, $itemId, $creatureId)
    {
        $this->db->beginTransaction();
        
        try {
            // Check if user owns the item
            $stmt = $this->db->prepare('
                SELECT ui.*, i.type
                FROM UserItems ui
                JOIN Items i ON ui.item_id = i.id
                WHERE ui.user_id = :user_id AND ui.item_id = :item_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $userItem = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$userItem || $userItem['quantity'] < 1 || $userItem['type'] !== 'creature_accessory') {
                $this->db->rollBack();
                return false;
            }
            
            // Check if user owns the creature
            $stmt = $this->db->prepare('
                SELECT *
                FROM Creatures
                WHERE id = :id AND user_id = :user_id
            ');
            
            $stmt->bindParam(':id', $creatureId, \PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $creature = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$creature || $creature['stage'] === 'egg') {
                $this->db->rollBack();
                return false;
            }
            
            // Unequip any previously equipped items of this type
            $stmt = $this->db->prepare('
                UPDATE UserItems
                SET is_equipped = 0, equipped_to = NULL, updated_at = NOW()
                WHERE user_id = :user_id AND equipped_to = :creature_id
                AND item_id IN (
                    SELECT id FROM Items WHERE type = :type
                )
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':creature_id', $creatureId, \PDO::PARAM_INT);
            $stmt->bindParam(':type', $userItem['type'], \PDO::PARAM_STR);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            // Equip the new item
            $stmt = $this->db->prepare('
                UPDATE UserItems
                SET is_equipped = 1, equipped_to = :creature_id, updated_at = NOW()
                WHERE user_id = :user_id AND item_id = :item_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
            $stmt->bindParam(':creature_id', $creatureId, \PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            // Increase creature happiness
            $creatureModel = new Creature($this->db);
            if (!$creatureModel->play($creatureId, 5)) {
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
     * Unequip an item from a creature
     * 
     * @param int $userId User ID
     * @param int $itemId Item ID
     * @return bool Success status
     */
    public function unequipItem($userId, $itemId)
    {
        $stmt = $this->db->prepare('
            UPDATE UserItems
            SET is_equipped = 0, equipped_to = NULL, updated_at = NOW()
            WHERE user_id = :user_id AND item_id = :item_id AND is_equipped = 1
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Use a consumable item
     * 
     * @param int $userId User ID
     * @param int $itemId Item ID
     * @param int|null $targetId Target ID (creature or habitat ID, depending on item type)
     * @return bool Success status
     */
    public function useConsumable($userId, $itemId, $targetId = null)
    {
        $this->db->beginTransaction();
        
        try {
            // Check if user owns the item
            $stmt = $this->db->prepare('
                SELECT ui.*, i.name, i.type
                FROM UserItems ui
                JOIN Items i ON ui.item_id = i.id
                WHERE ui.user_id = :user_id AND ui.item_id = :item_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $userItem = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$userItem || $userItem['quantity'] < 1 || $userItem['type'] !== 'consumable') {
                $this->db->rollBack();
                return false;
            }
            
            // Handle different consumable effects based on item
            // This is just an example - actual effects would depend on your game design
            switch ($itemId) {
                case 1: // Example: Health Potion for creature
                    if (!$targetId) {
                        $this->db->rollBack();
                        return false;
                    }
                    
                    $creatureModel = new Creature($this->db);
                    $success = $creatureModel->feed($targetId, 50); // Big health boost
                    
                    if (!$success) {
                        $this->db->rollBack();
                        return false;
                    }
                    break;
                    
                case 2: // Example: Happiness Treat for creature
                    if (!$targetId) {
                        $this->db->rollBack();
                        return false;
                    }
                    
                    $creatureModel = new Creature($this->db);
                    $success = $creatureModel->play($targetId, 50); // Big happiness boost
                    
                    if (!$success) {
                        $this->db->rollBack();
                        return false;
                    }
                    break;
                    
                // Add more item effects as needed
                    
                default:
                    // Unknown consumable
                    $this->db->rollBack();
                    return false;
            }
            
            // Reduce item quantity
            $stmt = $this->db->prepare('
                UPDATE UserItems
                SET quantity = quantity - 1,
                    updated_at = NOW()
                WHERE user_id = :user_id AND item_id = :item_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            // Delete user item if quantity is 0
            $stmt = $this->db->prepare('
                DELETE FROM UserItems
                WHERE user_id = :user_id AND item_id = :item_id AND quantity <= 0
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $this->db->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    
    /**
     * Add a decoration to a habitat
     * 
     * @param int $userId User ID
     * @param int $itemId Item ID
     * @param int $habitatId Habitat ID
     * @return bool Success status
     */
    public function addDecorationToHabitat($userId, $itemId, $habitatId)
    {
        $this->db->beginTransaction();
        
        try {
            // Check if user owns the item
            $stmt = $this->db->prepare('
                SELECT ui.*, i.type
                FROM UserItems ui
                JOIN Items i ON ui.item_id = i.id
                WHERE ui.user_id = :user_id AND ui.item_id = :item_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $userItem = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$userItem || $userItem['quantity'] < 1 || $userItem['type'] !== 'habitat_decoration') {
                $this->db->rollBack();
                return false;
            }
            
            // Check if user owns the habitat
            $stmt = $this->db->prepare('
                SELECT *
                FROM Habitats
                WHERE id = :id AND user_id = :user_id
            ');
            
            $stmt->bindParam(':id', $habitatId, \PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $habitat = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$habitat) {
                $this->db->rollBack();
                return false;
            }
            
            // Add decoration to habitat
            $habitatModel = new Habitat($this->db);
            if (!$habitatModel->addDecoration($habitatId, $itemId)) {
                $this->db->rollBack();
                return false;
            }
            
            // Reduce item quantity
            $stmt = $this->db->prepare('
                UPDATE UserItems
                SET quantity = quantity - 1,
                    updated_at = NOW()
                WHERE user_id = :user_id AND item_id = :item_id
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }
            
            // Delete user item if quantity is 0
            $stmt = $this->db->prepare('
                DELETE FROM UserItems
                WHERE user_id = :user_id AND item_id = :item_id AND quantity <= 0
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $itemId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $this->db->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
}