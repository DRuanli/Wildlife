<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Inline Styles & Font Imports: Feel free to move these to your main CSS file -->
<style>
  /* Import Google Fonts */
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@400;500&display=swap');

  :root {
    --primary-color: #CE6246;
    --background-color: #F9F8F2;
    --text-dark: #111;
    --text-gray: #333;
  }

  /* Global Styles */
  body {
    background-color: var(--background-color);
    color: var(--text-gray);
    font-family: 'Inter', Helvetica, Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  /* Headline (Large) */
  .headline {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem; /* ~56px */
    font-weight: 500;
    line-height: 1.1;
    letter-spacing: -0.5px;
    color: var(--text-dark);
    margin: 2rem 0 1rem;
  }

  /* Sub-Headline / Section Title */
  .sub-headline {
    font-family: 'Playfair Display', serif;
    font-size: 2rem; /* ~32px */
    font-weight: 400;
    line-height: 1.2;
    color: var(--text-dark);
    margin: 1rem 0;
  }

  /* Body Text */
  .body-text {
    font-size: 1rem; /* 16px */
    line-height: 1.6;
    color: var(--text-gray);
    margin-bottom: 1rem;
  }

  /* Small Text (Captions/Disclaimers) */
  .small-text {
    font-size: 0.875rem; /* 14px */
    line-height: 1.3;
    color: #555;
  }

  /* Button Styles */
  .btn {
    font-size: 1rem;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s ease;
    display: inline-block;
  }
  .btn-primary {
    background-color: var(--primary-color);
    color: #fff;
  }
  .btn-primary:hover {
    background-color: #b55a3f;
  }
  .btn-secondary {
    background-color: var(--background-color);
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
  }
  .btn-secondary:hover {
    background-color: var(--primary-color);
    color: #fff;
  }

  /* Section Layout */
  .section {
    padding: 4rem 1rem;
    text-align: center;
  }

  /* Hero Section */
  .hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: url('<?= $baseUrl ?>/images/hero-bg.jpg') center/cover no-repeat;
    color: #fff;
  }
  .hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
  }
  .hero-content {
    position: relative;
    z-index: 1;
    padding: 2rem;
  }

  /* Creature Gallery Cards */
  .creature-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    width: 300px;
    margin: 0 auto;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .creature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
  }
  .creature-card img {
    width: 100%;
    height: auto;
  }
  .creature-card .card-content {
    padding: 1rem;
  }
</style>

<main>
  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1 class="headline">Meet Wildlife Haven</h1>
      <p class="body-text" style="font-size:1.25rem;">
        Transform your focus into a force for conservation. Nurture mythical creatures while making a real impact.
      </p>
      <div>
        <a href="<?= $baseUrl ?>/auth/register" class="btn btn-primary" aria-label="Get Started">Get Started</a>
        <a href="#features" class="btn btn-secondary" aria-label="Learn More" style="margin-left:1rem;">Learn More</a>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="section" id="features">
    <h2 class="sub-headline">Innovative Focus Tools</h2>
    <p class="body-text">
      Experience a cutting-edge focus timer, dynamic creature gallery, and immersive testimonials—all designed to elevate your productivity and passion for conservation.
    </p>
  </section>

  <!-- Interactive Focus Timer (Front-End Only) -->
  <section class="section" id="focus-timer">
    <h2 class="sub-headline">Interactive Focus Timer</h2>
    <div id="timer" style="font-size: 2rem; font-family: 'Courier New', monospace;">00:00</div>
    <div style="margin-top: 1rem;">
      <button class="btn btn-primary" onclick="startTimer()">Start</button>
      <button class="btn btn-secondary" onclick="pauseTimer()">Pause</button>
      <button class="btn btn-secondary" onclick="resetTimer()">Reset</button>
    </div>
  </section>

  <!-- Virtual Sanctuary Section -->
  <section class="section" id="creature-gallery">
    <h2 class="sub-headline">Virtual Sanctuary</h2>
    <p class="body-text">Explore your growing collection of mythical creatures nurtured by your focus sessions.</p>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem;">
      <!-- Creature Card 1 -->
      <div class="creature-card">
        <img src="<?= $baseUrl ?>/images/creature1.jpg" alt="Aurora the Phoenix">
        <div class="card-content">
          <h3 class="sub-headline" style="font-size: 1.5rem; margin:0;">Aurora the Phoenix</h3>
          <p class="small-text">Rises from the ashes with each focus session.</p>
        </div>
      </div>
      <!-- Creature Card 2 -->
      <div class="creature-card">
        <img src="<?= $baseUrl ?>/images/creature2.jpg" alt="Zephyr the Dragon">
        <div class="card-content">
          <h3 class="sub-headline" style="font-size: 1.5rem; margin:0;">Zephyr the Dragon</h3>
          <p class="small-text">Soars high with your productivity.</p>
        </div>
      </div>
      <!-- Creature Card 3 -->
      <div class="creature-card">
        <img src="<?= $baseUrl ?>/images/creature3.jpg" alt="Luna the Unicorn">
        <div class="card-content">
          <h3 class="sub-headline" style="font-size: 1.5rem; margin:0;">Luna the Unicorn</h3>
          <p class="small-text">Brings magic and clarity to your sessions.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="section" id="testimonials">
    <h2 class="sub-headline">What Our Users Say</h2>
    <p class="body-text">
      Discover how Wildlife Haven has revolutionized focus sessions, blending productivity with conservation seamlessly.
    </p>
    <div style="max-width: 600px; margin: 0 auto;">
      <blockquote style="font-size: 1.25rem; line-height: 1.6; color: var(--text-gray); margin: 2rem 0; font-style: italic;">
        "Wildlife Haven revolutionized my productivity, blending focus with conservation seamlessly."
      </blockquote>
      <p class="small-text">- Sarah K., Student</p>
    </div>
  </section>
</main>

<script>
  // Simple JavaScript timer (front-end only)
  let timerInterval;
  let seconds = 0;
  function updateTimer() {
    const timerEl = document.getElementById('timer');
    const mins = Math.floor(seconds / 60);
    const secs = seconds % 60;
    timerEl.textContent = String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
  }
  function startTimer() {
    if (!timerInterval) {
      timerInterval = setInterval(() => {
        seconds++;
        updateTimer();
      }, 1000);
    }
  }
  function pauseTimer() {
    clearInterval(timerInterval);
    timerInterval = null;
  }
  function resetTimer() {
    pauseTimer();
    seconds = 0;
    updateTimer();
  }
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
