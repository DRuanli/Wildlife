<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Welcome Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars("Welcome, {$user['username']}!") ?></h1>
                <p class="text-gray-600">Your daily focus journey awaits.</p>
            </div>
            
            <div class="flex space-x-2">
                <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fas fa-clock mr-2"></i> Start Focus Session
                </a>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Focus Time Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                    <i class="fas fa-hourglass-half text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Focus Time</p>
                    <p class="text-xl font-bold text-gray-800">
                        <?= floor($totalFocusTime / 60) ?> hours <?= $totalFocusTime % 60 ?> mins
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Streak Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-orange-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-500 mr-4">
                    <i class="fas fa-fire text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Current Streak</p>
                    <p class="text-xl font-bold text-gray-800">
                        <?= $focusStreak ?> day<?= $focusStreak !== 1 ? 's' : '' ?>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Coins Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                    <i class="fas fa-coins text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Wild Coins</p>
                    <p class="text-xl font-bold text-gray-800">
                        <?= $coinsBalance ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Creatures & Habitats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- My Creatures -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-green-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">My Creatures</h2>
                <a href="<?= $baseUrl ?>/creatures" class="text-sm hover:underline">View All</a>
            </div>
            
            <?php if (empty($creatures)): ?>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                    <i class="fas fa-dragon text-2xl"></i>
                </div>
                <h3 class="text-gray-700 font-medium mb-2">No creatures yet!</h3>
                <p class="text-gray-500 mb-4">Complete focus sessions to hatch your first creature.</p>
                <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-4 py-2 bg-green-600 text-sm text-white rounded-md hover:bg-green-700">
                    Start Focusing
                </a>
            </div>
            <?php else: ?>
            <div class="p-4 grid grid-cols-2 sm:grid-cols-3 gap-3">
                <?php foreach (array_slice($creatures, 0, 3) as $creature): ?>
                <!-- Creature Card -->
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <div class="h-20 w-20 mx-auto mb-2 bg-gray-200 rounded-full flex items-center justify-center">
                        <?php if ($creature['stage'] === 'egg'): ?>
                        <i class="fas fa-egg text-gray-400 text-2xl"></i>
                        <?php else: ?>
                        <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-16 w-16">
                        <?php endif; ?>
                    </div>
                    <h4 class="font-medium text-sm"><?= htmlspecialchars($creature['name'] ?? 'Mystery Creature') ?></h4>
                    <p class="text-xs text-gray-500 capitalize"><?= $creature['stage'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- My Habitats -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">My Habitats</h2>
                <a href="<?= $baseUrl ?>/habitats" class="text-sm hover:underline">View All</a>
            </div>
            
            <?php if (empty($habitats)): ?>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                    <i class="fas fa-tree text-2xl"></i>
                </div>
                <h3 class="text-gray-700 font-medium mb-2">No habitats created yet!</h3>
                <p class="text-gray-500 mb-4">Create your first habitat to house your creatures.</p>
                <a href="<?= $baseUrl ?>/habitats/create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-sm text-white rounded-md hover:bg-blue-700">
                    Create Habitat
                </a>
            </div>
            <?php else: ?>
            <div class="p-4 grid grid-cols-2 gap-3">
                <?php foreach (array_slice($habitats, 0, 2) as $habitat): ?>
                <!-- Habitat Card -->
                <div class="relative bg-gradient-to-br 
                    <?php
                    switch ($habitat['type']) {
                        case 'forest': echo 'from-green-100 to-green-200 border-green-300'; break;
                        case 'ocean': echo 'from-blue-100 to-blue-200 border-blue-300'; break;
                        case 'mountain': echo 'from-red-100 to-red-200 border-red-300'; break;
                        case 'sky': echo 'from-cyan-100 to-cyan-200 border-cyan-300'; break;
                        case 'cosmic': echo 'from-purple-100 to-purple-200 border-purple-300'; break;
                        case 'enchanted': echo 'from-pink-100 to-pink-200 border-pink-300'; break;
                        default: echo 'from-gray-100 to-gray-200 border-gray-300';
                    }
                    ?>
                    rounded-lg p-4 border">
                    <h4 class="font-medium text-gray-800 capitalize"><?= $habitat['type'] ?> Habitat</h4>
                    <p class="text-sm text-gray-600">Level <?= $habitat['level'] ?></p>
                    <div class="mt-2 flex items-center text-xs text-gray-500">
                        <i class="fas fa-paw mr-1"></i>
                        <span>Contains <?= $habitat['creature_count'] ?? 0 ?> creatures</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Recent Focus Sessions -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="bg-purple-600 text-white px-6 py-4">
            <h2 class="text-xl font-bold">Recent Focus Sessions</h2>
        </div>
        
        <?php if (empty($recentSessions)): ?>
        <div class="p-6 text-center">
            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                <i class="fas fa-history text-2xl"></i>
            </div>
            <h3 class="text-gray-700 font-medium mb-2">No focus sessions yet!</h3>
            <p class="text-gray-500 mb-4">Start focusing to build your wildlife haven.</p>
            <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-4 py-2 bg-purple-600 text-sm text-white rounded-md hover:bg-purple-700">
                Start First Session
            </a>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Focus Score</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coins Earned</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($recentSessions as $session): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= date('M j, Y - g:i A', strtotime($session['start_time'])) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= $session['duration_minutes'] ?> mins
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-2 w-24 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full 
                                        <?php
                                        $score = $session['focus_score'];
                                        if ($score >= 80) echo 'bg-green-500';
                                        else if ($score >= 60) echo 'bg-blue-500';
                                        else if ($score >= 40) echo 'bg-yellow-500';
                                        else echo 'bg-red-500';
                                        ?>
                                    " style="width: <?= $score ?>%"></div>
                                </div>
                                <span class="ml-2 text-sm text-gray-600"><?= $score ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= $session['coins_earned'] ?> <i class="fas fa-coins text-yellow-500 ml-1"></i>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Conservation Impact -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-green-700 text-white px-6 py-4">
            <h2 class="text-xl font-bold">Your Conservation Impact</h2>
        </div>
        
        <div class="p-6">
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/3 px-2 mb-4">
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <div class="w-12 h-12 mx-auto bg-green-100 rounded-full flex items-center justify-center text-green-600 mb-3">
                            <i class="fas fa-tree text-xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800">0</h4>
                        <p class="text-sm text-gray-600">Trees Planted</p>
                    </div>
                </div>
                
                <div class="w-full md:w-1/3 px-2 mb-4">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mb-3">
                            <i class="fas fa-paw text-xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800">0</h4>
                        <p class="text-sm text-gray-600">Wildlife Protected</p>
                    </div>
                </div>
                
                <div class="w-full md:w-1/3 px-2 mb-4">
                    <div class="bg-amber-50 rounded-lg p-4 text-center">
                        <div class="w-12 h-12 mx-auto bg-amber-100 rounded-full flex items-center justify-center text-amber-600 mb-3">
                            <i class="fas fa-hand-holding-heart text-xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800">0</h4>
                        <p class="text-sm text-gray-600">Donations Made</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600 mb-4">Keep focusing to increase your real-world conservation impact!</p>
                <a href="<?= $baseUrl ?>/conservation" class="inline-flex items-center px-4 py-2 bg-green-700 text-sm text-white rounded-md hover:bg-green-800">
                    Learn More About Conservation
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>