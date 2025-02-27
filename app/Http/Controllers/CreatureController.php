<?php
// app/Http/Controllers/CreatureController.php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Creature;
use App\Models\Habitat;
use App\Models\Achievement;

/**
 * CreatureController
 * 
 * Handles creature functionality
 */
class CreatureController extends Controller
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
     * @var Achievement $achievementModel
     */
    private $achievementModel;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Database connection
     */
    public function __construct($db)
    {
        parent::__construct($db);
        $this->userModel = new User($db);
        $this->creatureModel = new Creature($db);
        $this->habitatModel = new Habitat($db);
        $this->achievementModel = new Achievement($db);
        
        // Require authentication for creature pages
        $this->requireAuth();
    }
    
    /**
     * Display all user's creatures
     * 
     * @return void
     */
    public function index()
    {
        $userId = $_SESSION['user_id'];
        
        // Get all user's creatures
        $creatures = $this->creatureModel->findByUserId($userId);
        
        // Get user's habitats
        $habitats = $this->habitatModel->findByUserId($userId);
        
        // Get creature statistics
        $creatureStats = $this->creatureModel->countByStage($userId);
        
        // Organize creatures by stage
        $organized = [
            'eggs' => [],
            'babies' => [],
            'juveniles' => [],
            'adults' => [],
            'mythicals' => []
        ];
        
        foreach ($creatures as $creature) {
            switch ($creature['stage']) {
                case 'egg':
                    $organized['eggs'][] = $creature;
                    break;
                case 'baby':
                    $organized['babies'][] = $creature;
                    break;
                case 'juvenile':
                    $organized['juveniles'][] = $creature;
                    break;
                case 'adult':
                    $organized['adults'][] = $creature;
                    break;
                case 'mythical':
                    $organized['mythicals'][] = $creature;
                    break;
            }
        }
        
        // Prepare view data
        $data = [
            'creatures' => $creatures,
            'organized' => $organized,
            'habitats' => $habitats,
            'creatureStats' => $creatureStats,
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('creatures/index', $data);
    }
    
    /**
     * View a specific creature
     * 
     * @param array $params Parameters from URL
     * @return void
     */
    public function view($params)
    {
        $userId = $_SESSION['user_id'];
        $creatureId = isset($params['id']) ? (int)$params['id'] : null;
        
        if (!$creatureId) {
            $this->setFlashMessage('Invalid creature ID', 'danger');
            $this->redirect('/creatures');
            return;
        }
        
        // Get creature details
        $creature = $this->creatureModel->findById($creatureId);
        
        if (!$creature || $creature['user_id'] != $userId) {
            $this->setFlashMessage('Creature not found', 'danger');
            $this->redirect('/creatures');
            return;
        }
        
        // Get user's habitats
        $habitats = $this->habitatModel->findByUserId($userId);
        
        // Get current habitat if any
        $currentHabitat = null;
        if ($creature['habitat_id']) {
            foreach ($habitats as $habitat) {
                if ($habitat['id'] == $creature['habitat_id']) {
                    $currentHabitat = $habitat;
                    break;
                }
            }
        }
        
        // Prepare growth data
        $growthData = [
            'percentage' => 0,
            'next_stage' => null
        ];
        
        // Calculate growth percentage based on stage
        switch ($creature['stage']) {
            case 'egg':
                $growthData['percentage'] = min(100, ($creature['growth_progress'] / 100) * 100);
                $growthData['next_stage'] = 'baby';
                break;
            case 'baby':
                $growthData['percentage'] = min(100, ($creature['growth_progress'] / 200) * 100);
                $growthData['next_stage'] = 'juvenile';
                break;
            case 'juvenile':
                $growthData['percentage'] = min(100, ($creature['growth_progress'] / 200) * 100);
                $growthData['next_stage'] = 'adult';
                break;
            case 'adult':
                $growthData['percentage'] = min(100, ($creature['growth_progress'] / 200) * 100);
                $growthData['next_stage'] = 'mythical';
                break;
            case 'mythical':
                $growthData['percentage'] = 100;
                $growthData['next_stage'] = null;
                break;
        }
        
        // Prepare view data
        $data = [
            'creature' => $creature,
            'habitats' => $habitats,
            'currentHabitat' => $currentHabitat,
            'growthData' => $growthData,
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('creatures/view', $data);
    }
    
    /**
     * Process hatching an egg
     * 
     * @return void
     */
    public function hatchEgg()
    {
        $userId = $_SESSION['user_id'];
        
        // Get request data
        $requestData = $this->getJsonInput();
        if (!$requestData) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request data'], 400);
            return;
        }
        
        $creatureId = isset($requestData['creature_id']) ? (int)$requestData['creature_id'] : null;
        $name = isset($requestData['name']) ? trim($requestData['name']) : null;
        
        if (!$creatureId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature ID is required'], 400);
            return;
        }
        
        // Validate name
        if (!$name || strlen($name) < 2 || strlen($name) > 50) {
            $this->jsonResponse(['success' => false, 'message' => 'Name must be between 2 and 50 characters'], 400);
            return;
        }
        
        // Get creature
        $creature = $this->creatureModel->findById($creatureId);
        
        if (!$creature || $creature['user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature not found'], 404);
            return;
        }
        
        if ($creature['stage'] !== 'egg') {
            $this->jsonResponse(['success' => false, 'message' => 'This creature is already hatched'], 400);
            return;
        }
        
        if ($creature['growth_progress'] < 100) {
            $this->jsonResponse(['success' => false, 'message' => 'This egg is not ready to hatch yet'], 400);
            return;
        }
        
        // Hatch the egg
        $success = $this->creatureModel->hatchEgg($creatureId, $name);
        
        if (!$success) {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to hatch egg'], 500);
            return;
        }
        
        // Get updated creature
        $updatedCreature = $this->creatureModel->findById($creatureId);
        
        // Check for new achievements
        $newAchievements = $this->achievementModel->checkCreatureAchievements($userId);
        
        $this->jsonResponse([
            'success' => true,
            'message' => 'Egg hatched successfully!',
            'creature' => $updatedCreature,
            'new_achievements' => $newAchievements
        ]);
    }
    
    /**
     * Process evolving a creature
     * 
     * @return void
     */
    public function evolveCreature()
    {
        $userId = $_SESSION['user_id'];
        
        // Get request data
        $requestData = $this->getJsonInput();
        if (!$requestData) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request data'], 400);
            return;
        }
        
        $creatureId = isset($requestData['creature_id']) ? (int)$requestData['creature_id'] : null;
        
        if (!$creatureId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature ID is required'], 400);
            return;
        }
        
        // Get creature
        $creature = $this->creatureModel->findById($creatureId);
        
        if (!$creature || $creature['user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature not found'], 404);
            return;
        }
        
        if ($creature['stage'] === 'egg') {
            $this->jsonResponse(['success' => false, 'message' => 'You need to hatch this egg first'], 400);
            return;
        }
        
        if ($creature['stage'] === 'mythical') {
            $this->jsonResponse(['success' => false, 'message' => 'This creature is already fully evolved'], 400);
            return;
        }
        
        if ($creature['growth_progress'] < 200) {
            $this->jsonResponse(['success' => false, 'message' => 'This creature is not ready to evolve yet'], 400);
            return;
        }
        
        // Evolve the creature
        $success = $this->creatureModel->evolve($creatureId);
        
        if (!$success) {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to evolve creature'], 500);
            return;
        }
        
        // Get updated creature
        $updatedCreature = $this->creatureModel->findById($creatureId);
        
        // Check for new achievements
        $newAchievements = $this->achievementModel->checkCreatureAchievements($userId);
        
        $this->jsonResponse([
            'success' => true,
            'message' => 'Creature evolved successfully!',
            'creature' => $updatedCreature,
            'new_achievements' => $newAchievements
        ]);
    }
    
    /**
     * Process feeding a creature
     * 
     * @return void
     */
    public function feedCreature()
    {
        $userId = $_SESSION['user_id'];
        
        // Get request data
        $requestData = $this->getJsonInput();
        if (!$requestData) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request data'], 400);
            return;
        }
        
        $creatureId = isset($requestData['creature_id']) ? (int)$requestData['creature_id'] : null;
        
        if (!$creatureId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature ID is required'], 400);
            return;
        }
        
        // Get creature
        $creature = $this->creatureModel->findById($creatureId);
        
        if (!$creature || $creature['user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature not found'], 404);
            return;
        }
        
        if ($creature['stage'] === 'egg') {
            $this->jsonResponse(['success' => false, 'message' => 'Eggs don\'t need feeding'], 400);
            return;
        }
        
        // Feed the creature
        $success = $this->creatureModel->feed($creatureId);
        
        if (!$success) {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to feed creature'], 500);
            return;
        }
        
        // Get updated creature
        $updatedCreature = $this->creatureModel->findById($creatureId);
        
        $this->jsonResponse([
            'success' => true,
            'message' => 'Creature fed successfully!',
            'creature' => $updatedCreature
        ]);
    }
    
    /**
     * Process playing with a creature
     * 
     * @return void
     */
    public function playWithCreature()
    {
        $userId = $_SESSION['user_id'];
        
        // Get request data
        $requestData = $this->getJsonInput();
        if (!$requestData) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request data'], 400);
            return;
        }
        
        $creatureId = isset($requestData['creature_id']) ? (int)$requestData['creature_id'] : null;
        
        if (!$creatureId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature ID is required'], 400);
            return;
        }
        
        // Get creature
        $creature = $this->creatureModel->findById($creatureId);
        
        if (!$creature || $creature['user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature not found'], 404);
            return;
        }
        
        if ($creature['stage'] === 'egg') {
            $this->jsonResponse(['success' => false, 'message' => 'You can\'t play with an egg'], 400);
            return;
        }
        
        // Play with the creature
        $success = $this->creatureModel->play($creatureId);
        
        if (!$success) {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to play with creature'], 500);
            return;
        }
        
        // Get updated creature
        $updatedCreature = $this->creatureModel->findById($creatureId);
        
        $this->jsonResponse([
            'success' => true,
            'message' => 'Played with creature successfully!',
            'creature' => $updatedCreature
        ]);
    }
    
    /**
     * Process moving a creature to a habitat
     * 
     * @return void
     */
    public function moveToHabitat()
    {
        $userId = $_SESSION['user_id'];
        
        // Get request data
        $requestData = $this->getJsonInput();
        if (!$requestData) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request data'], 400);
            return;
        }
        
        $creatureId = isset($requestData['creature_id']) ? (int)$requestData['creature_id'] : null;
        $habitatId = isset($requestData['habitat_id']) ? (int)$requestData['habitat_id'] : null;
        
        if (!$creatureId || !$habitatId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature ID and Habitat ID are required'], 400);
            return;
        }
        
        // Get creature
        $creature = $this->creatureModel->findById($creatureId);
        
        if (!$creature || $creature['user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature not found'], 404);
            return;
        }
        
        // Get habitat
        $habitat = $this->habitatModel->findById($habitatId);
        
        if (!$habitat || $habitat['user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Habitat not found'], 404);
            return;
        }
        
        // Move the creature
        $success = $this->creatureModel->moveToHabitat($creatureId, $habitatId);
        
        if (!$success) {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to move creature to habitat'], 500);
            return;
        }
        
        // Get updated creature
        $updatedCreature = $this->creatureModel->findById($creatureId);
        
        $this->jsonResponse([
            'success' => true,
            'message' => 'Creature moved to habitat successfully!',
            'creature' => $updatedCreature
        ]);
    }
    
    /**
     * Process renaming a creature
     * 
     * @return void
     */
    public function renameCreature()
    {
        $userId = $_SESSION['user_id'];
        
        // Get request data
        $requestData = $this->getJsonInput();
        if (!$requestData) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request data'], 400);
            return;
        }
        
        $creatureId = isset($requestData['creature_id']) ? (int)$requestData['creature_id'] : null;
        $name = isset($requestData['name']) ? trim($requestData['name']) : null;
        
        if (!$creatureId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature ID is required'], 400);
            return;
        }
        
        // Validate name
        if (!$name || strlen($name) < 2 || strlen($name) > 50) {
            $this->jsonResponse(['success' => false, 'message' => 'Name must be between 2 and 50 characters'], 400);
            return;
        }
        
        // Get creature
        $creature = $this->creatureModel->findById($creatureId);
        
        if (!$creature || $creature['user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Creature not found'], 404);
            return;
        }
        
        // Update the creature
        $updateData = [
            'name' => $name
        ];
        
        $success = $this->creatureModel->update($creatureId, $updateData);
        
        if (!$success) {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to rename creature'], 500);
            return;
        }
        
        // Get updated creature
        $updatedCreature = $this->creatureModel->findById($creatureId);
        
        $this->jsonResponse([
            'success' => true,
            'message' => 'Creature renamed successfully!',
            'creature' => $updatedCreature
        ]);
    }
    
    /**
     * Display the form to hatch an egg
     * 
     * @param array $params Parameters from URL
     * @return void
     */
    public function hatch($params)
    {
        $userId = $_SESSION['user_id'];
        $creatureId = isset($params['id']) ? (int)$params['id'] : null;
        
        if (!$creatureId) {
            $this->setFlashMessage('Invalid creature ID', 'danger');
            $this->redirect('/creatures');
            return;
        }
        
        // Get creature details
        $creature = $this->creatureModel->findById($creatureId);
        
        if (!$creature || $creature['user_id'] != $userId) {
            $this->setFlashMessage('Creature not found', 'danger');
            $this->redirect('/creatures');
            return;
        }
        
        if ($creature['stage'] !== 'egg') {
            $this->setFlashMessage('This creature is already hatched', 'warning');
            $this->redirect('/creatures/view/' . $creatureId);
            return;
        }
        
        if ($creature['growth_progress'] < 100) {
            $this->setFlashMessage('This egg is not ready to hatch yet. It needs more focus time.', 'warning');
            $this->redirect('/creatures/view/' . $creatureId);
            return;
        }
        
        // Prepare view data
        $data = [
            'creature' => $creature,
            'baseUrl' => '/Wildlife'
        ];
        
        $this->render('creatures/hatch', $data);
    }
}