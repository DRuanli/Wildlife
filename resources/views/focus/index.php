<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary-color: #4D724D;
            --primary-light: #C4D7C4;
            --primary-dark: #2F4F2F;
            --accent-color: #CE6246;
            --neutral-light: #F9F8F2;
            --neutral-dark: #333333;
            --forest: #2d6a4f;
            --ocean: #1e40af;
            --mountain: #7f1d1d;
            --sky: #0369a1;
            --cosmic: #4c1d95;
            --enchanted: #9d174d;
            
            /* Dark mode colors */
            --dark-bg: #121212;
            --dark-surface: #1e1e1e;
            --dark-text: #e0e0e0;
            --dark-text-secondary: #a0a0a0;
        }

        body {
            background-color: var(--neutral-light);
            transition: background-color 0.5s ease;
        }
        
        body.dark-mode {
            background-color: var(--dark-bg);
            color: var(--dark-text);
        }
        
        body.dark-mode .bg-white {
            background-color: var(--dark-surface) !important;
            color: var(--dark-text);
        }
        
        body.dark-mode .text-gray-800 {
            color: var(--dark-text) !important;
        }
        
        body.dark-mode .text-gray-600 {
            color: var(--dark-text-secondary) !important;
        }
        
        body.fullscreen-mode {
            overflow: hidden;
        }

        /* Focus timer styles */
        .timer-container {
            position: relative;
            width: 280px;
            height: 280px;
            transition: transform 0.5s ease;
        }
        
        .fullscreen-mode .timer-container {
            width: 400px;
            height: 400px;
            margin: 0 auto;
        }

        .timer-circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .timer-background {
            background-color: #f5f5f5;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }
        
        body.dark-mode .timer-background {
            background-color: #2a2a2a;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .timer-progress {
            background: conic-gradient(var(--primary-color) 0%, transparent 0%);
            transition: background 0.1s linear;
            z-index: 2;
        }

        .timer-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 3;
        }

        .timer-inner {
            width: 85%;
            height: 85%;
            background-color: white;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
            transition: background-color 0.5s ease;
        }
        
        body.dark-mode .timer-inner {
            background-color: #333;
        }


        /* 3D model container */
        .model-container {
            position: relative;
            width: 100%;
            height: 650px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.5s ease;
        }
        
        body.dark-mode .model-container {
            background-color: rgba(40, 40, 40, 0.7);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }
        
        .fullscreen-mode .model-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            border-radius: 0;
        }

        .model-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        .habitat-type-indicator {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 12px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 10;
            transition: all 0.3s ease;
        }
        
        body.dark-mode .habitat-type-indicator {
            background-color: rgba(60, 60, 60, 0.8);
        }

        .creature-info-panel {
            position: absolute;
            bottom: 10px;
            left: 10px;
            right: 10px;
            padding: 10px 15px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
            transition: all 0.3s ease;
        }
        
        body.dark-mode .creature-info-panel {
            background-color: rgba(60, 60, 60, 0.9);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
        }

        /* Progress bars */
        .progress-bar {
            height: 6px;
            border-radius: 3px;
            background-color: #e5e7eb;
            overflow: hidden;
        }
        
        body.dark-mode .progress-bar {
            background-color: #555;
        }

        .progress-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.5s ease-out;
        }

        /* Lifecycle badges */
        .badge-egg {
            background-color: #e5e7eb;
            color: #4b5563;
        }

        .badge-baby {
            background-color: #c6f6d5;
            color: #047857;
        }

        .badge-juvenile {
            background-color: #bbdefb;
            color: #1e40af;
        }

        .badge-adult {
            background-color: #c084fc;
            color: #6b21a8;
        }

        .badge-mythical {
            background-color: #fcd34d;
            color: #92400e;
        }

        /* Focus mode transition */
        .focus-mode-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 30;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.8s ease;
            backdrop-filter: blur(3px);
        }

        .focus-mode-active .focus-mode-overlay {
            opacity: 1;
            pointer-events: auto;
        }
        .focus-mode-content {
            transition: all 0.5s ease;
            z-index: 40;
        }

        .focus-mode-active .focus-mode-content {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.15);
        }
        
        .fullscreen-mode .focus-content-wrapper {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50;
            width: 90%;
            max-width: 500px;
        }
        .focus-content-wrapper {
            position: relative;
            z-index: 40;
            transition: all 0.5s ease;
        }

        /* Button effects */
        .focus-btn {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            animation: gentle-pulse 3s infinite;
            transform: scale(1.05);
        }

        .start-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(76, 175, 80, 0.3);
            animation: gentle-pulse 3s infinite;
            transform: scale(1.05);
        }

        .focus-btn:before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(45deg);
            animation: shine 6s infinite;
            pointer-events: none;
        }

        .start-btn:active {
            transform: translateY(0) scale(1.02);
            box-shadow: 0 2px 10px rgba(76, 175, 80, 0.3);
        }

        .focus-btn:hover {
            transform: translateY(-3px) scale(1.08);
            box-shadow: 0 7px 20px rgba(0, 0, 0, 0.1);
        }

        .focus-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        @keyframes gentle-pulse {
            0% {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            }
            50% {
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            }
            100% {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            }
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
            30%, 100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }
        
        /* Theme toggle */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
            cursor: pointer;
            background-color: #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        body.dark-mode .theme-toggle {
            background-color: #333;
            color: #fff;
        }
        
        /* Fullscreen toggle */
        .fullscreen-toggle {
            position: fixed;
            top: 20px;
            right: 70px;
            z-index: 100;
            cursor: pointer;
            background-color: #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        body.dark-mode .fullscreen-toggle {
            background-color: #333;
            color: #fff;
        }
        
        /* Ambient sounds player */
        .ambient-player {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            background-color: #fff;
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            width: 280px;
            overflow: hidden;
        }
        
        body.dark-mode .ambient-player {
            background-color: #333;
            color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
        }
        
        .ambient-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 101;
            cursor: pointer;
            background-color: #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        body.dark-mode .ambient-toggle {
            background-color: #333;
            color: #fff;
        }
        
        .ambient-control {
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            margin: 5px 3px;
            text-align: center;
            transition: all 0.2s ease;
        }
        
        .ambient-control:hover {
            background-color: #f3f4f6;
        }
        
        body.dark-mode .ambient-control:hover {
            background-color: #444;
        }
        
        .ambient-control.active {
            background-color: var(--primary-light);
            color: var(--primary-dark);
        }
        
        body.dark-mode .ambient-control.active {
            background-color: var(--primary-dark);
            color: var(--primary-light);
        }
        
        /* Pomodoro settings */
        .pomodoro-settings {
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f9fafb;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        body.dark-mode .pomodoro-settings {
            background-color: #2a2a2a;
        }
        
        /* Quote display */
        .focus-quote {
            text-align: center;
            font-style: italic;
            margin: 1rem 0;
            padding: 1rem;
            border-radius: 8px;
            background-color: #f9fafb;
            transition: all 0.3s ease;
        }
        
        body.dark-mode .focus-quote {
            background-color: #2a2a2a;
        }
        
        /* Breathing guide */
        .breathing-guide {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s ease;
        }
        
        .breathing-guide.active {
            opacity: 1;
            pointer-events: auto;
        }
        
        .breathing-circle {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            border: 2px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #fff;
            animation: none;
        }
        
        .breathing-circle.inhale {
            animation: inhale 4s ease-in-out;
        }
        
        .breathing-circle.hold {
            animation: none;
        }
        
        .breathing-circle.exhale {
            animation: exhale 4s ease-in-out;
        }
        
        @keyframes inhale {
            from { transform: scale(1); }
            to { transform: scale(1.5); }
        }
        
        @keyframes exhale {
            from { transform: scale(1.5); }
            to { transform: scale(1); }
        }
        
        /* Session intent */
        .session-intent {
            margin-bottom: 1rem;
        }
        
        /* Distraction log */
        .distraction-log {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 100;
            background-color: #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        body.dark-mode .distraction-log {
            background-color: #333;
            color: #fff;
        }
        
        .distraction-panel {
            position: fixed;
            bottom: 70px;
            left: 20px;
            z-index: 100;
            background-color: #fff;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 280px;
            max-height: 400px;
            overflow-y: auto;
            transform: translateY(20px);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        
        .distraction-panel.active {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }
        
        body.dark-mode .distraction-panel {
            background-color: #333;
            color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
        }

        /* Animations */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .timer-container {
                width: 220px;
                height: 220px;
            }

            .model-container {
                height: 250px;
            }
            
            .theme-toggle, .fullscreen-toggle {
                top: 10px;
                width: 36px;
                height: 36px;
            }
            
            .fullscreen-toggle {
                right: 56px;
            }
        }
    </style>

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

    <!-- Focus Page JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Theme variables
            let darkModeEnabled = false;
            let fullscreenEnabled = false;
            
            // Ambient sound variables
            let currentSound = null;
            let currentVolume = 0.5;
            
            // Focus quotes
            const focusQuotes = [
                { text: "The successful warrior is the average man, with laser-like focus.", author: "Bruce Lee" },
                { text: "Concentrate all your thoughts upon the work in hand. The sun's rays do not burn until brought to a focus.", author: "Alexander Graham Bell" },
                { text: "It's not that I'm so smart, it's just that I stay with problems longer.", author: "Albert Einstein" },
                { text: "Where focus goes, energy flows.", author: "Tony Robbins" },
                { text: "Focus on the journey, not the destination. Joy is found not in finishing an activity but in doing it.", author: "Greg Anderson" },
                { text: "Lack of direction, not lack of time, is the problem. We all have twenty-four hour days.", author: "Zig Ziglar" },
                { text: "Your focus determines your reality.", author: "George Lucas" },
                { text: "Don't dwell on what went wrong. Instead, focus on what to do next.", author: "Denis Waitley" },
                { text: "Focus is a matter of deciding what things you're not going to do.", author: "John Carmack" },
                { text: "Simplicity is the ultimate sophistication.", author: "Leonardo da Vinci" }
            ];
            
            // Set a random quote
            function setRandomQuote() {
                const quoteIndex = Math.floor(Math.random() * focusQuotes.length);
                const quote = focusQuotes[quoteIndex];
                document.getElementById('focus-quote-text').textContent = `"${quote.text}"`;
                document.getElementById('focus-quote-author').textContent = `— ${quote.author}`;
            }
            
            // Set initial quote
            setRandomQuote();

            // Timer variables
            let timerInterval;
            let timerRunning = false;
            let timerPaused = false;
            let sessionDuration = 25 * 60; // 25 minutes in seconds
            let timeRemaining = sessionDuration;
            let startTime;
            let pauseTime;
            let activeSessionId;
            let selectedCreatureId;
            let selectedCreatureData = {};
            let pomodoroCount = 0;
            let isBreak = false;
            let autoStartEnabled = false;
            
            // Track distractions
            let distractions = [];

            // DOM elements
            const timerDisplay = document.getElementById('timer-display');
            const timerStatus = document.getElementById('timer-status');
            const timerProgress = document.getElementById('timer-progress');
            const startBtn = document.getElementById('start-btn');
            const pauseBtn = document.getElementById('pause-btn');
            const resumeBtn = document.getElementById('resume-btn');
            const completeBtn = document.getElementById('complete-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const breatheBtn = document.getElementById('breathe-btn');
            const timerSettings = document.getElementById('timer-settings');
            const creatureSelect = document.getElementById('creature-select');
            const focusModeOverlay = document.getElementById('focus-mode-overlay');
            const focusApp = document.getElementById('focus-app');
            const themeToggle = document.getElementById('theme-toggle');
            const fullscreenToggle = document.getElementById('fullscreen-toggle');
            const ambientToggle = document.getElementById('ambient-toggle');
            const ambientPlayer = document.getElementById('ambient-player');
            const ambientControls = document.querySelectorAll('.ambient-control');
            const volumeControl = document.getElementById('volume-control');
            const breathingGuide = document.getElementById('breathing-guide');
            const breathingCircle = document.getElementById('breathing-circle');
            const breathingText = document.getElementById('breathing-text');
            const pomodoroFocusSelect = document.getElementById('pomodoro-focus');
            const pomodoroBreakSelect = document.getElementById('pomodoro-break');
            const pomodoroAutoCheck = document.getElementById('pomodoro-auto');
            const sessionIntent = document.getElementById('session-intent');
            const distractionLog = document.getElementById('distraction-log');
            const distractionPanel = document.getElementById('distraction-panel');
            const distractionForm = document.getElementById('distraction-form');
            const distractionInput = document.getElementById('distraction-input');
            const distractionType = document.getElementById('distraction-type');
            const distractionList = document.getElementById('distraction-list');

            // 3D model display elements
            const modelPlaceholder = document.getElementById('model-placeholder');
            const modelDisplay = document.getElementById('model-display');
            const habitatTypeIndicator = document.getElementById('habitat-type');
            const creatureInfoPanel = document.getElementById('creature-info-panel');
            const creatureNameDisplay = document.getElementById('creature-name');
            const creatureStageDisplay = document.getElementById('creature-stage');
            const creatureHealthDisplay = document.getElementById('creature-health');
            const creatureHappinessDisplay = document.getElementById('creature-happiness');
            const growthPercentageDisplay = document.getElementById('growth-percentage');
            const growthBar = document.getElementById('growth-bar');

            // Control buttons
            const rotateLeftBtn = document.getElementById('rotate-left-btn');
            const rotateRightBtn = document.getElementById('rotate-right-btn');
            const zoomInBtn = document.getElementById('zoom-in-btn');
            const zoomOutBtn = document.getElementById('zoom-out-btn');
            const resetViewBtn = document.getElementById('reset-view-btn');

            // Modal elements
            const completeModal = document.getElementById('complete-modal');
            const closeCompleteModal = document.getElementById('close-complete-modal');
            const viewSummaryBtn = document.getElementById('view-summary-btn');
            const startNewSessionBtn = document.getElementById('start-new-session-btn');
            const completedDuration = document.getElementById('completed-duration');
            const resultFocusScore = document.getElementById('result-focus-score');
            const resultCoins = document.getElementById('result-coins');
            const resultCreatureGrowth = document.getElementById('result-creature-growth');
            
            // Theme toggle functionality
            themeToggle.addEventListener('click', function() {
                const body = document.body;
                darkModeEnabled = !darkModeEnabled;
                
                if (darkModeEnabled) {
                    body.classList.add('dark-mode');
                    this.innerHTML = '<i class="fas fa-sun"></i>';
                } else {
                    body.classList.remove('dark-mode');
                    this.innerHTML = '<i class="fas fa-moon"></i>';
                }
            });
            
            // Fullscreen toggle functionality
            fullscreenToggle.addEventListener('click', function() {
                const body = document.body;
                fullscreenEnabled = !fullscreenEnabled;
                
                if (fullscreenEnabled) {
                    body.classList.add('fullscreen-mode');
                    this.innerHTML = '<i class="fas fa-compress"></i>';
                } else {
                    body.classList.remove('fullscreen-mode');
                    this.innerHTML = '<i class="fas fa-expand"></i>';
                }
            });
            
            // Ambient sound functionality
            ambientToggle.addEventListener('click', function() {
                if (ambientPlayer.style.display === 'none') {
                    ambientPlayer.style.display = 'block';
                } else {
                    ambientPlayer.style.display = 'none';
                }
            });
            
            // Volume control
            volumeControl.addEventListener('input', function() {
                currentVolume = this.value / 100;
                if (currentSound) {
                    const audio = document.getElementById(`sound-${currentSound}`);
                    audio.volume = currentVolume;
                }
            });
            
            // Ambient sound selectors
            ambientControls.forEach(control => {
                control.addEventListener('click', function() {
                    const soundName = this.dataset.sound;
                    
                    // Stop current sound if playing
                    if (currentSound) {
                        const currentAudio = document.getElementById(`sound-${currentSound}`);
                        currentAudio.pause();
                        currentAudio.currentTime = 0;
                        document.querySelector(`.ambient-control[data-sound="${currentSound}"]`).classList.remove('active');
                    }
                    
                    // If clicked on already active sound, just stop it
                    if (currentSound === soundName) {
                        currentSound = null;
                        return;
                    }
                    
                    // Start new sound
                    currentSound = soundName;
                    const audio = document.getElementById(`sound-${soundName}`);
                    audio.volume = currentVolume;
                    audio.play();
                    this.classList.add('active');
                });
            });
            
            // Breathing guide functionality
            breatheBtn.addEventListener('click', startBreathingGuide);
            
            function startBreathingGuide() {
                breathingGuide.classList.add('active');
                breathingText.textContent = 'Prepare';
                
                // Start breathing sequence
                setTimeout(() => {
                    let breathCycle = 0;
                    
                    function runBreathCycle() {
                        // Inhale
                        breathingText.textContent = 'Inhale';
                        breathingCircle.className = 'breathing-circle inhale';
                        
                        // Hold
                        setTimeout(() => {
                            breathingText.textContent = 'Hold';
                            breathingCircle.className = 'breathing-circle hold';
                        }, 4000);
                        
                        // Exhale
                        setTimeout(() => {
                            breathingText.textContent = 'Exhale';
                            breathingCircle.className = 'breathing-circle exhale';
                        }, 8000);
                    }
                    
                    // Initial cycle
                    runBreathCycle();
                    
                    // Set up interval for 4 breath cycles
                    const breathInterval = setInterval(() => {
                        breathCycle++;
                        if (breathCycle >= 4) {
                            clearInterval(breathInterval);
                            setTimeout(() => {
                                breathingGuide.classList.remove('active');
                                breathingCircle.className = 'breathing-circle';
                            }, 4000);
                        } else {
                            runBreathCycle();
                        }
                    }, 12000);
                }, 2000);
            }
            
            // Distraction logging functionality
            distractionLog.addEventListener('click', function() {
                distractionPanel.classList.toggle('active');
            });
            
            distractionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const distractionText = distractionInput.value.trim();
                if (!distractionText) return;
                
                const distractionCategory = distractionType.value;
                const timestamp = new Date();
                
                // Add to distractions array
                distractions.push({
                    text: distractionText,
                    type: distractionCategory,
                    timestamp: timestamp
                });
                
                // Add to UI
                updateDistractionList();
                
                // Clear form
                distractionInput.value = '';
                
                // Focus back on the input for easy logging
                distractionInput.focus();
            });
            
            function updateDistractionList() {
                // Clear current list
                distractionList.innerHTML = '';
                
                // Sort by most recent first
                const sortedDistractions = [...distractions].sort((a, b) => b.timestamp - a.timestamp);
                
                // Show up to 5 most recent
                const recentDistractions = sortedDistractions.slice(0, 5);
                
                // Add to list
                recentDistractions.forEach(distraction => {
                    const distractionItem = document.createElement('div');
                    distractionItem.className = 'p-2 bg-gray-50 dark:bg-gray-800 rounded';
                    
                    // Get icon for type
                    let typeIcon;
                    switch(distraction.type) {
                        case 'thought': typeIcon = 'fa-brain'; break;
                        case 'notification': typeIcon = 'fa-bell'; break;
                        case 'noise': typeIcon = 'fa-volume-up'; break;
                        case 'person': typeIcon = 'fa-user'; break;
                        default: typeIcon = 'fa-question-circle';
                    }
                    
                    // Format time
                    const timeString = distraction.timestamp.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    
                    distractionItem.innerHTML = `
                        <div class="flex items-start">
                            <i class="fas ${typeIcon} text-gray-500 mt-1 mr-2"></i>
                            <div>
                                <p class="text-sm">${distraction.text}</p>
                                <p class="text-xs text-gray-500">${timeString}</p>
                            </div>
                        </div>
                    `;
                    
                    distractionList.appendChild(distractionItem);
                });
                
                // Add empty state if no distractions
                if (distractions.length === 0) {
                    distractionList.innerHTML = '<p class="text-sm text-gray-500 text-center">No distractions logged yet</p>';
                }
            }

            // Helper functions for the timer
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const secs = seconds % 60;
                return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }

            function updateTimerDisplay() {
                timerDisplay.textContent = formatTime(timeRemaining);

                // Update timer progress circle
                const progressPercent = ((sessionDuration - timeRemaining) / sessionDuration) * 100;
                timerProgress.style.background = `conic-gradient(var(--primary-color) ${progressPercent}%, transparent 0%)`;
            }

            function startTimer() {
                if (timerRunning) return;

                // Get selected creature
                selectedCreatureId = creatureSelect.value;

                if (selectedCreatureId) {
                    // Save selected creature data
                    const selectedOption = creatureSelect.options[creatureSelect.selectedIndex];
                    selectedCreatureData = {
                        id: selectedCreatureId,
                        name: selectedOption.dataset.name,
                        stage: selectedOption.dataset.stage,
                        species: selectedOption.dataset.species,
                        habitat: selectedOption.dataset.habitat,
                        health: selectedOption.dataset.health,
                        happiness: selectedOption.dataset.happiness,
                        growth: selectedOption.dataset.growth
                    };

                    // Update creature display
                    updateCreatureDisplay();
                }

                // Hide settings, show control buttons
                timerSettings.classList.add('hidden');
                startBtn.classList.add('hidden');
                breatheBtn.classList.add('hidden');
                pauseBtn.classList.remove('hidden');
                cancelBtn.classList.remove('hidden');

                // Start new focus session
                startTime = new Date();
                timerRunning = true;
                
                // Check if this is a break or focus session
                if (isBreak) {
                    timerStatus.textContent = 'On break...';
                } else {
                    timerStatus.textContent = 'Focusing...';
                    
                    // Only create backend session for focus sessions, not breaks
                    createBackendSession();
                }

                // Enter focus mode
                focusApp.classList.add('focus-mode-active');

                // Start countdown
                timerInterval = setInterval(function () {
                    if (timeRemaining <= 0) {
                        clearInterval(timerInterval);
                        
                        if (isBreak) {
                            // Break is over, start a new focus session
                            completeBreak();
                        } else {
                            // Focus session is over
                            completeSession();
                        }
                    } else {
                        timeRemaining--;
                        updateTimerDisplay();
                    }
                }, 1000);
                
                // Save auto-start setting
                autoStartEnabled = pomodoroAutoCheck.checked;
            }
            
            function createBackendSession() {
                // Create focus session in backend
                fetch('<?= $baseUrl ?>/focus/session/start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        duration: sessionDuration / 60,
                        creature_id: selectedCreatureId || null
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            activeSessionId = data.session.id;
                        } else {
                            console.error('Failed to start session:', data.message);
                            resetTimer();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resetTimer();
                    });
            }
            
            function completeBreak() {
                // Break is over, start a new focus session if auto-start is enabled
                isBreak = false;
                resetTimer(false); // Don't reset UI elements
                
                // Set duration back to focus time
                sessionDuration = parseInt(pomodoroFocusSelect.value) * 60;
                timeRemaining = sessionDuration;
                updateTimerDisplay();
                
                // Update UI
                timerStatus.textContent = 'Ready to focus';
                
                // Auto-start next focus session if enabled
                if (autoStartEnabled) {
                    setTimeout(() => {
                        startTimer();
                    }, 2000);
                } else {
                    // Show start button
                    startBtn.classList.remove('hidden');
                    breatheBtn.classList.remove('hidden');
                }
            }

            function pauseTimer() {
                if (!timerRunning || timerPaused) return;

                clearInterval(timerInterval);
                timerPaused = true;
                pauseTime = new Date();

                pauseBtn.classList.add('hidden');
                resumeBtn.classList.remove('hidden');
                completeBtn.classList.remove('hidden');

                timerStatus.textContent = 'Paused';
            }

            function resumeTimer() {
                if (!timerRunning || !timerPaused) return;

                timerPaused = false;

                resumeBtn.classList.add('hidden');
                completeBtn.classList.add('hidden');
                pauseBtn.classList.remove('hidden');

                if (isBreak) {
                    timerStatus.textContent = 'On break...';
                } else {
                    timerStatus.textContent = 'Focusing...';
                }

                timerInterval = setInterval(function () {
                    if (timeRemaining <= 0) {
                        if (isBreak) {
                            completeBreak();
                        } else {
                            completeSession();
                        }
                    } else {
                        timeRemaining--;
                        updateTimerDisplay();
                    }
                }, 1000);
            }

            function completeSession() {
                clearInterval(timerInterval);

                // Calculate actual duration and focus score
                const endTime = new Date();
                const focusScore = calculateFocusScore(startTime, endTime, pauseTime);

                // Complete the session in backend
                fetch('<?= $baseUrl ?>/focus/session/complete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        session_id: activeSessionId,
                        focus_score: focusScore
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showCompletionModal(data);
                        } else {
                            console.error('Failed to complete session:', data.message);
                        }
                        
                        // Start break if using pomodoro technique
                        pomodoroCount++;
                        startBreak();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resetTimer();
                    });
            }
            
            function startBreak() {
                // Start a break after completing a focus session
                isBreak = true;
                resetTimer(false); // Don't reset UI completely
                
                // Set duration to break time
                sessionDuration = parseInt(pomodoroBreakSelect.value) * 60;
                timeRemaining = sessionDuration;
                updateTimerDisplay();
                
                // Update UI
                timerStatus.textContent = 'Take a break';
                
                // Auto-start break if enabled
                if (autoStartEnabled) {
                    setTimeout(() => {
                        startTimer();
                    }, 2000);
                } else {
                    // Show start button
                    startBtn.classList.remove('hidden');
                    breatheBtn.classList.remove('hidden');
                }
            }

            function cancelSession() {
                if (!confirm('Are you sure you want to cancel this focus session? Progress will be lost.')) {
                    return;
                }

                clearInterval(timerInterval);

                // Cancel the session in backend if there's an active session and not in break mode
                if (activeSessionId && !isBreak) {
                    fetch('<?= $baseUrl ?>/focus/session/cancel', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            session_id: activeSessionId
                        }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                console.error('Failed to cancel session:', data.message);
                            }
                            resetTimer();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            resetTimer();
                        });
                } else {
                    resetTimer();
                }
                
                // Reset break status
                isBreak = false;
            }

            function resetTimer(resetUI = true) {
                // Clear timer and reset state
                clearInterval(timerInterval);
                timerRunning = false;
                timerPaused = false;
                timeRemaining = sessionDuration;
                activeSessionId = null;

                // Reset UI
                updateTimerDisplay();
                timerStatus.textContent = isBreak ? 'Take a break' : 'Ready to focus';

                // Hide control buttons, show settings
                startBtn.classList.remove('hidden');
                breatheBtn.classList.remove('hidden');
                pauseBtn.classList.add('hidden');
                resumeBtn.classList.add('hidden');
                completeBtn.classList.add('hidden');
                cancelBtn.classList.add('hidden');
                
                // Only show settings if we're doing a full reset
                if (resetUI) {
                    timerSettings.classList.remove('hidden');
                    
                    // Exit focus mode
                    focusApp.classList.remove('focus-mode-active');
                }
            }

            function calculateFocusScore(start, end, pauseMoment) {
                // Base score is 100
                let score = 100;
                
                // Deduct if paused
                if (pauseMoment) {
                    score -= 10;
                }
                
                // Deduct for distractions (5 points per distraction, max 25 points)
                if (distractions.length > 0) {
                    // Only count distractions logged during this session
                    const sessionDistractions = distractions.filter(d => d.timestamp >= start && d.timestamp <= end);
                    const distractionPenalty = Math.min(25, sessionDistractions.length * 5);
                    score -= distractionPenalty;
                }
                
                // Add some randomness (just for demo purposes)
                score += Math.floor(Math.random() * 10) - 5;
                
                // Ensure score is within 0-100 range
                return Math.min(100, Math.max(0, score));
            }

            function showCompletionModal(data) {
                // Update modal content
                completedDuration.textContent = sessionDuration / 60;
                resultFocusScore.textContent = `${data.session.focus_score}%`;
                resultCoins.textContent = data.coins_earned;

                // Show creature growth if applicable
                if (data.creature) {
                    resultCreatureGrowth.classList.remove('hidden');
                    document.getElementById('result-creature-name').textContent = data.creature.name;

                    // Set appropriate icon based on creature stage
                    const creatureIcon = document.getElementById('result-creature-icon');
                    switch (data.creature.stage) {
                        case 'egg':
                            creatureIcon.innerHTML = '<i class="fas fa-egg text-yellow-500 text-xl"></i>';
                            break;
                        case 'baby':
                            creatureIcon.innerHTML = '<i class="fas fa-baby text-green-500 text-xl"></i>';
                            break;
                        case 'juvenile':
                            creatureIcon.innerHTML = '<i class="fas fa-paw text-blue-500 text-xl"></i>';
                            break;
                        case 'adult':
                            creatureIcon.innerHTML = '<i class="fas fa-dragon text-purple-500 text-xl"></i>';
                            break;
                        case 'mythical':
                            creatureIcon.innerHTML = '<i class="fas fa-dragon text-yellow-500 text-xl"></i>';
                            break;
                    }

                    // Update growth progress
                    let growthPercentage = 0;
                    if (data.creature.stage === 'egg') {
                        growthPercentage = (data.creature.growth_progress / 100) * 100;
                    } else if (data.creature.stage === 'mythical') {
                        growthPercentage = 100;
                    } else {
                        growthPercentage = (data.creature.growth_progress / 200) * 100;
                    }

                    document.getElementById('result-growth-bar').style.width = `${growthPercentage}%`;
                    document.getElementById('result-growth-text').textContent = `+${data.session.duration_minutes} points`;

                    // Configure view summary button
                    viewSummaryBtn.onclick = function () {
                        window.location.href = `<?= $baseUrl ?>/focus/summary/${data.session.id}`;
                    };
                } else {
                    resultCreatureGrowth.classList.add('hidden');

                    // Configure view summary button for no creature
                    viewSummaryBtn.onclick = function () {
                        window.location.href = `<?= $baseUrl ?>/focus/summary/${data.session.id}`;
                    };
                }

                // Show modal
                completeModal.classList.remove('hidden');
            }

            // Event listeners
            startBtn.addEventListener('click', startTimer);
            pauseBtn.addEventListener('click', pauseTimer);
            resumeBtn.addEventListener('click', resumeTimer);
            completeBtn.addEventListener('click', completeSession);
            cancelBtn.addEventListener('click', cancelSession);

            // Set session duration when selecting from Pomodoro settings
            pomodoroFocusSelect.addEventListener('change', function() {
                const minutes = parseInt(this.value);
                sessionDuration = minutes * 60;
                timeRemaining = sessionDuration;
                updateTimerDisplay();
            });

            // Creature select listener
            creatureSelect.addEventListener('change', function () {
                selectedCreatureId = this.value;
                if (selectedCreatureId) {
                    const selectedOption = this.options[this.selectedIndex];
                    selectedCreatureData = {
                        id: selectedCreatureId,
                        name: selectedOption.dataset.name,
                        stage: selectedOption.dataset.stage,
                        species: selectedOption.dataset.species,
                        habitat: selectedOption.dataset.habitat,
                        health: selectedOption.dataset.health,
                        happiness: selectedOption.dataset.happiness,
                        growth: selectedOption.dataset.growth
                    };

                    // Update creature display
                    updateCreatureDisplay();
                } else {
                    // Reset model display
                    modelPlaceholder.style.display = 'flex';
                    modelDisplay.innerHTML = '';

                    // Reset habitat type indicator
                    habitatTypeIndicator.innerHTML = '<i class="fas fa-tree mr-1"></i> Select a creature';
                    habitatTypeIndicator.className = 'habitat-type-indicator';

                    // Hide creature info panel
                    creatureInfoPanel.classList.add('opacity-0');

                    // Disable model controls
                    enableModelControls(false);
                }
            });

            /**
             * Update creature info display
             */
            function updateCreatureDisplay() {
                if (!selectedCreatureId || !selectedCreatureData) {
                    return;
                }

                // Get creature details from selected option
                const creatureName = selectedCreatureData.name;
                const creatureStage = selectedCreatureData.stage;
                const creatureSpecies = selectedCreatureData.species;
                const habitatType = selectedCreatureData.habitat;
                const health = selectedCreatureData.health;
                const happiness = selectedCreatureData.happiness;
                const growthProgress = selectedCreatureData.growth;

                // Load 3D model and environment (will be implemented in the future)
                loadHabitatEnvironment(habitatType);
                loadCreatureModel(creatureSpecies, creatureStage);

                // Update creature info panel
                creatureNameDisplay.textContent = creatureName;
                creatureHealthDisplay.textContent = `Health: ${health}/100`;
                creatureHappinessDisplay.textContent = `Happiness: ${happiness}/100`;

                // Update stage badge
                creatureStageDisplay.textContent = creatureStage.charAt(0).toUpperCase() + creatureStage.slice(1);
                creatureStageDisplay.className = `px-2 py-1 text-xs font-medium rounded-full badge-${creatureStage}`;

                // Calculate and update growth progress
                let growthPercentage = 0;
                if (creatureStage === 'egg') {
                    growthPercentage = (growthProgress / 100) * 100;
                } else if (creatureStage === 'mythical') {
                    growthPercentage = 100;
                } else {
                    growthPercentage = (growthProgress / 200) * 100;
                }

                growthPercentageDisplay.textContent = `${Math.round(growthPercentage)}%`;
                growthBar.style.width = `${growthPercentage}%`;

                // Show the creature info panel
                creatureInfoPanel.classList.remove('opacity-0');
            }

            /**
             * Load habitat environment
             * This function will be implemented in the future to load habitat 3D environments
             * @param {string} habitatType - The type of habitat
             */
            function loadHabitatEnvironment(habitatType) {
                // Update habitat type indicator
                habitatTypeIndicator.innerHTML = getHabitatIcon(habitatType);
                habitatTypeIndicator.className = `habitat-type-indicator text-${habitatType}`;

                // In the future, this will load a habitat environment
                // const environmentPath = `/models/environments/${habitatType}.jbx`;
            }

            /**
             * Load 3D model for creature
             * This function will be implemented in the future to load .jbx models
             * @param {string} speciesId - The species ID
             * @param {string} stage - The creature's stage (egg, baby, juvenile, adult, mythical)
             */
            function loadCreatureModel(speciesId, stage) {
                // This is a placeholder function for future implementation
                console.log(`Loading model for species ${speciesId} at stage ${stage}`);

                // In the future, this will load a .jbx model file
                // const modelPath = `/models/creatures/${speciesId}_${stage}.jbx`;

                // Clear placeholder when model is selected
                modelPlaceholder.style.display = 'none';

                // Show a temporary placeholder for now
                const placeholderIcon = getCreatureIcon(stage);
                modelDisplay.innerHTML = `
      <div class="flex items-center justify-center h-full">
        <div class="text-8xl ${getCreatureColor(speciesId, stage)}">
          ${placeholderIcon}
        </div>
      </div>
    `;

                // Enable model control buttons
                enableModelControls(true);
            }

            /**
             * Get creature icon based on stage
             * @param {string} stage - The creature's stage
             * @return {string} HTML for the icon
             */
            function getCreatureIcon(stage) {
                switch (stage) {
                    case 'egg':
                        return '<i class="fas fa-egg"></i>';
                    case 'baby':
                        return '<i class="fas fa-baby"></i>';
                    case 'juvenile':
                        return '<i class="fas fa-paw"></i>';
                    case 'adult':
                        return '<i class="fas fa-dragon"></i>';
                    case 'mythical':
                        return '<i class="fas fa-dragon"></i>';
                    default:
                        return '<i class="fas fa-question"></i>';
                }
            }

            /**
             * Get creature color class based on species and stage
             * @param {number} speciesId - The species ID
             * @param {string} stage - The creature's stage
             * @return {string} CSS class for the color
             */
            function getCreatureColor(speciesId, stage) {
                const habitatMap = ['forest', 'ocean', 'mountain', 'sky', 'cosmic', 'enchanted'];
                const habitatType = habitatMap[speciesId % habitatMap.length];

                if (stage === 'mythical') {
                    return `text-yellow-500`;
                }

                switch (habitatType) {
                    case 'forest':
                        return 'text-green-600';
                    case 'ocean':
                        return 'text-blue-600';
                    case 'mountain':
                        return 'text-red-700';
                    case 'sky':
                        return 'text-blue-400';
                    case 'cosmic':
                        return 'text-purple-600';
                    case 'enchanted':
                        return 'text-pink-600';
                    default:
                        return 'text-gray-500';
                }
            }

            /**
             * Get habitat icon and label based on type
             * @param {string} habitatType - The habitat type
             * @return {string} HTML for the habitat indicator
             */
            function getHabitatIcon(habitatType) {
                switch (habitatType) {
                    case 'forest':
                        return '<i class="fas fa-tree mr-1"></i> Forest Habitat';
                    case 'ocean':
                        return '<i class="fas fa-water mr-1"></i> Ocean Habitat';
                    case 'mountain':
                        return '<i class="fas fa-mountain mr-1"></i> Mountain Habitat';
                    case 'sky':
                        return '<i class="fas fa-cloud mr-1"></i> Sky Habitat';
                    case 'cosmic':
                        return '<i class="fas fa-star mr-1"></i> Cosmic Habitat';
                    case 'enchanted':
                        return '<i class="fas fa-magic mr-1"></i> Enchanted Habitat';
                    default:
                        return '<i class="fas fa-tree mr-1"></i> Select a creature';
                }
            }

            /**
             * Enable or disable the model control buttons
             * @param {boolean} enable - Whether to enable the controls
             */
            function enableModelControls(enable) {
                rotateLeftBtn.disabled = !enable;
                rotateRightBtn.disabled = !enable;
                zoomInBtn.disabled = !enable;
                zoomOutBtn.disabled = !enable;
                resetViewBtn.disabled = !enable;
            }

            // Model control buttons placeholder functionality
            rotateLeftBtn.addEventListener('click', function() {
                console.log('Rotate left');
                // In the future, this will rotate the 3D model left
            });

            rotateRightBtn.addEventListener('click', function() {
                console.log('Rotate right');
                // In the future, this will rotate the 3D model right
            });

            zoomInBtn.addEventListener('click', function() {
                console.log('Zoom in');
                // In the future, this will zoom in the 3D model
            });

            zoomOutBtn.addEventListener('click', function() {
                console.log('Zoom out');
                // In the future, this will zoom out the 3D model
            });

            resetViewBtn.addEventListener('click', function() {
                console.log('Reset view');
                // In the future, this will reset the 3D model view
            });

            // Complete modal listeners
            closeCompleteModal.addEventListener('click', function () {
                completeModal.classList.add('hidden');
            });

            startNewSessionBtn.addEventListener('click', function () {
                completeModal.classList.add('hidden');
            });

            // Close modal when clicking outside
            completeModal.addEventListener('click', function (e) {
                if (e.target === completeModal) {
                    completeModal.classList.add('hidden');
                }
            });

            // Check for active session
            <?php if (isset($activeSession)): ?>
            // Resume active session
            activeSessionId = <?= $activeSession['id'] ?>;
            sessionDuration = <?= $activeSession['duration_minutes'] * 60 ?>;

            // Calculate remaining time
            const startTime = new Date('<?= $activeSession['start_time'] ?>');
            const now = new Date();
            const elapsedSeconds = Math.floor((now - startTime) / 1000);
            timeRemaining = Math.max(0, sessionDuration - elapsedSeconds);

            // If session has creature, get creature data
            <?php if ($activeSession['creature_id']): ?>
            selectedCreatureId = <?= $activeSession['creature_id'] ?>;

            // Find corresponding creature from dropdown
            for (let i = 0; i < creatureSelect.options.length; i++) {
                if (creatureSelect.options[i].value == selectedCreatureId) {
                    creatureSelect.selectedIndex = i;
                    selectedCreatureData = {
                        id: selectedCreatureId,
                        name: creatureSelect.options[i].dataset.name,
                        stage: creatureSelect.options[i].dataset.stage,
                        species: creatureSelect.options[i].dataset.species,
                        habitat: creatureSelect.options[i].dataset.habitat,
                        health: creatureSelect.options[i].dataset.health,
                        happiness: creatureSelect.options[i].dataset.happiness,
                        growth: creatureSelect.options[i].dataset.growth
                    };
                    break;
                }
            }

            // Update creature display
            updateCreatureDisplay();
            <?php endif; ?>

            // Update UI for active session
            timerSettings.classList.add('hidden');
            startBtn.classList.add('hidden');
            breatheBtn.classList.add('hidden');
            pauseBtn.classList.remove('hidden');
            cancelBtn.classList.remove('hidden');

            // Start timer
            timerRunning = true;
            timerStatus.textContent = 'Focusing...';
            updateTimerDisplay();

            // Enter focus mode
            focusApp.classList.add('focus-mode-active');

            timerInterval = setInterval(function () {
                if (timeRemaining <= 0) {
                    completeSession();
                } else {
                    timeRemaining--;
                    updateTimerDisplay();
                }
            }, 1000);
            <?php endif; ?>
            
            // Make helper functions and variables available to the global scope
            window.timerRunning = timerRunning;
            window.timerPaused = timerPaused;
            window.startTimer = startTimer;
            window.pauseTimer = pauseTimer;
            window.resumeTimer = resumeTimer;
            window.completeSession = completeSession;
            window.cancelSession = cancelSession;
            window.resetTimer = resetTimer;
            window.sessionDuration = sessionDuration;
            window.timeRemaining = timeRemaining;
            window.selectedCreatureId = selectedCreatureId;
            window.selectedCreatureData = selectedCreatureData;
        });
    </script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>