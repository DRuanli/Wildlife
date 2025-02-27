<?php
// Path: resources/views/errors/404.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Adventure Awaits | Wildlife Haven</title>
  
  <!-- Favicon -->
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  
  <!-- GSAP Animation Library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
  
  <!-- Three.js for 3D elements -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    :root {
      --primary: #3b82f6;
      --primary-dark: #2563eb;
      --secondary: #10b981;
      --accent: #f59e0b;
      --dark: #1e293b;
      --light: #f8fafc;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }
    
    /* Canvas for 3D animation */
    #animal-scene {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: -1;
    }
    
    /* Parallax effect */
    .parallax-layer {
      will-change: transform;
    }
    
    /* Custom cursor */
    .custom-cursor {
      position: fixed;
      width: 24px;
      height: 24px;
      background-color: rgba(59, 130, 246, 0.5);
      border-radius: 50%;
      pointer-events: none;
      z-index: 9999;
      transform: translate(-50%, -50%);
      mix-blend-mode: difference;
      transition: width 0.3s, height 0.3s, background-color 0.3s;
    }
    
    .custom-cursor-dot {
      position: fixed;
      width: 4px;
      height: 4px;
      background-color: rgba(59, 130, 246, 1);
      border-radius: 50%;
      pointer-events: none;
      z-index: 10000;
      transform: translate(-50%, -50%);
    }
    
    .cursor-grow {
      width: 48px;
      height: 48px;
      background-color: rgba(16, 185, 129, 0.5);
    }
    
    /* Interactive card */
    .interactive-card {
      transition: all 0.3s ease;
      transform-style: preserve-3d;
      perspective: 1000px;
    }
    
    .interactive-card-content {
      backface-visibility: hidden;
      transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Trail effect */
    .trail {
      position: absolute;
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background-color: var(--primary);
      pointer-events: none;
      opacity: 0;
    }
    
    /* Sound wave visualization */
    .sound-wave {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 40px;
    }
    
    .sound-wave span {
      display: inline-block;
      width: 3px;
      height: 100%;
      margin: 0 2px;
      background-color: var(--primary);
      border-radius: 3px;
      animation: sound-wave-animation 0.8s infinite ease-in-out;
    }
    
    @keyframes sound-wave-animation {
      0%, 100% { height: 8px; }
      50% { height: 32px; }
    }
    
    .sound-wave span:nth-child(1) { animation-delay: 0.0s; }
    .sound-wave span:nth-child(2) { animation-delay: 0.1s; }
    .sound-wave span:nth-child(3) { animation-delay: 0.2s; }
    .sound-wave span:nth-child(4) { animation-delay: 0.3s; }
    .sound-wave span:nth-child(5) { animation-delay: 0.4s; }
    .sound-wave span:nth-child(6) { animation-delay: 0.5s; }
    
    /* Interactive map */
    #wildlife-map {
      height: 300px;
      border-radius: 0.75rem;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    /* Weather widget */
    .weather-widget {
      background: linear-gradient(135deg, #60a5fa, #3b82f6);
      border-radius: 0.75rem;
      overflow: hidden;
      transform-style: preserve-3d;
      perspective: 1000px;
    }
    
    /* Day/night toggle */
    .theme-toggle {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 100;
    }
    
    .theme-toggle-button {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    /* Dark theme */
    .dark-theme {
      background-color: #0f172a;
      color: #f8fafc;
    }
    
    .dark-theme .card-bg {
      background-color: #1e293b;
    }
    
    /* Speech recognition styles */
    .voice-search {
      position: relative;
    }
    
    .voice-search-button {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
    }
    
    /* Loading animation */
    .loading-dots span {
      display: inline-block;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background-color: var(--primary);
      margin: 0 2px;
      animation: loading-dots 1.4s infinite ease-in-out both;
    }
    
    .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
    .loading-dots span:nth-child(2) { animation-delay: -0.16s; }
    
    @keyframes loading-dots {
      0%, 80%, 100% { transform: scale(0); }
      40% { transform: scale(1); }
    }
    
    /* Progress indicator */
    .progress-container {
      width: 100%;
      height: 4px;
      background-color: #e2e8f0;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
    }
    
    .progress-bar {
      height: 4px;
      background-color: var(--primary);
      width: 0%;
      transition: width 0.2s ease;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
  <!-- Progress indicator -->
  <div class="progress-container">
    <div class="progress-bar" id="progress-bar"></div>
  </div>
  
  <!-- Custom cursor -->
  <div class="custom-cursor" id="custom-cursor"></div>
  <div class="custom-cursor-dot" id="custom-cursor-dot"></div>
  
  <!-- Theme toggle -->
  <div class="theme-toggle">
    <div class="theme-toggle-button bg-white shadow-lg" id="theme-toggle">
      <i class="fas fa-moon text-indigo-600"></i>
    </div>
  </div>
  
  <!-- 3D background canvas -->
  <canvas id="animal-scene"></canvas>
  
  <div class="container mx-auto px-4 py-8 relative z-10">
    <!-- Header with animated elements -->
    <header class="text-center mb-12 pt-8">
      <div class="inline-block mb-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-blue-500 opacity-20 rounded-full"></div>
        <i class="fas fa-compass text-6xl text-blue-600 p-8 animate-pulse"></i>
      </div>
      <h1 class="text-5xl md:text-7xl font-bold text-blue-900 mb-4 tracking-tight parallax-layer" data-depth="0.2">404</h1>
      <p class="text-xl md:text-2xl text-blue-700 max-w-2xl mx-auto mb-6 parallax-layer" data-depth="0.1">
        Whoops! You've ventured into uncharted territory.
      </p>
      <div class="flex justify-center space-x-2 mb-8 sound-wave">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="flex flex-wrap justify-center gap-4">
        <button id="speak-button" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center transition transform hover:scale-105 shadow-lg">
          <i class="fas fa-volume-up mr-2"></i>
          Hear Message
        </button>
        <a href="/" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full flex items-center transition transform hover:scale-105 shadow-lg">
          <i class="fas fa-home mr-2"></i>
          Return Home
        </a>
      </div>
    </header>
    
    <!-- Interactive search with voice recognition -->
    <div class="max-w-2xl mx-auto mb-16">
      <div class="bg-white rounded-xl shadow-lg p-6 transform transition hover:shadow-xl card-bg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Find Your Way</h2>
        <div class="voice-search relative">
          <input 
            type="text" 
            id="search-input" 
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
            placeholder="Search or speak what you're looking for..."
          >
          <button class="voice-search-button" id="voice-search-button">
            <i class="fas fa-microphone text-gray-500 hover:text-blue-500 transition"></i>
          </button>
        </div>
        <div id="search-status" class="mt-2 text-sm text-gray-600 hidden">
          <div class="flex items-center">
            <div class="loading-dots mr-2">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <span>Listening...</span>
          </div>
        </div>
        <div id="search-results" class="mt-4 bg-gray-50 rounded-lg p-4 hidden">
          <h3 class="font-medium text-gray-800 mb-2">Quick Suggestions</h3>
          <ul class="space-y-2" id="suggestion-list"></ul>
        </div>
      </div>
    </div>
    
    <!-- Interactive biome explorer with animated cards -->
    <div class="mb-16">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Explore Wildlife Biomes</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Biome card 1 -->
        <div class="interactive-card group" data-tilt data-tilt-max="10">
          <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full interactive-card-content card-bg">
            <div class="relative overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-b from-transparent to-blue-900 opacity-70"></div>
              <img src="/api/placeholder/400/200" alt="Ocean" class="w-full h-48 object-cover transition group-hover:scale-110">
              <div class="absolute bottom-0 left-0 p-4 text-white">
                <h3 class="text-xl font-bold">Ocean Depths</h3>
              </div>
            </div>
            <div class="p-6">
              <p class="text-gray-600 mb-4">Discover the mysterious creatures of the deep blue sea.</p>
              <div class="flex justify-between items-center">
                <span class="text-sm text-blue-600">10+ Species</span>
                <button class="explore-button px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition">
                  Explore <i class="fas fa-arrow-right ml-1"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Biome card 2 -->
        <div class="interactive-card group" data-tilt data-tilt-max="10">
          <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full interactive-card-content card-bg">
            <div class="relative overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-b from-transparent to-green-900 opacity-70"></div>
              <img src="/api/placeholder/400/200" alt="Rainforest" class="w-full h-48 object-cover transition group-hover:scale-110">
              <div class="absolute bottom-0 left-0 p-4 text-white">
                <h3 class="text-xl font-bold">Rainforest</h3>
              </div>
            </div>
            <div class="p-6">
              <p class="text-gray-600 mb-4">Explore the lush canopy and diverse ecosystem of the rainforest.</p>
              <div class="flex justify-between items-center">
                <span class="text-sm text-green-600">24+ Species</span>
                <button class="explore-button px-4 py-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition">
                  Explore <i class="fas fa-arrow-right ml-1"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Biome card 3 -->
        <div class="interactive-card group" data-tilt data-tilt-max="10">
          <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full interactive-card-content card-bg">
            <div class="relative overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-b from-transparent to-amber-900 opacity-70"></div>
              <img src="/api/placeholder/400/200" alt="Savanna" class="w-full h-48 object-cover transition group-hover:scale-110">
              <div class="absolute bottom-0 left-0 p-4 text-white">
                <h3 class="text-xl font-bold">Savanna</h3>
              </div>
            </div>
            <div class="p-6">
              <p class="text-gray-600 mb-4">Witness the majestic animals of the African plains.</p>
              <div class="flex justify-between items-center">
                <span class="text-sm text-amber-600">15+ Species</span>
                <button class="explore-button px-4 py-2 bg-amber-100 text-amber-600 rounded-lg hover:bg-amber-200 transition">
                  Explore <i class="fas fa-arrow-right ml-1"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Interactive wildlife map and facts panel -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-16">
      <!-- Wildlife map -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg p-6 h-full card-bg">
          <h2 class="text-2xl font-bold text-gray-800 mb-4">Wildlife Around the World</h2>
          <div id="wildlife-map" class="relative">
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="text-center">
                <div class="loading-dots mb-4">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <p class="text-gray-600">Loading interactive map...</p>
              </div>
            </div>
            <img src="/api/placeholder/800/300" alt="World Map" class="w-full h-full object-cover rounded-lg">
          </div>
          <div class="mt-4 flex justify-between">
            <button class="px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition" id="toggle-map-view">
              <i class="fas fa-globe mr-1"></i> Change View
            </button>
            <div class="flex space-x-2">
              <button class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full hover:bg-gray-200 transition" id="zoom-in">
                <i class="fas fa-plus text-gray-600"></i>
              </button>
              <button class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full hover:bg-gray-200 transition" id="zoom-out">
                <i class="fas fa-minus text-gray-600"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Interactive facts widget -->
      <div>
        <div class="bg-white rounded-xl shadow-lg p-6 h-full card-bg">
          <h2 class="text-2xl font-bold text-gray-800 mb-4">Wildlife Discovery</h2>
          <div id="fact-carousel" class="relative overflow-hidden mb-4 h-64">
            <div class="absolute inset-0 transition-transform duration-300 transform translate-x-0" id="fact-slide-1">
              <div class="h-full flex flex-col">
                <div class="flex-shrink-0 mb-3">
                  <span class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm">Did you know?</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2" id="fact-title-1">Amazing Elephant Memory</h3>
                <p class="text-gray-600 mb-4" id="fact-content-1">Elephants have remarkable memories and can remember routes to watering holes over incredibly long distances and time periods.</p>
                <img src="/api/placeholder/400/150" alt="Elephant" class="w-full h-32 object-cover rounded-lg">
              </div>
            </div>
            <div class="absolute inset-0 transition-transform duration-300 transform translate-x-full" id="fact-slide-2">
              <div class="h-full flex flex-col">
                <div class="flex-shrink-0 mb-3">
                  <span class="inline-block px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm">Amazing Fact</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2" id="fact-title-2">Octopus Intelligence</h3>
                <p class="text-gray-600 mb-4" id="fact-content-2">Octopuses are highly intelligent and have been observed using tools, solving complex puzzles, and even mimicking other sea creatures.</p>
                <img src="/api/placeholder/400/150" alt="Octopus" class="w-full h-32 object-cover rounded-lg">
              </div>
            </div>
            <div class="absolute inset-0 transition-transform duration-300 transform translate-x-full" id="fact-slide-3">
              <div class="h-full flex flex-col">
                <div class="flex-shrink-0 mb-3">
                  <span class="inline-block px-3 py-1 bg-amber-100 text-amber-600 rounded-full text-sm">Fascinating</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2" id="fact-title-3">Cheetah Speed</h3>
                <p class="text-gray-600 mb-4" id="fact-content-3">Cheetahs can accelerate from 0 to 60 miles per hour in just three seconds, making them the fastest land animals.</p>
                <img src="/api/placeholder/400/150" alt="Cheetah" class="w-full h-32 object-cover rounded-lg">
              </div>
            </div>
          </div>
          <div class="flex justify-between items-center">
            <button id="prev-fact" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition">
              <i class="fas fa-arrow-left text-gray-600"></i>
            </button>
            <div class="flex space-x-2">
              <span class="w-2 h-2 rounded-full bg-blue-600" id="dot-1"></span>
              <span class="w-2 h-2 rounded-full bg-gray-300" id="dot-2"></span>
              <span class="w-2 h-2 rounded-full bg-gray-300" id="dot-3"></span>
            </div>
            <button id="next-fact" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition">
              <i class="fas fa-arrow-right text-gray-600"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Interactive wildlife chat assistant -->
    <div class="max-w-3xl mx-auto mb-16">
      <div class="bg-white rounded-xl shadow-lg overflow-hidden card-bg">
        <div class="p-6 border-b border-gray-200">
          <h2 class="text-2xl font-bold text-gray-800">Wildlife Guide Chat</h2>
          <p class="text-gray-600">Ask questions about wildlife and get instant answers</p>
        </div>
        <div class="p-6 bg-gray-50 h-64 overflow-y-auto" id="chat-messages">
          <div class="flex mb-4">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex-shrink-0 flex items-center justify-center">
              <i class="fas fa-robot text-blue-600"></i>
            </div>
            <div class="ml-3 bg-white p-3 rounded-lg shadow-sm max-w-md">
              <p class="text-gray-800">Hi there! I'm your wildlife guide. How can I help you explore the animal kingdom today?</p>
            </div>
          </div>
        </div>
        <div class="p-4 border-t border-gray-200">
          <div class="flex">
            <input 
              type="text" 
              id="chat-input" 
              class="flex-grow px-4 py-2 rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
              placeholder="Ask about wildlife..."
            >
            <button id="send-chat" class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition">
              <i class="fas fa-paper-plane"></i>
            </button>
          </div>
          <div class="mt-2 flex flex-wrap gap-2">
            <button class="quick-question px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition">What animals are endangered?</button>
            <button class="quick-question px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition">Tell me about tigers</button>
            <button class="quick-question px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm hover:bg-blue-100 transition">How do whales communicate?</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Interactive mini-game -->
    <div class="max-w-2xl mx-auto mb-16">
      <div class="bg-white rounded-xl shadow-lg p-6 card-bg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Wildlife Memory Challenge</h2>
        <p class="text-gray-600 mb-6">Test your memory with this fun animal matching game!</p>
        
        <div class="grid grid-cols-4 gap-3" id="memory-game">
          <!-- Cards are generated by JavaScript -->
        </div>
        
        <div class="mt-6 flex items-center justify-between">
          <div>
            <span class="text-gray-600">Moves: </span>
            <span class="font-semibold text-gray-800" id="move-counter">0</span>
          </div>
          <button id="reset-game" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-redo-alt mr-1"></i> Reset Game
          </button>
        </div>
      </div>
    </div>
    
    <!-- Newsletter with animation -->
    <div class="max-w-3xl mx-auto mb-16">
      <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg p-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
        
        <div class="relative z-10">
          <h2 class="text-3xl font-bold text-white mb-2">Stay in the Wild</h2>
          <p class="text-blue-100 mb-6">Join our newsletter for wildlife facts, conservation news, and more!</p>
          
          <form id="newsletter-form" class="flex flex-col sm:flex-row gap-3">
            <input 
              type="email" 
              id="email-input" 
              class="flex-grow px-4 py-3 rounded-lg border-0 focus:ring-2 focus:ring-blue-300 transition" 
              placeholder="Your email address"
              required
            >
            <button type="submit" class="px-6 py-3 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition shadow-md">
              Subscribe Now
            </button>
          </form>
          
          <div id="newsletter-success" class="mt-4 bg-blue-500 bg-opacity-30 p-3 rounded-lg text-blue-50 hidden">
            <div class="flex items-center">
              <i class="fas fa-check-circle mr-2"></i>
              <span>Thank you for subscribing! Check your email to confirm.</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Weather info widget -->
    <div class="max-w-xl mx-auto mb-16">
      <div class="weather-widget p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-bold">Wildlife Weather Conditions</h2>
          <i class="fas fa-cloud-sun text-2xl"></i>
        </div>
        <div class="flex flex-wrap gap-6">
          <div>
            <h3 class="text-sm font-medium mb-1">Savanna</h3>
            <div class="flex items-center">
              <span class="text-3xl font-bold">32°C</span>
              <span class="ml-2 text-sm">Sunny</span>
            </div>
          </div>
          <div>
            <h3 class="text-sm font-medium mb-1">Rainforest</h3>
            <div class="flex items-center">
              <span class="text-3xl font-bold">27°C</span>
              <span class="ml-2 text-sm">Rainy</span>
            </div>
          </div>
          <div>
            <h3 class="text-sm font-medium mb-1">Arctic</h3>
            <div class="flex items-center">
              <span class="text-3xl font-bold">-5°C</span>
              <span class="ml-2 text-sm">Snow</span>
            </div>
          </div>
        </div>
        <div class="mt-4 text-xs text-blue-100">Weather affects wildlife behavior and activity. Plan your virtual safari accordingly!</div>
      </div>
    </div>
  </div>
    
    <!-- Footer -->
  <footer class="bg-white py-8 border-t border-gray-200 card-bg">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Logo and about -->
        <div>
          <div class="flex items-center mb-4">
            <i class="fas fa-paw text-2xl text-blue-600 mr-2"></i>
            <h3 class="text-xl font-bold text-gray-800">Wildlife Haven</h3>
          </div>
          <p class="text-gray-600 mb-4">Exploring and preserving Earth's incredible biodiversity through education and conservation.</p>
          <div class="flex space-x-4">
            <a href="#" class="text-blue-600 hover:text-blue-800 transition">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="text-blue-600 hover:text-blue-800 transition">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="text-blue-600 hover:text-blue-800 transition">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="text-blue-600 hover:text-blue-800 transition">
              <i class="fab fa-youtube"></i>
            </a>
          </div>
        </div>
        
        <!-- Quick links -->
        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Explore</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Homepage</a></li>
            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Animal Encyclopedia</a></li>
            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Conservation Efforts</a></li>
            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Virtual Safari</a></li>
            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Educational Resources</a></li>
          </ul>
        </div>
        
        <!-- Support -->
        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Support</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Contact Us</a></li>
            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">FAQ</a></li>
            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Donate</a></li>
            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Volunteer</a></li>
            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Report Wildlife Crime</a></li>
          </ul>
        </div>
        
        <!-- App download -->
        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Mobile App</h3>
          <p class="text-gray-600 mb-4">Download our app for wildlife identification and tracking in the field.</p>
          <div class="flex flex-col space-y-2">
            <a href="#" class="bg-gray-900 text-white px-4 py-2 rounded-lg flex items-center hover:bg-gray-800 transition">
              <i class="fab fa-apple text-2xl mr-2"></i>
              <div>
                <div class="text-xs">Download on the</div>
                <div class="font-medium">App Store</div>
              </div>
            </a>
            <a href="#" class="bg-gray-900 text-white px-4 py-2 rounded-lg flex items-center hover:bg-gray-800 transition">
              <i class="fab fa-google-play text-2xl mr-2"></i>
              <div>
                <div class="text-xs">Get it on</div>
                <div class="font-medium">Google Play</div>
              </div>
            </a>
          </div>
        </div>
      </div>
      
      <div class="border-t border-gray-200 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-600 mb-4 md:mb-0">&copy; 2025 Wildlife Haven. All rights reserved.</p>
        <div class="flex space-x-6">
          <a href="#" class="text-gray-600 hover:text-blue-600 transition text-sm">Privacy Policy</a>
          <a href="#" class="text-gray-600 hover:text-blue-600 transition text-sm">Terms of Service</a>
          <a href="#" class="text-gray-600 hover:text-blue-600 transition text-sm">Cookie Policy</a>
          <a href="#" class="text-gray-600 hover:text-blue-600 transition text-sm">Accessibility</a>
        </div>
      </div>
    </div>
  </footer>
  
  <!-- JavaScript for interactive features -->
  <script>
    // Progress bar on scroll
    window.addEventListener('scroll', function() {
      const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
      const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const scrolled = (winScroll / height) * 100;
      document.getElementById('progress-bar').style.width = scrolled + '%';
    });
    
    // Custom cursor
    const cursor = document.getElementById('custom-cursor');
    const cursorDot = document.getElementById('custom-cursor-dot');
    
    document.addEventListener('mousemove', function(e) {
      cursor.style.left = e.clientX + 'px';
      cursor.style.top = e.clientY + 'px';
      cursorDot.style.left = e.clientX + 'px';
      cursorDot.style.top = e.clientY + 'px';
    });
    
    document.addEventListener('mousedown', function() {
      cursor.classList.add('cursor-grow');
    });
    
    document.addEventListener('mouseup', function() {
      cursor.classList.remove('cursor-grow');
    });
    
    // Dark mode toggle
    const themeToggle = document.getElementById('theme-toggle');
    themeToggle.addEventListener('click', function() {
      document.body.classList.toggle('dark-theme');
      
      const icon = themeToggle.querySelector('i');
      if (document.body.classList.contains('dark-theme')) {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
      } else {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
      }
    });
    
    // Initialize interactive cards
    document.querySelectorAll('.interactive-card').forEach(card => {
      card.addEventListener('mousemove', function(e) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        
        const rotateX = (y - centerY) / 10;
        const rotateY = (centerX - x) / 10;
        
        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
      });
      
      card.addEventListener('mouseleave', function() {
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
      });
    });
    
    // Wildlife facts carousel
    const factSlides = [
      document.getElementById('fact-slide-1'),
      document.getElementById('fact-slide-2'),
      document.getElementById('fact-slide-3')
    ];
    
    const dots = [
      document.getElementById('dot-1'),
      document.getElementById('dot-2'),
      document.getElementById('dot-3')
    ];
    
    let currentSlide = 0;
    
    function showSlide(index) {
      factSlides.forEach((slide, i) => {
        if (i === index) {
          slide.style.transform = 'translateX(0)';
          dots[i].classList.add('bg-blue-600');
          dots[i].classList.remove('bg-gray-300');
        } else {
          slide.style.transform = i < index ? 'translateX(-100%)' : 'translateX(100%)';
          dots[i].classList.add('bg-gray-300');
          dots[i].classList.remove('bg-blue-600');
        }
      });
    }
    
    document.getElementById('next-fact').addEventListener('click', function() {
      currentSlide = (currentSlide + 1) % factSlides.length;
      showSlide(currentSlide);
    });
    
    document.getElementById('prev-fact').addEventListener('click', function() {
      currentSlide = (currentSlide - 1 + factSlides.length) % factSlides.length;
      showSlide(currentSlide);
    });
    
    // Text-to-speech for 404 message
    document.getElementById('speak-button').addEventListener('click', function() {
      const message = "Whoops! You've ventured into uncharted territory. Let us help you find your way back.";
      const speech = new SpeechSynthesisUtterance(message);
      speechSynthesis.speak(speech);
    });
    
    // Voice search implementation
    const voiceSearchButton = document.getElementById('voice-search-button');
    const searchInput = document.getElementById('search-input');
    const searchStatus = document.getElementById('search-status');
    
    voiceSearchButton.addEventListener('click', function() {
      if ('webkitSpeechRecognition' in window) {
        const recognition = new webkitSpeechRecognition();
        recognition.continuous = false;
        recognition.interimResults = false;
        
        recognition.onstart = function() {
          searchStatus.classList.remove('hidden');
        };
        
        recognition.onresult = function(event) {
          const transcript = event.results[0][0].transcript;
          searchInput.value = transcript;
        };
        
        recognition.onend = function() {
          searchStatus.classList.add('hidden');
        };
        
        recognition.start();
      } else {
        alert('Voice search is not supported in your browser.');
      }
    });
    
    // Chat functionality
    const chatInput = document.getElementById('chat-input');
    const sendChatButton = document.getElementById('send-chat');
    const chatMessages = document.getElementById('chat-messages');
    
    function addChatMessage(message, isUser = false) {
      const messageDiv = document.createElement('div');
      messageDiv.className = 'flex mb-4' + (isUser ? ' justify-end' : '');
      
      let icon = isUser ? 'fa-user' : 'fa-robot';
      let bgColor = isUser ? 'bg-blue-600' : 'bg-blue-100';
      let textColor = isUser ? 'text-white' : 'text-blue-600';
      let messageBg = isUser ? 'bg-blue-600' : 'bg-white';
      let messageTextColor = isUser ? 'text-white' : 'text-gray-800';
      
      messageDiv.innerHTML = `
        <div class="w-10 h-10 rounded-full ${bgColor} flex-shrink-0 flex items-center justify-center ${isUser ? 'order-2 ml-3' : 'mr-3'}">
          <i class="fas ${icon} ${textColor}"></i>
        </div>
        <div class="${isUser ? 'mr-3' : 'ml-3'} ${messageBg} p-3 rounded-lg shadow-sm max-w-md">
          <p class="${messageTextColor}">${message}</p>
        </div>
      `;
      
      chatMessages.appendChild(messageDiv);
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    function processChat(message) {
      // Simple rule-based response for demo purposes
      let response;
      
      if (message.toLowerCase().includes('endangered')) {
        response = "Many species are endangered today, including tigers, pandas, rhinos, gorillas, and sea turtles. Conservation efforts are critical for their survival.";
      } else if (message.toLowerCase().includes('tiger')) {
        response = "Tigers are the largest cat species and one of the most recognizable animals. They're endangered with only about 3,900 left in the wild.";
      } else if (message.toLowerCase().includes('whale') && message.toLowerCase().includes('communicate')) {
        response = "Whales communicate through complex songs that can travel for miles underwater. Humpback whales are known for their elaborate songs that can last up to 30 minutes!";
      } else {
        response = "That's an interesting wildlife question! I recommend checking our animal encyclopedia for detailed information on that topic.";
      }
      
      setTimeout(() => {
        addChatMessage(response);
      }, 500);
    }
    
    sendChatButton.addEventListener('click', function() {
      const message = chatInput.value.trim();
      if (message) {
        addChatMessage(message, true);
        chatInput.value = '';
        processChat(message);
      }
    });
    
    chatInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        sendChatButton.click();
      }
    });
    
    document.querySelectorAll('.quick-question').forEach(button => {
      button.addEventListener('click', function() {
        const question = this.textContent;
        addChatMessage(question, true);
        processChat(question);
      });
    });
    
    // Memory game initialization
    const memoryGame = document.getElementById('memory-game');
    const moveCounter = document.getElementById('move-counter');
    const resetGameButton = document.getElementById('reset-game');
    
    const animalEmojis = ['🐘', '🦁', '🐯', '🦒', '🦓', '🦏', '🐻', '🐨'];
    let cards = [...animalEmojis, ...animalEmojis];
    let moves = 0;
    let flipped = [];
    let matched = [];
    
    function shuffleArray(array) {
      for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
      }
      return array;
    }
    
    function createMemoryGame() {
      memoryGame.innerHTML = '';
      moves = 0;
      moveCounter.textContent = moves;
      flipped = [];
      matched = [];
      
      shuffleArray(cards).forEach((emoji, index) => {
        const card = document.createElement('div');
        card.className = 'aspect-square bg-white rounded-lg shadow flex items-center justify-center cursor-pointer transform transition hover:scale-105 hover:shadow-md';
        card.dataset.index = index;
        card.dataset.emoji = emoji;
        card.innerHTML = `
          <div class="card-back w-full h-full rounded-lg bg-blue-600 flex items-center justify-center">
            <i class="fas fa-question text-white text-xl"></i>
          </div>
          <div class="card-front w-full h-full rounded-lg flex items-center justify-center text-3xl hidden">
            ${emoji}
          </div>
        `;
        
        card.addEventListener('click', flipCard);
        memoryGame.appendChild(card);
      });
    }
    
    function flipCard() {
      const index = this.dataset.index;
      
      // Skip if already flipped or matched
      if (flipped.includes(index) || matched.includes(index)) return;
      
      // Flip this card
      this.querySelector('.card-back').classList.add('hidden');
      this.querySelector('.card-front').classList.remove('hidden');
      
      flipped.push(index);
      
      // If two cards are flipped, check for match
      if (flipped.length === 2) {
        moves++;
        moveCounter.textContent = moves;
        
        const card1 = document.querySelector(`[data-index="${flipped[0]}"]`);
        const card2 = document.querySelector(`[data-index="${flipped[1]}"]`);
        
        if (card1.dataset.emoji === card2.dataset.emoji) {
          // Match found
          matched.push(flipped[0], flipped[1]);
          flipped = [];
          
          // Check for game completion
          if (matched.length === cards.length) {
            setTimeout(() => {
              alert(`Congratulations! You completed the game in ${moves} moves.`);
            }, 500);
          }
        } else {
          // No match, flip back
          setTimeout(() => {
            card1.querySelector('.card-back').classList.remove('hidden');
            card1.querySelector('.card-front').classList.add('hidden');
            card2.querySelector('.card-back').classList.remove('hidden');
            card2.querySelector('.card-front').classList.add('hidden');
            flipped = [];
          }, 1000);
        }
      }
    }
    
    resetGameButton.addEventListener('click', createMemoryGame);
    
    // Newsletter form
    const newsletterForm = document.getElementById('newsletter-form');
    const newsletterSuccess = document.getElementById('newsletter-success');
    
    newsletterForm.addEventListener('submit', function(e) {
      e.preventDefault();
      newsletterSuccess.classList.remove('hidden');
      newsletterForm.reset();
      
      setTimeout(() => {
        newsletterSuccess.classList.add('hidden');
      }, 5000);
    });
    
    // Initialize the memory game
    createMemoryGame();
    
    // Initialize Three.js scene (simplified version)
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('animal-scene'), alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    
    // Add simple particle system
    const particlesGeometry = new THREE.BufferGeometry();
    const particlesCount = 100;
    
    const posArray = new Float32Array(particlesCount * 3);
    for (let i = 0; i < particlesCount * 3; i++) {
      posArray[i] = (Math.random() - 0.5) * 10;
    }
    
    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
    
    const particlesMaterial = new THREE.PointsMaterial({
      size: 0.02,
      color: 0x3b82f6,
      transparent: true,
      opacity: 0.8
    });
    
    const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
    scene.add(particlesMesh);
    
    camera.position.z = 5;
    
    function animate() {
      requestAnimationFrame(animate);
      particlesMesh.rotation.x += 0.0003;
      particlesMesh.rotation.y += 0.0005;
      renderer.render(scene, camera);
    }
    
    animate();
    
    // Parallax effect
    document.addEventListener('mousemove', function(e) {
      document.querySelectorAll('.parallax-layer').forEach(layer => {
        const depth = layer.getAttribute('data-depth');
        const moveX = (e.pageX - window.innerWidth / 2) * depth;
        const moveY = (e.pageY - window.innerHeight / 2) * depth;
        layer.style.transform = `translate(${moveX}px, ${moveY}px)`;
      });
    });
    
    // Resize event handler
    window.addEventListener('resize', function() {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
    });
  </script>
</body>
</html>