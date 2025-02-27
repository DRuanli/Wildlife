<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Inline Styles & Font Imports (move to your main CSS file as desired) -->
<style>
  /* Import Google Fonts */
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@400;500&display=swap');

  :root {
    --primary-color: #4D724D;
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
    background: url('<?= $baseUrl ?>/public/videos/vid.mov') center/cover no-repeat;
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

  /* ADVANCED FOCUS TIMER WITH RADIAL PROGRESS */
  #focus-timer {
    text-align: center;
  }
  #focus-timer svg {
    transform: rotate(-90deg);
  }
  #timerDisplay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(90deg);
    font-family: 'Courier New', monospace;
    font-size: 2rem;
    pointer-events: none;
  }
  #timerInput {
    width: 60px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 0.25rem;
  }

  /* ADVANCED CREATURE GALLERY CARDS (Interactive Flip Cards) */
  .advanced-grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
  }
  .advanced-card {
    position: relative;
    perspective: 1000px; /* Enables 3D space */
    border-radius: 12px;
    border: 1px solid #E5E5E5;
    height: 350px;
    overflow: hidden;
    cursor: pointer;
  }
  .advanced-card-content {
    width: 100%;
    height: 100%;
    transition: transform 0.6s;
    transform-style: preserve-3d;
    position: relative;
  }
  .advanced-card-front,
  .advanced-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    padding: 2rem;
    box-sizing: border-box;
    backface-visibility: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    border-radius: 12px;
  }
  .advanced-card-front {
    background-color: #FAF6EE;
    z-index: 2;
  }
  .advanced-card-back {
    background-color: #FFF9F4;
    transform: rotateY(180deg);
    z-index: 1;
  }
  
  /* ADVANCED TESTIMONIALS CAROUSEL STYLES */
  .testimonial-carousel {
    position: relative;
    max-width: 700px;
    margin: 0 auto;
    overflow: hidden;
  }
  .testimonial-slides {
    position: relative;
    width: 100%;
    height: 200px;
  }
  .testimonial-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    opacity: 0;
    transition: opacity 0.8s ease-in-out;
    text-align: center;
    padding: 1rem;
    box-sizing: border-box;
  }
  .testimonial-slide.active {
    opacity: 1;
    z-index: 1;
  }
  .testimonial-quote {
    font-size: 1.25rem;
    line-height: 1.6;
    color: var(--text-gray);
    font-style: italic;
    margin-bottom: 1rem;
  }
  .testimonial-author {
    font-size: 0.875rem;
    color: #555;
  }
  .carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.8);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s ease;
    font-size: 1rem;
  }
  .carousel-btn:hover {
    background: rgba(255,255,255,1);
  }
  .prev-btn { left: -20px; }
  .next-btn { right: -20px; }
  .carousel-dots {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
    gap: 0.5rem;
  }
  .carousel-dot {
    width: 10px;
    height: 10px;
    background: #ccc;
    border-radius: 50%;
    cursor: pointer;
  }
  .carousel-dot.active { background: var(--primary-color); }

  /* Responsive adjustments for carousel buttons */
  @media (max-width: 768px) {
    .carousel-btn { width: 32px; height: 32px; }
    .prev-btn { left: 5px; }
    .next-btn { right: 5px; }
  }
</style>

<!-- AlpineJS for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<main>
  <!-- HERO SECTION -->
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

  <!-- FEATURES SECTION -->
