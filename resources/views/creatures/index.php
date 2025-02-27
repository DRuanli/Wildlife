<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-green-50 to-white pb-12">
    <!-- Creatures Hero Banner -->
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
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">My Mythical Creatures</h1>
                    <p class="text-purple-100 text-lg">Collect, grow, and evolve your wildlife companion creatures</p>
                </div>
                <div class="flex space-x-2">
                    <a href="<?= $baseUrl ?>/focus" class="px-4 py-2 bg-white text-purple-700 rounded-lg text-sm font-medium hover:bg-purple-50 transition-colors shadow-md">
                        <i class="fas fa-clock mr-2"></i> Start Focus to Grow
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-6">
        <!-- Creature Collection Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Overall Collection -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">My Collection</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-purple-50 rounded-lg p-4 text-center">
                            <p class="text-sm text-purple-600 font-medium">Total Creatures</p>
                            <p class="text-3xl font-bold text-gray-800"><?= count($creatures) ?></p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4 text-center">
                            <p class="text-sm text-purple-600 font-medium">Species Found</p>
                            <?php
                            // Calculate unique species count
                            $uniqueSpecies = [];
                            foreach ($creatures as $creature) {
                                $uniqueSpecies[$creature['species_id']] = true;
                            }
                            $speciesCount = count($uniqueSpecies);
                            ?>
                            <p class="text-3xl font-bold text-gray-800"><?= $speciesCount ?></p>
                        </div>
                    </div>
                    
                    <!-- Collection Progress -->
                    <div class="mt-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700 font-medium">Collection Progress</span>
                            <span class="text-purple-600"><?= $speciesCount ?>/24</span>
                        </div>
                        <div class="h-3 bg-gray-200 rounded-full overflow-hidden mb-4">
                            <div class="h-full bg-gradient-to-r from-purple-500 to-purple-700 rounded-full" style="width: <?= ($speciesCount / 24) * 100 ?>%"></div>
                        </div>
                        
                        <!-- Collection Stats -->
                        <div class="grid grid-cols-5 gap-1 my-4">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-1">
                                    <i class="fas fa-egg text-sm"></i>
                                </div>
                                <span class="text-xs font-medium text-gray-700"><?= isset($organized['eggs']) ? count($organized['eggs']) : 0 ?></span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mb-1">
                                    <i class="fas fa-baby text-sm"></i>
                                </div>
                                <span class="text-xs font-medium text-gray-700"><?= isset($organized['babies']) ? count($organized['babies']) : 0 ?></span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mb-1">
                                    <i class="fas fa-dragon text-sm"></i>
                                </div>
                                <span class="text-xs font-medium text-gray-700"><?= isset($organized['juveniles']) ? count($organized['juveniles']) : 0 ?></span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 mb-1">
                                    <i class="fas fa-paw text-sm"></i>
                                </div>
                                <span class="text-xs font-medium text-gray-700"><?= isset($organized['adults']) ? count($organized['adults']) : 0 ?></span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 mb-1">
                                    <i class="fas fa-crown text-sm"></i>
                                </div>
                                <span class="text-xs font-medium text-gray-700"><?= isset($organized['mythicals']) ? count($organized['mythicals']) : 0 ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Currently Growing -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">Active Growth</h3>
                </div>
                <div class="p-6">
                    <?php
                    // Get creatures that are currently growing (not eggs and not mythicals)
                    $growingCreatures = array_filter($creatures, function($creature) {
                        return $creature['stage'] !== 'egg' && $creature['stage'] !== 'mythical';
                    });
                    
                    // Sort by growth progress
                    usort($growingCreatures, function($a, $b) {
                        // Calculate percentage
                        $aPercentage = ($a['growth_progress'] / 200) * 100;
                        $bPercentage = ($b['growth_progress'] / 200) * 100;
                        
                        // Sort by percentage in descending order
                        return $bPercentage <=> $aPercentage;
                    });
                    
                    // Get the top 3 growing
                    $topGrowing = array_slice($growingCreatures, 0, 3);
                    ?>
                    
                    <?php if (empty($topGrowing)): ?>
                        <div class="flex flex-col items-center justify-center py-6">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                                <i class="fas fa-seedling text-2xl"></i>
                            </div>
                            <h4 class="text-gray-700 font-medium mb-1">No Growing Creatures</h4>
                            <p class="text-gray-500 text-sm text-center mb-3">Hatch an egg to start growing your first creature</p>
                            <a href="<?= $baseUrl ?>/focus" class="px-4 py-2 bg-green-600 text-sm text-white rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-clock mr-1"></i> Start Focus Session
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($topGrowing as $creature): ?>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-<?= $creature['habitat_type'] ?? 'green' ?>-100 rounded-full flex items-center justify-center mr-3">
                                            <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-8 w-8 object-contain">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-center">
                                                <h4 class="text-sm font-medium text-gray-800 truncate" title="<?= htmlspecialchars($creature['name'] ?? 'Unnamed') ?>">
                                                    <?= htmlspecialchars($creature['name'] ?? 'Unnamed') ?>
                                                </h4>
                                                <span class="text-xs bg-<?= $creature['habitat_type'] ?? 'green' ?>-100 text-<?= $creature['habitat_type'] ?? 'green' ?>-800 px-2 py-0.5 rounded-full capitalize">
                                                    <?= $creature['stage'] ?>
                                                </span>
                                            </div>
                                            
                                            <!-- Growth Progress -->
                                            <?php 
                                                // Calculate growth percentage 
                                                $growthPercentage = min(100, ($creature['growth_progress'] / 200) * 100);
                                            ?>
                                            <div class="mt-2">
                                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                                    <span><?= $creature['growth_progress'] ?>/200 growth points</span>
                                                    <span><?= round($growthPercentage) ?>%</span>
                                                </div>
                                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-<?= $creature['habitat_type'] ?? 'green' ?>-500 rounded-full" style="width: <?= $growthPercentage ?>%"></div>
                                                </div>
                                            </div>
                                            
                                            <?php if ($growthPercentage >= 100): ?>
                                                <div class="mt-2 text-xs text-green-600 flex items-center">
                                                    <i class="fas fa-arrow-up-right-dots mr-1"></i> Ready to evolve!
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <?php if (count($growingCreatures) > 3): ?>
                                <div class="text-center">
                                    <button class="text-green-600 hover:text-green-800 text-sm font-medium" id="show-more-growing">
                                        Show <?= count($growingCreatures) - 3 ?> more growing
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Ready to Hatch -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">Ready to Hatch</h3>
                </div>
                <div class="p-6">
                    <?php
                    // Get eggs that are ready to hatch (growth progress >= 100)
                    $readyToHatchEggs = array_filter($organized['eggs'] ?? [], function($egg) {
                        return $egg['growth_progress'] >= 100;
                    });
                    ?>
                    
                    <?php if (empty($readyToHatchEggs)): ?>
                        <div class="flex flex-col items-center justify-center py-6">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                                <i class="fas fa-egg text-2xl"></i>
                            </div>
                            <h4 class="text-gray-700 font-medium mb-1">No Eggs Ready to Hatch</h4>
                            <p class="text-gray-500 text-sm text-center mb-3">Keep focusing to warm your eggs</p>
                            <a href="<?= $baseUrl ?>/focus" class="px-4 py-2 bg-amber-500 text-sm text-white rounded-lg hover:bg-amber-600 transition-colors">
                                <i class="fas fa-clock mr-1"></i> Focus to Warm Eggs
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-2 gap-4">
                            <?php foreach ($readyToHatchEggs as $egg): ?>
                                <a href="<?= $baseUrl ?>/creatures/hatch/<?= $egg['id'] ?>" class="group">
                                    <div class="bg-amber-50 border border-amber-100 rounded-lg p-4 text-center hover:border-amber-300 hover:shadow-md transition-all">
                                        <div class="w-16 h-16 mx-auto bg-white rounded-full border-2 border-amber-200 flex items-center justify-center mb-3 group-hover:animate-pulse">
                                            <i class="fas fa-egg text-amber-400 text-2xl"></i>
                                        </div>
                                        <h4 class="font-medium text-gray-800 mb-1">Mystery Egg</h4>
                                        <p class="text-xs text-amber-600">Ready to hatch!</p>
                                        
                                        <div class="mt-3 px-3 py-1 bg-amber-500 text-white text-xs font-medium rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                            Hatch Now
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Creatures Filter and Grid -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-violet-600 to-purple-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">All Creatures</h3>
                
                <!-- Total Count Badge -->
                <span class="px-3 py-1 bg-white text-purple-700 text-sm font-medium rounded-full">
                    <?= count($creatures) ?> creatures
                </span>
            </div>
            
            <div class="p-6">
                <?php if (empty($creatures)): ?>
                    <div class="text-center py-10">
                        <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                            <i class="fas fa-dragon text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-800 mb-2">No creatures found</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">Complete focus sessions to incubate eggs and build your mythical creature collection.</p>
                        <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-clock mr-2"></i> Start Focus Session
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Filters -->
                    <div class="mb-6" x-data="{ showFilters: false }">
                        <div class="flex justify-between items-center mb-4">
                            <button @click="showFilters = !showFilters" class="flex items-center text-sm font-medium text-purple-600 hover:text-purple-800">
                                <i class="fas fa-sliders mr-2"></i>
                                <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'">Show Filters</span>
                                <i class="fas fa-chevron-down ml-1 transition-transform" :class="showFilters ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <!-- Sort Options -->
                            <div class="flex items-center">
                                <label for="sort-by" class="text-sm text-gray-600 mr-2">Sort:</label>
                                <select id="sort-by" class="text-sm border-gray-300 rounded-lg focus:border-purple-500 focus:ring-purple-500">
                                    <option value="newest">Newest First</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="stage">By Stage</option>
                                    <option value="growth">By Growth Progress</option>
                                    <option value="name">By Name</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Filter Panel (toggleable) -->
                        <div x-show="showFilters" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="bg-gray-50 rounded-lg p-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Stage Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Stage</label>
                                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                                        <button type="button" class="filter-btn stage-filter active px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center" data-filter="all">
                                            All
                                        </button>
                                        <button type="button" class="filter-btn stage-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center" data-filter="egg">
                                            <i class="fas fa-egg text-gray-500 mr-1.5"></i> Eggs
                                        </button>
                                        <button type="button" class="filter-btn stage-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center" data-filter="baby">
                                            <i class="fas fa-baby text-gray-500 mr-1.5"></i> Baby
                                        </button>
                                        <button type="button" class="filter-btn stage-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center" data-filter="juvenile">
                                            <i class="fas fa-dragon text-gray-500 mr-1.5"></i> Juvenile
                                        </button>
                                        <button type="button" class="filter-btn stage-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center" data-filter="adult">
                                            <i class="fas fa-paw text-gray-500 mr-1.5"></i> Adult
                                        </button>
                                        <button type="button" class="filter-btn stage-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center md:col-start-1" data-filter="mythical">
                                            <i class="fas fa-crown text-gray-500 mr-1.5"></i> Mythical
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Habitat Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Habitat Type</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <button type="button" class="filter-btn habitat-filter active px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center" data-filter="all">
                                            All Habitats
                                        </button>
                                        <button type="button" class="filter-btn habitat-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center bg-forest-50 text-forest-700 border-forest-200" data-filter="forest">
                                            <i class="fas fa-tree mr-1.5"></i> Forest
                                        </button>
                                        <button type="button" class="filter-btn habitat-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center bg-ocean-50 text-ocean-700 border-ocean-200" data-filter="ocean">
                                            <i class="fas fa-water mr-1.5"></i> Ocean
                                        </button>
                                        <button type="button" class="filter-btn habitat-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center bg-mountain-50 text-mountain-700 border-mountain-200" data-filter="mountain">
                                            <i class="fas fa-mountain mr-1.5"></i> Mountain
                                        </button>
                                        <button type="button" class="filter-btn habitat-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center bg-sky-50 text-sky-700 border-sky-200" data-filter="sky">
                                            <i class="fas fa-cloud mr-1.5"></i> Sky
                                        </button>
                                        <button type="button" class="filter-btn habitat-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center bg-enchanted-50 text-enchanted-700 border-enchanted-200" data-filter="enchanted">
                                            <i class="fas fa-sparkles mr-1.5"></i> Enchanted
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Status Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <button type="button" class="filter-btn status-filter active px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center" data-filter="all">
                                            All Status
                                        </button>
                                        <button type="button" class="filter-btn status-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center bg-green-50 text-green-700 border-green-200" data-filter="ready">
                                            <i class="fas fa-arrow-up mr-1.5"></i> Ready to Evolve
                                        </button>
                                        <button type="button" class="filter-btn status-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center bg-amber-50 text-amber-700 border-amber-200" data-filter="growing">
                                            <i class="fas fa-seedling mr-1.5"></i> Currently Growing
                                        </button>
                                        <button type="button" class="filter-btn status-filter px-3 py-1.5 text-sm border rounded-lg flex items-center justify-center bg-gray-50 text-gray-700 border-gray-200" data-filter="maxed">
                                            <i class="fas fa-star mr-1.5"></i> Max Level
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Active Filters & Clear -->
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                                <div class="flex items-center flex-wrap gap-2" id="active-filters">
                                    <div class="text-sm text-gray-500 mr-1">Active Filters:</div>
                                    <span class="text-sm bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full flex items-center" id="filter-all">
                                        All <button class="ml-1 text-purple-600 hover:text-purple-800"><i class="fas fa-times"></i></button>
                                    </span>
                                </div>
                                <button id="clear-filters" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                    Clear All Filters
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Creatures Grid -->
                    <div id="creatures-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <?php foreach ($creatures as $creature): ?>
                            <div class="creature-card" 
                                 data-stage="<?= $creature['stage'] ?>" 
                                 data-habitat="<?= $creature['habitat_type'] ?? 'none' ?>"
                                 data-status="<?php 
                                    if ($creature['stage'] === 'mythical') {
                                        echo 'maxed';
                                    } else if ($creature['stage'] === 'egg' && $creature['growth_progress'] >= 100) {
                                        echo 'ready';
                                    } else if ($creature['stage'] !== 'egg' && $creature['growth_progress'] >= 200) {
                                        echo 'ready';
                                    } else if ($creature['stage'] !== 'mythical') {
                                        echo 'growing';
                                    } else {
                                        echo 'none';
                                    }
                                 ?>"
                             >
                                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-all group relative">
                                    <!-- Creature Image -->
                                    <div class="aspect-square p-4 flex items-center justify-center bg-<?= $creature['habitat_type'] ?? 'gray' ?>-50 border-b border-gray-100 group-hover:bg-<?= $creature['habitat_type'] ?? 'gray' ?>-100 transition-colors relative">
                                        <?php if ($creature['stage'] === 'egg'): ?>
                                            <i class="fas fa-egg text-<?= $creature['habitat_type'] ?? 'gray' ?>-400 text-5xl group-hover:animate-pulse"></i>
                                            <?php if ($creature['growth_progress'] >= 100): ?>
                                                <div class="absolute bottom-2 right-2 w-6 h-6 bg-amber-500 rounded-full text-white flex items-center justify-center animate-pulse">
                                                    <i class="fas fa-bolt text-xs"></i>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-24 w-24 object-contain transform group-hover:scale-110 transition-transform">
                                            <?php if ($creature['stage'] !== 'mythical' && $creature['growth_progress'] >= 200): ?>
                                                <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 rounded-full text-white flex items-center justify-center animate-pulse">
                                                    <i class="fas fa-arrow-up text-xs"></i>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Creature Info -->
                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="font-medium text-gray-800 truncate" title="<?= htmlspecialchars($creature['name'] ?? 'Unnamed') ?>">
                                                <?= htmlspecialchars($creature['name'] ?? 'Unnamed') ?>
                                            </h4>
                                            <span class="text-xs bg-<?= $creature['habitat_type'] ?? 'gray' ?>-100 text-<?= $creature['habitat_type'] ?? 'gray' ?>-700 px-1.5 py-0.5 rounded capitalize">
                                                <?= $creature['stage'] ?>
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mb-2"><?= $creature['species_name'] ?></p>
                                        
                                        <?php if ($creature['stage'] !== 'mythical'): ?>
                                            <!-- Growth Progress -->
                                            <div class="mb-3">
                                                <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                                    <?php 
                                                    // Calculate growth percentage
                                                    $growthPercentage = 0;
                                                    if ($creature['stage'] === 'egg') {
                                                        $growthPercentage = min(100, ($creature['growth_progress'] / 100) * 100);
                                                    } else {
                                                        $growthPercentage = min(100, ($creature['growth_progress'] / 200) * 100);
                                                    }
                                                    ?>
                                                    <div class="h-full bg-<?= $creature['habitat_type'] ?? 'gray' ?>-500 rounded-full" style="width: <?= $growthPercentage ?>%"></div>
                                                </div>
                                                <div class="flex justify-between mt-1 text-xs text-gray-500">
                                                    <span>Growth: <?= $creature['growth_progress'] ?>/<?= $creature['stage'] === 'egg' ? '100' : '200' ?></span>
                                                    <span><?= round($growthPercentage) ?>%</span>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <!-- Mythical Badge -->
                                            <div class="flex items-center justify-center space-x-1 mb-3">
                                                <?php for($i = 0; $i < 5; $i++): ?>
                                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                <?php endfor; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Action Button -->
                                        <a href="<?= $baseUrl ?>/creatures/view/<?= $creature['id'] ?>" class="block w-full text-center py-2 bg-<?= $creature['habitat_type'] ?? 'purple' ?>-600 text-white text-sm font-medium rounded-lg hover:bg-<?= $creature['habitat_type'] ?? 'purple' ?>-700 transition-colors">
                                            <?php if ($creature['stage'] === 'egg' && $creature['growth_progress'] >= 100): ?>
                                                Hatch Now
                                            <?php elseif ($creature['stage'] !== 'egg' && $creature['stage'] !== 'mythical' && $creature['growth_progress'] >= 200): ?>
                                                Evolve Now
                                            <?php else: ?>
                                                View Details
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Habitat Selection -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Creature Habitats</h3>
            </div>
            
            <div class="p-6">
                <?php if (empty($habitats)): ?>
                    <div class="text-center py-6">
                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                            <i class="fas fa-tree text-2xl"></i>
                        </div>
                        <h4 class="text-gray-700 font-medium mb-2">No habitats created yet!</h4>
                        <p class="text-gray-500 mb-4">Create your first habitat to house your creatures.</p>
                        <a href="<?= $baseUrl ?>/habitats/create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-sm text-white rounded-md hover:bg-blue-700">
                            Create Habitat
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($habitats as $habitat): 
                            // Count creatures in this habitat
                            $habitatCreatures = array_filter($creatures, function($creature) use ($habitat) {
                                return isset($creature['habitat_id']) && $creature['habitat_id'] == $habitat['id'];
                            });
                            $creatureCount = count($habitatCreatures);
                        ?>
                            <div class="relative overflow-hidden rounded-xl border border-gray-200 transition-all hover:shadow-md group">
                                <!-- Habitat Background -->
                                <div class="h-32 bg-gradient-to-br 
                                    <?php
                                    switch ($habitat['type']) {
                                        case 'forest': echo 'from-green-100 to-green-200'; break;
                                        case 'ocean': echo 'from-blue-100 to-blue-200'; break;
                                        case 'mountain': echo 'from-red-100 to-red-200'; break;
                                        case 'sky': echo 'from-cyan-100 to-cyan-200'; break;
                                        case 'cosmic': echo 'from-purple-100 to-purple-200'; break;
                                        case 'enchanted': echo 'from-pink-100 to-pink-200'; break;
                                        default: echo 'from-gray-100 to-gray-200';
                                    }
                                    ?> p-4">
                                    <div class="flex justify-between">
                                        <div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-<?= $habitat['type'] ?>-800 uppercase">
                                                <?= $habitat['type'] ?>
                                            </span>
                                            <h4 class="text-<?= $habitat['type'] ?>-800 text-lg font-medium mt-1">
                                                <?= ucfirst($habitat['type']) ?> Haven
                                            </h4>
                                        </div>
                                        <div class="bg-white bg-opacity-70 px-2 py-1 rounded-full flex items-center text-xs font-medium text-<?= $habitat['type'] ?>-800">
                                            <i class="fas fa-layer-group mr-1"></i> Level <?= $habitat['level'] ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-4 bg-white">
                                    <!-- Habitat Stats -->
                                    <div class="flex justify-between text-sm mb-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-dragon text-gray-400 mr-1.5"></i>
                                            <span class="text-gray-700"><?= $creatureCount ?> creatures</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-expand text-gray-400 mr-1.5"></i>
                                            <span class="text-gray-700">Size <?= $habitat['expansion_level'] ?>/5</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Habitat Creatures Preview -->
                                    <?php if ($creatureCount > 0): ?>
                                        <div class="flex items-center mb-4 -space-x-2 overflow-hidden">
                                            <?php 
                                            $displayCount = min(5, $creatureCount);
                                            $displayedCreatures = array_slice($habitatCreatures, 0, $displayCount);
                                            foreach ($displayedCreatures as $creature): 
                                            ?>
                                                <div class="w-8 h-8 rounded-full ring-2 ring-white overflow-hidden bg-<?= $creature['habitat_type'] ?? 'gray' ?>-100 flex items-center justify-center">
                                                    <?php if ($creature['stage'] === 'egg'): ?>
                                                        <i class="fas fa-egg text-<?= $creature['habitat_type'] ?? 'gray' ?>-400 text-xs"></i>
                                                    <?php else: ?>
                                                        <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-6 w-6 object-contain">
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                            
                                            <?php if ($creatureCount > $displayCount): ?>
                                                <div class="w-8 h-8 rounded-full ring-2 ring-white bg-gray-200 flex items-center justify-center text-xs font-medium text-gray-600">
                                                    +<?= $creatureCount - $displayCount ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-sm text-gray-500 mb-4">No creatures in this habitat</div>
                                    <?php endif; ?>
                                    
                                    <div class="flex justify-between">
                                        <a href="<?= $baseUrl ?>/habitats/view/<?= $habitat['id'] ?>" class="text-<?= $habitat['type'] ?>-600 hover:text-<?= $habitat['type'] ?>-800 text-sm font-medium">
                                            View Habitat
                                        </a>
                                        <a href="<?= $baseUrl ?>/creatures/move-habitat/<?= $habitat['id'] ?>" class="text-<?= $habitat['type'] ?>-600 hover:text-<?= $habitat['type'] ?>-800 text-sm font-medium">
                                            Move Creatures
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Alpine.js for interactive components -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- JavaScript for Creatures Page -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const creaturesGrid = document.getElementById('creatures-grid');
    const creatureCards = document.querySelectorAll('.creature-card');
    const activeFiltersContainer = document.getElementById('active-filters');
    const clearFiltersButton = document.getElementById('clear-filters');
    
    // Current filters state
    let activeFilters = {
        stage: 'all',
        habitat: 'all',
        status: 'all'
    };
    
    // Sort functionality
    const sortSelect = document.getElementById('sort-by');
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            sortCreatures(this.value);
        });
    }
    
    function sortCreatures(sortType) {
        if (!creaturesGrid) return;
        
        const cards = Array.from(creatureCards);
        
        cards.sort((a, b) => {
            switch (sortType) {
                case 'newest':
                    // Would need creation date data attributes
                    return 0; // Default to no change for this example
                case 'oldest':
                    // Would need creation date data attributes
                    return 0; // Default to no change for this example
                case 'stage':
                    // Define stage order
                    const stageOrder = {'egg': 0, 'baby': 1, 'juvenile': 2, 'adult': 3, 'mythical': 4};
                    return stageOrder[a.dataset.stage] - stageOrder[b.dataset.stage];
                case 'growth':
                    // Would need growth percentage data attributes
                    return 0; // Default to no change for this example
                case 'name':
                    // Would need name data attributes
                    return 0; // Default to no change for this example
                default:
                    return 0;
            }
        });
        
        // Re-append sorted items
        cards.forEach(card => {
            creaturesGrid.appendChild(card);
        });
    }
    
    // Filter functionality
    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filterType = this.classList.contains('stage-filter') ? 'stage' : 
                                   this.classList.contains('habitat-filter') ? 'habitat' : 'status';
                const filterValue = this.dataset.filter;
                
                // Update active state for this filter type
                document.querySelectorAll(`.${filterType}-filter`).forEach(btn => {
                    btn.classList.remove('bg-gray-200', 'border-gray-300', 'font-medium');
                    btn.classList.remove('active');
                });
                
                this.classList.add('bg-gray-200', 'border-gray-300', 'font-medium');
                this.classList.add('active');
                
                // Update active filters
                activeFilters[filterType] = filterValue;
                
                // Apply filters
                applyFilters();
                
                // Update active filters display
                updateActiveFiltersDisplay();
            });
        });
    }
    
    // Clear all filters
    if (clearFiltersButton) {
        clearFiltersButton.addEventListener('click', function() {
            // Reset filter state
            activeFilters = {
                stage: 'all',
                habitat: 'all',
                status: 'all'
            };
            
            // Reset filter buttons
            filterButtons.forEach(button => {
                if (button.dataset.filter === 'all') {
                    button.classList.add('bg-gray-200', 'border-gray-300', 'font-medium');
                    button.classList.add('active');
                } else {
                    button.classList.remove('bg-gray-200', 'border-gray-300', 'font-medium');
                    button.classList.remove('active');
                }
            });
            
            // Apply filters
            applyFilters();
            
            // Update active filters display
            updateActiveFiltersDisplay();
        });
    }
    
    function applyFilters() {
        if (!creaturesGrid) return;
        
        // Filter creature cards
        creatureCards.forEach(card => {
            const stageMatch = activeFilters.stage === 'all' || card.dataset.stage === activeFilters.stage;
            const habitatMatch = activeFilters.habitat === 'all' || card.dataset.habitat === activeFilters.habitat;
            const statusMatch = activeFilters.status === 'all' || card.dataset.status === activeFilters.status;
            
            if (stageMatch && habitatMatch && statusMatch) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Check if any cards are visible
        let visibleCards = 0;
        creatureCards.forEach(card => {
            if (card.style.display !== 'none') {
                visibleCards++;
            }
        });
        
        // Show no results message if needed
        let noResultsMessage = document.getElementById('no-results-message');
        if (visibleCards === 0) {
            if (!noResultsMessage) {
                noResultsMessage = document.createElement('div');
                noResultsMessage.id = 'no-results-message';
                noResultsMessage.className = 'text-center py-8';
                noResultsMessage.innerHTML = `
                    <div class="w-12 h-12 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-2">
                        <i class="fas fa-search text-lg"></i>
                    </div>
                    <p class="text-gray-500">No creatures match your filters</p>
                `;
                creaturesGrid.appendChild(noResultsMessage);
            }
        } else if (noResultsMessage) {
            noResultsMessage.remove();
        }
    }
    
    function updateActiveFiltersDisplay() {
        if (!activeFiltersContainer) return;
        
        // Clear current filters
        activeFiltersContainer.innerHTML = '<div class="text-sm text-gray-500 mr-1">Active Filters:</div>';
        
        // If all filters are 'all', show one "All" filter
        if (activeFilters.stage === 'all' && activeFilters.habitat === 'all' && activeFilters.status === 'all') {
            const allFilter = document.createElement('span');
            allFilter.className = 'text-sm bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full flex items-center';
            allFilter.innerHTML = 'All <button class="ml-1 text-purple-600 hover:text-purple-800"><i class="fas fa-times"></i></button>';
            activeFiltersContainer.appendChild(allFilter);
            return;
        }
        
        // Add active stage filter
        if (activeFilters.stage !== 'all') {
            const stageFilter = document.createElement('span');
            stageFilter.className = 'text-sm bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full flex items-center';
            stageFilter.innerHTML = `Stage: ${activeFilters.stage} <button class="ml-1 text-purple-600 hover:text-purple-800"><i class="fas fa-times"></i></button>`;
            stageFilter.querySelector('button').addEventListener('click', function() {
                document.querySelector('.stage-filter[data-filter="all"]').click();
            });
            activeFiltersContainer.appendChild(stageFilter);
        }
        
        // Add active habitat filter
        if (activeFilters.habitat !== 'all') {
            const habitatFilter = document.createElement('span');
            habitatFilter.className = 'text-sm bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full flex items-center';
            habitatFilter.innerHTML = `Habitat: ${activeFilters.habitat} <button class="ml-1 text-purple-600 hover:text-purple-800"><i class="fas fa-times"></i></button>`;
            habitatFilter.querySelector('button').addEventListener('click', function() {
                document.querySelector('.habitat-filter[data-filter="all"]').click();
            });
            activeFiltersContainer.appendChild(habitatFilter);
        }
        
        // Add active status filter
        if (activeFilters.status !== 'all') {
            const statusFilter = document.createElement('span');
            statusFilter.className = 'text-sm bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full flex items-center';
            statusFilter.innerHTML = `Status: ${activeFilters.status} <button class="ml-1 text-purple-600 hover:text-purple-800"><i class="fas fa-times"></i></button>`;
            statusFilter.querySelector('button').addEventListener('click', function() {
                document.querySelector('.status-filter[data-filter="all"]').click();
            });
            activeFiltersContainer.appendChild(statusFilter);
        }
    }
    
    // Initialize with default sort
    if (sortSelect) {
        sortCreatures(sortSelect.value);
    }
    
    // Initialize with default filters
    applyFilters();
    updateActiveFiltersDisplay();
    
    // "Show more growing" button functionality
    const showMoreGrowingBtn = document.getElementById('show-more-growing');
    if (showMoreGrowingBtn) {
        showMoreGrowingBtn.addEventListener('click', function() {
            // This would show a modal with all growing creatures
            alert('This would open a modal showing all growing creatures.');
        });
    }
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>