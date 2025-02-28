<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wildlife Haven - Dashboard</title>
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <!-- GSAP for animations -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

  <!-- Three.js for 3D effects -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
  
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
    
    html {
      scroll-behavior: smooth;
    }
    
    body {
      font-family: var(--font-sans);
      background-color: var(--color-bg);
      color: var(--color-text);
      line-height: 1.5;
      overflow-x: hidden;
    }
    
    .headline {
      font-family: var(--font-display);
      font-weight: 500;
    }
    
    /* Parallax layers */
    .parallax-container {
      perspective: 1px;
      height: 100vh;
      overflow-x: hidden;
      overflow-y: auto;
      perspective-origin: 0 0;
    }
    
    .parallax-layer {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      transform-origin-x: 100%;
    }
    
    .parallax-layer-back {
      transform: translateZ(-6px) scale(7);
    }
    
    .parallax-layer-mid {
      transform: translateZ(-3px) scale(4);
    }
    
    .parallax-layer-front {
      transform: translateZ(-1px) scale(2);
    }
    
    .parallax-content {
      transform: translateZ(0);
      position: relative;
      z-index: 1;
    }
    
    /* Interactive elements */
    .interactive-card {
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    }
    
    .interactive-card:hover {
      transform: translateY(-10px) rotateX(5deg) rotateY(5deg);
      box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
    }
    
    /* Hero button effect */
    .hero-button {
      position: relative;
      overflow: hidden;
      z-index: 1;
      transition: all 0.5s ease;
    }
    
    .hero-button:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.1);
      z-index: -1;
      transform: scale(0);
      transition: transform 0.5s ease;
      border-radius: inherit;
    }
    
    .hero-button:hover:before {
      transform: scale(1);
    }
    
    .hero-button:after {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%);
      transform: scale(0);
      transition: transform 0.5s ease;
    }
    
    .hero-button:hover:after {
      transform: scale(1);
    }
    
    /* Glass morphism */
    .glass {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.18);
    }
    
    /* Animated background gradient */
    .animated-gradient {
      background: linear-gradient(-45deg, #2f4f2f, #4D724D, #4A6FA5, #CE8550);
      background-size: 400% 400%;
      animation: gradient 15s ease infinite;
    }
    
    @keyframes gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
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
    
    /* 3D scene container */
    #scene-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      z-index: 0;
      opacity: 0.5;
    }
    
    /* Scroll-triggered animations */
    .fade-in {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 1s ease, transform 1s ease;
    }
    
    .fade-in.active {
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Bubble floating animation */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
    }
    
    .float {
      animation: float 6s ease-in-out infinite;
    }
    
    /* Creature container */
    .creature-container {
      position: relative;
      transition: transform 0.6s cubic-bezier(0.68, -0.6, 0.32, 1.6);
    }
    
    .creature-container:hover {
      transform: scale(1.1) rotate(5deg);
    }
    
    /* Progress bar animation */
    @keyframes progress-fill {
      0% { width: 0; }
      100% { width: var(--progress-width); }
    }
    
    .progress-bar {
      position: relative;
      height: 8px;
      background: rgba(0,0,0,0.1);
      border-radius: 4px;
      overflow: hidden;
    }
    
    .progress-bar-fill {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      background: var(--color-primary);
      border-radius: 4px;
      width: 0;
      animation: progress-fill 1.5s ease forwards;
    }
    
    /* Stats number animation */
    .animate-number {
      display: inline-block;
      opacity: 0;
      transform: translateY(10px);
    }
    
    /* Cursor follower */
    .cursor-follower {
      position: fixed;
      width: 30px;
      height: 30px;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      pointer-events: none;
      mix-blend-mode: difference;
      z-index: 9999;
      transform: translate(-50%, -50%);
      transition: transform 0.1s ease, width 0.3s ease, height 0.3s ease;
    }
  </style>
</head>

