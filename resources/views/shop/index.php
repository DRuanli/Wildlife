<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-purple-50 to-white pb-12">
    <!-- Shop Hero Banner -->
    <div class="relative overflow-hidden bg-purple-600 text-white">
        <div class="absolute opacity-20 right-0 top-0 w-full h-full">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <defs>
                    <pattern id="pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40L40 0" stroke="currentColor" stroke-width="1" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#pattern)" />
            </svg>
        </div>
        <div class="container mx-auto px-4 py-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Wildlife Haven Shop</h1>
                    <p class="text-purple-100 text-lg">Customize your creatures and habitats with magical items</p>
                </div>
                <div class="flex items-center bg-white bg-opacity-20 rounded-full px-4 py-2">
                    <i class="fas fa-coins text-yellow-300 mr-2"></i>
                    <span class="font-bold"><?= number_format($userCoins) ?></span>
                    <span class="ml-1">WildCoins</span>
                    <a href="#" class="ml-3 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-3 py-1 rounded-full transition-colors">
                        <i class="fas fa-plus text-xs mr-1"></i> Get More
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Deals Banner -->
    <div class="container mx-auto px-4 -mt-6">
        <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="bg-white rounded-full p-3 mr-4">
                            <i class="fas fa-bolt text-amber-500 text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-white font-bold text-2xl">Daily Deals</h2>
                            <p class="text-amber-100">Special offers refreshing in <span id="countdown-timer" class="font-bold">23:45:19</span></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <!-- Daily Deal Item 1 -->
                        <div class="bg-white bg-opacity-10 rounded-lg p-3 flex items-center group hover:bg-opacity-20 transition-all cursor-pointer">
                            <div class="w-12 h-12 bg-white rounded-md flex items-center justify-center mr-3">
                                <img src="<?= $baseUrl ?>/images/shop/crystal-egg.png" alt="Crystal Egg" class="w-10 h-10 object-contain">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-medium text-sm">Crystal Egg</h3>
                                <div class="flex items-center">
                                    <span class="text-gray-200 text-xs line-through mr-2">500</span>
                                    <span class="text-white font-bold">350</span>
                                    <i class="fas fa-coins text-yellow-300 text-xs ml-1"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Daily Deal Item 2 -->
                        <div class="bg-white bg-opacity-10 rounded-lg p-3 flex items-center group hover:bg-opacity-20 transition-all cursor-pointer">
                            <div class="w-12 h-12 bg-white rounded-md flex items-center justify-center mr-3">
                                <img src="<?= $baseUrl ?>/images/shop/golden-fountain.png" alt="Golden Fountain" class="w-10 h-10 object-contain">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-medium text-sm">Golden Fountain</h3>
                                <div class="flex items-center">
                                    <span class="text-gray-200 text-xs line-through mr-2">1200</span>
                                    <span class="text-white font-bold">800</span>
                                    <i class="fas fa-coins text-yellow-300 text-xs ml-1"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Daily Deal Item 3 (hidden on smallest screens) -->
                        <div class="hidden sm:flex bg-white bg-opacity-10 rounded-lg p-3 items-center group hover:bg-opacity-20 transition-all cursor-pointer">
                            <div class="w-12 h-12 bg-white rounded-md flex items-center justify-center mr-3">
                                <img src="<?= $baseUrl ?>/images/shop/sapphire-collar.png" alt="Sapphire Collar" class="w-10 h-10 object-contain">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-medium text-sm">Sapphire Collar</h3>
                                <div class="flex items-center">
                                    <span class="text-gray-200 text-xs line-through mr-2">750</span>
                                    <span class="text-white font-bold">550</span>
                                    <i class="fas fa-coins text-yellow-300 text-xs ml-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Shop Categories Tabs -->
        <div class="mb-8" x-data="{ activeTab: 'all' }">
            <div class="flex flex-wrap border-b border-gray-200 mb-6">
                <button @click="activeTab = 'all'" :class="{ 'border-purple-500 text-purple-600': activeTab === 'all', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'all' }" class="px-4 py-2 font-medium text-sm border-b-2 -mb-px">
                    All Items
                </button>
                <button @click="activeTab = 'creatures'" :class="{ 'border-purple-500 text-purple-600': activeTab === 'creatures', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'creatures' }" class="px-4 py-2 font-medium text-sm border-b-2 -mb-px">
                    <i class="fas fa-dragon mr-1"></i> Creature Items
                </button>
                <button @click="activeTab = 'habitats'" :class="{ 'border-purple-500 text-purple-600': activeTab === 'habitats', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'habitats' }" class="px-4 py-2 font-medium text-sm border-b-2 -mb-px">
                    <i class="fas fa-tree mr-1"></i> Habitat Decorations
                </button>
                <button @click="activeTab = 'eggs'" :class="{ 'border-purple-500 text-purple-600': activeTab === 'eggs', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'eggs' }" class="px-4 py-2 font-medium text-sm border-b-2 -mb-px">
                    <i class="fas fa-egg mr-1"></i> Special Eggs
                </button>
                <button @click="activeTab = 'conservation'" :class="{ 'border-purple-500 text-purple-600': activeTab === 'conservation', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'conservation' }" class="px-4 py-2 font-medium text-sm border-b-2 -mb-px">
                    <i class="fas fa-leaf mr-1"></i> Conservation
                </button>
                <button @click="activeTab = 'limited'" :class="{ 'border-purple-500 text-purple-600': activeTab === 'limited', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'limited' }" class="px-4 py-2 font-medium text-sm border-b-2 -mb-px">
                    <i class="fas fa-star mr-1"></i> Limited Edition
                </button>
            </div>
            
            <!-- Search and Filters -->
            <div class="flex flex-col md:flex-row justify-between mb-6">
                <div class="mb-3 md:mb-0 relative">
                    <input type="text" placeholder="Search items..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <select class="border border-gray-300 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500 p-2">
                        <option value="">Sort by</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                        <option value="newest">Newest First</option>
                        <option value="popularity">Most Popular</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500 p-2">
                        <option value="">Filter by Rarity</option>
                        <option value="common">Common</option>
                        <option value="uncommon">Uncommon</option>
                        <option value="rare">Rare</option>
                        <option value="legendary">Legendary</option>
                        <option value="mythical">Mythical</option>
                    </select>
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg p-2 text-sm flex items-center transition-colors">
                        <i class="fas fa-filter mr-1"></i> More Filters
                    </button>
                </div>
            </div>
            
            <!-- All Items Tab Panel -->
            <div x-show="activeTab === 'all'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <!-- Featured Item (Full Width on Small, 2 Columns on Large) -->
                <div class="col-span-2 lg:col-span-2 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-md overflow-hidden text-white relative group">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 font-bold uppercase text-xs px-2 py-1 rounded-full z-10">
                        Featured
                    </div>
                    <div class="p-6 flex flex-col h-full relative z-0">
                        <h3 class="text-xl font-bold mb-1">Mythical Habitat Expansion</h3>
                        <p class="text-purple-100 text-sm mb-4">Double your habitat size and unlock special decoration slots</p>
                        <div class="mt-auto flex justify-between items-end">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold mr-1">1,500</span>
                                <i class="fas fa-coins text-yellow-300"></i>
                            </div>
                            <button class="bg-white text-purple-700 font-medium px-4 py-2 rounded-lg hover:bg-purple-50 transition-colors">
                                Buy Now
                            </button>
                        </div>
                    </div>
                    <img src="<?= $baseUrl ?>/images/shop/mythical-expansion.png" alt="Mythical Habitat Expansion" class="absolute -right-8 bottom-0 h-32 transform transition-transform group-hover:scale-110 group-hover:translate-x-2">
                </div>
                
                <!-- Regular Item 1 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                    <div class="relative">
                        <img src="<?= $baseUrl ?>/images/shop/magic-crystal.png" alt="Magic Crystal" class="w-full h-48 object-contain p-4 bg-purple-50">
                        <div class="absolute top-2 right-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                            Rare
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-gray-800 mb-1">Magic Crystal</h3>
                        <p class="text-sm text-gray-500 mb-3">Accelerates creature growth when placed in a habitat</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <span class="font-bold text-gray-800 mr-1">450</span>
                                <i class="fas fa-coins text-yellow-500 text-sm"></i>
                            </div>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-3 py-1.5 rounded-lg transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Regular Item 2 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                    <div class="relative">
                        <img src="<?= $baseUrl ?>/images/shop/golden-crown.png" alt="Golden Crown" class="w-full h-48 object-contain p-4 bg-yellow-50">
                        <div class="absolute top-2 right-2 bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full">
                            Legendary
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-gray-800 mb-1">Golden Crown</h3>
                        <p class="text-sm text-gray-500 mb-3">Royal accessory for your mythical creatures</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <span class="font-bold text-gray-800 mr-1">750</span>
                                <i class="fas fa-coins text-yellow-500 text-sm"></i>
                            </div>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-3 py-1.5 rounded-lg transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Regular Item 3 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                    <div class="relative">
                        <img src="<?= $baseUrl ?>/images/shop/enchanted-fountain.png" alt="Enchanted Fountain" class="w-full h-48 object-contain p-4 bg-blue-50">
                        <div class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                            Uncommon
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-gray-800 mb-1">Enchanted Fountain</h3>
                        <p class="text-sm text-gray-500 mb-3">Boosts happiness for all creatures in a habitat</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <span class="font-bold text-gray-800 mr-1">325</span>
                                <i class="fas fa-coins text-yellow-500 text-sm"></i>
                            </div>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-3 py-1.5 rounded-lg transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Regular Item 4 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                    <div class="relative">
                        <img src="<?= $baseUrl ?>/images/shop/emerald-egg.png" alt="Emerald Egg" class="w-full h-48 object-contain p-4 bg-green-50">
                        <div class="absolute top-2 right-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                            Rare
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-gray-800 mb-1">Emerald Egg</h3>
                        <p class="text-sm text-gray-500 mb-3">Contains a rare forest creature</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <span class="font-bold text-gray-800 mr-1">500</span>
                                <i class="fas fa-coins text-yellow-500 text-sm"></i>
                            </div>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-3 py-1.5 rounded-lg transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- More items would go here... -->
            </div>
            
            <!-- Creature Items Tab Panel -->
            <div x-show="activeTab === 'creatures'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <!-- Creature items content would go here -->
                <div class="text-center py-8 text-gray-500">Loading creature items...</div>
            </div>
            
            <!-- Habitat Decorations Tab Panel -->
            <div x-show="activeTab === 'habitats'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <!-- Habitat items content would go here -->
                <div class="text-center py-8 text-gray-500">Loading habitat decorations...</div>
            </div>
            
            <!-- Special Eggs Tab Panel -->
            <div x-show="activeTab === 'eggs'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <!-- Eggs content would go here -->
                <div class="text-center py-8 text-gray-500">Loading special eggs...</div>
            </div>
            
            <!-- Conservation Tab Panel -->
            <div x-show="activeTab === 'conservation'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Conservation content would go here -->
                <div class="text-center py-8 text-gray-500">Loading conservation packages...</div>
            </div>
            
            <!-- Limited Edition Tab Panel -->
            <div x-show="activeTab === 'limited'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <!-- Limited edition content would go here -->
                <div class="text-center py-8 text-gray-500">Loading limited edition items...</div>
            </div>
        </div>
        
        <!-- Recently Viewed -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-800">Recently Viewed</h2>
            </div>
            <div class="p-6">
                <div class="flex overflow-x-auto space-x-4 pb-2">
                    <!-- Recently Viewed Item 1 -->
                    <div class="flex-shrink-0 w-40 bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <img src="<?= $baseUrl ?>/images/shop/magic-crystal.png" alt="Magic Crystal" class="w-full h-32 object-contain p-2 bg-purple-50">
                        <div class="p-3">
                            <h3 class="font-medium text-sm text-gray-800 mb-1 truncate">Magic Crystal</h3>
                            <div class="flex items-center">
                                <span class="font-bold text-sm text-gray-800 mr-1">450</span>
                                <i class="fas fa-coins text-yellow-500 text-xs"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recently Viewed Item 2 -->
                    <div class="flex-shrink-0 w-40 bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <img src="<?= $baseUrl ?>/images/shop/golden-crown.png" alt="Golden Crown" class="w-full h-32 object-contain p-2 bg-yellow-50">
                        <div class="p-3">
                            <h3 class="font-medium text-sm text-gray-800 mb-1 truncate">Golden Crown</h3>
                            <div class="flex items-center">
                                <span class="font-bold text-sm text-gray-800 mr-1">750</span>
                                <i class="fas fa-coins text-yellow-500 text-xs"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recently Viewed Item 3 -->
                    <div class="flex-shrink-0 w-40 bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <img src="<?= $baseUrl ?>/images/shop/enchanted-fountain.png" alt="Enchanted Fountain" class="w-full h-32 object-contain p-2 bg-blue-50">
                        <div class="p-3">
                            <h3 class="font-medium text-sm text-gray-800 mb-1 truncate">Enchanted Fountain</h3>
                            <div class="flex items-center">
                                <span class="font-bold text-sm text-gray-800 mr-1">325</span>
                                <i class="fas fa-coins text-yellow-500 text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Community Progress -->
        <div class="bg-green-50 rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-green-600 text-white">
                <h2 class="text-lg font-bold">Community Conservation Progress</h2>
            </div>
            <div class="p-6">
                <div class="mb-6 text-center">
                    <p class="text-gray-600 mb-2">Together, Wildlife Haven users have contributed to:</p>
                    <div class="grid grid-cols-3 gap-4 max-w-2xl mx-auto">
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-3xl font-bold text-green-600">547</div>
                            <div class="text-sm text-gray-500">Trees Planted</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-3xl font-bold text-blue-600">32</div>
                            <div class="text-sm text-gray-500">Acres Protected</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-3xl font-bold text-amber-600">$2,450</div>
                            <div class="text-sm text-gray-500">Donations Made</div>
                        </div>
                    </div>
                </div>
                
                <!-- Current Goal -->
                <div class="bg-white rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold text-gray-800">Current Community Goal: 1,000 Trees</h3>
                        <span class="text-green-600 font-medium">54.7% Complete</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: 54.7%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">When we reach 1,000 trees, all users will receive a special Rainforest Guardian egg!</p>
                    <div class="text-center">
                        <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-seedling mr-2"></i> Contribute Now
                        </button>
                    </div>
                </div>
                
                <!-- Conservation Partners -->
                <div class="text-center">
                    <h3 class="font-medium text-gray-700 mb-3">Our Conservation Partners</h3>
                    <div class="flex flex-wrap justify-center items-center gap-6">
                        <img src="<?= $baseUrl ?>/images/partners/rainforest-trust.png" alt="Rainforest Trust" class="h-12 opacity-70 hover:opacity-100 transition-opacity">
                        <img src="<?= $baseUrl ?>/images/partners/wwf.png" alt="World Wildlife Fund" class="h-10 opacity-70 hover:opacity-100 transition-opacity">
                        <img src="<?= $baseUrl ?>/images/partners/one-tree-planted.png" alt="One Tree Planted" class="h-12 opacity-70 hover:opacity-100 transition-opacity">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Item Preview Modal -->