<section class="section" id="features" style="background-color: #F9F8F2; padding: 6rem 0;">
  <div class="container mx-auto px-4 text-center">
    <h2 class="sub-headline text-4xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif;">Innovative Focus Tools</h2>
    <p class="body-text text-lg text-gray-700 mb-12">
      Experience a cutting-edge focus timer, dynamic creature gallery, and immersive testimonials—all designed to elevate your productivity and passion for conservation.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      <!-- Feature Card 1: Focus Timer -->
      <div class="feature-card bg-white rounded-2xl shadow-lg p-8 transform transition duration-300 hover:scale-105">
        <div class="icon mb-6">
          <i class="fas fa-clock text-6xl" style="color: #4D724D;"></i>
        </div>
        <h3 class="text-2xl font-semibold text-gray-800 mb-3">Advanced Focus Timer</h3>
        <p class="text-gray-600">
          Stay in the zone with our dynamic radial progress timer that visualizes your focus sessions in real time.
        </p>
      </div>
      <!-- Feature Card 2: Creature Gallery -->
        <div class="feature-card bg-white rounded-2xl shadow-lg p-8 transform transition duration-300 hover:scale-105">
            <div class="icon mb-6">
                <i class="fas fa-kiwi-bird text-6xl" style="color: #2F4F2F;"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-800 mb-3">Dynamic Creature Gallery</h3>
            <p class="text-gray-600">
                Unlock and evolve a collection of mystical creatures (including rare species like the Kiwi Bird) as you hit your focus milestones.
            </p>
        </div>

      <!-- Feature Card 3: Testimonials -->
      <div class="feature-card bg-white rounded-2xl shadow-lg p-8 transform transition duration-300 hover:scale-105">
        <div class="icon mb-6">
          <i class="fas fa-comment-dots text-6xl" style="color: #CE6246;"></i>
        </div>
        <h3 class="text-2xl font-semibold text-gray-800 mb-3">Immersive Testimonials</h3>
        <p class="text-gray-600">
          Read inspiring success stories from users who have transformed their productivity and supported conservation.
        </p>
      </div>
    </div>
  </div>
</section>


  <!-- ADVANCED FOCUS TIMER WITH RADIAL PROGRESS -->
<section class="section" id="focus-timer" style="text-align: center; font-family: 'Inter', sans-serif;">
  <h2 class="sub-headline" style="margin-bottom: 1rem; color: #4D724D;">Interactive Focus Timer</h2>
  
  <!-- Timer Container -->
  <div class="timer-container" style="display: inline-block; position: relative; margin-bottom: 2rem;">
    <svg id="timerRing" width="220" height="220">
      <!-- Background Circle -->
      <circle
        id="timerCircleBg"
        cx="110"
        cy="110"
        r="95"
        fill="none"
        stroke="#e0e0e0"
        stroke-width="15"
      ></circle>
      <!-- Progress Circle -->
      <circle
        id="timerCircle"
        cx="110"
        cy="110"
        r="95"
        fill="none"
        stroke="#4D724D"
        stroke-width="15"
        stroke-linecap="round"
        stroke-dasharray="597"
        stroke-dashoffset="597"
      ></circle>
    </svg>
    <div id="timerDisplay" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); font-size:2.5rem; color:#4D724D;">
      25:00
    </div>
  </div>
  
  <!-- Controls & Duration Input -->
  <div style="margin-bottom: 1rem;">
    <label for="timerInput" class="small-text" style="margin-right: 0.5rem; color:#555;">
      Set Focus Time (minutes):
    </label>
    <input id="timerInput" type="number" min="1" max="999" value="25" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 60px; text-align: center;" />
  </div>
  
  <!-- Action Buttons -->
  <div class="timer-controls" style="display: inline-flex; gap: 1rem; margin-bottom: 1rem;">
    <button id="startBtn" class="btn" onclick="startTimer()" style="width: 100px; border: none; background-color: #4D724D; color: #fff; padding: 0.5rem; border-radius: 4px;">
      <i class="fas fa-play"></i> Start
    </button>
    <button id="pauseBtn" class="btn" onclick="togglePause()" style="width: 100px; border: none; background-color: #4D724D; color: #fff; padding: 0.5rem; border-radius: 4px;">
      <i class="fas fa-pause"></i> Pause
    </button>
    <button id="resetBtn" class="btn" onclick="resetTimer()" style="width: 100px; border: none; background-color: #4D724D; color: #fff; padding: 0.5rem; border-radius: 4px;">
      <i class="fas fa-sync-alt"></i> Reset
    </button>
  </div>
  
  <!-- Sound Options -->
  <div style="margin-top: 1rem;">
    <label for="soundSelect" class="small-text" style="margin-right: 0.5rem; color:#555;">Sound Option:</label>
    <select id="soundSelect" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
      <option value="beep">Beep</option>
      <option value="chime">Chime</option>
      <option value="alarm">Alarm</option>
    </select>
  </div>
  
  <!-- Audio Elements -->
  <audio id="beepAudio" src="<?= $baseUrl ?>/audio/beep.mp3" preload="auto"></audio>
  <audio id="chimeAudio" src="<?= $baseUrl ?>/audio/chime.mp3" preload="auto"></audio>
  <audio id="alarmAudio" src="<?= $baseUrl ?>/audio/alarm.mp3" preload="auto"></audio>
