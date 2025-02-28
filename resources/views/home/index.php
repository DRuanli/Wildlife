<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Enhanced Home Page with Immersive Animation Effects -->

<!-- Preload Critical Resources -->
<link rel="preload" href="<?= $baseUrl ?>/assets/fonts/playfair-display-v30-latin-500.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?= $baseUrl ?>/assets/fonts/inter-v12-latin-regular.woff2" as="font" type="font/woff2" crossorigin>

<!-- GSAP Animation Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollToPlugin.min.js"></script>

<!-- Lottie Animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"></script>

<!-- Custom Styles with Enhanced Design System -->
<style>
  /* Font Imports and Base Design System */
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap');

  :root {
    /* Main Colors */
    --primary-color: #4D724D;
    --primary-dark: #3A5A3A;
    --primary-light: #6B8E6B;
    --secondary-color: #D9C589;
    --secondary-dark: #C4AF6F;
    --secondary-light: #E8D9A8;
    --background-color: #F9F8F2;
    --text-dark: #111827;
    --text-medium: #374151;
    --text-light: #6B7280;
    
    /* Accent Colors */
    --accent-1: #CE6246; /* Coral */
    --accent-2: #2F6DAE; /* Ocean Blue */
    --accent-3: #8C6239; /* Earth Brown */
    --accent-4: #5D456B; /* Forest Purple */
    
    /* UI Colors */
    --success: #0D9488;
    --warning: #F59E0B;
    --error: #EF4444;
    --info: #3B82F6;
    
    /* Spacing System */
    --space-xs: 0.25rem;
    --space-sm: 0.5rem;
    --space-md: 1rem;
    --space-lg: 1.5rem;
    --space-xl: 2rem;
    --space-2xl: 3rem;
    --space-3xl: 4rem;
    
    /* Typography Scale */
    --text-xs: 0.75rem;
    --text-sm: 0.875rem;
    --text-base: 1rem;
    --text-lg: 1.125rem;
    --text-xl: 1.25rem;
    --text-2xl: 1.5rem;
    --text-3xl: 1.875rem;
    --text-4xl: 2.25rem;
    --text-5xl: 3rem;
    --text-6xl: 3.75rem;
  }

  /* Base Styles */
  body {
    font-family: 'Inter', sans-serif;
    background-color: var(--background-color);
    color: var(--text-medium);
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    overflow-x: hidden;
    cursor: default;
  }

  /* Custom Cursor */
  .custom-cursor {
    position: fixed;
    top: 0;
    left: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    pointer-events: none;
    z-index: 9999;
    mix-blend-mode: difference;
    transition: transform 0.1s ease;
    transform: translate(-50%, -50%) scale(1);
  }

  .custom-cursor-follower {
    position: fixed;
    top: 0;
    left: 0;
    width: 8px;
    height: 8px;
    background-color: white;
    border-radius: 50%;
    pointer-events: none;
    z-index: 10000;
    mix-blend-mode: difference;
    transition: transform 0.3s ease;
    transform: translate(-50%, -50%);
  }

  .cursor-hover {
    transform: translate(-50%, -50%) scale(2);
    background-color: var(--primary-color);
    mix-blend-mode: normal;
  }

  /* Main Content Container */
  #scrollContent {
    width: 100%;
    position: relative;
    overflow-x: hidden;
  }

  /* Typography */
  .headline {
    font-family: 'Playfair Display', serif;
    font-weight: 600;
    line-height: 1.1;
    letter-spacing: -0.02em;
    color: var(--text-dark);
    position: relative;
    overflow: hidden;
  }

  .headline .reveal-text {
    display: block;
    transform: translateY(100%);
    opacity: 0;
  }

  .headline-lg {
    font-size: clamp(2.5rem, 5vw, var(--text-6xl));
  }

  .headline-md {
    font-size: clamp(1.75rem, 4vw, var(--text-4xl));
  }

  .headline-sm {
    font-size: clamp(1.5rem, 3vw, var(--text-2xl));
  }

  .body-text {
    opacity: 0;
    transform: translateY(20px);
  }

  .body-lg {
    font-size: var(--text-xl);
    line-height: 1.5;
  }
  
  .body-md {
    font-size: var(--text-base);
    line-height: 1.6;
  }
  
  .body-sm {
    font-size: var(--text-sm);
    line-height: 1.5;
  }

  .caption {
    font-size: var(--text-xs);
    color: var(--text-light);
    letter-spacing: 0.02em;
  }

  /* Morphing Button Styles */
  .btn {
    font-size: var(--text-base);
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    position: relative;
    overflow: hidden;
    z-index: 1;
    cursor: none;
  }
  
  .btn-primary {
    background-color: var(--primary-color);
    color: white;
    box-shadow: 0 4px 6px rgba(77, 114, 77, 0.2);
  }
  
  .btn-primary:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 12px rgba(77, 114, 77, 0.25);
  }
  
  .btn-primary:active {
    transform: translateY(0);
  }
  
  .btn-secondary {
    background-color: white;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  }
  
  .btn-secondary:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  }

  /* Magnetic button effect */
  .btn.magnetic-btn {
    transform-style: preserve-3d;
    transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1);
  }

  /* Button liquid ripple effect */
  .btn .liquid {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transform: scale(0);
    z-index: -1;
    transition: transform 0.5s ease-out;
  }

  /* Layout with Perspective */
  .section {
    padding: var(--space-3xl) var(--space-lg);
    position: relative;
    overflow: hidden;
    perspective: 1000px;
  }
  
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 var(--space-lg);
    position: relative;
    z-index: 2;
  }
  
  .flex-center {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Parallax background elements */
  .parallax-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
  }

  .parallax-element {
    position: absolute;
    will-change: transform;
  }

  .circle {
    width: 30vh;
    height: 30vh;
    border-radius: 50%;
    opacity: 0.1;
  }

  .circle-1 {
    background-color: var(--primary-light);
    top: -10vh;
    left: -5vh;
  }

  .circle-2 {
    background-color: var(--accent-1);
    bottom: -15vh;
    right: -5vh;
  }

  .circle-3 {
    background-color: var(--accent-2);
    top: 40%;
    left: 60%;
    width: 20vh;
    height: 20vh;
  }

  /* Hero Section with 3D Transform */
  .hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    background-color: var(--primary-dark);
    z-index: 1;
  }
  
  .hero-video-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 0;
  }
  
  .hero-video {
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    object-fit: cover;
    opacity: 0.7;
    filter: blur(0px);
    transition: filter 0.5s ease;
  }
  
  .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(77,114,77,0.4) 100%);
    z-index: 1;
    opacity: 0;
  }
  
  .hero-content {
    position: relative;
    z-index: 2;
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
    padding: var(--space-lg);
    color: white;
    transform-style: preserve-3d;
  }
  
  .hero-subtitle {
    margin-bottom: var(--space-xl);
    font-size: var(--text-xl);
    font-weight: 300;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    opacity: 0;
    transform: translateY(30px);
  }
  
  .hero-buttons {
    display: flex;
    gap: var(--space-md);
    justify-content: center;
    flex-wrap: wrap;
    opacity: 0;
    transform: translateY(30px);
  }

  /* 3D Scroll Indicator */
  .scroll-indicator {
    position: absolute;
    bottom: var(--space-xl);
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    display: flex;
    flex-direction: column;
    align-items: center;
    color: white;
    opacity: 0;
    cursor: none;
    transition: opacity 0.3s ease;
  }
  
  .scroll-indicator:hover {
    opacity: 1;
  }
  
  .scroll-indicator-text {
    margin-bottom: var(--space-sm);
    font-size: var(--text-sm);
    text-transform: uppercase;
    letter-spacing: 0.1em;
  }
  
  .scroll-arrow {
    width: 30px;
    height: 50px;
    border: 2px solid white;
    border-radius: 15px;
    position: relative;
  }
  
  .scroll-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background-color: white;
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
  }

  /* Features Section with Interactive Cards */
  .features-section {
    background-color: white;
    padding: var(--space-3xl) 0;
    overflow: visible;
  }
  
  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-xl);
    margin-top: var(--space-2xl);
    position: relative;
    z-index: 1;
  }
  
  .feature-card {
    background-color: white;
    border-radius: 12px;
    padding: var(--space-xl);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    transform-style: preserve-3d;
    transform: translateY(50px);
    opacity: 0;
    cursor: none;
  }
  
  .feature-card:hover {
    transform: translateY(-10px) rotateX(5deg) rotateY(5deg);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }
  
  .feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: var(--primary-color);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.6s cubic-bezier(0.19, 1, 0.22, 1);
  }
  
  .feature-card:hover::before {
    transform: scaleX(1);
  }
  
  .feature-icon-container {
    position: relative;
    width: 80px;
    height: 80px;
    margin-bottom: var(--space-lg);
    transform-style: preserve-3d;
    transform: translateZ(20px);
  }
  
  .feature-icon {
    font-size: 2.5rem;
    color: var(--primary-color);
    background-color: rgba(77, 114, 77, 0.1);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    position: relative;
    z-index: 1;
  }
  
  .feature-icon-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(77, 114, 77, 0.2) 0%, rgba(77, 114, 77, 0) 70%);
    transform: scale(0);
    transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    z-index: 0;
  }
  
  .feature-card:hover .feature-icon {
    background-color: var(--primary-color);
    color: white;
    transform: scale(1.1) translateZ(30px);
  }
  
  .feature-card:hover .feature-icon-bg {
    transform: scale(2.5);
  }
  
  .feature-title {
    font-size: var(--text-xl);
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: var(--space-md);
    font-family: 'Playfair Display', serif;
    transform-style: preserve-3d;
    transform: translateZ(10px);
    position: relative;
  }
  
  .feature-description {
    color: var(--text-medium);
    margin-bottom: var(--space-md);
    transform-style: preserve-3d;
    transform: translateZ(5px);
    position: relative;
  }
  
  .feature-card .btn {
    margin-top: auto;
    transform-style: preserve-3d;
    transform: translateZ(15px);
  }

  /* Focus Timer with Morphing Animation */
  .focus-timer-section {
    background-color: var(--background-color);
    padding: var(--space-3xl) 0;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  
  .focus-timer-wrapper {
    max-width: 600px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
  }
  
  .timer-container {
    position: relative;
    margin: var(--space-2xl) 0;
    transform-style: preserve-3d;
    transform: translateZ(0px) scale(0.8);
    opacity: 0;
    transition: transform 1s cubic-bezier(0.19, 1, 0.22, 1), opacity 1s ease;
  }
  
  .timer-svg {
    transform: rotate(-90deg);
    filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.1));
  }
  
  .timer-circle-bg {
    fill: none;
    stroke: #e0e0e0;
    stroke-width: 10;
  }
  
  .timer-circle {
    fill: none;
    stroke: var(--primary-color);
    stroke-width: 10;
    stroke-linecap: round;
    transform-origin: center;
    transition: stroke-dashoffset 0.5s cubic-bezier(0.19, 1, 0.22, 1);
  }
  
  .timer-display {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    font-family: 'Inter', sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .timer-display-time {
    line-height: 1;
  }
  
  .timer-display-label {
    font-size: var(--text-xs);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-top: var(--space-xs);
    opacity: 0.7;
  }
  
  .timer-controls {
    display: flex;
    gap: var(--space-md);
    margin-bottom: var(--space-lg);
    transform: translateY(30px);
    opacity: 0;
  }
  
  .timer-btn {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: none;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
  }
  
  .timer-btn:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px) scale(1.1);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
  }
  
  .timer-btn:active {
    transform: translateY(0) scale(1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .timer-btn i {
    font-size: 1.5rem;
    position: relative;
    z-index: 1;
  }
  
  .timer-settings {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-lg);
    margin-top: var(--space-lg);
    transform: translateY(30px);
    opacity: 0;
  }
  
  .timer-setting {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100px;
  }
  
  .timer-setting-label {
    font-size: var(--text-xs);
    color: var(--text-light);
    margin-bottom: var(--space-xs);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
  
  .timer-input, .timer-select {
    width: 100%;
    padding: var(--space-sm) var(--space-md);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    text-align: center;
    font-family: 'Inter', sans-serif;
    color: var(--text-medium);
    background-color: white;
    transition: all 0.3s ease;
  }
  
  .timer-input:focus, .timer-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(77, 114, 77, 0.2);
    transform: translateY(-2px);
  }

  /* Floating particles for timer section */
  .particles-container {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 1;
    overflow: hidden;
  }

  .particle {
    position: absolute;
    border-radius: 50%;
    background-color: var(--primary-color);
    opacity: 0.1;
    pointer-events: none;
  }

  /* Creatures Gallery with Interactive Cards */
  .creatures-section {
    background-color: white;
    padding: var(--space-3xl) 0;
    position: relative;
    overflow: hidden;
  }
  
  .creatures-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--space-xl);
    margin-top: var(--space-2xl);
  }
  
  .creature-card {
    position: relative;
    height: 400px;
    perspective: 1000px;
    cursor: none;
    opacity: 0;
    transform: translateY(50px);
  }
  
  .creature-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.8s cubic-bezier(0.19, 1, 0.22, 1);
    transform-style: preserve-3d;
  }
  
  .creature-card:hover .creature-card-inner {
    transform: rotateY(180deg);
  }
  
  .creature-front, .creature-back {
    position: absolute;
    width: 100%;
    height: 100%;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }
  
  .creature-front {
    background-color: #f0f0f0;
  }
  
  .creature-back {
    background-color: white;
    transform: rotateY(180deg);
    padding: var(--space-lg);
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  
  .creature-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.19, 1, 0.22, 1);
  }
  
  .creature-card:hover .creature-image {
    transform: scale(1.05);
  }
  
  .creature-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
    padding: var(--space-lg);
    color: white;
    transition: opacity 0.3s ease;
  }
  
  .creature-name {
    font-family: 'Playfair Display', serif;
    font-size: var(--text-xl);
    margin-bottom: var(--space-xs);
  }
  
  .creature-species {
    font-style: italic;
    font-size: var(--text-sm);
    opacity: 0.9;
  }
  
  .creature-back-title {
    font-family: 'Playfair Display', serif;
    color: var(--text-dark);
    font-size: var(--text-xl);
    margin-bottom: var(--space-md);
  }
  
  .creature-description {
    color: var(--text-medium);
    margin-bottom: var(--space-lg);
  }
  
  .creature-conservation-status {
    display: inline-block;
    padding: var(--space-xs) var(--space-sm);
    background-color: var(--error);
    color: white;
    border-radius: 4px;
    font-size: var(--text-xs);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
    margin-top: auto;
  }
  
  .creature-card[data-status="vulnerable"] .creature-conservation-status {
    background-color: var(--warning);
  }
  
  .creature-card[data-status="endangered"] .creature-conservation-status {
    background-color: var(--error);
  }
  
  .creature-card[data-status="near-threatened"] .creature-conservation-status {
    background-color: var(--info);
  }

  /* Interactive creature pattern */
  .creatures-pattern {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    opacity: 0.03;
    pointer-events: none;
  }

  /* Testimonials with Floating Cards */
  .testimonials-section {
    background-color: var(--background-color);
    padding: var(--space-3xl) 0;
    position: relative;
    overflow: hidden;
  }
  
  .testimonials-container {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    perspective: 1000px;
  }
  
  .testimonial-track {
    position: relative;
    width: 100%;
    height: 350px;
    transform-style: preserve-3d;
    transition: transform 1s cubic-bezier(0.19, 1, 0.22, 1);
  }
  
  .testimonial-card {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: white;
    border-radius: 15px;
    padding: var(--space-2xl);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    z-index: 1;
    transform-style: preserve-3d;
    backface-visibility: hidden;
    transition: all 1s cubic-bezier(0.19, 1, 0.22, 1);
    opacity: 0;
  }
  
  .testimonial-card.active {
    opacity: 1;
    z-index: 2;
    transform: translateZ(0) rotateY(0deg);
  }
  
  .testimonial-card.prev {
    opacity: 0.7;
    transform: translateX(-100%) rotateY(10deg) scale(0.9);
    z-index: 1;
  }
  
  .testimonial-card.next {
    opacity: 0.7;
    transform: translateX(100%) rotateY(-10deg) scale(0.9);
    z-index: 1;
  }
  
  .testimonial-quote {
    font-size: var(--text-xl);
    line-height: 1.6;
    color: var(--text-dark);
    margin-bottom: var(--space-xl);
    position: relative;
    font-style: italic;
    transform-style: preserve-3d;
    transform: translateZ(20px);
  }
  
  .testimonial-quote::before,
  .testimonial-quote::after {
    content: """;
    font-family: 'Playfair Display', serif;
    font-size: 4rem;
    line-height: 0;
    position: absolute;
    color: var(--primary-light);
    opacity: 0.3;
  }
  
  .testimonial-quote::before {
    top: -0.5rem;
    left: -0.5rem;
    transform: translateZ(30px);
  }
  
  .testimonial-quote::after {
    content: """;
    bottom: -2rem;
    right: -0.5rem;
    transform: translateZ(30px);
  }
  
  .testimonial-author {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: var(--space-xl);
    transform-style: preserve-3d;
    transform: translateZ(10px);
  }
  
  .testimonial-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary-color);
    margin-right: var(--space-md);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }
  
  .testimonial-info {
    text-align: left;
  }
  
  .testimonial-name {
    font-weight: 600;
    color: var(--text-dark);
    font-size: var(--text-lg);
  }
  
  .testimonial-role {
    color: var(--text-light);
    font-size: var(--text-sm);
  }
  
  .testimonial-nav {
    position: absolute;
    top: 50%;
    width: 100%;
    transform: translateY(-50%);
    z-index: 10;
    display: flex;
    justify-content: space-between;
    pointer-events: none;
  }
  
  .testimonial-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: white;
    border: none;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    cursor: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--text-lg);
    color: var(--primary-color);
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    pointer-events: auto;
    position: relative;
    overflow: hidden;
  }
  
  .testimonial-btn:hover {
    background-color: var(--primary-color);
    color: white;
    transform: scale(1.1);
  }
  
  .testimonial-btn-prev {
    left: -25px;
  }
  
  .testimonial-btn-next {
    right: -25px;
  }
  
  .testimonial-indicators {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: var(--space-lg);
  }
  
  .testimonial-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: var(--text-light);
    opacity: 0.3;
    cursor: none;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    position: relative;
  }
  
  .testimonial-dot.active {
    opacity: 1;
    background-color: var(--primary-color);
    transform: scale(1.3);
  }

  /* Conservation Impact with Parallax Effect */
  .conservation-section {
    background-color: var(--primary-color);
    color: white;
    padding: var(--space-3xl) 0;
    position: relative;
    overflow: hidden;
  }
  
  .conservation-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('<?= $baseUrl ?>/assets/images/forest-pattern.svg');
    opacity: 0.1;
    z-index: 0;
  }
  
  .conservation-content {
    position: relative;
    z-index: 1;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
  }
  
  .conservation-title {
    color: white;
    margin-bottom: var(--space-xl);
  }
  
  .conservation-description {
    font-size: var(--text-lg);
    margin-bottom: var(--space-2xl);
    opacity: 0;
    transform: translateY(30px);
  }
  
  .conservation-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-xl);
    margin-top: var(--space-2xl);
  }
  
  .conservation-stat {
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: var(--space-lg);
    transition: transform 0.5s cubic-bezier(0.19, 1, 0.22, 1), background-color 0.3s ease;
    transform-style: preserve-3d;
    transform: translateY(50px);
    opacity: 0;
    position: relative;
    overflow: hidden;
  }
  
  .conservation-stat:hover {
    transform: translateY(-10px) translateZ(30px);
    background-color: rgba(255, 255, 255, 0.2);
  }
  
  .conservation-stat-number {
    font-size: var(--text-4xl);
    font-weight: 700;
    font-family: 'Playfair Display', serif;
    margin-bottom: var(--space-xs);
    background: linear-gradient(90deg, white, var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position: relative;
    z-index: 1;
  }
  
  .conservation-stat-label {
    font-size: var(--text-sm);
    opacity: 0.8;
    line-height: 1.4;
    position: relative;
    z-index: 1;
  }
  
  /* Call to Action with Morphing Background */
  .cta-section {
    background-color: white;
    padding: var(--space-3xl) 0;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  
  .cta-container {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
  }
  
  .cta-title {
    margin-bottom: var(--space-lg);
    opacity: 0;
    transform: translateY(30px);
  }
  
  .cta-description {
    margin-bottom: var(--space-xl);
    font-size: var(--text-lg);
    opacity: 0;
    transform: translateY(30px);
  }
  
  .cta-form {
    max-width: 500px;
    margin: 0 auto;
    display: flex;
    gap: var(--space-sm);
    opacity: 0;
    transform: translateY(30px);
  }
  
  .cta-input {
    flex: 1;
    padding: var(--space-md) var(--space-lg);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    font-family: 'Inter', sans-serif;
    font-size: var(--text-base);
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
  }
  
  .cta-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(77, 114, 77, 0.2);
    transform: translateY(-2px);
  }

  /* Background morphing blob */
  .morphing-blob {
    position: absolute;
    z-index: 0;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    background: linear-gradient(to right, var(--primary-light), var(--accent-1));
    opacity: 0.05;
    filter: blur(30px);
  }

  /* Reveal Animation for Text */
  .word-reveal {
    display: inline-block;
    overflow: hidden;
  }

  .word-reveal span {
    display: inline-block;
    transform: translateY(100%);
    opacity: 0;
  }

  /* Loading Screen */
  .loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: var(--background-color);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity 0.5s ease, visibility 0.5s ease;
  }

  .loading-logo {
    width: 120px;
    height: 120px;
    position: relative;
    transform-style: preserve-3d;
  }

  .loading-progress {
    position: absolute;
    bottom: -40px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 2px;
    overflow: hidden;
  }

  .loading-bar {
    height: 100%;
    width: 0%;
    background-color: var(--primary-color);
    transition: width 0.3s ease-out;
  }

  /* Media Queries for Responsive Design */
  @media (max-width: 1024px) {
    .headline-lg { font-size: var(--text-5xl); }
    .headline-md { font-size: var(--text-3xl); }
    .hero-content { max-width: 600px; }
    .custom-cursor, .custom-cursor-follower { display: none; }
    [cursor="none"] { cursor: pointer; }
  }
  
  @media (max-width: 768px) {
    .headline-lg { font-size: var(--text-4xl); }
    .headline-md { font-size: var(--text-2xl); }
    .hero-content { max-width: 100%; }
    .hero-buttons { flex-direction: column; width: 100%; }
    .btn { width: 100%; }
    .features-grid { grid-template-columns: 1fr; }
    .conservation-stats { grid-template-columns: 1fr; }
    .testimonial-btn { display: none; }
    .cta-form { flex-direction: column; }
    .cta-input, .btn { width: 100%; }
  }
  
  @media (max-width: 480px) {
    .headline-lg { font-size: var(--text-3xl); }
    .headline-md { font-size: var(--text-xl); }
    .section { padding: var(--space-2xl) var(--space-md); }
    .hero-subtitle { font-size: var(--text-base); }
    .testimonial-quote { font-size: var(--text-lg); }
    .timer-settings { flex-direction: column; }
  }
