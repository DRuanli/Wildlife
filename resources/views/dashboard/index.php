<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>
<?php // include ROOT_PATH . '/resources/views/components/loading.php'; ?>

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
  
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <!-- Custom Styles -->
  <style>
    :root {
      --font-sans: 'Inter', sans-serif;
      --font-display: 'Playfair Display', serif;
      
      /* Core palette - inspired by Anthropic's muted tones */
      --color-bg: #F9F8F2;
      --color-text: #1A1A1A;
      --color-text-muted: #666666;
      --color-primary: #4D724D;
      --color-primary-light: #C4D7C4;
      --color-primary-dark: #2F4F2F;
      --color-accent: #CE6246;
      --color-accent-light: #F7D9D0;
      
      /* Status colors */
      --color-focus: #4A6FA5;
      --color-focus-light: #D9E5F1;
      --color-streak: #CE8550;
      --color-streak-light: #F9E9D9;
      --color-coins: #C9A227;
      --color-coins-light: #F8F1D9;
      --color-conservation: #4E8D89;
      --color-conservation-light: #DBE9E8;
      
      /* Habitat colors */
      --color-forest: #2d6a4f;
      --color-ocean: #1e40af;
      --color-mountain: #7f1d1d;
      --color-sky: #0369a1;
      --color-cosmic: #4c1d95;
      --color-enchanted: #9d174d;
    }
    
    body {
      font-family: var(--font-sans);
      background-color: var(--color-bg);
      color: var(--color-text);
      line-height: 1.5;
    }
    
    .headline {
      font-family: var(--font-display);
      font-weight: 500;
    }
    
    .headline-large {
      font-size: 2.5rem;
      line-height: 1.2;
    }
    
    .headline-medium {
      font-size: 1.875rem;
      line-height: 1.25;
    }
    
    .headline-small {
      font-size: 1.5rem;
      line-height: 1.3;
    }
    
    .stat-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    /* Custom animation for progress circles */
    @keyframes progress-fill {
      from { stroke-dashoffset: var(--start-offset); }
      to { stroke-dashoffset: var(--end-offset); }
    }
    
    /* Custom animation for floating elements */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }
    
    /* Custom animation for fade-in elements */
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-float {
      animation: float 6s ease-in-out infinite;
    }
    
    .animate-fade-in {
      animation: fade-in 0.8s ease-out forwards;
    }
    
    /* Tab transition styles */
    .tab-content {
      transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    .chart-container {
      position: relative;
      height: 300px;
    }
    
    /* Creature card styles */
    .creature-card {
      transition: all 0.3s ease;
      transform-style: preserve-3d;
    }
    
    .creature-card:hover {
      transform: translateY(-8px) rotate3d(1, 1, 0, 5deg);
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }
    
    ::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.05);
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.2);
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: rgba(0, 0, 0, 0.3);
    }
    
    /* Focus Button Pulse Effect */
    .focus-button {
      position: relative;
    }
    
    .focus-button::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      border-radius: 0.5rem;
      background-color: var(--color-accent);
      z-index: -1;
      opacity: 0.7;
      transform: scale(1);
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0% { opacity: 0.7; transform: scale(1); }
      70% { opacity: 0; transform: scale(1.1); }
      100% { opacity: 0; transform: scale(1.1); }
    }
  </style>
</head>

