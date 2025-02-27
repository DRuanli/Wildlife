<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Session Summary</h1>
            <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Focus
            </a>
        </div>
        
        <!-- Summary Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-green-600 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Focus Session Completed!</h2>
            </div>
            
            <div class="p-6">
                <!-- Success Message with Confetti Animation -->
                <div class="text-center mb-8">
                    <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center text-green-600 mb-4">
                        <i class="fas fa-check-circle text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-1">Great job staying focused!</h3>
                    <p class="text-gray-600">You've completed your focus session successfully.</p>
                </div>
                
                <!-- Session Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <!-- Duration -->
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-gray-500 text-sm mb-1">Duration</div>
                        <div class="text-2xl font-bold text-gray-800"><?= $session['duration_minutes'] ?> min</div>
                    </div>
                    
                    <!-- Focus Score -->
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-gray-500 text-sm mb-1">Focus Score</div>
                        <div class="text-2xl font-bold 
                            <?php
                            $score = $session['focus_score'];
                            if ($score >= 80) echo 'text-green-600';
                            else if ($score >= 60) echo 'text-blue-600';
                            else if ($score >= 40) echo 'text-yellow-600';
                            else echo 'text-red-600';
                            ?>
                        "><?= $score ?>%</div>
                    </div>
                    
                    <!-- Coins Earned -->
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-gray-500 text-sm mb-1">Coins Earned</div>
                        <div class="text-2xl font-bold text-yellow-600"><?= $session['coins_earned'] ?> <i class="fas fa-coins text-lg"></i></div>
                    </div>
                    
                    <!-- Date & Time -->
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-gray-500 text-sm mb-1">Completed At</div>
                        <div class="text-lg font-medium text-gray-800"><?= date('M j, g:i A', strtotime($session['end_time'])) ?></div>
                    </div>
                </div>
                
                <?php if ($creature): ?>
                    <!-- Creature Growth -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Creature Development</h3>
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-<?= $creature['habitat_type'] ?? 'green' ?>-100 rounded-full flex items-center justify-center mr-4">
                                <?php if ($creature['stage'] === 'egg'): ?>
                                    <i class="fas fa-egg text-<?= $creature['habitat_type'] ?? 'green' ?>-500 text-2xl"></i>
                                <?php else: ?>
                                    <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-12 w-12">
                                <?php endif; ?>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800"><?= htmlspecialchars($creature['name'] ?? 'Your creature') ?></h4>
                                <p class="text-sm text-gray-600"><?= ucfirst($creature['stage']) ?> <?= $creature['species_name'] ?? 'Creature' ?></p>
                                
                                <!-- Growth Progress Bar -->
                                <div class="mt-2">
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                <?php
                                                // Calculate growth percentage
                                                $growthPercentage = 0;
                                                if ($creature['stage'] === 'egg') {
                                                    // Simplified growth calculation for display
                                                    $growthPercentage = min(100, ($creature['growth_progress'] / 100) * 100);
                                                } else {
                                                    $growthPercentage = min(100, ($creature['growth_progress'] / 200) * 100);
                                                }
                                                ?>
                                                <div class="h-full bg-<?= $creature['habitat_type'] ?? 'green' ?>-500" style="width: <?= $growthPercentage ?>%"></div>
                                            </div>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600"><?= round($growthPercentage) ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-sm text-gray-600">
                            <p class="mb-2">
                                <i class="fas fa-seedling text-green-500 mr-1"></i> 
                                Your focus session has helped your creature grow!
                            </p>
                            <?php if ($creature['stage'] === 'egg' && $growthPercentage >= 100): ?>
                                <p class="text-green-600 font-medium">
                                    <i class="fas fa-egg-crack mr-1"></i>
                                    Your egg is ready to hatch! Visit your creatures to hatch it.
                                </p>
                            <?php elseif ($creature['stage'] !== 'mythical' && $growthPercentage >= 100): ?>
                                <p class="text-green-600 font-medium">
                                    <i class="fas fa-level-up-alt mr-1"></i>
                                    Your creature is ready to evolve! Visit your creatures to evolve it.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($conservationImpact): ?>
                    <!-- Conservation Impact -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Your Conservation Impact</h3>
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-600 mr-4">
                                <i class="fas fa-tree text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">You've contributed to real-world conservation!</h4>
                                <p class="text-sm text-gray-600">Your focus session has contributed to <?= $conservationImpact['partner_name'] ?></p>
                                
                                <div class="mt-2 text-green-600 font-medium">
                                    <i class="fas fa-heart mr-1"></i>
                                    Impact: <?= $conservationImpact['potential_impact'] ?> units
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            Keep focusing to increase your conservation impact and help protect wildlife around the world.
                        </p>
                    </div>
                <?php endif; ?>
                
                <!-- Buttons for Next Actions -->
                <div class="flex flex-col sm:flex-row sm:justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="<?= $baseUrl ?>/focus" class="inline-flex justify-center items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-redo mr-2"></i> Start Another Session
                    </a>
                    <?php if ($creature): ?>
                        <a href="<?= $baseUrl ?>/creatures/view/<?= $creature['id'] ?>" class="inline-flex justify-center items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-dragon mr-2"></i> View Your Creature
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Tips for Next Time -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Tips for Next Time</h2>
            </div>
            
            <div class="p-6">
                <ul class="space-y-4">
                    <li class="flex">
                        <i class="fas fa-lightbulb text-yellow-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-800 mb-1">Try the Pomodoro Technique</h4>
                            <p class="text-sm text-gray-600">Break your work into 25-minute sessions with 5-minute breaks in between. After 4 sessions, take a longer break of 15-30 minutes.</p>
                        </div>
                    </li>
                    <li class="flex">
                        <i class="fas fa-bell text-yellow-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-800 mb-1">Set a regular schedule</h4>
                            <p class="text-sm text-gray-600">Focus at the same times each day to build a habit. Your brain will begin to automatically shift into focus mode at these times.</p>
                        </div>
                    </li>
                    <li class="flex">
                        <i class="fas fa-list text-yellow-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-800 mb-1">Define clear objectives</h4>
                            <p class="text-sm text-gray-600">Before each focus session, write down exactly what you want to accomplish. This gives your session direction and purpose.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Simple Confetti Animation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.createElement('canvas');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    canvas.style.position = 'fixed';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = '1000';
    document.body.appendChild(canvas);
    
    const ctx = canvas.getContext('2d');
    
    // Confetti particles
    const particles = [];
    const particleCount = 100;
    const colors = ['#4CAF50', '#2196F3', '#FFC107', '#E91E63', '#9C27B0'];
    
    for (let i = 0; i < particleCount; i++) {
        particles.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height - canvas.height,
            size: Math.random() * 5 + 5,
            color: colors[Math.floor(Math.random() * colors.length)],
            speed: Math.random() * 3 + 2,
            angle: Math.random() * 2 * Math.PI,
            rotation: Math.random() * 0.2 - 0.1,
            rotationSpeed: Math.random() * 0.01 - 0.005
        });
    }
    
    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        for (let i = 0; i < particles.length; i++) {
            const p = particles[i];
            
            p.y += p.speed;
            p.x += Math.sin(p.angle) * 1.5;
            p.angle += p.rotation;
            p.rotation += p.rotationSpeed;
            
            ctx.fillStyle = p.color;
            ctx.beginPath();
            ctx.rect(p.x, p.y, p.size, p.size);
            ctx.fill();
            
            // Reset particle if it's off screen
            if (p.y > canvas.height) {
                particles[i].y = -20;
                particles[i].x = Math.random() * canvas.width;
            }
        }
        
        // Stop animation after 5 seconds
        if (Date.now() - startTime < 5000) {
            requestAnimationFrame(animate);
        } else {
            // Remove canvas after animation ends
            canvas.remove();
        }
    }
    
    const startTime = Date.now();
    animate();
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>