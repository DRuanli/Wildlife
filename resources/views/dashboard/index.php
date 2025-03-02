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
    :root {
      --font-sans: 'Inter', sans-serif;
      --font-display: 'Playfair Display', serif;
      
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
      background: linear-gradient(135deg, #4D724D 0%, #2F4F2F 100%);
    }
    
    .headline {
      font-family: var(--font-display);
      font-weight: 700;
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
      font-size: 4rem;
      margin-bottom: 1rem;
    }
    
    .tagline {
      font-size: 1.5rem;
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
    }
    
    .hero-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 7px 14px rgba(0, 0, 0, 0.1);
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
  </style>
</head>

<body>
  <!-- Particles background -->
  <div id="particles-js"></div>
  
  <!-- Main hero section -->
  <div class="hero-container">
    <h1 class="headline welcome-text" id="welcome-text">
      Welcome back, <span class="username"><?php echo $user['username']; ?></span>!
    </h1>
    <p class="tagline">Your wild haven awaits your focused energy.</p>
    
    <div class="buttons-container">
      <a href="<?= $baseUrl ?>/focus" class="hero-button focus-button">
        <i class="fas fa-clock mr-3"></i>
        <span>Start Focus Session</span>
      </a>
      <a href="<?= $baseUrl ?>/dashboard/visualization" class="hero-button analytics-button">
        <i class="fas fa-chart-line mr-3"></i>
        <span>View Analytics</span>
      </a>
    </div>
  </div>

  <!-- Initialize Scripts -->
  <script>
    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize particles.js
      initParticles();
      
      // Initialize welcome text animation
      animateWelcomeText();
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
  </script>
</body>
</html>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>