<body class="parallax-container" data-barba="wrapper">
  <!-- Custom cursor follower -->
  <div class="cursor-follower hidden md:block"></div>
  
  <!-- 3D Scene Container -->
  <div id="scene-container"></div>
  
  <!-- Parallax Background Layers -->
  <div class="parallax-layer parallax-layer-back">
    <div class="h-screen w-full animated-gradient"></div>
  </div>
  
  <div class="parallax-layer parallax-layer-mid">
    <div class="absolute top-1/4 left-1/3 w-32 h-32 rounded-full bg-white opacity-10"></div>
    <div class="absolute top-1/2 right-1/4 w-24 h-24 rounded-full bg-white opacity-5"></div>
    <div class="absolute bottom-1/4 left-1/5 w-40 h-40 rounded-full bg-white opacity-5"></div>
  </div>
  
  <div class="parallax-layer parallax-layer-front">
    <div class="absolute top-20 right-20 w-16 h-16 rounded-full bg-white opacity-10 float"></div>
    <div class="absolute bottom-40 left-1/4 w-12 h-12 rounded-full bg-white opacity-10 float" style="animation-delay: -2s;"></div>
    <div class="absolute top-1/3 left-10 w-20 h-20 rounded-full bg-white opacity-10 float" style="animation-delay: -4s;"></div>
  </div>
  
  <!-- Main Content -->
  <div class="parallax-content">
    <!-- Hero Section with Particles -->
    <section class="relative min-h-screen flex items-center">
      <div id="particles-js" class="absolute inset-0"></div>
      
      <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
          <h1 class="headline text-5xl sm:text-6xl mb-6 text-white text-shadow" id="welcome-text">
            Welcome back, <span class="text-amber-300"><?php echo $user['username']; ?></span>!
          </h1>
          <p class="text-xl text-white text-opacity-90 mb-10">Your wild haven awaits your focused energy.</p>
          
          <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
            <a href="<?= $baseUrl ?>/focus" class="hero-button bg-accent text-white px-8 py-4 rounded-xl font-medium shadow-xl flex items-center justify-center text-lg group">
              <i class="fas fa-clock mr-3 group-hover:rotate-12 transition-transform"></i>
              <span>Start Focus Session</span>
            </a>
            <a href="<?= $baseUrl ?>/dashboard/visualization" class="hero-button glass text-white px-8 py-4 rounded-xl font-medium flex items-center justify-center text-lg group">
              <i class="fas fa-chart-line mr-3 group-hover:scale-110 transition-transform"></i>
              <span>View Analytics</span>
            </a>
          </div>
        </div>
      </div>
      
      <!-- Scroll indicator -->
      <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 text-white text-opacity-80 text-center">
        <p class="mb-2 text-sm">Scroll to explore</p>
        <div class="w-6 h-10 border-2 border-white border-opacity-50 rounded-full mx-auto flex justify-center">
          <div class="w-1.5 h-1.5 bg-white rounded-full animate-bounce mt-1"></div>
        </div>
      </div>
    </section>

    <!-- Stats Section with 3D Transformations -->
    <section class="relative py-24 bg-white">
      <div class="container mx-auto px-4">
        <h2 class="headline text-3xl mb-12 text-center fade-in">Your Focus Journey</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
          <!-- Focus Time Card -->
          <div class="interactive-card bg-white p-6 stats-card" data-stats-value="<?= floor(($user['total_focus_time'] ?? 0) / 60) ?>">
            <div class="flex items-center mb-3">
              <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3" style="background-color: var(--color-focus-light);">
                <i class="fas fa-hourglass-half text-xl" style="color: var(--color-focus);"></i>
              </div>
              <h3 class="font-medium">Focus Time</h3>
            </div>
            
            <div class="flex items-end">
              <span class="text-3xl font-bold stats-number">0</span>
              <span class="text-lg ml-1 text-gray-600">hrs</span>
              <span class="text-xl font-bold ml-2 stats-decimal">0</span>
              <span class="text-lg ml-1 text-gray-600">min</span>
            </div>
            
            <div class="mt-3">
              <div class="progress-bar">
                <div class="progress-bar-fill" style="--progress-width: 75%"></div>
              </div>
              <div class="text-sm text-gray-500 mt-1 flex justify-between">
                <span>Last week</span>
                <span class="text-green-500"><i class="fas fa-arrow-up text-xs"></i> 12%</span>
              </div>
            </div>
          </div>
          
          <!-- Streak Card -->
          <div class="interactive-card bg-white p-6 stats-card" data-stats-value="<?= $user['streak_days'] ?? 0 ?>">
            <div class="flex items-center mb-3">
              <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3" style="background-color: var(--color-streak-light);">
                <i class="fas fa-fire text-xl" style="color: var(--color-streak);"></i>
              </div>
              <h3 class="font-medium">Current Streak</h3>
            </div>
            
            <div class="flex items-end">
              <span class="text-3xl font-bold stats-number">0</span>
              <span class="text-lg ml-1 text-gray-600">days</span>
            </div>
            
            <div class="mt-3">
              <div class="progress-bar">
                <div class="progress-bar-fill" style="--progress-width: 65%"></div>
              </div>
              <div class="text-sm text-gray-500 mt-1">
                <span>Personal best: 21 days</span>
              </div>
            </div>
          </div>
          
          <!-- Coins Card -->
          <div class="interactive-card bg-white p-6 stats-card" data-stats-value="<?= $user['coins_balance'] ?? 0 ?>">
            <div class="flex items-center mb-3">
              <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3" style="background-color: var(--color-coins-light);">
                <i class="fas fa-coins text-xl" style="color: var(--color-coins);"></i>
              </div>
              <h3 class="font-medium">Wild Coins</h3>
            </div>
            
            <div class="flex items-end">
              <span class="text-3xl font-bold stats-number">0</span>
            </div>
            
            <div class="mt-3">
              <div class="progress-bar">
                <div class="progress-bar-fill" style="--progress-width: 40%"></div>
              </div>
              <div class="text-sm text-gray-500 mt-1 flex justify-between">
                <span>5% bonus active</span>
                <a href="<?= $baseUrl ?>/shop" class="text-blue-500 hover:underline">Shop</a>
              </div>
            </div>
          </div>
          
          <!-- Conservation Card -->
          <div class="interactive-card bg-white p-6 stats-card" data-stats-value="12">
            <div class="flex items-center mb-3">
              <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3" style="background-color: var(--color-conservation-light);">
                <i class="fas fa-leaf text-xl" style="color: var(--color-conservation);"></i>
              </div>
              <h3 class="font-medium">Trees Planted</h3>
            </div>
            
            <div class="flex items-end">
              <span class="text-3xl font-bold stats-number">0</span>
            </div>
            
            <div class="mt-3">
              <div class="progress-bar">
                <div class="progress-bar-fill" style="--progress-width: 65%"></div>
              </div>
              <div class="text-sm text-gray-500 mt-1">
                <span>65% to next tree</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Creatures Section with 3D Animated Creatures -->
    <section class="relative py-24 bg-gradient-to-b from-emerald-50 to-emerald-100">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center mb-12">
          <h2 class="headline text-3xl mb-4 fade-in">Your Wildlife Collection</h2>
          <p class="text-gray-600 fade-in">Nurture your magical creatures by focusing on what matters</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
          <!-- Creature Card 1 - Water Dragon -->
          <div class="creature-container fade-in">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full transform transition-transform">
              <div class="h-32 bg-blue-50 relative overflow-hidden">
                <!-- Animated water waves -->
                <svg viewBox="0 0 100 20" class="absolute inset-0 w-full h-full opacity-20" preserveAspectRatio="none">
                  <path d="M0,10 Q30,5 50,10 T100,10 V20 H0 Z" fill="#3B82F6">
                    <animate attributeName="d" dur="6s" repeatCount="indefinite" values="M0,10 Q30,5 50,10 T100,10 V20 H0 Z; M0,10 Q30,15 50,10 T100,10 V20 H0 Z; M0,10 Q30,5 50,10 T100,10 V20 H0 Z"></animate>
                  </path>
                </svg>
                
                <div class="absolute inset-0 flex items-center justify-center">
                  <i class="fas fa-dragon text-blue-500 text-5xl creature-icon float"></i>
                </div>
              </div>
              
              <div class="p-4">
                <h3 class="font-bold text-center">Aquaris</h3>
                <p class="text-sm text-gray-500 text-center">Water Dragon • Adult</p>
                
                <div class="mt-2 flex justify-center space-x-2">
                  <div class="text-xs flex items-center">
                    <i class="fas fa-heart text-red-500 mr-1"></i>
                    <span>92%</span>
                  </div>
                  <div class="text-xs flex items-center">
                    <i class="fas fa-smile text-yellow-500 mr-1"></i>
                    <span>87%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Creature Card 2 - Fire Phoenix -->
          <div class="creature-container fade-in">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full transform transition-transform">
              <div class="h-32 bg-orange-50 relative overflow-hidden">
                <!-- Animated flames -->
                <svg viewBox="0 0 100 50" class="absolute inset-0 w-full h-full opacity-20" preserveAspectRatio="none">
                  <path d="M10,50 Q30,30 50,50 T90,50" fill="#F97316">
                    <animate attributeName="d" dur="3s" repeatCount="indefinite" values="M10,50 Q30,30 50,50 T90,50; M10,50 Q30,20 50,50 T90,50; M10,50 Q30,30 50,50 T90,50"></animate>
                  </path>
                </svg>
                
                <div class="absolute inset-0 flex items-center justify-center">
                  <i class="fas fa-fire text-orange-500 text-5xl creature-icon float" style="animation-delay: -2s"></i>
                </div>
              </div>
              
              <div class="p-4">
                <h3 class="font-bold text-center">Ember</h3>
                <p class="text-sm text-gray-500 text-center">Fire Phoenix • Adult</p>
                
                <div class="mt-2 flex justify-center space-x-2">
                  <div class="text-xs flex items-center">
                    <i class="fas fa-heart text-red-500 mr-1"></i>
                    <span>96%</span>
                  </div>
                  <div class="text-xs flex items-center">
                    <i class="fas fa-smile text-yellow-500 mr-1"></i>
                    <span>92%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Creature Card 3 - Forest Spirit -->
          <div class="creature-container fade-in">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full transform transition-transform">
              <div class="h-32 bg-green-50 relative overflow-hidden">
                <!-- Animated leaves -->
                <svg viewBox="0 0 100 50" class="absolute inset-0 w-full h-full opacity-20" preserveAspectRatio="none">
                  <path d="M20,20 Q30,5 40,20 Q50,35 60,20 Q70,5 80,20" stroke="#22c55e" stroke-width="1" fill="none">
                    <animate attributeName="d" dur="8s" repeatCount="indefinite" values="M20,20 Q30,5 40,20 Q50,35 60,20 Q70,5 80,20; M20,25 Q30,10 40,25 Q50,40 60,25 Q70,10 80,25; M20,20 Q30,5 40,20 Q50,35 60,20 Q70,5 80,20"></animate>
                  </path>
                </svg>
                
                <div class="absolute inset-0 flex items-center justify-center">
                  <i class="fas fa-leaf text-green-500 text-5xl creature-icon float" style="animation-delay: -4s"></i>
                </div>
              </div>
              
              <div class="p-4">
                <h3 class="font-bold text-center">Leafling</h3>
                <p class="text-sm text-gray-500 text-center">Forest Spirit • Juvenile</p>
                
                <div class="mt-2 flex justify-center space-x-2">
                  <div class="text-xs flex items-center">
                    <i class="fas fa-heart text-red-500 mr-1"></i>
                    <span>88%</span>
                  </div>
                  <div class="text-xs flex items-center">
                    <i class="fas fa-smile text-yellow-500 mr-1"></i>
                    <span>91%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Creature Card 4 - Mystery Egg -->
          <div class="creature-container fade-in">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full transform transition-transform">
              <div class="h-32 bg-yellow-50 relative overflow-hidden">
                <div class="absolute inset-0 flex items-center justify-center">
                  <i class="fas fa-egg text-yellow-400 text-5xl creature-icon" id="mystery-egg"></i>
                </div>
              </div>
              
              <div class="p-4">
                <h3 class="font-bold text-center">Mystery Egg</h3>
                <p class="text-sm text-gray-500 text-center">Unknown • Egg</p>
                
                <div class="mt-2">
                  <div class="progress-bar">
                    <div class="progress-bar-fill" style="--progress-width: 85%"></div>
                  </div>
                  <p class="text-xs text-center text-gray-500 mt-1">Ready to hatch!</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="text-center">
          <a href="<?= $baseUrl ?>/creatures" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-medium shadow-md hover:bg-emerald-700 transition-colors hero-button">
            <span>View All Creatures</span>
            <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
      </div>
    </section>
    
    <!-- Conservation Impact with Particle Effects -->
    <section class="relative py-24 bg-white overflow-hidden">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center mb-12">
          <h2 class="headline text-3xl mb-4 fade-in">Your Conservation Impact</h2>
          <p class="text-gray-600 fade-in">Your focus sessions have contributed to real-world conservation efforts</p>
        </div>
        
        <div class="flex flex-wrap -mx-2 mb-10">
          <div class="w-full md:w-1/3 px-2 mb-4 fade-in">
            <div class="interactive-card bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 text-center h-full">
              <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center text-green-600 mb-4 float">
                <i class="fas fa-tree text-2xl"></i>
              </div>
              <h4 class="text-2xl font-semibold text-gray-800 mb-1 stats-card" data-stats-value="12">
                <span class="stats-number">0</span>
              </h4>
              <p class="text-gray-600">Trees Planted</p>
            </div>
          </div>
          
          <div class="w-full md:w-1/3 px-2 mb-4 fade-in">
            <div class="interactive-card bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 text-center h-full">
              <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center text-blue-600 mb-4 float" style="animation-delay: -2s">
                <i class="fas fa-paw text-2xl"></i>
              </div>
              <h4 class="text-2xl font-semibold text-gray-800 mb-1 stats-card" data-stats-value="4">
                <span class="stats-number">0</span>
              </h4>
              <p class="text-gray-600">Wildlife Protected</p>
            </div>
          </div>
          
          <div class="w-full md:w-1/3 px-2 mb-4 fade-in">
            <div class="interactive-card bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg p-6 text-center h-full">
              <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center text-amber-600 mb-4 float" style="animation-delay: -4s">
                <i class="fas fa-hand-holding-heart text-2xl"></i>
              </div>
              <h4 class="text-2xl font-semibold text-gray-800 mb-1 stats-card" data-stats-value="2">
                <span class="stats-number">0</span>
              </h4>
              <p class="text-gray-600">Donations Made</p>
            </div>
          </div>
        </div>
        
      </div>
    </section>
    
    
  </div>

  <!-- Initialize Scripts -->
  <script>
    // Initialize particles.js
    document.addEventListener('DOMContentLoaded', function() {
      particlesJS('particles-js', {
        "particles": {
          "number": {
            "value": 80,
            "density": {
              "enable": true,
              "value_area": 800
            }
          },
          "color": {
            "value": "#ffffff"
          },
          "shape": {
            "type": "circle",
            "stroke": {
              "width": 0,
              "color": "#000000"
            }
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
            "speed": 1,
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
            },
            "resize": true
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
              "particles_nb": 4
            }
          }
        },
        "retina_detect": true
      });
      
      // Initialize 3D scene
      initThreeJS();
      
      // Initialize GSAP animations
      initGSAP();
      
      // Custom cursor follower
      initCursorFollower();
      
      // Initialize scroll animations
      initScrollAnimations();
      
      // Animate stats numbers
      initStatsAnimation();
      
      // Egg wobble animation
      initEggAnimation();
    });
    
    // Initialize Three.js scene
    function initThreeJS() {
      const container = document.getElementById('scene-container');
      
      if (!container) return;
      
      // Create scene, camera and renderer
      const scene = new THREE.Scene();
      const camera = new THREE.PerspectiveCamera(70, window.innerWidth / window.innerHeight, 0.1, 1000);
      const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
      
      renderer.setSize(window.innerWidth, window.innerHeight);
      renderer.setPixelRatio(window.devicePixelRatio);
      container.appendChild(renderer.domElement);
      
      // Add lights
      const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
      scene.add(ambientLight);
      
      const pointLight = new THREE.PointLight(0xffffff, 0.5);
      pointLight.position.set(5, 5, 5);
      scene.add(pointLight);
      
      // Create particles
      const particlesGeometry = new THREE.BufferGeometry();
      const particlesCount = 500;
      
      const posArray = new Float32Array(particlesCount * 3);
      
      for (let i = 0; i < particlesCount * 3; i++) {
        posArray[i] = (Math.random() - 0.5) * 10;
      }
      
      particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
      
      const particlesMaterial = new THREE.PointsMaterial({
        size: 0.01,
        color: 0x4D724D,
        transparent: true,
        opacity: 0.8
      });
      
      const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
      scene.add(particlesMesh);
      
      // Position camera
      camera.position.z = 5;
      
      // Animation loop
      const animate = () => {
        requestAnimationFrame(animate);
        
        particlesMesh.rotation.x += 0.0005;
        particlesMesh.rotation.y += 0.0005;
        
        renderer.render(scene, camera);
      };
      
      animate();
      
      // Handle window resize
      window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
      });
    }
    
    // Initialize GSAP animations
    function initGSAP() {
      // Welcome text animation
      gsap.from("#welcome-text", {
        y: -50,
        opacity: 0,
        duration: 1.5,
        ease: "elastic.out(1, 0.5)"
      });
      
      // Setup scroll triggers
      gsap.registerPlugin(ScrollTrigger);
      
      // Creature cards animation
      gsap.utils.toArray(".creature-container").forEach((card, i) => {
        gsap.from(card, {
          y: 50,
          opacity: 0,
          duration: 0.8,
          delay: i * 0.2,
          scrollTrigger: {
            trigger: card,
            start: "top bottom-=100",
            toggleActions: "play none none none"
          }
        });
      });
    }
    
    // Custom cursor follower
    function initCursorFollower() {
      const cursor = document.querySelector('.cursor-follower');
      
      if (!cursor) return;
      
      document.addEventListener('mousemove', (e) => {
        gsap.to(cursor, {
          x: e.clientX,
          y: e.clientY,
          duration: 0.2
        });
      });
      
      // Expand cursor on hoverable elements
      const hoverables = document.querySelectorAll('a, button, .interactive-card, .creature-container');
      
      hoverables.forEach(hoverable => {
        hoverable.addEventListener('mouseenter', () => {
          gsap.to(cursor, {
            width: 60,
            height: 60,
            opacity: 0.3,
            duration: 0.3
          });
        });
        
        hoverable.addEventListener('mouseleave', () => {
          gsap.to(cursor, {
            width: 30,
            height: 30,
            opacity: 0.6,
            duration: 0.3
          });
        });
      });
    }
    
    // Initialize scroll animations
    function initScrollAnimations() {
      const fadeElements = document.querySelectorAll('.fade-in');
      
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('active');
            observer.unobserve(entry.target);
          }
        });
      }, observerOptions);
      
      fadeElements.forEach(element => {
        observer.observe(element);
      });
    }
    
    // Animate stats numbers
    function initStatsAnimation() {
      const statsCards = document.querySelectorAll('.stats-card');
      
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const card = entry.target;
            const targetValue = parseInt(card.dataset.statsValue);
            const numberElement = card.querySelector('.stats-number');
            const decimalElement = card.querySelector('.stats-decimal');
            
            if (numberElement) {
              animateNumber(numberElement, 0, targetValue);
            }
            
            if (decimalElement) {
              const decimalValue = (targetValue % 1) * 60;
              animateNumber(decimalElement, 0, Math.round(decimalValue));
            }
            
            observer.unobserve(card);
          }
        });
      }, observerOptions);
      
      statsCards.forEach(card => {
        observer.observe(card);
      });
    }
    
    // Animate a number from start to end
    function animateNumber(element, start, end) {
      let startTimestamp = null;
      const duration = 1500;
      
      const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const value = Math.floor(progress * (end - start) + start);
        
        element.textContent = value;
        
        if (progress < 1) {
          window.requestAnimationFrame(step);
        }
      };
      
      window.requestAnimationFrame(step);
    }
    
    // Egg wobble animation
    function initEggAnimation() {
      const egg = document.getElementById('mystery-egg');
      
      if (!egg) return;
      
      // GSAP animation for egg wobbling
      gsap.to(egg, {
        rotation: 10,
        duration: 1.5,
        repeat: -1,
        yoyo: true,
        ease: "power1.inOut"
      });
      
      // Occasional "crack" effect
      setInterval(() => {
        gsap.to(egg, {
          scale: 1.1,
          duration: 0.2,
          yoyo: true,
          repeat: 1,
          ease: "elastic.out(1, 0.3)"
        });
      }, 5000);
    }
  </script>
</body>
</html>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>