</style>

<!-- Loading Screen -->
<div class="loading-screen" id="loadingScreen">
  <div class="loading-logo">
    <img src="<?= $baseUrl ?>/assets/images/logo.svg" alt="Wildlife Haven" width="120">
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
            Nurture mythical creatures inspired by endangered wildlife while developing better focus habits. Every minute focused is a contribution to real-world conservation.
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
            Wildlife Haven combines productivity tools with conservation impact, creating a virtuous cycle between personal growth and global change.
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
                Stay in the zone with our Pomodoro-style timer that rewards your focused time with creature growth.
              </p>
              <a href="#focus-timer" class="btn btn-primary magnetic-btn" style="margin-top: auto;">
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
                Hatch and nurture beautiful mythical creatures inspired by endangered wildlife species.
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
                Your focus time contributes to actual conservation efforts like tree planting and habitat protection.
              </p>
              <a href="#conservation" class="btn btn-primary magnetic-btn" style="margin-top: auto;">
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
            Transform distractions into focus with our beautiful timer. Every focused minute helps your creatures grow.
          </p>
          
          <div class="focus-timer-wrapper">
            <div class="timer-container" id="timerContainer">
              <svg class="timer-svg" width="300" height="300" viewBox="0 0 300 300">
                <circle class="timer-circle-bg" cx="150" cy="150" r="130"></circle>
                <circle class="timer-circle" cx="150" cy="150" r="130" stroke-dasharray="817" stroke-dashoffset="817"></circle>
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
              <button class="timer-btn magnetic-btn" id="pauseBtn" onclick="togglePause()" disabled>
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
                <input id="timerInput" type="number" min="1" max="60" value="25" class="timer-input">
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
            Each mythical creature is inspired by an endangered species. Nurture them with your focus and learn about their real-world counterparts.
          </p>
          
          <div class="creatures-grid">
            <!-- Creature 1 -->
            <div class="creature-card" data-status="endangered" data-delay="0">
              <div class="creature-card-inner">
                <div class="creature-front">
                  <img src="<?= $baseUrl ?>/public/img/panda.jpg" alt="Celestial Guardian" class="creature-image">
                  <div class="creature-overlay">
                    <h3 class="creature-name">Celestial Guardian</h3>
                    <p class="creature-species">Inspired by: Giant Panda</p>
                  </div>
                </div>
                <div class="creature-back">
                  <h3 class="creature-back-title">Celestial Guardian</h3>
                  <p class="creature-description">
                    This mystical creature draws its essence from the Giant Panda, channeling celestial energy to protect bamboo forests. In the real world, Giant Pandas remain vulnerable with only 1,800 left in the wild.
                  </p>
                  <span class="creature-conservation-status">Endangered</span>
                </div>
              </div>
            </div>
            
            <!-- Creature 2 -->
            <div class="creature-card" data-status="endangered" data-delay="0.1">
              <div class="creature-card-inner">
                <div class="creature-front">
                  <img src="<?= $baseUrl ?>/public/img/snow_leopard.png" alt="Frost Shadow" class="creature-image">
                  <div class="creature-overlay">
                    <h3 class="creature-name">Frost Shadow</h3>
                    <p class="creature-species">Inspired by: Snow Leopard</p>
                  </div>
                </div>
                <div class="creature-back">
                  <h3 class="creature-back-title">Frost Shadow</h3>
                  <p class="creature-description">
                    The elusive Frost Shadow glides through mountain mists with ghostly grace. Like its inspiration, the endangered Snow Leopard, it faces threats from poaching and habitat loss with fewer than 6,000 remaining.
                  </p>
                  <span class="creature-conservation-status">Endangered</span>
                </div>
              </div>
            </div>
            
            <!-- Creature 3 -->
            <div class="creature-card" data-status="endangered" data-delay="0.2">
              <div class="creature-card-inner">
                <div class="creature-front">
                  <img src="<?= $baseUrl ?>/public/img/whale.png" alt="Oceanic Titan" class="creature-image">
                  <div class="creature-overlay">
                    <h3 class="creature-name">Oceanic Titan</h3>
                    <p class="creature-species">Inspired by: Blue Whale</p>
                  </div>
                </div>
                <div class="creature-back">
                  <h3 class="creature-back-title">Oceanic Titan</h3>
                  <p class="creature-description">
                    This majestic creature channels the spirit of the Blue Whale, the largest animal on Earth. Despite protection, these magnificent creatures remain endangered with only 10,000-25,000 remaining worldwide.
                  </p>
                  <span class="creature-conservation-status">Endangered</span>
                </div>
              </div>
            </div>
            
            <!-- Creature 4 -->
            <div class="creature-card" data-status="endangered" data-delay="0.3">
              <div class="creature-card-inner">
                <div class="creature-front">
                  <img src="<?= $baseUrl ?>/public/img/rhino.png" alt="Stone Sentinel" class="creature-image">
                  <div class="creature-overlay">
                    <h3 class="creature-name">Stone Sentinel</h3>
                    <p class="creature-species">Inspired by: Sumatran Rhinoceros</p>
                  </div>
                </div>
                <div class="creature-back">
                  <h3 class="creature-back-title">Stone Sentinel</h3>
                  <p class="creature-description">
                    With armor-like skin and powerful presence, the Stone Sentinel embodies the critically endangered Sumatran Rhinoceros. Fewer than 80 individuals remain in isolated pockets of Indonesian rainforests.
                  </p>
                  <span class="creature-conservation-status">Endangered</span>
                </div>
              </div>
            </div>

            <!-- Creature 5 -->
            <div class="creature-card" data-status="endangered" data-delay="0.4">
              <div class="creature-card-inner">
                <div class="creature-front">
                  <img src="<?= $baseUrl ?>/public/img/ele.png" alt="Thunder Walker" class="creature-image">
                  <div class="creature-overlay">
                    <h3 class="creature-name">Thunder Walker</h3>
                    <p class="creature-species">Inspired by: Asian Elephant</p>
                  </div>
                </div>
                <div class="creature-back">
                  <h3 class="creature-back-title">Thunder Walker</h3>
                  <p class="creature-description">
                    The mighty Thunder Walker commands the forces of nature with its wise presence. In reality, Asian Elephants face serious threats from habitat loss and poaching, with populations declining rapidly throughout their range.
                  </p>
                  <span class="creature-conservation-status">Endangered</span>
                </div>
              </div>
            </div>

            <!-- Creature 6 -->
            <div class="creature-card" data-status="endangered" data-delay="0.5">
              <div class="creature-card-inner">
                <div class="creature-front">
                  <img src="<?= $baseUrl ?>/public/img/IndochineseTiger.jpg" alt="Flame Strider" class="creature-image">
                  <div class="creature-overlay">
                    <h3 class="creature-name">Flame Strider</h3>
                    <p class="creature-species">Inspired by: Indochinese Tiger</p>
                  </div>
                </div>
                <div class="creature-back">
                  <h3 class="creature-back-title">Flame Strider</h3>
                  <p class="creature-description">
                    The Flame Strider moves like living fire through the forest, leaving trails of light in its wake. Its real-world counterpart, the Indochinese Tiger, is critically endangered with fewer than 350 individuals left in the wild.
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
          <div class="parallax-element circle circle-2" data-speed="-0.1" style="opacity: 0.05;"></div>
        </div>
        <div class="container">
          <h2 class="headline headline-md text-center">
            <span class="reveal-text">What Our Community Says</span>
          </h2>
          <p class="body-text body-md text-center" style="max-width: 700px; margin: 0 auto 2rem;">
            Join thousands of users who have transformed their productivity while making a positive impact on wildlife conservation.
          </p>
          
          <div class="testimonials-container">
            <div class="testimonial-track" id="testimonialTrack">
              <div class="testimonial-card active" id="testimonial1">
                <div class="testimonial-quote">
                  "Wildlife Haven transformed my work habits. The focus timer keeps me productive, and watching my creatures grow while knowing I'm helping real conservation efforts makes it meaningful. It's so much more than just another productivity app."
                </div>
                <div class="testimonial-author">
                  <img src="<?= $baseUrl ?>/assets/images/testimonials/user1.jpg" alt="Sarah K." class="testimonial-avatar">
                  <div class="testimonial-info">
                    <div class="testimonial-name">Sarah K.</div>
                    <div class="testimonial-role">Graphic Designer</div>
                  </div>
                </div>
              </div>
              
              <div class="testimonial-card next" id="testimonial2">
                <div class="testimonial-quote">
                  "As a student, I struggle with staying focused during long study sessions. Wildlife Haven makes it fun - each focused session helps my creatures grow and contributes to real-world conservation. It's the perfect blend of productivity and purpose."
                </div>
                <div class="testimonial-author">
                  <img src="<?= $baseUrl ?>/assets/images/testimonials/user2.jpg" alt="Michael T." class="testimonial-avatar">
                  <div class="testimonial-info">
                    <div class="testimonial-name">Michael T.</div>
                    <div class="testimonial-role">University Student</div>
                  </div>
                </div>
              </div>
              
              <div class="testimonial-card" id="testimonial3">
                <div class="testimonial-quote">
                  "I've tried dozens of productivity apps, but Wildlife Haven is the only one that keeps me coming back. The connection to conservation gives my daily work deeper meaning, and the creatures are absolutely beautiful. Highly recommended!"
                </div>
                <div class="testimonial-author">
                  <img src="<?= $baseUrl ?>/assets/images/testimonials/user3.jpg" alt="Elena R." class="testimonial-avatar">
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
              Every minute you focus contributes to real-world conservation efforts. Here's what our community has accomplished so far:
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
        <div class="morphing-blob" id="blob1" style="width: 500px; height: 500px; left: 80%; top: 60%;"></div>
        <div class="morphing-blob" id="blob2" style="width: 300px; height: 300px; left: 20%; top: 30%;"></div>
      </section>

      <!-- Call to Action -->
      <section class="cta-section" id="cta">
        <div class="container">
          <div class="cta-container">
            <h2 class="headline headline-md cta-title">
              <span class="reveal-text">Start Your Focus Journey Today</span>
            </h2>
            <p class="cta-description" id="ctaDesc">
              Join our community of focused individuals making a difference for wildlife conservation around the world.
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
        <div class="morphing-blob" id="ctaBlob1" style="width: 400px; height: 400px; left: 70%; top: 50%;"></div>
        <div class="morphing-blob" id="ctaBlob2" style="width: 250px; height: 250px; left: 30%; top: 70%;"></div>
      </section>

      <!-- Hidden audio elements for timer sounds -->
      <audio id="bellAudio" src="<?= $baseUrl ?>/assets/sounds/bell.mp3" preload="auto"></audio>
      <audio id="forestAudio" src="<?= $baseUrl ?>/assets/sounds/forest.mp3" preload="auto"></audio>
      <audio id="oceanAudio" src="<?= $baseUrl ?>/assets/sounds/ocean.mp3" preload="auto"></audio>
    </main>

  </div>
