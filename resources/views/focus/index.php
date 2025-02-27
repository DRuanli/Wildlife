<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Session Timer Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="bg-green-600 text-white px-6 py-4">
            <h2 class="text-xl font-bold">Focus Timer</h2>
        </div>
        
        <div class="p-6">
            <?php if ($activeSession): ?>
                <!-- Active Session -->
                <div id="active-session" data-session-id="<?= $activeSession['id'] ?>" data-duration="<?= $activeSession['duration_minutes'] ?>" data-start-time="<?= $activeSession['start_time'] ?>">
                    <div class="text-center mb-8">
                        <div class="text-6xl font-bold text-gray-800 mb-2 timer-display">25:00</div>
                        <p class="text-gray-600">Stay focused until the timer ends</p>
                    </div>
                    
                    <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-4 mb-6">
                        <button id="pause-btn" class="inline-flex items-center px-6 py-3 bg-yellow-500 text-white font-medium rounded-lg hover:bg-yellow-600 transition duration-150">
                            <i class="fas fa-pause mr-2"></i> Pause Session
                        </button>
                        <button id="complete-btn" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition duration-150">
                            <i class="fas fa-check mr-2"></i> Complete Early
                        </button>
                        <button id="cancel-btn" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition duration-150">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </button>
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
                            <div class="text-center mb-4">
                                <p class="text-gray-700 mb-2">This session is helping your creature grow:</p>
                                <div class="flex items-center justify-center">
                                    <div class="w-16 h-16 bg-<?= $activeCreature['habitat_type'] ?? 'green' ?>-100 rounded-full flex items-center justify-center mr-3">
                                        <?php if ($activeCreature['stage'] === 'egg'): ?>
                                            <i class="fas fa-egg text-<?= $activeCreature['habitat_type'] ?? 'green' ?>-500 text-2xl"></i>
                                        <?php else: ?>
                                            <img src="<?= $baseUrl ?>/images/creatures/<?= $activeCreature['species_id'] ?>_<?= $activeCreature['stage'] ?>.png" alt="<?= $activeCreature['name'] ?>" class="h-12 w-12">
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-left">
                                        <h4 class="font-medium text-gray-800"><?= htmlspecialchars($activeCreature['name'] ?? 'Your creature') ?></h4>
                                        <p class="text-sm text-gray-600"><?= ucfirst($activeCreature['stage']) ?> <?= $activeCreature['species_name'] ?? 'Creature' ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <div class="mt-6 bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                        <h4 class="font-medium text-yellow-800 mb-2">Focus Tips</h4>
                        <ul class="text-sm text-yellow-700 space-y-2">
                            <li><i class="fas fa-lightbulb mr-2"></i> Close other tabs and applications to avoid distractions.</li>
                            <li><i class="fas fa-lightbulb mr-2"></i> Put your phone on silent mode or in another room.</li>
                            <li><i class="fas fa-lightbulb mr-2"></i> Stay hydrated and take deep breaths if you feel your focus waning.</li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <!-- Start New Session -->
                <form id="start-session-form" class="space-y-6">
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Session Duration</label>
                        <select id="duration" name="duration" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="15">15 minutes</option>
                            <option value="25" selected>25 minutes</option>
                            <option value="30">30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60">60 minutes</option>
                            <option value="90">90 minutes</option>
                        </select>
                    </div>
                    
                    <?php if (!empty($creatures)): ?>
                        <div>
                            <label for="creature" class="block text-sm font-medium text-gray-700 mb-1">Associate with Creature (Optional)</label>
                            <p class="text-xs text-gray-500 mb-2">Focus sessions help your creatures grow and evolve</p>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="relative">
                                    <input type="radio" id="no-creature" name="creature_id" value="" class="absolute opacity-0 w-full h-full cursor-pointer z-10 peer">
                                    <label for="no-creature" class="block p-4 border border-gray-200 rounded-lg bg-white peer-checked:border-green-500 peer-checked:ring-2 peer-checked:ring-green-500 transition-all cursor-pointer">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-times text-gray-400 text-xl"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium">No Creature</h4>
                                                <p class="text-sm text-gray-500">Focus without a creature</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                
                                <?php foreach ($creatures as $creature): ?>
                                    <div class="relative">
                                        <input type="radio" id="creature-<?= $creature['id'] ?>" name="creature_id" value="<?= $creature['id'] ?>" class="absolute opacity-0 w-full h-full cursor-pointer z-10 peer">
                                        <label for="creature-<?= $creature['id'] ?>" class="block p-4 border border-gray-200 rounded-lg bg-white peer-checked:border-green-500 peer-checked:ring-2 peer-checked:ring-green-500 transition-all cursor-pointer">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-<?= $creature['habitat_type'] ?? 'green' ?>-100 rounded-full flex items-center justify-center mr-3">
                                                    <?php if ($creature['stage'] === 'egg'): ?>
                                                        <i class="fas fa-egg text-<?= $creature['habitat_type'] ?? 'green' ?>-500 text-2xl"></i>
                                                    <?php else: ?>
                                                        <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-10 w-10">
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium"><?= htmlspecialchars($creature['name'] ?? 'Creature') ?></h4>
                                                    <p class="text-sm text-gray-500"><?= ucfirst($creature['stage']) ?></p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-6">
                        <button type="submit" id="start-session-btn" class="w-full py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition duration-150">
                            <i class="fas fa-play mr-2"></i> Start Focus Session
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Focus Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Focus Time -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-3">
                <h3 class="text-lg font-semibold">Total Focus Time</h3>
            </div>
            <div class="p-4 text-center">
                <div class="text-3xl font-bold text-gray-800 mb-1">
                    <?= floor($total_focus_time / 60) ?> hrs <?= $total_focus_time % 60 ?> mins
                </div>
                <p class="text-sm text-gray-600">Lifetime focus time</p>
            </div>
        </div>
        
        <!-- Current Streak -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-orange-600 text-white px-6 py-3">
                <h3 class="text-lg font-semibold">Current Streak</h3>
            </div>
            <div class="p-4 text-center">
                <div class="text-3xl font-bold text-gray-800 mb-1">
                    <?= $streak_days ?> <?= $streak_days === 1 ? 'day' : 'days' ?>
                </div>
                <p class="text-sm text-gray-600">Keep it going!</p>
            </div>
        </div>
        
        <!-- Average Focus Score -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-purple-600 text-white px-6 py-3">
                <h3 class="text-lg font-semibold">Average Focus Score</h3>
            </div>
            <div class="p-4 text-center">
                <div class="text-3xl font-bold text-gray-800 mb-1">
                    <?= round($avg_focus_score ?? 0) ?>%
                </div>
                <p class="text-sm text-gray-600">How well you stay focused</p>
            </div>
        </div>
    </div>
    
    <!-- Today's Sessions -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold">Today's Sessions</h2>
            <a href="<?= $baseUrl ?>/focus/history" class="text-sm text-indigo-100 hover:text-white hover:underline">View Full History</a>
        </div>
        
        <div class="p-6">
            <?php if (empty($todaySessions)): ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                        <i class="fas fa-calendar-day text-2xl"></i>
                    </div>
                    <h3 class="text-gray-700 font-medium mb-2">No sessions yet today</h3>
                    <p class="text-gray-500 mb-4">Start your first focus session to begin tracking your progress.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Focus Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rewards</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($todaySessions as $session): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('g:i A', strtotime($session['start_time'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $session['duration_minutes'] ?> mins
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($session['end_time'] === null): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                In Progress
                                            </span>
                                        <?php elseif ($session['completed']): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Cancelled
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($session['focus_score']): ?>
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
                                                <span class="ml-2 text-sm text-gray-600"><?= $score ?>%</span>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-400">--</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php if ($session['coins_earned']): ?>
                                            <span class="text-yellow-600">
                                                <?= $session['coins_earned'] ?> <i class="fas fa-coins"></i>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-400">--</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php if ($session['completed']): ?>
                                            <a href="<?= $baseUrl ?>/focus/summary/<?= $session['id'] ?>" class="text-indigo-600 hover:text-indigo-900">
                                                View Summary
                                            </a>
                                        <?php elseif ($session['end_time'] === null): ?>
                                            <a href="<?= $baseUrl ?>/focus" class="text-indigo-600 hover:text-indigo-900">
                                                Return to Session
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-400">--</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- JavaScript for Timer Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Timer variables
    let timerInterval;
    let remainingSeconds = 0;
    let isPaused = false;
    
    // Elements
    const startForm = document.getElementById('start-session-form');
    const startBtn = document.getElementById('start-session-btn');
    const activeSession = document.getElementById('active-session');
    
    // If there's an active session
    if (activeSession) {
        const sessionId = activeSession.dataset.sessionId;
        const duration = parseInt(activeSession.dataset.duration, 10);
        const startTime = new Date(activeSession.dataset.startTime);
        const timerDisplay = document.querySelector('.timer-display');
        const pauseBtn = document.getElementById('pause-btn');
        const completeBtn = document.getElementById('complete-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        
        // Calculate remaining time
        const now = new Date();
        const elapsedSeconds = Math.floor((now - startTime) / 1000);
        remainingSeconds = duration * 60 - elapsedSeconds;
        
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
                pauseBtn.innerHTML = '<i class="fas fa-pause mr-2"></i> Pause Session';
                startTimer();
            } else {
                // Pause timer
                isPaused = true;
                pauseBtn.innerHTML = '<i class="fas fa-play mr-2"></i> Resume Session';
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
            
            // Create session data
            const sessionData = {
                duration: parseInt(duration, 10),
                creature_id: creatureId ? parseInt(creatureId, 10) : null
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
                    startBtn.innerHTML = '<i class="fas fa-play mr-2"></i> Start Focus Session';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error starting session. Please try again.');
                startBtn.disabled = false;
                startBtn.innerHTML = '<i class="fas fa-play mr-2"></i> Start Focus Session';
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
            
            if (remainingSeconds <= 0) {
                // Timer completed
                clearInterval(timerInterval);
                remainingSeconds = 0;
                
                // Auto-complete session
                if (activeSession) {
                    completeSession(activeSession.dataset.sessionId);
                }
            }
            
            updateTimerDisplay();
        }, 1000);
    }
    
    function updateTimerDisplay() {
        if (!activeSession) return;
        
        const timerDisplay = document.querySelector('.timer-display');
        const minutes = Math.floor(remainingSeconds / 60);
        const seconds = remainingSeconds % 60;
        
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
    
    function completeSession(sessionId) {
        // Set focus score (in a real app, this would be calculated based on user behavior)
        const focusScore = Math.floor(Math.random() * 21) + 80; // Random score between 80-100 for demonstration
        
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
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>