<body>
  <!-- Main Dashboard Container -->
  <div class="min-h-screen pb-12">
    <!-- Welcome Banner -->
    <div class="relative bg-gradient-to-r from-emerald-800 to-emerald-700 text-white overflow-hidden">
      <!-- Decorative pattern -->
      <div class="absolute inset-0 opacity-10">
        <svg viewBox="0 0 100 100" class="absolute inset-0 h-full w-full" preserveAspectRatio="none">
          <defs>
            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
              <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
            </pattern>
          </defs>
          <rect width="100" height="100" fill="url(#grid)"/>
        </svg>
      </div>
      
      <div class="container mx-auto px-4 py-12 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="mb-6 md:mb-0 animate-fade-in" style="--animation-delay: 0.1s;">
            <h1 class="headline headline-large mb-2">Welcome back, <?php echo $user['username']; ?>!</h1>
            <p class="text-emerald-100 text-lg max-w-xl">Your wildlife sanctuary awaits your attention. Continue your focus journey and see your creatures thrive.</p>
          </div>
          
          <div class="flex gap-4 animate-fade-in" style="--animation-delay: 0.3s;">
            <a href="<?= $baseUrl ?>/focus" class="focus-button relative px-6 py-3 bg-white text-emerald-700 rounded-lg font-medium shadow-lg overflow-hidden transition-all duration-300 hover:bg-emerald-50 hover:shadow-xl z-10">
              <span class="flex items-center">
                <i class="fas fa-clock mr-2 text-lg"></i>
                Start Focus Session
              </span>
            </a>
            
            <a href="<?= $baseUrl ?>/shop" class="px-6 py-3 bg-emerald-900 text-white rounded-lg font-medium shadow-md overflow-hidden transition-all duration-300 hover:bg-emerald-950 hover:shadow-lg">
              <span class="flex items-center">
                <i class="fas fa-coins mr-2 text-lg"></i>
                Shop
              </span>
            </a>
          </div>
        </div>
      </div>
      
      <!-- Wave decoration at bottom -->
      <div class="absolute bottom-0 left-0 right-0 h-8 overflow-hidden">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="absolute bottom-0 w-full h-full">
          <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C50.45,0,113.73,20.09,171.52,38.9,253.82,67.9,297.49,69.21,321.39,56.44Z" fill="white" opacity="0.8"></path>
        </svg>
      </div>
    </div>

    <!-- Dashboard Content -->
    <div class="container mx-auto px-4 -mt-6">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Focus Time Card -->
        <div class="stat-card bg-white rounded-xl shadow-md p-6 relative overflow-hidden animate-fade-in" style="--animation-delay: 0.2s; border-top: 4px solid var(--color-focus);">
          <!-- Subtle background pattern -->
          <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
              <pattern id="focus-pattern" width="30" height="30" patternUnits="userSpaceOnUse">
                <circle cx="15" cy="15" r="10" fill="none" stroke="currentColor" stroke-width="1"/>
              </pattern>
              <rect width="100%" height="100%" fill="url(#focus-pattern)"/>
            </svg>
          </div>
          
          <div class="flex items-center relative z-10">
            <div class="p-3 rounded-full mr-4" style="background-color: var(--color-focus-light);">
              <i class="fas fa-hourglass-half text-xl" style="color: var(--color-focus);"></i>
            </div>
            <div>
              <p class="text-sm font-medium" style="color: var(--color-focus);">Total Focus Time</p>
              <div class="flex items-end">
                <p class="text-2xl font-bold text-gray-800">120</p>
                <p class="text-lg text-gray-600 ml-1">hours</p>
                <p class="text-lg font-bold text-gray-800 ml-2">30</p>
                <p class="text-lg text-gray-600 ml-1">mins</p>
              </div>
            </div>
          </div>
          
          <!-- Focus Time Progress Chart -->
          <div class="relative mt-4 h-16">
            <div class="absolute top-0 left-0 right-0 text-xs text-gray-400 flex justify-between">
              <span>Last 7 days</span>
              <span>+12.5% vs previous</span>
            </div>
            <canvas id="focusTimeChart" class="mt-4" width="100%" height="30"></canvas>
          </div>
        </div>
        
        <!-- Streak Card -->
        <div class="stat-card bg-white rounded-xl shadow-md p-6 relative overflow-hidden animate-fade-in" style="--animation-delay: 0.3s; border-top: 4px solid var(--color-streak);">
          <!-- Subtle background pattern -->
          <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
              <pattern id="streak-pattern" width="30" height="30" patternUnits="userSpaceOnUse">
                <path d="M0,15 L30,15 M15,0 L15,30" stroke="currentColor" stroke-width="1"/>
              </pattern>
              <rect width="100%" height="100%" fill="url(#streak-pattern)"/>
            </svg>
          </div>
          
          <div class="flex items-center relative z-10">
            <div class="p-3 rounded-full mr-4 relative" style="background-color: var(--color-streak-light);">
              <i class="fas fa-fire text-xl" style="color: var(--color-streak);"></i>
              <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-green-500 text-white text-xs font-bold animate-pulse">
                <i class="fas fa-arrow-up"></i>
              </span>
            </div>
            <div>
              <p class="text-sm font-medium" style="color: var(--color-streak);">Current Streak</p>
              <div class="flex items-end">
                <p class="text-2xl font-bold text-gray-800">14</p>
                <p class="text-lg text-gray-600 ml-1">days</p>
              </div>
            </div>
          </div>
          
          <!-- Streak Calendar -->
          <div class="mt-4 flex space-x-1 relative z-10">
            <!-- Previous 7 days + today -->
            <div class="flex-1">
              <div class="text-xs text-center text-gray-500 mb-1">Mon</div>
              <div class="aspect-square rounded-md flex items-center justify-center text-xs bg-orange-500 text-white">8</div>
            </div>
            <div class="flex-1">
              <div class="text-xs text-center text-gray-500 mb-1">Tue</div>
              <div class="aspect-square rounded-md flex items-center justify-center text-xs bg-orange-500 text-white">9</div>
            </div>
            <div class="flex-1">
              <div class="text-xs text-center text-gray-500 mb-1">Wed</div>
              <div class="aspect-square rounded-md flex items-center justify-center text-xs bg-orange-500 text-white">10</div>
            </div>
            <div class="flex-1">
              <div class="text-xs text-center text-gray-500 mb-1">Thu</div>
              <div class="aspect-square rounded-md flex items-center justify-center text-xs bg-orange-500 text-white">11</div>
            </div>
            <div class="flex-1">
              <div class="text-xs text-center text-gray-500 mb-1">Fri</div>
              <div class="aspect-square rounded-md flex items-center justify-center text-xs bg-orange-500 text-white">12</div>
            </div>
            <div class="flex-1">
              <div class="text-xs text-center text-gray-500 mb-1">Sat</div>
              <div class="aspect-square rounded-md flex items-center justify-center text-xs bg-orange-500 text-white">13</div>
            </div>
            <div class="flex-1">
              <div class="text-xs text-center text-gray-500 mb-1">Sun</div>
              <div class="aspect-square rounded-md flex items-center justify-center text-xs bg-orange-500 text-white ring-2 ring-orange-300">14</div>
            </div>
            <div class="flex-1">
              <div class="text-xs text-center text-gray-500 mb-1">Mon</div>
              <div class="aspect-square rounded-md flex items-center justify-center text-xs bg-gray-100 text-gray-400">15</div>
            </div>
          </div>
        </div>
        
        <!-- Coins Card -->
        <div class="stat-card bg-white rounded-xl shadow-md p-6 relative overflow-hidden animate-fade-in" style="--animation-delay: 0.4s; border-top: 4px solid var(--color-coins);">
          <!-- Subtle background pattern -->
          <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
              <pattern id="coin-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                <circle cx="10" cy="10" r="5" fill="none" stroke="currentColor" stroke-width="1"/>
              </pattern>
              <rect width="100%" height="100%" fill="url(#coin-pattern)"/>
            </svg>
          </div>
          
          <div class="flex items-center relative z-10">
            <div class="p-3 rounded-full mr-4" style="background-color: var(--color-coins-light);">
              <i class="fas fa-coins text-xl" style="color: var(--color-coins);"></i>
            </div>
            <div>
              <p class="text-sm font-medium" style="color: var(--color-coins);">Wild Coins</p>
              <div class="flex items-end">
                <p class="text-2xl font-bold text-gray-800">2,450</p>
                <p class="text-lg text-gray-600 ml-1">coins</p>
              </div>
            </div>
          </div>
          
          <!-- Coin Interactions -->
          <div class="mt-6 flex justify-between items-center relative z-10">
            <div class="text-sm text-gray-500">Available to spend</div>
            <a href="<?= $baseUrl ?>/shop" class="text-amber-600 hover:text-amber-700 text-sm font-medium flex items-center group">
              <span>Shop</span>
              <i class="fas fa-chevron-right ml-1 text-xs transition-transform transform group-hover:translate-x-1"></i>
            </a>
          </div>
          
          <!-- Recent Coins Activity -->
          <div class="mt-2 text-xs text-gray-400">
            <span>+250 coins earned today</span>
          </div>
        </div>
        
        <!-- Conservation Impact Card -->
        <div class="stat-card bg-white rounded-xl shadow-md p-6 relative overflow-hidden animate-fade-in" style="--animation-delay: 0.5s; border-top: 4px solid var(--color-conservation);">
          <!-- Subtle background pattern -->
          <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
              <pattern id="leaf-pattern" width="30" height="30" patternUnits="userSpaceOnUse">
                <path d="M15,5 Q25,15 15,25 Q5,15 15,5" fill="none" stroke="currentColor" stroke-width="1"/>
              </pattern>
              <rect width="100%" height="100%" fill="url(#leaf-pattern)"/>
            </svg>
          </div>
          
          <div class="flex items-center relative z-10">
            <div class="p-3 rounded-full mr-4" style="background-color: var(--color-conservation-light);">
              <i class="fas fa-leaf text-xl" style="color: var(--color-conservation);"></i>
            </div>
            <div>
              <p class="text-sm font-medium" style="color: var(--color-conservation);">Conservation Impact</p>
              <div class="flex items-end">
                <p class="text-2xl font-bold text-gray-800">12</p>
                <p class="text-lg text-gray-600 ml-1">trees</p>
              </div>
            </div>
          </div>
          
          <!-- Conservation Progress -->
          <div class="mt-4 relative z-10">
            <div class="flex justify-between text-xs text-gray-500 mb-1">
              <span>Progress to next tree</span>
              <span>65%</span>
            </div>
            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full rounded-full" style="width: 65%; background-color: var(--color-conservation);"></div>
            </div>
            
            <!-- Next milestone estimate -->
            <div class="mt-2 text-xs text-gray-400 flex justify-between">
              <span>2.5 hours more focus needed</span>
              <a href="<?= $baseUrl ?>/conservation" class="text-teal-600 hover:underline">View impact</a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Dashboard Tabs -->
      <div class="mb-8 bg-white rounded-xl shadow-md overflow-hidden" x-data="{ activeTab: 'activity' }">
        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-200 bg-gray-50 px-2">
          <button @click="activeTab = 'activity'" 
                  :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'activity', 
                           'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'activity' }" 
                  class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
            <i class="fas fa-chart-line mr-2"></i>Activity
          </button>
          <button @click="activeTab = 'creatures'" 
                  :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'creatures', 
                           'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'creatures' }" 
                  class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
            <i class="fas fa-dragon mr-2"></i>Creatures
          </button>
          <button @click="activeTab = 'habitats'" 
                  :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'habitats', 
                           'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'habitats' }" 
                  class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
            <i class="fas fa-tree mr-2"></i>Habitats
          </button>
          <button @click="activeTab = 'achievements'" 
                  :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'achievements', 
                           'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'achievements' }" 
                  class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200">
            <i class="fas fa-trophy mr-2"></i>Achievements
          </button>
        </div>
        
        <!-- Tab Content -->
        <div class="p-6">
          <!-- Activity Tab -->
          <div x-show="activeTab === 'activity'" 
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform -translate-y-4"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               class="space-y-6 tab-content">
            <div class="flex flex-col lg:flex-row gap-6">
              <!-- Focus Time Chart -->
              <div class="w-full lg:w-2/3 bg-white rounded-lg border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                  <h3 class="text-lg font-semibold text-gray-800">Focus Trends</h3>
                  <div class="flex space-x-2">
                    <button class="px-3 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-600 focus:outline-none">Week</button>
                    <button class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 focus:outline-none">Month</button>
                    <button class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 focus:outline-none">Year</button>
                  </div>
                </div>
                <div class="chart-container">
                  <canvas id="weeklyFocusChart"></canvas>
                </div>
              </div>
              
              <!-- Recent Sessions -->
              <div class="w-full lg:w-1/3 bg-white rounded-lg border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                  <h3 class="text-lg font-semibold text-gray-800">Recent Sessions</h3>
                  <a href="<?= $baseUrl ?>/focus/history" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium group">
                    <span>View All</span>
                    <i class="fas fa-chevron-right ml-1 text-xs transition-transform transform group-hover:translate-x-1"></i>
                  </a>
                </div>
                
                <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                  <!-- Example Recent Sessions -->
                  <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-100 text-blue-600 mr-3">
                      <i class="fas fa-clock"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800 truncate">25 min focus session</p>
                      <p class="text-xs text-gray-500">Today, 10:30 AM</p>
                    </div>
                    <div>
                      <div class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">
                        92%
                      </div>
                    </div>
                  </div>
                  
                  <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-100 text-blue-600 mr-3">
                      <i class="fas fa-clock"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800 truncate">45 min focus session</p>
                      <p class="text-xs text-gray-500">Today, 8:15 AM</p>
                    </div>
                    <div>
                      <div class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">
                        88%
                      </div>
                    </div>
                  </div>
                  
                  <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-100 text-blue-600 mr-3">
                      <i class="fas fa-clock"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800 truncate">30 min focus session</p>
                      <p class="text-xs text-gray-500">Yesterday, 4:20 PM</p>
                    </div>
                    <div>
                      <div class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                        75%
                      </div>
                    </div>
                  </div>
                  
                  <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-100 text-blue-600 mr-3">
                      <i class="fas fa-clock"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800 truncate">50 min focus session</p>
                      <p class="text-xs text-gray-500">Yesterday, 2:00 PM</p>
                    </div>
                    <div>
                      <div class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">
                        95%
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Creatures Tab -->
          <div x-show="activeTab === 'creatures'"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform -translate-y-4"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               class="tab-content">
            <!-- Creature Collection Stats -->
            <div class="flex flex-wrap -mx-2 mb-6">
              <div class="w-full sm:w-1/5 px-2 mb-4">
                <div class="rounded-lg p-4 text-center border border-gray-200 bg-gray-50">
                  <h4 class="font-semibold text-lg text-gray-800">All Creatures</h4>
                  <p class="text-3xl font-bold text-emerald-600">8</p>
                </div>
              </div>
              <div class="w-full sm:w-1/5 px-2 mb-4">
                <div class="rounded-lg p-4 text-center border border-gray-200">
                  <h4 class="font-semibold text-sm text-gray-600">Eggs</h4>
                  <p class="text-2xl font-bold text-yellow-600">2</p>
                </div>
              </div>
              <div class="w-full sm:w-1/5 px-2 mb-4">
                <div class="rounded-lg p-4 text-center border border-gray-200">
                  <h4 class="font-semibold text-sm text-gray-600">Babies</h4>
                  <p class="text-2xl font-bold text-blue-600">3</p>
                </div>
              </div>
              <div class="w-full sm:w-1/5 px-2 mb-4">
                <div class="rounded-lg p-4 text-center border border-gray-200">
                  <h4 class="font-semibold text-sm text-gray-600">Adults</h4>
                  <p class="text-2xl font-bold text-purple-600">2</p>
                </div>
              </div>
              <div class="w-full sm:w-1/5 px-2 mb-4">
                <div class="rounded-lg p-4 text-center border border-gray-200">
                  <h4 class="font-semibold text-sm text-gray-600">Mythicals</h4>
                  <p class="text-2xl font-bold text-red-600">1</p>
                </div>
              </div>
            </div>
            
            <!-- Creature Gallery -->
            <div class="space-y-4">
              <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">My Creatures</h3>
                <a href="<?= $baseUrl ?>/creatures" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium group">
                  <span>View All</span>
                  <i class="fas fa-chevron-right ml-1 text-xs transition-transform transform group-hover:translate-x-1"></i>
                </a>
              </div>
              
              <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <!-- Creature Cards -->
                <div class="creature-card bg-white rounded-lg border border-gray-200 overflow-hidden">
                  <div class="h-24 flex items-center justify-center p-2 bg-blue-50 relative overflow-hidden">
                    <!-- Animated background waves for water creature -->
                    <div class="absolute inset-0 opacity-20">
                      <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                        <path d="M0,50 Q25,40 50,50 Q75,60 100,50 L100,100 L0,100 Z" fill="#3B82F6" class="animate-pulse">
                          <animate attributeName="d" values="M0,50 Q25,40 50,50 Q75,60 100,50 L100,100 L0,100 Z; M0,50 Q25,60 50,50 Q75,40 100,50 L100,100 L0,100 Z; M0,50 Q25,40 50,50 Q75,60 100,50 L100,100 L0,100 Z" dur="10s" repeatCount="indefinite" />
                        </path>
                      </svg>
                    </div>
                    
                    <img src="/images/creatures/2_adult.png" alt="Water Dragon" class="h-20 w-20 object-contain relative z-10 animate-float" />
                  </div>
                  <div class="p-2 text-center">
                    <h4 class="font-medium text-sm truncate" title="Aquaris">
                      Aquaris
                    </h4>
                    <p class="text-xs text-gray-500 capitalize">adult</p>
                    
                    <!-- Health/Happiness Indicators -->
                    <div class="flex justify-center mt-1 space-x-2">
                      <div class="flex items-center">
                        <i class="fas fa-heart text-red-500 text-xs mr-1"></i>
                        <div class="h-1 w-12 bg-gray-200 rounded-full overflow-hidden">
                          <div class="h-full bg-red-500 rounded-full" style="width: 80%"></div>
                        </div>
                      </div>
                      <div class="flex items-center">
                        <i class="fas fa-smile text-yellow-500 text-xs mr-1"></i>
                        <div class="h-1 w-12 bg-gray-200 rounded-full overflow-hidden">
                          <div class="h-full bg-yellow-500 rounded-full" style="width: 90%"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <a href="/creatures/view/1" class="block text-xs text-center py-1 bg-gray-50 hover:bg-gray-100 text-gray-600 transition-colors">
                    View Details
                  </a>
                </div>
                
                <div class="creature-card bg-white rounded-lg border border-gray-200 overflow-hidden">
                  <div class="h-24 flex items-center justify-center p-2 bg-purple-50 relative overflow-hidden">
                    <!-- Animated stars for cosmic creature -->
                    <div class="absolute inset-0 opacity-20">
                      <div class="absolute h-2 w-2 bg-purple-500 rounded-full" style="top: 15%; left: 20%; animation: pulse 3s infinite;"></div>
                      <div class="absolute h-1 w-1 bg-purple-500 rounded-full" style="top: 25%; left: 80%; animation: pulse 4s infinite;"></div>
                      <div class="absolute h-1.5 w-1.5 bg-purple-500 rounded-full" style="top: 65%; left: 35%; animation: pulse 5s infinite;"></div>
                      <div class="absolute h-1 w-1 bg-purple-500 rounded-full" style="top: 75%; left: 75%; animation: pulse 2.5s infinite;"></div>
                    </div>
                    
                    <img src="/images/creatures/5_mythical.png" alt="Cosmic Dragon" class="h-20 w-20 object-contain relative z-10 animate-float" />
                  </div>
                  <div class="p-2 text-center">
                    <h4 class="font-medium text-sm truncate" title="Starshifter">
                      Starshifter
                    </h4>
                    <p class="text-xs text-gray-500 capitalize">mythical</p>
                    
                    <!-- Special Status for Mythical -->
                    <div class="mt-1">
                      <span class="text-xs rounded-full px-2 py-0.5 bg-purple-100 text-purple-800">Max Level</span>
                    </div>
                  </div>
                  <a href="/creatures/view/2" class="block text-xs text-center py-1 bg-gray-50 hover:bg-gray-100 text-gray-600 transition-colors">
                    View Details
                  </a>
                </div>
                
                <div class="creature-card bg-white rounded-lg border border-gray-200 overflow-hidden">
                  <div class="h-24 flex items-center justify-center p-2 bg-green-50 relative overflow-hidden">
                    <!-- Animated leaves for forest creature -->
                    <div class="absolute inset-0 opacity-20">
                      <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                        <path d="M20,20 Q30,5 40,20 Q50,35 60,20 Q70,5 80,20" stroke="#22c55e" stroke-width="1" fill="none">
                          <animate attributeName="d" values="M20,20 Q30,5 40,20 Q50,35 60,20 Q70,5 80,20; M20,25 Q30,10 40,25 Q50,40 60,25 Q70,10 80,25; M20,20 Q30,5 40,20 Q50,35 60,20 Q70,5 80,20" dur="8s" repeatCount="indefinite" />
                        </path>
                      </svg>
                    </div>
                    
                    <img src="/images/creatures/1_baby.png" alt="Forest Sprite" class="h-20 w-20 object-contain relative z-10 animate-float" />
                  </div>
                  <div class="p-2 text-center">
                    <h4 class="font-medium text-sm truncate" title="Leafling">
                      Leafling
                    </h4>
                    <p class="text-xs text-gray-500 capitalize">baby</p>
                    
                    <!-- Growth Progress Bar -->
                    <div class="mt-1">
                      <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-400 rounded-full" style="width: 45%"></div>
                      </div>
                    </div>
                  </div>
                  <a href="/creatures/view/3" class="block text-xs text-center py-1 bg-gray-50 hover:bg-gray-100 text-gray-600 transition-colors">
                    View Details
                  </a>
                </div>
                
                <div class="creature-card bg-white rounded-lg border border-gray-200 overflow-hidden">
                  <div class="h-24 flex items-center justify-center p-2 bg-yellow-50 relative overflow-hidden">
                    <!-- Egg wobble animation -->
                    <div class="relative">
                      <i class="fas fa-egg text-yellow-400 text-4xl animate-pulse"></i>
                      <div class="absolute -top-1 -right-1 h-3 w-3 bg-green-400 rounded-full animate-ping"></div>
                    </div>
                  </div>
                  <div class="p-2 text-center">
                    <h4 class="font-medium text-sm truncate" title="Mystery Egg">
                      Mystery Egg
                    </h4>
                    <p class="text-xs text-gray-500 capitalize">egg</p>
                    
                    <!-- Hatching Progress Bar -->
                    <div class="mt-1">
                      <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-400 rounded-full" style="width: 85%"></div>
                      </div>
                      <p class="text-xs text-gray-400 mt-0.5">Ready to hatch!</p>
                    </div>
                  </div>
                  <a href="/creatures/hatch/4" class="block text-xs text-center py-1 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 transition-colors">
                    Hatch Now
                  </a>
                </div>
                
                <!-- View More Card -->
                <div class="bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center">
                  <a href="<?= $baseUrl ?>/creatures" class="text-emerald-600 hover:text-emerald-700 p-4 text-center">
                    <i class="fas fa-plus-circle text-2xl mb-2"></i>
                    <p class="text-sm">View 4 more</p>
                  </a>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Habitats Tab -->
          <div x-show="activeTab === 'habitats'" 
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform -translate-y-4"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               class="tab-content">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-semibold text-gray-800">My Habitats</h3>
              <a href="<?= $baseUrl ?>/habitats" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium group">
                <span>View All</span>
                <i class="fas fa-chevron-right ml-1 text-xs transition-transform transform group-hover:translate-x-1"></i>
              </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <!-- Forest Habitat Card -->
              <div class="relative overflow-hidden rounded-xl shadow-md border border-gray-100 group transition-all hover:shadow-lg">
                <!-- Habitat Background -->
                <div class="h-40 bg-gradient-to-br from-green-100 to-green-200 p-4 relative">
                  <!-- Habitat Pattern Overlay -->
                  <div class="absolute inset-0 opacity-10 bg-forest-pattern"></div>
                  
                  <!-- Habitat Creatures Preview -->
                  <div class="absolute bottom-0 right-0 p-4 flex items-center space-x-1">
                    <div class="flex -space-x-2">
                      <div class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-forest">
                        <i class="fas fa-dragon text-sm"></i>
                      </div>
                      <div class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-forest">
                        <i class="fas fa-dragon text-sm"></i>
                      </div>
                      <div class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-forest">
                        <i class="fas fa-dragon text-sm"></i>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Habitat Type Badge -->
                  <div class="absolute top-2 left-2">
                    <div class="px-2 py-1 rounded-full bg-white bg-opacity-80 text-xs font-medium text-green-600 capitalize">
                      Forest Habitat
                    </div>
                  </div>
                </div>
                
                <!-- Habitat Info -->
                <div class="p-4 bg-white">
                  <div class="flex justify-between items-center">
                    <h4 class="font-medium text-gray-800 capitalize">Forest Haven</h4>
                    <div class="px-2 py-0.5 bg-gray-100 rounded-full text-xs text-gray-700">
                      Level 3
                    </div>
                  </div>
                  
                  <!-- Habitat Stats -->
                  <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="bg-gray-50 p-2 rounded">
                      <p class="text-xs text-gray-500">Creatures</p>
                      <p class="font-medium">3</p>
                    </div>
                    <div class="bg-gray-50 p-2 rounded">
                      <p class="text-xs text-gray-500">Expansion</p>
                      <p class="font-medium">2/5</p>
                    </div>
                  </div>
                  
                  <!-- View Button -->
                  <a href="/habitats/view/1" class="block w-full text-center py-2 mt-3 text-sm font-medium text-green-600 hover:text-green-800 transition-colors">
                    Visit Habitat
                  </a>
                </div>
              </div>

              <!-- Ocean Habitat Card -->
              <div class="relative overflow-hidden rounded-xl shadow-md border border-gray-100 group transition-all hover:shadow-lg">
                <!-- Habitat Background -->
                <div class="h-40 bg-gradient-to-br from-blue-100 to-blue-200 p-4 relative">
                  <!-- Habitat Pattern Overlay -->
                  <div class="absolute inset-0 opacity-10 bg-ocean-pattern"></div>
                  
                  <!-- Habitat Creatures Preview -->
                  <div class="absolute bottom-0 right-0 p-4 flex items-center space-x-1">
                    <div class="flex -space-x-2">
                      <div class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-ocean">
                        <i class="fas fa-dragon text-sm"></i>
                      </div>
                      <div class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-ocean">
                        <i class="fas fa-dragon text-sm"></i>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Habitat Type Badge -->
                  <div class="absolute top-2 left-2">
                    <div class="px-2 py-1 rounded-full bg-white bg-opacity-80 text-xs font-medium text-blue-600 capitalize">
                      Ocean Habitat
                    </div>
                  </div>
                </div>
                
                <!-- Habitat Info -->
                <div class="p-4 bg-white">
                  <div class="flex justify-between items-center">
                    <h4 class="font-medium text-gray-800 capitalize">Coral Reef</h4>
                    <div class="px-2 py-0.5 bg-gray-100 rounded-full text-xs text-gray-700">
                      Level 2
                    </div>
                  </div>
                  
                  <!-- Habitat Stats -->
                  <div class="grid grid-cols-2 gap-2 mt-3">
                    <div class="bg-gray-50 p-2 rounded">
                      <p class="text-xs text-gray-500">Creatures</p>
                      <p class="font-medium">2</p>
                    </div>
                    <div class="bg-gray-50 p-2 rounded">
                      <p class="text-xs text-gray-500">Expansion</p>
                      <p class="font-medium">1/5</p>
                    </div>
                  </div>
                  
                  <!-- View Button -->
                  <a href="/habitats/view/2" class="block w-full text-center py-2 mt-3 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                    Visit Habitat
                  </a>
                </div>
              </div>
              
              <!-- Create New Habitat Card -->
              <div class="relative overflow-hidden rounded-xl border border-dashed border-gray-300 flex flex-col items-center justify-center p-6 bg-gray-50 text-center hover:bg-gray-100 transition">
                <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                  <i class="fas fa-plus text-emerald-600 text-xl"></i>
                </div>
                <h4 class="font-medium text-gray-800 mb-2">Create New Habitat</h4>
                <p class="text-sm text-gray-500 mb-4">Add a new home for your creatures</p>
                <a href="<?= $baseUrl ?>/habitats/create" class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium shadow-sm hover:bg-emerald-700 transition">
                  Create Habitat
                </a>
              </div>
            </div>
          </div>
          
          <!-- Achievements Tab -->
          <div x-show="activeTab === 'achievements'" 
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform -translate-y-4"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               class="tab-content">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-semibold text-gray-800">My Achievements</h3>
              <div class="text-sm text-gray-500">
                <span class="font-medium text-emerald-600">15</span> / 36 completed
              </div>
            </div>
            
            <!-- Achievement Categories -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <!-- Focus Category -->
              <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-4 bg-blue-50 border-b border-gray-200">
                  <h4 class="font-medium flex items-center">
                    <i class="fas fa-clock text-blue-500 mr-2"></i>
                    Focus Achievements
                  </h4>
                </div>
                <div class="p-4 space-y-3">
                  <!-- Completed Achievement -->
                  <div class="flex items-center p-2 rounded border border-gray-100">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 mr-3">
                      <i class="fas fa-hourglass text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">First Timer</p>
                      <p class="text-xs text-gray-500">Complete your first focus session</p>
                    </div>
                    <div class="h-5 w-5 rounded-full bg-blue-500 flex items-center justify-center">
                      <i class="fas fa-check text-white text-xs"></i>
                    </div>
                  </div>
                  
                  <!-- Completed Achievement -->
                  <div class="flex items-center p-2 rounded border border-gray-100">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 mr-3">
                      <i class="fas fa-hourglass-half text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">Focus Apprentice</p>
                      <p class="text-xs text-gray-500">Complete 10 focus sessions</p>
                    </div>
                    <div class="h-5 w-5 rounded-full bg-blue-500 flex items-center justify-center">
                      <i class="fas fa-check text-white text-xs"></i>
                    </div>
                  </div>
                  
                  <!-- In-progress Achievement -->
                  <div class="flex items-center p-2 rounded border border-gray-100 bg-gray-50">
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 mr-3">
                      <i class="fas fa-hourglass-end text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">Focus Master</p>
                      <p class="text-xs text-gray-500">Complete 100 focus sessions</p>
                      <div class="mt-1 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500" style="width: 62%"></div>
                      </div>
                    </div>
                    <div class="h-5 w-5 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 text-xs">
                      62%
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Creature Category -->
              <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-4 bg-purple-50 border-b border-gray-200">
                  <h4 class="font-medium flex items-center">
                    <i class="fas fa-dragon text-purple-500 mr-2"></i>
                    Creature Achievements
                  </h4>
                </div>
                <div class="p-4 space-y-3">
                  <!-- Completed Achievement -->
                  <div class="flex items-center p-2 rounded border border-gray-100">
                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-500 mr-3">
                      <i class="fas fa-egg text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">First Hatch</p>
                      <p class="text-xs text-gray-500">Hatch your first creature</p>
                    </div>
                    <div class="h-5 w-5 rounded-full bg-purple-500 flex items-center justify-center">
                      <i class="fas fa-check text-white text-xs"></i>
                    </div>
                  </div>
                  
                  <!-- Locked Achievement -->
                  <div class="flex items-center p-2 rounded border border-gray-100 bg-gray-50">
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 mr-3">
                      <i class="fas fa-dragon text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">Dragon Tamer</p>
                      <p class="text-xs text-gray-500">Raise 5 creatures to adult stage</p>
                      <div class="mt-1 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-500" style="width: 40%"></div>
                      </div>
                    </div>
                    <div class="h-5 w-5 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 text-xs">
                      2/5
                    </div>
                  </div>
                  
                  <!-- Locked Achievement -->
                  <div class="flex items-center p-2 rounded border border-gray-100 bg-gray-50">
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 mr-3">
                      <i class="fas fa-crown text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">Mythical Master</p>
                      <p class="text-xs text-gray-500">Evolve a creature to mythical stage</p>
                    </div>
                    <div class="h-5 w-5 rounded-full bg-purple-500 flex items-center justify-center">
                      <i class="fas fa-check text-white text-xs"></i>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Conservation Category -->
              <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-4 bg-green-50 border-b border-gray-200">
                  <h4 class="font-medium flex items-center">
                    <i class="fas fa-leaf text-green-500 mr-2"></i>
                    Conservation Achievements
                  </h4>
                </div>
                <div class="p-4 space-y-3">
                  <!-- Completed Achievement -->
                  <div class="flex items-center p-2 rounded border border-gray-100">
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-500 mr-3">
                      <i class="fas fa-tree text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">First Tree</p>
                      <p class="text-xs text-gray-500">Help plant your first tree</p>
                    </div>
                    <div class="h-5 w-5 rounded-full bg-green-500 flex items-center justify-center">
                      <i class="fas fa-check text-white text-xs"></i>
                    </div>
                  </div>
                  
                  <!-- Completed Achievement -->
                  <div class="flex items-center p-2 rounded border border-gray-100">
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-500 mr-3">
                      <i class="fas fa-seedling text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">Growing Forest</p>
                      <p class="text-xs text-gray-500">Plant 10 trees through your focus</p>
                    </div>
                    <div class="h-5 w-5 rounded-full bg-green-500 flex items-center justify-center">
                      <i class="fas fa-check text-white text-xs"></i>
                    </div>
                  </div>
                  
                  <!-- In-progress Achievement -->
                  <div class="flex items-center p-2 rounded border border-gray-100 bg-gray-50">
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 mr-3">
                      <i class="fas fa-globe-americas text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">Earth Guardian</p>
                      <p class="text-xs text-gray-500">Plant 25 trees through your focus</p>
                      <div class="mt-1 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500" style="width: 48%"></div>
                      </div>
                    </div>
                    <div class="h-5 w-5 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 text-xs">
                      12/25
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Conservation Impact Section -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-teal-700 to-emerald-700 text-white px-6 py-4">
          <h2 class="text-xl font-bold">Your Conservation Impact</h2>
        </div>
        
        <div class="p-6">
          <div class="flex flex-wrap -mx-2">
            <div class="w-full md:w-1/3 px-2 mb-4">
              <div class="group bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 text-center hover:shadow-md transition-all relative overflow-hidden">
                <div class="absolute inset-0 bg-green-200 transform scale-y-0 origin-bottom transition-transform group-hover:scale-y-100 z-0"></div>
                <div class="relative z-10">
                  <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center text-green-600 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-tree text-2xl"></i>
                  </div>
                  <h4 class="text-2xl font-semibold text-gray-800 group-hover:text-gray-900">12</h4>
                  <p class="text-gray-600 group-hover:text-gray-700">Trees Planted</p>
                </div>
              </div>
            </div>
            
            <div class="w-full md:w-1/3 px-2 mb-4">
              <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 text-center hover:shadow-md transition-all relative overflow-hidden">
                <div class="absolute inset-0 bg-blue-200 transform scale-y-0 origin-bottom transition-transform group-hover:scale-y-100 z-0"></div>
                <div class="relative z-10">
                  <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center text-blue-600 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-paw text-2xl"></i>
                  </div>
                  <h4 class="text-2xl font-semibold text-gray-800 group-hover:text-gray-900">4</h4>
                  <p class="text-gray-600 group-hover:text-gray-700">Wildlife Protected</p>
                </div>
              </div>
            </div>
            
            <div class="w-full md:w-1/3 px-2 mb-4">
              <div class="group bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg p-6 text-center hover:shadow-md transition-all relative overflow-hidden">
                <div class="absolute inset-0 bg-amber-200 transform scale-y-0 origin-bottom transition-transform group-hover:scale-y-100 z-0"></div>
                <div class="relative z-10">
                  <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center text-amber-600 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-hand-holding-heart text-2xl"></i>
                  </div>
                  <h4 class="text-2xl font-semibold text-gray-800 group-hover:text-gray-900">2</h4>
                  <p class="text-gray-600 group-hover:text-gray-700">Donations Made</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="mt-6 text-center">
            <p class="text-gray-600 mb-4">Your focus sessions have contributed to real-world conservation efforts. Keep going!</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
              <a href="<?= $baseUrl ?>/conservation" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-medium rounded-md hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-sm hover:shadow">
                <i class="fas fa-leaf mr-2"></i>
                Learn More About Conservation
              </a>
              
              <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-6 py-3 bg-white border border-emerald-600 text-emerald-700 font-medium rounded-md hover:bg-emerald-50 transition-all">
                <i class="fas fa-clock mr-2"></i>
                Start New Focus Session
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Nature Quote -->
      <div class="text-center mb-10 px-4">
        <blockquote class="italic text-gray-600 max-w-xl mx-auto">
          "In every walk with nature one receives far more than he seeks."
          <footer class="text-gray-500 mt-2 text-sm">- John Muir</footer>
        </blockquote>
      </div>
    </div>
  </div>

  <!-- Charts Initialization -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Focus Time Mini Chart
      const focusTimeCtx = document.getElementById('focusTimeChart').getContext('2d');
      
      new Chart(focusTimeCtx, {
        type: 'line',
        data: {
          labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
          datasets: [{
            label: 'Focus Minutes',
            data: [30, 45, 60, 35, 75, 55, 45],
            borderColor: '#4A6FA5',
            backgroundColor: 'rgba(74, 111, 165, 0.1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointRadius: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              enabled: false
            }
          },
          scales: {
            x: {
              display: false
            },
            y: {
              display: false,
              beginAtZero: true
            }
          },
          elements: {
            line: {
              cubicInterpolationMode: 'monotone'
            }
          }
        }
      });
      
      // Weekly Focus Chart
      const weeklyFocusCtx = document.getElementById('weeklyFocusChart').getContext('2d');
      
      new Chart(weeklyFocusCtx, {
        type: 'bar',
        data: {
          labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
          datasets: [
            {
              label: 'Duration (minutes)',
              data: [75, 95, 120, 85, 50, 90, 110],
              backgroundColor: 'rgba(45, 106, 79, 0.8)',
              borderRadius: 6
            },
            {
              label: 'Focus Score',
              data: [85, 92, 88, 75, 80, 87, 91],
              backgroundColor: 'rgba(99, 102, 241, 0.2)',
              borderColor: 'rgba(99, 102, 241, 0.8)',
              type: 'line',
              yAxisID: 'y1',
              tension: 0.3,
              pointBackgroundColor: 'rgba(99, 102, 241, 1)'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: {
            intersect: false,
            mode: 'index'
          },
          plugins: {
            legend: {
              position: 'top',
              labels: {
                usePointStyle: true,
                boxWidth: 6,
                font: {
                  size: 12
                }
              }
            },
            tooltip: {
              backgroundColor: 'rgba(255, 255, 255, 0.9)',
              titleColor: '#111827',
              bodyColor: '#374151',
              borderColor: '#E5E7EB',
              borderWidth: 1,
              cornerRadius: 8,
              boxPadding: 4,
              usePointStyle: true,
              callbacks: {
                labelColor: function(context) {
                  const color = context.dataset.backgroundColor;
                  return {
                    backgroundColor: typeof color === 'string' ? color : color[context.dataIndex]
                  };
                }
              }
            }
          },
          scales: {
            x: {
              grid: {
                display: false
              },
              ticks: {
                font: {
                  size: 12
                }
              }
            },
            y: {
              position: 'left',
              grid: {
                color: 'rgba(156, 163, 175, 0.1)'
              },
              ticks: {
                font: {
                  size: 12
                }
              },
              title: {
                display: true,
                text: 'Duration (minutes)',
                color: '#2D6A4F',
                font: {
                  size: 12,
                  weight: 'normal'
                }
              }
            },
            y1: {
              position: 'right',
              grid: {
                drawOnChartArea: false
              },
              min: 0,
              max: 100,
              ticks: {
                font: {
                  size: 12
                },
                callback: function(value) {
                  return value + '%';
                }
              },
              title: {
                display: true,
                text: 'Focus Score',
                color: '#6366F1',
                font: {
                  size: 12,
                  weight: 'normal'
                }
              }
            }
          }
        }
      });
    });

    // Hide loading screen when page is fully loaded
    window.addEventListener('load', function() {
    // Allow some minimum time for users to see the loading animations
    setTimeout(function() {
        window.hideLoadingScreen();
    }, 2000);
    });
  </script>

  
</body>
</html>
<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>