</div>

<!-- Advanced Animation & Interaction JavaScript -->
<script>
  // Initialize GSAP and plugins
  gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);
  
  // Global variables
  let isLoaded = false;
  let currentTestimonial = 0;
  const testimonials = [
    {
      id: "testimonial1",
      name: "Sarah K.",
      role: "Graphic Designer",
      avatar: "<?= $baseUrl ?>/assets/images/testimonials/user1.jpg",
      quote: "Wildlife Haven transformed my work habits. The focus timer keeps me productive, and watching my creatures grow while knowing I'm helping real conservation efforts makes it meaningful. It's so much more than just another productivity app."
    },
    {
      id: "testimonial2",
      name: "Michael T.",
      role: "University Student",
      avatar: "<?= $baseUrl ?>/assets/images/testimonials/user2.jpg",
      quote: "As a student, I struggle with staying focused during long study sessions. Wildlife Haven makes it fun - each focused session helps my creatures grow and contributes to real-world conservation. It's the perfect blend of productivity and purpose."
    },
    {
      id: "testimonial3",
      name: "Elena R.",
      role: "Software Developer",
      avatar: "<?= $baseUrl ?>/assets/images/testimonials/user3.jpg",
      quote: "I've tried dozens of productivity apps, but Wildlife Haven is the only one that keeps me coming back. The connection to conservation gives my daily work deeper meaning, and the creatures are absolutely beautiful. Highly recommended!"
    }
  ];
  
  // DOM elements
  const loadingScreen = document.getElementById('loadingScreen');
  const loadingBar = document.getElementById('loadingBar');
  const smoothScroll = document.getElementById('smoothScroll');
  const scrollContent = document.getElementById('scrollContent');
  const customCursor = document.getElementById('customCursor');
  const cursorFollower = document.getElementById('cursorFollower');
  
  // Loading animation
  function simulateLoading() {
    let progress = 0;
    const interval = setInterval(() => {
      progress += Math.random() * 10;
      if (progress > 100) progress = 100;
      
      loadingBar.style.width = `${progress}%`;
      
      if (progress === 100) {
        clearInterval(interval);
        setTimeout(() => {
          loadingScreen.style.opacity = '0';
          setTimeout(() => {
            loadingScreen.style.display = 'none';
            isLoaded = true;
            initPage();
          }, 500);
        }, 500);
      }
    }, 200);
  }
  
  // Initialize page animations
  function initPage() {
    initSmoothScroll();
    initCursor();
    initHeroSection();
    initRevealAnimations();
    initParallaxElements();
    initFeatureCards();
    initTimerSection();
    initCreatures();
    initTestimonials();
    initConservationSection();
    initCtaSection();
    initMagneticButtons();
    createParticles();
    initMorphingBlobs();
  }
  
  // Standard scrolling with enhanced animations
  function initSmoothScroll() {
    // Convert smooth scroll containers to standard layout
    const smoothScrollContainer = document.getElementById('smoothScroll');
    const scrollContentElement = document.getElementById('scrollContent');
    
    if (smoothScrollContainer && scrollContentElement) {
      // Remove fixed positioning to enable normal scrolling
      smoothScrollContainer.style.position = 'static';
      scrollContentElement.style.position = 'static';
      document.body.style.overflow = 'auto';
    }
    
    // Setup scroll triggers for animations without pinning
    ScrollTrigger.defaults({
      toggleActions: "play none none reverse",
      markers: false
    });
    
    // Handle window resize
    window.addEventListener('resize', () => {
      setTimeout(() => {
        ScrollTrigger.refresh();
      }, 100);
    });
    
    // Add error handling
    window.addEventListener('error', function(e) {
      console.error('Animation error:', e);
      // Force enable normal scrolling if an error occurs
      document.body.style.overflow = 'auto';
      if (smoothScrollContainer) smoothScrollContainer.style.position = 'static';
      if (scrollContentElement) scrollContentElement.style.position = 'static';
    });
  }
  
  // Custom cursor
  function initCursor() {
    const cursor = document.getElementById('customCursor');
    const follower = document.getElementById('cursorFollower');
    
    // Variables for cursor position
    let mouseX = 0;
    let mouseY = 0;
    let cursorX = 0;
    let cursorY = 0;
    let followerX = 0;
    let followerY = 0;
    
    // Update cursor position on mouse move
    document.addEventListener('mousemove', (e) => {
      mouseX = e.clientX;
      mouseY = e.clientY;
      
      // Set custom cursor color based on background
      const elementUnderCursor = document.elementFromPoint(mouseX, mouseY);
      if (elementUnderCursor) {
        const bgColor = window.getComputedStyle(elementUnderCursor).backgroundColor;
        if (bgColor.includes('rgb(77, 114, 77)') || bgColor.includes('rgb(58, 90, 58)')) {
          cursor.style.backgroundColor = 'white';
          follower.style.backgroundColor = 'white';
        } else {
          cursor.style.backgroundColor = 'var(--primary-color)';
          follower.style.backgroundColor = 'white';
        }
      }
    });
    
    // Add hover effect on interactive elements
    const interactiveElements = document.querySelectorAll('a, button, .feature-card, .creature-card, .timer-btn, .testimonial-btn, .testimonial-dot');
    interactiveElements.forEach(element => {
      element.addEventListener('mouseenter', () => {
        cursor.classList.add('cursor-hover');
      });
      element.addEventListener('mouseleave', () => {
        cursor.classList.remove('cursor-hover');
      });
    });
    
    // Animate cursor with requestAnimationFrame
    function animateCursor() {
      // Smoothly move main cursor with easing
      cursorX += (mouseX - cursorX) * 0.1;
      cursorY += (mouseY - cursorY) * 0.1;
      
      // Smoothly move follower with different easing
      followerX += (mouseX - followerX) * 0.2;
      followerY += (mouseY - followerY) * 0.2;
      
      // Update cursor positions
      cursor.style.transform = `translate(${cursorX}px, ${cursorY}px)`;
      follower.style.transform = `translate(${followerX}px, ${followerY}px)`;
      
      // Continue animation loop
      requestAnimationFrame(animateCursor);
    }
    
    // Start cursor animation
    animateCursor();
  }
  
  // Hero section animations
  function initHeroSection() {
    const heroTimeline = gsap.timeline();
    
    // Reveal hero elements
    heroTimeline
      .to('#heroOverlay', { opacity: 1, duration: 1.5, ease: "power2.out" })
      .to('.headline .reveal-text', { y: 0, opacity: 1, duration: 1.2, stagger: 0.2, ease: "power3.out" }, "-=1")
      .to('#heroSubtitle', { y: 0, opacity: 1, duration: 1, ease: "power2.out" }, "-=0.8")
      .to('#heroButtons', { y: 0, opacity: 1, duration: 1, ease: "power2.out" }, "-=0.6")
      .to('#scrollIndicator', { opacity: 0.8, duration: 1, ease: "power2.out" }, "-=0.6");
    
    // Animate scroll dot
    gsap.to('#scrollDot', {
      y: 15,
      repeat: -1,
      yoyo: true,
      duration: 1.5,
      ease: "power2.inOut"
    });
    
    // Parallax effect for hero content on mouse move
    document.addEventListener('mousemove', (e) => {
      const xPos = (e.clientX / window.innerWidth - 0.5) * 20;
      const yPos = (e.clientY / window.innerHeight - 0.5) * 20;
      
      gsap.to('#heroContent', {
        rotationY: xPos * 0.5,
        rotationX: -yPos * 0.5,
        transformPerspective: 1000,
        duration: 0.6,
        ease: "power1.out"
      });
      
      // Subtle video movement
      gsap.to('#heroVideo', {
        x: xPos * 0.5,
        y: yPos * 0.5,
        duration: 1,
        ease: "power1.out"
      });
    });
    
    // Video blur effect on scroll
    ScrollTrigger.create({
      trigger: "#hero",
      start: "top top",
      end: "bottom top",
      scrub: true,
      onUpdate: (self) => {
        const blur = self.progress * 10;
        gsap.to('#heroVideo', { filter: `blur(${blur}px)`, ease: "none" });
      }
    });
  }
  
  // Text reveal animations
  function initRevealAnimations() {
    // Split text into words for animated reveal
    const revealTexts = document.querySelectorAll('.headline .reveal-text');
    
    revealTexts.forEach(text => {
      // Create scroll trigger for each headline
      ScrollTrigger.create({
        trigger: text.parentElement,
        start: "top 80%",
        once: true,
        onEnter: () => {
          gsap.to(text, {
            y: 0,
            opacity: 1,
            duration: 1,
            ease: "power3.out"
          });
        }
      });
    });
    
    // Animate body text
    const bodyTexts = document.querySelectorAll('.body-text');
    
    bodyTexts.forEach(text => {
      ScrollTrigger.create({
        trigger: text,
        start: "top 85%",
        once: true,
        onEnter: () => {
          gsap.to(text, {
            y: 0,
            opacity: 1,
            duration: 1,
            ease: "power2.out"
          });
        }
      });
    });
  }
  
  // Parallax background elements
  function initParallaxElements() {
    const parallaxElements = document.querySelectorAll('.parallax-element');
    
    parallaxElements.forEach(element => {
      const speed = element.getAttribute('data-speed') || 0.1;
      
      gsap.to(element, {
        y: `${speed * 100}%`,
        ease: "none",
        scrollTrigger: {
          trigger: element.parentElement,
          start: "top bottom",
          end: "bottom top",
          scrub: true
        }
      });
    });
  }
  
  // Feature cards animation
  function initFeatureCards() {
    const featureCards = document.querySelectorAll('.feature-card');
    
    featureCards.forEach(card => {
      const delay = parseFloat(card.getAttribute('data-delay')) || 0;
      
      ScrollTrigger.create({
        trigger: card,
        start: "top 85%",
        once: true,
        onEnter: () => {
          gsap.to(card, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            delay: delay,
            ease: "power2.out"
          });
        }
      });
      
      // 3D tilt effect
      card.addEventListener('mousemove', (e) => {
        const cardRect = card.getBoundingClientRect();
        const cardCenterX = cardRect.left + cardRect.width / 2;
        const cardCenterY = cardRect.top + cardRect.height / 2;
        const angleY = (e.clientX - cardCenterX) / 10;
        const angleX = (cardCenterY - e.clientY) / 10;
        
        gsap.to(card, {
          rotationY: angleY,
          rotationX: angleX,
          transformPerspective: 1000,
          duration: 0.3,
          ease: "power1.out"
        });
      });
      
      card.addEventListener('mouseleave', () => {
        gsap.to(card, {
          rotationY: 0,
          rotationX: 0,
          y: 0,
          duration: 0.5,
          ease: "power1.out"
        });
      });
    });
  }
  
  // Timer section animations
  function initTimerSection() {
    // Animate timer container
    ScrollTrigger.create({
      trigger: "#timerContainer",
      start: "top 75%",
      once: true,
      onEnter: () => {
        gsap.to("#timerContainer", {
          scale: 1,
          opacity: 1,
          duration: 1,
          ease: "elastic.out(1, 0.5)"
        });
      }
    });
    
    // Animate timer controls and settings
    ScrollTrigger.create({
      trigger: "#timerControls",
      start: "top 85%",
      once: true,
      onEnter: () => {
        gsap.to("#timerControls", {
          y: 0,
          opacity: 1,
          duration: 0.8,
          ease: "power2.out"
        });
        
        gsap.to("#timerSettings", {
          y: 0,
          opacity: 1,
          duration: 0.8,
          delay: 0.2,
          ease: "power2.out"
        });
      }
    });
  }
  
  // Creatures section animations
  function initCreatures() {
    const creatureCards = document.querySelectorAll('.creature-card');
    
    creatureCards.forEach(card => {
      const delay = parseFloat(card.getAttribute('data-delay')) || 0;
      
      ScrollTrigger.create({
        trigger: card,
        start: "top 85%",
        once: true,
        onEnter: () => {
          gsap.to(card, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            delay: delay,
            ease: "power2.out"
          });
        }
      });
    });
    
    // Interactive pattern background
    const pattern = document.getElementById('creaturesPattern');
    if (pattern) {
      document.addEventListener('mousemove', (e) => {
        const xPos = (e.clientX / window.innerWidth - 0.5) * 20;
        const yPos = (e.clientY / window.innerHeight - 0.5) * 20;
        
        gsap.to(pattern, {
          x: xPos,
          y: yPos,
          duration: 1,
          ease: "power1.out"
        });
      });
    }
  }
  
  // Testimonials section
  function initTestimonials() {
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dots = document.querySelectorAll('.testimonial-dot');
    
    // Show initial testimonial
    setTimeout(() => {
      gsap.to(testimonialCards[0], {
        opacity: 1,
        duration: 1,
        ease: "power2.out"
      });
    }, 500);
    
    // Navigation buttons
    prevBtn.addEventListener('click', () => {
      navigateTestimonial('prev');
    });
    
    nextBtn.addEventListener('click', () => {
      navigateTestimonial('next');
    });
    
    // Indicator dots
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        goToTestimonial(index);
      });
    });
    
    // Auto rotate testimonials
    const autoRotate = setInterval(() => {
      navigateTestimonial('next');
    }, 8000);
    
    // Stop auto-rotation on hover
    const testimonialsContainer = document.querySelector('.testimonials-container');
    testimonialsContainer.addEventListener('mouseenter', () => {
      clearInterval(autoRotate);
    });
  }
  
  // Navigate testimonials
  function navigateTestimonial(direction) {
    const totalTestimonials = testimonials.length;
    let newIndex;
    
    if (direction === 'next') {
      newIndex = (currentTestimonial + 1) % totalTestimonials;
    } else {
      newIndex = (currentTestimonial - 1 + totalTestimonials) % totalTestimonials;
    }
    
    goToTestimonial(newIndex);
  }
  
  // Go to specific testimonial
  function goToTestimonial(index) {
    if (index === currentTestimonial) return;
    
    const prevIndex = currentTestimonial;
    currentTestimonial = index;
    
    // Update testimonial cards
    const cards = document.querySelectorAll('.testimonial-card');
    
    // Set classes based on position
    cards.forEach((card, i) => {
      card.classList.remove('active', 'prev', 'next');
      
      if (i === currentTestimonial) {
        card.classList.add('active');
      } else if (i === (currentTestimonial - 1 + cards.length) % cards.length) {
        card.classList.add('prev');
      } else if (i === (currentTestimonial + 1) % cards.length) {
        card.classList.add('next');
      }
    });
    
    // Update indicator dots
    const dots = document.querySelectorAll('.testimonial-dot');
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === currentTestimonial);
    });
  }
  
  // Conservation section animations
  function initConservationSection() {
    // Animate description
    ScrollTrigger.create({
      trigger: "#conservationDesc",
      start: "top 85%",
      once: true,
      onEnter: () => {
        gsap.to("#conservationDesc", {
          y: 0,
          opacity: 1,
          duration: 0.8,
          ease: "power2.out"
        });
      }
    });
    
    // Animate stat cards
    const statCards = document.querySelectorAll('.conservation-stat');
    
    statCards.forEach(card => {
      const delay = parseFloat(card.getAttribute('data-delay')) || 0;
      
      ScrollTrigger.create({
        trigger: card,
        start: "top 85%",
        once: true,
        onEnter: () => {
          gsap.to(card, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            delay: delay,
            ease: "power2.out"
          });
          
          // Animate the count after card appears
          setTimeout(() => {
            const countElement = card.querySelector('.count');
            if (countElement) {
              animateCount(countElement);
            }
          }, delay * 1000 + 500);
        }
      });
    });
    
    // Parallax background
    const bg = document.getElementById('conservationBg');
    if (bg) {
      ScrollTrigger.create({
        trigger: "#conservation",
        start: "top bottom",
        end: "bottom top",
        scrub: true,
        onUpdate: (self) => {
          const yPos = self.progress * 20;
          gsap.to(bg, { y: -yPos + '%', ease: "none" });
        }
      });
    }
  }
  
  // Animated counting for stats
  function animateCount(el) {
    const target = parseInt(el.getAttribute('data-target'));
    const duration = 2500;
    const frameDuration = 1000 / 60;
    const totalFrames = Math.round(duration / frameDuration);
    let frame = 0;
    
    const counter = setInterval(() => {
      frame++;
      const progress = frame / totalFrames;
      const easedProgress = 1 - Math.pow(1 - progress, 3); // Cubic ease out
      const currentCount = Math.round(easedProgress * target);
      
      el.textContent = currentCount.toLocaleString();
      
      if (frame === totalFrames) {
        clearInterval(counter);
      }
    }, frameDuration);
  }
  
  // CTA section animations
  function initCtaSection() {
    // Animate CTA elements
    ScrollTrigger.create({
      trigger: "#cta",
      start: "top 75%",
      once: true,
      onEnter: () => {
        gsap.to(".cta-title", {
          y: 0,
          opacity: 1,
          duration: 0.8,
          ease: "power2.out"
        });
        
        gsap.to("#ctaDesc", {
          y: 0,
          opacity: 1,
          duration: 0.8,
          delay: 0.2,
          ease: "power2.out"
        });
        
        gsap.to("#ctaForm", {
          y: 0,
          opacity: 1,
          duration: 0.8,
          delay: 0.4,
          ease: "power2.out"
        });
      }
    });
  }
  
  // Magnetic buttons effect
  function initMagneticButtons() {
    const magneticBtns = document.querySelectorAll('.magnetic-btn');
    
    magneticBtns.forEach(btn => {
      btn.addEventListener('mousemove', (e) => {
        const btnRect = btn.getBoundingClientRect();
        const btnCenterX = btnRect.left + btnRect.width / 2;
        const btnCenterY = btnRect.top + btnRect.height / 2;
        
        // Calculate distance from center
        const distanceX = e.clientX - btnCenterX;
        const distanceY = e.clientY - btnCenterY;
        
        // Max movement range
        const maxMovement = 15;
        
        // Calculate movement based on distance from center
        const moveX = (distanceX / btnRect.width) * maxMovement;
        const moveY = (distanceY / btnRect.height) * maxMovement;
        
        // Apply magnetic effect
        gsap.to(btn, {
          x: moveX,
          y: moveY,
          duration: 0.3,
          ease: "power2.out"
        });
      });
      
      btn.addEventListener('mouseleave', () => {
        gsap.to(btn, {
          x: 0,
          y: 0,
          duration: 0.5,
          ease: "elastic.out(1, 0.5)"
        });
      });
      
      // Ripple effect on click
      btn.addEventListener('click', (e) => {
        const btnRect = btn.getBoundingClientRect();
        const liquid = btn.querySelector('.liquid');
        
        if (liquid) {
          // Position liquid at click position
          const x = e.clientX - btnRect.left;
          const y = e.clientY - btnRect.top;
          
          gsap.set(liquid, {
            left: x + 'px',
            top: y + 'px',
            scale: 0
          });
          
          gsap.to(liquid, {
            scale: 3,
            opacity: 0,
            duration: 0.8,
            ease: "power2.out",
            onComplete: () => {
              gsap.set(liquid, { opacity: 1, scale: 0 });
            }
          });
        }
      });
    });
  }
  
  // Create floating particles
  function createParticles() {
    const container = document.getElementById('particles');
    if (!container) return;
    
    const particleCount = Math.min(50, Math.floor(window.innerWidth / 20));
    
    for (let i = 0; i < particleCount; i++) {
      const particle = document.createElement('div');
      particle.classList.add('particle');
      
      // Random size
      const size = Math.random() * 8 + 2;
      particle.style.width = `${size}px`;
      particle.style.height = `${size}px`;
      
      // Random position
      const posX = Math.random() * 100;
      const posY = Math.random() * 100;
      particle.style.left = `${posX}%`;
      particle.style.top = `${posY}%`;
      
      // Random opacity
      particle.style.opacity = Math.random() * 0.2 + 0.05;
      
      // Add to container
      container.appendChild(particle);
      
      // Animate particle
      gsap.to(particle, {
        x: `${(Math.random() - 0.5) * 50}%`,
        y: `${(Math.random() - 0.5) * 50}%`,
        duration: Math.random() * 10 + 10,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
        delay: Math.random() * 5
      });
    }
  }
  
  // Initialize morphing blobs
  function initMorphingBlobs() {
    const blobs = [
      document.getElementById('blob1'),
      document.getElementById('blob2'),
      document.getElementById('ctaBlob1'),
      document.getElementById('ctaBlob2')
    ].filter(blob => blob);
    
    blobs.forEach(blob => {
      // Get initial size
      const initialWidth = parseInt(blob.style.width);
      const initialHeight = parseInt(blob.style.height);
      
      // Animate blob morphing
      gsap.to(blob, {
        width: initialWidth * (0.8 + Math.random() * 0.4),
        height: initialHeight * (0.8 + Math.random() * 0.4),
        x: `${(Math.random() - 0.5) * 20}%`,
        y: `${(Math.random() - 0.5) * 20}%`,
        borderRadius: `${30 + Math.random() * 40}% ${30 + Math.random() * 40}% ${30 + Math.random() * 40}% ${30 + Math.random() * 40}%`,
        duration: 8 + Math.random() * 7,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
      });
    });
  }
  
  // Scroll to section (simplified version)
  function scrollToSection(selector) {
    const section = document.querySelector(selector);
    if (!section) return;
    
    // Use a simpler scroll method that's more reliable
    section.scrollIntoView({ 
      behavior: 'smooth', 
      block: 'start' 
    });
    
    // Fallback for browsers that don't support smooth scrolling
    if (typeof window.scrollTo === 'function' && !('scrollBehavior' in document.documentElement.style)) {
      const sectionPosition = section.getBoundingClientRect().top + window.scrollY;
      window.scrollTo({
        top: sectionPosition,
        behavior: 'smooth'
      });
    }
  }
  
  // Focus Timer Functionality
  let timerInterval;
  let remainingSeconds = 0;
  let totalSeconds = 0;
  let isPaused = false;
  
  function startTimer() {
    if (timerInterval) return;
    
    // Get timer duration in seconds
    const timerInput = document.getElementById('timerInput');
    totalSeconds = parseInt(timerInput.value) * 60;
    remainingSeconds = totalSeconds;
    
    // Update display
    updateTimerDisplay();
    
    // Update button states
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    startBtn.disabled = true;
    pauseBtn.disabled = false;
    isPaused = false;
    
    // Play start sound
    playSound('start');
    
    // Start interval
    timerInterval = setInterval(() => {
      if (!isPaused) {
        remainingSeconds--;
        updateTimerDisplay();
        
        if (remainingSeconds <= 0) {
          clearInterval(timerInterval);
          timerInterval = null;
          timerComplete();
        }
      }
    }, 1000);
  }
  
  function updateTimerDisplay() {
    const timerDisplay = document.getElementById('timerDisplay');
    const timerCircle = document.querySelector('.timer-circle');
    
    // Update time display
    const minutes = Math.floor(remainingSeconds / 60);
    const seconds = remainingSeconds % 60;
    timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    
    // Update circle progress
    const circumference = 2 * Math.PI * 130;
    const progress = (totalSeconds - remainingSeconds) / totalSeconds;
    const dashoffset = circumference * (1 - progress);
    timerCircle.style.strokeDashoffset = dashoffset;
    
    // Add pulse effect when almost done
    if (remainingSeconds <= 10 && remainingSeconds > 0) {
      timerCircle.classList.add('pulse');
    } else {
      timerCircle.classList.remove('pulse');
    }
  }
  
  function togglePause() {
    isPaused = !isPaused;
    
    // Update button
    const pauseBtn = document.getElementById('pauseBtn');
    pauseBtn.innerHTML = isPaused ? '<i class="fas fa-play"></i>' : '<i class="fas fa-pause"></i>';
    
    // Play sound
    playSound(isPaused ? 'pause' : 'resume');
  }
  
  function resetTimer() {
    // Clear timer
    clearInterval(timerInterval);
    timerInterval = null;
    
    // Reset timer state
    const timerInput = document.getElementById('timerInput');
    totalSeconds = parseInt(timerInput.value) * 60;
    remainingSeconds = totalSeconds;
    isPaused = false;
    
    // Update display
    updateTimerDisplay();
    
    // Reset buttons
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    startBtn.disabled = false;
    pauseBtn.disabled = true;
    pauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
  }
  
  function timerComplete() {
    // Play completion sound
    playSound('complete');
    
    // Reset button states
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    startBtn.disabled = false;
    pauseBtn.disabled = true;
    
    // Show celebration animation
    const timerContainer = document.getElementById('timerContainer');
    
    gsap.to(timerContainer, {
      scale: 1.05,
      duration: 0.3,
      yoyo: true,
      repeat: 3,
      ease: "elastic.out(1, 0.3)"
    });
  }
  
  function playSound(action) {
    const soundSelect = document.getElementById('soundSelect');
    const soundType = soundSelect.value;
    const audio = document.getElementById(`${soundType}Audio`);
    
    if (audio) {
      audio.currentTime = 0;
      
      if (action === 'complete') {
        audio.volume = 1.0;
        audio.play();
      } else if (action === 'start' || action === 'pause' || action === 'resume') {
        audio.volume = 0.5;
        audio.play();
      }
    }
  }
  
  // Detect devices without hover capability
  function isTouchDevice() {
    return ('ontouchstart' in window) || 
      (navigator.maxTouchPoints > 0) || 
      (navigator.msMaxTouchPoints > 0);
  }
  
  // Initialize everything on document load
  document.addEventListener('DOMContentLoaded', function() {
    // First simulate loading
    simulateLoading();
    
    // Add class for touch devices
    if (isTouchDevice()) {
      document.body.classList.add('touch-device');
      
      // Hide custom cursor on touch devices
      const cursor = document.getElementById('customCursor');
      const follower = document.getElementById('cursorFollower');
      if (cursor) cursor.style.display = 'none';
      if (follower) follower.style.display = 'none';
    }
    
    // Add fallback for scrolling issues
    document.body.style.overflow = 'auto';
    window.addEventListener('load', function() {
      setTimeout(function() {
        // Force enable scrolling after slight delay to ensure page is fully loaded
        document.body.style.overflow = 'auto';
        const scrollContent = document.getElementById('scrollContent');
        if (scrollContent) {
          scrollContent.style.position = 'relative';
          scrollContent.style.height = 'auto';
        }
        // Refresh scroll triggers
        if (typeof ScrollTrigger !== 'undefined') {
          ScrollTrigger.refresh();
        }
      }, 500);
    });
  });
  </script>