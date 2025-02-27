<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-green-50 to-white pb-12">
    <!-- Focus Hero Banner -->
    <div class="relative overflow-hidden bg-indigo-600 text-white">
        <div class="absolute opacity-10 left-0 top-0 w-full h-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800" class="w-full h-full">
                <g fill="none" stroke="currentColor" stroke-width="1">
                    <path d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63" />
                    <path d="M-31 229L237 261 390 382 731 737M520 660L309 538 295 764 40 599 238 382 102 382 126.5 79.5 128 0M520 660L295 764" />
                    <path d="M520 660L-197 493 102 382 128 0M1204 546L1204 270M1204 270L1024 160M1204 270L1204 30" />
                </g>
            </svg>
        </div>
        <div class="container mx-auto px-4 py-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Deep Focus Engine</h1>
                    <p class="text-indigo-100 text-lg">Focus your mind, grow your creatures, make real impact</p>
                </div>
                <div class="flex space-x-2">
                    <a href="<?= $baseUrl ?>/focus/history" class="px-4 py-2 bg-indigo-700 hover:bg-indigo-800 rounded-lg text-sm font-medium transition-colors flex items-center">
                        <i class="fas fa-history mr-2"></i> History
                    </a>
                    <a href="<?= $baseUrl ?>/focus/stats" class="px-4 py-2 bg-indigo-700 hover:bg-indigo-800 rounded-lg text-sm font-medium transition-colors flex items-center">
                        <i class="fas fa-chart-line mr-2"></i> Statistics
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column: Timer and Controls -->
            <div class="w-full lg:w-8/12">
                <!-- Timer Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 relative">
                    <?php if ($activeSession): ?>
                        <!-- Active Session Timer -->
                        <div id="active-session" data-session-id="<?= $activeSession['id'] ?>" data-duration="<?= $activeSession['duration_minutes'] ?>" data-start-time="<?= $activeSession['start_time'] ?>">
                            <!-- Progress Indicator -->
                            <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 h-1 absolute top-0 left-0 right-0" id="progress-bar" style="width: 0%;"></div>
                            
                            <div class="p-6 pb-4">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-xl font-bold text-gray-800">Focus Session in Progress</h3>
                                    <div class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                        <i class="fas fa-clock-rotate-left mr-1.5"></i>
                                        <span>Started at <?= date('g:i A', strtotime($activeSession['start_time'])) ?></span>
                                    </div>
                                </div>
                                
                                <!-- Timer Display -->
                                <div class="flex flex-col items-center justify-center my-10">
                                    <div class="relative">
                                        <svg class="w-48 h-48" viewBox="0 0 100 100">
                                            <!-- Timer Background -->
                                            <circle cx="50" cy="50" r="45" fill="none" stroke="#f3f4f6" stroke-width="8" />
                                            <!-- Timer Progress - Will be updated by JS -->
                                            <circle cx="50" cy="50" r="45" fill="none" stroke="#6366f1" stroke-width="8" 
                                                stroke-linecap="round" stroke-dasharray="283" stroke-dashoffset="283" 
                                                transform="rotate(-90 50 50)" id="timer-circle" />
                                        </svg>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-5xl font-bold text-gray-800 timer-display">25:00</div>
                                                <div class="text-sm text-gray-500 mt-1" id="timer-status">Focusing...</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Focus Score Indicator (updated in real-time) -->
                                    <div class="mt-6 w-full max-w-md">
                                        <div class="flex justify-between text-sm text-gray-700 mb-1">
                                            <span>Focus Score</span>
                                            <span id="focus-score">95%</span>
                                        </div>
                                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full" id="focus-score-bar" style="width: 95%"></div>
                                        </div>
                                        <div class="mt-1 flex justify-between text-xs text-gray-500">
                                            <span>Distracted</span>
                                            <span>Focused</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Session Controls -->
                                <div class="flex justify-center space-x-4 mb-4">
                                    <button id="pause-btn" class="inline-flex items-center px-4 py-2 rounded-lg border border-indigo-300 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors">
                                        <i class="fas fa-pause mr-2"></i> Pause
                                    </button>
                                    <button id="complete-btn" class="inline-flex items-center px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition-colors">
                                        <i class="fas fa-check mr-2"></i> Complete
                                    </button>
                                    <button id="cancel-btn" class="inline-flex items-center px-4 py-2 rounded-lg border border-red-300 bg-red-50 text-red-700 hover:bg-red-100 transition-colors">
                                        <i class="fas fa-times mr-2"></i> Cancel
                                    </button>
                                </div>
                            </div>
                            
                            <?php if (!empty($activeSession['creature_id'])): ?>
                                <?php 
                                    $activeCreature = null;
                                    foreach ($creatures as $creature) {
                                        if ($creature['id'] == $activeSession['creature_id']) {
                                            $activeCreature = $creature;
                                            break;
                                        }
                                    }
                                ?>
                                <?php if ($activeCreature): ?>
                                    <!-- Creature Growth Progress -->
                                    <div class="bg-indigo-50 border-t border-indigo-100 p-4 flex items-center">
                                        <div class="w-16 h-16 overflow-hidden rounded-full bg-white flex items-center justify-center border-2 border-indigo-200 mr-4">
                                            <?php if ($activeCreature['stage'] === 'egg'): ?>
                                                <div class="animate-pulse">
                                                    <i class="fas fa-egg text-<?= $activeCreature['habitat_type'] ?? 'indigo' ?>-400 text-2xl"></i>
                                                </div>
                                            <?php else: ?>
                                                <img src="<?= $baseUrl ?>/images/creatures/<?= $activeCreature['species_id'] ?>_<?= $activeCreature['stage'] ?>.png" alt="<?= $activeCreature['name'] ?>" class="h-12 w-12 object-contain">
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex justify-between items-center mb-1">
                                                <h4 class="font-medium text-gray-800"><?= htmlspecialchars($activeCreature['name'] ?? 'Your creature') ?></h4>
                                                <span class="text-xs font-medium text-indigo-600 capitalize"><?= $activeCreature['stage'] ?> <?= $activeCreature['species_name'] ?? '' ?></span>
                                            </div>
                                            
                                            <!-- Growth Progress Bar -->
                                            <div class="flex-1">
                                                <div class="h-2 bg-indigo-100 rounded-full overflow-hidden">
                                                    <?php 
                                                    // Simple growth calculation for display
                                                    $growthPercentage = 0;
                                                    if ($activeCreature['stage'] === 'egg') {
                                                        $growthPercentage = min(100, ($activeCreature['growth_progress'] / 100) * 100);
                                                    } else {
                                                        $growthPercentage = min(100, ($activeCreature['growth_progress'] / 200) * 100);
                                                    }
                                                    ?>
                                                    <div class="h-full bg-gradient-to-r from-indigo-400 to-indigo-600 rounded-full" style="width: <?= $growthPercentage ?>%"></div>
                                                </div>
                                            </div>
                                            <div class="mt-1 flex justify-between text-xs text-gray-500">
                                                <span>Currently <?= round($growthPercentage) ?>% grown</span>
                                                <span>+1 growth point per 5 mins</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <!-- Start New Session -->
                        <form id="start-session-form" class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">Start a New Focus Session</h3>
                            
                            <!-- Duration Selector -->
                            <div class="mb-6">
                                <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Session Duration</label>
                                <div class="grid grid-cols-3 sm:grid-cols-6 gap-2" id="duration-buttons">
                                    <button type="button" data-value="15" class="duration-btn px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors">
                                        15 min
                                    </button>
                                    <button type="button" data-value="25" class="duration-btn px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors">
                                        25 min
                                    </button>
                                    <button type="button" data-value="30" class="duration-btn px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors">
                                        30 min
                                    </button>
                                    <button type="button" data-value="45" class="duration-btn px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors">
                                        45 min
                                    </button>
                                    <button type="button" data-value="60" class="duration-btn px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors">
                                        60 min
                                    </button>
                                    <button type="button" data-value="custom" class="duration-btn px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors">
                                        Custom
                                    </button>
                                </div>
                                <input type="hidden" id="duration" name="duration" value="25">
                                
                                <!-- Custom Duration (hidden by default) -->
                                <div id="custom-duration-container" class="hidden mt-3">
                                    <div class="flex items-center">
                                        <input type="number" id="custom-duration" min="5" max="120" step="5" value="25" class="w-20 border-gray-300 rounded-lg mr-2">
                                        <span class="text-gray-600">minutes</span>
                                        <button type="button" id="custom-duration-set" class="ml-auto px-3 py-1 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition-colors">
                                            Set
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!empty($creatures)): ?>
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select a Creature to Grow</label>
                                    <p class="text-xs text-gray-500 mb-3">Focus sessions help your creatures grow and evolve</p>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="creature-selection">
                                        <!-- No Creature Option -->
                                        <div class="creature-option group cursor-pointer" data-id="">
                                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:border-indigo-300 hover:shadow-md transition-all">
                                                <div class="h-20 flex items-center justify-center bg-gray-50 group-hover:bg-gray-100 transition-colors">
                                                    <div class="w-12 h-12 rounded-full bg-white shadow flex items-center justify-center">
                                                        <i class="fas fa-times text-gray-400"></i>
                                                    </div>
                                                </div>
                                                <div class="p-3 text-center">
                                                    <h4 class="font-medium text-gray-700 group-hover:text-gray-900">No Creature</h4>
                                                    <p class="text-xs text-gray-500">Focus without growing</p>
                                                </div>
                                            </div>
                                            <input type="radio" name="creature_id" value="" class="hidden">
                                        </div>
                                        
                                        <?php 
                                        // Filter growable creatures (not at maximum level)
                                        $growableCreatures = array_filter($creatures, function($creature) {
                                            return $creature['stage'] !== 'mythical';
                                        });
                                        
                                        foreach ($growableCreatures as $creature): 
                                        ?>
                                            <div class="creature-option group cursor-pointer" data-id="<?= $creature['id'] ?>">
                                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:border-indigo-300 hover:shadow-md transition-all">
                                                    <div class="h-20 flex items-center justify-center bg-<?= $creature['habitat_type'] ?? 'green' ?>-50 group-hover:bg-<?= $creature['habitat_type'] ?? 'green' ?>-100 transition-colors">
                                                        <?php if ($creature['stage'] === 'egg'): ?>
                                                            <div class="group-hover:animate-pulse">
                                                                <i class="fas fa-egg text-<?= $creature['habitat_type'] ?? 'green' ?>-400 text-3xl"></i>
                                                            </div>
                                                        <?php else: ?>
                                                            <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-16 w-16 object-contain">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="p-3 text-center">
                                                        <h4 class="font-medium text-gray-700 group-hover:text-gray-900"><?= htmlspecialchars($creature['name'] ?? 'Unnamed') ?></h4>
                                                        <p class="text-xs text-gray-500 capitalize"><?= $creature['stage'] ?></p>
                                                        
                                                        <!-- Growth Progress -->
                                                        <div class="mt-2 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
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
                                                </div>
                                                <input type="radio" name="creature_id" value="<?= $creature['id'] ?>" class="hidden">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Focus Settings -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between">
                                    <label class="block text-sm font-medium text-gray-700">Focus Settings</label>
                                    <button type="button" id="toggle-settings" class="text-indigo-600 hover:text-indigo-800 text-sm flex items-center">
                                        <span>Advanced</span>
                                        <i class="fas fa-chevron-down ml-1 text-xs" id="settings-icon"></i>
                                    </button>
                                </div>
                                
                                <!-- Basic Settings -->
                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                        <div class="flex items-center">
                                            <i class="fas fa-bell text-indigo-500 mr-3"></i>
                                            <span class="text-sm text-gray-700">Session Bell</span>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" id="sound-enabled" checked>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                        <div class="flex items-center">
                                            <i class="fas fa-stopwatch text-indigo-500 mr-3"></i>
                                            <span class="text-sm text-gray-700">Auto-Start</span>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" id="auto-start">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Advanced Settings (hidden by default) -->
                                <div id="advanced-settings" class="hidden mt-4">
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Break Duration</label>
                                                <select id="break-duration" class="w-full border-gray-300 rounded-lg text-sm">
                                                    <option value="0">No break</option>
                                                    <option value="5" selected>5 minutes</option>
                                                    <option value="10">10 minutes</option>
                                                    <option value="15">15 minutes</option>
                                                </select>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Auto Repeat</label>
                                                <select id="auto-repeat" class="w-full border-gray-300 rounded-lg text-sm">
                                                    <option value="0" selected>Off</option>
                                                    <option value="2">2 sessions</option>
                                                    <option value="4">4 sessions</option>
                                                    <option value="-1">Until cancelled</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Focus Environment</label>
                                            <div class="grid grid-cols-4 gap-2">
                                                <button type="button" class="focus-env-btn py-2 px-3 text-xs border border-gray-300 rounded-lg hover:bg-gray-50 active" data-env="silent">
                                                    <i class="fas fa-volume-xmark block mx-auto mb-1 text-gray-600"></i>
                                                    Silent
                                                </button>
                                                <button type="button" class="focus-env-btn py-2 px-3 text-xs border border-gray-300 rounded-lg hover:bg-gray-50" data-env="nature">
                                                    <i class="fas fa-leaf block mx-auto mb-1 text-gray-600"></i>
                                                    Nature
                                                </button>
                                                <button type="button" class="focus-env-btn py-2 px-3 text-xs border border-gray-300 rounded-lg hover:bg-gray-50" data-env="rain">
                                                    <i class="fas fa-cloud-rain block mx-auto mb-1 text-gray-600"></i>
                                                    Rain
                                                </button>
                                                <button type="button" class="focus-env-btn py-2 px-3 text-xs border border-gray-300 rounded-lg hover:bg-gray-50" data-env="cafe">
                                                    <i class="fas fa-mug-hot block mx-auto mb-1 text-gray-600"></i>
                                                    Café
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Start Button -->
                            <div>
                                <button type="submit" id="start-session-btn" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-medium rounded-lg flex items-center justify-center transition-all">
                                    <i class="fas fa-play-circle mr-2 text-lg"></i>
                                    Start Focus Session
                                </button>
                                
                                <p class="text-center text-sm text-gray-500 mt-3">
                                    <i class="fas fa-lightbulb text-yellow-500 mr-1"></i>
                                    Pro Tip: Stay on the page for the best focus experience
                                </p>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
                
                <!-- Focus Tips Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3">
                        <h3 class="text-lg font-bold text-white">Focus Tips</h3>
                    </div>
                    
                    <div x-data="{ currentTip: 0, tips: [
                        {icon: 'fa-mobile-screen', title: 'Eliminate Distractions', text: 'Put your phone on silent mode or in another room during focus sessions.'},
                        {icon: 'fa-droplet', title: 'Stay Hydrated', text: 'Keep water nearby to stay hydrated during your focus sessions.'},
                        {icon: 'fa-list-check', title: 'Set Clear Goals', text: 'Define what you want to accomplish before starting each focus session.'},
                        {icon: 'fa-brain', title: 'Mindful Breaks', text: 'Use breaks to stretch, breathe deeply, or meditate for better focus.'}
                    ] }" class="p-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 mr-4 shrink-0">
                                <i class="fas" :class="tips[currentTip].icon"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800" x-text="tips[currentTip].title"></h4>
                                <p class="text-gray-600 text-sm mt-1" x-text="tips[currentTip].text"></p>
                            </div>
                        </div>
                        
                        <!-- Tip Navigation -->
                        <div class="flex justify-center mt-4">
                            <template x-for="(tip, index) in tips" :key="index">
                                <button @click="currentTip = index" class="w-2 h-2 rounded-full mx-1 focus:outline-none" 
                                    :class="currentTip === index ? 'bg-amber-500' : 'bg-gray-300'"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Stats and History -->
            <div class="w-full lg:w-4/12">
                <!-- Focus Stats Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-3">
                        <h3 class="text-lg font-bold text-white">Focus Statistics</h3>
                    </div>
                    
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <!-- Today Focus Time -->
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <p class="text-sm text-gray-500">Today</p>
                                <p class="text-xl font-bold text-gray-800">
                                    <?php
                                    // Calculate today's focus time
                                    $todayMinutes = 0;
                                    foreach ($todaySessions as $session) {
                                        if ($session['completed']) {
                                            $todayMinutes += $session['duration_minutes'];
                                        }
                                    }
                                    echo $todayMinutes;
                                    ?>
                                    <span class="text-sm text-gray-600">min</span>
                                </p>
                            </div>
                            
                            <!-- Current Streak -->
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <p class="text-sm text-gray-500">Streak</p>
                                <p class="text-xl font-bold text-gray-800">
                                    <?= $streak_days ?>
                                    <span class="text-sm text-gray-600">days</span>
                                </p>
                            </div>
                            
                            <!-- Total Focus Time -->
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <p class="text-sm text-gray-500">Total Time</p>
                                <p class="text-xl font-bold text-gray-800">
                                    <?= floor($total_focus_time / 60) ?>
                                    <span class="text-sm text-gray-600">hrs</span>
                                </p>
                            </div>
                            
                            <!-- Average Focus Score -->
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <p class="text-sm text-gray-500">Avg. Score</p>
                                <p class="text-xl font-bold text-gray-800">
                                    <?= round($avg_focus_score ?? 0) ?>
                                    <span class="text-sm text-gray-600">%</span>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Mini Weekly Chart -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">This Week</h4>
                            <div class="h-32">
                                <canvas id="weeklyMiniChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Today's Sessions Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-3 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white">Today's Sessions</h3>
                        <span class="text-sm font-medium text-green-100">
                            <?= count($todaySessions) ?> sessions
                        </span>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        <?php if (empty($todaySessions)): ?>
                            <div class="p-6 text-center">
                                <div class="w-12 h-12 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-2">
                                    <i class="fas fa-calendar-day text-lg"></i>
                                </div>
                                <p class="text-gray-500">No sessions completed today</p>
                            </div>
                        <?php else: ?>
                            <div class="max-h-96 overflow-y-auto">
                                <?php foreach (array_reverse($todaySessions) as $index => $session): ?>
                                    <div class="p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3
                                                    <?php if ($session['completed']): ?>
                                                        bg-green-100 text-green-600
                                                    <?php elseif ($session['end_time'] === null): ?>
                                                        bg-blue-100 text-blue-600 animate-pulse
                                                    <?php else: ?>
                                                        bg-red-100 text-red-600
                                                    <?php endif; ?>
                                                ">
                                                    <?php if ($session['end_time'] === null): ?>
                                                        <i class="fas fa-circle-play"></i>
                                                    <?php elseif ($session['completed']): ?>
                                                        <i class="fas fa-check"></i>
                                                    <?php else: ?>
                                                        <i class="fas fa-ban"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-800">
                                                        <?= $session['duration_minutes'] ?> min session
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        <?= date('g:i A', strtotime($session['start_time'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center">
                                                <?php if ($session['completed']): ?>
                                                    <div class="mr-3 text-right">
                                                        <div class="text-sm font-medium text-yellow-600">
                                                            <?= $session['coins_earned'] ?? 0 ?> <i class="fas fa-coins text-xs"></i>
                                                        </div>
                                                        <div class="text-xs font-medium 
                                                            <?php
                                                            $score = $session['focus_score'];
                                                            if ($score >= 80) echo 'text-green-600';
                                                            else if ($score >= 60) echo 'text-blue-600';
                                                            else if ($score >= 40) echo 'text-yellow-600';
                                                            else echo 'text-red-600';
                                                            ?>">
                                                            <?= $score ?>% focus
                                                        </div>
                                                    </div>
                                                    <a href="<?= $baseUrl ?>/focus/summary/<?= $session['id'] ?>" class="text-indigo-600 hover:text-indigo-800 text-xs">
                                                        <i class="fas fa-external-link"></i>
                                                    </a>
                                                <?php elseif ($session['end_time'] === null): ?>
                                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Active</span>
                                                <?php else: ?>
                                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelled</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <?php 
                                        // Show creature info if available
                                        if ($session['creature_id']): 
                                            $sessionCreature = null;
                                            foreach ($creatures as $creature) {
                                                if ($creature['id'] == $session['creature_id']) {
                                                    $sessionCreature = $creature;
                                                    break;
                                                }
                                            }
                                            
                                            if ($sessionCreature):
                                        ?>
                                            <div class="mt-2 ml-13 pl-0.5 flex items-center text-xs text-gray-500">
                                                <i class="fas fa-dragon mr-1 text-<?= $sessionCreature['habitat_type'] ?? 'gray' ?>-400"></i>
                                                Growing: <?= htmlspecialchars($sessionCreature['name'] ?? 'Unknown creature') ?>
                                            </div>
                                        <?php 
                                            endif;
                                        endif; 
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Productivity Calendar -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-violet-500 to-violet-600 px-6 py-3">
                        <h3 class="text-lg font-bold text-white">Activity Calendar</h3>
                    </div>
                    
                    <div class="p-4">
                        <div id="productivity-calendar" class="space-y-4">
                            <!-- Month Navigation -->
                            <div class="flex justify-between items-center">
                                <button id="prev-month" class="p-1 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <h4 id="calendar-month" class="text-sm font-medium text-gray-800">March 2025</h4>
                                <button id="next-month" class="p-1 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            
                            <!-- Calendar Grid -->
                            <div>
                                <!-- Weekday Headers -->
                                <div class="grid grid-cols-7 mb-1">
                                    <?php foreach (['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day): ?>
                                        <div class="text-xs font-medium text-gray-500 text-center py-1"><?= $day ?></div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <!-- Calendar Days (will be filled by JS) -->
                                <div id="calendar-days" class="grid grid-cols-7 gap-1">
                                    <!-- Calendar days will be inserted here by JavaScript -->
                                </div>
                            </div>
                            
                            <!-- Legend -->
                            <div class="flex justify-center items-center text-xs text-gray-600 pt-2">
                                <div class="flex items-center mr-4">
                                    <div class="w-3 h-3 bg-gray-200 rounded-sm mr-1"></div>
                                    <span>No Focus</span>
                                </div>
                                <div class="flex items-center mr-4">
                                    <div class="w-3 h-3 bg-violet-300 rounded-sm mr-1"></div>
                                    <span>1-30 min</span>
                                </div>
                                <div class="flex items-center mr-4">
                                    <div class="w-3 h-3 bg-violet-500 rounded-sm mr-1"></div>
                                    <span>30-60 min</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-violet-700 rounded-sm mr-1"></div>
                                    <span>60+ min</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add necessary libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- JavaScript for Focus Page -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Timer functionality
    let timerInterval;
    let remainingSeconds = 0;
    let isPaused = false;
    let totalSeconds = 0;
    
    // Get elements
    const startForm = document.getElementById('start-session-form');
    const startBtn = document.getElementById('start-session-btn');
    const activeSession = document.getElementById('active-session');
    
    // Duration button selection
    const durationButtons = document.querySelectorAll('.duration-btn');
    const durationInput = document.getElementById('duration');
    
    durationButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            durationButtons.forEach(btn => btn.classList.remove('bg-indigo-100', 'border-indigo-300', 'text-indigo-700'));
            
            // Add active class to clicked button
            this.classList.add('bg-indigo-100', 'border-indigo-300', 'text-indigo-700');
            
            const value = this.dataset.value;
            
            // Handle custom duration
            if (value === 'custom') {
                document.getElementById('custom-duration-container').classList.remove('hidden');
            } else {
                document.getElementById('custom-duration-container').classList.add('hidden');
                durationInput.value = value;
            }
        });
    });
    
    // Set first button as active by default
    if (durationButtons.length > 0) {
        durationButtons[1].click(); // Select 25 min by default
    }
    
    // Custom duration handling
    const customDurationBtn = document.getElementById('custom-duration-set');
    if (customDurationBtn) {
        customDurationBtn.addEventListener('click', function() {
            const customValue = document.getElementById('custom-duration').value;
            durationInput.value = customValue;
            
            // Update the custom button text to show the selected duration
            const customDurationButton = document.querySelector('.duration-btn[data-value="custom"]');
            customDurationButton.textContent = `${customValue} min`;
        });
    }
    
    // Toggle advanced settings
    const toggleSettings = document.getElementById('toggle-settings');
    if (toggleSettings) {
        toggleSettings.addEventListener('click', function() {
            const settingsPanel = document.getElementById('advanced-settings');
            const settingsIcon = document.getElementById('settings-icon');
            
            if (settingsPanel.classList.contains('hidden')) {
                settingsPanel.classList.remove('hidden');
                settingsIcon.classList.remove('fa-chevron-down');
                settingsIcon.classList.add('fa-chevron-up');
            } else {
                settingsPanel.classList.add('hidden');
                settingsIcon.classList.remove('fa-chevron-up');
                settingsIcon.classList.add('fa-chevron-down');
            }
        });
    }
    
    // Creature selection
    const creatureOptions = document.querySelectorAll('.creature-option');
    if (creatureOptions.length > 0) {
        creatureOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                creatureOptions.forEach(opt => {
                    opt.querySelector('.border').classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-200');
                });
                
                // Add selected class to clicked option
                this.querySelector('.border').classList.add('border-indigo-500', 'ring-2', 'ring-indigo-200');
                
                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
            });
        });
        
        // Select first option by default
        creatureOptions[0].click();
    }
    
    // Focus environment selection
    const focusEnvButtons = document.querySelectorAll('.focus-env-btn');
    if (focusEnvButtons.length > 0) {
        focusEnvButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                focusEnvButtons.forEach(btn => btn.classList.remove('bg-indigo-100', 'border-indigo-300', 'text-indigo-700', 'active'));
                
                // Add active class to clicked button
                this.classList.add('bg-indigo-100', 'border-indigo-300', 'text-indigo-700', 'active');
            });
        });
    }
    
    // If there's an active session
    if (activeSession) {
        const sessionId = activeSession.dataset.sessionId;
        const duration = parseInt(activeSession.dataset.duration, 10);
        const startTime = new Date(activeSession.dataset.startTime);
        const timerDisplay = document.querySelector('.timer-display');
        const timerCircle = document.getElementById('timer-circle');
        const progressBar = document.getElementById('progress-bar');
        const pauseBtn = document.getElementById('pause-btn');
        const completeBtn = document.getElementById('complete-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const focusScoreBar = document.getElementById('focus-score-bar');
        const focusScoreText = document.getElementById('focus-score');
        const timerStatus = document.getElementById('timer-status');
        
        // Calculate total seconds for the session
        totalSeconds = duration * 60;
        
        // Calculate remaining time
        const now = new Date();
        const elapsedSeconds = Math.floor((now - startTime) / 1000);
        remainingSeconds = totalSeconds - elapsedSeconds;
        
        // Ensure we don't show negative time
        if (remainingSeconds < 0) {
            remainingSeconds = 0;
        }
        
        // Update timer display
        updateTimerDisplay();
        
        // Start the timer
        startTimer();
        
        // Event listeners for buttons
        pauseBtn.addEventListener('click', function() {
            if (isPaused) {
                // Resume timer
                isPaused = false;
                this.innerHTML = '<i class="fas fa-pause mr-2"></i> Pause';
                timerStatus.textContent = 'Focusing...';
                startTimer();
            } else {
                // Pause timer
                isPaused = true;
                this.innerHTML = '<i class="fas fa-play mr-2"></i> Resume';
                timerStatus.textContent = 'Paused';
                clearInterval(timerInterval);
            }
        });
        
        completeBtn.addEventListener('click', function() {
            // Complete session early
            completeSession(sessionId);
        });
        
        cancelBtn.addEventListener('click', function() {
            // Cancel session
            if (confirm('Are you sure you want to cancel this focus session?')) {
                cancelSession(sessionId);
            }
        });
        
        // Simulate focus score changes for demo (would be real calculation in production)
        setInterval(() => {
            // Randomly adjust focus score between 85-100% for demonstration
            const randomChange = Math.random() * 2 - 1; // -1 to +1
            let currentScore = parseInt(focusScoreText.textContent);
            currentScore = Math.min(100, Math.max(85, currentScore + randomChange));
            
            focusScoreText.textContent = Math.round(currentScore) + '%';
            focusScoreBar.style.width = Math.round(currentScore) + '%';
        }, 5000);
    }
    
    // Start session form submission
    if (startForm) {
        startForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Disable button to prevent multiple submissions
            startBtn.disabled = true;
            startBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Starting...';
            
            // Get form data
            const duration = document.getElementById('duration').value;
            let creatureId = '';
            
            // Check if creature selection exists
            const selectedCreature = document.querySelector('input[name="creature_id"]:checked');
            if (selectedCreature) {
                creatureId = selectedCreature.value;
            }
            
            // Get advanced settings
            const soundEnabled = document.getElementById('sound-enabled').checked;
            const breakDuration = document.getElementById('break-duration')?.value || 5;
            const autoRepeat = document.getElementById('auto-repeat')?.value || 0;
            const focusEnv = document.querySelector('.focus-env-btn.active')?.dataset.env || 'silent';
            
            // Create session data
            const sessionData = {
                duration: parseInt(duration, 10),
                creature_id: creatureId ? parseInt(creatureId, 10) : null,
                settings: {
                    sound_enabled: soundEnabled,
                    break_duration: parseInt(breakDuration, 10),
                    auto_repeat: parseInt(autoRepeat, 10),
                    environment: focusEnv
                }
            };
            
            // Send AJAX request to start session
            fetch('<?= $baseUrl ?>/focus/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(sessionData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to show active session
                    window.location.reload();
                } else {
                    alert('Error starting session: ' + data.message);
                    startBtn.disabled = false;
                    startBtn.innerHTML = '<i class="fas fa-play-circle mr-2 text-lg"></i> Start Focus Session';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error starting session. Please try again.');
                startBtn.disabled = false;
                startBtn.innerHTML = '<i class="fas fa-play-circle mr-2 text-lg"></i> Start Focus Session';
            });
        });
    }
    
    // Timer functions
    function startTimer() {
        // Clear any existing interval
        clearInterval(timerInterval);
        
        // Start new interval
        timerInterval = setInterval(function() {
            remainingSeconds--;
            
            // Update timer UI
            updateTimerDisplay();
            
            // Update progress
            const progress = ((totalSeconds - remainingSeconds) / totalSeconds) * 100;
            updateProgress(progress);
            
            if (remainingSeconds <= 0) {
                // Timer completed
                clearInterval(timerInterval);
                remainingSeconds = 0;
                
                // Play notification sound
                playNotificationSound();
                
                // Auto-complete session
                if (activeSession) {
                    completeSession(activeSession.dataset.sessionId);
                }
            }
        }, 1000);
    }
    
    function updateTimerDisplay() {
        if (!activeSession) return;
        
        const timerDisplay = document.querySelector('.timer-display');
        const minutes = Math.floor(remainingSeconds / 60);
        const seconds = remainingSeconds % 60;
        
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
    
    function updateProgress(progressPercent) {
        if (!activeSession) return;
        
        const timerCircle = document.getElementById('timer-circle');
        const progressBar = document.getElementById('progress-bar');
        
        // Calculate circle dash offset (283 is the circumference of the circle with r=45)
        const circumference = 283;
        const offset = circumference - (progressPercent / 100) * circumference;
        
        // Update circle progress
        timerCircle.style.strokeDashoffset = offset;
        timerCircle.style.strokeDasharray = circumference;
        
        // Update linear progress bar
        progressBar.style.width = `${progressPercent}%`;
    }
    
    function playNotificationSound() {
        // Check if sound is enabled
        const soundEnabled = document.getElementById('sound-enabled')?.checked ?? true;
        
        if (soundEnabled) {
            const audio = new Audio('<?= $baseUrl ?>/sounds/complete.mp3');
            audio.play().catch(e => console.log('Error playing sound:', e));
        }
    }
    
    function completeSession(sessionId) {
        // Set focus score (in a real app, this would be calculated based on user behavior)
        const focusScore = parseInt(document.getElementById('focus-score')?.textContent || '95');
        
        // Send AJAX request to complete session
        fetch('<?= $baseUrl ?>/focus/complete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                session_id: sessionId,
                focus_score: focusScore
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to summary page
                window.location.href = `<?= $baseUrl ?>/focus/summary/${sessionId}`;
            } else {
                alert('Error completing session: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error completing session. Please try again.');
        });
    }
    
    function cancelSession(sessionId) {
        // Send AJAX request to cancel session
        fetch('<?= $baseUrl ?>/focus/cancel', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                session_id: sessionId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload page
                window.location.reload();
            } else {
                alert('Error cancelling session: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error cancelling session. Please try again.');
        });
    }
    
    // Initialize Mini Weekly Chart
    if (document.getElementById('weeklyMiniChart')) {
        const ctx = document.getElementById('weeklyMiniChart').getContext('2d');
        
        // Sample data for the chart (in a real app, this would come from the server)
        const dailyData = [
            <?php 
            // Generate data for the last 7 days using actual session data
            $last7Days = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-$i days"));
                $minutes = 0;
                foreach ($recentSessions as $session) {
                    $sessionDate = date('Y-m-d', strtotime($session['start_time']));
                    if ($sessionDate === $date && $session['completed']) {
                        $minutes += $session['duration_minutes'];
                    }
                }
                $last7Days[] = $minutes;
            }
            echo implode(', ', $last7Days);
            ?>
        ];
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Minutes Focused',
                    data: dailyData,
                    backgroundColor: '#6366f1',
                    borderRadius: 4
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
                        callbacks: {
                            label: function(context) {
                                return context.raw + ' mins';
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
                                size: 10
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Initialize Productivity Calendar
    function initializeCalendar() {
        const calendarDays = document.getElementById('calendar-days');
        const calendarMonth = document.getElementById('calendar-month');
        const prevMonthBtn = document.getElementById('prev-month');
        const nextMonthBtn = document.getElementById('next-month');
        
        if (!calendarDays || !calendarMonth) return;
        
        let currentDate = new Date();
        
        // Sample focus data (would come from the backend in a real app)
        // Format: { 'YYYY-MM-DD': minutes }
        const focusData = {
            <?php
            // Generate random focus data for demonstration
            $startDate = strtotime('-30 days');
            for ($i = 0; $i < 30; $i++) {
                $date = date('Y-m-d', $startDate + ($i * 86400));
                $minutes = rand(0, 120);
                if ($minutes > 0) {
                    echo "'$date': $minutes,";
                }
            }
            ?>
        };
        
        function renderCalendar(year, month) {
            // Clear existing calendar
            calendarDays.innerHTML = '';
            
            // Update month and year display
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            calendarMonth.textContent = `${monthNames[month]} ${year}`;
            
            // Get first day of month and number of days in month
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            // Add empty cells for days before the start of the month
            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('h-7');
                calendarDays.appendChild(emptyCell);
            }
            
            // Add cells for each day of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayCell = document.createElement('div');
                dayCell.classList.add('h-7', 'flex', 'items-center', 'justify-center', 'text-xs');
                
                // Format the date for lookup in focusData
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const focusMinutes = focusData[dateString] || 0;
                
                // Color the cell based on focus minutes
                if (focusMinutes === 0) {
                    dayCell.classList.add('bg-gray-200');
                } else if (focusMinutes <= 30) {
                    dayCell.classList.add('bg-violet-300');
                } else if (focusMinutes <= 60) {
                    dayCell.classList.add('bg-violet-500', 'text-white');
                } else {
                    dayCell.classList.add('bg-violet-700', 'text-white');
                }
                
                // Check if this is today
                const today = new Date();
                if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    dayCell.classList.add('ring-2', 'ring-yellow-400');
                }
                
                dayCell.textContent = day;
                dayCell.title = `${focusMinutes} minutes focused`;
                
                calendarDays.appendChild(dayCell);
            }
        }
        
        // Initial render
        renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
        
        // Month navigation
        prevMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
        });
        
        nextMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
        });
    }
    
    // Initialize calendar
    initializeCalendar();
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>