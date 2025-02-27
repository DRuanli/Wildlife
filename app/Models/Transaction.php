<?php
// app/Models/Transaction.php

namespace App\Models;

/**
 * Transaction Model
 * 
 * Handles database operations for the Transactions table
 */
class Transaction
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
     * Find a transaction by ID
     * 
     * @param int $id Transaction ID
     * @return array|false Transaction data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM Transactions
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new transaction
     * 
     * @param array $transactionData Transaction data
     * @return int|false The new transaction ID or false on failure
     */
    public function create($transactionData)
    {
        $stmt = $this->db->prepare('
            INSERT INTO Transactions (
                user_id, type, amount, currency, description, reference_id,
                created_at, updated_at
            ) VALUES (
                :user_id, :type, :amount, :currency, :description, :reference_id,
                NOW(), NOW()
            )
        ');
        
        $stmt->bindParam(':user_id', $transactionData['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':type', $transactionData['type'], \PDO::PARAM_STR);
        $stmt->bindParam(':amount', $transactionData['amount'], \PDO::PARAM_STR);
        $stmt->bindParam(':currency', $transactionData['currency'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $transactionData['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':reference_id', $transactionData['reference_id'], \PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Get transactions by user ID
     * 
     * @param int $userId User ID
     * @param int $limit Number of transactions to return
     * @param int $offset Offset for pagination
     * @return array Array of transactions
     */
    public function getByUserId($userId, $limit = 20, $offset = 0)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM Transactions
            WHERE user_id = :user_id
            ORDER BY created_at DESC
            LIMIT :limit OFFSET :offset
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get user's purchase transactions
     * 
     * @param int $userId User ID
     * @param int $limit Number of transactions to return
     * @return array Array of purchase transactions
     */
    public function getUserPurchases($userId, $limit = 20)
    {
        $stmt = $this->db->prepare('
            SELECT t.*, i.name as item_name, i.type as item_type
            FROM Transactions t
            LEFT JOIN Items i ON t.reference_id = i.id AND t.type = "purchase"
            WHERE t.user_id = :user_id
            AND t.type IN ("purchase", "spending")
            ORDER BY t.created_at DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get user's earning transactions
     * 
     * @param int $userId User ID
     * @param int $limit Number of transactions to return
     * @return array Array of earning transactions
     */
    public function getUserEarnings($userId, $limit = 20)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM Transactions
            WHERE user_id = :user_id
            AND type = "earning"
            ORDER BY created_at DESC
            LIMIT :limit
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Calculate total earnings for a user
     * 
     * @param int $userId User ID
     * @return int Total earnings
     */
    public function getTotalEarnings($userId)
    {
        $stmt = $this->db->prepare('
            SELECT SUM(amount) as total
            FROM Transactions
            WHERE user_id = :user_id
            AND type = "earning"
            AND currency = "coins"
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int)($result['total'] ?? 0);
    }
    
    /**
     * Calculate total spending for a user
     * 
     * @param int $userId User ID
     * @return int Total spending
     */
    public function getTotalSpending($userId)
    {
        $stmt = $this->db->prepare('
            SELECT SUM(amount) as total
            FROM Transactions
            WHERE user_id = :user_id
            AND type IN ("purchase", "spending")
            AND currency = "coins"
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int)($result['total'] ?? 0);
    }
    
    /**
     * Get user's transactions by item type
     * 
     * @param int $userId User ID
     * @param string $itemType Item type
     * @return array Array of transactions for the specified item type
     */
    public function getTransactionsByItemType($userId, $itemType)
    {
        $stmt = $this->db->prepare('
            SELECT t.*, i.name as item_name
            FROM Transactions t
            JOIN Items i ON t.reference_id = i.id
            WHERE t.user_id = :user_id
            AND t.type = "purchase"
            AND i.type = :item_type
            ORDER BY t.created_at DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':item_type', $itemType, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get transactions for a specific date range
     * 
     * @param int $userId User ID
     * @param string $startDate Start date (Y-m-d format)
     * @param string $endDate End date (Y-m-d format)
     * @return array Array of transactions in the date range
     */
    public function getTransactionsInDateRange($userId, $startDate, $endDate)
    {
        $stmt = $this->db->prepare('
            SELECT *
            FROM Transactions
            WHERE user_id = :user_id
            AND DATE(created_at) BETWEEN :start_date AND :end_date
            ORDER BY created_at DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $startDate, \PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get transactions summary grouped by day
     * 
     * @param int $userId User ID
     * @param int $days Number of days to include
     * @return array Daily transaction summary
     */
    public function getDailyTransactionSummary($userId, $days = 30)
    {
        $stmt = $this->db->prepare('
            SELECT 
                DATE(created_at) as date,
                type,
                currency,
                SUM(amount) as total_amount,
                COUNT(*) as transaction_count
            FROM Transactions
            WHERE user_id = :user_id
            AND created_at >= DATE_SUB(CURDATE(), INTERVAL :days DAY)
            GROUP BY DATE(created_at), type, currency
            ORDER BY date DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':days', $days, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get conservation impact transactions
     * 
     * @param int $userId User ID
     * @return array Array of conservation impact transactions
     */
    public function getConservationTransactions($userId)
    {
        $stmt = $this->db->prepare('
            SELECT t.*, i.name as package_name, i.conservation_impact
            FROM Transactions t
            JOIN Items i ON t.reference_id = i.id
            WHERE t.user_id = :user_id
            AND t.type = "purchase"
            AND i.type = "conservation_package"
            ORDER BY t.created_at DESC
        ');
        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        
        $transactions = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Parse conservation_impact JSON
        foreach ($transactions as &$transaction) {
            if (isset($transaction['conservation_impact'])) {
                $transaction['conservation_impact'] = json_decode($transaction['conservation_impact'], true);
            }
        }
        
        return $transactions;
    }
}