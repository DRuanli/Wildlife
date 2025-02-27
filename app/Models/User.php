<?php
// app/Models/User.php

namespace App\Models;

/**
 * User Model
 * 
 * Handles database operations for the Users table
 */
class User
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
     * Find user by ID
     * 
     * @param int $id User ID
     * @return array|false User data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare('
            SELECT id, username, email, password_hash, avatar_url, bio, 
                   streak_days, total_focus_time, coins_balance, 
                   subscription_status, email_verified_at, oauth_provider, oauth_id
            FROM Users 
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find user by email
     * 
     * @param string $email Email address
     * @return array|false User data or false if not found
     */
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare('
            SELECT id, username, email, password_hash, avatar_url, bio, 
                   streak_days, total_focus_time, coins_balance, 
                   subscription_status, email_verified_at, oauth_provider, oauth_id
            FROM Users 
            WHERE email = :email
        ');
        
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find user by username
     * 
     * @param string $username Username
     * @return array|false User data or false if not found
     */
    public function findByUsername($username)
    {
        $stmt = $this->db->prepare('
            SELECT id, username, email, password_hash, avatar_url, bio, 
                   streak_days, total_focus_time, coins_balance, 
                   subscription_status, email_verified_at, oauth_provider, oauth_id
            FROM Users 
            WHERE username = :username
        ');
        
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find user by verification token
     * 
     * @param string $token Verification token
     * @return array|false User data or false if not found
     */
    public function findByVerificationToken($token)
    {
        $stmt = $this->db->prepare('
            SELECT id, username, email, password_hash, avatar_url, bio, 
                   streak_days, total_focus_time, coins_balance, 
                   subscription_status, email_verified_at, oauth_provider, oauth_id
            FROM Users 
            WHERE email_verification_token = :token
            AND email_verified_at IS NULL
        ');
        
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find user by remember token
     * 
     * @param string $token Remember token
     * @return array|false User data or false if not found
     */
    public function findByRememberToken($token)
    {
        $stmt = $this->db->prepare('
            SELECT id, username, email, password_hash, avatar_url, bio, 
                   streak_days, total_focus_time, coins_balance, 
                   subscription_status, email_verified_at, oauth_provider, oauth_id
            FROM Users 
            WHERE remember_token = :token
            AND remember_token_expires_at > NOW()
        ');
        
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Find user by OAuth provider and ID
     * 
     * @param string $provider OAuth provider (google, apple)
     * @param string $oauthId OAuth ID
     * @return array|false User data or false if not found
     */
    public function findByOAuthId($provider, $oauthId)
    {
        $stmt = $this->db->prepare('
            SELECT id, username, email, password_hash, avatar_url, bio, 
                   streak_days, total_focus_time, coins_balance, 
                   subscription_status, email_verified_at, oauth_provider, oauth_id
            FROM Users 
            WHERE oauth_provider = :provider
            AND oauth_id = :oauth_id
        ');
        
        $stmt->bindParam(':provider', $provider, \PDO::PARAM_STR);
        $stmt->bindParam(':oauth_id', $oauthId, \PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new user
     * 
     * @param array $userData User data
     * @return int|false The new user ID or false on failure
     */
    public function create($userData)
    {
        $this->db->beginTransaction();
        
        try {
            // Insert into Users table
            $stmt = $this->db->prepare('
                INSERT INTO Users (
                    username, email, password_hash, avatar_url,
                    email_verification_token, email_verified_at,
                    oauth_provider, oauth_id, created_at, updated_at
                ) VALUES (
                    :username, :email, :password_hash, :avatar_url,
                    :email_verification_token, :email_verified_at,
                    :oauth_provider, :oauth_id, NOW(), NOW()
                )
            ');
            
            $username = $userData['username'];
            $email = $userData['email'];
            $password_hash = $userData['password_hash'];
            $avatar_url = $userData['avatar_url'] ?? null;
            $email_verification_token = $userData['email_verification_token'] ?? null;
            $email_verified_at = $userData['email_verified_at'] ?? null;
            $oauth_provider = $userData['oauth_provider'] ?? null;
            $oauth_id = $userData['oauth_id'] ?? null;

            $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->bindParam(':password_hash', $password_hash, \PDO::PARAM_STR);
            $stmt->bindParam(':avatar_url', $avatar_url, \PDO::PARAM_STR);
            $stmt->bindParam(':email_verification_token', $email_verification_token, \PDO::PARAM_STR);
            $stmt->bindParam(':email_verified_at', $email_verified_at, \PDO::PARAM_STR);
            $stmt->bindParam(':oauth_provider', $oauth_provider, \PDO::PARAM_STR);
            $stmt->bindParam(':oauth_id', $oauth_id, \PDO::PARAM_STR);
            
            $stmt->execute();
            $userId = $this->db->lastInsertId();
            
            // Create default habitats for the user
            $stmt = $this->db->prepare('
                INSERT INTO Habitats (user_id, type, created_at, updated_at)
                VALUES (:user_id, "forest", NOW(), NOW())
            ');
            
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $this->db->commit();
            
            return $userId;
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    
    /**
     * Verify user's email
     * 
     * @param int $userId User ID
     * @return bool Success status
     */
    public function verifyEmail($userId)
    {
        $stmt = $this->db->prepare('
            UPDATE Users
            SET email_verified_at = NOW(),
                email_verification_token = NULL,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Update last login timestamp
     * 
     * @param int $userId User ID
     * @return bool Success status
     */
    public function updateLastLogin($userId)
    {
        $stmt = $this->db->prepare('
            UPDATE Users
            SET last_login_at = NOW(),
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Set remember token for a user
     * 
     * @param int $userId User ID
     * @param string $token Remember token
     * @param string $expireDate Expiration date (Y-m-d H:i:s format)
     * @return bool Success status
     */
    public function setRememberToken($userId, $token, $expireDate)
    {
        $stmt = $this->db->prepare('
            UPDATE Users
            SET remember_token = :token,
                remember_token_expires_at = :expires,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->bindParam(':expires', $expireDate, \PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    /**
     * Update OAuth information for a user
     * 
     * @param int $userId User ID
     * @param string $provider OAuth provider
     * @param string $oauthId OAuth ID
     * @return bool Success status
     */
    public function updateOAuthInfo($userId, $provider, $oauthId)
    {
        $stmt = $this->db->prepare('
            UPDATE Users
            SET oauth_provider = :provider,
                oauth_id = :oauth_id,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':provider', $provider, \PDO::PARAM_STR);
        $stmt->bindParam(':oauth_id', $oauthId, \PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    /**
     * Update user profile
     * 
     * @param int $userId User ID
     * @param array $profileData Profile data to update
     * @return bool Success status
     */
    public function updateProfile($userId, $profileData)
    {
        $allowedFields = ['username', 'avatar_url', 'bio'];
        $updates = [];
        $params = [':id' => $userId];
        
        foreach ($profileData as $field => $value) {
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
            UPDATE Users
            SET {$updateStr}
            WHERE id = :id
        ");
        
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Update user password
     * 
     * @param int $userId User ID
     * @param string $newPasswordHash New password hash
     * @return bool Success status
     */
    public function updatePassword($userId, $newPasswordHash)
    {
        $stmt = $this->db->prepare('
            UPDATE Users
            SET password_hash = :password_hash,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':password_hash', $newPasswordHash, \PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    /**
     * Update user focus statistics
     * 
     * @param int $userId User ID
     * @param int $focusMinutes Minutes to add to total
     * @param bool $incrementStreak Whether to increment streak
     * @return bool Success status
     */
    public function updateFocusStats($userId, $focusMinutes, $incrementStreak = true)
    {
        $streakUpdate = $incrementStreak ? 'streak_days = streak_days + 1' : 'streak_days = streak_days';
        
        $stmt = $this->db->prepare("
            UPDATE Users
            SET total_focus_time = total_focus_time + :minutes,
                {$streakUpdate},
                updated_at = NOW()
            WHERE id = :id
        ");
        
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':minutes', $focusMinutes, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Reset user streak (e.g., if they miss a day)
     * 
     * @param int $userId User ID
     * @return bool Success status
     */
    public function resetStreak($userId)
    {
        $stmt = $this->db->prepare('
            UPDATE Users
            SET streak_days = 0,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Update user coin balance
     * 
     * @param int $userId User ID
     * @param int $amount Amount to add (positive) or subtract (negative)
     * @return bool Success status
     */
    public function updateCoins($userId, $amount)
    {
        $stmt = $this->db->prepare('
            UPDATE Users
            SET coins_balance = coins_balance + :amount,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Update user subscription status
     * 
     * @param int $userId User ID
     * @param string $status Subscription status ('free' or 'premium')
     * @return bool Success status
     */
    public function updateSubscription($userId, $status)
    {
        $stmt = $this->db->prepare('
            UPDATE Users
            SET subscription_status = :status,
                updated_at = NOW()
            WHERE id = :id
        ');
        
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        
        return $stmt->execute();
    }
}