</section>

<!-- CSS Styles for Pulse Effect -->
<style>
  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }
  /* Class to apply pulse animation */
  .pulse {
    animation: pulse 1s ease-in-out infinite;
  }
  
  /* Optional: Hover effect for buttons */
  .btn:hover {
    opacity: 0.9;
  }
</style>

<!-- JavaScript for Timer Functionality & UI Updates -->
<script>
  let totalTime, remainingTime, timerInterval;
  let isPaused = false;
  
  const timerCircle = document.getElementById('timerCircle');
  const timerDisplay = document.getElementById('timerDisplay');
  const startBtn = document.getElementById('startBtn');
  const pauseBtn = document.getElementById('pauseBtn');
  const timerInput = document.getElementById('timerInput');
  
  const audioElements = {
    beep: document.getElementById('beepAudio'),
    chime: document.getElementById('chimeAudio'),
    alarm: document.getElementById('alarmAudio')
  };
  
  function startTimer() {
    // Lấy thời gian từ input (phút) và chuyển về giây
    totalTime = parseInt(timerInput.value) * 60;
    remainingTime = totalTime;
    updateDisplay();
    resetCircle();
    // Phát âm thanh bắt đầu
    playSound('beep');
    
    // Cài đặt lại các nút
    startBtn.disabled = true;
    pauseBtn.disabled = false;
    pauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
    isPaused = false;
    
    timerInterval = setInterval(() => {
      if (!isPaused) {
        remainingTime--;
        updateDisplay();
        updateCircle();
        // Nếu thời gian dưới 10%, thêm hiệu ứng pulse cho vòng tròn
        if (remainingTime / totalTime <= 0.1) {
          timerCircle.classList.add('pulse');
        } else {
          timerCircle.classList.remove('pulse');
        }
        if (remainingTime <= 0) {
          clearInterval(timerInterval);
          playSound('alarm');
          startBtn.disabled = false;
          pauseBtn.disabled = true;
        }
      }
    }, 1000);
  }
  
  function updateDisplay() {
    let minutes = Math.floor(remainingTime / 60);
    let seconds = remainingTime % 60;
    timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
  }
  
  function resetCircle() {
    // Tổng chu vi của vòng tròn
    const circumference = 2 * Math.PI * timerCircle.getAttribute('r');
    timerCircle.setAttribute('stroke-dasharray', circumference);
    timerCircle.setAttribute('stroke-dashoffset', circumference);
  }
  
  function updateCircle() {
    const circumference = 2 * Math.PI * timerCircle.getAttribute('r');
    const progress = (totalTime - remainingTime) / totalTime;
    timerCircle.setAttribute('stroke-dashoffset', circumference * (1 - progress));
  }
  
  function togglePause() {
    if (!startBtn.disabled) return; // Nếu chưa bắt đầu, không làm gì
    isPaused = !isPaused;
    if (isPaused) {
      pauseBtn.innerHTML = '<i class="fas fa-play"></i> Resume';
      playSound('chime');
    } else {
      pauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
    }
  }
  
  function resetTimer() {
    clearInterval(timerInterval);
    remainingTime = totalTime;
    updateDisplay();
    resetCircle();
    timerCircle.classList.remove('pulse');
    startBtn.disabled = false;
    pauseBtn.disabled = false;
    pauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
  }
  
  function playSound(type) {
    // Lấy giá trị âm thanh đã chọn từ dropdown
    const selectedSound = document.getElementById('soundSelect').value;
    // Phát âm thanh dựa trên loại sự kiện
    if (type === 'beep') {
      audioElements[selectedSound].currentTime = 0;
      audioElements[selectedSound].play();
    } else if (type === 'chime') {
      audioElements[selectedSound].currentTime = 0;
      audioElements[selectedSound].play();
    } else if (type === 'alarm') {
      audioElements[selectedSound].currentTime = 0;
      audioElements[selectedSound].play();
    }
  }
