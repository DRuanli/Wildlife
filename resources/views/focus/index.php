<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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
  }

  body {
    background-color: var(--neutral-light);
  }

  /* Focus timer styles */
  .timer-container {
    position: relative;
    width: 280px;
    height: 280px;
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

  /* Progress bars */
  .progress-bar {
    height: 6px;
    border-radius: 3px;
    background-color: #e5e7eb;
    overflow: hidden;
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
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 50;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.5s ease;
  }

  .focus-mode-active .focus-mode-overlay {
    opacity: 1;
    pointer-events: auto;
  }

  .focus-mode-content {
    transition: all 0.5s ease;
  }

  .focus-mode-active .focus-mode-content {
    transform: scale(1.05);
  }

  /* Button effects */
  .focus-btn {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .focus-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  .focus-btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  /* Animations */
  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }

  .pulse-animation {
    animation: pulse 2s infinite;
  }

  @keyframes float {
    0% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0); }
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
  }
</style>

<div id="focus-app" class="min-h-screen pt-6 pb-12">
  <div class="container mx-auto px-4">
    <!-- Header Section -->
    <div class="mb-8 flex justify-between items-center">
      <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Focus Session</h1>
      <div class="flex items-center space-x-2">
        <a href="<?= $baseUrl ?>/focus/history" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
          <i class="fas fa-history mr-1"></i> History
        </a>
        <a href="<?= $baseUrl ?>/dashboard" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
          <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
        </a>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Left Column: Timer and Controls -->
      <div class="lg:col-span-1 flex flex-col items-center">
        <div id="focus-mode-content" class="focus-mode-content w-full bg-white rounded-xl shadow-md p-6 mb-6 flex flex-col items-center">
          <!-- Focus Timer -->
          <div class="timer-container mb-6">
            <div class="timer-circle timer-background"></div>
            <div id="timer-progress" class="timer-circle timer-progress"></div>
            <div class="timer-content">
              <div class="timer-inner">
                <span id="timer-display" class="text-4xl md:text-5xl font-bold text-gray-800">25:00</span>
                <p id="timer-status" class="text-gray-600 mt-2">Ready to focus</p>
              </div>
            </div>
          </div>

          <!-- Timer Controls -->
          <div id="timer-controls" class="flex flex-wrap justify-center gap-3 mb-6 w-full">
            <button id="start-btn" class="focus-btn px-5 py-3 bg-green-600 text-white font-medium rounded-lg flex items-center">
              <i class="fas fa-play mr-2"></i> Start Focus
            </button>
            <button id="pause-btn" class="focus-btn px-5 py-3 bg-yellow-500 text-white font-medium rounded-lg flex items-center hidden">
              <i class="fas fa-pause mr-2"></i> Pause
            </button>
            <button id="resume-btn" class="focus-btn px-5 py-3 bg-green-600 text-white font-medium rounded-lg flex items-center hidden">
              <i class="fas fa-play mr-2"></i> Resume
            </button>
            <button id="complete-btn" class="focus-btn px-5 py-3 bg-blue-600 text-white font-medium rounded-lg flex items-center hidden">
              <i class="fas fa-check mr-2"></i> Complete
            </button>
            <button id="cancel-btn" class="focus-btn px-5 py-3 bg-red-500 text-white font-medium rounded-lg flex items-center hidden">
              <i class="fas fa-times mr-2"></i> Cancel
            </button>
          </div>

          <!-- Session Settings -->
          <div id="timer-settings" class="w-full max-w-md">
            <div class="mb-4">
              <label class="block text-gray-700 font-medium mb-2">Session Duration</label>
              <div class="flex justify-between gap-2">
                <button class="duration-btn flex-1 py-2 rounded text-center font-medium bg-green-600 text-white" data-duration="25">25m</button>
                <button class="duration-btn flex-1 py-2 rounded text-center font-medium bg-gray-200 text-gray-700" data-duration="30">30m</button>
                <button class="duration-btn flex-1 py-2 rounded text-center font-medium bg-gray-200 text-gray-700" data-duration="45">45m</button>
                <button class="duration-btn flex-1 py-2 rounded text-center font-medium bg-gray-200 text-gray-700" data-duration="60">60m</button>
              </div>
            </div>
            
            <!-- Creature Selection -->
            <div class="mb-4">
              <label for="creature-select" class="block text-gray-700 font-medium mb-2">Choose a creature to grow:</label>
              <select id="creature-select" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 bg-white">
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
                  <?= htmlspecialchars($creature['name'] ?? 'Unnamed ' . $creature['species_name']) ?> (<?= ucfirst($creature['stage']) ?>)
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
            <!-- Placeholder for 3D model - will be replaced with actual 3D model in the future -->
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
            <div id="creature-info-panel" class="creature-info-panel opacity-0 transition-opacity duration-300">
              <div class="flex justify-between items-center mb-2">
                <h4 id="creature-name" class="font-bold text-gray-800">No creature selected</h4>
                <span id="creature-stage" class="px-2 py-1 text-xs font-medium rounded-full badge-egg">Egg</span>
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
            <button id="rotate-left-btn" class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none disabled:opacity-50" disabled>
              <i class="fas fa-undo"></i>
            </button>
            <button id="rotate-right-btn" class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none disabled:opacity-50" disabled>
              <i class="fas fa-redo"></i>
            </button>
            <button id="zoom-in-btn" class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none disabled:opacity-50" disabled>
              <i class="fas fa-search-plus"></i>
            </button>
            <button id="zoom-out-btn" class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none disabled:opacity-50" disabled>
              <i class="fas fa-search-minus"></i>
            </button>
            <button id="reset-view-btn" class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none disabled:opacity-50" disabled>
              <i class="fas fa-home"></i>
            </button>
          </div>
        </div>

        <!-- Focus Stats Card -->
        <div class="bg-white rounded-xl shadow-md p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-800">Focus Statistics</h3>
            <a href="<?= $baseUrl ?>/focus/history" class="text-green-600 hover:text-green-700 text-sm font-medium">View History</a>
          </div>
          
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
              <p class="text-gray-500 text-sm mb-1">Total Focus Time</p>
              <p class="text-xl font-bold text-gray-800">
                <?= floor(($userStats['total_minutes'] ?? 0) / 60) ?>h <?= ($userStats['total_minutes'] ?? 0) % 60 ?>m
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
            <?php foreach(array_slice($todaySessions, 0, 5) as $session): ?>
            <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
              <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-100 text-blue-600 mr-3">
                <i class="fas fa-clock"></i>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800 truncate"><?= $session['duration_minutes'] ?> min focus session</p>
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
      <button id="close-complete-modal" class="absolute top-4 right-4 text-white hover:text-white hover:opacity-80">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="p-6">
      <div class="text-center mb-6">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-check-circle text-green-600 text-4xl"></i>
        </div>
        <h4 class="text-xl font-bold text-gray-800 mb-2">Great work!</h4>
        <p class="text-gray-600">You've completed a <span id="completed-duration">25</span> minute focus session.</p>
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
          <div id="result-creature-icon" class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mr-3">
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
                <div id="result-growth-bar" class="progress-fill bg-green-500" style="width: 35%"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="flex space-x-3">
        <button id="view-summary-btn" class="flex-1 px-4 py-2 border border-gray-300 text-gray-800 font-medium rounded-lg hover:bg-gray-50">
          View Summary
        </button>
        <button id="start-new-session-btn" class="flex-1 px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700">
          Start New Session
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Future 3D Model Loading Library -->
<!-- This script tag will be where we include the 3D model loader in the future -->
<!-- <script src="path/to/3d-model-loader.js"></script> -->

