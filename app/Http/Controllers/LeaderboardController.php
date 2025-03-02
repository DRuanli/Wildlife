<?php
// app/Http/Controllers/LeaderboardController.php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\FocusSession;
use App\Models\Creature;
use App\Models\Achievement;
use App\Models\ConservationPartner;
use App\Models\Event;

/**
 * LeaderboardController
 * 
 * Handles leaderboard functionality and rankings
 */
class LeaderboardController extends Controller
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
     * @var Event $eventModel
     */
    private $eventModel;
    
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
        $this->eventModel = new Event($db);
        
        // Require authentication for leaderboard
        $this->requireAuth();
    }
    
    /**
     * Display the main leaderboard page
     * 
     * @param array $params Optional parameters
     * @return void
     */
    public function index($params = [])
    {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);
        
        // Get filter parameters
        $period = $_GET['period'] ?? 'today';
        $category = $_GET['category'] ?? 'focus_score';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        // Get top users for the selected period and category
        $users = $this->getTopUsers($period, $category, $limit, $offset);
        
        // Get user's rank and stats
        $userRank = $this->getUserRank($userId, $period, $category);
        $userStats = $this->getUserStats($userId);
        
        // Get global statistics
        $globalStats = $this->getGlobalStats();
        
        // Get upcoming challenges
        $challenges = $this->getUpcomingChallenges($userId);
        
        // Prepare data for view
        $data = [
            'user' => $user,
            'users' => $users,
            'userRank' => $userRank,
            'userStats' => $userStats,
            'globalStats' => $globalStats,
            'challenges' => $challenges,
            'period' => $period,
            'category' => $category,
            'page' => $page,
            'totalPages' => $this->getTotalPages($period, $category, $limit),
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('leaderboard/index', $data);
    }
    
    /**
     * Get user profile for the leaderboard
     * 
     * @return void
     */
    public function getProfile()
    {
        // Get profile ID from request
        $requestData = $this->getJsonInput();
        $profileId = isset($requestData['user_id']) ? (int)$requestData['user_id'] : null;
        
        if (!$profileId) {
            $this->jsonResponse(['success' => false, 'message' => 'User ID is required'], 400);
            return;
        }
        
        // Get user profile
        $user = $this->userModel->findById($profileId);
        
        if (!$user) {
            $this->jsonResponse(['success' => false, 'message' => 'User not found'], 404);
            return;
        }
        
        // Get user stats
        $focusStats = $this->focusSessionModel->getUserStats($profileId);
        $creatureStats = $this->creatureModel->countByStage($profileId);
        $achievements = $this->achievementModel->getUserAchievements($profileId);
        $conservationImpact = $this->conservationModel->getUserImpact($profileId);
        
        // Get focus history for chart
        $focusHistory = $this->getFocusHistory($profileId, 7);
        
        // Get top creatures
        $topCreatures = $this->getTopCreatures($profileId, 3);
        
        $this->jsonResponse([
            'success' => true,
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'avatar_url' => $user['avatar_url'],
                'joined_at' => $user['created_at']
            ],
            'stats' => [
                'focus_score' => $focusStats['total_minutes'] ?? 0,
                'streak_days' => $user['streak_days'] ?? 0,
                'total_creatures' => $creatureStats['total'] ?? 0,
                'mythical_creatures' => $creatureStats['mythical'] ?? 0,
                'focus_sessions' => $focusStats['total_sessions'] ?? 0,
                'avg_focus_score' => $focusStats['avg_focus_score'] ?? 0,
                'conservation_impact' => $conservationImpact
            ],
            'achievements' => $achievements,
            'focus_history' => $focusHistory,
            'top_creatures' => $topCreatures
        ]);
    }
    
    /**
     * Join a challenge
     * 
     * @return void
     */
    public function joinChallenge()
    {
        $userId = $_SESSION['user_id'];
        
        // Get challenge ID from request
        $requestData = $this->getJsonInput();
        $challengeId = isset($requestData['challenge_id']) ? (int)$requestData['challenge_id'] : null;
        
        if (!$challengeId) {
            $this->jsonResponse(['success' => false, 'message' => 'Challenge ID is required'], 400);
            return;
        }
        
        // Join the challenge
        $result = $this->eventModel->joinEvent($userId, $challengeId);
        
        if ($result) {
            $this->jsonResponse(['success' => true, 'message' => 'Successfully joined the challenge']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to join challenge'], 500);
        }
    }
    
    /**
     * Get updated leaderboard rankings
     * 
     * @return void
     */
    public function getRankings()
    {
        $userId = $_SESSION['user_id'];
        
        // Get filter parameters
        $requestData = $this->getJsonInput();
        $period = $requestData['period'] ?? 'today';
        $category = $requestData['category'] ?? 'focus_score';
        $page = isset($requestData['page']) ? max(1, (int)$requestData['page']) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        // Get top users
        $users = $this->getTopUsers($period, $category, $limit, $offset);
        
        // Get user's rank
        $userRank = $this->getUserRank($userId, $period, $category);
        
        $this->jsonResponse([
            'success' => true,
            'users' => $users,
            'userRank' => $userRank,
            'page' => $page,
            'totalPages' => $this->getTotalPages($period, $category, $limit)
        ]);
    }
    
    /**
     * Get global statistics
     * 
     * @return void
     */
    public function getGlobalStatistics()
    {
        $globalStats = $this->getGlobalStats();
        
        $this->jsonResponse([
            'success' => true,
            'stats' => $globalStats
        ]);
    }
    
    /**
     * Get top users based on period and category
     * 
     * @param string $period Time period (today, week, month, all)
     * @param string $category Ranking category (focus_score, creatures, streak, conservation)
     * @param int $limit Number of users to return
     * @param int $offset Offset for pagination
     * @return array Top users
     */
    private function getTopUsers($period, $category, $limit, $offset)
    {
        // Define date range based on period
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        
        switch ($period) {
            case 'today':
                $startDate = date('Y-m-d');
                break;
            case 'week':
                $startDate = date('Y-m-d', strtotime('-7 days'));
                break;
            case 'month':
                $startDate = date('Y-m-d', strtotime('-30 days'));
                break;
            case 'all':
                $startDate = null;
                break;
        }
        
        // Get users based on category
        switch ($category) {
            case 'focus_score':
                return $this->getTopUsersByFocusScore($startDate, $endDate, $limit, $offset);
            case 'creatures':
                return $this->getTopUsersByCreatures($limit, $offset);
            case 'streak':
                return $this->getTopUsersByStreak($limit, $offset);
            case 'conservation':
                return $this->getTopUsersByConservation($limit, $offset);
            default:
                return $this->getTopUsersByFocusScore($startDate, $endDate, $limit, $offset);
        }
    }
    
    /**
     * Get top users by focus score
     * 
     * @param string|null $startDate Start date (Y-m-d format) or null for all time
     * @param string $endDate End date (Y-m-d format)
     * @param int $limit Number of users to return
     * @param int $offset Offset for pagination
     * @return array Top users by focus score
     */
    private function getTopUsersByFocusScore($startDate, $endDate, $limit, $offset)
    {
        // Implement with SQL query to get top users by focus score in date range
        
        // For example:
        $query = '
            SELECT u.id, u.username, u.avatar_url, u.streak_days, 
                   SUM(fs.duration_minutes) as total_minutes,
                   COUNT(DISTINCT fs.id) as session_count
            FROM Users u
            JOIN FocusSessions fs ON u.id = fs.user_id
            WHERE fs.completed = 1
        ';
        
        if ($startDate) {
            $query .= ' AND DATE(fs.start_time) BETWEEN :start_date AND :end_date';
        }
        
        $query .= '
            GROUP BY u.id
            ORDER BY total_minutes DESC
            LIMIT :limit OFFSET :offset
        ';
        
        $stmt = $this->db->prepare($query);
        
        if ($startDate) {
            $stmt->bindParam(':start_date', $startDate, \PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $endDate, \PDO::PARAM_STR);
        }
        
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Enrich with creature counts
        foreach ($users as &$user) {
            $creatureCounts = $this->creatureModel->countByStage($user['id']);
            $user['creature_count'] = $creatureCounts['total'];
            $user['mythical_count'] = $creatureCounts['mythical'];
            
            // Get achievements
            $achievements = $this->achievementModel->getUserAchievements($user['id']);
            $user['achievements'] = array_slice($achievements, 0, 3);
        }
        
        return $users;
    }
    
    /**
     * Get top users by number of creatures raised
     * 
     * @param int $limit Number of users to return
     * @param int $offset Offset for pagination
     * @return array Top users by creatures
     */
    private function getTopUsersByCreatures($limit, $offset)
    {
        // Implementation similar to getTopUsersByFocusScore but with different query
        // Example query would count creatures by user
        
        // Placeholder implementation
        return [];
    }
    
    /**
     * Get top users by streak days
     * 
     * @param int $limit Number of users to return
     * @param int $offset Offset for pagination
     * @return array Top users by streak
     */
    private function getTopUsersByStreak($limit, $offset)
    {
        // Implementation similar to getTopUsersByFocusScore but with different query
        // Example query would order by streak_days
        
        // Placeholder implementation
        return [];
    }
    
    /**
     * Get top users by conservation impact
     * 
     * @param int $limit Number of users to return
     * @param int $offset Offset for pagination
     * @return array Top users by conservation impact
     */
    private function getTopUsersByConservation($limit, $offset)
    {
        // Implementation similar to getTopUsersByFocusScore but with different query
        // Example query would sum conservation impact
        
        // Placeholder implementation
        return [];
    }
    
    /**
     * Get user's rank in the leaderboard
     * 
     * @param int $userId User ID
     * @param string $period Time period
     * @param string $category Ranking category
     * @return array User's rank and stats
     */
    private function getUserRank($userId, $period, $category)
    {
        // Logic to determine user's rank based on period and category
        
        // Placeholder implementation
        return [
            'rank' => 14,
            'total' => 156,
            'focus_score' => 1850,
            'change' => '+120'
        ];
    }
    
    /**
     * Get user's statistics
     * 
     * @param int $userId User ID
     * @return array User's stats
     */
    private function getUserStats($userId)
    {
        // Get user's focus stats
        $focusStats = $this->focusSessionModel->getUserStats($userId);
        
        // Get user's creature stats
        $creatureStats = $this->creatureModel->countByStage($userId);
        
        // Get user's conservation impact
        $conservationImpact = $this->conservationModel->getUserImpact($userId);
        
        return [
            'focus_minutes' => $focusStats['total_minutes'] ?? 0,
            'focus_sessions' => $focusStats['total_sessions'] ?? 0,
            'streak_days' => $focusStats['streak_days'] ?? 0,
            'total_creatures' => $creatureStats['total'] ?? 0,
            'mythical_creatures' => $creatureStats['mythical'] ?? 0,
            'conservation_impact' => $conservationImpact
        ];
    }
    
    /**
     * Get global statistics
     * 
     * @return array Global statistics
     */
    private function getGlobalStats()
    {
        // Get global focus time 
        $stmt = $this->db->prepare('
            SELECT SUM(duration_minutes) as total_minutes
            FROM FocusSessions
            WHERE completed = 1
            AND DATE(start_time) = CURDATE()
        ');
        
        $stmt->execute();
        $focusResult = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Get total creatures
        $stmt = $this->db->prepare('
            SELECT COUNT(*) as total_creatures
            FROM Creatures
        ');
        
        $stmt->execute();
        $creaturesResult = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Get conservation impact
        $conservationImpact = $this->conservationModel->getCommunityImpact();
        
        return [
            'focus_minutes_today' => $focusResult['total_minutes'] ?? 0,
            'total_creatures' => $creaturesResult['total_creatures'] ?? 0,
            'trees_planted' => $conservationImpact['tree_planted'] ?? 0,
            'habitat_protected' => $conservationImpact['habitat_protected'] ?? 0
        ];
    }
    
    /**
     * Get upcoming challenges
     * 
     * @param int $userId User ID
     * @return array Upcoming challenges
     */
    private function getUpcomingChallenges($userId)
    {
        // Get active and upcoming events
        $events = $this->eventModel->getActiveEventsForUser($userId);
        
        // Limit to the top 3
        return array_slice($events, 0, 3);
    }
    
    /**
     * Get focus history for a user
     * 
     * @param int $userId User ID
     * @param int $days Number of days to include
     * @return array Daily focus time
     */
    private function getFocusHistory($userId, $days)
    {
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime("-{$days} days"));
        
        return $this->focusSessionModel->getDailyFocusTime($userId, $startDate, $endDate);
    }
    
    /**
     * Get top creatures for a user
     * 
     * @param int $userId User ID
     * @param int $limit Number of creatures to return
     * @return array Top creatures
     */
    private function getTopCreatures($userId, $limit)
    {
        // Get creatures by growth progress (placeholder implementation)
        $creatures = $this->creatureModel->findByUserId($userId);
        
        // Sort by growth progress
        usort($creatures, function($a, $b) {
            return $b['growth_progress'] <=> $a['growth_progress'];
        });
        
        // Return top creatures
        return array_slice($creatures, 0, $limit);
    }
    
    /**
     * Get total number of pages for pagination
     * 
     * @param string $period Time period
     * @param string $category Ranking category
     * @param int $limit Items per page
     * @return int Total pages
     */
    private function getTotalPages($period, $category, $limit)
    {
        // Implement count query based on period and category
        
        // Placeholder implementation
        return 8;
    }
}