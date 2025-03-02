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

            window.addEventListener('beforeunload', function(e) {
                // Only show confirmation if a timer is running and not paused
                if (timerRunning && !timerPaused && activeSessionId) {
                    // Standard way to show confirmation dialog
                    const confirmationMessage = 'Your focus session will be marked as incomplete if you leave.';
                    e.returnValue = confirmationMessage;
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
                    return confirmationMessage;
                }
            });

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