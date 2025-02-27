<?php
// Path: app/Http/Controllers/ShopController.php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\Item;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Creature;
use App\Models\Habitat;
use App\Models\ConservationPartner;

/**
 * Shop Controller
 * 
 * Handles the marketplace functionality for Wildlife Haven
 */
class ShopController extends Controller
{
    /**
     * @var Item $itemModel
     */
    private $itemModel;
    
    /**
     * @var User $userModel
     */
    private $userModel;
    
    /**
     * @var Transaction $transactionModel
     */
    private $transactionModel;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Database connection
     */
    public function __construct($db)
    {
        parent::__construct($db);
        $this->itemModel = new Item($db);
        $this->userModel = new User($db);
        $this->transactionModel = new Transaction($db);
    }
    
    /**
     * Display the shop index page
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function index($params = [])
    {
        // Require authentication to access the shop
        $this->requireAuth();
        
        $userId = $_SESSION['user_id'];
        
        // Get user's coin balance
        $user = $this->userModel->findById($userId);
        $userCoins = $user['coins_balance'] ?? 0;
        
        // Get all items
        $items = $this->itemModel->getAll();
        
        // Get user's creatures for item compatibility
        $creatureModel = new Creature($this->db);
        $userCreatures = $creatureModel->findByUserId($userId);
        
        // Get user's habitats for item compatibility
        $habitatModel = new Habitat($this->db);
        $userHabitats = $habitatModel->findByUserId($userId);
        
        // Get featured items
        $featuredItems = $this->itemModel->getFeatured();
        
        // Get daily deals
        $dailyDeals = $this->itemModel->getDailyDeals();
        
        // Get user's recently viewed items
        $recentlyViewed = $this->itemModel->getRecentlyViewed($userId);
        
        // Get conservation partners and statistics
        $conservationModel = new ConservationPartner($this->db);
        $conservationPartners = $conservationModel->getAll();
        $conservationStats = $conservationModel->getGlobalStats();
        
        // Organize items by category
        $organizedItems = [
            'creatures' => array_filter($items, function($item) {
                return $item['type'] === 'creature_accessory';
            }),
            'habitats' => array_filter($items, function($item) {
                return $item['type'] === 'habitat_decoration';
            }),
            'eggs' => array_filter($items, function($item) {
                return $item['type'] === 'egg';
            }),
            'conservation' => array_filter($items, function($item) {
                return $item['type'] === 'conservation_package';
            }),
            'limited' => array_filter($items, function($item) {
                return $item['is_limited_edition'] === 1;
            }),
        ];
        
        // Render the shop view
        $this->render('shop/index', [
            'userCoins' => $userCoins,
            'items' => $items,
            'userCreatures' => $userCreatures,
            'userHabitats' => $userHabitats,
            'featuredItems' => $featuredItems,
            'dailyDeals' => $dailyDeals,
            'recentlyViewed' => $recentlyViewed,
            'conservationPartners' => $conservationPartners,
            'conservationStats' => $conservationStats,
            'organizedItems' => $organizedItems,
            'baseUrl' => '/Wildlife' // Base URL for assets
        ]);
    }
    
    /**
     * Display a specific item's details
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function view($params = [])
    {
        // Require authentication to access item details
        $this->requireAuth();
        
        $itemId = $params['id'] ?? 0;
        $userId = $_SESSION['user_id'];
        
        // Get item details
        $item = $this->itemModel->findById($itemId);
        
        if (!$item) {
            $this->setFlashMessage('Item not found', 'danger');
            $this->redirect('/shop');
            return;
        }
        
        // Record that user viewed this item
        $this->itemModel->recordItemView($userId, $itemId);
        
        // Get user's coin balance
        $user = $this->userModel->findById($userId);
        $userCoins = $user['coins_balance'] ?? 0;
        
        // Get compatible creatures or habitats based on item type
        $compatibleWith = [];
        
        if ($item['type'] === 'creature_accessory') {
            $creatureModel = new Creature($this->db);
            $compatibleWith = $creatureModel->findByUserId($userId);
        } elseif ($item['type'] === 'habitat_decoration') {
            $habitatModel = new Habitat($this->db);
            $compatibleWith = $habitatModel->findByUserId($userId);
        }
        
        // Render the item detail view
        $this->render('shop/view', [
            'item' => $item,
            'userCoins' => $userCoins,
            'compatibleWith' => $compatibleWith,
            'baseUrl' => '/Wildlife' // Base URL for assets
        ]);
    }
    
    /**
     * Purchase an item
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function purchase($params = [])
    {
        // Require authentication to purchase items
        $this->requireAuth();
        
        // Handle AJAX request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputData = $this->getJsonInput();
            
            $itemId = $inputData['item_id'] ?? 0;
            $quantity = $inputData['quantity'] ?? 1;
            $userId = $_SESSION['user_id'];
            
            // Validate quantity
            if ($quantity < 1) {
                $this->jsonResponse(['success' => false, 'message' => 'Invalid quantity'], 400);
                return;
            }
            
            // Get item details
            $item = $this->itemModel->findById($itemId);
            
            if (!$item) {
                $this->jsonResponse(['success' => false, 'message' => 'Item not found'], 404);
                return;
            }
            
            // Get user's coin balance
            $user = $this->userModel->findById($userId);
            $userCoins = $user['coins_balance'] ?? 0;
            
            // Calculate total cost
            $totalCost = $item['price'] * $quantity;
            
            // Check if user has enough coins
            if ($userCoins < $totalCost) {
                $this->jsonResponse(['success' => false, 'message' => 'Not enough coins'], 400);
                return;
            }
            
            // Start a transaction
            $this->db->beginTransaction();
            
            try {
                // Deduct coins from user's balance
                $this->userModel->updateCoins($userId, -$totalCost);
                
                // Process based on item type
                switch ($item['type']) {
                    case 'creature_accessory':
                    case 'habitat_decoration':
                        // Add item to user's inventory
                        $this->itemModel->addToUserInventory($userId, $itemId, $quantity);
                        break;
                        
                    case 'egg':
                        // Create new egg for the user
                        $creatureModel = new Creature($this->db);
                        for ($i = 0; $i < $quantity; $i++) {
                            // Parse the species ID from the item data
                            $speciesId = $item['metadata']['species_id'] ?? 1;
                            
                            $creatureData = [
                                'user_id' => $userId,
                                'species_id' => $speciesId,
                                'name' => null,
                                'stage' => 'egg',
                                'health' => 100,
                                'happiness' => 100,
                                'growth_progress' => 0,
                                'habitat_id' => null
                            ];
                            
                            $creatureModel->create($creatureData);
                        }
                        break;
                        
                    case 'conservation_package':
                        // Record conservation impact
                        $conservationModel = new ConservationPartner($this->db);
                        $partnerId = $item['metadata']['partner_id'] ?? 1;
                        $impactType = $item['metadata']['impact_type'] ?? 'tree_planted';
                        $impactAmount = $item['metadata']['impact_amount'] ?? 1;
                        
                        $conservationModel->recordConservationImpact(
                            $userId,
                            $partnerId,
                            $impactType,
                            $impactAmount * $quantity,
                            'purchase'
                        );
                        break;
                }
                
                // Record the transaction
                $this->transactionModel->create([
                    'user_id' => $userId,
                    'type' => 'purchase',
                    'amount' => $totalCost,
                    'currency' => 'coins',
                    'description' => "Purchased {$quantity}x {$item['name']}",
                    'reference_id' => $itemId
                ]);
                
                // Commit the transaction
                $this->db->commit();
                
                // Return success response
                $this->jsonResponse([
                    'success' => true, 
                    'message' => "Successfully purchased {$quantity}x {$item['name']}",
                    'new_balance' => $userCoins - $totalCost
                ]);
                
            } catch (\Exception $e) {
                // Rollback the transaction on error
                $this->db->rollback();
                $this->jsonResponse(['success' => false, 'message' => 'An error occurred during purchase'], 500);
            }
        } else {
            // Redirect if not a POST request
            $this->redirect('/shop');
        }
    }
    
    /**
     * Add an item to the wishlist
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function addToWishlist($params = [])
    {
        // Require authentication
        $this->requireAuth();
        
        // Handle AJAX request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputData = $this->getJsonInput();
            
            $itemId = $inputData['item_id'] ?? 0;
            $userId = $_SESSION['user_id'];
            
            // Check if item exists
            $item = $this->itemModel->findById($itemId);
            
            if (!$item) {
                $this->jsonResponse(['success' => false, 'message' => 'Item not found'], 404);
                return;
            }
            
            // Add to wishlist
            $result = $this->itemModel->addToWishlist($userId, $itemId);
            
            if ($result) {
                $this->jsonResponse(['success' => true, 'message' => 'Added to wishlist']);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to add to wishlist'], 500);
            }
        } else {
            // Redirect if not a POST request
            $this->redirect('/shop');
        }
    }
    
    /**
     * Remove an item from the wishlist
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function removeFromWishlist($params = [])
    {
        // Require authentication
        $this->requireAuth();
        
        // Handle AJAX request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputData = $this->getJsonInput();
            
            $itemId = $inputData['item_id'] ?? 0;
            $userId = $_SESSION['user_id'];
            
            // Remove from wishlist
            $result = $this->itemModel->removeFromWishlist($userId, $itemId);
            
            if ($result) {
                $this->jsonResponse(['success' => true, 'message' => 'Removed from wishlist']);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to remove from wishlist'], 500);
            }
        } else {
            // Redirect if not a POST request
            $this->redirect('/shop');
        }
    }
    
    /**
     * Display user's wishlist
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function wishlist($params = [])
    {
        // Require authentication
        $this->requireAuth();
        
        $userId = $_SESSION['user_id'];
        
        // Get user's coin balance
        $user = $this->userModel->findById($userId);
        $userCoins = $user['coins_balance'] ?? 0;
        
        // Get wishlist items
        $wishlistItems = $this->itemModel->getWishlist($userId);
        
        // Render the wishlist view
        $this->render('shop/wishlist', [
            'userCoins' => $userCoins,
            'wishlistItems' => $wishlistItems,
            'baseUrl' => '/Wildlife' // Base URL for assets
        ]);
    }
    
    /**
     * Display the purchase history
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function history($params = [])
    {
        // Require authentication
        $this->requireAuth();
        
        $userId = $_SESSION['user_id'];
        
        // Get purchase history
        $transactions = $this->transactionModel->getUserPurchases($userId);
        
        // Render the history view
        $this->render('shop/history', [
            'transactions' => $transactions,
            'baseUrl' => '/Wildlife' // Base URL for assets
        ]);
    }
    
    /**
     * Handle purchase of premium currency (coins)
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function getCurrency($params = [])
    {
        // Require authentication
        $this->requireAuth();
        
        $userId = $_SESSION['user_id'];
        
        // Get available coin packages
        $coinPackages = [
            [
                'id' => 'coins_500',
                'name' => 'Small Pouch',
                'amount' => 500,
                'price' => 4.99,
                'bonus' => 0
            ],
            [
                'id' => 'coins_1000',
                'name' => 'Medium Bag',
                'amount' => 1000,
                'price' => 9.99,
                'bonus' => 50
            ],
            [
                'id' => 'coins_2500',
                'name' => 'Large Chest',
                'amount' => 2500,
                'price' => 19.99,
                'bonus' => 250
            ],
            [
                'id' => 'coins_5000',
                'name' => 'Giant Vault',
                'amount' => 5000,
                'price' => 39.99,
                'bonus' => 750
            ]
        ];
        
        // Handle POST request for purchase
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputData = $this->getJsonInput();
            
            $packageId = $inputData['package_id'] ?? '';
            
            // Find the selected package
            $selectedPackage = null;
            foreach ($coinPackages as $package) {
                if ($package['id'] === $packageId) {
                    $selectedPackage = $package;
                    break;
                }
            }
            
            if (!$selectedPackage) {
                $this->jsonResponse(['success' => false, 'message' => 'Invalid package'], 400);
                return;
            }
            
            // In a real implementation, this would connect to a payment processor
            // For now, we'll simulate a successful purchase
            
            // Add coins to user's balance
            $totalCoins = $selectedPackage['amount'] + $selectedPackage['bonus'];
            $this->userModel->updateCoins($userId, $totalCoins);
            
            // Record the transaction
            $this->transactionModel->create([
                'user_id' => $userId,
                'type' => 'purchase',
                'amount' => $selectedPackage['price'],
                'currency' => 'real_money',
                'description' => "Purchased {$selectedPackage['name']} coin package ({$totalCoins} coins)",
                'reference_id' => $packageId
            ]);
            
            $this->jsonResponse([
                'success' => true, 
                'message' => "Successfully purchased {$totalCoins} coins",
                'new_balance' => ($user['coins_balance'] ?? 0) + $totalCoins
            ]);
            
            return;
        }
        
        // Render the get currency view
        $this->render('shop/get_currency', [
            'coinPackages' => $coinPackages,
            'baseUrl' => '/Wildlife' // Base URL for assets
        ]);
    }
    
    /**
     * Display the conservation impact shop
     * 
     * @param array $params Route parameters
     * @return void
     */
    public function conservation($params = [])
    {
        // Require authentication
        $this->requireAuth();
        
        $userId = $_SESSION['user_id'];
        
        // Get user's coin balance
        $user = $this->userModel->findById($userId);
        $userCoins = $user['coins_balance'] ?? 0;
        
        // Get conservation packages
        $conservationPackages = $this->itemModel->getByType('conservation_package');
        
        // Get conservation partners
        $conservationModel = new ConservationPartner($this->db);
        $partners = $conservationModel->getAll();
        
        // Get global and user conservation stats
        $globalStats = $conservationModel->getGlobalStats();
        $userStats = $conservationModel->getUserStats($userId);
        
        // Render the conservation shop view
        $this->render('shop/conservation', [
            'userCoins' => $userCoins,
            'conservationPackages' => $conservationPackages,
            'partners' => $partners,
            'globalStats' => $globalStats,
            'userStats' => $userStats,
            'baseUrl' => '/Wildlife' // Base URL for assets
        ]);
    }
}