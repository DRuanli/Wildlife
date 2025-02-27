<?php
// Path: app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Creature;
use App\Models\Habitat;
use App\Models\FocusSession;

/**
 * DashboardController
 * 
 * Handles dashboard and user profile functionality
 */
class DashboardController extends Controller
{
    /**
     * @var User $userModel
     */
    private $userModel;
    
    /**
     * @var Creature $creatureModel
     */
    private $creatureModel;
    
    /**
     * @var Habitat $habitatModel
     */
    private $habitatModel;
    
    /**
     * @var FocusSession $focusSessionModel
     */
    private $focusSessionModel;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Database connection
     */
    public function __construct($db)
    {
        parent::__construct($db);
        $this->userModel = new User($db);
        
        // Initialize other models when they're implemented
        // $this->creatureModel = new Creature($db);
        // $this->habitatModel = new Habitat($db);
        // $this->focusSessionModel = new FocusSession($db);
        
        // Require authentication for all dashboard pages
        $this->requireAuth();
    }
    
    /**
     * Display main dashboard page
     * 
     * @return void
     */
    public function index()
    {
        // Get user data
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);
        
        // Get user's creatures (implement when Creature model is ready)
        $creatures = []; // $this->creatureModel->findByUserId($userId);
        
        // Get user's habitats (implement when Habitat model is ready)
        $habitats = []; // $this->habitatModel->findByUserId($userId);
        
        // Get recent focus sessions (implement when FocusSession model is ready)
        $recentSessions = []; // $this->focusSessionModel->getRecentByUserId($userId, 5);
        
        // Calculate focus stats
        $totalFocusTime = $user['total_focus_time'] ?? 0;
        $focusStreak = $user['streak_days'] ?? 0;
        
        // Prepare data for the view
        $data = [
            'user' => $user,
            'creatures' => $creatures,
            'habitats' => $habitats,
            'recentSessions' => $recentSessions,
            'totalFocusTime' => $totalFocusTime,
            'focusStreak' => $focusStreak,
            'coinsBalance' => $user['coins_balance'] ?? 0,
        ];
        
        $this->render('dashboard/index', $data);
    }
    
    /**
     * Display user profile page
     * 
     * @return void
     */
    public function profile()
    {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);
        
        // Get user achievements (implement later)
        $achievements = [];
        
        $data = [
            'user' => $user,
            'achievements' => $achievements
        ];
        
        $this->render('dashboard/profile', $data);
    }
    
    /**
     * Display user settings page
     * 
     * @return void
     */
    public function settings()
    {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);
        
        $data = [
            'user' => $user
        ];
        
        $this->render('dashboard/settings', $data);
    }
    
    /**
     * Update user profile
     * 
     * @return void
     */
    public function updateProfile()
    {
        $userId = $_SESSION['user_id'];
        
        // Get profile data from form
        $username = trim($_POST['username'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        
        // Handle avatar upload
        $avatarUrl = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatarUrl = $this->handleAvatarUpload($_FILES['avatar']);
        }
        
        // Prepare update data
        $profileData = [
            'username' => $username,
            'bio' => $bio
        ];
        
        // Only include avatar URL if uploaded
        if ($avatarUrl) {
            $profileData['avatar_url'] = $avatarUrl;
        }
        
        // Update profile
        $success = $this->userModel->updateProfile($userId, $profileData);
        
        if ($success) {
            // Update session with new username
            $_SESSION['username'] = $username;
            
            $this->setFlashMessage('Profile updated successfully!', 'success');
        } else {
            $this->setFlashMessage('Error updating profile. Please try again.', 'danger');
        }
        
        $this->redirect('/dashboard/profile');
    }
    
    /**
     * Handle avatar image upload
     * 
     * @param array $file Uploaded file data
     * @return string|null URL of uploaded avatar or null on failure
     */
    private function handleAvatarUpload($file)
    {
        // Create upload directory if it doesn't exist
        $uploadDir = ROOT_PATH . '/public/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate unique filename
        $filename = md5(uniqid(rand(), true)) . '.jpg';
        $filepath = $uploadDir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Resize image (implement if needed)
            // ...
            
            // Return URL path
            return '/uploads/avatars/' . $filename;
        }
        
        return null;
    }
    
    /**
     * Update user password
     * 
     * @return void
     */
    public function updatePassword()
    {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);
        
        // Get password data from form
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validate current password
        if (!password_verify($currentPassword, $user['password_hash'])) {
            $this->setFlashMessage('Current password is incorrect.', 'danger');
            $this->redirect('/dashboard/settings');
            return;
        }
        
        // Validate new password
        if (strlen($newPassword) < 8) {
            $this->setFlashMessage('New password must be at least 8 characters.', 'danger');
            $this->redirect('/dashboard/settings');
            return;
        }
        
        // Validate password confirmation
        if ($newPassword !== $confirmPassword) {
            $this->setFlashMessage('New passwords do not match.', 'danger');
            $this->redirect('/dashboard/settings');
            return;
        }
        
        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update password
        $success = $this->userModel->updatePassword($userId, $hashedPassword);
        
        if ($success) {
            $this->setFlashMessage('Password updated successfully!', 'success');
        } else {
            $this->setFlashMessage('Error updating password. Please try again.', 'danger');
        }
        
        $this->redirect('/dashboard/settings');
    }
}