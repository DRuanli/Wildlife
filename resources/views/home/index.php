<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>
<?php //Path: resources/views/home/index.php ?>

    <!-- Enhanced Home Page with Immersive Animation Effects -->

    <!-- Preload Critical Resources -->
    <link rel="preload" href="<?= $baseUrl ?>/assets/fonts/playfair-display-v30-latin-500.woff2" as="font"
          type="font/woff2" crossorigin>
    <link rel="preload" href="<?= $baseUrl ?>/assets/fonts/inter-v12-latin-regular.woff2" as="font" type="font/woff2"
          crossorigin>
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/home/home.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/smooth-scroll.css">

    <!-- GSAP Animation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollToPlugin.min.js"></script>

    <!-- Lottie Animation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"></script>

    <!-- Custom Styles with Enhanced Design System -->


    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="loading-logo">
            <img src="<?= $baseUrl ?>/public/img/logo.png" alt="Wildlife Haven" width="120">
            <div class="loading-progress">
                <div class="loading-bar" id="loadingBar"></div>
            </div>
            </main>

            <!-- Custom Cursor -->
            <div class="custom-cursor" id="customCursor"></div>
            <div class="custom-cursor-follower" id="cursorFollower"></div>

            <!-- Main Content Container -->
            <main id="scrollContent">

                <main>
                    <!-- Hero Section with Video Background -->
                    <section class="hero" id="hero">
                        <div class="hero-video-container">
                            <video class="hero-video" id="heroVideo" autoplay muted loop playsinline>
                                <source src="<?= $baseUrl ?>/public/videos/vid.mp4" type="video/mp4">
                            </video>
                        </div>
                        <div class="hero-overlay" id="heroOverlay"></div>
                        <div class="hero-content" id="heroContent">
                            <h1 class="headline headline-lg">
                                <span class="reveal-text">Transform Focus</span>
                                <span class="reveal-text">Into Conservation</span>
                            </h1>
                            <p class="hero-subtitle" id="heroSubtitle">
                                Nurture mythical creatures inspired by endangered wildlife while developing better focus
                                habits. Every minute focused is a contribution to real-world conservation.
                            </p>
                            <div class="hero-buttons" id="heroButtons">
                                <a href="<?= $baseUrl ?>/auth/register" class="btn btn-primary magnetic-btn">
                                    <i class="fas fa-paw"></i> Get Started Free
                                    <span class="liquid"></span>
                                </a>
                                <a href="#how-it-works" class="btn btn-secondary magnetic-btn">
                                    <i class="fas fa-play"></i> See How It Works
                                    <span class="liquid"></span>
                                </a>
                            </div>
                        </div>
                        <div class="scroll-indicator" id="scrollIndicator" onclick="scrollToSection('#features')">
                            <span class="scroll-indicator-text">Explore</span>
                            <div class="scroll-arrow">
                                <div class="scroll-dot" id="scrollDot"></div>
                            </div>
                        </div>
                    </section>

                    <!-- Features Section -->
                    <section class="features-section" id="features">
                        <div class="parallax-bg">
                            <div class="parallax-element circle circle-1" data-speed="-0.2"></div>
                            <div class="parallax-element circle circle-2" data-speed="0.3"></div>
                            <div class="parallax-element circle circle-3" data-speed="-0.1"></div>
                        </div>
                        <div class="container">
                            <h2 class="headline headline-md text-center">
                                <span class="reveal-text">Powerful Features for Focus & Conservation</span>
                            </h2>
                            <p class="body-text body-md text-center" style="max-width: 700px; margin: 0 auto;">
                                Wildlife Haven combines productivity tools with conservation impact, creating a virtuous
                                cycle between personal growth and global change.
                            </p>

                            <div class="features-grid">
                                <!-- Feature 1 -->
                                <div class="feature-card" data-delay="0">
                                    <div class="feature-icon-container">
                                        <div class="feature-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="feature-icon-bg"></div>
                                    </div>
                                    <h3 class="feature-title">Advanced Focus Timer</h3>
                                    <p class="feature-description">
                                        Stay in the zone with our Pomodoro-style timer that rewards your focused time
                                        with creature growth.
                                    </p>
                                    <a href="#focus-timer" class="btn btn-primary magnetic-btn"
                                       style="margin-top: auto;">
                                        Try It Now
                                        <span class="liquid"></span>
                                    </a>
                                </div>

                                <!-- Feature 2 -->
                                <div class="feature-card" data-delay="0.2">
                                    <div class="feature-icon-container">
                                        <div class="feature-icon">
                                            <i class="fas fa-dragon"></i>
                                        </div>
                                        <div class="feature-icon-bg"></div>
                                    </div>
                                    <h3 class="feature-title">Mythical Creatures</h3>
                                    <p class="feature-description">
                                        Hatch and nurture beautiful mythical creatures inspired by endangered wildlife
                                        species.
                                    </p>
                                    <a href="#creatures" class="btn btn-primary magnetic-btn" style="margin-top: auto;">
                                        View Creatures
                                        <span class="liquid"></span>
                                    </a>
                                </div>

                                <!-- Feature 3 -->
                                <div class="feature-card" data-delay="0.4">
                                    <div class="feature-icon-container">
                                        <div class="feature-icon">
                                            <i class="fas fa-seedling"></i>
                                        </div>
                                        <div class="feature-icon-bg"></div>
                                    </div>
                                    <h3 class="feature-title">Real Conservation Impact</h3>
                                    <p class="feature-description">
                                        Your focus time contributes to actual conservation efforts like tree planting
                                        and habitat protection.
                                    </p>
                                    <a href="#conservation" class="btn btn-primary magnetic-btn"
                                       style="margin-top: auto;">
                                        Our Impact
                                        <span class="liquid"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Advanced Focus Timer -->
                    <section class="focus-timer-section" id="focus-timer">
                        <div class="particles-container" id="particles"></div>
                        <div class="container">
                            <h2 class="headline headline-md text-center">
                                <span class="reveal-text">Experience Our Interactive Focus Timer</span>
                            </h2>
                            <p class="body-text body-md text-center" style="max-width: 600px; margin: 0 auto 2rem;">
                                Transform distractions into focus with our beautiful timer. Every focused minute helps
                                your creatures grow.
                            </p>

                            <div class="focus-timer-wrapper">
                                <div class="timer-container" id="timerContainer">
                                    <svg class="timer-svg" width="300" height="300" viewBox="0 0 300 300">
                                        <circle class="timer-circle-bg" cx="150" cy="150" r="130"></circle>
                                        <circle class="timer-circle" cx="150" cy="150" r="130" stroke-dasharray="817"
                                                stroke-dashoffset="817"></circle>
                                    </svg>
                                    <div class="timer-display">
                                        <div class="timer-display-time" id="timerDisplay">25:00</div>
                                        <div class="timer-display-label">Focus Time</div>
                                    </div>
                                </div>

                                <div class="timer-controls" id="timerControls">
                                    <button class="timer-btn magnetic-btn" id="startBtn" onclick="startTimer()">
                                        <i class="fas fa-play"></i>
                                        <span class="liquid"></span>
                                    </button>
                                    <button class="timer-btn magnetic-btn" id="pauseBtn" onclick="togglePause()"
                                            disabled>
                                        <i class="fas fa-pause"></i>
                                        <span class="liquid"></span>
                                    </button>
                                    <button class="timer-btn magnetic-btn" id="resetBtn" onclick="resetTimer()">
                                        <i class="fas fa-redo-alt"></i>
                                        <span class="liquid"></span>
                                    </button>
                                </div>

                                <div class="timer-settings" id="timerSettings">
                                    <div class="timer-setting">
                                        <label for="timerInput" class="timer-setting-label">Minutes</label>
                                        <input id="timerInput" type="number" min="1" max="60" value="25"
                                               class="timer-input">
                                    </div>

                                    <div class="timer-setting">
                                        <label for="soundSelect" class="timer-setting-label">Alarm Sound</label>
                                        <select id="soundSelect" class="timer-select">
                                            <option value="bell">Bell</option>
                                            <option value="forest">Forest</option>
                                            <option value="ocean">Ocean</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Creatures Gallery -->
                    <section class="creatures-section" id="creatures">
                        <div class="creatures-pattern" id="creaturesPattern"></div>
                        <div class="container">
                            <h2 class="headline headline-md text-center">
                                <span class="reveal-text">Discover Mythical Wildlife</span>
                            </h2>
                            <p class="body-text body-md text-center" style="max-width: 700px; margin: 0 auto 2rem;">
                                Each mythical creature is inspired by an endangered species. Nurture them with your
                                focus and learn about their real-world counterparts.
                            </p>

                            <div class="creatures-grid">
                                <!-- Creature 1 -->
                                <div class="creature-card" data-status="endangered" data-delay="0">
                                    <div class="creature-card-inner">
                                        <div class="creature-front">
                                            <img src="<?= $baseUrl ?>/public/img/panda.jpg" alt="Celestial Guardian"
                                                 class="creature-image">
                                            <div class="creature-overlay">
                                                <h3 class="creature-name">Celestial Guardian</h3>
                                                <p class="creature-species">Inspired by: Giant Panda</p>
                                            </div>
                                        </div>
                                        <div class="creature-back">
                                            <h3 class="creature-back-title">Celestial Guardian</h3>
                                            <p class="creature-description">
                                                This mystical creature draws its essence from the Giant Panda,
                                                channeling celestial energy to protect bamboo forests. In the real
                                                world, Giant Pandas remain vulnerable with only 1,800 left in the wild.
                                            </p>
                                            <span class="creature-conservation-status">Endangered</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Creature 2 -->
                                <div class="creature-card" data-status="endangered" data-delay="0.1">
                                    <div class="creature-card-inner">
                                        <div class="creature-front">
                                            <img src="<?= $baseUrl ?>/public/img/snow_leopard.png" alt="Frost Shadow"
                                                 class="creature-image">
                                            <div class="creature-overlay">
                                                <h3 class="creature-name">Frost Shadow</h3>
                                                <p class="creature-species">Inspired by: Snow Leopard</p>
                                            </div>
                                        </div>
                                        <div class="creature-back">
                                            <h3 class="creature-back-title">Frost Shadow</h3>
                                            <p class="creature-description">
                                                The elusive Frost Shadow glides through mountain mists with ghostly
                                                grace. Like its inspiration, the endangered Snow Leopard, it faces
                                                threats from poaching and habitat loss with fewer than 6,000 remaining.
                                            </p>
                                            <span class="creature-conservation-status">Endangered</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Creature 3 -->
                                <div class="creature-card" data-status="endangered" data-delay="0.2">
                                    <div class="creature-card-inner">
                                        <div class="creature-front">
                                            <img src="<?= $baseUrl ?>/public/img/whale.png" alt="Oceanic Titan"
                                                 class="creature-image">
                                            <div class="creature-overlay">
                                                <h3 class="creature-name">Oceanic Titan</h3>
                                                <p class="creature-species">Inspired by: Blue Whale</p>
                                            </div>
                                        </div>
                                        <div class="creature-back">
                                            <h3 class="creature-back-title">Oceanic Titan</h3>
                                            <p class="creature-description">
                                                This majestic creature channels the spirit of the Blue Whale, the
                                                largest animal on Earth. Despite protection, these magnificent creatures
                                                remain endangered with only 10,000-25,000 remaining worldwide.
                                            </p>
                                            <span class="creature-conservation-status">Endangered</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Creature 4 -->
                                <div class="creature-card" data-status="endangered" data-delay="0.3">
                                    <div class="creature-card-inner">
                                        <div class="creature-front">
                                            <img src="<?= $baseUrl ?>/public/img/rhino.png" alt="Stone Sentinel"
                                                 class="creature-image">
                                            <div class="creature-overlay">
                                                <h3 class="creature-name">Stone Sentinel</h3>
                                                <p class="creature-species">Inspired by: Sumatran Rhinoceros</p>
                                            </div>
                                        </div>
                                        <div class="creature-back">
                                            <h3 class="creature-back-title">Stone Sentinel</h3>
                                            <p class="creature-description">
                                                With armor-like skin and powerful presence, the Stone Sentinel embodies
                                                the critically endangered Sumatran Rhinoceros. Fewer than 80 individuals
                                                remain in isolated pockets of Indonesian rainforests.
                                            </p>
                                            <span class="creature-conservation-status">Endangered</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Creature 5 -->
                                <div class="creature-card" data-status="endangered" data-delay="0.4">
                                    <div class="creature-card-inner">
                                        <div class="creature-front">
                                            <img src="<?= $baseUrl ?>/public/img/ele.png" alt="Thunder Walker"
                                                 class="creature-image">
                                            <div class="creature-overlay">
                                                <h3 class="creature-name">Thunder Walker</h3>
                                                <p class="creature-species">Inspired by: Asian Elephant</p>
                                            </div>
                                        </div>
                                        <div class="creature-back">
                                            <h3 class="creature-back-title">Thunder Walker</h3>
                                            <p class="creature-description">
                                                The mighty Thunder Walker commands the forces of nature with its wise
                                                presence. In reality, Asian Elephants face serious threats from habitat
                                                loss and poaching, with populations declining rapidly throughout their
                                                range.
                                            </p>
                                            <span class="creature-conservation-status">Endangered</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Creature 6 -->
                                <div class="creature-card" data-status="endangered" data-delay="0.5">
                                    <div class="creature-card-inner">
                                        <div class="creature-front">
                                            <img src="<?= $baseUrl ?>/public/img/IndochineseTiger.jpg"
                                                 alt="Flame Strider" class="creature-image">
                                            <div class="creature-overlay">
                                                <h3 class="creature-name">Flame Strider</h3>
                                                <p class="creature-species">Inspired by: Indochinese Tiger</p>
                                            </div>
                                        </div>
                                        <div class="creature-back">
                                            <h3 class="creature-back-title">Flame Strider</h3>
                                            <p class="creature-description">
                                                The Flame Strider moves like living fire through the forest, leaving
                                                trails of light in its wake. Its real-world counterpart, the Indochinese
                                                Tiger, is critically endangered with fewer than 350 individuals left in
                                                the wild.
                                            </p>
                                            <span class="creature-conservation-status">Endangered</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Testimonials Carousel -->
                    <section class="testimonials-section" id="testimonials">
                        <div class="parallax-bg">
                            <div class="parallax-element circle circle-1" data-speed="0.2" style="opacity: 0.05;"></div>
                            <div class="parallax-element circle circle-2" data-speed="-0.1"
                                 style="opacity: 0.05;"></div>
                        </div>
                        <div class="container">
                            <h2 class="headline headline-md text-center">
                                <span class="reveal-text">What Our Community Says</span>
                            </h2>
                            <p class="body-text body-md text-center" style="max-width: 700px; margin: 0 auto 2rem;">
                                Join thousands of users who have transformed their productivity while making a positive
                                impact on wildlife conservation.
                            </p>

                            <div class="testimonials-container">
                                <div class="testimonial-track" id="testimonialTrack">
                                    <div class="testimonial-card active" id="testimonial1">
                                        <div class="testimonial-quote">
                                            "Wildlife Haven transformed my work habits. The focus timer keeps me
                                            productive, and watching my creatures grow while knowing I'm helping real
                                            conservation efforts makes it meaningful. It's so much more than just
                                            another productivity app."
                                        </div>
                                        <div class="testimonial-author">
                                            <img src="<?= $baseUrl ?>/assets/images/testimonials/user1.jpg"
                                                 alt="Sarah K." class="testimonial-avatar">
                                            <div class="testimonial-info">
                                                <div class="testimonial-name">Sarah K.</div>
                                                <div class="testimonial-role">Graphic Designer</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="testimonial-card next" id="testimonial2">
                                        <div class="testimonial-quote">
                                            "As a student, I struggle with staying focused during long study sessions.
                                            Wildlife Haven makes it fun - each focused session helps my creatures grow
                                            and contributes to real-world conservation. It's the perfect blend of
                                            productivity and purpose."
                                        </div>
                                        <div class="testimonial-author">
                                            <img src="<?= $baseUrl ?>/assets/images/testimonials/user2.jpg"
                                                 alt="Michael T." class="testimonial-avatar">
                                            <div class="testimonial-info">
                                                <div class="testimonial-name">Michael T.</div>
                                                <div class="testimonial-role">University Student</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="testimonial-card" id="testimonial3">
                                        <div class="testimonial-quote">
                                            "I've tried dozens of productivity apps, but Wildlife Haven is the only one
                                            that keeps me coming back. The connection to conservation gives my daily
                                            work deeper meaning, and the creatures are absolutely beautiful. Highly
                                            recommended!"
                                        </div>
                                        <div class="testimonial-author">
                                            <img src="<?= $baseUrl ?>/assets/images/testimonials/user3.jpg"
                                                 alt="Elena R." class="testimonial-avatar">
                                            <div class="testimonial-info">
                                                <div class="testimonial-name">Elena R.</div>
                                                <div class="testimonial-role">Software Developer</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="testimonial-nav">
                                    <button class="testimonial-btn testimonial-btn-prev magnetic-btn" id="prevBtn">
                                        <i class="fas fa-arrow-left"></i>
                                        <span class="liquid"></span>
                                    </button>
                                    <button class="testimonial-btn testimonial-btn-next magnetic-btn" id="nextBtn">
                                        <i class="fas fa-arrow-right"></i>
                                        <span class="liquid"></span>
                                    </button>
                                </div>

                                <div class="testimonial-indicators">
                                    <span class="testimonial-dot active" data-index="0"></span>
                                    <span class="testimonial-dot" data-index="1"></span>
                                    <span class="testimonial-dot" data-index="2"></span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Conservation Impact -->
                    <section class="conservation-section" id="conservation">
                        <div class="conservation-bg" id="conservationBg"></div>
                        <div class="container">
                            <div class="conservation-content">
                                <h2 class="headline headline-md conservation-title">
                                    <span class="reveal-text">Our Conservation Impact</span>
                                </h2>
                                <p class="conservation-description" id="conservationDesc">
                                    Every minute you focus contributes to real-world conservation efforts. Here's what
                                    our community has accomplished so far:
                                </p>

                                <div class="conservation-stats">
                                    <div class="conservation-stat" data-delay="0">
                                        <div class="conservation-stat-number" id="treesPlanted">
                                            <span class="count" data-target="25000">0</span>
                                        </div>
                                        <div class="conservation-stat-label">Trees Planted</div>
                                    </div>

                                    <div class="conservation-stat" data-delay="0.2">
                                        <div class="conservation-stat-number" id="habitatProtected">
                                            <span class="count" data-target="5000">0</span> acres
                                        </div>
                                        <div class="conservation-stat-label">Habitat Protected</div>
                                    </div>

                                    <div class="conservation-stat" data-delay="0.4">
                                        <div class="conservation-stat-number" id="speciesSupported">
                                            <span class="count" data-target="35">0</span>
                                        </div>
                                        <div class="conservation-stat-label">Endangered Species Supported</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Morphing blobs -->
                        <div class="morphing-blob" id="blob1"
                             style="width: 500px; height: 500px; left: 80%; top: 60%;"></div>
                        <div class="morphing-blob" id="blob2"
                             style="width: 300px; height: 300px; left: 20%; top: 30%;"></div>
                    </section>

                    <!-- Call to Action -->
                    <section class="cta-section" id="cta">
                        <div class="container">
                            <div class="cta-container">
                                <h2 class="headline headline-md cta-title">
                                    <span class="reveal-text">Start Your Focus Journey Today</span>
                                </h2>
                                <p class="cta-description" id="ctaDesc">
                                    Join our community of focused individuals making a difference for wildlife
                                    conservation around the world.
                                </p>
                                <form class="cta-form" id="ctaForm" action="<?= $baseUrl ?>/auth/register" method="GET">
                                    <input type="email" class="cta-input" placeholder="Your email address" required>
                                    <button type="submit" class="btn btn-primary magnetic-btn">
                                        <i class="fas fa-arrow-right"></i> Get Started Free
                                        <span class="liquid"></span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Morphing blobs -->
                        <div class="morphing-blob" id="ctaBlob1"
                             style="width: 400px; height: 400px; left: 70%; top: 50%;"></div>
                        <div class="morphing-blob" id="ctaBlob2"
                             style="width: 250px; height: 250px; left: 30%; top: 70%;"></div>
                    </section>

                    <!-- Hidden audio elements for timer sounds -->
                    <audio id="bellAudio" src="<?= $baseUrl ?>/assets/sounds/bell.mp3" preload="auto"></audio>
                    <audio id="forestAudio" src="<?= $baseUrl ?>/assets/sounds/forest.mp3" preload="auto"></audio>
                    <audio id="oceanAudio" src="<?= $baseUrl ?>/assets/sounds/ocean.mp3" preload="auto"></audio>
                </main>

        </div>
    </div>

    <!-- External JavaScript for Home Page -->
    <script src="<?= $baseUrl ?>/public/js/home/home.js"></script>
    <script>
        function addFloatingCardsSection() {
            // Create the section
            const section = document.createElement('section');
            section.className = 'floating-cards-section';
            section.id = 'floatingCards';

            // Create circular background
            const circleBackground = document.createElement('div');
            circleBackground.className = 'circle-background';

            // Create container
            const container = document.createElement('div');
            container.className = 'container';

            // Create floating cards stage
            const floatingStage = document.createElement('div');
            floatingStage.className = 'floating-stage';

            // Create overlay for expanded view
            const fullPageOverlay = document.createElement('div');
            fullPageOverlay.className = 'full-page-overlay';
            fullPageOverlay.style.display = 'none';
            document.body.appendChild(fullPageOverlay);

            // Create expanded card container inside overlay
            const expandedCardContainer = document.createElement('div');
            expandedCardContainer.className = 'expanded-card-container';
            fullPageOverlay.appendChild(expandedCardContainer);

            // Create expanded card content section
            const expandedContent = document.createElement('div');
            expandedContent.className = 'expanded-content';

            // Create expanded card image section
            const expandedImage = document.createElement('div');
            expandedImage.className = 'expanded-image';

            // Add close button
            const closeButton = document.createElement('button');
            closeButton.className = 'close-expanded-card';
            closeButton.innerHTML = '×';
            closeButton.addEventListener('click', closeExpandedCard);

            // Add to expanded card container
            expandedCardContainer.appendChild(expandedContent);
            expandedCardContainer.appendChild(expandedImage);
            expandedCardContainer.appendChild(closeButton);

            // Create four floating cards
            const cardsData = [
                {
                    title: 'Focus Timer',
                    image: '<?= $baseUrl ?>/public/img/panda.jpg',
                    color: 'var(--primary-color)',
                    content: 'The Focus Timer helps you stay on task with timed work sessions inspired by the peaceful nature of pandas. Take regular breaks to recharge your mind. Our approach combines productivity techniques with mindfulness practices to help you achieve deep focus while maintaining balance and preventing burnout.<br><br>Features include customizable session lengths, ambient nature sounds, gentle notifications, and progress tracking to help you build consistent work habits.'
                },
                {
                    title: 'Mythical Creatures',
                    image: '<?= $baseUrl ?>/public/img/snow_leopard.png',
                    color: 'var(--accent-1)',
                    content: 'Explore the world of mythical creatures and their connection to wildlife conservation through engaging stories and interactive experiences. Discover how legends and folklore from around the world often reflect our relationship with the natural environment.<br><br>Our collection features detailed illustrations, origin stories, and conservation connections for each creature, highlighting how mythology can inspire modern conservation efforts.'
                },
                {
                    title: 'Wildlife Impact',
                    image: '<?= $baseUrl ?>/public/img/whale.png',
                    color: 'var(--accent-2)',
                    content: 'Learn about the impact of human activities on wildlife habitats and discover ways to contribute to conservation efforts worldwide. Our interactive maps and data visualizations help you understand critical ecosystems and the challenges they face.<br><br>From climate change to habitat loss, pollution to poaching, we provide clear explanations of complex issues and actionable steps that anyone can take to make a positive difference.'
                },
                {
                    title: 'Conservation',
                    image: '<?= $baseUrl ?>/public/img/rhino.png',
                    color: 'var(--primary-dark)',
                    content: 'Join our conservation initiatives to protect endangered species and preserve biodiversity for future generations. Our community-driven approach connects passionate individuals with organizations doing vital work on the ground.<br><br>Through education, fundraising, and direct action programs, we create pathways for meaningful participation in conservation efforts around the world, with transparent tracking of impact and outcomes.'
                }
            ];

            // Add each card
            cardsData.forEach((card, index) => {
                const cardElement = document.createElement('div');
                cardElement.className = 'floating-card';
                cardElement.style.backgroundImage = `url(${card.image})`;
                cardElement.style.backgroundColor = card.color;
                cardElement.setAttribute('data-index', index);
                cardElement.innerHTML = `<span class="card-title">${card.title}</span>`;

                // Add click event for card expansion
                cardElement.addEventListener('click', function (e) {
                    e.stopPropagation();
                    expandCard(card, cardElement);
                });

                floatingStage.appendChild(cardElement);
            });

            // Create pagination indicator
            const pagination = document.createElement('div');
            pagination.className = 'cards-pagination';

            // Create heading
            const heading = document.createElement('h2');
            heading.className = 'headline headline-lg text-center';

            // Assemble the section
            container.appendChild(floatingStage);

            section.appendChild(circleBackground);
            section.appendChild(container);

            // Add to page before the testimonials section
            const testimonialsSection = document.getElementById('testimonials');
            if (testimonialsSection) {
                testimonialsSection.parentNode.insertBefore(section, testimonialsSection);
            } else {
                document.getElementById('scrollContent').appendChild(section);
            }

            // Initialize floating cards animation
            initFloatingCards();

            // Function to expand card
            function expandCard(cardData, cardElement) {
                // Store original card position for animation
                const cardRect = cardElement.getBoundingClientRect();

                // Clone the card for expanding animation
                const cardClone = cardElement.cloneNode(true);
                cardClone.style.position = 'fixed';
                cardClone.style.top = `${cardRect.top}px`;
                cardClone.style.left = `${cardRect.left}px`;
                cardClone.style.width = `${cardRect.width}px`;
                cardClone.style.height = `${cardRect.height}px`;
                cardClone.style.zIndex = '10000';
                document.body.appendChild(cardClone);

                // Prepare expanded content
                expandedContent.innerHTML = `
        <h2>${cardData.title}</h2>
        <div class="content-text">${cardData.content}</div>
        <button class="learn-more-btn">Learn More</button>
      `;

                // Prepare expanded image
                expandedImage.style.backgroundImage = `url(${cardData.image})`;
                expandedImage.style.backgroundColor = cardData.color;

                // Show overlay with fade in
                fullPageOverlay.style.display = 'block';
                fullPageOverlay.style.opacity = '0';

                gsap.to(fullPageOverlay, {
                    opacity: 1,
                    duration: 0.5,
                    ease: "power2.out"
                });

                // Disable scroll
                document.body.style.overflow = 'hidden';

                // First animate card to fullscreen
                gsap.to(cardClone, {
                    top: '0',
                    left: '0',
                    width: '100vw',
                    height: '100vh',
                    borderRadius: '0',
                    duration: 0.8,
                    ease: "power3.inOut",
                    onComplete: function () {
                        // When full screen, animate the split into content and image
                        gsap.to(cardClone, {
                            opacity: 0,
                            duration: 0.3,
                            onComplete: function () {
                                document.body.removeChild(cardClone);
                            }
                        });

                        // Show expanded card container
                        expandedCardContainer.style.opacity = '0';
                        expandedCardContainer.style.display = 'flex';

                        // Animate expanded content parts
                        gsap.to(expandedCardContainer, {
                            opacity: 1,
                            duration: 0.5,
                            ease: "power2.out"
                        });

                        gsap.fromTo(expandedContent,
                            {x: -100, opacity: 0},
                            {x: 0, opacity: 1, duration: 0.8, ease: "power2.out", delay: 0.1}
                        );

                        gsap.fromTo(expandedImage,
                            {x: 100, opacity: 0, rotation: -5},
                            {x: 0, opacity: 1, rotation: 0, duration: 0.8, ease: "power2.out", delay: 0.2}
                        );
                    }
                });

                // Add event listener to close on escape key
                document.addEventListener('keydown', handleEscKey);
            }

            // Function to handle escape key
            function handleEscKey(e) {
                if (e.key === 'Escape') {
                    closeExpandedCard();
                }
            }

            // Function to close expanded card
            function closeExpandedCard() {
                // Don't close if already animating out
                if (fullPageOverlay.classList.contains('closing')) return;
                fullPageOverlay.classList.add('closing');

                // Animate out expanded content
                gsap.to(expandedContent, {
                    x: -100,
                    opacity: 0,
                    duration: 0.5,
                    ease: "power2.in"
                });

                gsap.to(expandedImage, {
                    x: 100,
                    opacity: 0,
                    rotation: -5,
                    duration: 0.5,
                    ease: "power2.in"
                });

                // Fade out overlay
                gsap.to(fullPageOverlay, {
                    opacity: 0,
                    duration: 0.5,
                    delay: 0.2,
                    ease: "power2.in",
                    onComplete: function () {
                        // Hide overlay
                        fullPageOverlay.style.display = 'none';
                        fullPageOverlay.classList.remove('closing');

                        // Re-enable scroll
                        document.body.style.overflow = '';

                        // Remove event listener
                        document.removeEventListener('keydown', handleEscKey);
                    }
                });
            }
        }

        function initFloatingCards() {
            const cards = document.querySelectorAll('.floating-card');
            const pagination = document.querySelector('.current-page');
            let currentCard = 0;
            let autoRotateInterval;

            // Position cards in 3D space
            function positionCards() {
                cards.forEach((card, index) => {
                    const offset = (index - currentCard) % cards.length;
                    const zIndex = offset === 0 ? 10 : 5 - Math.abs(offset);

                    gsap.to(card, {
                        x: offset * 50,
                        y: offset * 10,
                        z: offset * -100,
                        rotationY: offset * -10,
                        rotationX: offset * 5,
                        scale: 1 - Math.abs(offset) * 0.15,
                        opacity: 1 - Math.abs(offset) * 0.2,
                        zIndex: zIndex,
                        duration: 1,
                        ease: "power3.out",
                        force3D: true
                    });
                });

                // Update pagination
                if (pagination) pagination.textContent = currentCard + 1;
            }

            // Initial positioning
            positionCards();

            // Navigate to next/previous card
            function nextCard() {
                currentCard = (currentCard + 1) % cards.length;
                positionCards();
            }

            function prevCard() {
                currentCard = (currentCard - 1 + cards.length) % cards.length;
                positionCards();
            }

            // Click on card to navigate
            cards.forEach(card => {
                card.addEventListener('click', function (e) {
                    e.stopPropagation(); // Prevent bubbling
                    const index = parseInt(this.getAttribute('data-index'));
                    if (index !== currentCard) {
                        currentCard = index;
                        positionCards();
                    }
                });
            });

            // Add mouse movement effect
            const floatingStage = document.querySelector('.floating-stage');
            if (floatingStage) {
                floatingStage.addEventListener('mousemove', (e) => {
                    const rect = floatingStage.getBoundingClientRect();
                    const centerX = rect.left + rect.width / 2;
                    const centerY = rect.top + rect.height / 2;

                    // Calculate mouse position relative to center
                    const xPos = (e.clientX - centerX) / (rect.width / 2);
                    const yPos = (e.clientY - centerY) / (rect.height / 2);

                    // Apply subtle movement to all cards
                    cards.forEach(card => {
                        gsap.to(card, {
                            x: parseFloat(getComputedStyle(card).transform.split(',')[4] || 0) + xPos * 20,
                            y: parseFloat(getComputedStyle(card).transform.split(',')[5] || 0) + yPos * -20,
                            duration: 0.5,
                            ease: "power1.out"
                        });
                    });
                });

                // Start auto rotation
                startAutoRotate();

                // Stop auto-rotation on hover
                floatingStage.addEventListener('mouseenter', () => {
                    stopAutoRotate();
                });

                // Resume auto-rotation on mouse leave
                floatingStage.addEventListener('mouseleave', () => {
                    startAutoRotate();
                    setTimeout(() => {
                        positionCards();
                    }, 300);
                });

                function startAutoRotate() {
                    stopAutoRotate(); // Clear any existing interval first
                    autoRotateInterval = setInterval(nextCard, 3000);
                }

                function stopAutoRotate() {
                    if (autoRotateInterval) {
                        clearInterval(autoRotateInterval);
                        autoRotateInterval = null;
                    }
                }

                // Add touch swipe functionality
                let startX, startY;
                floatingStage.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                    startY = e.touches[0].clientY;
                }, false);

                floatingStage.addEventListener('touchend', (e) => {
                    let diffX = startX - e.changedTouches[0].clientX;
                    let diffY = startY - e.changedTouches[0].clientY;

                    // Horizontal swipe detection
                    if (Math.abs(diffX) > Math.abs(diffY)) {
                        if (diffX > 50) {
                            nextCard();
                        } else if (diffX < -50) {
                            prevCard();
                        }
                    }
                }, false);
            }
        }
    </script>


<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>