<!-- Focus Page JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
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
  
  // DOM elements
  const timerDisplay = document.getElementById('timer-display');
  const timerStatus = document.getElementById('timer-status');
  const timerProgress = document.getElementById('timer-progress');
  const startBtn = document.getElementById('start-btn');
  const pauseBtn = document.getElementById('pause-btn');
  const resumeBtn = document.getElementById('resume-btn');
  const completeBtn = document.getElementById('complete-btn');
  const cancelBtn = document.getElementById('cancel-btn');
  const timerSettings = document.getElementById('timer-settings');
  const durationBtns = document.querySelectorAll('.duration-btn');
  const creatureSelect = document.getElementById('creature-select');
  const focusModeOverlay = document.getElementById('focus-mode-overlay');
  const focusApp = document.getElementById('focus-app');
  
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
   * Get creature icon based on stage
   * @param {string} stage - The creature's stage
   * @return {string} HTML for the icon
   */
  function getCreatureIcon(stage) {
    switch(stage) {
      case 'egg': return '<i class="fas fa-egg"></i>';
      case 'baby': return '<i class="fas fa-baby"></i>';
      case 'juvenile': return '<i class="fas fa-paw"></i>';
      case 'adult': return '<i class="fas fa-dragon"></i>';
      case 'mythical': return '<i class="fas fa-dragon"></i>';
      default: return '<i class="fas fa-question"></i>';
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
    
    switch(habitatType) {
      case 'forest': return 'text-green-600';
      case 'ocean': return 'text-blue-600';
      case 'mountain': return 'text-red-700';
      case 'sky': return 'text-blue-400';
      case 'cosmic': return 'text-purple-600';
      case 'enchanted': return 'text-pink-600';
      default: return 'text-gray-500';
    }
  }
  
  /**
   * Get habitat icon and label based on type
   * @param {string} habitatType - The habitat type
   * @return {string} HTML for the habitat indicator
   */
  function getHabitatIcon(habitatType) {
    switch(habitatType) {
      case 'forest': return '<i class="fas fa-tree mr-1"></i> Forest Habitat';
      case 'ocean': return '<i class="fas fa-water mr-1"></i> Ocean Habitat';
      case 'mountain': return '<i class="fas fa-mountain mr-1"></i> Mountain Habitat';
      case 'sky': return '<i class="fas fa-cloud mr-1"></i> Sky Habitat';
      case 'cosmic': return '<i class="fas fa-star mr-1"></i> Cosmic Habitat';
      case 'enchanted': return '<i class="fas fa-magic mr-1"></i> Enchanted Habitat';
      default: return '<i class="fas fa-tree mr-1"></i> Select a creature';
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
    pauseBtn.classList.remove('hidden');
    cancelBtn.classList.remove('hidden');
    
    // Start new focus session
    startTime = new Date();
    timerRunning = true;
    timerStatus.textContent = 'Focusing...';
    
    // Enter focus mode
    focusApp.classList.add('focus-mode-active');
    
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
    
    // Start countdown
    timerInterval = setInterval(function() {
      if (timeRemaining <= 0) {
        completeSession();
      } else {
        timeRemaining--;
        updateTimerDisplay();
      }
    }, 1000);
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
    
    timerStatus.textContent = 'Focusing...';
    
    timerInterval = setInterval(function() {
      if (timeRemaining <= 0) {
        completeSession();
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
      resetTimer();
    })
    .catch(error => {
      console.error('Error:', error);
      resetTimer();
    });
  }
  
  function cancelSession() {
    if (!confirm('Are you sure you want to cancel this focus session? Progress will be lost.')) {
      return;
    }
    
    clearInterval(timerInterval);
    
    // Cancel the session in backend if there's an active session
    if (activeSessionId) {
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
  }
  
  function resetTimer() {
    // Clear timer and reset state
    clearInterval(timerInterval);
    timerRunning = false;
    timerPaused = false;
    timeRemaining = sessionDuration;
    activeSessionId = null;
    
    // Reset UI
    updateTimerDisplay();
    timerStatus.textContent = 'Ready to focus';
    
    // Hide control buttons, show settings
    startBtn.classList.remove('hidden');
    pauseBtn.classList.add('hidden');
    resumeBtn.classList.add('hidden');
    completeBtn.classList.add('hidden');
    cancelBtn.classList.add('hidden');
    timerSettings.classList.remove('hidden');
    
    // Exit focus mode
    focusApp.classList.remove('focus-mode-active');
  }
  
  function calculateFocusScore(start, end, pauseMoment) {
    // In a real implementation, this would consider factors like:
    // - How many times the session was paused
    // - Whether user navigated away from the app
    // - Other distraction indicators
    
    // For this demo, we'll simulate a focus score
    let score = 100;
    
    // Deduct if paused
    if (pauseMoment) {
      score -= 10;
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
      viewSummaryBtn.onclick = function() {
        window.location.href = `<?= $baseUrl ?>/focus/session/${data.session.id}/summary`;
      };
    } else {
      resultCreatureGrowth.classList.add('hidden');
      
      // Configure view summary button for no creature
      viewSummaryBtn.onclick = function() {
        window.location.href = `<?= $baseUrl ?>/focus/session/${data.session.id}/summary`;
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
  
  // Duration button listeners
  durationBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      // Update UI
      durationBtns.forEach(b => {
        b.classList.remove('bg-green-600', 'text-white');
        b.classList.add('bg-gray-200', 'text-gray-700');
      });
      this.classList.remove('bg-gray-200', 'text-gray-700');
      this.classList.add('bg-green-600', 'text-white');
      
      // Set duration
      const minutes = parseInt(this.dataset.duration);
      sessionDuration = minutes * 60;
      timeRemaining = sessionDuration;
      updateTimerDisplay();
    });
  });
  
  // Creature select listener
  creatureSelect.addEventListener('change', function() {
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
  
  // Model control button listeners - placeholder for future functionality
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
  closeCompleteModal.addEventListener('click', function() {
    completeModal.classList.add('hidden');
  });
  
  startNewSessionBtn.addEventListener('click', function() {
    completeModal.classList.add('hidden');
  });
  
  // Close modal when clicking outside
  completeModal.addEventListener('click', function(e) {
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
  pauseBtn.classList.remove('hidden');
  cancelBtn.classList.remove('hidden');
  
  // Start timer
  timerRunning = true;
  timerStatus.textContent = 'Focusing...';
  updateTimerDisplay();
  
  // Enter focus mode
  focusApp.classList.add('focus-mode-active');
  
  timerInterval = setInterval(function() {
    if (timeRemaining <= 0) {
      completeSession();
    } else {
      timeRemaining--;
      updateTimerDisplay();
    }
  }, 1000);
  <?php endif; ?>
});

/**
 * Placeholder for future 3D model loading functionality
 * This would be in a separate file that implements model loading
 */
class ModelLoader {
  constructor(containerId) {
    this.container = document.getElementById(containerId);
    // Initialize 3D engine, camera, etc.
  }
  
  /**
   * Load a 3D model file
   * @param {string} modelPath - Path to the model file (.jbx)
   * @return {Promise} Promise that resolves when the model is loaded
   */
  loadModel(modelPath) {
    return new Promise((resolve, reject) => {
      console.log(`Loading model from ${modelPath}`);
      // Implementation for loading .jbx models will go here
      resolve();
    });
  }
  
  /**
   * Load environment (background/setting)
   * @param {string} environmentPath - Path to the environment model
   * @return {Promise} Promise that resolves when the environment is loaded
   */
  loadEnvironment(environmentPath) {
    return new Promise((resolve, reject) => {
      console.log(`Loading environment from ${environmentPath}`);
      // Implementation for loading environment models will go here
      resolve();
    });
  }
  
  /**
   * Create a model file path based on species and stage
   * @param {number} speciesId - The species ID
   * @param {string} stage - The creature's stage
   * @return {string} Path to the model file
   */
  static getModelPath(speciesId, stage) {
    return `/models/creatures/${speciesId}_${stage}.jbx`;
  }
  
  /**
   * Create an environment file path based on habitat type
   * @param {string} habitatType - The habitat type
   * @return {string} Path to the environment file
   */
  static getEnvironmentPath(habitatType) {
    return `/models/environments/${habitatType}.jbx`;
  }
}
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>