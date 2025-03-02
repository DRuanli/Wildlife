<?php require_once ROOT_PATH . '/resources/views/layouts/header.php';
include('public/loading-component.php');
?>
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
            <input type="text" id="distraction-input" placeholder="What distracted you?"
                   class="w-full p-2 rounded border mb-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700">
            <select id="distraction-type"
                    class="w-full p-2 rounded border mb-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700">
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
        <button id="close-breathing-guide" class="close-breathing" aria-label="Close breathing guide">
            <i class="fas fa-times"></i>
        </button>

        <div class="breathing-wrapper">
            <div class="breathing-circle-container">
                <div class="breathing-circle" id="breathing-circle">
                    <div class="breathing-inner-circle"></div>
                    <div class="breathing-ripple"></div>
                </div>
                <svg class="breathing-progress" viewBox="0 0 100 100">
                    <circle class="breathing-progress-track" cx="50" cy="50" r="45"></circle>
                    <circle class="breathing-progress-indicator" cx="50" cy="50" r="45"></circle>
                </svg>
            </div>

            <div class="breathing-label">
                <div class="breathing-text" id="breathing-text">Prepare</div>
                <div class="breathing-cycles" id="breathing-cycles">
                    <span class="cycle active"></span>
                    <span class="cycle"></span>
                    <span class="cycle"></span>
                    <span class="cycle"></span>
                </div>
            </div>
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
                        <div class="session-intent-container w-full mb-6 transition-all duration-300">
                            <div class="intent-header flex items-center mb-2">
                                <label for="session-intent"
                                       class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                    <i class="fas fa-bullseye text-green-600 dark:text-green-400 mr-2"></i>
                                    Session Intent
                                </label>
                                <div class="ml-auto flex items-center">
                                    <button id="session-intent-history"
                                            class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 text-sm mr-1"
                                            title="Previous intents">
                                        <i class="fas fa-history"></i>
                                    </button>
                                    <button id="session-intent-suggestions"
                                            class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 text-sm"
                                            title="Suggestions">
                                        <i class="fas fa-lightbulb"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="intent-input-wrapper relative">
                                <div class="intent-input-container relative rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-green-500 focus-within:border-green-500">
                                    <input type="text" id="session-intent" placeholder="What do you intend to focus on?"
                                           class="w-full p-3 outline-none bg-transparent text-gray-800 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 pr-10">
                                    <div class="absolute right-2 top-1/2 transform -translate-y-1/2 flex items-center">
                                        <span id="intent-word-count"
                                              class="text-xs text-gray-400 dark:text-gray-500 mr-1">0/100</span>
                                        <button id="clear-intent"
                                                class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 p-1 opacity-0 transition-opacity duration-200"
                                                title="Clear">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Suggestions dropdown -->
                                <div id="intent-suggestions"
                                     class="suggestions-dropdown absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg hidden">
                                    <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300">Common
                                            Intents</h5>
                                    </div>
                                    <ul class="max-h-60 overflow-y-auto py-1">
                                        <li class="suggestion-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200">
                                            <i class="fas fa-code text-blue-500 mr-2"></i> Complete programming task
                                        </li>
                                        <li class="suggestion-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200">
                                            <i class="fas fa-book text-indigo-500 mr-2"></i> Study for exam
                                        </li>
                                        <li class="suggestion-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200">
                                            <i class="fas fa-edit text-purple-500 mr-2"></i> Write essay/article
                                        </li>
                                        <li class="suggestion-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200">
                                            <i class="fas fa-file-alt text-green-500 mr-2"></i> Draft email/message
                                        </li>
                                        <li class="suggestion-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200">
                                            <i class="fas fa-chart-line text-red-500 mr-2"></i> Complete work
                                            presentation
                                        </li>
                                        <li class="suggestion-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200">
                                            <i class="fas fa-tasks text-yellow-500 mr-2"></i> Clear my task backlog
                                        </li>
                                    </ul>
                                </div>

                                <!-- History dropdown -->
                                <div id="intent-history"
                                     class="history-dropdown absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg hidden">
                                    <div class="p-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300">Recent
                                            Intents</h5>
                                        <button id="clear-history"
                                                class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                            Clear History
                                        </button>
                                    </div>
                                    <ul id="history-list" class="max-h-60 overflow-y-auto py-1">
                                        <!-- History items will be inserted here -->
                                        <li class="history-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200 flex justify-between items-center">
                                            <span>Create website wireframes</span>
                                            <span class="text-xs text-gray-500">Yesterday</span>
                                        </li>
                                        <li class="history-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200 flex justify-between items-center">
                                            <span>Study JavaScript promises</span>
                                            <span class="text-xs text-gray-500">3 days ago</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Intent cards - visible when session is active -->
                            <div id="active-intent-card"
                                 class="hidden mt-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg animate-fadeIn">
                                <div class="flex items-start">
                                    <div class="text-green-600 dark:text-green-400 mr-3">
                                        <i class="fas fa-check-circle text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="font-medium text-gray-800 dark:text-gray-200 leading-tight">Your
                                            focus intention:</h5>
                                        <p id="active-intent-text" class="text-gray-700 dark:text-gray-300 mt-1"></p>
                                    </div>
                                </div>
                            </div>
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

                        <!-- Session Settings -->
                        <div id="timer-settings" class="w-full max-w-md">
                            <!-- Pomodoro Settings (New) -->
                            <!-- Improved Pomodoro Settings -->
                            <div class="pomodoro-settings mb-4 p-5 rounded-lg bg-white dark:bg-gray-800 shadow-sm">
                                <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-4">Pomodoro Technique</h3>

                                <!-- Focus Time Slider -->
                                <div class="mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="text-sm text-gray-600 dark:text-gray-400">Focus Time</label>
                                        <span id="focus-time-display"
                                              class="text-sm font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100 px-2 py-1 rounded-full">25 minutes</span>
                                    </div>
                                    <input type="range" id="pomodoro-focus"
                                           class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer"
                                           min="5" max="90" step="5" value="25">
                                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span>5m</span>
                                        <span>25m</span>
                                        <span>45m</span>
                                        <span>90m</span>
                                    </div>
                                </div>

                                <!-- Break Time Slider -->
                                <div class="mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="text-sm text-gray-600 dark:text-gray-400">Break Time</label>
                                        <span id="break-time-display"
                                              class="text-sm font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 px-2 py-1 rounded-full">5 minutes</span>
                                    </div>
                                    <input type="range" id="pomodoro-break"
                                           class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer"
                                           min="1" max="30" step="1" value="5">
                                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span>1m</span>
                                        <span>5m</span>
                                        <span>15m</span>
                                        <span>30m</span>
                                    </div>
                                </div>

                                <!-- Pomodoro Presets -->
                                <div class="mb-4">
                                    <label class="block text-sm text-gray-600 dark:text-gray-400 mb-2">Quick
                                        Presets</label>
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button"
                                                class="preset-btn px-3 py-2 text-sm rounded-lg bg-gray-100 hover:bg-green-100 dark:bg-gray-700 dark:hover:bg-green-900 transition-all"
                                                data-focus="25" data-break="5">
                                            <span class="font-medium">25/5</span>
                                            <span class="text-xs block">Classic</span>
                                        </button>
                                        <button type="button"
                                                class="preset-btn px-3 py-2 text-sm rounded-lg bg-gray-100 hover:bg-green-100 dark:bg-gray-700 dark:hover:bg-green-900 transition-all"
                                                data-focus="50" data-break="10">
                                            <span class="font-medium">50/10</span>
                                            <span class="text-xs block">Extended</span>
                                        </button>
                                        <button type="button"
                                                class="preset-btn px-3 py-2 text-sm rounded-lg bg-gray-100 hover:bg-green-100 dark:bg-gray-700 dark:hover:bg-green-900 transition-all"
                                                data-focus="90" data-break="20">
                                            <span class="font-medium">90/20</span>
                                            <span class="text-xs block">Deep Work</span>
                                        </button>
                                        <button type="button"
                                                class="preset-btn px-3 py-2 text-sm rounded-lg bg-gray-100 hover:bg-green-100 dark:bg-gray-700 dark:hover:bg-green-900 transition-all"
                                                data-focus="10" data-break="2">
                                            <span class="font-medium">10/2</span>
                                            <span class="text-xs block">Quick</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex items-center p-2 bg-gray-50 dark:bg-gray-900 rounded-lg">
                                    <input type="checkbox" id="pomodoro-auto"
                                           class="w-4 h-4 text-green-600 rounded focus:ring-green-500 mr-2">
                                    <label for="pomodoro-auto" class="text-sm text-gray-600 dark:text-gray-400">Auto-start
                                        next session</label>
                                </div>
                            </div>

                            <!-- Improved Creature Selection -->
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Choose a creature
                                    to grow:</label>

                                <!-- Creature Selection Carousel -->
                                <div class="relative">
                                    <div class="creature-carousel flex overflow-x-auto py-3 pb-5 space-x-4 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                                        <!-- Default "Select a creature" card -->
                                        <div class="creature-card cursor-pointer flex-none w-28 h-32 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                                             data-creature-id="">
                                            <div class="text-center">
                                                <div class="text-gray-400 text-xl">
                                                    <i class="fas fa-plus"></i>
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Select</div>
                                            </div>
                                        </div>

                                        <?php foreach ($creatures as $creature): ?>
                                            <div class="creature-card cursor-pointer flex-none w-28 h-32 rounded-lg border-2 hover:border-green-500 dark:hover:border-green-400 transition-all transform hover:scale-105 <?= $creature['id'] === ($selectedCreatureId ?? '') ? 'border-green-500 dark:border-green-400 bg-green-50 dark:bg-green-900/30' : 'border-gray-200 dark:border-gray-700' ?>"
                                                 data-creature-id="<?= $creature['id'] ?>"
                                                 data-stage="<?= $creature['stage'] ?>"
                                                 data-species="<?= $creature['species_id'] ?>"
                                                 data-habitat="<?= $creature['habitat_type'] ?>"
                                                 data-health="<?= $creature['health'] ?>"
                                                 data-happiness="<?= $creature['happiness'] ?>"
                                                 data-growth="<?= $creature['growth_progress'] ?>"
                                                 data-name="<?= htmlspecialchars($creature['name'] ?? 'Unnamed ' . $creature['species_name']) ?>">

                                                <!-- Creature Icon -->
                                                <div class="h-16 flex items-center justify-center pt-2">
                                                    <?php
                                                    $iconClass = "text-gray-400";
                                                    $icon = "fa-question";

                                                    switch ($creature['habitat_type']) {
                                                        case 'forest':
                                                            $iconClass = "text-green-600";
                                                            break;
                                                        case 'ocean':
                                                            $iconClass = "text-blue-600";
                                                            break;
                                                        case 'mountain':
                                                            $iconClass = "text-red-700";
                                                            break;
                                                        case 'sky':
                                                            $iconClass = "text-blue-400";
                                                            break;
                                                        case 'cosmic':
                                                            $iconClass = "text-purple-600";
                                                            break;
                                                        case 'enchanted':
                                                            $iconClass = "text-pink-600";
                                                            break;
                                                    }

                                                    switch ($creature['stage']) {
                                                        case 'egg':
                                                            $icon = "fa-egg";
                                                            break;
                                                        case 'baby':
                                                            $icon = "fa-baby";
                                                            break;
                                                        case 'juvenile':
                                                            $icon = "fa-paw";
                                                            break;
                                                        case 'adult':
                                                        case 'mythical':
                                                            $icon = "fa-dragon";
                                                            break;
                                                    }
                                                    ?>
                                                    <i class="fas <?= $icon ?> <?= $iconClass ?> text-3xl transition-all"></i>
                                                </div>

                                                <!-- Creature Name -->
                                                <div class="text-center text-xs font-medium text-gray-700 dark:text-gray-300 px-1 truncate">
                                                    <?= htmlspecialchars($creature['name'] ?? 'Unnamed ' . $creature['species_name']) ?>
                                                </div>

                                                <!-- Creature Stage -->
                                                <div class="absolute top-1 right-1">
                        <span class="px-1.5 py-0.5 text-[10px] font-medium rounded-full <?= 'badge-' . $creature['stage'] ?>">
                            <?= ucfirst($creature['stage']) ?>
                        </span>
                                                </div>

                                                <!-- Growth Progress Bar (tiny) -->
                                                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-200 dark:bg-gray-700">
                                                    <?php
                                                    $growthPercentage = 0;
                                                    if ($creature['stage'] === 'egg') {
                                                        $growthPercentage = ($creature['growth_progress'] / 100) * 100;
                                                    } elseif ($creature['stage'] === 'mythical') {
                                                        $growthPercentage = 100;
                                                    } else {
                                                        $growthPercentage = ($creature['growth_progress'] / 200) * 100;
                                                    }
                                                    ?>
                                                    <div class="h-full bg-green-500 rounded-r-sm"
                                                         style="width: <?= $growthPercentage ?>%"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Navigation buttons for larger screens -->
                                    <button class="carousel-prev absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-3 bg-white dark:bg-gray-800 rounded-full w-8 h-8 flex items-center justify-center shadow-md hover:bg-gray-100 dark:hover:bg-gray-700 md:flex hidden">
                                        <i class="fas fa-chevron-left text-gray-600 dark:text-gray-300"></i>
                                    </button>
                                    <button class="carousel-next absolute top-1/2 right-0 transform -translate-y-1/2 translate-x-3 bg-white dark:bg-gray-800 rounded-full w-8 h-8 flex items-center justify-center shadow-md hover:bg-gray-100 dark:hover:bg-gray-700 md:flex hidden">
                                        <i class="fas fa-chevron-right text-gray-600 dark:text-gray-300"></i>
                                    </button>
                                </div>

                                <!-- Selected Creature Information -->
                                <div id="selected-creature-info"
                                     class="mt-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 <?= isset($selectedCreatureId) ? '' : 'hidden' ?>">
                                    <div class="flex items-center">
                                        <div id="selected-creature-icon"
                                             class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mr-3">
                                            <i id="selected-creature-icon-element"
                                               class="fas fa-dragon text-gray-400 text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 id="selected-creature-name"
                                                class="font-medium text-gray-800 dark:text-gray-200">Select a
                                                creature</h4>
                                            <p id="selected-creature-habitat"
                                               class="text-xs text-gray-500 dark:text-gray-400">No habitat selected</p>
                                        </div>
                                    </div>
                                </div>


                                <!-- Hidden select element to maintain compatibility with existing code -->
                                <select id="creature-select" class="hidden">
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
                        <!-- Focus Quote (New) -->
                        <div class="focus-quote text-gray-600">
                            <p id="focus-quote-text">"The successful warrior is the average man, with laser-like
                                focus."</p>
                            <p class="text-sm mt-1" id="focus-quote-author">— Bruce Lee</p>
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
        <source src="<?= $baseUrl ?>/public/sounds/Howl.mp3" type="audio/mp3">
    </audio>
    <audio id="sound-forest" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/AOT.mp3" type="audio/mp3">
    </audio>
    <audio id="sound-waves" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/trung.mp3" type="audio/mp3">
    </audio>
    <audio id="sound-cafe" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/nga.mp3" type="audio/mp3">
    </audio>
    <audio id="sound-fire" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/viet.mp3" type="audio/mp3">
    </audio>
    <audio id="sound-white-noise" loop preload="none">
        <source src="<?= $baseUrl ?>/public/sounds/nhat.mp3" type="audio/mp3">
    </audio>

    <div id="focus-mode-overlay" class="focus-mode-overlay"></div>
    <script src="<?= $baseUrl ?>/public/js/focus/focus-3d.js"></script>

    <style>
        /* Enhanced Slider Styling */
        input[type="range"] {
            -webkit-appearance: none;
            height: 6px;
            background: #e5e7eb;
            border-radius: 5px;
            background-image: linear-gradient(#4D724D, #4D724D);
            background-size: 50% 100%;
            background-repeat: no-repeat;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: #4D724D;
            cursor: pointer;
            box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.25);
            transition: background .3s ease-in-out, transform 0.2s ease;
        }

        input[type="range"]::-webkit-slider-runnable-track {
            -webkit-appearance: none;
            box-shadow: none;
            border: none;
            background: transparent;
        }

        input[type="range"]::-webkit-slider-thumb:hover {
            background: #2F4F2F;
            transform: scale(1.2);
        }

        body.dark-mode input[type="range"] {
            background: #4b5563;
            background-image: linear-gradient(#C4D7C4, #C4D7C4);
            background-size: 50% 100%;
            background-repeat: no-repeat;
        }

        body.dark-mode input[type="range"]::-webkit-slider-thumb {
            background: #C4D7C4;
        }

        body.dark-mode input[type="range"]::-webkit-slider-thumb:hover {
            background: #ffffff;
        }

        input[type="range"]:focus {
            outline: none;
        }

        /* Preset buttons */
        .preset-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .preset-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .preset-btn.active {
            background-color: rgba(74, 222, 128, 0.2) !important;
            border: 2px solid #4ade80;
            transform: translateY(-1px);
        }

        body.dark-mode .preset-btn.active {
            background-color: rgba(74, 222, 128, 0.1) !important;
            border: 2px solid #22c55e;
        }

        /* Creature Cards */
        .creature-carousel {
            scrollbar-width: thin;
            scrollbar-color: #CBD5E0 #EDF2F7;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
        }

        .creature-carousel::-webkit-scrollbar {
            height: 6px;
        }

        .creature-carousel::-webkit-scrollbar-track {
            background: #EDF2F7;
            border-radius: 3px;
        }

        .creature-carousel::-webkit-scrollbar-thumb {
            background-color: #CBD5E0;
            border-radius: 3px;
        }

        body.dark-mode .creature-carousel::-webkit-scrollbar-track {
            background: #2D3748;
        }

        body.dark-mode .creature-carousel::-webkit-scrollbar-thumb {
            background-color: #4A5568;
        }

        .creature-card {
            position: relative;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            scroll-snap-align: center;
        }

        .creature-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .creature-card.selected {
            animation: pulse 2s infinite;
        }

        .carousel-prev, .carousel-next {
            opacity: 0.7;
            transition: all 0.2s ease;
            z-index: 10;
        }

        .carousel-prev:hover, .carousel-next:hover {
            opacity: 1;
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-prev:hover {
            transform: translateY(-50%) translateX(-3px) scale(1.1);
        }

        .carousel-next:hover {
            transform: translateY(-50%) translateX(3px) scale(1.1);
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(77, 124, 77, 0.4);
            }
            70% {
                box-shadow: 0 0 0 5px rgba(77, 124, 77, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(77, 124, 77, 0);
            }
        }

        /* Hover zoom effect for creature icons */
        .creature-card:hover i {
            transform: scale(1.2);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Pomodoro slider controls
            const focusSlider = document.getElementById('pomodoro-focus');
            const breakSlider = document.getElementById('pomodoro-break');
            const focusDisplay = document.getElementById('focus-time-display');
            const breakDisplay = document.getElementById('break-time-display');

            // Function to update slider fill visualization
            function updateSliderFill(slider) {
                if (!slider) return;

                const min = slider.min ? parseFloat(slider.min) : 0;
                const max = slider.max ? parseFloat(slider.max) : 100;
                const value = slider.value ? parseFloat(slider.value) : min;
                const percentage = ((value - min) / (max - min)) * 100;

                slider.style.backgroundSize = `${percentage}% 100%`;
            }

            // Initialize sliders
            if (focusSlider && focusDisplay) {
                updateSliderFill(focusSlider);
                focusSlider.addEventListener('input', function () {
                    focusDisplay.textContent = `${this.value} minutes`;
                    updateSliderFill(this);
                    updateSessionDuration(parseInt(this.value));
                });
            }

            if (breakSlider && breakDisplay) {
                updateSliderFill(breakSlider);
                breakSlider.addEventListener('input', function () {
                    breakDisplay.textContent = `${this.value} minutes`;
                    updateSliderFill(this);
                });
            }

            // Preset buttons
            const presetButtons = document.querySelectorAll('.preset-btn');
            presetButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const focusValue = this.getAttribute('data-focus');
                    const breakValue = this.getAttribute('data-break');

                    // Update sliders and displays
                    if (focusSlider && focusValue) {
                        focusSlider.value = focusValue;
                        focusDisplay.textContent = `${focusValue} minutes`;
                        updateSliderFill(focusSlider);
                        updateSessionDuration(parseInt(focusValue));
                    }

                    if (breakSlider && breakValue) {
                        breakSlider.value = breakValue;
                        breakDisplay.textContent = `${breakValue} minutes`;
                        updateSliderFill(breakSlider);
                    }

                    // Add active class to clicked button and remove from others
                    presetButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Add subtle animation
                    this.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        this.classList.remove('animate__animated', 'animate__pulse');
                    }, 1000);
                });
            });

            // Function to update session duration
            function updateSessionDuration(minutes) {
                if (typeof window.sessionDuration !== 'undefined') {
                    window.sessionDuration = minutes * 60;
                    window.timeRemaining = window.sessionDuration;

                    // Update timer display
                    if (typeof window.updateTimerDisplay === 'function') {
                        window.updateTimerDisplay();
                    }
                }
            }

            // Creature selection carousel
            const creatureCards = document.querySelectorAll('.creature-card');
            const creatureSelect = document.getElementById('creature-select');
            const selectedCreatureInfo = document.getElementById('selected-creature-info');
            const selectedCreatureName = document.getElementById('selected-creature-name');
            const selectedCreatureHabitat = document.getElementById('selected-creature-habitat');
            const selectedCreatureIcon = document.getElementById('selected-creature-icon-element');

            // Make creature cards interactive
            creatureCards.forEach(card => {
                card.addEventListener('click', function () {
                    const creatureId = this.getAttribute('data-creature-id');

                    // Clear selection from all cards
                    creatureCards.forEach(c => {
                        c.classList.remove('border-green-500', 'dark:border-green-400', 'bg-green-50', 'dark:bg-green-900/30', 'scale-105', 'selected');
                    });

                    if (creatureId) {
                        // Apply selection styling
                        this.classList.add('border-green-500', 'dark:border-green-400', 'bg-green-50', 'dark:bg-green-900/30', 'scale-105', 'selected');

                        // Update hidden select to maintain compatibility with existing code
                        if (creatureSelect) {
                            creatureSelect.value = creatureId;

                            // Trigger change event to ensure original handlers run
                            const event = new Event('change');
                            creatureSelect.dispatchEvent(event);
                        }

                        // Update the creature info panel
                        if (selectedCreatureInfo) {
                            selectedCreatureInfo.classList.remove('hidden');

                            const name = this.getAttribute('data-name');
                            const habitat = this.getAttribute('data-habitat');
                            const stage = this.getAttribute('data-stage');

                            if (selectedCreatureName) {
                                selectedCreatureName.textContent = name;
                            }

                            if (selectedCreatureHabitat) {
                                let habitatText = 'Unknown Habitat';
                                let habitatIcon = '';

                                switch (habitat) {
                                    case 'forest':
                                        habitatText = 'Forest Habitat';
                                        habitatIcon = '<i class="fas fa-tree mr-1 text-green-600"></i>';
                                        break;
                                    case 'ocean':
                                        habitatText = 'Ocean Habitat';
                                        habitatIcon = '<i class="fas fa-water mr-1 text-blue-600"></i>';
                                        break;
                                    case 'mountain':
                                        habitatText = 'Mountain Habitat';
                                        habitatIcon = '<i class="fas fa-mountain mr-1 text-red-700"></i>';
                                        break;
                                    case 'sky':
                                        habitatText = 'Sky Habitat';
                                        habitatIcon = '<i class="fas fa-cloud mr-1 text-blue-400"></i>';
                                        break;
                                    case 'cosmic':
                                        habitatText = 'Cosmic Habitat';
                                        habitatIcon = '<i class="fas fa-star mr-1 text-purple-600"></i>';
                                        break;
                                    case 'enchanted':
                                        habitatText = 'Enchanted Habitat';
                                        habitatIcon = '<i class="fas fa-magic mr-1 text-pink-600"></i>';
                                        break;
                                }

                                selectedCreatureHabitat.innerHTML = habitatIcon + habitatText;
                            }

                            if (selectedCreatureIcon) {
                                // Set icon based on stage
                                let iconClass = "fas ";
                                switch (stage) {
                                    case 'egg':
                                        iconClass += "fa-egg";
                                        break;
                                    case 'baby':
                                        iconClass += "fa-baby";
                                        break;
                                    case 'juvenile':
                                        iconClass += "fa-paw";
                                        break;
                                    case 'adult':
                                        iconClass += "fa-dragon";
                                        break;
                                    case 'mythical':
                                        iconClass += "fa-dragon";
                                        break;
                                    default:
                                        iconClass += "fa-question";
                                }

                                // Set color based on habitat
                                let colorClass = "text-gray-400";
                                switch (habitat) {
                                    case 'forest':
                                        colorClass = "text-green-600";
                                        break;
                                    case 'ocean':
                                        colorClass = "text-blue-600";
                                        break;
                                    case 'mountain':
                                        colorClass = "text-red-700";
                                        break;
                                    case 'sky':
                                        colorClass = "text-blue-400";
                                        break;
                                    case 'cosmic':
                                        colorClass = "text-purple-600";
                                        break;
                                    case 'enchanted':
                                        colorClass = "text-pink-600";
                                        break;
                                }

                                selectedCreatureIcon.className = `${iconClass} ${colorClass} text-2xl`;
                            }
                        }
                    } else {
                        // No creature selected (default card)
                        if (creatureSelect) {
                            creatureSelect.value = '';
                            const event = new Event('change');
                            creatureSelect.dispatchEvent(event);
                        }

                        if (selectedCreatureInfo) {
                            selectedCreatureInfo.classList.add('hidden');
                        }
                    }
                });

                // Add hover effects
                card.addEventListener('mouseenter', function () {
                    this.classList.add('transform', 'hover:scale-105');
                });

                card.addEventListener('mouseleave', function () {
                    if (!this.classList.contains('selected')) {
                        this.classList.remove('transform', 'hover:scale-105');
                    }
                });
            });

            // Carousel navigation
            const carousel = document.querySelector('.creature-carousel');
            const prevBtn = document.querySelector('.carousel-prev');
            const nextBtn = document.querySelector('.carousel-next');

            if (prevBtn && carousel) {
                prevBtn.addEventListener('click', function () {
                    carousel.scrollBy({left: -200, behavior: 'smooth'});
                });
            }

            if (nextBtn && carousel) {
                nextBtn.addEventListener('click', function () {
                    carousel.scrollBy({left: 200, behavior: 'smooth'});
                });
            }

            // Auto-select previously selected creature if any
            if (creatureSelect && creatureSelect.value) {
                const selectedId = creatureSelect.value;
                const selectedCard = document.querySelector(`.creature-card[data-creature-id="${selectedId}"]`);
                if (selectedCard) {
                    // Simulate click to set up all visuals
                    selectedCard.click();

                    // Scroll to the selected card
                    if (carousel) {
                        setTimeout(() => {
                            selectedCard.scrollIntoView({behavior: 'smooth', block: 'nearest', inline: 'center'});
                        }, 100);
                    }
                }
            }

            // Synchronize with existing pomodoro dropdown if present
            const pomodoroFocusDropdown = document.getElementById('pomodoro-focus-old');
            if (pomodoroFocusDropdown && focusSlider) {
                // Update dropdown if slider changes
                focusSlider.addEventListener('change', function () {
                    const options = pomodoroFocusDropdown.options;
                    for (let i = 0; i < options.length; i++) {
                        if (options[i].value == this.value) {
                            pomodoroFocusDropdown.selectedIndex = i;
                            break;
                        }
                    }
                });

                // Update slider if dropdown changes
                pomodoroFocusDropdown.addEventListener('change', function () {
                    focusSlider.value = this.value;
                    focusDisplay.textContent = `${this.value} minutes`;
                    updateSliderFill(focusSlider);
                });
            }

            const pomodoroBreakDropdown = document.getElementById('pomodoro-break-old');
            if (pomodoroBreakDropdown && breakSlider) {
                // Update dropdown if slider changes
                breakSlider.addEventListener('change', function () {
                    const options = pomodoroBreakDropdown.options;
                    for (let i = 0; i < options.length; i++) {
                        if (options[i].value == this.value) {
                            pomodoroBreakDropdown.selectedIndex = i;
                            break;
                        }
                    }
                });

                // Update slider if dropdown changes
                pomodoroBreakDropdown.addEventListener('change', function () {
                    breakSlider.value = this.value;
                    breakDisplay.textContent = `${this.value} minutes`;
                    updateSliderFill(breakSlider);
                });
            }
        });
    </script>

    <style>
        .breathing-guide {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .breathing-guide.active {
            opacity: 1;
            pointer-events: auto;
        }

        .breathing-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transform: translateY(30px);
            opacity: 0;
            transition: transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1),
            opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .breathing-guide.active .breathing-wrapper {
            transform: translateY(0);
            opacity: 1;
        }

        .close-breathing {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0.7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2;
        }

        .close-breathing:hover, .close-breathing:focus {
            opacity: 1;
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.2);
            outline: none;
        }

        .breathing-circle-container {
            position: relative;
            width: 250px;
            height: 250px;
            margin-bottom: 30px;
        }

        .breathing-circle {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .breathing-inner-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 30px rgba(66, 153, 225, 0.3);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            will-change: transform, opacity, width, height;
        }

        .breathing-ripple {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.2);
            opacity: 0;
        }

        .breathing-circle.inhale .breathing-inner-circle {
            width: 200px;
            height: 200px;
            background: rgba(104, 211, 245, 0.2);
            box-shadow: 0 0 40px rgba(104, 211, 245, 0.4);
            transition: all 4s cubic-bezier(0.34, 0.13, 0.26, 0.99);
        }

        .breathing-circle.inhale .breathing-ripple {
            animation: ripple-inhale 4s cubic-bezier(0.34, 0.13, 0.26, 0.99) forwards;
        }

        .breathing-circle.hold .breathing-inner-circle {
            width: 200px;
            height: 200px;
            background: rgba(250, 176, 62, 0.2);
            box-shadow: 0 0 40px rgba(250, 176, 62, 0.4);
            animation: pulse 4s ease-in-out infinite;
        }

        .breathing-circle.exhale .breathing-inner-circle {
            width: 150px;
            height: 150px;
            background: rgba(72, 187, 120, 0.2);
            box-shadow: 0 0 30px rgba(72, 187, 120, 0.4);
            transition: all 4s cubic-bezier(0.5, 0, 0.3, 1);
        }

        .breathing-circle.exhale .breathing-ripple {
            animation: ripple-exhale 4s cubic-bezier(0.5, 0, 0.3, 1) forwards;
        }

        .breathing-progress {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
            z-index: 0;
        }

        .breathing-progress-track {
            fill: none;
            stroke: rgba(255, 255, 255, 0.1);
            stroke-width: 3;
        }

        .breathing-progress-indicator {
            fill: none;
            stroke-width: 3;
            stroke-dasharray: 283;
            stroke-dashoffset: 283;
            stroke-linecap: round;
            transition: stroke-dashoffset 0.1s linear;
        }

        .breathing-circle.inhale + svg .breathing-progress-indicator {
            stroke: #68d3f5;
            animation: progress 4s linear forwards;
        }

        .breathing-circle.hold + svg .breathing-progress-indicator {
            stroke: #fab03e;
            animation: progress 4s linear forwards;
        }

        .breathing-circle.exhale + svg .breathing-progress-indicator {
            stroke: #48bb78;
            animation: progress 4s linear forwards;
        }

        .breathing-label {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .breathing-text {
            color: white;
            font-size: 2.2rem;
            font-weight: 300;
            opacity: 0.9;
            margin-bottom: 15px;
            transition: opacity 0.3s ease;
            min-height: 48px;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .breathing-cycles {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .breathing-cycles .cycle {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .breathing-cycles .cycle.active {
            background: rgba(104, 211, 245, 0.7);
            transform: scale(1.2);
        }

        .breathing-cycles .cycle.completed {
            background: rgba(72, 187, 120, 0.7);
        }

        @keyframes ripple-inhale {
            0% {
                width: 150px;
                height: 150px;
                border-width: 2px;
                opacity: 0.7;
            }
            100% {
                width: 260px;
                height: 260px;
                border-width: 1px;
                opacity: 0;
            }
        }

        @keyframes ripple-exhale {
            0% {
                width: 200px;
                height: 200px;
                border-width: 2px;
                opacity: 0.7;
            }
            100% {
                width: 120px;
                height: 120px;
                border-width: 1px;
                opacity: 0;
            }
        }

        @keyframes progress {
            from {
                stroke-dashoffset: 283;
            }
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.03);
            }
            100% {
                transform: scale(1);
            }
        }

        @media (max-width: 600px) {
            .breathing-circle-container {
                width: 200px;
                height: 200px;
            }

            .breathing-inner-circle {
                width: 120px;
                height: 120px;
            }

            .breathing-circle.inhale .breathing-inner-circle {
                width: 160px;
                height: 160px;
            }

            .breathing-circle.hold .breathing-inner-circle {
                width: 160px;
                height: 160px;
            }

            .breathing-text {
                font-size: 1.8rem;
            }

            @keyframes ripple-inhale {
                0% {
                    width: 120px;
                    height: 120px;
                }
                100% {
                    width: 220px;
                    height: 220px;
                }
            }

            @keyframes ripple-exhale {
                0% {
                    width: 160px;
                    height: 160px;
                }
                100% {
                    width: 100px;
                    height: 100px;
                }
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const breatheBtn = document.getElementById('breathe-btn');
            const breathingGuide = document.getElementById('breathing-guide');
            const breathingCircle = document.getElementById('breathing-circle');
            const breathingText = document.getElementById('breathing-text');
            const closeBreathingGuide = document.getElementById('close-breathing-guide');
            const cycleIndicators = document.querySelectorAll('#breathing-cycles .cycle');

            let timeouts = [];
            let breathingInterval = null;
            let isRunning = false;

            // Close button event
            if (closeBreathingGuide) {
                closeBreathingGuide.addEventListener('click', () => endBreathingGuide(true));
            }

            // Breathe button event
            if (breatheBtn) {
                breatheBtn.addEventListener('click', startBreathingGuide);
            }

            // End the breathing guide
            function endBreathingGuide(immediate = false) {
                if (isRunning) {
                    isRunning = false;

                    // Clear all timeouts
                    timeouts.forEach(id => clearTimeout(id));
                    timeouts = [];

                    // Clear interval
                    if (breathingInterval) {
                        clearInterval(breathingInterval);
                        breathingInterval = null;
                    }

                    if (immediate) {
                        // Reset UI immediately
                        breathingGuide.classList.remove('active');
                        breathingCircle.className = 'breathing-circle';

                        // Reset cycle indicators
                        cycleIndicators.forEach(dot => {
                            dot.classList.remove('active', 'completed');
                        });
                        cycleIndicators[0]?.classList.add('active');
                    } else {
                        // Fade out smoothly
                        timeouts.push(setTimeout(() => {
                            // Graceful fade out
                            breathingCircle.className = 'breathing-circle';
                            breathingText.textContent = 'Complete';

                            timeouts.push(setTimeout(() => {
                                breathingGuide.classList.remove('active');

                                // Reset cycle indicators after fade out
                                timeouts.push(setTimeout(() => {
                                    cycleIndicators.forEach(dot => {
                                        dot.classList.remove('active', 'completed');
                                    });
                                    cycleIndicators[0]?.classList.add('active');
                                }, 700));
                            }, 2000));
                        }, 500));
                    }
                }
            }

            // Update cycle indicators
            function updateCycleIndicators(currentCycle) {
                cycleIndicators.forEach((dot, index) => {
                    dot.classList.remove('active');
                    if (index < currentCycle) {
                        dot.classList.add('completed');
                    } else if (index === currentCycle) {
                        dot.classList.add('active');
                    }
                });
            }

            // Start the breathing guide
            function startBreathingGuide() {
                if (isRunning) return;
                isRunning = true;

                // Reset timeouts
                timeouts.forEach(id => clearTimeout(id));
                timeouts = [];

                // Reset cycle indicators
                cycleIndicators.forEach(dot => {
                    dot.classList.remove('active', 'completed');
                });
                cycleIndicators[0]?.classList.add('active');

                // Activate the guide with smooth transition
                breathingGuide.classList.add('active');
                breathingText.textContent = 'Prepare';
                breathingCircle.className = 'breathing-circle';

                // Start breathing sequence after preparation
                timeouts.push(setTimeout(() => {
                    let breathCycle = 0;

                    // Function to run a breath cycle
                    function runBreathCycle() {
                        updateCycleIndicators(breathCycle);

                        // Inhale phase - smooth transition
                        breathingText.textContent = 'Inhale';
                        breathingCircle.className = 'breathing-circle inhale';

                        // Hold phase - smooth transition
                        timeouts.push(setTimeout(() => {
                            breathingText.textContent = 'Hold';
                            breathingCircle.className = 'breathing-circle hold';
                        }, 4000));

                        // Exhale phase - smooth transition
                        timeouts.push(setTimeout(() => {
                            breathingText.textContent = 'Exhale';
                            breathingCircle.className = 'breathing-circle exhale';
                        }, 8000));
                    }

                    // Initial cycle
                    runBreathCycle();

                    // Setup 4 breath cycles with perfect timing
                    breathingInterval = setInterval(() => {
                        breathCycle++;

                        if (breathCycle >= 4) {
                            // End after 4 cycles
                            clearInterval(breathingInterval);
                            breathingInterval = null;

                            // Complete all cycle indicators
                            cycleIndicators.forEach(dot => {
                                dot.classList.remove('active');
                                dot.classList.add('completed');
                            });

                            // Auto-close with delay for smooth experience
                            endBreathingGuide(false);
                        } else {
                            runBreathCycle();
                        }
                    }, 12000); // 12 seconds per full breath cycle
                }, 3000)); // 3 seconds preparation time
            }

            // Escape key to exit
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && breathingGuide.classList.contains('active')) {
                    endBreathingGuide(true);
                }
            });

            // Prevent guide from getting stuck if page is hidden/inactive
            document.addEventListener('visibilitychange', function () {
                if (document.hidden && isRunning) {
                    endBreathingGuide(true);
                }
            });
        });
    </script>

    <style>
        /* Animations and transitions */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(76, 76, 76);
            }
            70% {
                box-shadow: 0 0 0 6px rgba(74, 222, 128, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(74, 222, 128, 0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }

        .animate-pulse-green {
            animation: pulse 2s infinite;
        }

        /* Enhanced input styles */
        .intent-input-container {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .intent-input-container:focus-within {
            border-color:rgb(76, 76, 76);
            box-shadow: 0 0 0 2px rgba(76, 76, 76, 0.2);
        }

        #session-intent:focus + div #clear-intent {
            opacity: 1;
        }

        /* Dropdowns */
        .suggestions-dropdown, .history-dropdown {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease-out;
        }

        .suggestions-dropdown.visible, .history-dropdown.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Active intent styling */
        #active-intent-card {
            transition: all 0.3s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .intent-input-container {
                padding: 0.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Elements
            const sessionIntent = document.getElementById('session-intent');
            const clearIntentBtn = document.getElementById('clear-intent');
            const wordCount = document.getElementById('intent-word-count');
            const suggestionsBtn = document.getElementById('session-intent-suggestions');
            const suggestionsDropdown = document.getElementById('intent-suggestions');
            const suggestionItems = document.querySelectorAll('.suggestion-item');
            const historyBtn = document.getElementById('session-intent-history');
            const historyDropdown = document.getElementById('intent-history');
            const historyItems = document.querySelectorAll('.history-item');
            const clearHistoryBtn = document.getElementById('clear-history');
            const activeIntentCard = document.getElementById('active-intent-card');
            const activeIntentText = document.getElementById('active-intent-text');

            // Variables
            let intentHistory = JSON.parse(localStorage.getItem('intentHistory') || '[]');
            let currentDropdown = null;

            // Function to update word count
            function updateWordCount() {
                const count = sessionIntent.value.length;
                wordCount.textContent = `${count}/100`;

                // Change color when approaching limit
                if (count > 80) {
                    wordCount.classList.add('text-yellow-500');
                    wordCount.classList.remove('text-gray-400', 'text-red-500');
                } else if (count > 100) {
                    wordCount.classList.add('text-red-500');
                    wordCount.classList.remove('text-gray-400', 'text-yellow-500');
                } else {
                    wordCount.classList.add('text-gray-400');
                    wordCount.classList.remove('text-yellow-500', 'text-red-500');
                }

                // Show/hide clear button
                if (count > 0) {
                    clearIntentBtn.style.opacity = '1';
                } else {
                    clearIntentBtn.style.opacity = '0';
                }
            }

            // Function to toggle dropdown visibility
            function toggleDropdown(dropdown) {
                // Close current dropdown if open
                if (currentDropdown && currentDropdown !== dropdown) {
                    currentDropdown.classList.remove('visible');
                    currentDropdown.classList.add('hidden');
                }

                // Toggle clicked dropdown
                if (dropdown.classList.contains('hidden')) {
                    dropdown.classList.remove('hidden');
                    setTimeout(() => dropdown.classList.add('visible'), 10);
                    currentDropdown = dropdown;
                } else {
                    dropdown.classList.remove('visible');
                    setTimeout(() => dropdown.classList.add('hidden'), 200);
                    currentDropdown = null;
                }
            }

            // Function to add intent to history
            function addToHistory(intent) {
                if (!intent.trim()) return;

                // Remove if already exists
                intentHistory = intentHistory.filter(item => item.text !== intent);

                // Add to beginning
                intentHistory.unshift({
                    text: intent,
                    timestamp: new Date().toISOString()
                });

                // Limit history to 10 items
                if (intentHistory.length > 10) {
                    intentHistory.pop();
                }

                // Save to localStorage
                localStorage.setItem('intentHistory', JSON.stringify(intentHistory));

                // Update history list
                updateHistoryList();
            }

            // Function to update history list in UI
            function updateHistoryList() {
                const historyList = document.getElementById('history-list');
                historyList.innerHTML = '';

                if (intentHistory.length === 0) {
                    historyList.innerHTML = '<li class="px-3 py-2 text-gray-500 dark:text-gray-400 text-sm">No history yet</li>';
                    return;
                }

                intentHistory.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'history-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200 flex justify-between items-center';

                    // Format timestamp
                    const timestamp = new Date(item.timestamp);
                    const now = new Date();
                    let timeText;

                    if (timestamp.toDateString() === now.toDateString()) {
                        timeText = 'Today';
                    } else if (new Date(now - 86400000).toDateString() === timestamp.toDateString()) {
                        timeText = 'Yesterday';
                    } else {
                        timeText = timestamp.toLocaleDateString();
                    }

                    li.innerHTML = `
                <span>${item.text}</span>
                <span class="text-xs text-gray-500">${timeText}</span>
            `;

                    li.addEventListener('click', () => {
                        sessionIntent.value = item.text;
                        updateWordCount();
                        toggleDropdown(historyDropdown);
                    });

                    historyList.appendChild(li);
                });
            }

            // Function to activate intent UI when session starts
            function activateIntent() {
                const intentText = sessionIntent.value.trim();
                if (!intentText) return;

                // Set active intent text
                activeIntentText.textContent = intentText;

                // Show active intent card with animation
                activeIntentCard.classList.remove('hidden');

                // Add to history
                addToHistory(intentText);
            }

            // Event for start focus button
            const startFocusBtn = document.querySelector('#start-btn, button.start-btn, button:contains("Start Focus")');
            if (startFocusBtn) {
                const originalClick = startFocusBtn.onclick;
                startFocusBtn.onclick = function (e) {
                    activateIntent();
                    if (originalClick) {
                        return originalClick.call(this, e);
                    }
                };
            }

            // Initialize
            updateWordCount();
            updateHistoryList();

            // Event Listeners
            sessionIntent.addEventListener('input', updateWordCount);

            clearIntentBtn.addEventListener('click', function () {
                sessionIntent.value = '';
                updateWordCount();
                sessionIntent.focus();
            });

            suggestionsBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleDropdown(suggestionsDropdown);
            });

            historyBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleDropdown(historyDropdown);
            });

            suggestionItems.forEach(item => {
                item.addEventListener('click', function () {
                    sessionIntent.value = this.textContent.trim();
                    updateWordCount();
                    toggleDropdown(suggestionsDropdown);
                    sessionIntent.focus();
                });
            });

            clearHistoryBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (confirm('Clear all intent history?')) {
                    intentHistory = [];
                    localStorage.setItem('intentHistory', JSON.stringify(intentHistory));
                    updateHistoryList();
                }
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function (e) {
                if (currentDropdown &&
                    !currentDropdown.contains(e.target) &&
                    e.target !== suggestionsBtn &&
                    e.target !== historyBtn) {
                    toggleDropdown(currentDropdown);
                }
            });

            // Close dropdowns when pressing escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && currentDropdown) {
                    toggleDropdown(currentDropdown);
                }
            });

            // Handle session complete event to reset intent
            const completeBtn = document.getElementById('complete-btn');
            if (completeBtn) {
                const originalCompleteClick = completeBtn.onclick;
                completeBtn.onclick = function (e) {
                    setTimeout(() => {
                        activeIntentCard.classList.add('hidden');
                    }, 500);

                    if (originalCompleteClick) {
                        return originalCompleteClick.call(this, e);
                    }
                };
            }
        });
    </script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>