<?php
// app/Http/Controllers/FocusController.php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\FocusSession;
use App\Models\Creature;
use App\Models\Achievement;
use App\Models\ConservationPartner;

/**
 * FocusController
 * 
 * Handles the focus timer and related functionality
 */
class FocusController extends Controller
{
    /**
     * @var User $userModel
     */
    private $userModel;
    
    /**
     * @var FocusSession $focusSessionModel
     */
    private $focusSessionModel;
    
    /**
     * @var Creature $creatureModel
     */
    private $creatureModel;
    
    /**
     * @var Achievement $achievementModel
     */
    private $achievementModel;
    
    /**
     * @var ConservationPartner $conservationModel
     */
    private $conservationModel;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Database connection
     */
    public function __construct($db)
    {
        parent::__construct($db);
        $this->userModel = new User($db);
        $this->focusSessionModel = new FocusSession($db);
        $this->creatureModel = new Creature($db);
        $this->achievementModel = new Achievement($db);
        $this->conservationModel = new ConservationPartner($db);
        
        // Require authentication for focus pages
        $this->requireAuth();
    }
    
    /**
     * Display focus timer page
     * 
     * @param array $params Optional parameters
     * @return void
     */
    public function index($params = [])
    {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);
        
        // Get user's creatures to associate with the session
        $creatures = $this->creatureModel->findByUserId($userId);
        
        // Filter out fully mature creatures (mythical stage)
        $growableCreatures = array_filter($creatures, function($creature) {
            return $creature['stage'] !== 'mythical';
        });
        
        // Get any in-progress session
        $todaySessions = $this->focusSessionModel->getTodaySessionsByUserId($userId);
        $activeSession = null;
        
        foreach ($todaySessions as $session) {
            if ($session['end_time'] === null) {
                $activeSession = $session;
                break;
            }
        }
        
        // Prepare the view data
        $data = [
            'user' => $user,
            'creatures' => $growableCreatures,
            'activeSession' => $activeSession,
            'todaySessions' => $todaySessions,
            'baseUrl' => '/Wildlife'
        ];
        
        // Get recent sessions for statistics
        $recentStats = $this->focusSessionModel->getUserStats($userId);
        $data = array_merge($data, $recentStats);

        $data['personalizedTips'] = $this->getPersonalizedTips($userId);
        
