<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<style>
  :root {
    --primary-bg: #F9F8F2;
    --primary-text: #111111;
    --accent-primary: #6B5CA5;
    --accent-secondary: #8FC0A9;
    --accent-tertiary: #C8553D;
    --neutral-light: #F5F5F5;
    --neutral-medium: #E0E0E0;
    --neutral-dark: #666666;
    --forest: #2d6a4f;
    --ocean: #1e40af;
    --mountain: #7f1d1d;
    --sky: #0369a1;
    --cosmic: #4c1d95;
    --enchanted: #9d174d;
  }
  
  /* Timer styles */
  .timer-circle {
    position: relative;
    width: 240px;
    height: 240px;
    border-radius: 50%;
    background: conic-gradient(var(--accent-primary) 0%, var(--neutral-light) 0%);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: background 0.1s linear;
  }
  
  .timer-circle-inner {
    position: absolute;
    width: 220px;
    height: 220px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    background: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  
  /* Animation classes */
  .fade-in {
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.5s ease, transform 0.5s ease;
  }
  
  .fade-in.visible {
    opacity: 1;
    transform: translateY(0);
  }
  
  .pulse {
    animation: pulse 2s infinite;
  }
  
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
  
  /* Stage badges */
  .badge-egg {
    background-color: #E0E0E0;
    color: #555555;
  }
  
  .badge-baby {
    background-color: #C5E1A5;
    color: #33691E;
  }
  
  .badge-juvenile {
    background-color: #90CAF9;
    color: #0D47A1;
  }
  
  .badge-adult {
    background-color: #CE93D8;
    color: #4A148C;
  }
  
  .badge-mythical {
    background-color: #FFD54F;
    color: #E65100;
  }
  
  /* Progress bars */
  .progress-bar {
    height: 6px;
    border-radius: 3px;
    background-color: var(--neutral-light);
    overflow: hidden;
  }
  
  .progress-bar-fill {
    height: 100%;
    border-radius: 3px;
    transition: width 0.3s ease;
  }
</style>

<div class="min-h-screen bg-[var(--primary-bg)]">
  <!-- Main Content Container -->
  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-6">
      <!-- Left Column: Timer and Active Creature -->
      <div class="w-full lg:w-1/2 order-2 lg:order-1">
        <!-- Focus Timer Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
          <div class="flex flex-col items-center">
            <!-- Timer Circle -->
            <div id="timer-circle" class="timer-circle mb-6">
              <div class="timer-circle-inner">
                <span id="timer-display" class="text-5xl font-bold text-[var(--primary-text)]">25:00</span>
                <p class="text-[var(--neutral-dark)] mt-2" id="timer-status">Ready to focus</p>
              </div>
            </div>
            
            <!-- Timer Controls -->
            <div class="flex space-x-4 mb-6">
              <button id="start-btn" class="px-6 py-3 bg-[var(--accent-primary)] hover:bg-opacity-90 text-white font-medium rounded-lg flex items-center transition-all duration-300">
                <i class="fas fa-play mr-2"></i>
                <span>Start Focus</span>
              </button>
              <button id="pause-btn" class="px-6 py-3 bg-[var(--neutral-light)] hover:bg-[var(--neutral-medium)] text-[var(--primary-text)] font-medium rounded-lg flex items-center transition-all duration-300 hidden">
                <i class="fas fa-pause mr-2"></i>
                <span>Pause</span>
              </button>
              <button id="resume-btn" class="px-6 py-3 bg-[var(--accent-primary)] hover:bg-opacity-90 text-white font-medium rounded-lg flex items-center transition-all duration-300 hidden">
                <i class="fas fa-play mr-2"></i>
                <span>Resume</span>
              </button>
              <button id="complete-btn" class="px-6 py-3 bg-[var(--accent-secondary)] hover:bg-opacity-90 text-white font-medium rounded-lg flex items-center transition-all duration-300 hidden">
                <i class="fas fa-check mr-2"></i>
                <span>Complete</span>
              </button>
              <button id="cancel-btn" class="px-6 py-3 bg-[var(--neutral-light)] text-[var(--accent-tertiary)] font-medium rounded-lg flex items-center hover:bg-[var(--neutral-medium)] transition-all duration-300 hidden">
                <i class="fas fa-times mr-2"></i>
                <span>Cancel</span>
              </button>
            </div>
            
            <!-- Timer Settings -->
            <div class="w-full max-w-md" id="timer-settings">
              <div class="flex justify-between mb-4">
                <span class="text-[var(--primary-text)] font-medium">Session Duration</span>
                <div class="flex space-x-2">
                  <button class="duration-btn px-3 py-1 rounded text-sm bg-[var(--accent-primary)] text-white" data-duration="25">25m</button>
                  <button class="duration-btn px-3 py-1 rounded text-sm bg-[var(--neutral-light)] text-[var(--primary-text)]" data-duration="30">30m</button>
                  <button class="duration-btn px-3 py-1 rounded text-sm bg-[var(--neutral-light)] text-[var(--primary-text)]" data-duration="45">45m</button>
                  <button class="duration-btn px-3 py-1 rounded text-sm bg-[var(--neutral-light)] text-[var(--primary-text)]" data-duration="60">60m</button>
                </div>
              </div>
              
              <!-- Creature Selection -->
              <div class="mb-4">
                <label for="creature-select" class="block text-[var(--primary-text)] font-medium mb-2">Choose a creature to grow:</label>
                <select id="creature-select" class="w-full p-2 border border-[var(--neutral-medium)] rounded-lg focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)]">
                  <option value="">Select a creature</option>
                  <?php foreach ($creatures as $creature): ?>
                  <option value="<?= $creature['id'] ?>" data-stage="<?= $creature['stage'] ?>" data-habitat="<?= $creature['habitat_type'] ?>">
                    <?= htmlspecialchars($creature['name'] ?? 'Unnamed ' . $creature['species_name']) ?> (<?= ucfirst($creature['stage']) ?>)
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Active Creature Card (Hidden initially) -->
        <div id="active-creature-card" class="bg-white rounded-xl shadow-sm p-6 mb-6 hidden">
          <div class="flex flex-col sm:flex-row gap-4 items-center sm:items-start">
            <div id="creature-avatar" class="w-24 h-24 bg-[var(--neutral-light)] rounded-lg flex items-center justify-center">
              <!-- Creature image will be loaded here -->
              <i class="fas fa-dragon text-[var(--neutral-dark)] text-3xl"></i>
            </div>
            
            <div class="flex-1">
              <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-2">
                <div>
                  <h3 id="creature-name" class="text-lg font-bold text-[var(--primary-text)]">Select a Creature</h3>
                  <p id="creature-species" class="text-[var(--neutral-dark)]">-</p>
                </div>
                <span id="creature-stage-badge" class="px-2 py-1 text-xs font-medium rounded-full badge-egg mt-1 sm:mt-0">
                  Egg
                </span>
              </div>
              
              <div class="mb-2">
                <div class="flex justify-between text-sm mb-1">
                  <span class="text-[var(--neutral-dark)]">Growth Progress</span>
                  <span id="growth-percentage" class="text-[var(--accent-primary)] font-medium">0%</span>
                </div>
                <div class="progress-bar">
                  <div id="growth-bar" class="progress-bar-fill bg-[var(--accent-primary)]" style="width: 0%"></div>
                </div>
              </div>
              
              <div class="flex flex-wrap gap-y-2 gap-x-4">
                <div class="flex items-center">
                  <i class="fas fa-heart text-red-500 mr-1.5 text-sm"></i>
                  <span class="text-sm text-[var(--neutral-dark)]" id="creature-health">Health: 100/100</span>
                </div>
                <div class="flex items-center">
                  <i class="fas fa-smile text-yellow-500 mr-1.5 text-sm"></i>
                  <span class="text-sm text-[var(--neutral-dark)]" id="creature-happiness">Happiness: 100/100</span>
                </div>
                <div class="flex items-center">
                  <i class="fas fa-home text-blue-500 mr-1.5 text-sm"></i>
                  <span class="text-sm text-[var(--neutral-dark)]" id="creature-habitat">Habitat: None</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Tips Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
          <h3 class="font-bold text-[var(--primary-text)] mb-4 flex items-center">
            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
            Focus Tips
          </h3>
          <ul class="space-y-3">
            <li class="flex items-start">
              <i class="fas fa-check-circle text-[var(--accent-secondary)] mt-1 mr-2"></i>
              <span class="text-[var(--neutral-dark)]">Find a quiet, comfortable space with minimal distractions.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check-circle text-[var(--accent-secondary)] mt-1 mr-2"></i>
              <span class="text-[var(--neutral-dark)]">Set a clear goal for what you want to accomplish during this session.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check-circle text-[var(--accent-secondary)] mt-1 mr-2"></i>
              <span class="text-[var(--neutral-dark)]">Keep your phone away or in silent mode to avoid notifications.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check-circle text-[var(--accent-secondary)] mt-1 mr-2"></i>
              <span class="text-[var(--neutral-dark)]">Take short breaks between focus sessions to recharge.</span>
            </li>
          </ul>
        </div>
      </div>
      
      <!-- Right Column: Statistics and History -->
      <div class="w-full lg:w-1/2 order-1 lg:order-2">
        <!-- Focus Stats Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
          <h3 class="font-bold text-[var(--primary-text)] mb-4">Your Focus Journey</h3>
          
          <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-[var(--primary-bg)] rounded-lg p-4 text-center">
              <p class="text-[var(--neutral-dark)] text-sm mb-1">Total Focus Time</p>
              <p class="text-2xl font-bold text-[var(--primary-text)]">
                <?= floor(($userStats['total_minutes'] ?? 0) / 60) ?>h <?= ($userStats['total_minutes'] ?? 0) % 60 ?>m
              </p>
            </div>
            
            <div class="bg-[var(--primary-bg)] rounded-lg p-4 text-center">
              <p class="text-[var(--neutral-dark)] text-sm mb-1">Focus Streak</p>
              <p class="text-2xl font-bold text-[var(--primary-text)]">
                <?= $userStats['current_streak'] ?? 0 ?> days
              </p>
            </div>
            
            <div class="bg-[var(--primary-bg)] rounded-lg p-4 text-center">
              <p class="text-[var(--neutral-dark)] text-sm mb-1">Sessions Completed</p>
              <p class="text-2xl font-bold text-[var(--primary-text)]">
                <?= $userStats['total_sessions'] ?? 0 ?>
              </p>
            </div>
            
            <div class="bg-[var(--primary-bg)] rounded-lg p-4 text-center">
              <p class="text-[var(--neutral-dark)] text-sm mb-1">Avg. Focus Score</p>
              <p class="text-2xl font-bold text-[var(--primary-text)]">
                <?= number_format($userStats['avg_focus_score'] ?? 0) ?>%
              </p>
            </div>
          </div>
          
          <!-- Weekly Focus Chart -->
          <div>
            <h4 class="font-medium text-[var(--primary-text)] mb-2">This Week's Focus</h4>
            <div class="w-full h-48 bg-[var(--primary-bg)] rounded-lg p-4">
              <!-- We'll render the chart here with JavaScript -->
              <canvas id="weekly-focus-chart"></canvas>
            </div>
          </div>
        </div>
        
        <!-- Focus History Card -->
        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-[var(--primary-text)]">Recent Focus Sessions</h3>
            <a href="<?= $baseUrl ?>/focus/history" class="text-[var(--accent-primary)] hover:underline text-sm font-medium">
              View All
            </a>
          </div>
          
          <?php if (empty($todaySessions)): ?>
          <div class="text-center py-6 text-[var(--neutral-dark)]">
            <i class="fas fa-history text-[var(--neutral-medium)] text-4xl mb-3"></i>
            <p class="mb-2">No focus sessions yet today</p>
            <p class="text-sm">Start your first session to begin growing your creatures!</p>
          </div>
          <?php else: ?>
          <div class="divide-y divide-[var(--neutral-light)]">
            <?php foreach(array_slice($todaySessions, 0, 5) as $session): ?>
            <div class="py-3">
              <div class="flex justify-between items-start">
                <div>
                  <p class="font-medium text-[var(--primary-text)]">
                    <?= date('g:i A', strtotime($session['start_time'])) ?> - 
                    <?= $session['end_time'] ? date('g:i A', strtotime($session['end_time'])) : 'In Progress' ?>
                  </p>
                  <p class="text-sm text-[var(--neutral-dark)]">
                    <?= $session['duration_minutes'] ?> minute session
                    <?php if ($session['creature_id']): ?>
                      with <?= htmlspecialchars($session['creature_name'] ?? 'Creature') ?>
                    <?php endif; ?>
                  </p>
                </div>
                <div class="flex items-center">
                  <?php if ($session['completed']): ?>
                  <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                    Completed
                  </span>
                  <?php elseif ($session['end_time'] === null): ?>
                  <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                    In Progress
                  </span>
                  <?php else: ?>
                  <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                    Canceled
                  </span>
                  <?php endif; ?>
                  
                  <?php if ($session['completed']): ?>
                  <div class="ml-2 text-yellow-500 flex items-center" title="Focus Score">
                    <span class="text-sm font-medium"><?= $session['focus_score'] ?></span>
                    <i class="fas fa-star text-xs ml-1"></i>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
              
              <?php if ($session['completed']): ?>
              <div class="flex items-center mt-1">
                <i class="fas fa-coins text-yellow-500 mr-1 text-xs"></i>
                <span class="text-sm text-[var(--neutral-dark)]">
                  Earned <?= $session['coins_earned'] ?> coins
                </span>
                <a href="<?= $baseUrl ?>/focus/summary/<?= $session['id'] ?>" class="ml-auto text-[var(--accent-primary)] hover:underline text-xs font-medium">
                  View Summary
                </a>
              </div>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Session Complete Modal -->
<div id="complete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-xl max-w-md w-full overflow-hidden">
    <div class="bg-[var(--accent-secondary)] px-6 py-4 text-white relative">
      <h3 class="text-xl font-bold">Session Complete!</h3>
      <button id="close-complete-modal" class="absolute top-4 right-4 text-white hover:text-white hover:opacity-80">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="p-6">
      <div class="text-center mb-6">
        <div class="w-20 h-20 bg-[var(--accent-secondary)] bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-check-circle text-[var(--accent-secondary)] text-4xl"></i>
        </div>
        <h4 class="text-xl font-bold text-[var(--primary-text)] mb-2">Great work!</h4>
        <p class="text-[var(--neutral-dark)]">You've completed a <span id="completed-duration">25</span> minute focus session.</p>
      </div>
      
      <div class="bg-[var(--primary-bg)] rounded-lg p-4 mb-6">
        <h5 class="font-medium text-[var(--primary-text)] mb-2">Session Results</h5>
        <div class="grid grid-cols-2 gap-4 text-center">
          <div>
            <p class="text-sm text-[var(--neutral-dark)] mb-1">Focus Score</p>
            <p class="text-xl font-bold text-[var(--primary-text)]" id="result-focus-score">85%</p>
          </div>
          <div>
            <p class="text-sm text-[var(--neutral-dark)] mb-1">Coins Earned</p>
            <div class="flex items-center justify-center">
              <span class="text-xl font-bold text-[var(--primary-text)] mr-1" id="result-coins">5</span>
              <i class="fas fa-coins text-yellow-500"></i>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Creature Growth (shown if creature was selected) -->
      <div id="result-creature-growth" class="bg-[var(--primary-bg)] rounded-lg p-4 mb-6 hidden">
        <h5 class="font-medium text-[var(--primary-text)] mb-2">Creature Growth</h5>
        <div class="flex items-center">
          <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mr-3">
            <i id="result-creature-icon" class="fas fa-dragon text-[var(--accent-primary)]"></i>
          </div>
          <div class="flex-1">
            <p class="font-medium text-[var(--primary-text)]" id="result-creature-name">Your Creature</p>
            <div class="w-full mt-1">
              <div class="flex justify-between text-xs mb-1">
                <span class="text-[var(--neutral-dark)]">Growth Progress</span>
                <span id="result-growth-text" class="text-[var(--accent-primary)]">+5 points</span>
              </div>
              <div class="progress-bar">
                <div id="result-growth-bar" class="progress-bar-fill bg-[var(--accent-primary)]" style="width: 35%"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="flex space-x-3">
        <button id="view-summary-btn" class="flex-1 px-4 py-2 border border-[var(--neutral-medium)] text-[var(--primary-text)] font-medium rounded-lg hover:bg-[var(--neutral-light)] transition-colors">
          View Summary
        </button>
        <button id="start-new-session-btn" class="flex-1 px-4 py-2 bg-[var(--accent-primary)] text-white font-medium rounded-lg hover:bg-opacity-90 transition-colors">
          Start New Session
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Add Chart.js for the focus chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Focus page JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initial variables
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
  const timerCircle = document.getElementById('timer-circle');
  const startBtn = document.getElementById('start-btn');
  const pauseBtn = document.getElementById('pause-btn');
  const resumeBtn = document.getElementById('resume-btn');
  const completeBtn = document.getElementById('complete-btn');
  const cancelBtn = document.getElementById('cancel-btn');
  const timerSettings = document.getElementById('timer-settings');
  const durationBtns = document.querySelectorAll('.duration-btn');
  const creatureSelect = document.getElementById('creature-select');
  const activeCreatureCard = document.getElementById('active-creature-card');
  
  // Modal elements
  const completeModal = document.getElementById('complete-modal');
  const closeCompleteModal = document.getElementById('close-complete-modal');
  const viewSummaryBtn = document.getElementById('view-summary-btn');
  const startNewSessionBtn = document.getElementById('start-new-session-btn');
  const completedDuration = document.getElementById('completed-duration');
  const resultFocusScore = document.getElementById('result-focus-score');
  const resultCoins = document.getElementById('result-coins');
  const resultCreatureGrowth = document.getElementById('result-creature-growth');
  
  // Helper functions
  function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
  }
  
  function updateTimerDisplay() {
    timerDisplay.textContent = formatTime(timeRemaining);
    
    // Update timer circle progress
    const progressPercent = ((sessionDuration - timeRemaining) / sessionDuration) * 100;
    timerCircle.style.background = `conic-gradient(var(--accent-primary) ${progressPercent}%, var(--neutral-light) 0%)`;
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
        name: selectedOption.text,
        stage: selectedOption.dataset.stage,
        habitat: selectedOption.dataset.habitat
      };
      
      // Show active creature card
      updateCreatureCard();
      activeCreatureCard.classList.remove('hidden');
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
    
    // Create focus session in backend
    fetch('<?= $baseUrl ?>/focus/start', {
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
    fetch('<?= $baseUrl ?>/focus/complete', {
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
      fetch('<?= $baseUrl ?>/focus/cancel', {
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
    
    // Hide active creature card
    activeCreatureCard.classList.add('hidden');
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
          creatureIcon.className = 'fas fa-egg';
          break;
        case 'baby':
          creatureIcon.className = 'fas fa-baby';
          break;
        case 'juvenile':
          creatureIcon.className = 'fas fa-paw';
          break;
        case 'adult':
        case 'mythical':
          creatureIcon.className = 'fas fa-dragon';
          break;
      }
      
      // Update growth progress
      let growthPercentage = 0;
      if (data.creature.stage === 'egg') {
        growthPercentage = (data.creature.growth_progress / 100) * 100;
      } else {
        growthPercentage = (data.creature.growth_progress / 200) * 100;
      }
      
      document.getElementById('result-growth-bar').style.width = `${growthPercentage}%`;
      document.getElementById('result-growth-text').textContent = `+${data.session.duration_minutes} points`;
      
      // Configure view summary button
      viewSummaryBtn.onclick = function() {
        window.location.href = `<?= $baseUrl ?>/focus/summary/${data.session.id}`;
      };
    } else {
      resultCreatureGrowth.classList.add('hidden');
      
      // Configure view summary button for no creature
      viewSummaryBtn.onclick = function() {
        window.location.href = `<?= $baseUrl ?>/focus/summary/${data.session.id}`;
      };
    }
    
    // Show modal
    completeModal.classList.remove('hidden');
  }
  
  function updateCreatureCard() {
    if (!selectedCreatureId || !selectedCreatureData) return;
    
    // Get creature details
    fetch(`<?= $baseUrl ?>/creatures/view/${selectedCreatureId}`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.creature) {
        const creature = data.creature;
        
        // Update creature card with fetched data
        document.getElementById('creature-name').textContent = creature.name || 'Unnamed Creature';
        document.getElementById('creature-species').textContent = creature.species_name;
        
        // Update stage badge
        const stageBadge = document.getElementById('creature-stage-badge');
        stageBadge.textContent = creature.stage.charAt(0).toUpperCase() + creature.stage.slice(1);
        stageBadge.className = `px-2 py-1 text-xs font-medium rounded-full badge-${creature.stage}`;
        
        // Update growth progress
        let growthPercentage = 0;
        if (creature.stage === 'egg') {
          growthPercentage = (creature.growth_progress / 100) * 100;
        } else {
          growthPercentage = (creature.growth_progress / 200) * 100;
        }
        
        document.getElementById('growth-percentage').textContent = `${Math.round(growthPercentage)}%`;
        document.getElementById('growth-bar').style.width = `${growthPercentage}%`;
        
        // Update creature stats
        document.getElementById('creature-health').textContent = `Health: ${creature.health}/100`;
        document.getElementById('creature-happiness').textContent = `Happiness: ${creature.happiness}/100`;
        
        if (creature.habitat_id) {
          document.getElementById('creature-habitat').textContent = `Habitat: ${creature.habitat_type || 'Unknown'}`;
        } else {
          document.getElementById('creature-habitat').textContent = `Habitat: None`;
        }
        
        // Update creature avatar/image
        const creatureAvatar = document.getElementById('creature-avatar');
        if (creature.stage === 'egg') {
          creatureAvatar.innerHTML = `<i class="fas fa-egg text-4xl text-${creature.habitat_type || 'gray'}-500"></i>`;
        } else {
          creatureAvatar.innerHTML = `<img src="<?= $baseUrl ?>/images/creatures/${creature.species_id}_${creature.stage}.png" alt="${creature.name}" class="h-20 w-20 object-contain">`;
        }
      }
    })
    .catch(error => {
      console.error('Error fetching creature details:', error);
    });
  }
  
  // Initialize weekly focus chart
  function initWeeklyChart() {
    const ctx = document.getElementById('weekly-focus-chart').getContext('2d');
    
    // Get dates for last 7 days
    const dates = [];
    for (let i = 6; i >= 0; i--) {
      const date = new Date();
      date.setDate(date.getDate() - i);
      dates.push(date.toLocaleDateString('en-US', { weekday: 'short' }));
    }
    
    // Sample data - in a real app, this would come from the backend
    const dailyMinutes = [
      <?= json_encode(array_map(function($day) { return $day['total_minutes'] ?? 0; }, $dailyFocusTime ?? [])) ?>
    ];
    
    // Ensure we have 7 days of data
    while (dailyMinutes.length < 7) {
      dailyMinutes.unshift(0);
    }
    
    // If we have more than 7 days, take only the last 7
    if (dailyMinutes.length > 7) {
      dailyMinutes = dailyMinutes.slice(-7);
    }
    
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: dates,
        datasets: [{
          label: 'Minutes Focused',
          data: dailyMinutes,
          backgroundColor: 'rgba(107, 92, 165, 0.7)',
          borderColor: 'rgba(107, 92, 165, 1)',
          borderWidth: 1,
          borderRadius: 5,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              display: false
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  }
  
  // Initialize timer display
  updateTimerDisplay();
  
  // Initialize weekly chart
  initWeeklyChart();
  
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
        b.classList.remove('bg-[var(--accent-primary)]', 'text-white');
        b.classList.add('bg-[var(--neutral-light)]', 'text-[var(--primary-text)]');
      });
      this.classList.remove('bg-[var(--neutral-light)]', 'text-[var(--primary-text)]');
      this.classList.add('bg-[var(--accent-primary)]', 'text-white');
      
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
        name: selectedOption.text,
        stage: selectedOption.dataset.stage,
        habitat: selectedOption.dataset.habitat
      };
    } else {
      selectedCreatureData = {};
    }
  });
  
  // Complete modal listeners
  closeCompleteModal.addEventListener('click', function() {
    completeModal.classList.add('hidden');
  });
  
  startNewSessionBtn.addEventListener('click', function() {
    completeModal.classList.add('hidden');
    resetTimer();
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
        name: creatureSelect.options[i].text,
        stage: creatureSelect.options[i].dataset.stage,
        habitat: creatureSelect.options[i].dataset.habitat
      };
      break;
    }
  }
  
  // Show and update creature card
  updateCreatureCard();
  activeCreatureCard.classList.remove('hidden');
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
  
  timerInterval = setInterval(function() {
    if (timeRemaining <= 0) {
      completeSession();
    } else {
      timeRemaining--;
      updateTimerDisplay();
    }
  }, 1000);
  <?php endif; ?>
  
  // Intersection Observer for fade-in elements
  const fadeElements = document.querySelectorAll('.fade-in');
  
  if ('IntersectionObserver' in window) {
    const fadeObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          fadeObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });
    
    fadeElements.forEach(element => {
      fadeObserver.observe(element);
    });
  } else {
    // Fallback for browsers without Intersection Observer support
    fadeElements.forEach(element => {
      element.classList.add('visible');
    });
  }
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>