<div id="item-preview-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Item Preview Image/3D View -->
            <div class="w-full md:w-1/2 bg-gray-50 p-6 flex items-center justify-center min-h-[300px]">
                <div id="item-preview-display" class="w-full h-full">
                    <!-- 3D viewer or image will be loaded here -->
                    <img src="<?= $baseUrl ?>/images/shop/golden-crown.png" alt="Golden Crown" class="max-w-full max-h-[400px] object-contain mx-auto">
                </div>
            </div>
            
            <!-- Item Details -->
            <div class="w-full md:w-1/2 p-6 overflow-y-auto max-h-[600px]">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Golden Crown</h2>
                        <div class="flex items-center mt-1">
                            <div class="px-2 py-0.5 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">
                                Legendary
                            </div>
                            <span class="mx-2 text-gray-400">•</span>
                            <div class="text-gray-600 text-sm">
                                Creature Accessory
                            </div>
                        </div>
                    </div>
                    <button id="close-preview-btn" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="border-t border-gray-200 pt-4 mb-4">
                    <p class="text-gray-700 mb-4">
                        This majestic golden crown is crafted from enchanted materials. When worn by your mythical creatures, it increases their happiness and adds a regal appearance that impresses other creatures.
                    </p>
                    
                    <div class="mb-4">
                        <h3 class="font-medium text-gray-800 mb-2">Effects</h3>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                <span>+15% Happiness bonus for the creature wearing it</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                <span>+5% Growth speed bonus</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                <span>Special animations and effects in AR view</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4 mb-4">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <span class="text-3xl font-bold text-gray-800 mr-2">750</span>
                            <i class="fas fa-coins text-yellow-500 text-xl"></i>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="text-sm text-gray-500 mr-4">
                                <span class="mr-1">Quantity:</span>
                                <select class="border border-gray-300 rounded p-1">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                            Add to Cart
                        </button>
                        <button class="flex items-center justify-center w-12 h-12 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="font-medium text-gray-800 mb-3">Try it on your creatures</h3>
                    <div class="grid grid-cols-4 gap-2">
                        <div class="bg-gray-100 rounded p-2 text-center cursor-pointer hover:bg-gray-200 transition-colors">
                            <img src="<?= $baseUrl ?>/images/creatures/1_mythical.png" alt="Dragon" class="w-full h-12 object-contain">
                            <span class="text-xs text-gray-600 block mt-1 truncate">Dragon</span>
                        </div>
                        <div class="bg-gray-100 rounded p-2 text-center cursor-pointer hover:bg-gray-200 transition-colors">
                            <img src="<?= $baseUrl ?>/images/creatures/2_mythical.png" alt="Phoenix" class="w-full h-12 object-contain">
                            <span class="text-xs text-gray-600 block mt-1 truncate">Phoenix</span>
                        </div>
                        <div class="bg-gray-100 rounded p-2 text-center cursor-not-allowed opacity-50">
                            <img src="<?= $baseUrl ?>/images/creatures/3_adult.png" alt="Kirin" class="w-full h-12 object-contain">
                            <span class="text-xs text-gray-600 block mt-1 truncate">Kirin (Adult)</span>
                        </div>
                        <div class="bg-gray-100 rounded p-2 text-center cursor-not-allowed opacity-50">
                            <img src="<?= $baseUrl ?>/images/creatures/4_juvenile.png" alt="Serpent" class="w-full h-12 object-contain">
                            <span class="text-xs text-gray-600 block mt-1 truncate">Serpent (Youth)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Alpine.js for tab functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Add Three.js for 3D previews -->
