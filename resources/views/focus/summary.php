<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Inline CSS for demonstration – ideally move these styles to your main CSS file -->
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@500&display=swap');

  :root {
    --bg-color: #F9F8F2;
    --text-dark: #111;
    --text-gray: #333;
    --accent: #CE6246;
  }

  body {
    background-color: var(--bg-color);
    font-family: 'Inter', sans-serif;
    color: var(--text-gray);
  }
  h1, h2, h3, h4 {
    font-family: 'Playfair Display', serif;
    color: var(--text-dark);
  }
  /* Container */
  .container {
    max-width: 1200px;
    margin: 0 auto;
  }
  /* Header Section */
  .session-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
  }
  .session-header h1 {
    font-size: 2rem;
    font-weight: bold;
  }
  .btn-back {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.25rem;
    background: #e5e7eb;
    color: #444;
    border-radius: 6px;
    transition: background 0.3s;
  }
  .btn-back:hover {
    background: #d1d5db;
  }
  /* Summary Card */
  .summary-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
  }
  .summary-card-header {
    background: var(--accent);
    color: #fff;
    padding: 1.5rem 1.75rem;
  }
  .summary-card-header h2 {
    font-size: 1.5rem;
    font-weight: bold;
  }
  .summary-card-body {
    padding: 1.75rem;
  }
  .success-message {
    text-align: center;
    margin-bottom: 2rem;
  }
  .success-message .icon-circle {
    width: 80px;
    height: 80px;
    background: #d1fae5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: #16a34a;
  }
  .success-message h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
  }
  .grid-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
  }
  .stat-card {
    background: #f9fafb;
    border-radius: 6px;
    padding: 1rem;
    text-align: center;
  }
  .stat-card .label {
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
  }
  .stat-card .value {
    font-size: 1.5rem;
    font-weight: 600;
  }
  /* Dynamic Focus Score Color */
  .score-high { color: #16a34a; }
  .score-med { color: #2563eb; }
  .score-low { color: #ca8a04; }
  .score-very-low { color: #dc2626; }

  /* Creature Growth Section */
  .creature-section {
    background: #f9fafb;
    border-radius: 6px;
    padding: 1.5rem;
    margin-bottom: 2rem;
  }
  .creature-section .creature-info {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
  }
  .creature-img {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #e5f5e0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
  }
  .creature-img img, .creature-img i {
    width: 40px;
    height: 40px;
  }
  .creature-info h4 {
    font-size: 1.125rem;
    font-weight: 600;
  }
  .growth-bar-wrapper {
    margin-top: 0.75rem;
  }
  .growth-bar {
    height: 8px;
    background: #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
  }
  .growth-progress {
    height: 100%;
    background: var(--accent);
    transition: width 0.3s ease;
  }
  /* Conservation Impact */
  .conservation-section {
    background: #f9fafb;
    border-radius: 6px;
    padding: 1.5rem;
    margin-bottom: 2rem;
  }
  .conservation-section .impact-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #ecfdf5;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: #16a34a;
  }
  /* Action Buttons */
  .action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 2rem;
  }
  .action-buttons a {
    padding: 0.75rem 1.25rem;
    border-radius: 6px;
    font-weight: 500;
    transition: background 0.3s;
  }
  .btn-primary {
    background: var(--accent);
    color: #fff;
  }
  .btn-primary:hover {
    background: #b55a3f;
  }
  .btn-secondary {
    background: #6366f1;
    color: #fff;
  }
  .btn-secondary:hover {
    background: #4f46e5;
  }
  /* Tips Section */
  .tips-card {
    background: #fff;
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 2rem;
  }
  .tips-card-header {
    background: #2563eb;
    color: #fff;
    padding: 1.25rem;
  }
  .tips-card-header h2 {
    font-size: 1.25rem;
    font-weight: bold;
  }
  .tips-card-body {
    padding: 1.5rem;
  }
  .tips-card ul {
    list-style: none;
    padding-left: 0;
  }
  .tips-card li {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1rem;
  }
  .tips-card li i {
    color: #facc15;
    margin-right: 0.75rem;
    margin-top: 0.25rem;
  }
  .tips-card li h4 {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 0.25rem;
  }
  .tips-card li p {
    font-size: 0.875rem;
    color: #555;
  }
  
  /* Confetti Canvas is appended dynamically */
</style>

<div class="container mx-auto px-4 py-8">
  <div class="max-w-3xl mx-auto">
    <!-- Page Header -->
    <div class="session-header">
      <h1>Session Summary</h1>
      <a href="<?= $baseUrl ?>/focus" class="btn-back">
        <i class="fas fa-arrow-left mr-2"></i> Back to Focus
      </a>
    </div>

    <!-- Summary Card -->
    <div class="summary-card">
      <div class="summary-card-header">
        <h2>Focus Session Completed!</h2>
      </div>
      <div class="summary-card-body">
        <!-- Celebratory Message with Confetti (triggered on page load) -->
        <div class="success-message">
          <div class="icon-circle">
            <i class="fas fa-check-circle" style="font-size: 2.5rem;"></i>
          </div>
          <h3>Great job staying focused!</h3>
          <p>You've completed your focus session successfully.</p>
        </div>
        
        <!-- Session Statistics -->
        <div class="grid-stats">
          <!-- Duration -->
          <div class="stat-card">
            <div class="label">Duration</div>
            <div class="value"><?= $session['duration_minutes'] ?> min</div>
          </div>
          <!-- Focus Score -->
          <div class="stat-card">
            <div class="label">Focus Score</div>
            <?php
              $score = $session['focus_score'];
              if ($score >= 80) $scoreClass = 'score-high';
              else if ($score >= 60) $scoreClass = 'score-med';
              else if ($score >= 40) $scoreClass = 'score-low';
              else $scoreClass = 'score-very-low';
            ?>
            <div class="value <?= $scoreClass ?>"><?= $score ?>%</div>
          </div>
          <!-- Coins Earned -->
          <div class="stat-card">
            <div class="label">Coins Earned</div>
            <div class="value text-yellow-600"><?= $session['coins_earned'] ?> <i class="fas fa-coins"></i></div>
          </div>
          <!-- Completed At -->
          <div class="stat-card">
            <div class="label">Completed At</div>
            <div class="value"><?= date('M j, g:i A', strtotime($session['end_time'])) ?></div>
          </div>
        </div>

        <!-- Creature Growth Section -->
        <?php if ($creature): ?>
        <div class="creature-section">
          <h3 class="text-lg font-semibold mb-4">Creature Development</h3>
          <div class="creature-info">
            <div class="creature-img bg-<?= $creature['habitat_type'] ?? 'green' ?>-100">
              <?php if ($creature['stage'] === 'egg'): ?>
                <i class="fas fa-egg text-<?= $creature['habitat_type'] ?? 'green' ?>-500" style="font-size:1.75rem;"></i>
              <?php else: ?>
                <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>">
              <?php endif; ?>
            </div>
            <div>
              <h4><?= htmlspecialchars($creature['name'] ?? 'Your Creature') ?></h4>
              <p class="text-sm text-gray-600"><?= ucfirst($creature['stage']) ?> <?= $creature['species_name'] ?? 'Creature' ?></p>
              
              <!-- Growth Progress Bar -->
              <?php
                // Calculate growth percentage
                if ($creature['stage'] === 'egg') {
                  $growthPercentage = min(100, ($creature['growth_progress'] / 100) * 100);
                } else {
                  $growthPercentage = min(100, ($creature['growth_progress'] / 200) * 100);
                }
              ?>
              <div class="growth-bar-wrapper">
                <div class="growth-bar">
                  <div class="growth-progress" style="width: <?= $growthPercentage ?>%;"></div>
                </div>
                <span class="text-sm ml-2"><?= round($growthPercentage) ?>%</span>
              </div>
            </div>
          </div>
          <div class="mt-4 text-sm text-gray-600">
            <p>
              <i class="fas fa-seedling text-green-500 mr-1"></i>
              Your focus session has helped your creature grow!
            </p>
            <?php if ($creature['stage'] === 'egg' && $growthPercentage >= 100): ?>
              <p class="text-green-600 font-medium mt-2">
                <i class="fas fa-egg-crack mr-1"></i>
                Your egg is ready to hatch! Visit your creature page to hatch it.
              </p>
            <?php elseif ($creature['stage'] !== 'mythical' && $growthPercentage >= 100): ?>
              <p class="text-green-600 font-medium mt-2">
                <i class="fas fa-level-up-alt mr-1"></i>
                Your creature is ready to evolve! Visit your creature page to evolve it.
              </p>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Conservation Impact Section -->
        <?php if ($conservationImpact): ?>
        <div class="conservation-section">
          <h3 class="text-lg font-semibold mb-4">Your Conservation Impact</h3>
          <div class="flex items-center mb-4">
            <div class="impact-icon">
              <i class="fas fa-tree" style="font-size:1.75rem;"></i>
            </div>
            <div>
              <h4 class="font-medium">You've contributed to real-world conservation!</h4>
              <p class="text-sm">Your session helped support <?= $conservationImpact['partner_name'] ?></p>
              <div class="mt-2 text-green-600 font-medium">
                <i class="fas fa-heart mr-1"></i>
                Impact: <?= $conservationImpact['potential_impact'] ?> units
              </div>
            </div>
          </div>
          <p class="text-sm">Keep focusing to increase your impact and help protect wildlife worldwide.</p>
        </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="action-buttons">
          <a href="<?= $baseUrl ?>/focus" class="btn-primary">
            <i class="fas fa-redo mr-2"></i> Start Another Session
          </a>
          <?php if ($creature): ?>
            <a href="<?= $baseUrl ?>/creatures/view/<?= $creature['id'] ?>" class="btn-secondary">
              <i class="fas fa-dragon mr-2"></i> View Your Creature
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Tips for Next Time -->
    <div class="tips-card">
      <div class="tips-card-header">
        <h2>Tips for Next Time</h2>
      </div>
      <div class="tips-card-body">
        <ul>
          <li>
            <i class="fas fa-lightbulb"></i>
            <div>
              <h4>Try the Pomodoro Technique</h4>
              <p>Break your work into 25-minute sessions with 5-minute breaks. After 4 sessions, take a longer break.</p>
            </div>
          </li>
          <li>
            <i class="fas fa-bell"></i>
            <div>
              <h4>Set a Regular Schedule</h4>
              <p>Focus at the same times each day to build a habit—your brain will automatically switch to focus mode.</p>
            </div>
          </li>
          <li>
            <i class="fas fa-list"></i>
            <div>
              <h4>Define Clear Objectives</h4>
              <p>Before each session, jot down your goals to provide direction and purpose.</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Confetti Animation Script -->
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
    const particles = [];
    const particleCount = 150;
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
        particles.forEach(p => {
            p.y += p.speed;
            p.x += Math.sin(p.angle) * 1.5;
            p.angle += p.rotation;
            p.rotation += p.rotationSpeed;
            ctx.fillStyle = p.color;
            ctx.beginPath();
            ctx.rect(p.x, p.y, p.size, p.size);
            ctx.fill();
            if (p.y > canvas.height) {
                p.y = -20;
                p.x = Math.random() * canvas.width;
            }
        });
        if (Date.now() - startTime < 5000) {
            requestAnimationFrame(animate);
        } else {
            canvas.remove();
        }
    }
    const startTime = Date.now();
    animate();
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
