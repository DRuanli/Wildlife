<?php
// Optional: Configure the loading screen
$loading_duration = 2000; // milliseconds
$loading_text = "LOADING WILDLIFE HAVEN"; // custom text

// Include the loading component at the beginning of your file
include('public/loading-component.php');
?>

<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wildlife Haven - Dashboard</title>
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Google Fonts - Preload for performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  
  <!-- GSAP for animations -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  
  <!-- Particles.js -->
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  
  <!-- Custom Styles -->
  <style>

    @font-face {
      font-family: "ZooCute";
      src: url("/Wildlife/public/fonts/Zoocute.ttf") format("truetype");
    }
    :root {
      --font-sans: 'Merriweather', sans-serif;
      --font-display: 'ZooCute', cursive;
      
      
      /* Core palette */
      --color-bg: #F9F8F2;
      --color-text: #1A1A1A;
      --color-text-muted: #666666;
      --color-primary: #4D724D;
      --color-primary-light: #C4D7C4;
      --color-primary-dark: #2F4F2F;
      --color-accent: #CE6246;
      
      /* Status colors */
      --color-focus: #4A6FA5;
      --color-streak: #CE8550;
      --color-coins: #C9A227;
      --color-conservation: #4E8D89;
    }
    
    body {
      font-family: var(--font-sans);
      line-height: 1.5;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      margin: 0;
      padding: 0;
      height: 100vh;
      background: linear-gradient(135deg, #4D724D 0%, #4D724D 100%);
      cursor: none; /* Hide default cursor */
    }
    
    .headline {
      font-family: var(--font-display);
      font-weight: 1000;
    }

    .wave-title {
      font-size: 48px;
      font-weight: bold;
      animation-name: waveMotion;
      animation-duration: 3s;
      animation-iteration-count: infinite;
    }


    @keyframes waveMotion {
      0% {
        transform: translate3d(0, 0, 0);
      }
      20% {
        transform: translate3d(15px, -10px, 15px);
      }
      40% {
        transform: translate3d(0, 15px, 0);
      }
      60% {
        transform: translate3d(-15px, -10px, -15px);
      }
      80% {
        transform: translate3d(0, -5px, 0);
      }
      100% {
        transform: translate3d(0, 0, 0);
      }
    }

    /* Hero section styles */
    .hero-container {
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
      z-index: 10;
      color: white;
      padding: 2rem;
    }
    
    .welcome-text {
      font-size: 10rem;
      margin-bottom: 1rem;
    }
    
    .tagline {
      font-family: var(--font-display);
      font-size: 2.5rem;
      margin-bottom: 4rem;
      opacity: 0.9;
    }
    
    .username {
      color: #FFD700;
    }
    
    /* Button styles */
    .buttons-container {
      display: flex;
      gap: 1.5rem;
      margin-top: 1rem;
    }
    
    @media (max-width: 640px) {
      .buttons-container {
        flex-direction: column;
      }
      
      .welcome-text {
        font-size: 3rem;
      }
    }
    
    .hero-button {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem 2rem;
      border-radius: 0.75rem;
      font-weight: 500;
      transition: all 0.3s ease;
      font-size: 1.125rem;
      position: relative;
      overflow: hidden;
    }
    
    .hero-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 7px 14px rgba(0, 0, 0, 0.1);
    }
    
    /* Button click effect */
    .hero-button .ripple {
      position: absolute;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.5);
      transform: scale(0);
      animation: ripple 0.8s linear;
      pointer-events: none;
    }
    
    @keyframes ripple {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }
    
    .focus-button {
      background-color: var(--color-accent);
      color: white;
    }
    
    .analytics-button {
      background-color: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.18);
    }
    
    /* Particles container */
    #particles-js {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: 0;
    }
    
    /* Custom cursor styles */
    .cursor {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      position: fixed;
      background-color: rgba(255, 255, 255, 0.3);
      mix-blend-mode: difference;
      pointer-events: none;
      transform: translate(-50%, -50%);
      transition: transform 0.1s ease;
      z-index: 9999;
    }
    
    /* Animal following cursor */
    .animal {
      position: absolute;
      width: 40px;
      height: 40px;
      pointer-events: none;
      z-index: 9998;
      transition: all 0.2s ease;
      transform-origin: center center;
      opacity: 0.8;
    }
    
    .animal img {
      width: 100%;
      height: 200%;
      object-fit: contain;
    }
    
    /* Animal appearance animation */
    @keyframes animalAppear {
      0% { transform: scale(0) rotate(-10deg); opacity: 0; }
      50% { transform: scale(1.2) rotate(10deg); opacity: 1; }
      100% { transform: scale(1) rotate(0); opacity: 0.8; }
    }
    
    /* Animal disappearance animation */
    @keyframes animalDisappear {
      0% { transform: scale(1); opacity: 0.8; }
      100% { transform: scale(0); opacity: 0; }
    }
  </style>
</head>