<script src="https://cdn.jsdelivr.net/npm/three@0.154.0/build/three.min.js"></script>

<!-- Shop page JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Countdown timer for daily deals
    function updateCountdown() {
        const now = new Date();
        // Set the end time to midnight
        const end = new Date();
        end.setHours(23, 59, 59, 999);
        
        // Calculate remaining time
        const diff = end - now;
        
        // Calculate hours, minutes, seconds
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        // Format the time
        const formattedTime = 
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');
        
        // Update the countdown element
        document.getElementById('countdown-timer').textContent = formattedTime;
    }
    
    // Update the countdown immediately and then every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
    
    // Item preview modal
    const previewModal = document.getElementById('item-preview-modal');
    const closePreviewBtn = document.getElementById('close-preview-btn');
    
    // Sample function to open the preview modal
    window.openItemPreview = function(itemId) {
        // In a real implementation, you would fetch item data based on the ID
        // and update the modal content
        previewModal.classList.remove('hidden');
        
        // Prevent scrolling of the body when modal is open
        document.body.style.overflow = 'hidden';
    }
    
    // Close modal when clicking the close button
    closePreviewBtn.addEventListener('click', function() {
        previewModal.classList.add('hidden');
        document.body.style.overflow = '';
    });
    
    // Close modal when clicking outside the content
    previewModal.addEventListener('click', function(e) {
        if (e.target === previewModal) {
            previewModal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });
    
    // For demonstration, add click listeners to shop items
    document.querySelectorAll('.bg-white.rounded-lg.shadow-sm').forEach(item => {
        item.addEventListener('click', function() {
            // In a real implementation, you would get the item ID from a data attribute
            window.openItemPreview('sample-item-id');
        });
    });
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>