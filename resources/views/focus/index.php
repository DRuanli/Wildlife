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

  /* 3D canvas container */
  .habitat-container {
    position: relative;
    width: 100%;
    height: 300px;
    background-color: rgba(255, 255, 255, 0.7);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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

    .habitat-container {
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
        <!-- 3D Habitat Visualization Card -->
        <div id="habitat-card" class="bg-white rounded-xl shadow-md p-6 mb-6">
          <h3 class="font-bold text-gray-800 mb-4">Your Wildlife Habitat</h3>
          
          <!-- 3D Habitat Container -->
          <div class="habitat-container">
            <!-- 3D Rendering will be inserted here -->
            <div id="habitat-canvas"></div>
            
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
          
          <!-- Habitat Controls -->
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

<!-- Load Three.js library -->
<script src="https://cdn.jsdelivr.net/npm/three@0.154.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.154.0/examples/js/controls/OrbitControls.js"></script>

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
  
  // 3D scene variables
  let scene, camera, renderer, controls;
  let habitat, creature;
  let rotateEnabled = false;
  const habitatCanvas = document.getElementById('habitat-canvas');
  const habitatTypeIndicator = document.getElementById('habitat-type');
  const creatureInfoPanel = document.getElementById('creature-info-panel');
  const creatureNameDisplay = document.getElementById('creature-name');
  const creatureStageDisplay = document.getElementById('creature-stage');
  const creatureHealthDisplay = document.getElementById('creature-health');
  const creatureHappinessDisplay = document.getElementById('creature-happiness');
  const growthPercentageDisplay = document.getElementById('growth-percentage');
  const growthBar = document.getElementById('growth-bar');
  
  // Modal elements
  const completeModal = document.getElementById('complete-modal');
  const closeCompleteModal = document.getElementById('close-complete-modal');
  const viewSummaryBtn = document.getElementById('view-summary-btn');
  const startNewSessionBtn = document.getElementById('start-new-session-btn');
  const completedDuration = document.getElementById('completed-duration');
  const resultFocusScore = document.getElementById('result-focus-score');
  const resultCoins = document.getElementById('result-coins');
  const resultCreatureGrowth = document.getElementById('result-creature-growth');
  
  // Habitat control buttons
  const rotateLeftBtn = document.getElementById('rotate-left-btn');
  const rotateRightBtn = document.getElementById('rotate-right-btn');
  const zoomInBtn = document.getElementById('zoom-in-btn');
  const zoomOutBtn = document.getElementById('zoom-out-btn');
  const resetViewBtn = document.getElementById('reset-view-btn');
  
  // Initialize 3D scene
  function initScene() {
    // Create scene
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf0f9ff);
    
    // Create camera
    camera = new THREE.PerspectiveCamera(75, habitatCanvas.clientWidth / habitatCanvas.clientHeight, 0.1, 1000);
    camera.position.z = 5;
    camera.position.y = 2;
    
    // Create renderer
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(habitatCanvas.clientWidth, habitatCanvas.clientHeight);
    renderer.shadowMap.enabled = true;
    
    // Clear previous canvas if it exists
    while (habitatCanvas.firstChild) {
      habitatCanvas.removeChild(habitatCanvas.firstChild);
    }
    
    // Add new canvas
    habitatCanvas.appendChild(renderer.domElement);
    
    // Add orbit controls
    controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.rotateSpeed = 0.5;
    controls.enableZoom = true;
    controls.enablePan = false;
    controls.enabled = false; // Disable controls initially
    
    // Add ambient light
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);
    
    // Add directional light (sun)
    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
    directionalLight.position.set(5, 10, 5);
    directionalLight.castShadow = true;
    scene.add(directionalLight);
    
    // Set up the ground
    const groundGeometry = new THREE.PlaneGeometry(20, 20);
    const groundMaterial = new THREE.MeshStandardMaterial({ 
      color: 0x90ee90, 
      roughness: 0.8,
      metalness: 0.2
    });
    const ground = new THREE.Mesh(groundGeometry, groundMaterial);
    ground.rotation.x = -Math.PI / 2;
    ground.receiveShadow = true;
    scene.add(ground);
    
    // Start animation loop
    animate();
  }
  
  // Animation loop
  function animate() {
    requestAnimationFrame(animate);
    
    if (controls) {
      controls.update();
    }
    
    if (creature) {
      // Add subtle movement to creature
      creature.rotation.y += 0.005;
    }
    
    renderer.render(scene, camera);
  }
  
  // Handle window resize
  function onWindowResize() {
    if (camera && renderer && habitatCanvas) {
      camera.aspect = habitatCanvas.clientWidth / habitatCanvas.clientHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(habitatCanvas.clientWidth, habitatCanvas.clientHeight);
    }
  }
  
  // Create habitat based on type
  function createHabitat(type) {
    // Remove existing habitat if any
    if (habitat) {
      scene.remove(habitat);
    }
    
    // Create new habitat group
    habitat = new THREE.Group();
    
    // Add different elements based on habitat type
    switch (type) {
      case 'forest':
        // Update habitat type indicator
        habitatTypeIndicator.innerHTML = '<i class="fas fa-tree mr-1"></i> Forest Habitat';
        habitatTypeIndicator.className = 'habitat-type-indicator text-forest';
        
        // Create trees and forest elements
        for (let i = 0; i < 10; i++) {
          const treeGeometry = new THREE.ConeGeometry(0.5, 2, 8);
          const treeMaterial = new THREE.MeshStandardMaterial({ color: 0x2d6a4f });
          const tree = new THREE.Mesh(treeGeometry, treeMaterial);
          tree.position.x = Math.random() * 10 - 5;
          tree.position.z = Math.random() * 10 - 5;
          tree.position.y = 1;
          tree.castShadow = true;
          
          const trunkGeometry = new THREE.CylinderGeometry(0.1, 0.1, 1, 8);
          const trunkMaterial = new THREE.MeshStandardMaterial({ color: 0x8B4513 });
          const trunk = new THREE.Mesh(trunkGeometry, trunkMaterial);
          trunk.position.y = -0.5;
          tree.add(trunk);
          
          habitat.add(tree);
        }
        
        // Set forest ground color
        scene.background = new THREE.Color(0xE8F5E9);
        break;
        
      case 'ocean':
        // Update habitat type indicator
        habitatTypeIndicator.innerHTML = '<i class="fas fa-water mr-1"></i> Ocean Habitat';
        habitatTypeIndicator.className = 'habitat-type-indicator text-ocean';
        
        // Create water surface
        const waterGeometry = new THREE.PlaneGeometry(20, 20, 20, 20);
        const waterMaterial = new THREE.MeshStandardMaterial({ 
          color: 0x1e40af, 
          transparent: true, 
          opacity: 0.8,
          roughness: 0.2,
          metalness: 0.1
        });
        const water = new THREE.Mesh(waterGeometry, waterMaterial);
        water.rotation.x = -Math.PI / 2;
        water.position.y = 0.1;
        habitat.add(water);
        
        // Add coral elements
        for (let i = 0; i < 8; i++) {
          const coralGeometry = new THREE.DodecahedronGeometry(0.3, 0);
          const coralMaterial = new THREE.MeshStandardMaterial({ 
            color: Math.random() > 0.5 ? 0xFF6F61 : 0x9D65C9,
            roughness: 0.7
          });
          const coral = new THREE.Mesh(coralGeometry, coralMaterial);
          coral.position.x = Math.random() * 10 - 5;
          coral.position.z = Math.random() * 10 - 5;
          coral.position.y = 0.3;
          coral.scale.y = 1 + Math.random();
          coral.castShadow = true;
          habitat.add(coral);
        }
        
        // Set ocean background color
        scene.background = new THREE.Color(0xBBDEFB);
        break;
        
      case 'mountain':
        // Update habitat type indicator
        habitatTypeIndicator.innerHTML = '<i class="fas fa-mountain mr-1"></i> Mountain Habitat';
        habitatTypeIndicator.className = 'habitat-type-indicator text-mountain';
        
        // Create mountains
        for (let i = 0; i < 5; i++) {
          const mountainGeometry = new THREE.ConeGeometry(2, 4, 6);
          const mountainMaterial = new THREE.MeshStandardMaterial({ 
            color: 0x7f1d1d,
            roughness: 0.9
          });
          const mountain = new THREE.Mesh(mountainGeometry, mountainMaterial);
          mountain.position.x = Math.random() * 16 - 8;
          mountain.position.z = Math.random() * 16 - 8;
          mountain.position.y = 0;
          mountain.castShadow = true;
          
          // Add snow cap
          const snowGeometry = new THREE.ConeGeometry(0.8, 1, 6);
          const snowMaterial = new THREE.MeshStandardMaterial({ color: 0xFFFFFF });
          const snow = new THREE.Mesh(snowGeometry, snowMaterial);
          snow.position.y = 1.7;
          mountain.add(snow);
          
          habitat.add(mountain);
        }
        
        // Set mountain background color
        scene.background = new THREE.Color(0xF3E5F5);
        break;
        
      case 'sky':
        // Update habitat type indicator
        habitatTypeIndicator.innerHTML = '<i class="fas fa-cloud mr-1"></i> Sky Habitat';
        habitatTypeIndicator.className = 'habitat-type-indicator text-sky';
        
        // Create clouds
        for (let i = 0; i < 10; i++) {
          // Cloud group
          const cloud = new THREE.Group();
          
          // Create cloud puffs
          const puffCount = 3 + Math.floor(Math.random() * 4);
          for (let j = 0; j < puffCount; j++) {
            const puffGeometry = new THREE.SphereGeometry(0.5 + Math.random() * 0.5, 7, 7);
            const puffMaterial = new THREE.MeshStandardMaterial({ 
              color: 0xFFFFFF,
              roughness: 0.3
            });
            const puff = new THREE.Mesh(puffGeometry, puffMaterial);
            puff.position.x = j * 0.7;
            puff.position.y = Math.random() * 0.2;
            puff.position.z = Math.random() * 0.2;
            cloud.add(puff);
          }
          
          cloud.position.x = Math.random() * 16 - 8;
          cloud.position.y = 1 + Math.random() * 3;
          cloud.position.z = Math.random() * 16 - 8;
          
          habitat.add(cloud);
        }
        
        // Set sky background color
        scene.background = new THREE.Color(0xAEE2FF);
        break;
        
      case 'cosmic':
        // Update habitat type indicator
        habitatTypeIndicator.innerHTML = '<i class="fas fa-star mr-1"></i> Cosmic Habitat';
        habitatTypeIndicator.className = 'habitat-type-indicator text-cosmic';
        
        // Create stars
        for (let i = 0; i < 200; i++) {
          const starGeometry = new THREE.SphereGeometry(0.05, 4, 4);
          const starMaterial = new THREE.MeshBasicMaterial({ 
            color: 0xFFFFFF
          });
          const star = new THREE.Mesh(starGeometry, starMaterial);
          
          // Position stars in a large sphere around the center
          const radius = 10;
          const theta = Math.random() * Math.PI * 2;
          const phi = Math.random() * Math.PI;
          
          star.position.x = radius * Math.sin(phi) * Math.cos(theta);
          star.position.y = radius * Math.sin(phi) * Math.sin(theta);
          star.position.z = radius * Math.cos(phi);
          
          habitat.add(star);
        }
        
        // Add a few planets
        for (let i = 0; i < 3; i++) {
          const planetGeometry = new THREE.SphereGeometry(0.5, 32, 32);
          const planetMaterial = new THREE.MeshStandardMaterial({ 
            color: [0x8B4513, 0x76ABDF, 0x8A2BE2][i],
            roughness: 0.7
          });
          const planet = new THREE.Mesh(planetGeometry, planetMaterial);
          
          planet.position.x = Math.random() * 8 - 4;
          planet.position.y = Math.random() * 4;
          planet.position.z = Math.random() * 8 - 4;
          
          habitat.add(planet);
        }
        
        // Set cosmic background color (dark space)
        scene.background = new THREE.Color(0x090418);
        break;
      
      case 'enchanted':
        // Update habitat type indicator
        habitatTypeIndicator.innerHTML = '<i class="fas fa-magic mr-1"></i> Enchanted Habitat';
        habitatTypeIndicator.className = 'habitat-type-indicator text-enchanted';
        
        // Create magical mushrooms and flowers
        for (let i = 0; i < 15; i++) {
          // Mushroom
          if (i < 8) {
            const stemGeometry = new THREE.CylinderGeometry(0.1, 0.1, 0.5, 8);
            const stemMaterial = new THREE.MeshStandardMaterial({ color: 0xFFFFFF });
            const stem = new THREE.Mesh(stemGeometry, stemMaterial);
            
            const capGeometry = new THREE.SphereGeometry(0.3, 16, 8, 0, Math.PI * 2, 0, Math.PI / 2);
            const capMaterial = new THREE.MeshStandardMaterial({ 
              color: 0x9D174D,
              roughness: 0.6
            });
            const cap = new THREE.Mesh(capGeometry, capMaterial);
            cap.position.y = 0.3;
            cap.rotation.x = Math.PI;
            
            const mushroom = new THREE.Group();
            mushroom.add(stem);
            mushroom.add(cap);
            mushroom.position.x = Math.random() * 10 - 5;
            mushroom.position.z = Math.random() * 10 - 5;
            mushroom.position.y = 0.25;
            
            habitat.add(mushroom);
          } 
          // Magical flowers
          else {
            const stemGeometry = new THREE.CylinderGeometry(0.03, 0.03, 0.6, 8);
            const stemMaterial = new THREE.MeshStandardMaterial({ color: 0x4CAF50 });
            const stem = new THREE.Mesh(stemGeometry, stemMaterial);
            
            const flowerGeometry = new THREE.DodecahedronGeometry(0.2, 0);
            const flowerMaterial = new THREE.MeshStandardMaterial({ 
              color: Math.random() > 0.5 ? 0xFF69B4 : 0x9370DB,
              roughness: 0.5,
              metalness: 0.3
            });
            const flower = new THREE.Mesh(flowerGeometry, flowerMaterial);
            flower.position.y = 0.4;
            
            const plantGroup = new THREE.Group();
            plantGroup.add(stem);
            plantGroup.add(flower);
            plantGroup.position.x = Math.random() * 10 - 5;
            plantGroup.position.z = Math.random() * 10 - 5;
            plantGroup.position.y = 0.3;
            
            habitat.add(plantGroup);
          }
        }
        
        // Add magical fog/particles
        const particleGeometry = new THREE.BufferGeometry();
        const particleCount = 100;
        const positions = new Float32Array(particleCount * 3);
        
        for (let i = 0; i < particleCount * 3; i += 3) {
          positions[i] = Math.random() * 10 - 5; // x
          positions[i + 1] = Math.random() * 3; // y
          positions[i + 2] = Math.random() * 10 - 5; // z
        }
        
        particleGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        
        const particleMaterial = new THREE.PointsMaterial({
          color: 0xE195BD,
          size: 0.1,
          transparent: true,
          opacity: 0.7
        });
        
        const particles = new THREE.Points(particleGeometry, particleMaterial);
        habitat.add(particles);
        
        // Set enchanted background color
        scene.background = new THREE.Color(0xFCE4EC);
        break;
        
      default:
        // Default habitat (grass field)
        habitatTypeIndicator.innerHTML = '<i class="fas fa-leaf mr-1"></i> Default Habitat';
        habitatTypeIndicator.className = 'habitat-type-indicator';
    }
    
    // Add habitat to scene
    scene.add(habitat);
  }
  
  // Create creature based on stage
  function createCreature(stage, speciesId) {
    // Remove existing creature if any
    if (creature) {
      scene.remove(creature);
    }
    
    // Create creature based on stage
    creature = new THREE.Group();
    
    switch (stage) {
      case 'egg':
        // Create egg shape
        const eggGeometry = new THREE.SphereGeometry(0.5, 32, 32);
        eggGeometry.scale(1, 1.3, 1);
        
        // Determine egg color based on species
        let eggColor;
        switch (speciesId % 6) {
          case 0: eggColor = 0x2d6a4f; break; // Forest
          case 1: eggColor = 0x1e40af; break; // Ocean
          case 2: eggColor = 0x7f1d1d; break; // Mountain
          case 3: eggColor = 0x0369a1; break; // Sky
          case 4: eggColor = 0x4c1d95; break; // Cosmic
          case 5: eggColor = 0x9d174d; break; // Enchanted
          default: eggColor = 0x999999;
        }
        
        const eggMaterial = new THREE.MeshStandardMaterial({
          color: eggColor,
          roughness: 0.7,
          metalness: 0.1
        });
        
        const egg = new THREE.Mesh(eggGeometry, eggMaterial);
        egg.rotation.x = Math.PI * 0.1;
        egg.castShadow = true;
        
        // Add some egg patterns/spots
        for (let i = 0; i < 5; i++) {
          const spotGeometry = new THREE.CircleGeometry(0.07, 12);
          const spotMaterial = new THREE.MeshBasicMaterial({
            color: 0xFFFFFF,
            opacity: 0.7,
            transparent: true
          });
          const spot = new THREE.Mesh(spotGeometry, spotMaterial);
          
          // Position spots randomly on the egg surface
          const phi = Math.random() * Math.PI;
          const theta = Math.random() * Math.PI * 2;
          
          spot.position.x = 0.5 * Math.sin(phi) * Math.cos(theta);
          spot.position.y = 0.65 * Math.sin(phi) * Math.sin(theta);
          spot.position.z = 0.5 * Math.cos(phi);
          
          // Orient spot to face outward from egg center
          spot.lookAt(spot.position.clone().multiplyScalar(2));
          
          egg.add(spot);
        }
        
        creature.add(egg);
        break;
        
      case 'baby':
        // Create baby creature (small and cute)
        // Body
        const babyBodyGeometry = new THREE.SphereGeometry(0.35, 24, 24);
        const babyBodyMaterial = new THREE.MeshStandardMaterial({
          color: getCreatureColor(speciesId),
          roughness: 0.8,
          metalness: 0.1
        });
        const babyBody = new THREE.Mesh(babyBodyGeometry, babyBodyMaterial);
        babyBody.castShadow = true;
        creature.add(babyBody);
        
        // Head (larger in proportion to body for cuteness)
        const babyHeadGeometry = new THREE.SphereGeometry(0.25, 24, 24);
        const babyHeadMaterial = new THREE.MeshStandardMaterial({
          color: getCreatureColor(speciesId, true),
          roughness: 0.8,
          metalness: 0.1
        });
        const babyHead = new THREE.Mesh(babyHeadGeometry, babyHeadMaterial);
        babyHead.position.y = 0.4;
        babyHead.position.z = 0.1;
        babyHead.castShadow = true;
        creature.add(babyHead);
        
        // Eyes
        const eyeGeometry = new THREE.SphereGeometry(0.05, 16, 16);
        const eyeMaterial = new THREE.MeshBasicMaterial({ color: 0x000000 });
        
        const leftEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
        leftEye.position.x = -0.1;
        leftEye.position.y = 0.05;
        leftEye.position.z = 0.2;
        babyHead.add(leftEye);
        
        const rightEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
        rightEye.position.x = 0.1;
        rightEye.position.y = 0.05;
        rightEye.position.z = 0.2;
        babyHead.add(rightEye);
        
        // White dots in eyes for cuteness
        const eyeHighlightGeometry = new THREE.SphereGeometry(0.015, 8, 8);
        const eyeHighlightMaterial = new THREE.MeshBasicMaterial({ color: 0xFFFFFF });
        
        const leftHighlight = new THREE.Mesh(eyeHighlightGeometry, eyeHighlightMaterial);
        leftHighlight.position.x = 0.02;
        leftHighlight.position.y = 0.02;
        leftHighlight.position.z = 0.05;
        leftEye.add(leftHighlight);
        
        const rightHighlight = new THREE.Mesh(eyeHighlightGeometry, eyeHighlightMaterial);
        rightHighlight.position.x = 0.02;
        rightHighlight.position.y = 0.02;
        rightHighlight.position.z = 0.05;
        rightEye.add(rightHighlight);
        
        // Small tail
        const babyTailGeometry = new THREE.ConeGeometry(0.1, 0.3, 8);
        babyTailGeometry.rotateX(Math.PI / 2);
        const babyTailMaterial = new THREE.MeshStandardMaterial({
          color: getCreatureColor(speciesId, true),
          roughness: 0.7,
          metalness: 0.1
        });
        const babyTail = new THREE.Mesh(babyTailGeometry, babyTailMaterial);
        babyTail.position.z = -0.35;
        babyTail.castShadow = true;
        creature.add(babyTail);
        
        // Tiny stubby limbs
        const limbGeometry = new THREE.SphereGeometry(0.08, 16, 16);
        limbGeometry.scale(1, 1, 1.2);
        const limbMaterial = babyBodyMaterial;
        
        const frontLeftLimb = new THREE.Mesh(limbGeometry, limbMaterial);
        frontLeftLimb.position.set(-0.25, -0.1, 0.2);
        frontLeftLimb.castShadow = true;
        creature.add(frontLeftLimb);
        
        const frontRightLimb = new THREE.Mesh(limbGeometry, limbMaterial);
        frontRightLimb.position.set(0.25, -0.1, 0.2);
        frontRightLimb.castShadow = true;
        creature.add(frontRightLimb);
        
        const backLeftLimb = new THREE.Mesh(limbGeometry, limbMaterial);
        backLeftLimb.position.set(-0.25, -0.1, -0.2);
        backLeftLimb.castShadow = true;
        creature.add(backLeftLimb);
        
        const backRightLimb = new THREE.Mesh(limbGeometry, limbMaterial);
        backRightLimb.position.set(0.25, -0.1, -0.2);
        backRightLimb.castShadow = true;
        creature.add(backRightLimb);
        break;
        
      case 'juvenile':
        // Create juvenile creature (medium sized, developing features)
        // Body
        const juvBodyGeometry = new THREE.SphereGeometry(0.4, 24, 24);
        juvBodyGeometry.scale(1.2, 1, 1.5);
        const juvBodyMaterial = new THREE.MeshStandardMaterial({
          color: getCreatureColor(speciesId),
          roughness: 0.7,
          metalness: 0.2
        });
        const juvBody = new THREE.Mesh(juvBodyGeometry, juvBodyMaterial);
        juvBody.castShadow = true;
        creature.add(juvBody);
        
        // Head
        const juvHeadGeometry = new THREE.SphereGeometry(0.3, 24, 24);
        const juvHeadMaterial = new THREE.MeshStandardMaterial({
          color: getCreatureColor(speciesId, true),
          roughness: 0.7,
          metalness: 0.2
        });
        const juvHead = new THREE.Mesh(juvHeadGeometry, juvHeadMaterial);
        juvHead.position.y = 0.5;
        juvHead.position.z = 0.4;
        juvHead.castShadow = true;
        creature.add(juvHead);
        
        // Neck
        const neckGeometry = new THREE.CylinderGeometry(0.15, 0.2, 0.4, 16);
        const neckMaterial = juvBodyMaterial;
        const neck = new THREE.Mesh(neckGeometry, neckMaterial);
        neck.position.y = 0.3;
        neck.position.z = 0.2;
        neck.rotation.x = Math.PI / 4;
        neck.castShadow = true;
        creature.add(neck);
        
        // Eyes
        const juvEyeGeometry = new THREE.SphereGeometry(0.06, 16, 16);
        const juvEyeMaterial = new THREE.MeshBasicMaterial({ color: 0x000000 });
        
        const juvLeftEye = new THREE.Mesh(juvEyeGeometry, juvEyeMaterial);
        juvLeftEye.position.x = -0.12;
        juvLeftEye.position.y = 0.05;
        juvLeftEye.position.z = 0.25;
        juvHead.add(juvLeftEye);
        
        const juvRightEye = new THREE.Mesh(juvEyeGeometry, juvEyeMaterial);
        juvRightEye.position.x = 0.12;
        juvRightEye.position.y = 0.05;
        juvRightEye.position.z = 0.25;
        juvHead.add(juvRightEye);
        
        // Eye highlights
        const juvHighlightGeometry = new THREE.SphereGeometry(0.02, 8, 8);
        const juvHighlightMaterial = new THREE.MeshBasicMaterial({ color: 0xFFFFFF });
        
        const juvLeftHighlight = new THREE.Mesh(juvHighlightGeometry, juvHighlightMaterial);
        juvLeftHighlight.position.x = 0.02;
        juvLeftHighlight.position.y = 0.02;
        juvLeftHighlight.position.z = 0.06;
        juvLeftEye.add(juvLeftHighlight);
        
        const juvRightHighlight = new THREE.Mesh(juvHighlightGeometry, juvHighlightMaterial);
        juvRightHighlight.position.x = 0.02;
        juvRightHighlight.position.y = 0.02;
        juvRightHighlight.position.z = 0.06;
        juvRightEye.add(juvRightHighlight);
        
        // Developing horn/crest (depending on species)
        if (speciesId % 2 === 0) {
          // Horn
          const hornGeometry = new THREE.ConeGeometry(0.08, 0.25, 16);
          const hornMaterial = new THREE.MeshStandardMaterial({
            color: 0xD3D3D3,
            roughness: 0.5,
            metalness: 0.5
          });
          const horn = new THREE.Mesh(hornGeometry, hornMaterial);
          horn.position.y = 0.2;
          horn.rotation.x = -Math.PI / 4;
          horn.castShadow = true;
          juvHead.add(horn);
        } else {
          // Crest
          const crestGeometry = new THREE.BoxGeometry(0.4, 0.1, 0.2);
          crestGeometry.translate(0, 0.15, 0);
          const crestMaterial = new THREE.MeshStandardMaterial({
            color: getCreatureColor(speciesId, true, 1.2), // Brighter color
            roughness: 0.7,
            metalness: 0.2
          });
          const crest = new THREE.Mesh(crestGeometry, crestMaterial);
          crest.castShadow = true;
          juvHead.add(crest);
        }
        
        // Tail
        const juvTailGeometry = new THREE.ConeGeometry(0.15, 0.6, 16);
        juvTailGeometry.rotateX(Math.PI / 2);
        const juvTailMaterial = juvBodyMaterial;
        const juvTail = new THREE.Mesh(juvTailGeometry, juvTailMaterial);
        juvTail.position.z = -0.7;
        juvTail.castShadow = true;
        creature.add(juvTail);
        
        // Legs
        const legGeometry = new THREE.CylinderGeometry(0.08, 0.1, 0.35, 12);
        const legMaterial = juvBodyMaterial;
        
        const frontLeftLeg = new THREE.Mesh(legGeometry, legMaterial);
        frontLeftLeg.position.set(-0.35, -0.4, 0.3);
        frontLeftLeg.castShadow = true;
        creature.add(frontLeftLeg);
        
        const frontRightLeg = new THREE.Mesh(legGeometry, legMaterial);
        frontRightLeg.position.set(0.35, -0.4, 0.3);
        frontRightLeg.castShadow = true;
        creature.add(frontRightLeg);
        
        const backLeftLeg = new THREE.Mesh(legGeometry, legMaterial);
        backLeftLeg.position.set(-0.35, -0.4, -0.3);
        backLeftLeg.castShadow = true;
        creature.add(backLeftLeg);
        
        const backRightLeg = new THREE.Mesh(legGeometry, legMaterial);
        backRightLeg.position.set(0.35, -0.4, -0.3);
        backRightLeg.castShadow = true;
        creature.add(backRightLeg);
        
        // Developing wings for some species types
        if (speciesId % 3 === 0) {
          const wingGeometry = new THREE.BoxGeometry(0.05, 0.4, 0.5);
          wingGeometry.translate(0, 0, -0.25);
          const wingMaterial = new THREE.MeshStandardMaterial({
            color: getCreatureColor(speciesId, true, 0.8), // Lighter color
            roughness: 0.7,
            metalness: 0.2,
            transparent: true,
            opacity: 0.9
          });
          
          const leftWing = new THREE.Mesh(wingGeometry, wingMaterial);
          leftWing.position.set(-0.5, 0.1, 0);
          leftWing.rotation.y = Math.PI / 4;
          leftWing.castShadow = true;
          creature.add(leftWing);
          
          const rightWing = new THREE.Mesh(wingGeometry, wingMaterial);
          rightWing.position.set(0.5, 0.1, 0);
          rightWing.rotation.y = -Math.PI / 4;
          rightWing.castShadow = true;
          creature.add(rightWing);
        }
        break;
        
      case 'adult':
      case 'mythical':
        // Create adult/mythical creature (full size, all features)
        // Determine if it's mythical for special effects
        const isMythical = stage === 'mythical';
        
        // Body
        const adultBodyGeometry = new THREE.SphereGeometry(0.5, 32, 32);
        adultBodyGeometry.scale(1.3, 1, 1.8);
        const adultBodyMaterial = new THREE.MeshStandardMaterial({
          color: getCreatureColor(speciesId, false, isMythical ? 1.2 : 1),
          roughness: isMythical ? 0.4 : 0.6,
          metalness: isMythical ? 0.5 : 0.2
        });
        const adultBody = new THREE.Mesh(adultBodyGeometry, adultBodyMaterial);
        adultBody.castShadow = true;
        creature.add(adultBody);
        
        // Head
        const adultHeadGeometry = new THREE.SphereGeometry(0.35, 32, 32);
        const adultHeadMaterial = new THREE.MeshStandardMaterial({
          color: getCreatureColor(speciesId, true, isMythical ? 1.2 : 1),
          roughness: isMythical ? 0.4 : 0.6,
          metalness: isMythical ? 0.5 : 0.2
        });
        const adultHead = new THREE.Mesh(adultHeadGeometry, adultHeadMaterial);
        adultHead.position.y = 0.6;
        adultHead.position.z = 0.6;
        adultHead.castShadow = true;
        creature.add(adultHead);
        
        // Strong neck
        const adultNeckGeometry = new THREE.CylinderGeometry(0.2, 0.25, 0.5, 16);
        const adultNeckMaterial = adultBodyMaterial;
        const adultNeck = new THREE.Mesh(adultNeckGeometry, adultNeckMaterial);
        adultNeck.position.y = 0.35;
        adultNeck.position.z = 0.3;
        adultNeck.rotation.x = Math.PI / 3.5;
        adultNeck.castShadow = true;
        creature.add(adultNeck);
        
        // Eyes
        const adultEyeGeometry = new THREE.SphereGeometry(0.07, 16, 16);
        const adultEyeMaterial = new THREE.MeshBasicMaterial({ 
          color: isMythical ? 0x00FFFF : 0x000000 
        });
        
        const adultLeftEye = new THREE.Mesh(adultEyeGeometry, adultEyeMaterial);
        adultLeftEye.position.x = -0.15;
        adultLeftEye.position.y = 0.05;
        adultLeftEye.position.z = 0.3;
        adultHead.add(adultLeftEye);
        
        const adultRightEye = new THREE.Mesh(adultEyeGeometry, adultEyeMaterial);
        adultRightEye.position.x = 0.15;
        adultRightEye.position.y = 0.05;
        adultRightEye.position.z = 0.3;
        adultHead.add(adultRightEye);
        
        // Eye highlights (not for mythical glowing eyes)
        if (!isMythical) {
          const adultHighlightGeometry = new THREE.SphereGeometry(0.025, 8, 8);
          const adultHighlightMaterial = new THREE.MeshBasicMaterial({ color: 0xFFFFFF });
          
          const adultLeftHighlight = new THREE.Mesh(adultHighlightGeometry, adultHighlightMaterial);
          adultLeftHighlight.position.x = 0.03;
          adultLeftHighlight.position.y = 0.03;
          adultLeftHighlight.position.z = 0.07;
          adultLeftEye.add(adultLeftHighlight);
          
          const adultRightHighlight = new THREE.Mesh(adultHighlightGeometry, adultHighlightMaterial);
          adultRightHighlight.position.x = 0.03;
          adultRightHighlight.position.y = 0.03;
          adultRightHighlight.position.z = 0.07;
          adultRightEye.add(adultRightHighlight);
        }
        
        // Full-grown horns/crest based on species
        if (speciesId % 3 === 0) {
          // Dual horns
          const hornGeometry = new THREE.ConeGeometry(0.08, 0.4, 16);
          const hornMaterial = new THREE.MeshStandardMaterial({
            color: isMythical ? 0xFFD700 : 0xD3D3D3,
            roughness: 0.3,
            metalness: 0.7
          });
          
          const leftHorn = new THREE.Mesh(hornGeometry, hornMaterial);
          leftHorn.position.set(-0.15, 0.25, 0.1);
          leftHorn.rotation.x = -Math.PI / 6;
          leftHorn.rotation.z = -Math.PI / 12;
          leftHorn.castShadow = true;
          adultHead.add(leftHorn);
          
          const rightHorn = new THREE.Mesh(hornGeometry, hornMaterial);
          rightHorn.position.set(0.15, 0.25, 0.1);
          rightHorn.rotation.x = -Math.PI / 6;
          rightHorn.rotation.z = Math.PI / 12;
          rightHorn.castShadow = true;
          adultHead.add(rightHorn);
        } 
        else if (speciesId % 3 === 1) {
          // Crown/crest
          const crestGeometry = new THREE.BoxGeometry(0.5, 0.2, 0.3);
          crestGeometry.translate(0, 0.2, 0);
          const crestMaterial = new THREE.MeshStandardMaterial({
            color: getCreatureColor(speciesId, true, 1.5), // Much brighter
            roughness: 0.5,
            metalness: 0.3,
            emissive: isMythical ? getCreatureColor(speciesId, true, 0.5) : 0x000000,
            emissiveIntensity: isMythical ? 0.5 : 0
          });
          const crest = new THREE.Mesh(crestGeometry, crestMaterial);
          crest.castShadow = true;
          adultHead.add(crest);
          
          // Add crest spikes for more detail
          for (let i = 0; i < 5; i++) {
            const spikeGeometry = new THREE.ConeGeometry(0.03, 0.2, 8);
            const spike = new THREE.Mesh(spikeGeometry, crestMaterial);
            spike.position.set(-0.2 + i * 0.1, 0.3, 0);
            spike.castShadow = true;
            adultHead.add(spike);
          }
        }
        else {
          // Single large horn
          const longHornGeometry = new THREE.ConeGeometry(0.1, 0.6, 16);
          const longHornMaterial = new THREE.MeshStandardMaterial({
            color: isMythical ? 0xE0E0FF : 0xE0E0E0,
            roughness: 0.3,
            metalness: 0.7,
            emissive: isMythical ? 0x8080FF : 0x000000,
            emissiveIntensity: isMythical ? 0.3 : 0
          });
          const longHorn = new THREE.Mesh(longHornGeometry, longHornMaterial);
          longHorn.position.set(0, 0.2, 0.05);
          longHorn.rotation.x = -Math.PI / 5;
          longHorn.castShadow = true;
          adultHead.add(longHorn);
        }
        
        // Tail
        const adultTailGeometry = new THREE.CylinderGeometry(0.15, 0.03, 1.2, 16);
        adultTailGeometry.translate(0, -0.6, 0);
        adultTailGeometry.rotateX(Math.PI / 2);
        const adultTailMaterial = adultBodyMaterial;
        const adultTail = new THREE.Mesh(adultTailGeometry, adultTailMaterial);
        adultTail.position.z = -0.8;
        adultTail.castShadow = true;
        creature.add(adultTail);
        
        // Add tail end (different shapes based on species)
        if (speciesId % 3 === 0) {
          // Spade-shaped tail end
          const spadeGeometry = new THREE.SphereGeometry(0.15, 16, 16);
          spadeGeometry.scale(1, 0.7, 0.3);
          const spadeMaterial = new THREE.MeshStandardMaterial({
            color: getCreatureColor(speciesId, true),
            roughness: 0.6,
            metalness: 0.2
          });
          const spade = new THREE.Mesh(spadeGeometry, spadeMaterial);
          spade.position.y = 0;
          spade.position.z = -1.2;
          spade.rotation.x = Math.PI / 3;
          spade.castShadow = true;
          adultTail.add(spade);
        } else {
          // Fluffy or pointed tail end
          const tailEndGeometry = speciesId % 2 === 0 
            ? new THREE.SphereGeometry(0.12, 16, 16) // Fluffy
            : new THREE.ConeGeometry(0.1, 0.3, 8);   // Pointed
            
          const tailEndMaterial = new THREE.MeshStandardMaterial({
            color: getCreatureColor(speciesId, true),
            roughness: 0.7,
            metalness: 0.1,
            emissive: isMythical ? getCreatureColor(speciesId, true, 0.3) : 0x000000,
            emissiveIntensity: isMythical ? 0.3 : 0
          });
          
          const tailEnd = new THREE.Mesh(tailEndGeometry, tailEndMaterial);
          tailEnd.position.z = -1.2;
          if (speciesId % 2 !== 0) {
            tailEnd.rotation.x = -Math.PI / 2; // Rotate cone for pointed tail
          }
          tailEnd.castShadow = true;
          adultTail.add(tailEnd);
        }
        
        // Strong legs
        const adultLegGeometry = new THREE.CylinderGeometry(0.12, 0.15, 0.6, 12);
        const adultLegMaterial = adultBodyMaterial;
        
        const adultFrontLeftLeg = new THREE.Mesh(adultLegGeometry, adultLegMaterial);
        adultFrontLeftLeg.position.set(-0.5, -0.45, 0.5);
        adultFrontLeftLeg.castShadow = true;
        creature.add(adultFrontLeftLeg);
        
        const adultFrontRightLeg = new THREE.Mesh(adultLegGeometry, adultLegMaterial);
        adultFrontRightLeg.position.set(0.5, -0.45, 0.5);
        adultFrontRightLeg.castShadow = true;
        creature.add(adultFrontRightLeg);
        
        const adultBackLeftLeg = new THREE.Mesh(adultLegGeometry, adultLegMaterial);
        adultBackLeftLeg.position.set(-0.5, -0.45, -0.5);
        adultBackLeftLeg.castShadow = true;
        creature.add(adultBackLeftLeg);
        
        const adultBackRightLeg = new THREE.Mesh(adultLegGeometry, adultLegMaterial);
        adultBackRightLeg.position.set(0.5, -0.45, -0.5);
        adultBackRightLeg.castShadow = true;
        creature.add(adultBackRightLeg);
        
        // Add feet
        const footGeometry = new THREE.SphereGeometry(0.15, 16, 16);
        footGeometry.scale(1, 0.5, 1.3);
        
        const adultFrontLeftFoot = new THREE.Mesh(footGeometry, adultLegMaterial);
        adultFrontLeftFoot.position.y = -0.3;
        adultFrontLeftLeg.add(adultFrontLeftFoot);
        
        const adultFrontRightFoot = new THREE.Mesh(footGeometry, adultLegMaterial);
        adultFrontRightFoot.position.y = -0.3;
        adultFrontRightLeg.add(adultFrontRightFoot);
        
        const adultBackLeftFoot = new THREE.Mesh(footGeometry, adultLegMaterial);
        adultBackLeftFoot.position.y = -0.3;
        adultBackLeftLeg.add(adultBackLeftFoot);
        
        const adultBackRightFoot = new THREE.Mesh(footGeometry, adultLegMaterial);
        adultBackRightFoot.position.y = -0.3;
        adultBackRightLeg.add(adultBackRightFoot);
        
        // Wings for flying species
        if ([0, 3, 4].includes(speciesId % 6)) {
          const wingGeometry = new THREE.BoxGeometry(0.05, 0.6, 1.2);
          wingGeometry.translate(0, 0.15, -0.4);
          
          const wingMaterial = new THREE.MeshStandardMaterial({
            color: getCreatureColor(speciesId, true, 0.9),
            roughness: 0.6,
            metalness: 0.2,
            transparent: true,
            opacity: 0.9,
            emissive: isMythical ? getCreatureColor(speciesId, true, 0.3) : 0x000000,
            emissiveIntensity: isMythical ? 0.3 : 0
          });
          
          const leftWing = new THREE.Mesh(wingGeometry, wingMaterial);
          leftWing.position.set(-0.7, 0.15, 0);
          leftWing.rotation.y = Math.PI / 6;
          leftWing.castShadow = true;
          creature.add(leftWing);
          
          const rightWing = new THREE.Mesh(wingGeometry, wingMaterial);
          rightWing.position.set(0.7, 0.15, 0);
          rightWing.rotation.y = -Math.PI / 6;
          rightWing.castShadow = true;
          creature.add(rightWing);
        }
        
        // Special effects for mythical creatures
        if (isMythical) {
          // Add particle effects or glowing aura
          const auraGeometry = new THREE.SphereGeometry(1.5, 32, 32);
          const auraColor = getCreatureColor(speciesId, true, 0.5);
          const auraMaterial = new THREE.MeshBasicMaterial({
            color: auraColor,
            transparent: true,
            opacity: 0.15,
            side: THREE.DoubleSide
          });
          const aura = new THREE.Mesh(auraGeometry, auraMaterial);
          creature.add(aura);
          
          // Add special markings/patterns on body
          const markingsGeometry = new THREE.PlaneGeometry(0.8, 1.2);
          const markingsMaterial = new THREE.MeshBasicMaterial({
            color: 0xFFFFFF,
            transparent: true,
            opacity: 0.5,
            side: THREE.DoubleSide
          });
          
          const frontMarkings = new THREE.Mesh(markingsGeometry, markingsMaterial);
          frontMarkings.position.z = 0.7;
          frontMarkings.position.y = 0.1;
          frontMarkings.rotation.x = Math.PI / 2;
          creature.add(frontMarkings);
        }
        break;
        
      default:
        // Default placeholder (simple sphere)
        const defaultGeometry = new THREE.SphereGeometry(0.5, 32, 32);
        const defaultMaterial = new THREE.MeshStandardMaterial({
          color: 0x999999,
          roughness: 0.7,
          metalness: 0.1
        });
        const defaultMesh = new THREE.Mesh(defaultGeometry, defaultMaterial);
        defaultMesh.castShadow = true;
        creature.add(defaultMesh);
    }
    
    // Position the creature
    creature.position.y = stage === 'egg' ? 0.5 : 0.7;
    
    // Add creature to scene
    scene.add(creature);
    
    // Enable habitat controls once a creature is added
    controls.enabled = true;
    rotateEnabled = true;
    
    // Enable habitat control buttons
    rotateLeftBtn.disabled = false;
    rotateRightBtn.disabled = false;
    zoomInBtn.disabled = false;
    zoomOutBtn.disabled = false;
    resetViewBtn.disabled = false;
  }
  
  // Helper to get consistent creature colors based on species ID
  function getCreatureColor(speciesId, isSecondary = false, brightnessFactor = 1) {
    // Base colors by habitat type
    const baseColors = [
      0x2d6a4f, // Forest (green)
      0x1e40af, // Ocean (blue)
      0x7f1d1d, // Mountain (brown/red)
      0x0369a1, // Sky (light blue)
      0x4c1d95, // Cosmic (purple)
      0x9d174d  // Enchanted (pink/magenta)
    ];
    
    // Secondary colors (slightly different hue)
    const secondaryColors = [
      0x3a8c5f, // Lighter forest green
      0x3b82f6, // Lighter ocean blue
      0x9a3412, // Reddish brown
      0x38bdf8, // Bright sky blue
      0x7c3aed, // Bright purple
      0xec4899  // Bright pink
    ];
    
    // Get the base color based on species ID
    const colorIndex = speciesId % baseColors.length;
    let color = isSecondary ? secondaryColors[colorIndex] : baseColors[colorIndex];
    
    // Apply brightness adjustment if needed
    if (brightnessFactor !== 1) {
      const hex = color.toString(16).padStart(6, '0');
      let r = parseInt(hex.substring(0, 2), 16);
      let g = parseInt(hex.substring(2, 4), 16);
      let b = parseInt(hex.substring(4, 6), 16);
      
      r = Math.min(255, Math.floor(r * brightnessFactor));
      g = Math.min(255, Math.floor(g * brightnessFactor));
      b = Math.min(255, Math.floor(b * brightnessFactor));
      
      color = (r << 16) + (g << 8) + b;
    }
    
    return color;
  }
  
  // Update creature display in the 3D scene
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
    
    // Update habitat visualization
    createHabitat(habitatType);
    
    // Update creature model
    createCreature(creatureStage, creatureSpecies);
    
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
      
      // Update 3D visualization
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
      
      // Update 3D visualization
      updateCreatureDisplay();
    } else {
      // Reset creature display
      if (creature) {
        scene.remove(creature);
        creature = null;
      }
      
      // Reset habitat to default
      createHabitat('default');
      
      // Reset creature info panel
      creatureInfoPanel.classList.add('opacity-0');
      
      // Disable habitat controls
      controls.enabled = false;
      rotateEnabled = false;
      
      // Disable habitat control buttons
      rotateLeftBtn.disabled = true;
      rotateRightBtn.disabled = true;
      zoomInBtn.disabled = true;
      zoomOutBtn.disabled = true;
      resetViewBtn.disabled = true;
    }
  });
  
  // Habitat control buttons
  rotateLeftBtn.addEventListener('click', function() {
    if (controls && rotateEnabled) {
      controls.rotateLeft(Math.PI / 8); // Rotate 22.5 degrees left
    }
  });
  
  rotateRightBtn.addEventListener('click', function() {
    if (controls && rotateEnabled) {
      controls.rotateRight(Math.PI / 8); // Rotate 22.5 degrees right
    }
  });
  
  zoomInBtn.addEventListener('click', function() {
    if (controls && rotateEnabled) {
      controls.dollyIn(1.2); // Zoom in
    }
  });
  
  zoomOutBtn.addEventListener('click', function() {
    if (controls && rotateEnabled) {
      controls.dollyOut(1.2); // Zoom out
    }
  });
  
  resetViewBtn.addEventListener('click', function() {
    if (controls && rotateEnabled) {
      // Reset camera position
      camera.position.set(0, 2, 5);
      camera.lookAt(0, 0, 0);
      controls.update();
    }
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
  
  // Window resize handler
  window.addEventListener('resize', onWindowResize);
  
  // Initialize the scene
  initScene();
  
  // Create default habitat
  createHabitat('default');
  
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
  
  // Update 3D visualization
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