</script>


<!-- ADVANCED CARDS SECTION (Our Commitments) -->
<section class="section" id="value-props" style="text-align: left;">
    <div style="max-width: 1200px; margin: 0 auto;">
      <h2 class="sub-headline" style="margin-bottom: 1rem;">Our Commitments</h2>
      <p class="body-text" style="margin-bottom: 2rem;">
        We uphold these core principles to ensure a secure, trustworthy, and ever-evolving platform for our users.
      </p>
      
      <!-- Grid Container -->
      <div class="advanced-grid-container">
        <!-- Each card uses AlpineJS for flip effect on click -->
        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <!-- Front Face -->
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/public/img/panda.jpg" alt="Secure Icon" class="card-icon" />
            </div>
            <!-- Back Face -->
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Giant Panda (Ailuropoda melanoleuca)</h4>
              <p class="small-text">
                <em>An iconic species of China, the giant panda is famous for its black-and-white fur and a diet primarily consisting of bamboo. Their population is limited and strictly protected.</em>
              </p>
            </div>
          </div>
        </div>

        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <!-- Front Face -->
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/public/img/snow_leopard.png" alt="Secure Icon" class="card-icon" />
            </div>
            <!-- Back Face -->
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Snow Leopard (Panthera uncia)</h4>
              <p class="small-text">
                <em>Inhabiting the high mountains of Central Asia, the snow leopard is a symbol of strength but is at risk due to illegal hunting and habitat loss.</em>
              </p>
            </div>
          </div>
        </div>

        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <!-- Front Face -->
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/public/img/whale.png" alt="Secure Icon" class="card-icon" />
            </div>
            <!-- Back Face -->
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Blue Whale (Balaenoptera musculus)</h4>
              <p class="small-text">
                <em>As the largest animal on Earth, the blue whale is under severe pressure from hunting and ocean pollution, making it extremely rare.</em>
              </p>
            </div>
          </div>
        </div>

        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <!-- Front Face -->
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/public/img/ele.png" alt="Secure Icon" class="card-icon" />
            </div>
            <!-- Back Face -->
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Asian Elephant (Elephas maximus)</h4>
              <p class="small-text">
                <em>Asian elephants are severely threatened by habitat loss and human-wildlife conflict. They play a vital role in maintaining the biodiversity of Asian forests.</em>
              </p>
            </div>
          </div>
        </div>

        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <!-- Front Face -->
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/public/img/rhino.png" alt="Secure Icon" class="card-icon" />
            </div>
            <!-- Back Face -->
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Sumatran Rhinoceros (Dicerorhinus sumatrensis)</h4>
              <p class="small-text">
                <em>This species is one of the smallest and rarest rhinoceroses in the world. It is critically endangered due to poaching and habitat destruction.</em>
              </p>
            </div>
          </div>
        </div>

        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <!-- Front Face -->
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/public/img/IndochineseTiger.jpg" alt="Secure Icon" class="card-icon" />
            </div>
            <!-- Back Face -->
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Indochinese Tiger (Panthera tigris corbetti)</h4>
              <p class="small-text">
                <em>One of the most endangered tiger species, the Indochinese tiger faces habitat loss and illegal poaching. It plays a crucial role in the tropical forest ecosystem of Southeast Asia.</em>
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  
  <!-- ADVANCED TESTIMONIALS CAROUSEL -->
  <section class="section" id="testimonials" style="text-align: center;">
    <h2 class="sub-headline" style="margin-bottom: 1rem;">What Our Users Say</h2>
    <p class="body-text" style="margin-bottom: 2rem;">
      Discover how Wildlife Haven has revolutionized focus sessions, blending productivity with conservation seamlessly.
    </p>

    <!-- Carousel Container -->
    <div class="testimonial-carousel">
      <div class="testimonial-slides">
        <!-- Slides will be generated dynamically -->
      </div>
      
      <!-- Navigation Controls -->
      <button class="carousel-btn prev-btn" aria-label="Previous testimonial">
        <i class="fa fa-chevron-left"></i>
      </button>
      <button class="carousel-btn next-btn" aria-label="Next testimonial">
        <i class="fa fa-chevron-right"></i>
      </button>
      
      <!-- Dots (Pagination) -->
      <div class="carousel-dots"></div>
    </div>
  </section>
