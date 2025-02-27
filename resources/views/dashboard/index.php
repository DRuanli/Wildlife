<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Main Dashboard Container -->
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white pb-12">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden bg-green-600 text-white">
        <div class="absolute opacity-10 right-0 top-0 w-96 h-full">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <path fill="currentColor" d="M34.5,-59.2C45.5,-53.1,55.8,-45.6,65.3,-35.6C74.8,-25.6,83.4,-12.8,83.8,0.2C84.1,13.3,76.1,26.5,66.6,37.1C57.1,47.7,46.2,55.7,34.3,62.3C22.5,69,11.2,74.4,-1.9,77.5C-15,80.6,-30,81.4,-41.1,74.8C-52.2,68.2,-59.4,54.3,-64.7,40.5C-70,26.8,-73.5,13.4,-73.3,0.1C-73.1,-13.1,-69.1,-26.2,-63.8,-39.8C-58.4,-53.5,-51.8,-67.7,-40.9,-73.8C-30,-79.9,-15,-77.8,-1.9,-74.7C11.3,-71.5,22.5,-67.2,34.5,-59.2Z" transform="translate(100 100)" />
            </svg>
        </div>
        <div class="container mx-auto px-4 py-10 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Welcome back, <?= htmlspecialchars($user['username']) ?>!</h1>
                    <p class="text-green-100 text-lg">Your wildlife sanctuary awaits your attention</p>
                </div>
                <div class="flex space-x-3">
                    <a href="<?= $baseUrl ?>/focus" class="relative group px-6 py-3 bg-white text-green-700 rounded-lg font-medium shadow-lg overflow-hidden transition-all duration-300 hover:bg-green-50 hover:shadow-xl">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-clock mr-2 text-lg"></i>
                            Start Focus Session
                        </span>
                        <span class="absolute bottom-0 left-0 h-1 bg-green-500 w-0 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="container mx-auto px-4 -mt-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Focus Time Card -->
            <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-blue-500 transform transition-transform hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                        <i class="fas fa-hourglass-half text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-blue-500">Total Focus Time</p>
                        <div class="flex items-end">
                            <p class="text-2xl font-bold text-gray-800">
                                <?= floor($totalFocusTime / 60) ?>
                            </p>
                            <p class="text-lg text-gray-600 ml-1">hours</p>
                            <p class="text-lg font-bold text-gray-800 ml-2">
                                <?= $totalFocusTime % 60 ?>
                            </p>
                            <p class="text-lg text-gray-600 ml-1">mins</p>
                        </div>
                    </div>
                </div>
                <!-- Mini Progress Chart -->
                <div class="mt-4 h-10">
                    <canvas id="focusTimeChart" width="100%" height="30"></canvas>
                </div>
            </div>
            
            <!-- Streak Card -->
            <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-orange-500 transform transition-transform hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-500 mr-4 relative">
                        <i class="fas fa-fire text-xl"></i>
                        <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-green-500 text-white text-xs font-bold animate-pulse">
                            <i class="fas fa-arrow-up"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-orange-500">Current Streak</p>
                        <div class="flex items-end">
                            <p class="text-2xl font-bold text-gray-800">
                                <?= $focusStreak ?>
                            </p>
                            <p class="text-lg text-gray-600 ml-1">day<?= $focusStreak !== 1 ? 's' : '' ?></p>
                        </div>
                    </div>
                </div>
                <!-- Streak Calendar -->
                <div class="mt-4 flex space-x-1">
                    <?php 
                    // Sample streak data - in a real implementation, this would come from the backend
                    $pastDays = 7;
                    for ($i = $pastDays; $i >= 0; $i--): 
                        $isActive = $i < $focusStreak;
                        $isToday = $i === 0;
                    ?>
                        <div class="flex-1">
                            <div class="text-xs text-center text-gray-500 mb-1">
                                <?= date('D', strtotime("-$i days")) ?>
                            </div>
                            <div class="aspect-square rounded-md flex items-center justify-center text-xs
                                <?= $isActive ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-400' ?> 
                                <?= $isToday ? 'ring-2 ring-orange-300' : '' ?>">
                                <?= date('j', strtotime("-$i days")) ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            
            <!-- Coins Card -->
            <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-yellow-500 transform transition-transform hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                        <i class="fas fa-coins text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-yellow-500">Wild Coins</p>
                        <div class="flex items-end">
                            <p class="text-2xl font-bold text-gray-800">
                                <?= $coinsBalance ?>
                            </p>
                            <p class="text-lg text-gray-600 ml-1">coins</p>
                        </div>
                    </div>
                </div>
                <!-- Coin Interactions -->
                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-500">Available to spend</div>
                    <a href="<?= $baseUrl ?>/shop" class="text-yellow-500 hover:text-yellow-600 text-sm font-medium flex items-center">
                        <span>Shop</span>
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
            
            <!-- Conservation Impact Card -->
            <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-green-500 transform transition-transform hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                        <i class="fas fa-leaf text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-green-500">Conservation Impact</p>
                        <div class="flex items-end">
                            <p class="text-2xl font-bold text-gray-800">
                                <?= isset($conservationStats['trees_planted']) ? $conservationStats['trees_planted'] : 0 ?>
                            </p>
                            <p class="text-lg text-gray-600 ml-1">trees</p>
                        </div>
                    </div>
                </div>
                <!-- Conservation Progress -->
                <div class="mt-4">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>Progress to next tree</span>
                        <span>
                            <?= isset($conservationStats['progress']) ? $conservationStats['progress'] : 0 ?>%
                        </span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: <?= isset($conservationStats['progress']) ? $conservationStats['progress'] : 0 ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Dashboard Tabs -->
        <div class="mb-6" x-data="{ activeTab: 'activity' }">
            <div class="bg-white rounded-xl shadow-md">
                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-200">
                    <button @click="activeTab = 'activity'" :class="{ 'border-green-500 text-green-600': activeTab === 'activity', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'activity' }" class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
                        <i class="fas fa-chart-line mr-2"></i>Activity
                    </button>
                    <button @click="activeTab = 'creatures'" :class="{ 'border-green-500 text-green-600': activeTab === 'creatures', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'creatures' }" class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
                        <i class="fas fa-dragon mr-2"></i>Creatures
                    </button>
                    <button @click="activeTab = 'habitats'" :class="{ 'border-green-500 text-green-600': activeTab === 'habitats', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'habitats' }" class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
                        <i class="fas fa-tree mr-2"></i>Habitats
                    </button>
                    <button @click="activeTab = 'achievements'" :class="{ 'border-green-500 text-green-600': activeTab === 'achievements', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'achievements' }" class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
                        <i class="fas fa-trophy mr-2"></i>Achievements
                    </button>
                </div>
                
                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Activity Tab -->
                    <div x-show="activeTab === 'activity'" class="space-y-6">
                        <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">
                            <!-- Focus Time Chart -->
                            <div class="w-full md:w-2/3 bg-white rounded-lg border border-gray-100 p-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Focus Trends</h3>
                                    <div class="flex space-x-2">
                                        <button class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-600 focus:outline-none">Week</button>
                                        <button class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 focus:outline-none">Month</button>
                                        <button class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 focus:outline-none">Year</button>
                                    </div>
                                </div>
                                <div class="h-64">
                                    <canvas id="weeklyFocusChart"></canvas>
                                </div>
                            </div>
                            
                            <!-- Recent Sessions -->
                            <div class="w-full md:w-1/3 bg-white rounded-lg border border-gray-100 p-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Recent Sessions</h3>
                                    <a href="<?= $baseUrl ?>/focus/history" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                        View All
                                    </a>
                                </div>
                                
                                <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                                    <?php if (empty($recentSessions)): ?>
                                        <div class="text-center py-6 text-gray-500">
                                            <i class="fas fa-history text-gray-300 text-3xl mb-2"></i>
                                            <p>No recent sessions</p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach(array_slice($recentSessions, 0, 5) as $session): ?>
                                            <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                                                <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-100 text-blue-600 mr-3">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-800 truncate">
                                                        <?= $session['duration_minutes'] ?> min focus session
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        <?= date('M j, g:i A', strtotime($session['start_time'])) ?>
                                                    </p>
                                                </div>
                                                <div>
                                                    <?php if ($session['focus_score']): ?>
                                                        <div class="px-2 py-0.5 text-xs font-medium rounded-full 
                                                            <?php
                                                            $score = $session['focus_score'];
                                                            if ($score >= 80) echo 'bg-green-100 text-green-800';
                                                            else if ($score >= 60) echo 'bg-blue-100 text-blue-800';
                                                            else if ($score >= 40) echo 'bg-yellow-100 text-yellow-800';
                                                            else echo 'bg-red-100 text-red-800';
                                                            ?>">
                                                            <?= $score ?>%
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Creatures Tab -->
                    <div x-show="activeTab === 'creatures'" class="space-y-6">
                        <!-- Creature Collection Stats -->
                        <div class="flex flex-wrap -mx-2 mb-4">
                            <div class="w-full sm:w-1/5 px-2 mb-4">
                                <div class="rounded-lg p-4 text-center border border-gray-200 bg-gray-50">
                                    <h4 class="font-semibold text-lg text-gray-800">All Creatures</h4>
                                    <p class="text-3xl font-bold text-green-600"><?= count($creatures) ?></p>
                                </div>
                            </div>
                            <div class="w-full sm:w-1/5 px-2 mb-4">
                                <div class="rounded-lg p-4 text-center border border-gray-200">
                                    <h4 class="font-semibold text-sm text-gray-600">Eggs</h4>
                                    <p class="text-2xl font-bold text-yellow-600"><?= isset($organized['eggs']) ? count($organized['eggs']) : 0 ?></p>
                                </div>
                            </div>
                            <div class="w-full sm:w-1/5 px-2 mb-4">
                                <div class="rounded-lg p-4 text-center border border-gray-200">
                                    <h4 class="font-semibold text-sm text-gray-600">Babies</h4>
                                    <p class="text-2xl font-bold text-blue-600"><?= isset($organized['babies']) ? count($organized['babies']) : 0 ?></p>
                                </div>
                            </div>
                            <div class="w-full sm:w-1/5 px-2 mb-4">
                                <div class="rounded-lg p-4 text-center border border-gray-200">
                                    <h4 class="font-semibold text-sm text-gray-600">Adults</h4>
                                    <p class="text-2xl font-bold text-purple-600"><?= isset($organized['adults']) ? count($organized['adults']) : 0 ?></p>
                                </div>
                            </div>
                            <div class="w-full sm:w-1/5 px-2 mb-4">
                                <div class="rounded-lg p-4 text-center border border-gray-200">
                                    <h4 class="font-semibold text-sm text-gray-600">Mythicals</h4>
                                    <p class="text-2xl font-bold text-red-600"><?= isset($organized['mythicals']) ? count($organized['mythicals']) : 0 ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Creature Gallery -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-800">My Creatures</h3>
                                <a href="<?= $baseUrl ?>/creatures" class="text-green-600 hover:text-green-700 text-sm font-medium flex items-center">
                                    <span>View All</span>
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            
                            <?php if (empty($creatures)): ?>
                                <div class="bg-gray-50 rounded-lg p-8 text-center">
                                    <div class="w-16 h-16 mx-auto bg-gray-200 rounded-full flex items-center justify-center text-gray-400 mb-4">
                                        <i class="fas fa-dragon text-2xl"></i>
                                    </div>
                                    <h3 class="text-gray-700 font-medium mb-2">No creatures yet!</h3>
                                    <p class="text-gray-500 mb-4">Complete focus sessions to hatch your first creature.</p>
                                    <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-4 py-2 bg-green-600 text-sm text-white rounded-md hover:bg-green-700">
                                        Start Focusing
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                    <?php foreach (array_slice($creatures, 0, 10) as $creature): ?>
                                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden transform transition hover:shadow-md hover:-translate-y-1">
                                            <div class="h-24 flex items-center justify-center p-2 bg-<?= $creature['habitat_type'] ?? 'green' ?>-50">
                                                <?php if ($creature['stage'] === 'egg'): ?>
                                                    <i class="fas fa-egg text-<?= $creature['habitat_type'] ?? 'green' ?>-400 text-4xl"></i>
                                                <?php else: ?>
                                                    <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-20 w-20 object-contain">
                                                <?php endif; ?>
                                            </div>
                                            <div class="p-2 text-center">
                                                <h4 class="font-medium text-sm truncate" title="<?= htmlspecialchars($creature['name'] ?? 'Mystery Creature') ?>">
                                                    <?= htmlspecialchars($creature['name'] ?? 'Mystery Creature') ?>
                                                </h4>
                                                <p class="text-xs text-gray-500 capitalize"><?= $creature['stage'] ?></p>
                                                
                                                <?php if ($creature['stage'] !== 'mythical'): ?>
                                                    <div class="mt-1">
                                                        <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                                                            <?php 
                                                            // Simple growth calculation for display
                                                            $growthPercentage = 0;
                                                            if ($creature['stage'] === 'egg') {
                                                                $growthPercentage = min(100, ($creature['growth_progress'] / 100) * 100);
                                                            } else {
                                                                $growthPercentage = min(100, ($creature['growth_progress'] / 200) * 100);
                                                            }
                                                            ?>
                                                            <div class="h-full bg-<?= $creature['habitat_type'] ?? 'green' ?>-400 rounded-full" style="width: <?= $growthPercentage ?>%"></div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <a href="<?= $baseUrl ?>/creatures/view/<?= $creature['id'] ?>" class="block text-xs text-center py-1 bg-gray-50 hover:bg-gray-100 text-gray-600 transition-colors">
                                                View Details
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <?php if (count($creatures) > 10): ?>
                                        <div class="bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center">
                                            <a href="<?= $baseUrl ?>/creatures" class="text-green-600 hover:text-green-700 p-4 text-center">
                                                <i class="fas fa-plus-circle text-2xl mb-2"></i>
                                                <p class="text-sm">View <?= count($creatures) - 10 ?> more</p>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Habitats Tab -->
                    <div x-show="activeTab === 'habitats'">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-800">My Habitats</h3>
                                <a href="<?= $baseUrl ?>/habitats" class="text-green-600 hover:text-green-700 text-sm font-medium flex items-center">
                                    <span>View All</span>
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            
                            <?php if (empty($habitats)): ?>
                                <div class="bg-gray-50 rounded-lg p-8 text-center">
                                    <div class="w-16 h-16 mx-auto bg-gray-200 rounded-full flex items-center justify-center text-gray-400 mb-4">
                                        <i class="fas fa-tree text-2xl"></i>
                                    </div>
                                    <h3 class="text-gray-700 font-medium mb-2">No habitats created yet!</h3>
                                    <p class="text-gray-500 mb-4">Create your first habitat to house your creatures.</p>
                                    <a href="<?= $baseUrl ?>/habitats/create" class="inline-flex items-center px-4 py-2 bg-green-600 text-sm text-white rounded-md hover:bg-green-700">
                                        Create Habitat
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <?php foreach ($habitats as $habitat): ?>
                                        <div class="relative overflow-hidden rounded-xl shadow-md border border-gray-100 group transition-all hover:shadow-lg">
                                            <!-- Habitat Background -->
                                            <div class="h-40 bg-gradient-to-br 
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
                                                ?> p-4 relative">
                                                <!-- Habitat Pattern Overlay -->
                                                <div class="absolute inset-0 opacity-10 bg-<?= $habitat['type'] ?>-pattern"></div>
                                                
                                                <!-- Habitat Creatures Preview -->
                                                <div class="absolute bottom-0 right-0 p-4 flex items-center space-x-1">
                                                    <?php 
                                                    $creatureCount = isset($habitat['creature_count']) ? $habitat['creature_count'] : 0;
                                                    if ($creatureCount > 0): 
                                                    ?>
                                                        <div class="flex -space-x-2">
                                                            <?php for ($i = 0; $i < min(3, $creatureCount); $i++): ?>
                                                                <div class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-<?= $habitat['type'] ?>-500">
                                                                    <i class="fas fa-dragon text-sm"></i>
                                                                </div>
                                                            <?php endfor; ?>
                                                            
                                                            <?php if ($creatureCount > 3): ?>
                                                                <div class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-<?= $habitat['type'] ?>-500">
                                                                    <span class="text-xs font-medium">+<?= $creatureCount - 3 ?></span>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <!-- Habitat Type Badge -->
                                                <div class="absolute top-2 left-2">
                                                    <div class="px-2 py-1 rounded-full bg-white bg-opacity-80 text-xs font-medium text-<?= $habitat['type'] ?>-600 capitalize">
                                                        <?= $habitat['type'] ?> Habitat
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Habitat Info -->
                                            <div class="p-4 bg-white">
                                                <div class="flex justify-between items-center">
                                                    <h4 class="font-medium text-gray-800 capitalize"><?= $habitat['type'] ?> Haven</h4>
                                                    <div class="px-2 py-0.5 bg-gray-100 rounded-full text-xs text-gray-700">
                                                        Level <?= $habitat['level'] ?>
                                                    </div>
                                                </div>
                                                
                                                <!-- Habitat Stats -->
                                                <div class="grid grid-cols-2 gap-2 mt-3">
                                                    <div class="bg-gray-50 p-2 rounded">
                                                        <p class="text-xs text-gray-500">Creatures</p>
                                                        <p class="font-medium"><?= $habitat['creature_count'] ?? 0 ?></p>
                                                    </div>
                                                    <div class="bg-gray-50 p-2 rounded">
                                                        <p class="text-xs text-gray-500">Expansion</p>
                                                        <p class="font-medium"><?= $habitat['expansion_level'] ?? 1 ?>/5</p>
                                                    </div>
                                                </div>
                                                
                                                <!-- View Button -->
                                                <a href="<?= $baseUrl ?>/habitats/view/<?= $habitat['id'] ?>" class="block w-full text-center py-2 mt-3 text-sm font-medium text-<?= $habitat['type'] ?>-600 hover:text-<?= $habitat['type'] ?>-800 transition-colors">
                                                    Visit Habitat
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Achievements Tab -->
                    <div x-show="activeTab === 'achievements'">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-800">My Achievements</h3>
                                <div class="text-sm text-gray-500">
                                    <span class="font-medium text-green-600">0</span> / 24 completed
                                </div>
                            </div>
                            
                            <!-- Achievement Categories -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Focus Category -->
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                    <div class="p-4 bg-blue-50 border-b border-gray-200">
                                        <h4 class="font-medium flex items-center">
                                            <i class="fas fa-clock text-blue-500 mr-2"></i>
                                            Focus Achievements
                                        </h4>
                                    </div>
                                    <div class="p-4 space-y-3">
                                        <div class="flex items-center p-2 rounded border border-gray-100 bg-gray-50">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 mr-3">
                                                <i class="fas fa-hourglass text-sm"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800">First Timer</p>
                                                <p class="text-xs text-gray-500">Complete your first focus session</p>
                                            </div>
                                            <div class="h-5 w-5 rounded-full border border-gray-300"></div>
                                        </div>
                                        <div class="flex items-center p-2 rounded border border-gray-100">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 mr-3">
                                                <i class="fas fa-hourglass-half text-sm"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800">Focus Apprentice</p>
                                                <p class="text-xs text-gray-500">Complete 10 focus sessions</p>
                                            </div>
                                            <div class="h-5 w-5 rounded-full bg-blue-500 flex items-center justify-center">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                        </div>
                                        <div class="flex items-center p-2 rounded border border-gray-100 bg-gray-50">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 mr-3">
                                                <i class="fas fa-hourglass-end text-sm"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800">Focus Master</p>
                                                <p class="text-xs text-gray-500">Complete 100 focus sessions</p>
                                                <div class="mt-1 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-blue-500" style="width: 32%"></div>
                                                </div>
                                            </div>
                                            <div class="h-5 w-5 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 text-xs">
                                                32%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Creature Category -->
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                    <div class="p-4 bg-purple-50 border-b border-gray-200">
                                        <h4 class="font-medium flex items-center">
                                            <i class="fas fa-dragon text-purple-500 mr-2"></i>
                                            Creature Achievements
                                        </h4>
                                    </div>
                                    <div class="p-4 space-y-3">
                                        <!-- Sample achievement items -->
                                        <div class="flex items-center p-2 rounded border border-gray-100">
                                            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-500 mr-3">
                                                <i class="fas fa-egg text-sm"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800">First Hatch</p>
                                                <p class="text-xs text-gray-500">Hatch your first creature</p>
                                            </div>
                                            <div class="h-5 w-5 rounded-full bg-purple-500 flex items-center justify-center">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                        </div>
                                        <!-- More achievements would be here -->
                                    </div>
                                </div>
                                
                                <!-- Conservation Category -->
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                    <div class="p-4 bg-green-50 border-b border-gray-200">
                                        <h4 class="font-medium flex items-center">
                                            <i class="fas fa-leaf text-green-500 mr-2"></i>
                                            Conservation Achievements
                                        </h4>
                                    </div>
                                    <div class="p-4 space-y-3">
                                        <!-- Sample achievement items -->
                                        <div class="flex items-center p-2 rounded border border-gray-100 bg-gray-50">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 mr-3">
                                                <i class="fas fa-tree text-sm"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800">First Tree</p>
                                                <p class="text-xs text-gray-500">Help plant your first tree</p>
                                            </div>
                                            <div class="h-5 w-5 rounded-full border border-gray-300"></div>
                                        </div>
                                        <!-- More achievements would be here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Conservation Impact Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="bg-green-700 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Your Conservation Impact</h2>
            </div>
            
            <div class="p-6">
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-1/3 px-2 mb-4">
                        <div class="group bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 text-center hover:shadow-md transition-all relative overflow-hidden">
                            <div class="absolute inset-0 bg-green-200 transform scale-y-0 origin-bottom transition-transform group-hover:scale-y-100 z-0"></div>
                            <div class="relative z-10">
                                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center text-green-600 mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-tree text-2xl"></i>
                                </div>
                                <h4 class="text-2xl font-semibold text-gray-800 group-hover:text-gray-900">0</h4>
                                <p class="text-gray-600 group-hover:text-gray-700">Trees Planted</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-1/3 px-2 mb-4">
                        <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 text-center hover:shadow-md transition-all relative overflow-hidden">
                            <div class="absolute inset-0 bg-blue-200 transform scale-y-0 origin-bottom transition-transform group-hover:scale-y-100 z-0"></div>
                            <div class="relative z-10">
                                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center text-blue-600 mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-paw text-2xl"></i>
                                </div>
                                <h4 class="text-2xl font-semibold text-gray-800 group-hover:text-gray-900">0</h4>
                                <p class="text-gray-600 group-hover:text-gray-700">Wildlife Protected</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-1/3 px-2 mb-4">
                        <div class="group bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg p-6 text-center hover:shadow-md transition-all relative overflow-hidden">
                            <div class="absolute inset-0 bg-amber-200 transform scale-y-0 origin-bottom transition-transform group-hover:scale-y-100 z-0"></div>
                            <div class="relative z-10">
                                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center text-amber-600 mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-hand-holding-heart text-2xl"></i>
                                </div>
                                <h4 class="text-2xl font-semibold text-gray-800 group-hover:text-gray-900">0</h4>
                                <p class="text-gray-600 group-hover:text-gray-700">Donations Made</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <p class="text-gray-600 mb-4">Keep focusing to increase your real-world conservation impact!</p>
                    <a href="<?= $baseUrl ?>/conservation" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-md hover:from-green-700 hover:to-green-800 transition-all shadow-sm hover:shadow">
                        <i class="fas fa-leaf mr-2"></i>
                        Learn More About Conservation
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Alpine.js for tab functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Charts Initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Focus Time Mini Chart
    const focusTimeCtx = document.getElementById('focusTimeChart').getContext('2d');
    
    new Chart(focusTimeCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Focus Minutes',
                data: [30, 45, 60, 25, 70, 50, 45],
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            },
            scales: {
                x: {
                    display: false
                },
                y: {
                    display: false,
                    beginAtZero: true
                }
            },
            elements: {
                line: {
                    cubicInterpolationMode: 'monotone'
                }
            }
        }
    });
    
    // Weekly Focus Chart
    const weeklyFocusCtx = document.getElementById('weeklyFocusChart').getContext('2d');
    
    new Chart(weeklyFocusCtx, {
        type: 'bar',
        data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [
                {
                    label: 'Duration (minutes)',
                    data: [65, 90, 120, 75, 45, 80, 95],
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderRadius: 4
                },
                {
                    label: 'Focus Score',
                    data: [85, 92, 88, 75, 80, 87, 91],
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    borderColor: 'rgba(99, 102, 241, 0.8)',
                    type: 'line',
                    yAxisID: 'y1',
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(99, 102, 241, 1)'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#111827',
                    bodyColor: '#374151',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    cornerRadius: 8,
                    boxPadding: 4,
                    usePointStyle: true,
                    callbacks: {
                        labelColor: function(context) {
                            const color = context.dataset.backgroundColor;
                            return {
                                backgroundColor: typeof color === 'string' ? color : color[context.dataIndex]
                            };
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                y: {
                    position: 'left',
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    },
                    title: {
                        display: true,
                        text: 'Duration (minutes)',
                        color: '#10B981',
                        font: {
                            size: 12,
                            weight: 'normal'
                        }
                    }
                },
                y1: {
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    },
                    min: 0,
                    max: 100,
                    ticks: {
                        font: {
                            size: 12
                        },
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Focus Score',
                        color: '#6366F1',
                        font: {
                            size: 12,
                            weight: 'normal'
                        }
                    }
                }
            }
        }
    });
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>