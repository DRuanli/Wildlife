<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>
<?php require_once ROOT_PATH . '/public/js/focus/focus_style.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/focus/focus.css">


    <!-- Theme Toggle -->
    <div class="theme-toggle" id="theme-toggle">
        <i class="fas fa-moon"></i>
    </div>
    
    <!-- Fullscreen Toggle -->
    <div class="fullscreen-toggle" id="fullscreen-toggle">
        <i class="fas fa-expand"></i>
    </div>
    
    <!-- Ambient Sound Toggle -->
    <div class="ambient-toggle" id="ambient-toggle">
        <i class="fas fa-volume-up"></i>
    </div>
    
    <!-- Ambient Sounds Player (hidden by default) -->
    <div class="ambient-player" id="ambient-player" style="display: none;">
        <h4 class="text-sm font-bold mb-2">Ambient Sounds</h4>
        <div class="flex flex-wrap">
            <div class="ambient-control" data-sound="rain">
                <i class="fas fa-cloud-rain"></i>
                <span class="text-xs block mt-1">Rain</span>
            </div>
            <div class="ambient-control" data-sound="forest">
                <i class="fas fa-tree"></i>
                <span class="text-xs block mt-1">Forest</span>
            </div>
            <div class="ambient-control" data-sound="waves">
                <i class="fas fa-water"></i>
                <span class="text-xs block mt-1">Waves</span>
            </div>
            <div class="ambient-control" data-sound="cafe">
                <i class="fas fa-coffee"></i>
                <span class="text-xs block mt-1">Café</span>
            </div>
            <div class="ambient-control" data-sound="fire">
                <i class="fas fa-fire"></i>
                <span class="text-xs block mt-1">Fire</span>
            </div>
            <div class="ambient-control" data-sound="white-noise">
                <i class="fas fa-wave-square"></i>
                <span class="text-xs block mt-1">White Noise</span>
            </div>
        </div>
        <div class="mt-2">
            <label class="text-xs mb-1 block">Volume</label>
            <input type="range" id="volume-control" min="0" max="100" value="50" class="w-full">
        </div>
    </div>
    
    <!-- Distraction Log -->
    <div class="distraction-log" id="distraction-log">
        <i class="fas fa-exclamation-circle"></i>
    </div>
    
    <!-- Distraction Panel -->
    <div class="distraction-panel" id="distraction-panel">
        <h4 class="font-bold mb-2">Distraction Log</h4>
        <p class="text-sm mb-3">Log distractions to improve focus over time</p>
        
        <form id="distraction-form" class="mb-4">
            <input type="text" id="distraction-input" placeholder="What distracted you?" class="w-full p-2 rounded border mb-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700">
            <select id="distraction-type" class="w-full p-2 rounded border mb-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700">
                <option value="thought">Thought/Idea</option>
                <option value="notification">Notification</option>
                <option value="noise">Noise</option>
                <option value="person">Person</option>
                <option value="other">Other</option>
            </select>
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded">Log Distraction</button>
        </form>
        
        <h5 class="font-medium mb-2">Recent Distractions</h5>
        <div id="distraction-list" class="space-y-2 max-h-32 overflow-y-auto">
            <!-- Distractions will be added here -->
        </div>
    </div>
    
    <!-- Breathing Guide -->
    <div class="breathing-guide" id="breathing-guide">
        <div class="breathing-circle" id="breathing-circle">
            <span id="breathing-text">Prepare</span>
        </div>
    </div>

    <div id="focus-app" class="min-h-screen pt-6 pb-12">
        <div class="container mx-auto px-4">
            <!-- Header Section -->
            <div class="mb-8 flex justify-between items-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Focus Session</h1>
                <div class="flex items-center space-x-2">
                    <a href="<?= $baseUrl ?>/focus/history"
                       class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                        <i class="fas fa-history mr-1"></i> History
                    </a>
                    <a href="<?= $baseUrl ?>/dashboard"
                       class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Timer and Controls -->
                <div class="lg:col-span-1 flex flex-col items-center focus-content-wrapper">
                    <div id="focus-mode-content"
                         class="focus-mode-content w-full bg-white rounded-xl shadow-md p-6 mb-6 flex flex-col items-center">
                        <!-- Session Intent (New) -->
                        <div class="session-intent w-full">
                            <label for="session-intent" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Session Intent</label>
                            <input type="text" id="session-intent" placeholder="What do you intend to focus on?"
                                   class="w-full p-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 dark:border-gray-600">
                        </div>
                         
                        <!-- Focus Timer -->
                        <div class="timer-container mb-6">
                            <div class="timer-circle timer-background"></div>
                            <div id="timer-progress" class="timer-circle timer-progress"></div>
                            <div class="timer-content">
                                <div class="timer-inner">
                                    <span id="timer-display"
                                          class="text-4xl md:text-5xl font-bold text-gray-800">25:00</span>
                                    <p id="timer-status" class="text-gray-600 mt-2">Ready to focus</p>
                                </div>
                            </div>
                        </div>

                        <!-- Timer Controls -->
                        <div id="timer-controls" class="flex flex-wrap justify-center gap-3 mb-6 w-full">
                            <button id="breathe-btn"
                                    class="focus-btn px-5 py-3 bg-blue-600 text-white font-medium rounded-lg flex items-center">
                                <i class="fas fa-wind mr-2"></i> Breathe
                            </button>
                            <button id="start-btn"
                                    class="focus-btn start-btn px-5 py-3 bg-green-600 text-white font-medium rounded-lg flex items-center">
                                <i class="fas fa-play mr-2"></i> Start Focus
                            </button>
                            <button id="pause-btn"
                                    class="focus-btn px-5 py-3 bg-yellow-500 text-white font-medium rounded-lg flex items-center hidden">
                                <i class="fas fa-pause mr-2"></i> Pause
                            </button>
                            <button id="resume-btn"
                                    class="focus-btn px-5 py-3 bg-green-600 text-white font-medium rounded-lg flex items-center hidden">
                                <i class="fas fa-play mr-2"></i> Resume
                            </button>
                            <button id="complete-btn"
                                    class="focus-btn px-5 py-3 bg-blue-600 text-white font-medium rounded-lg flex items-center hidden">
                                <i class="fas fa-check mr-2"></i> Complete
                            </button>
                            <button id="cancel-btn"
                                    class="focus-btn px-5 py-3 bg-red-500 text-white font-medium rounded-lg flex items-center hidden">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </button>
                        </div>
                        
                        <!-- Focus Quote (New) -->
                        <div class="focus-quote text-gray-600">
                            <p id="focus-quote-text">"The successful warrior is the average man, with laser-like focus."</p>
                            <p class="text-sm mt-1" id="focus-quote-author">— Bruce Lee</p>
                        </div>

                        <!-- Session Settings -->
                        <div id="timer-settings" class="w-full max-w-md">
                            <!-- Pomodoro Settings (New) -->
                            <div class="pomodoro-settings mb-4">
                                <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Pomodoro Technique</h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Focus Time</label>
                                        <select id="pomodoro-focus" class="w-full p-2 rounded border focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 dark:border-gray-600">
                                            <option value="25">25 minutes</option>
                                            <option value="30">30 minutes</option>
                                            <option value="45">45 minutes</option>
                                            <option value="60">60 minutes</option>
                                            <option value="90">90 minutes</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Break Time</label>
                                        <select id="pomodoro-break" class="w-full p-2 rounded border focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 dark:border-gray-600">
                                            <option value="5">5 minutes</option>
                                            <option value="10">10 minutes</option>
                                            <option value="15">15 minutes</option>
                                            <option value="20">20 minutes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-center mt-2">
                                    <input type="checkbox" id="pomodoro-auto" class="mr-2">
                                    <label for="pomodoro-auto" class="text-sm text-gray-600 dark:text-gray-400">Auto-start next session</label>
                                </div>
                            </div>

                            <!-- Creature Selection -->
                            <div class="mb-4">
                                <label for="creature-select" class="block text-gray-700 font-medium mb-2">Choose a
                                    creature to grow:</label>
                                <select id="creature-select"
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 bg-white dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Select a creature</option>
                                    <?php foreach ($creatures as $creature): ?>
                                        <option value="<?= $creature['id'] ?>"
                                                data-stage="<?= $creature['stage'] ?>"
                                                data-species="<?= $creature['species_id'] ?>"
                                                data-habitat="<?= $creature['habitat_type'] ?>"
                                                data-health="<?= $creature['health'] ?>"
                                                data-happiness="<?= $creature['happiness'] ?>"
                                                data-growth="<?= $creature['growth_progress'] ?>"
                                                data-name="<?= htmlspecialchars($creature['name'] ?? 'Unnamed ' . $creature['species_name']) ?>">
                                            <?= htmlspecialchars($creature['name'] ?? 'Unnamed ' . $creature['species_name']) ?>
                                            (<?= ucfirst($creature['stage']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Focus Tips Card -->
                    <div id="focus-tips" class="w-full bg-white rounded-xl shadow-md p-6">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                            Focus Tips
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span class="text-gray-600">Find a quiet space with minimal distractions.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span class="text-gray-600">Set clear goals for what you want to accomplish.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span class="text-gray-600">Put your phone in Do Not Disturb mode.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span class="text-gray-600">Take short breaks between focus sessions.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Middle and Right Columns: Habitat Visualization and Stats -->
                <div class="lg:col-span-2">
                    <!-- 3D Model Placeholder Card -->
                    <div id="model-card" class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h3 class="font-bold text-gray-800 mb-4">Your Wildlife Habitat</h3>

                        <!-- 3D Model Container -->
                        <div class="model-container">
                            <!-- Placeholder for 3D model - will be replaced with actual 3D model -->
                            <div id="model-display" class="w-full h-full">
                                <div id="model-placeholder" class="model-placeholder">
                                    <div class="text-6xl mb-4 text-gray-300">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                    <div class="text-gray-500">
                                        <p class="font-medium mb-2">Select a creature to view it in 3D</p>
                                        <p class="text-sm">Your creature will appear here when selected</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Habitat Type Indicator -->
                            <div id="habitat-type" class="habitat-type-indicator">
                                <i class="fas fa-tree mr-1"></i> Select a creature
                            </div>

                            <!-- Creature Info Panel -->
                            <div id="creature-info-panel"
                                 class="creature-info-panel opacity-0 transition-opacity duration-300">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 id="creature-name" class="font-bold text-gray-800">No creature selected</h4>
                                    <span id="creature-stage"
                                          class="px-2 py-1 text-xs font-medium rounded-full badge-egg">Egg</span>
                                </div>

                                <div class="mb-2">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-500">Growth Progress</span>
                                        <span id="growth-percentage" class="text-green-600 font-medium">0%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div id="growth-bar" class="progress-fill bg-green-500" style="width: 0%"></div>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-4 text-xs">
                                    <div class="flex items-center">
                                        <i class="fas fa-heart text-red-500 mr-1.5"></i>
                                        <span id="creature-health" class="text-gray-600">Health: 100/100</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-smile text-yellow-500 mr-1.5"></i>
                                        <span id="creature-happiness" class="text-gray-600">Happiness: 100/100</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Model Controls -->
                        <div class="flex justify-center mt-4 space-x-3">
                            <button id="rotate-left-btn"
                                    class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none disabled:opacity-50"
                                    disabled>
                                <i class="fas fa-undo"></i>
                            </button>
                            <button id="rotate-right-btn"
                                    class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none disabled:opacity-50"
                                    disabled>
                                <i class="fas fa-redo"></i>
                            </button>
                            <button id="zoom-in-btn"
                                    class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none disabled:opacity-50"
                                    disabled>
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <button id="zoom-out-btn"
                                    class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none disabled:opacity-50"
                                    disabled>
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <button id="reset-view-btn"
                                    class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none disabled:opacity-50"
                                    disabled>
                                <i class="fas fa-home"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Focus Stats Card -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-gray-800">Focus Statistics</h3>
                            <a href="<?= $baseUrl ?>/focus/history"
                               class="text-green-600 hover:text-green-700 text-sm font-medium">View History</a>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-gray-500 text-sm mb-1">Total Focus Time</p>
                                <p class="text-xl font-bold text-gray-800">
                                    <?= floor(($userStats['total_minutes'] ?? 0) / 60) ?>
                                    h <?= ($userStats['total_minutes'] ?? 0) % 60 ?>m
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-gray-500 text-sm mb-1">Current Streak</p>
                                <p class="text-xl font-bold text-gray-800">
                                    <?= $userStats['streak_days'] ?? 0 ?> days
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-gray-500 text-sm mb-1">Sessions Completed</p>
                                <p class="text-xl font-bold text-gray-800">
                                    <?= $userStats['total_sessions'] ?? 0 ?>
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-gray-500 text-sm mb-1">Avg. Focus Score</p>
                                <p class="text-xl font-bold text-gray-800">
                                    <?= number_format($userStats['avg_focus_score'] ?? 0) ?>%
                                </p>
                            </div>
                        </div>

                        <!-- Recent Sessions -->
                        <h4 class="font-medium text-gray-800 mb-3">Recent Sessions</h4>
                        <?php if (empty($todaySessions)): ?>
                            <div class="text-center py-6 text-gray-500">
                                <i class="fas fa-history text-gray-300 text-4xl mb-3"></i>
                                <p class="mb-2">No focus sessions yet today</p>
                                <p class="text-sm">Start your first session to begin growing your creatures!</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                                <?php foreach (array_slice($todaySessions, 0, 5) as $session): ?>
                                    <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-100 text-blue-600 mr-3">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate"><?= $session['duration_minutes'] ?>
                                                min focus session</p>
                                            <p class="text-xs text-gray-500"><?= date('g:i A', strtotime($session['start_time'])) ?></p>
                                            <?php if ($session['completed']): ?>
                                                <div class="flex items-center mt-1">
                  <span class="text-xs text-yellow-600 flex items-center">
                    <i class="fas fa-coins mr-1"></i> Earned <?= $session['coins_earned'] ?> coins
                  </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <?php if ($session['completed']): ?>
                                                <div class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                    <?= $session['focus_score'] ?>%
                                                </div>
                                            <?php elseif ($session['end_time'] === null): ?>
                                                <div class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                                    In Progress
                                                </div>
                                            <?php else: ?>
                                                <div class="px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                    Canceled
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Focus Mode Overlay -->
    <div id="focus-mode-overlay" class="focus-mode-overlay"></div>

    <!-- Session Complete Modal -->
    <div id="complete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl max-w-md w-full overflow-hidden animate__animated animate__fadeInUp">
            <div class="bg-green-600 px-6 py-4 text-white relative">
                <h3 class="text-xl font-bold">Session Complete!</h3>
                <button id="close-complete-modal"
                        class="absolute top-4 right-4 text-white hover:text-white hover:opacity-80">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-green-600 text-4xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Great work!</h4>
                    <p class="text-gray-600">You've completed a <span id="completed-duration">25</span> minute focus
                        session.</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h5 class="font-medium text-gray-800 mb-2">Session Results</h5>
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Focus Score</p>
                            <p id="result-focus-score" class="text-xl font-bold text-green-600">85%</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Coins Earned</p>
                            <div class="flex items-center justify-center">
                                <span id="result-coins" class="text-xl font-bold text-yellow-600 mr-1">5</span>
                                <i class="fas fa-coins text-yellow-500"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Creature Growth -->
                <div id="result-creature-growth" class="bg-gray-50 rounded-lg p-4 mb-6 hidden">
                    <h5 class="font-medium text-gray-800 mb-2">Creature Growth</h5>
                    <div class="flex items-center">
                        <div id="result-creature-icon"
                             class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-dragon text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <p id="result-creature-name" class="font-medium text-gray-800">Your Creature</p>
                            <div class="w-full mt-1">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500">Growth Progress</span>
                                    <span id="result-growth-text" class="text-green-600">+5 points</span>
                                </div>
                                <div class="progress-bar">
                                    <div id="result-growth-bar" class="progress-fill bg-green-500"
                                         style="width: 35%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <button id="view-summary-btn"
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-800 font-medium rounded-lg hover:bg-gray-50">
                        View Summary
                    </button>
                    <button id="start-new-session-btn"
                            class="flex-1 px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700">
                        Start New Session
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio elements for ambient sounds -->
    <audio id="sound-rain" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/rain.mp3" type="audio/mp3">
    </audio>
    <audio id="sound-forest" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/forest.mp3" type="audio/mp3">
    </audio>
    <audio id="sound-waves" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/waves.mp3" type="audio/mp3">
    </audio>
    <audio id="sound-cafe" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/cafe.mp3" type="audio/mp3">
    </audio>
    <audio id="sound-fire" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/fire.mp3" type="audio/mp3">
    </audio>
    <audio id="sound-white-noise" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/white-noise.mp3" type="audio/mp3">
    </audio>

    <div id="focus-mode-overlay" class="focus-mode-overlay"></div>
    <script src="<?= $baseUrl ?>/public/js/focus/focus-3d.js"></script>
<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>