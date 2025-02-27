<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-green-50 to-white pb-12">
    <!-- Conservation Hero Banner -->
    <div class="relative overflow-hidden bg-green-700 text-white">
        <div class="absolute opacity-20 right-0 top-0 w-full h-full">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <defs>
                    <pattern id="leaf-pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M20 0C20 0 10 10 0 20C0 30 10 40 20 40C30 40 40 30 40 20C30 10 20 0 20 0Z" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#leaf-pattern)" />
            </svg>
        </div>
        <div class="container mx-auto px-4 py-12 relative z-10">
            <div class="flex flex-col items-center text-center max-w-3xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold mb-3">Make a Real-World Impact</h1>
                <p class="text-green-100 text-lg mb-6">Your virtual focus powers actual conservation efforts. Every purchase here directly supports our partner organizations in protecting wildlife and habitats around the world.</p>
                <div class="flex items-center bg-white bg-opacity-20 rounded-full px-4 py-2">
                    <i class="fas fa-coins text-yellow-300 mr-2"></i>
                    <span class="font-bold"><?= number_format($userCoins) ?></span>
                    <span class="ml-1">WildCoins</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 -mt-6">
        <!-- Impact Statistics -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Trees Planted -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center">
                        <div class="w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tree text-green-600 text-2xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-green-800 mb-1"><?= number_format($globalStats['trees_planted'] ?? 0) ?></div>
                        <div class="text-green-700">Trees Planted</div>
                        <div class="mt-4 text-sm text-green-600 font-medium">
                            Your contribution: <?= number_format($userStats['trees_planted'] ?? 0) ?>
                        </div>
                    </div>
                    
                    <!-- Habitat Protected -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center">
                        <div class="w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-mountain text-blue-600 text-2xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-blue-800 mb-1"><?= number_format($globalStats['habitat_protected'] ?? 0) ?></div>
                        <div class="text-blue-700">Acres Protected</div>
                        <div class="mt-4 text-sm text-blue-600 font-medium">
                            Your contribution: <?= number_format($userStats['habitat_protected'] ?? 0) ?>
                        </div>
                    </div>
                    
                    <!-- Animals Supported -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 text-center">
                        <div class="w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-paw text-amber-600 text-2xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-amber-800 mb-1"><?= number_format($globalStats['animals_supported'] ?? 0) ?></div>
                        <div class="text-amber-700">Animals Supported</div>
                        <div class="mt-4 text-sm text-amber-600 font-medium">
                            Your contribution: <?= number_format($userStats['animals_supported'] ?? 0) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Community Goal -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="bg-green-700 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Current Community Goal</h2>
            </div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="mb-6 md:mb-0 md:mr-8 flex-shrink-0">
                        <img src="<?= $baseUrl ?>/images/conservation/rainforest-project.jpg" alt="Rainforest Restoration" class="w-48 h-48 object-cover rounded-lg shadow-md">
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Rainforest Restoration Initiative</h3>
                        <p class="text-gray-600 mb-4">Help us reach our goal of planting 10,000 trees in threatened rainforest regions. We're partnering with local communities to restore biodiversity hotspots and create sustainable ecosystems.</p>
                        
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">Progress: <?= number_format($globalStats['current_goal_progress'] ?? 0) ?>/10,000</span>
                                <span class="text-green-600"><?= round(($globalStats['current_goal_progress'] ?? 0) / 100) ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-600 h-2.5 rounded-full" style="width: <?= ($globalStats['current_goal_progress'] ?? 0) / 100 ?>%"></div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <h4 class="font-medium text-green-800 mb-2">Community Reward</h4>
                            <p class="text-green-700">When we reach our goal, all participants will receive a special <span class="font-bold">Rainforest Guardian Egg</span> containing a mythical creature inspired by rainforest wildlife.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Conservation Packages -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="bg-green-700 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Conservation Packages</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tree Planting Package -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-4 bg-gradient-to-r from-green-600 to-green-700 text-white">
                            <h3 class="font-bold text-lg">Tree Planting Package</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start mb-4">
                                <img src="<?= $baseUrl ?>/images/conservation/tree-planting.jpg" alt="Tree Planting" class="w-20 h-20 object-cover rounded-lg mr-4">
                                <div>
                                    <p class="text-gray-600 mb-3">Plant trees in critical forest ecosystems to combat deforestation and climate change while providing habitat for endangered species.</p>
                                    <div class="flex flex-col sm:flex-row sm:items-center">
                                        <div class="mb-2 sm:mb-0 sm:mr-4">
                                            <select class="border border-gray-300 rounded-md text-sm p-1.5 focus:border-green-500 focus:ring-green-500">
                                                <option value="1">1 Tree (100 coins)</option>
                                                <option value="5">5 Trees (450 coins)</option>
                                                <option value="10">10 Trees (800 coins)</option>
                                                <option value="20">20 Trees (1,500 coins)</option>
                                            </select>
                                        </div>
                                        <button class="bg-green-600 hover:bg-green-700 text-white font-medium py-1.5 px-4 rounded-lg text-sm transition-colors">
                                            Purchase
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg">
                                <h4 class="text-sm font-medium text-green-800 mb-1">In-Game Rewards</h4>
                                <ul class="text-sm text-green-700 space-y-1">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5 mr-1.5"></i>
                                        <span>Exclusive "Forest Guardian" badge for your profile</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5 mr-1.5"></i>
                                        <span>Special tree decorations for your habitats</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5 mr-1.5"></i>
                                        <span>+5% Happiness boost for Forest habitat creatures</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-globe-americas mr-1.5"></i>
                                <span>Partner: One Tree Planted</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Wildlife Protection Package -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-4 bg-gradient-to-r from-amber-600 to-amber-700 text-white">
                            <h3 class="font-bold text-lg">Wildlife Protection Package</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start mb-4">
                                <img src="<?= $baseUrl ?>/images/conservation/wildlife-protection.jpg" alt="Wildlife Protection" class="w-20 h-20 object-cover rounded-lg mr-4">
                                <div>
                                    <p class="text-gray-600 mb-3">Support conservation programs that protect endangered species through habitat preservation, anti-poaching efforts, and community education.</p>
                                    <div class="flex flex-col sm:flex-row sm:items-center">
                                        <div class="mb-2 sm:mb-0 sm:mr-4">
                                            <select class="border border-gray-300 rounded-md text-sm p-1.5 focus:border-amber-500 focus:ring-amber-500">
                                                <option value="1">Small Impact (250 coins)</option>
                                                <option value="2">Medium Impact (600 coins)</option>
                                                <option value="3">Large Impact (1,200 coins)</option>
                                            </select>
                                        </div>
                                        <button class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-1.5 px-4 rounded-lg text-sm transition-colors">
                                            Purchase
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-amber-50 p-3 rounded-lg">
                                <h4 class="text-sm font-medium text-amber-800 mb-1">In-Game Rewards</h4>
                                <ul class="text-sm text-amber-700 space-y-1">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-amber-600 mt-0.5 mr-1.5"></i>
                                        <span>"Wildlife Protector" profile badge</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-amber-600 mt-0.5 mr-1.5"></i>
                                        <span>Rare accessories for your mythical creatures</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-amber-600 mt-0.5 mr-1.5"></i>
                                        <span>Chance to receive a special egg containing an endangered species-inspired creature</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-globe-americas mr-1.5"></i>
                                <span>Partner: World Wildlife Fund</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ocean Conservation Package -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                            <h3 class="font-bold text-lg">Ocean Conservation Package</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start mb-4">
                                <img src="<?= $baseUrl ?>/images/conservation/ocean-conservation.jpg" alt="Ocean Conservation" class="w-20 h-20 object-cover rounded-lg mr-4">
                                <div>
                                    <p class="text-gray-600 mb-3">Help clean oceans, protect coral reefs, and support marine wildlife through sustainable practices and pollution reduction initiatives.</p>
                                    <div class="flex flex-col sm:flex-row sm:items-center">
                                        <div class="mb-2 sm:mb-0 sm:mr-4">
                                            <select class="border border-gray-300 rounded-md text-sm p-1.5 focus:border-blue-500 focus:ring-blue-500">
                                                <option value="1">Small Impact (200 coins)</option>
                                                <option value="2">Medium Impact (500 coins)</option>
                                                <option value="3">Large Impact (1,000 coins)</option>
                                            </select>
                                        </div>
                                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1.5 px-4 rounded-lg text-sm transition-colors">
                                            Purchase
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <h4 class="text-sm font-medium text-blue-800 mb-1">In-Game Rewards</h4>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-600 mt-0.5 mr-1.5"></i>
                                        <span>"Ocean Guardian" profile badge</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-600 mt-0.5 mr-1.5"></i>
                                        <span>Special underwater decorations for Ocean habitats</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-600 mt-0.5 mr-1.5"></i>
                                        <span>+10% Growth speed for Ocean habitat creatures</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-globe-americas mr-1.5"></i>
                                <span>Partner: Ocean Conservancy</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Climate Action Package -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                            <h3 class="font-bold text-lg">Climate Action Package</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start mb-4">
                                <img src="<?= $baseUrl ?>/images/conservation/climate-action.jpg" alt="Climate Action" class="w-20 h-20 object-cover rounded-lg mr-4">
                                <div>
                                    <p class="text-gray-600 mb-3">Support initiatives that fight climate change through renewable energy, carbon offset programs, and sustainable development projects.</p>
                                    <div class="flex flex-col sm:flex-row sm:items-center">
                                        <div class="mb-2 sm:mb-0 sm:mr-4">
                                            <select class="border border-gray-300 rounded-md text-sm p-1.5 focus:border-purple-500 focus:ring-purple-500">
                                                <option value="1">Small Impact (300 coins)</option>
                                                <option value="2">Medium Impact (700 coins)</option>
                                                <option value="3">Large Impact (1,400 coins)</option>
                                            </select>
                                        </div>
                                        <button class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-1.5 px-4 rounded-lg text-sm transition-colors">
                                            Purchase
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-purple-50 p-3 rounded-lg">
                                <h4 class="text-sm font-medium text-purple-800 mb-1">In-Game Rewards</h4>
                                <ul class="text-sm text-purple-700 space-y-1">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-purple-600 mt-0.5 mr-1.5"></i>
                                        <span>"Climate Champion" profile badge</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-purple-600 mt-0.5 mr-1.5"></i>
                                        <span>Special environmental-themed decorations</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-purple-600 mt-0.5 mr-1.5"></i>
                                        <span>Access to exclusive Cosmic habitat expansion</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-globe-americas mr-1.5"></i>
                                <span>Partner: Climate Action Network</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Our Partners -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="bg-green-700 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Our Conservation Partners</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-center mb-8 max-w-3xl mx-auto">We've partnered with leading conservation organizations to ensure your contributions make a meaningful impact. Each purchase directly supports their important work.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php foreach ($partners as $partner): ?>
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="h-40 bg-gray-100 flex items-center justify-center p-4">
                            <img src="<?= $baseUrl . $partner['logo_url'] ?>" alt="<?= htmlspecialchars($partner['name']) ?>" class="max-h-full max-w-full object-contain">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 mb-2"><?= htmlspecialchars($partner['name']) ?></h3>
                            <p class="text-gray-600 text-sm mb-3"><?= htmlspecialchars($partner['description']) ?></p>
                            <a href="<?= htmlspecialchars($partner['website_url']) ?>" target="_blank" class="text-green-600 hover:text-green-700 text-sm font-medium flex items-center">
                                <span>Learn More</span>
                                <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Impact Transparency -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-green-700 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Impact Transparency</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-6">We're committed to transparency in our conservation efforts. Here's how your contributions are making a difference:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Impact Map -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="p-3 bg-gray-50 border-b border-gray-200">
                            <h3 class="font-medium text-gray-800">Global Impact Map</h3>
                        </div>
                        <div class="p-4 flex items-center justify-center h-64 bg-blue-50">
                            <img src="<?= $baseUrl ?>/images/conservation/impact-map.jpg" alt="Global Impact Map" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                    
                    <!-- Recent Activities -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="p-3 bg-gray-50 border-b border-gray-200">
                            <h3 class="font-medium text-gray-800">Recent Conservation Activities</h3>
                        </div>
                        <div class="p-4">
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <div class="bg-green-100 rounded-full p-1.5 text-green-600 mr-3 mt-0.5">
                                        <i class="fas fa-tree text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">1,000 trees planted in Amazon Rainforest</p>
                                        <p class="text-xs text-gray-500">2 weeks ago</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <div class="bg-blue-100 rounded-full p-1.5 text-blue-600 mr-3 mt-0.5">
                                        <i class="fas fa-water text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Coral reef restoration in Great Barrier Reef</p>
                                        <p class="text-xs text-gray-500">1 month ago</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <div class="bg-amber-100 rounded-full p-1.5 text-amber-600 mr-3 mt-0.5">
                                        <i class="fas fa-paw text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Tiger conservation program in Southeast Asia</p>
                                        <p class="text-xs text-gray-500">2 months ago</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <div class="bg-purple-100 rounded-full p-1.5 text-purple-600 mr-3 mt-0.5">
                                        <i class="fas fa-solar-panel text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Renewable energy project in rural communities</p>
                                        <p class="text-xs text-gray-500">3 months ago</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 text-center">
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-file-alt mr-2"></i>
                        View Complete Impact Report
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Purchase Confirmation Modal -->
<div id="purchase-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl max-w-md w-full overflow-hidden">
        <div class="bg-green-600 px-6 py-4 text-white relative">
            <h3 class="text-xl font-bold">Thank You!</h3>
            <button id="close-modal-btn" class="absolute top-4 right-4 text-white hover:text-green-100">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Purchase Successful</h4>
                <p class="text-gray-600" id="confirmation-message">You've contributed to planting 5 trees!</p>
            </div>
            
            <div class="bg-green-50 rounded-lg p-4 mb-6">
                <h5 class="font-medium text-green-800 mb-2">Your Impact</h5>
                <p class="text-green-700 text-sm mb-2">Your contribution will help restore forest habitats and support biodiversity conservation in critical ecosystems.</p>
                <div class="flex justify-between text-sm">
                    <span class="text-green-700">Trees Planted:</span>
                    <span class="font-medium text-green-800" id="impact-number">5</span>
                </div>
            </div>
            
            <div class="bg-yellow-50 rounded-lg p-4 mb-6">
                <h5 class="font-medium text-yellow-800 mb-2">Rewards Added</h5>
                <ul class="text-sm space-y-1" id="rewards-list">
                    <li class="flex items-start">
                        <i class="fas fa-star text-yellow-500 mt-0.5 mr-1.5"></i>
                        <span class="text-yellow-700">Forest Guardian badge added to your profile</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-star text-yellow-500 mt-0.5 mr-1.5"></i>
                        <span class="text-yellow-700">5 special tree decorations added to your inventory</span>
                    </li>
                </ul>
            </div>
            
            <div class="text-center">
                <button id="continue-btn" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Purchase button event listeners
    const purchaseButtons = document.querySelectorAll('.bg-green-600, .bg-amber-600, .bg-blue-600, .bg-purple-600');
    const purchaseModal = document.getElementById('purchase-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const continueBtn = document.getElementById('continue-btn');
    const confirmationMessage = document.getElementById('confirmation-message');
    const impactNumber = document.getElementById('impact-number');
    const rewardsList = document.getElementById('rewards-list');
    
    // Function to show purchase modal with appropriate content
    function showPurchaseModal(packageType, amount) {
        let message, impact, rewards;
        
        switch(packageType) {
            case 'tree':
                message = `You've contributed to planting ${amount} tree${amount > 1 ? 's' : ''}!`;
                impact = amount;
                rewards = [
                    'Forest Guardian badge added to your profile',
                    `${amount} special tree decoration${amount > 1 ? 's' : ''} added to your inventory`
                ];
                break;
                
            case 'wildlife':
                message = `You've supported wildlife protection initiatives!`;
                impact = amount;
                rewards = [
                    'Wildlife Protector badge added to your profile',
                    'Rare creature accessories added to your inventory'
                ];
                break;
                
            case 'ocean':
                message = `You've contributed to ocean conservation efforts!`;
                impact = amount;
                rewards = [
                    'Ocean Guardian badge added to your profile',
                    'Special underwater decorations added to your inventory'
                ];
                break;
                
            case 'climate':
                message = `You've supported climate action initiatives!`;
                impact = amount;
                rewards = [
                    'Climate Champion badge added to your profile',
                    'Environmental-themed decorations added to your inventory'
                ];
                break;
        }
        
        // Update modal content
        confirmationMessage.textContent = message;
        impactNumber.textContent = impact;
        
        // Update rewards list
        rewardsList.innerHTML = '';
        rewards.forEach(reward => {
            const li = document.createElement('li');
            li.className = 'flex items-start';
            li.innerHTML = `
                <i class="fas fa-star text-yellow-500 mt-0.5 mr-1.5"></i>
                <span class="text-yellow-700">${reward}</span>
            `;
            rewardsList.appendChild(li);
        });
        
        // Show modal
        purchaseModal.classList.remove('hidden');
    }
    
    // Add click event listeners to purchase buttons
    purchaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            // In a real implementation, you would send an AJAX request to make the purchase
            // For this demo, we'll just show the modal
            
            // Determine package type and amount from button context
            const container = this.closest('.border.border-gray-200');
            let packageType, amount;
            
            if (container.querySelector('.from-green-600')) {
                packageType = 'tree';
                const select = container.querySelector('select');
                amount = parseInt(select.value);
            } else if (container.querySelector('.from-amber-600')) {
                packageType = 'wildlife';
                const select = container.querySelector('select');
                amount = parseInt(select.value);
            } else if (container.querySelector('.from-blue-600')) {
                packageType = 'ocean';
                const select = container.querySelector('select');
                amount = parseInt(select.value);
            } else if (container.querySelector('.from-purple-600')) {
                packageType = 'climate';
                const select = container.querySelector('select');
                amount = parseInt(select.value);
            } else {
                packageType = 'tree';
                amount = 1;
            }
            
            showPurchaseModal(packageType, amount);
        });
    });
    
    // Close modal when clicking the close button
    closeModalBtn.addEventListener('click', function() {
        purchaseModal.classList.add('hidden');
    });
    
    // Close modal when clicking the continue button
    continueBtn.addEventListener('click', function() {
        purchaseModal.classList.add('hidden');
    });
    
    // Close modal when clicking outside the content
    purchaseModal.addEventListener('click', function(e) {
        if (e.target === purchaseModal) {
            purchaseModal.classList.add('hidden');
        }
    });
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>