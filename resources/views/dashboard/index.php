<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Welcome section with user stats -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800 mb-2">Welcome, <?= htmlspecialchars($user['username']) ?></h1>
                <p class="text-gray-600">Here's your focus journey overview</p>
            </div>
            <div class="mt-4 md:mt-0 bg-green-50 rounded-lg px-4 py-2 flex items-center">
                <i class="fas fa-coins text-yellow-500 mr-2"></i>
                <span class="font-medium"><?= $coinsBalance ?> Coins</span>
            </div>
        </div>
    </div>
    
    <!-- Stats overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Focus time -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-lg font-medium text-gray-700 mb-1">Total Focus Time</h2>
                    <p class="text-3xl font-semibold text-gray-800">
                        <?= floor($totalFocusTime / 60) ?><span class="text-lg font-normal text-gray-600">h</span> 
                        <?= $totalFocusTime % 60 ?><span class="text-lg font-normal text-gray-600">m</span>
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-clock text-green-600"></i>
                </div>
            </div>
        </div>
        
        <!-- Focus streak -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-lg font-medium text-gray-700 mb-1">Current Streak</h2>
                    <p class="text-3xl font-semibold text-gray-800">
                        <?= $focusStreak ?><span class="text-lg font-normal text-gray-600"> days</span>
                    </p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fas fa-fire text-orange-600"></i>
                </div>
            </div>
        </div>
        
        <!-- Creatures collected -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-lg font-medium text-gray-700 mb-1">Creatures</h2>
                    <p class="text-3xl font-semibold text-gray-800">
                        <?= count($creatures) ?><span class="text-lg font-normal text-gray-600"> collected</span>
                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-dragon text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Two-column layout for desktop -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Focus activity and recent sessions -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Focus Sessions</h2>
                
                <?php if (empty($recentSessions)): ?>
                <div class="py-8 text-center">
                    <div class="mb-3 text-gray-400">
                        <i class="fas fa-hourglass-start text-4xl"></i>
                    </div>
                    <p class="text-gray-600 mb-4">You haven't completed any focus sessions yet.</p>
                    <a href="<?= $baseUrl ?>/focus" class="inline-block px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        Start Focusing
                    </a>
                </div>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Focus Score</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coins</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($recentSessions as $session): ?>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <?= date('M j, Y g:i A', strtotime($session['start_time'])) ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <?= $session['duration_minutes'] ?> min
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-600 h-2.5 rounded-full" style="width: <?= $session['focus_score'] ?>%"></div>
                                        </div>
                                        <span class="ml-2 text-gray-700"><?= $session['focus_score'] ?>%</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <?= $session['coins_earned'] ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Creatures section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Your Creatures</h2>
                    <a href="<?= url('creatures') ?>" class="text-green-600 hover:text-green-700 text-sm">View All</a>
                </div>
                
                <?php if (empty($creatures)): ?>
                <div class="py-8 text-center">
                    <div class="mb-3 text-gray-400">
                        <i class="fas fa-egg text-4xl"></i>
                    </div>
                    <p class="text-gray-600 mb-4">Complete focus sessions to hatch your first creature!</p>
                    <a href="<?= url('focus') ?>" class="inline-block px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        Start Focusing
                    </a>
                </div>
                <?php else: ?>
                <div class="space-y-4">
                    <?php foreach (array_slice($creatures, 0, 3) as $creature): ?>
                    <div class="flex items-center p-3 border border-gray-100 rounded-lg hover:bg-green-50 transition">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-<?= $creature['stage'] === 'egg' ? 'egg' : 'dragon' ?> text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800"><?= htmlspecialchars($creature['name'] ?? 'Unnamed') ?></h3>
                            <p class="text-sm text-gray-600 capitalize"><?= $creature['stage'] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Habitats section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Your Habitats</h2>
                    <a href="<?= $baseUrl ?>/habitats" class="text-green-600 hover:text-green-700 text-sm">View All</a>
                </div>
                
                <?php if (empty($habitats)): ?>
                <div class="py-8 text-center">
                    <div class="mb-3 text-gray-400">
                        <i class="fas fa-tree text-4xl"></i>
                    </div>
                    <p class="text-gray-600">You haven't unlocked any habitats yet.</p>
                </div>
                <?php else: ?>
                <div class="space-y-4">
                    <?php foreach (array_slice($habitats, 0, 3) as $habitat): ?>
                    <div class="flex items-center p-3 border border-gray-100 rounded-lg hover:bg-green-50 transition">
                        <div class="w-12 h-12 bg-<?= $habitat['type'] ?>-100 rounded-full flex items-center justify-center mr-4">
                            <?php 
                            $icon = 'tree';
                            switch($habitat['type']) {
                                case 'ocean': $icon = 'water'; break;
                                case 'mountain': $icon = 'mountain'; break;
                                case 'sky': $icon = 'cloud'; break;
                                case 'cosmic': $icon = 'star'; break;
                                case 'enchanted': $icon = 'magic'; break;
                            }
                            ?>
                            <i class="fas fa-<?= $icon ?> text-<?= $habitat['type'] ?>-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800 capitalize"><?= $habitat['type'] ?> Habitat</h3>
                            <p class="text-sm text-gray-600">Level <?= $habitat['level'] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>