        $this->render('focus/index', $data);
    }
    
    /**
     * Start a focus session
     * 
     * @return void
     */
    public function startSession()
    {
        $userId = $_SESSION['user_id'];
        
        // Get session data from request
        $requestData = $this->getJsonInput();
        if (!$requestData) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request data'], 400);
            return;
        }
        
        $durationMinutes = isset($requestData['duration']) ? (int)$requestData['duration'] : 25;
        $creatureId = isset($requestData['creature_id']) ? (int)$requestData['creature_id'] : null;
        $platform = 'web';
        
        // Check if creature exists and belongs to user
        if ($creatureId) {
            $creature = $this->creatureModel->findById($creatureId);
            if (!$creature || $creature['user_id'] != $userId) {
                $this->jsonResponse(['success' => false, 'message' => 'Invalid creature selected'], 400);
                return;
            }
        }
        
        // Check if there's already an active session
        $todaySessions = $this->focusSessionModel->getTodaySessionsByUserId($userId);
        foreach ($todaySessions as $session) {
            if ($session['end_time'] === null) {
                $this->jsonResponse(['success' => false, 'message' => 'You already have an active session'], 400);
                return;
            }
        }
        
        // Create new session
        $sessionData = [
            'user_id' => $userId,
            'start_time' => date('Y-m-d H:i:s'),
            'duration_minutes' => $durationMinutes,
            'creature_id' => $creatureId,
            'platform' => $platform
        ];
        
        $sessionId = $this->focusSessionModel->create($sessionData);
        
        if (!$sessionId) {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to start session'], 500);
            return;
        }
        
        // Get the created session
        $session = $this->focusSessionModel->findById($sessionId);
        
        $this->jsonResponse([
            'success' => true, 
            'message' => 'Session started',
            'session' => $session
        ]);
    }
    
    /**
     * Complete a focus session
     * 
     * @return void
     */
    public function completeSession()
    {
        $userId = $_SESSION['user_id'];
        
        // Get session data from request
        $requestData = $this->getJsonInput();
        if (!$requestData) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request data'], 400);
            return;
        }
        
        $sessionId = isset($requestData['session_id']) ? (int)$requestData['session_id'] : null;
        $focusScore = isset($requestData['focus_score']) ? (int)$requestData['focus_score'] : 100;
        
        if (!$sessionId) {
            $this->jsonResponse(['success' => false, 'message' => 'Session ID is required'], 400);
            return;
        }
        
        // Validate focus score (0-100)
        $focusScore = max(0, min(100, $focusScore));
        
        // Get the session
        $session = $this->focusSessionModel->findById($sessionId);
        
        if (!$session || $session['user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid session'], 404);
            return;
        }
        
        if ($session['completed']) {
            $this->jsonResponse(['success' => false, 'message' => 'Session already completed'], 400);
            return;
        }
        
        // Calculate coins earned based on duration and focus score
        $coinsEarned = ceil(($session['duration_minutes'] / 5) * ($focusScore / 100));
        
        // Complete the session
        $completionData = [
            'end_time' => date('Y-m-d H:i:s'),
            'focus_score' => $focusScore,
            'coins_earned' => $coinsEarned
        ];
        
        $success = $this->focusSessionModel->complete($sessionId, $completionData);
        
        if (!$success) {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to complete session'], 500);
            return;
        }
        
        // Check for new achievements
        $newAchievements = $this->achievementModel->checkAllAchievements($userId);
        
        // Get updated session data
        $updatedSession = $this->focusSessionModel->findById($sessionId);
        
        // Get creature data if applicable
        $creatureData = null;
        if ($session['creature_id']) {
            $creature = $this->creatureModel->findById($session['creature_id']);
            $creatureData = [
                'id' => $creature['id'],
                'name' => $creature['name'] ?? 'Your creature',
                'species_name' => $creature['species_name'] ?? 'Mysterious creature',
                'stage' => $creature['stage'],
                'growth_progress' => $creature['growth_progress']
            ];
        }
        
        $this->jsonResponse([
            'success' => true, 
            'message' => 'Session completed',
            'session' => $updatedSession,
            'coins_earned' => $coinsEarned,
            'creature' => $creatureData,
            'new_achievements' => $newAchievements
        ]);
    }

    /**
     * Get personalized focus tips based on user patterns
     * @param int $userId User ID
     * @return array Focus tips with relevance scores
     */
    private function getPersonalizedTips($userId) {
        // Get user's session data
        $recentSessions = $this->focusSessionModel->getRecentByUserId($userId, 20);
        $userStats = $this->focusSessionModel->getUserStats($userId);
        $todaySessions = $this->focusSessionModel->getTodaySessionsByUserId($userId);
        
        $tips = [];
        
        // Time of day pattern
        $morningCount = $afternoonCount = $eveningCount = $nightCount = 0;
        
        foreach($recentSessions as $session) {
            $hour = (int)date('H', strtotime($session['start_time']));
            if($hour >= 5 && $hour < 12) $morningCount++;
            elseif($hour >= 12 && $hour < 17) $afternoonCount++;
            elseif($hour >= 17 && $hour < 22) $eveningCount++;
            else $nightCount++;
        }
        
        // Add time-based tips
        $preferredTime = array_search(max($morningCount, $afternoonCount, $eveningCount, $nightCount), 
                                    [$morningCount, $afternoonCount, $eveningCount, $nightCount]);
        
        // More logic to generate personalized tips...
        
        return $tips;
    }
    
    /**
     * Cancel a focus session
     * 
     * @return void
     */
    public function cancelSession()
    {
        $userId = $_SESSION['user_id'];
        
        // Get session data from request
        $requestData = $this->getJsonInput();
        if (!$requestData) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request data'], 400);
            return;
        }
        
        $sessionId = isset($requestData['session_id']) ? (int)$requestData['session_id'] : null;
        
        if (!$sessionId) {
            $this->jsonResponse(['success' => false, 'message' => 'Session ID is required'], 400);
            return;
        }
        
        // Get the session
        $session = $this->focusSessionModel->findById($sessionId);
        
        if (!$session || $session['user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid session'], 404);
            return;
        }
        
        if ($session['completed']) {
            $this->jsonResponse(['success' => false, 'message' => 'Session already completed'], 400);
            return;
        }
        
        // Cancel the session
        $success = $this->focusSessionModel->cancel($sessionId);
        
        if (!$success) {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to cancel session'], 500);
            return;
        }
        
        $this->jsonResponse([
            'success' => true, 
            'message' => 'Session cancelled'
        ]);
    }
    
    /**
     * Display session summary
     * 
     * @param array $params Parameters
     * @return void
     */
    public function summary($params)
    {
        $userId = $_SESSION['user_id'];
        $sessionId = isset($params['id']) ? (int)$params['id'] : null;
        
        if (!$sessionId) {
            $this->redirect('/focus');
            return;
        }
        
        // Get the session
        $session = $this->focusSessionModel->findById($sessionId);
        
        if (!$session || $session['user_id'] != $userId) {
            $this->setFlashMessage('Invalid session', 'danger');
            $this->redirect('/focus');
            return;
        }
        
        // Get creature data if applicable
        $creature = null;
        if ($session['creature_id']) {
            $creature = $this->creatureModel->findById($session['creature_id']);
        }
        
        // Get conservation impact
        $conservationImpact = null;
        $partners = $this->conservationModel->getAll();
        if (!empty($partners)) {
            $conservationImpact = $this->conservationModel->calculatePotentialImpact($session['duration_minutes'], $partners[0]['id']);
        }
        
        // Prepare the view data
        $data = [
            'session' => $session,
            'creature' => $creature,
            'conservationImpact' => $conservationImpact,
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('focus/summary', $data);
    }
    
    /**
     * Get user's focus history
     * 
     * @return void
     */
    public function history()
    {
        $userId = $_SESSION['user_id'];
        
        // Get filter parameters
        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
        
        // Get sessions
        $sessions = $this->focusSessionModel->getSessionsByDateRange($userId, $startDate, $endDate);
        
        // Get daily focus time
        $dailyFocusTime = $this->focusSessionModel->getDailyFocusTime($userId, $startDate, $endDate);
        
        // Get user stats
        $userStats = $this->focusSessionModel->getUserStats($userId);
        
        // Prepare the view data
        $data = [
            'sessions' => $sessions,
            'dailyFocusTime' => $dailyFocusTime,
            'userStats' => $userStats,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('focus/history', $data);
    }
    
    /**
     * Get focus statistics API endpoint
     * 
     * @return void
     */
    public function getStats()
    {
        $userId = $_SESSION['user_id'];
        
        // Get date range
        $requestData = $this->getJsonInput();
        $startDate = isset($requestData['start_date']) ? $requestData['start_date'] : date('Y-m-d', strtotime('-30 days'));
        $endDate = isset($requestData['end_date']) ? $requestData['end_date'] : date('Y-m-d');
        
        // Get daily focus time
        $dailyFocusTime = $this->focusSessionModel->getDailyFocusTime($userId, $startDate, $endDate);
        
        // Get user stats
        $userStats = $this->focusSessionModel->getUserStats($userId);
        
        // Format data for charts
        $chartData = [];
        foreach ($dailyFocusTime as $day) {
            $chartData[] = [
                'date' => $day['date'],
                'minutes' => (int)$day['total_minutes'],
                'sessions' => (int)$day['session_count']
            ];
        }
        
        $this->jsonResponse([
            'success' => true,
            'stats' => $userStats,
            'daily_data' => $chartData
        ]);
    }
}