<body>
  <!-- Particles background -->
  <div id="particles-js"></div>
  
  <!-- Custom cursor -->
  <div class="cursor"></div>
  
  <!-- Main hero section -->
  <div class="hero-container">
    <h1 class="headline welcome-text wave-title" id="welcome-text" style = "animation: waveMotion 10s infinite;">
      Welcome back, <span class="username" ><?php echo $user['username']; ?></span>!
    </h1>
    <p class="tagline" style = "animation: waveMotion 10s infinite;">Your wild haven awaits your focused energy.</p>
    
    <div class="buttons-container">
      <a href="<?= $baseUrl ?>/focus" class="hero-button focus-button">
        <i class="fas fa-clock mr-3"></i>
        <span">Start Focus Session</span>
      </a>
      <a href="<?= $baseUrl ?>/focus/history" class="hero-button analytics-button">
        <i class="fas fa-chart-line mr-3"></i>
        <span>View Analytics</span>
      </a>
    </div>
  </div>
  
  <!-- Animal templates (hidden) -->
  <div id="animal-templates" style="display: none; ">
    <img src="<?= $baseUrl ?>/public/img/diana-parkhouse-dBrKSWR-z1w-unsplash.jpg">
    <img src="<?= $baseUrl ?>/public/img/ele.png">
    <img src="<?= $baseUrl ?>/public/img/Rhino.png">
    <img src="<?= $baseUrl ?>/public/img/panda.jpg">
    <img src="<?= $baseUrl ?>/public/img/whale.png">
    <img src="<?= $baseUrl ?>/public/img/janne-simoes-7ks54q7I03g-unsplash.jpg">
    <img src="<?= $baseUrl ?>/public/img/jonatan-pie-d7ZBAPEuXGc-unsplash.jpg">
    <img src="<?= $baseUrl ?>/public/img/IndochineseTiger.jpg">
    <img src="<?= $baseUrl ?>/public/img/snow_leopard.png">
    <img src="<?= $baseUrl ?>/public/img/zdenek-machacek-UxHol6SwLyM-unsplash.jpg">
    <img src="<?= $baseUrl ?>/images/creatures/snow_leopard.png">
    <img src="<?= $baseUrl ?>/images/creatures/philipin_edge.jpg">
    <img src="<?= $baseUrl ?>/images/creatures/saola.png">
    <img src="<?= $baseUrl ?>/images/creatures/hawaiiCrow.png">
    <img src="<?= $baseUrl ?>/images/creatures/tasmaniaTiger.png">
    <img src="<?= $baseUrl ?>/images/creatures/Chinese Giant Salamander.png">
    <img src="<?= $baseUrl ?>/images/creatures/Vaquita.png">
    <img src="<?= $baseUrl ?>/images/creatures/African Grey Parrot.png">
    <img src="<?= $baseUrl ?>/images/creatures/Galápagos Tortoise.png">
    <img src="<?= $baseUrl ?>/images/creatures/Iberian Lynx.png">
    <img src="<?= $baseUrl ?>/images/creatures/Red Fox.png">
    <img src="<?= $baseUrl ?>/images/creatures/Giant Manta Ray.png">

  </div>

  <!-- Initialize Scripts -->
  <script>
    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize particles.js
      initParticles();
      
      // Initialize welcome text animation
      animateWelcomeText();
      
      // Initialize custom cursor
      initCustomCursor();
      
      // Initialize animal appearance on mouse movement
      initAnimalAppearance();
      
      // Initialize button click effects
      initButtonEffects();
    });
    
    // Optimized particles initialization
    function initParticles() {
      particlesJS('particles-js', {
        "particles": {
          "number": {
            "value": 40,
            "density": {
              "enable": true,
              "value_area": 800
            }
          },
          "color": {
            "value": "#ffffff"
          },
          "shape": {
            "type": "circle"
          },
          "opacity": {
            "value": 0.5,
            "random": true
          },
          "size": {
            "value": 3,
            "random": true
          },
          "line_linked": {
            "enable": false
          },
          "move": {
            "enable": true,
            "speed": 0.8,
            "direction": "top",
            "random": true,
            "straight": false,
            "out_mode": "out",
            "bounce": false
          }
        },
        "interactivity": {
          "detect_on": "canvas",
          "events": {
            "onhover": {
              "enable": true,
              "mode": "bubble"
            },
            "onclick": {
              "enable": true,
              "mode": "push"
            }
          },
          "modes": {
            "bubble": {
              "distance": 100,
              "size": 5,
              "duration": 2,
              "opacity": 0.8,
              "speed": 3
            },
            "push": {
              "particles_nb": 2
            }
          }
        },
        "retina_detect": false
      });
    }
    
    // Simple welcome text animation
    function animateWelcomeText() {
      gsap.from("#welcome-text", {
        y: -30,
        opacity: 0,
        duration: 1,
        ease: "power2.out"
      });
      
      gsap.from(".tagline", {
        y: -20,
        opacity: 0,
        duration: 1,
        delay: 0.3,
        ease: "power2.out"
      });
      
      gsap.from(".buttons-container", {
        y: 20,
        opacity: 0,
        duration: 1,
        delay: 0.6,
        ease: "power2.out"
      });
    }
    
    // Custom cursor that follows mouse
    function initCustomCursor() {
      const cursor = document.querySelector('.cursor');
      
      document.addEventListener('mousemove', (e) => {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
      });
      
      // Scale cursor when hovering over clickable elements
      const clickables = document.querySelectorAll('a, button, .hero-button');
      clickables.forEach(el => {
        el.addEventListener('mouseenter', () => {
          cursor.style.transform = 'translate(-50%, -50%) scale(1.5)';
          cursor.style.backgroundColor = 'rgba(255, 255, 255, 0.5)';
        });
        el.addEventListener('mouseleave', () => {
          cursor.style.transform = 'translate(-50%, -50%) scale(1)';
          cursor.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
        });
      });
    }
    
    // Animal appearance on mouse movement
    function initAnimalAppearance() {
      // Get animal templates
      const animalTemplates = document.querySelectorAll('#animal-templates img');
      const animalImages = Array.from(animalTemplates).map(img => img.getAttribute('src'));
      
      // Initialize variables for tracking mouse movement
      let lastX = 0;
      let lastY = 0;
      let threshold = 50; // Distance threshold to show animal
      let animalCounter = 0;
      
      // Track mouse movement
      document.addEventListener('mousemove', (e) => {
        const currentX = e.clientX;
        const currentY = e.clientY;
        
        // Calculate distance moved
        const distX = currentX - lastX;
        const distY = currentY - lastY;
        const distance = Math.sqrt(distX * distX + distY * distY);
        
        // Show animal if distance exceeds threshold
        if (distance > threshold) {
          showAnimal(currentX, currentY);
          lastX = currentX;
          lastY = currentY;
        }
      });
      
      function showAnimal(x, y) {
        // Create animal element
        const animal = document.createElement('div');
        animal.className = 'animal';
        animal.style.left = x + 'px';
        animal.style.top = y + 'px';
        
        // Select random animal image
        const randomIndex = Math.floor(Math.random() * animalImages.length);
        const img = document.createElement('img');
        img.src = animalImages[randomIndex];
        animal.appendChild(img);
        
        // Add to DOM
        document.body.appendChild(animal);
        
        // Animate appearance
        animal.style.animation = 'animalAppear 0.3s forwards';
        
        // Make unique ID for this animal
        const animalId = 'animal-' + animalCounter++;
        animal.id = animalId;
        
        // Remove after delay
        setTimeout(() => {
          animal.style.animation = 'animalDisappear 0.5s forwards';
          setTimeout(() => {
            const expiredAnimal = document.getElementById(animalId);
            if (expiredAnimal) {
              expiredAnimal.remove();
            }
          }, 500);
        }, 2000);
      }
    }
    
    // Button click effects
    function initButtonEffects() {
      const buttons = document.querySelectorAll('.hero-button');
      
      buttons.forEach(button => {
        button.addEventListener('click', function(e) {
          // Create ripple effect
          const ripple = document.createElement('span');
          ripple.className = 'ripple';
          this.appendChild(ripple);
          
          // Set ripple position
          const rect = this.getBoundingClientRect();
          const size = Math.max(rect.width, rect.height);
          ripple.style.width = size + 'px';
          ripple.style.height = size + 'px';
          ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
          ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
          
          // Remove ripple after animation completes
          setTimeout(() => {
            ripple.remove();
          }, 800);
          
          // Create animals burst from button
          createAnimalBurst(e.clientX, e.clientY);
        });
      });
      
      function createAnimalBurst(x, y) {
        // Create multiple animals bursting from click point
        for (let i = 0; i < 8; i++) {
          setTimeout(() => {
            // Calculate position with offset
            const angle = (i / 8) * Math.PI * 2;
            const distance = 60;
            const burstX = x + Math.cos(angle) * distance;
            const burstY = y + Math.sin(angle) * distance;
            
            // Create animal at position
            const animal = document.createElement('div');
            animal.className = 'animal';
            animal.style.left = burstX + 'px';
            animal.style.top = burstY + 'px';
            
            // Random animal
            const animalTemplates = document.querySelectorAll('#animal-templates img');
            const randomIndex = Math.floor(Math.random() * animalTemplates.length);
            const img = document.createElement('img');
            img.src = animalTemplates[randomIndex].getAttribute('src');
            animal.appendChild(img);
            
            // Add to DOM
            document.body.appendChild(animal);
            
            // Animate
            animal.style.animation = 'animalAppear 0.3s forwards';
            
            // Remove after delay
            setTimeout(() => {
              animal.style.animation = 'animalDisappear 0.5s forwards';
              setTimeout(() => {
                animal.remove();
              }, 500);
            }, 1000);
          }, i * 50); // Staggered timing
        }
      }
    }
  </script>
</body>
</html>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>