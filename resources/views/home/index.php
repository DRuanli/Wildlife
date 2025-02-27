<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Inline Styles & Font Imports (move to your main CSS file as desired) -->
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
    background: url('<?= $baseUrl ?>/public/img/jonatan-pie-d7ZBAPEuXGc-unsplash.jpg') center/cover no-repeat;
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
  <section class="section" id="features">
    <h2 class="sub-headline">Innovative Focus Tools</h2>
    <p class="body-text">
      Experience a cutting-edge focus timer, dynamic creature gallery, and immersive testimonials—all designed to elevate your productivity and passion for conservation.
    </p>
  </section>

  <!-- ADVANCED FOCUS TIMER WITH RADIAL PROGRESS -->
  <section class="section" id="focus-timer">
    <h2 class="sub-headline" style="margin-bottom: 1rem;">Interactive Focus Timer</h2>
    
    <!-- Timer Container -->
    <div style="display: inline-block; position: relative; margin-bottom: 2rem;">
      <svg id="timerRing" width="200" height="200">
        <circle
          id="timerCircleBg"
          cx="100"
          cy="100"
          r="90"
          fill="none"
          stroke="#e5e5e5"
          stroke-width="15"
        ></circle>
        <circle
          id="timerCircle"
          cx="100"
          cy="100"
          r="90"
          fill="none"
          stroke="#CE6246"
          stroke-width="15"
          stroke-linecap="round"
          stroke-dasharray="565.48"
          stroke-dashoffset="565.48"
        ></circle>
      </svg>
      <div id="timerDisplay">00:00</div>
    </div>
    
    <!-- Controls & Duration Input -->
    <div style="margin-bottom: 1rem;">
      <label for="timerInput" class="small-text" style="margin-right: 0.5rem;">
        Set Focus Time (minutes):
      </label>
      <input id="timerInput" type="number" min="1" max="999" value="25" />
    </div>
    
    <!-- Action Buttons -->
    <div style="display: inline-flex; gap: 1rem;">
      <button class="btn btn-primary" onclick="startTimer()" style="width: 100px;">Start</button>
      <button class="btn btn-secondary" onclick="pauseTimer()" style="width: 100px;">Pause</button>
      <button class="btn btn-secondary" onclick="resetTimer()" style="width: 100px;">Reset</button>
    </div>
    
    <!-- Audio for Beep -->
    <audio id="beepAudio" src="<?= $baseUrl ?>/audio/beep.mp3" preload="auto"></audio>
  </section>

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
              <img src="<?= $baseUrl ?>/images/icon-secure.png" alt="Secure Icon" class="card-icon" />
              <h3 class="sub-headline card-title">Giant Panda (Ailuropoda melanoleuca)</h3>
              <p class="body-text card-desc">
                With robust security practices—SOC 2 Type II certification, HIPAA compliance options, and more—we ensure your focus sessions and data remain protected.
              </p>
            </div>
            <!-- Back Face -->
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Featured Post</h4>
              <p class="small-text">
                <em>Constitutional Classifiers: Defending Against Universal Jailbreaks</em>
              </p>
            </div>
          </div>
        </div>
        
        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/images/icon-trust.png" alt="Trust Icon" class="card-icon" />
              <h3 class="sub-headline card-title">Trustworthy</h3>
              <p class="body-text card-desc">
                We combine best-in-class LLM risk mitigation with rigorous testing to protect your brand and community from harm.
              </p>
            </div>
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Featured Post</h4>
              <p class="small-text">
                <em>Challenges in Red Teaming AI Systems</em><br />
                Discover how we continually test and refine our defenses against AI vulnerabilities.
              </p>
            </div>
          </div>
        </div>
        
        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/images/icon-learning.png" alt="Learning Icon" class="card-icon" />
              <h3 class="sub-headline card-title">Continuous Learning</h3>
              <p class="body-text card-desc">
                Our platform evolves alongside user feedback, ensuring advanced model fine-tuning and seamless improvements for your productivity.
              </p>
            </div>
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Featured Paper</h4>
              <p class="small-text">
                <em>Red Teaming Language Models to Reduce Harm</em><br />
                A deeper look into how we identify and address emerging risks in real time.
              </p>
            </div>
          </div>
        </div>
        
        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/images/icon-evolving.png" alt="Evolving Icon" class="card-icon" />
              <h3 class="sub-headline card-title">Evolving</h3>
              <p class="body-text card-desc">
                We refine our approach constantly—building a more inclusive, transparent AI experience with every iteration.
              </p>
            </div>
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Featured Paper</h4>
              <p class="small-text">
                <em>Evaluating and Mitigating Discrimination in Language Model Decisions</em><br />
                How we foster fairness and accountability in AI-driven environments.
              </p>
            </div>
          </div>
        </div>

        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/images/icon-evolving.png" alt="Evolving Icon" class="card-icon" />
              <h3 class="sub-headline card-title">Evolving</h3>
              <p class="body-text card-desc">
                We refine our approach constantly—building a more inclusive, transparent AI experience with every iteration.
              </p>
            </div>
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Featured Paper</h4>
              <p class="small-text">
                <em>Evaluating and Mitigating Discrimination in Language Model Decisions</em><br />
                How we foster fairness and accountability in AI-driven environments.
              </p>
            </div>
          </div>
        </div>

        <div class="advanced-card" x-data="{ flipped: false }" @click="flipped = !flipped">
          <div class="advanced-card-content" :style="{ transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }">
            <div class="advanced-card-front">
              <img src="<?= $baseUrl ?>/images/icon-evolving.png" alt="Evolving Icon" class="card-icon" />
              <h3 class="sub-headline card-title">Evolving</h3>
              <p class="body-text card-desc">
                We refine our approach constantly—building a more inclusive, transparent AI experience with every iteration.
              </p>
            </div>
            <div class="advanced-card-back">
              <h4 class="sub-headline" style="margin-bottom: 0.5rem;">Featured Paper</h4>
              <p class="small-text">
                <em>Evaluating and Mitigating Discrimination in Language Model Decisions</em><br />
                How we foster fairness and accountability in AI-driven environments.
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