</main>

<!-- JavaScript for Radial Timer -->
<script>
  let timerInterval;
  let remainingSeconds = 0;
  let totalSeconds = 0;
  
  const circle = document.getElementById('timerCircle');
  const circumference = 565.48;
  const timerDisplay = document.getElementById('timerDisplay');
  const beepAudio = document.getElementById('beepAudio');

  function updateTimerDisplay() {
    const mins = Math.floor(remainingSeconds / 60);
    const secs = remainingSeconds % 60;
    timerDisplay.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    const fraction = remainingSeconds / totalSeconds;
    const offset = circumference - (fraction * circumference);
    circle.style.strokeDashoffset = offset;
  }
  
  function startTimer() {
    if (timerInterval) return;
    if (remainingSeconds <= 0) {
      const inputMins = parseInt(document.getElementById('timerInput').value) || 25;
      totalSeconds = inputMins * 60;
      remainingSeconds = totalSeconds;
      updateTimerDisplay();
    }
    timerInterval = setInterval(() => {
      remainingSeconds--;
      updateTimerDisplay();
      if (remainingSeconds <= 0) {
        clearInterval(timerInterval);
        timerInterval = null;
        remainingSeconds = 0;
        beepAudio.currentTime = 0;
        beepAudio.play().catch(err => console.log(err));
      }
    }, 1000);
  }
  
  function pauseTimer() {
    clearInterval(timerInterval);
    timerInterval = null;
  }
  
  function resetTimer() {
    pauseTimer();
    remainingSeconds = 0;
    circle.style.strokeDashoffset = circumference;
    timerDisplay.textContent = '00:00';
  }
</script>

<!-- JavaScript for Testimonials Carousel -->
<script>
  const testimonialsData = [
    {
      quote: "Wildlife Haven revolutionized my productivity, blending focus with conservation seamlessly.",
      author: "Sarah K., Student"
    },
    {
      quote: "I love the interactive focus timer—it keeps me on track and engaged!",
      author: "John D., Designer"
    },
    {
      quote: "Such a unique idea—combining real conservation with daily productivity is brilliant.",
      author: "Emily R., Entrepreneur"
    }
  ];

  let currentSlide = 0;
  const slides = [];
  const dots = [];
  let autoSlideInterval;

  document.addEventListener("DOMContentLoaded", () => {
    const slidesWrapper = document.querySelector(".testimonial-slides");
    const dotsWrapper = document.querySelector(".carousel-dots");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");

    testimonialsData.forEach((t, index) => {
      const slideEl = document.createElement("div");
      slideEl.className = "testimonial-slide" + (index === 0 ? " active" : "");
      slideEl.innerHTML = `
        <blockquote class="testimonial-quote">${t.quote}</blockquote>
        <p class="testimonial-author">- ${t.author}</p>
      `;
      slidesWrapper.appendChild(slideEl);
      slides.push(slideEl);

      const dotEl = document.createElement("span");
      dotEl.className = "carousel-dot" + (index === 0 ? " active" : "");
      dotEl.addEventListener("click", () => goToSlide(index));
      dotsWrapper.appendChild(dotEl);
      dots.push(dotEl);
    });

    prevBtn.addEventListener("click", prevSlide);
    nextBtn.addEventListener("click", nextSlide);

    autoSlideInterval = setInterval(nextSlide, 5000);
  });

  function goToSlide(index) {
    slides[currentSlide].classList.remove("active");
    dots[currentSlide].classList.remove("active");
    currentSlide = index;
    slides[currentSlide].classList.add("active");
    dots[currentSlide].classList.add("active");
  }

  function prevSlide() {
    let newIndex = currentSlide - 1;
    if (newIndex < 0) newIndex = slides.length - 1;
    goToSlide(newIndex);
  }

  function nextSlide() {
    let newIndex = currentSlide + 1;
    if (newIndex >= slides.length) newIndex = 0;
    goToSlide(newIndex);
  }
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
