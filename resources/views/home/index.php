<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Enhanced Home Page with Advanced UX Features -->

<!-- Preload Critical Images and Fonts -->
<link rel="preload" href="<?= $baseUrl ?>/assets/fonts/playfair-display-v30-latin-500.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?= $baseUrl ?>/assets/fonts/inter-v12-latin-regular.woff2" as="font" type="font/woff2" crossorigin>

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
  }

  /* Typography */
  .headline {
    font-family: 'Playfair Display', serif;
    font-weight: 600;
    line-height: 1.1;
    letter-spacing: -0.02em;
    color: var(--text-dark);
  }

  .headline-lg {
    font-size: var(--text-6xl);
  }

  .headline-md {
    font-size: var(--text-4xl);
  }

  .headline-sm {
    font-size: var(--text-2xl);
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

  /* Advanced Button Styles */
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
  }
  
  .btn-primary {
    background-color: var(--primary-color);
    color: white;
    box-shadow: 0 4px 6px rgba(77, 114, 77, 0.2);
  }
  
  .btn-primary:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
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
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  }

  /* Button ripple effect */
  .btn::after {
    content: '';
    position: absolute;
    width: 100px;
    height: 100px;
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transform: scale(0);
    opacity: 1;
    transition: transform 0.5s, opacity 0.5s;
  }
  
  .btn:active::after {
    transform: scale(3);
    opacity: 0;
    transition: 0s;
  }

  /* Layout */
  .section {
    padding: var(--space-3xl) var(--space-lg);
    position: relative;
  }
  
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 var(--space-lg);
  }
  
  .flex-center {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Hero Section */
  .hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    background-color: var(--primary-dark);
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
  }
  
  .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(77,114,77,0.4) 100%);
    z-index: 1;
  }
  
  .hero-content {
    position: relative;
    z-index: 2;
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
    padding: var(--space-lg);
    color: white;
  }
  
  .hero-subtitle {
    margin-bottom: var(--space-xl);
    font-size: var(--text-xl);
    font-weight: 300;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }
  
  .hero-buttons {
    display: flex;
    gap: var(--space-md);
    justify-content: center;
    flex-wrap: wrap;
  }

  /* Enhanced Scroll Indicator */
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
    cursor: pointer;
    opacity: 0.8;
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
  
  .scroll-indicator-icon {
    animation: bounce 2s infinite;
  }
  
  @keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
      transform: translateY(0);
    }
    40% {
      transform: translateY(-10px);
    }
    60% {
      transform: translateY(-5px);
    }
  }

  /* Features Section */
  .features-section {
    background-color: white;
    padding: var(--space-3xl) 0;
  }
  
  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-xl);
    margin-top: var(--space-2xl);
  }
  
  .feature-card {
    background-color: white;
    border-radius: 12px;
    padding: var(--space-xl);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
  
  .feature-card:hover {
    transform: translateY(-10px);
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
    transition: transform 0.3s ease;
  }
  
  .feature-card:hover::before {
    transform: scaleX(1);
  }
  
  .feature-icon {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: var(--space-lg);
    background-color: rgba(77, 114, 77, 0.1);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }
  
  .feature-card:hover .feature-icon {
    background-color: var(--primary-color);
    color: white;
    transform: scale(1.1);
  }
  
  .feature-title {
    font-size: var(--text-xl);
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: var(--space-md);
    font-family: 'Playfair Display', serif;
  }
  
  .feature-description {
    color: var(--text-medium);
    margin-bottom: var(--space-md);
  }

  /* Advanced Focus Timer */
  .focus-timer-section {
    background-color: var(--background-color);
    padding: var(--space-3xl) 0;
    text-align: center;
  }
  
  .focus-timer-wrapper {
    max-width: 600px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .timer-container {
    position: relative;
    margin: var(--space-2xl) 0;
  }
  
  .timer-svg {
    transform: rotate(-90deg);
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
    transition: stroke-dashoffset 0.5s ease;
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
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .timer-btn:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  }
  
  .timer-btn:active {
    transform: translateY(0);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .timer-btn i {
    font-size: 1.5rem;
  }
  
  .timer-settings {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-lg);
    margin-top: var(--space-lg);
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
  }
  
  .timer-input:focus, .timer-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(77, 114, 77, 0.2);
  }

  /* Creatures Gallery */
  .creatures-section {
    background-color: white;
    padding: var(--space-3xl) 0;
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
    cursor: pointer;
  }
  
  .creature-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
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
    transition: transform 0.5s ease;
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

  /* Testimonials Carousel */
  .testimonials-section {
    background-color: var(--background-color);
    padding: var(--space-3xl) 0;
    position: relative;
  }
  
  .testimonials-container {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
  }
  
  .testimonial-card {
    background-color: white;
    border-radius: 15px;
    padding: var(--space-2xl);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    text-align: center;
    position: relative;
    z-index: 1;
  }
  
  .testimonial-quote {
    font-size: var(--text-xl);
    line-height: 1.6;
    color: var(--text-dark);
    margin-bottom: var(--space-xl);
    position: relative;
    font-style: italic;
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
  }
  
  .testimonial-quote::after {
    content: """;
    bottom: -2rem;
    right: -0.5rem;
  }
  
  .testimonial-author {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: var(--space-xl);
  }
  
  .testimonial-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary-color);
    margin-right: var(--space-md);
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
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--text-lg);
    color: var(--primary-color);
    transition: all 0.3s ease;
    pointer-events: auto;
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
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .testimonial-dot.active {
    opacity: 1;
    background-color: var(--primary-color);
    transform: scale(1.3);
  }

  /* Conservation Impact Section */
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
    opacity: 0.9;
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
    transition: transform 0.3s ease, background-color 0.3s ease;
  }
  
  .conservation-stat:hover {
    transform: translateY(-10px);
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
  }
  
  .conservation-stat-label {
    font-size: var(--text-sm);
    opacity: 0.8;
    line-height: 1.4;
  }
  
  /* Call to Action */
  .cta-section {
    background-color: white;
    padding: var(--space-3xl) 0;
    text-align: center;
  }
  
  .cta-container {
    max-width: 800px;
    margin: 0 auto;
  }
  
  .cta-title {
    margin-bottom: var(--space-lg);
  }
  
  .cta-description {
    margin-bottom: var(--space-xl);
    font-size: var(--text-lg);
  }
  
  .cta-form {
    max-width: 500px;
    margin: 0 auto;
    display: flex;
    gap: var(--space-sm);
  }
  
  .cta-input {
    flex: 1;
    padding: var(--space-md) var(--space-lg);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    font-family: 'Inter', sans-serif;
    font-size: var(--text-base);
  }
  
  .cta-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(77, 114, 77, 0.2);
  }

  /* Animations */
  .fade-in {
    animation: fadeIn 1s ease-out forwards;
    opacity: 0;
  }
  
  .fade-in-up {
    animation: fadeInUp 1s ease-out forwards;
    opacity: 0;
  }
  
  .fade-in-left {
    animation: fadeInLeft 1s ease-out forwards;
    opacity: 0;
  }
  
  .fade-in-right {
    animation: fadeInRight 1s ease-out forwards;
    opacity: 0;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  @keyframes fadeInLeft {
    from {
      opacity: 0;
      transform: translateX(-20px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
  
  @keyframes fadeInRight {
    from {
      opacity: 0;
      transform: translateX(20px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  /* Pulse effect for buttons and interactive elements */
  @keyframes pulse {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(77, 114, 77, 0.5); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(77, 114, 77, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(77, 114, 77, 0); }
  }
  
  .pulse {
    animation: pulse 2s infinite;
  }

  /* Floating animation for featured elements */
  @keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
  }
  
  .float {
    animation: float 6s ease-in-out infinite;
  }

  /* Media Queries for Responsive Design */
  @media (max-width: 1024px) {
    .headline-lg { font-size: var(--text-5xl); }
    .headline-md { font-size: var(--text-3xl); }
    .hero-content { max-width: 600px; }
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
  }
</style>

<main>
  <!-- Hero Section with Video Background -->
  <section class="hero">
    <div class="hero-video-container">
      <video class="hero-video" autoplay muted loop playsinline>
        <source src="<?= $baseUrl ?>/public/videos/vid.mp4" type="video/mp4">
      </video>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1 class="headline headline-lg fade-in">Transform Focus Into Conservation</h1>
      <p class="hero-subtitle fade-in" style="animation-delay: 0.3s;">
        Nurture mythical creatures inspired by endangered wildlife while developing better focus habits. Every minute focused is a contribution to real-world conservation.
      </p>
      <div class="hero-buttons fade-in" style="animation-delay: 0.6s;">
        <a href="<?= $baseUrl ?>/auth/register" class="btn btn-primary pulse">
          <i class="fas fa-paw"></i> Get Started Free
        </a>
        <a href="#how-it-works" class="btn btn-secondary">
          <i class="fas fa-play"></i> See How It Works
        </a>
      </div>
    </div>
    <div class="scroll-indicator" onclick="document.querySelector('#features').scrollIntoView({behavior: 'smooth'})">
      <span class="scroll-indicator-text">Explore</span>
      <i class="fas fa-chevron-down scroll-indicator-icon"></i>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features-section" id="features">
    <div class="container">
      <h2 class="headline headline-md text-center">Powerful Features for Focus & Conservation</h2>
      <p class="body-md text-center" style="max-width: 700px; margin: 0 auto;">
        Wildlife Haven combines productivity tools with conservation impact, creating a virtuous cycle between personal growth and global change.
      </p>
      
      <div class="features-grid">
        <!-- Feature 1 -->
        <div class="feature-card fade-in-up" style="animation-delay: 0.1s;">
          <div class="feature-icon">
            <i class="fas fa-clock"></i>
          </div>
          <h3 class="feature-title">Advanced Focus Timer</h3>
          <p class="feature-description">
            Stay in the zone with our Pomodoro-style timer that rewards your focused time with creature growth.
          </p>
          <a href="#focus-timer" class="btn btn-primary" style="margin-top: auto;">Try It Now</a>
        </div>
        
        <!-- Feature 2 -->
        <div class="feature-card fade-in-up" style="animation-delay: 0.3s;">
          <div class="feature-icon">
            <i class="fas fa-dragon"></i>
          </div>
          <h3 class="feature-title">Mythical Creatures</h3>
          <p class="feature-description">
            Hatch and nurture beautiful mythical creatures inspired by endangered wildlife species.
          </p>
          <a href="#creatures" class="btn btn-primary" style="margin-top: auto;">View Creatures</a>
        </div>
        
        <!-- Feature 3 -->
        <div class="feature-card fade-in-up" style="animation-delay: 0.5s;">
          <div class="feature-icon">
            <i class="fas fa-seedling"></i>
          </div>
          <h3 class="feature-title">Real Conservation Impact</h3>
          <p class="feature-description">
            Your focus time contributes to actual conservation efforts like tree planting and habitat protection.
          </p>
          <a href="#conservation" class="btn btn-primary" style="margin-top: auto;">Our Impact</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Advanced Focus Timer -->
  <section class="focus-timer-section" id="focus-timer">
    <div class="container">
      <h2 class="headline headline-md text-center">Experience Our Interactive Focus Timer</h2>
      <p class="body-md text-center" style="max-width: 600px; margin: 0 auto 2rem;">
        Transform distractions into focus with our beautiful timer. Every focused minute helps your creatures grow.
      </p>
      
      <div class="focus-timer-wrapper">
        <div class="timer-container">
          <svg class="timer-svg" width="300" height="300" viewBox="0 0 300 300">
            <circle class="timer-circle-bg" cx="150" cy="150" r="130"></circle>
            <circle class="timer-circle" cx="150" cy="150" r="130" stroke-dasharray="817" stroke-dashoffset="817"></circle>
          </svg>
          <div class="timer-display">
            <div class="timer-display-time" id="timerDisplay">25:00</div>
            <div class="timer-display-label">Focus Time</div>
          </div>
        </div>
        
        <div class="timer-controls">
          <button class="timer-btn" id="startBtn" onclick="startTimer()">
            <i class="fas fa-play"></i>
          </button>
          <button class="timer-btn" id="pauseBtn" onclick="togglePause()" disabled>
            <i class="fas fa-pause"></i>
          </button>
          <button class="timer-btn" id="resetBtn" onclick="resetTimer()">
            <i class="fas fa-redo-alt"></i>
          </button>
        </div>
        
        <div class="timer-settings">
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
    <div class="container">
      <h2 class="headline headline-md text-center">Discover Mythical Wildlife</h2>
      <p class="body-md text-center" style="max-width: 700px; margin: 0 auto 2rem;">
        Each mythical creature is inspired by an endangered species. Nurture them with your focus and learn about their real-world counterparts.
      </p>
      
      <div class="creatures-grid">
        <!-- Creature 1 -->
        <div class="creature-card" data-status="endangered">
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
        <div class="creature-card" data-status="endangered">
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
        <div class="creature-card" data-status="endangered">
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
        <div class="creature-card" data-status="endangered">
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
        <div class="creature-card" data-status="endangered">
          <div class="creature-card-inner">
            <div class="creature-front">
              <img src="<?= $baseUrl ?>/public/img/ele.png" alt="Stone Sentinel" class="creature-image">
              <div class="creature-overlay">
                <h3 class="creature-name">Stone Sentinel</h3>
                <p class="creature-species">Inspired by: Asian Elephant</p>
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

        <!-- Creature 4 -->
        <div class="creature-card" data-status="endangered">
          <div class="creature-card-inner">
            <div class="creature-front">
              <img src="<?= $baseUrl ?>/public/img/IndochineseTiger.jpg" alt="Stone Sentinel" class="creature-image">
              <div class="creature-overlay">
                <h3 class="creature-name">Stone Sentinel</h3>
                <p class="creature-species">Inspired by: Indochinese Tiger</p>
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

        
      </div>
    </div>
  </section>

  <!-- Testimonials Carousel -->
  <section class="testimonials-section" id="testimonials">
    <div class="container">
      <h2 class="headline headline-md text-center">What Our Community Says</h2>
      <p class="body-md text-center" style="max-width: 700px; margin: 0 auto 2rem;">
        Join thousands of users who have transformed their productivity while making a positive impact on wildlife conservation.
      </p>
      
      <div class="testimonials-container">
        <div class="testimonial-card" id="testimonialCard">
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
        
        <div class="testimonial-nav">
          <button class="testimonial-btn testimonial-btn-prev" onclick="prevTestimonial()">
            <i class="fas fa-arrow-left"></i>
          </button>
          <button class="testimonial-btn testimonial-btn-next" onclick="nextTestimonial()">
            <i class="fas fa-arrow-right"></i>
          </button>
        </div>
        
        <div class="testimonial-indicators">
          <span class="testimonial-dot active" onclick="goToTestimonial(0)"></span>
          <span class="testimonial-dot" onclick="goToTestimonial(1)"></span>
          <span class="testimonial-dot" onclick="goToTestimonial(2)"></span>
        </div>
      </div>
    </div>
  </section>

  <!-- Conservation Impact -->
  <section class="conservation-section" id="conservation">
    <div class="conservation-bg"></div>
    <div class="container">
      <div class="conservation-content">
        <h2 class="headline headline-md conservation-title">Our Conservation Impact</h2>
        <p class="conservation-description">
          Every minute you focus contributes to real-world conservation efforts. Here's what our community has accomplished so far:
        </p>
        
        <div class="conservation-stats">
          <div class="conservation-stat float" style="animation-delay: 0.1s;">
            <div class="conservation-stat-number" id="treesPlanted">
              <span class="count" data-target="25000">0</span>
            </div>
            <div class="conservation-stat-label">Trees Planted</div>
          </div>
          
          <div class="conservation-stat float" style="animation-delay: 0.3s;">
            <div class="conservation-stat-number" id="habitatProtected">
              <span class="count" data-target="5000">0</span> acres
            </div>
            <div class="conservation-stat-label">Habitat Protected</div>
          </div>
          
          <div class="conservation-stat float" style="animation-delay: 0.5s;">
            <div class="conservation-stat-number" id="speciesSupported">
              <span class="count" data-target="35">0</span>
            </div>
            <div class="conservation-stat-label">Endangered Species Supported</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="cta-section" id="cta">
    <div class="container">
      <div class="cta-container">
        <h2 class="headline headline-md cta-title">Start Your Focus Journey Today</h2>
        <p class="cta-description">
          Join our community of focused individuals making a difference for wildlife conservation around the world.
        </p>
        <form class="cta-form" action="<?= $baseUrl ?>/auth/register" method="GET">
          <input type="email" class="cta-input" placeholder="Your email address" required>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-arrow-right"></i> Get Started Free
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- Hidden audio elements for timer sounds -->
  <audio id="bellAudio" src="<?= $baseUrl ?>/assets/sounds/bell.mp3" preload="auto"></audio>
  <audio id="forestAudio" src="<?= $baseUrl ?>/assets/sounds/forest.mp3" preload="auto"></audio>
  <audio id="oceanAudio" src="<?= $baseUrl ?>/assets/sounds/ocean.mp3" preload="auto"></audio>
</main>

<!-- JavaScript for Enhanced Functionality -->
<script>
  // Advanced Focus Timer Functionality
  let timerInterval;
  let remainingSeconds = 0;
  let totalSeconds = 0;
  let isPaused = false;
  
  const timerCircle = document.querySelector('.timer-circle');
  const timerDisplay = document.getElementById('timerDisplay');
  const startBtn = document.getElementById('startBtn');
  const pauseBtn = document.getElementById('pauseBtn');
  const resetBtn = document.getElementById('resetBtn');
  const timerInput = document.getElementById('timerInput');
  const soundSelect = document.getElementById('soundSelect');
  
  const circumference = 2 * Math.PI * 130; // Circumference of timer circle
  timerCircle.style.strokeDasharray = circumference;
  timerCircle.style.strokeDashoffset = circumference;
  
  function startTimer() {
    if (timerInterval) return;
    
    // Get timer duration in seconds
    totalSeconds = parseInt(timerInput.value) * 60;
    remainingSeconds = totalSeconds;
    
    // Update display
    updateTimerDisplay();
    
    // Update button states
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
    const minutes = Math.floor(remainingSeconds / 60);
    const seconds = remainingSeconds % 60;
    timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    
    // Update circle progress
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
    pauseBtn.innerHTML = isPaused ? '<i class="fas fa-play"></i>' : '<i class="fas fa-pause"></i>';
    
    if (isPaused) {
      timerCircle.style.animationPlayState = 'paused';
      playSound('pause');
    } else {
      timerCircle.style.animationPlayState = 'running';
      playSound('resume');
    }
  }
  
  function resetTimer() {
    clearInterval(timerInterval);
    timerInterval = null;
    
    // Reset timer state
    totalSeconds = parseInt(timerInput.value) * 60;
    remainingSeconds = totalSeconds;
    isPaused = false;
    
    // Update display
    updateTimerDisplay();
    
    // Reset button states
    startBtn.disabled = false;
    pauseBtn.disabled = true;
    pauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
    
    // Remove pulse effect
    timerCircle.classList.remove('pulse');
  }
  
  function timerComplete() {
    // Play completion sound
    playSound('complete');
    
    // Reset button states
    startBtn.disabled = false;
    pauseBtn.disabled = true;
    
    // Show completion animation
    timerCircle.classList.add('pulse');
    setTimeout(() => {
      timerCircle.classList.remove('pulse');
    }, 3000);
  }
  
  function playSound(action) {
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

  // Testimonials Carousel
  const testimonials = [
    {
      quote: "Wildlife Haven transformed my work habits. The focus timer keeps me productive, and watching my creatures grow while knowing I'm helping real conservation efforts makes it meaningful. It's so much more than just another productivity app.",
      name: "Sarah K.",
      role: "Graphic Designer",
      avatar: "<?= $baseUrl ?>/assets/images/testimonials/user1.jpg"
    },
    {
      quote: "As a student, I struggle with staying focused during long study sessions. Wildlife Haven makes it fun - each focused session helps my creatures grow and contributes to real-world conservation. It's the perfect blend of productivity and purpose.",
      name: "Michael T.",
      role: "University Student",
      avatar: "<?= $baseUrl ?>/assets/images/testimonials/user2.jpg"
    },
    {
      quote: "I've tried dozens of productivity apps, but Wildlife Haven is the only one that keeps me coming back. The connection to conservation gives my daily work deeper meaning, and the creatures are absolutely beautiful. Highly recommended!",
      name: "Elena R.",
      role: "Software Developer",
      avatar: "<?= $baseUrl ?>/assets/images/testimonials/user3.jpg"
    }
  ];
  
  let currentTestimonial = 0;
  
  function updateTestimonial() {
    const testimonial = testimonials[currentTestimonial];
    const testimonialCard = document.getElementById('testimonialCard');
    
    // Fade out
    testimonialCard.style.opacity = 0;
    
    setTimeout(() => {
      // Update content
      testimonialCard.querySelector('.testimonial-quote').textContent = testimonial.quote;
      testimonialCard.querySelector('.testimonial-name').textContent = testimonial.name;
      testimonialCard.querySelector('.testimonial-role').textContent = testimonial.role;
      testimonialCard.querySelector('.testimonial-avatar').src = testimonial.avatar;
      
      // Update indicator dots
      document.querySelectorAll('.testimonial-dot').forEach((dot, index) => {
        dot.classList.toggle('active', index === currentTestimonial);
      });
      
      // Fade in
      testimonialCard.style.opacity = 1;
    }, 300);
  }
  
  function nextTestimonial() {
    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
    updateTestimonial();
  }
  
  function prevTestimonial() {
    currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
    updateTestimonial();
  }
  
  function goToTestimonial(index) {
    currentTestimonial = index;
    updateTestimonial();
  }
  
  // Auto-rotate testimonials
  setInterval(nextTestimonial, 8000);

  // Animated Counting for Stats
  const countElements = document.querySelectorAll('.count');
  
  function animateCount(el) {
    const target = parseInt(el.getAttribute('data-target'));
    const duration = 2000; // ms
    const frameRate = 60;
    const frameDuration = 1000 / frameRate;
    const totalFrames = Math.round(duration / frameDuration);
    let frame = 0;
    
    const counter = setInterval(() => {
      frame++;
      const progress = frame / totalFrames;
      const currentCount = Math.round(progress * target);
      
      if (currentCount > target) {
        el.textContent = target.toLocaleString();
        clearInterval(counter);
      } else {
        el.textContent = currentCount.toLocaleString();
      }
      
      if (frame === totalFrames) {
        clearInterval(counter);
      }
    }, frameDuration);
  }
  
  // Intersection Observer for triggering animations when in viewport
  const animateOnViewObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        if (entry.target.classList.contains('count')) {
          animateCount(entry.target);
        } else if (entry.target.classList.contains('fade-in')) {
          entry.target.style.opacity = 1;
        } else if (entry.target.classList.contains('fade-in-up')) {
          entry.target.style.opacity = 1;
          entry.target.style.transform = 'translateY(0)';
        }
        animateOnViewObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });
  
  // Observe animated elements
  document.querySelectorAll('.count, .fade-in, .fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
    animateOnViewObserver.observe(el);
  });

  // Smooth scroll for navigation links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      
      const targetId = this.getAttribute('href');
      const targetElement = document.querySelector(targetId);
      
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - 80, // Offset for sticky header
          behavior: 'smooth'
        });
      }
    });
  });

  // Initialize the page
  document.addEventListener('DOMContentLoaded', function() {
    // Set initial timer display
    resetTimer();
    
    // Start observing animations
    document.querySelectorAll('.fade-in, .fade-in-up, .fade-in-left, .fade-in-right').forEach(el => {
      el.style.opacity = 0;
      animateOnViewObserver.observe(el);
    });
    
    // Observe count elements
    document.querySelectorAll('.count').forEach(el => {
      animateOnViewObserver.observe(el);
    });
  });
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>