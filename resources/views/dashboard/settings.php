<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wildlife Haven - Account Settings</title>
  
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
      background-color: var(--color-bg);
      color: var(--color-text);
      line-height: 1.5;
      overflow-x: hidden;
    }
    
    .headline {
      font-family: var(--font-display);
      font-weight: 500;
    }
    
    /* Tab animations */
    .tab-slider {
      position: absolute;
      bottom: 0;
      left: 0;
      height: 3px;
      background-color: var(--color-primary);
      transition: all 0.3s ease;
    }
    
    .settings-card {
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .settings-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 35px -10px rgba(0,0,0,0.15);
    }
    
    /* Toggle Switch */
    .toggle-switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }
    
    .toggle-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }
    
    .toggle-slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      transition: .4s;
      border-radius: 24px;
    }
    
    .toggle-slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }
    
    input:checked + .toggle-slider {
      background-color: var(--color-primary);
    }
    
    input:checked + .toggle-slider:before {
      transform: translateX(26px);
    }
    
    /* Animal pattern background */
    .animal-pattern {
      background-image: url("data:image/svg+xml,%3Csvg width='52' height='26' viewBox='0 0 52 26' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%234D724D' fill-opacity='0.05'%3E%3Cpath d='M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6h-2c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    /* Modal transition */
    .modal-transition {
      transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    /* Password strength indicator */
    .password-strength {
      height: 6px;
      border-radius: 3px;
      transition: width 0.3s ease;
    }
    
    /* Loading spinner animation */
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    .loading-spinner {
      animation: spin 1s linear infinite;
    }
    
    /* Section dividers with paw print */
    .paw-divider {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 1.5rem 0;
    }
    
    .paw-divider::before,
    .paw-divider::after {
      content: "";
      flex-grow: 1;
      height: 1px;
      background-color: rgba(107, 114, 128, 0.2);
      margin: 0 1rem;
    }
    
    /* Animated icon pulse */
    .pulse-icon {
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
  </style>
</head>

<body class="min-h-screen animal-pattern">
  <!-- Flash Message -->
  <?php if (isset($_SESSION['flash_message'])): ?>
    <div class="container mx-auto px-4 mb-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
      <div class="bg-<?= $_SESSION['flash_type'] ?? 'green' ?>-100 border-l-4 border-<?= $_SESSION['flash_type'] ?? 'green' ?>-500 text-<?= $_SESSION['flash_type'] ?? 'green' ?>-700 p-4 rounded-lg shadow-md">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-<?= $_SESSION['flash_type'] ?? 'green' ?>-500" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm"><?= $_SESSION['flash_message']; ?></p>
          </div>
          <div class="ml-auto pl-3">
            <div class="-mx-1.5 -my-1.5">
              <button @click="show = false" class="inline-flex rounded-md p-1.5 text-<?= $_SESSION['flash_type'] ?? 'green' ?>-500 hover:bg-<?= $_SESSION['flash_type'] ?? 'green' ?>-100 focus:outline-none">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
  <?php endif; ?>

  <!-- Main Content Container -->
  <div class="container mx-auto px-4 pb-16">
    <div class="max-w-5xl mx-auto">
      <!-- Page Header with Animal Illustration -->
      <div class="flex flex-col md:flex-row items-center justify-between mb-8">
        <div>
          <h1 class="headline text-3xl font-bold text-gray-800 mb-2">Account Settings</h1>
          <p class="text-gray-600">Customize your Wildlife Haven experience</p>
        </div>
        
        <!-- Decorative Animal Illustration -->
        <div class="mt-4 md:mt-0 w-32 h-32 relative">
          <svg class="w-full h-full text-green-700" viewBox="0 0 100 100" fill="currentColor">
            <path d="M83.9,47.5c-0.2-2.4-0.7-4.8-1.3-7.1c-1.3-5-2.9-9.8-4-14.8c-0.3-1.3-0.5-2.6-0.8-3.8c-0.1-0.6-0.2-1.3-0.2-1.9c0-0.3,0-0.7,0.1-1c0.1-0.8,0.3-1.5,0.7-2.2c0.8-1.4,2.1-2.3,3.5-2.5c2.1-0.3,3.9,0.5,5.1,2.2c0.8,1.2,1.2,2.5,1.4,3.9c0.2,1.7,0.2,3.5,0.1,5.2c-0.1,2.4-0.3,4.7-0.4,7.1c0,0.3,0,0.7,0.1,1c0.2,0.4,0.4,0.7,0.7,1c0.4,0.3,0.8,0.5,1.2,0.7c1.2,0.7,2.3,1.4,3.1,2.6c1.3,1.9,1.4,4,0.6,6.1c-0.8,2.1-2.4,3.4-4.5,4.1c-1.5,0.5-3,0.6-4.6,0.3C84.4,47.6,84.1,47.6,83.9,47.5z"/>
            <path d="M16.8,48c-0.8,0.2-1.5,0.2-2.2,0.1c-2.2-0.2-4.1-1.2-5.5-2.9c-1.4-1.7-1.8-3.6-1.1-5.7c0.5-1.6,1.5-2.8,2.9-3.8c0.9-0.6,1.8-1.1,2.7-1.6c0.4-0.2,0.9-0.5,1.3-0.7c0.4-0.3,0.7-0.7,0.8-1.2c0.1-0.4,0.1-0.9,0.1-1.3c0-2.2-0.1-4.5-0.1-6.7c0-1.5,0.1-3,0.3-4.4c0.3-1.9,1-3.5,2.6-4.7c1.8-1.3,4.4-1.1,5.9,0.4c1.1,1.1,1.6,2.5,1.7,4c0,0.5,0.1,1.1,0.1,1.6c-0.1,2.2-0.3,4.3-0.7,6.5c-0.7,3.9-1.6,7.7-2.5,11.6c-0.8,3.3-1.4,6.7-1.8,10.1C20.8,47.9,19.1,47.5,16.8,48z"/>
            <path d="M49.6,16.3c-1.7,0-3.3-0.1-4.9-0.5c-2.9-0.7-5.4-2.2-7.3-4.4c-1.4-1.6-2.2-3.5-2.3-5.6C35,3.9,35.3,2,36.1,0.3c0.9,0.2,1.7,0.3,2.6,0.5c3.4,0.8,6.8,1.7,10.2,2.5c2.9,0.7,5.9,1.2,8.9,1.8c1.1,0.2,2.1,0.4,3.2,0.5c0.9,0.1,1.9,0,2.7-0.3c2-0.6,3.4-1.9,4.3-3.8c2.4,5,0.8,9.3-4.3,12.2c-3.5,2-7.3,2.6-11.3,2.6C51.2,16.3,50.4,16.3,49.6,16.3z"/>
            <path d="M49.2,83.3c-0.4,0-0.7,0-1.1,0c-3.7-0.2-7-1.5-9.6-4.2c-1.9-1.9-3-4.2-3.3-6.8c-0.3-3,0.4-5.7,2.2-8.1c0.5,0.2,0.9,0.3,1.3,0.5c3.3,1.2,6.7,2.4,10,3.6c2.6,0.9,5.3,1.7,7.9,2.5c1.3,0.4,2.6,0.7,4,0.7c3.1,0,5.5-1.4,7.4-3.7c-0.1,1.7-0.5,3.3-1.1,4.8c-2.1,4.8-6.6,8.6-11.8,9.9C53.2,83.1,51.2,83.3,49.2,83.3z"/>
            <path d="M49.9,36.8c0.5,0,0.9,0,1.4,0c4.9,0,9.7,0.8,14.3,2.5c5.3,1.9,9.4,5.1,11.8,10.1c0.1,0.3,0.2,0.5,0.3,0.8c0.2,0.4,0.6,0.7,1,0.7c0.4,0,0.9,0,1.3,0c0.4,0,0.9-0.1,1.3-0.2c1-0.2,1.9-0.2,3,0c-0.2,1-0.3,2-0.6,2.9c-0.6,2.1-1.7,3.9-3.3,5.5c-3.2,3.2-7,5.4-11.2,6.9c-4.3,1.6-8.7,2.5-13.3,2.7c-6.7,0.3-13.1-0.9-19.3-3.5c-3.7-1.6-7-3.7-9.6-6.8c-1.9-2.3-3.2-4.9-3.8-7.8c0.2,0.1,0.3,0.1,0.5,0.1c1.3,0.3,2.7,0.3,4,0c0.4-0.1,0.8-0.1,1.2-0.1c0.8,0,1.3-0.4,1.6-1.1c0.2-0.6,0.4-1.1,0.7-1.6c2.9-5.4,7.6-8.5,13.5-9.9C46.1,37.1,48,37,49.9,36.8z"/>
            <path d="M77.8,61.3c0,3.9-0.5,8.4-2.2,12.6c-1,2.6-2.4,4.9-4.3,6.9c-2.9,3.2-6.5,5.3-10.8,6.2c-3.8,0.8-7.6,0.8-11.4,0.1c-4.2-0.8-7.7-2.8-10.6-5.9c-1.5-1.6-2.6-3.5-3.4-5.6c-1.5-3.6-2.2-7.4-2.6-11.3c-0.1-1-0.2-2.1-0.2-3.1c8.8,4.9,18.3,6.6,28.4,5.1C67.1,65.5,72.7,64.1,77.8,61.3z"/>
            <circle cx="36" cy="46" r="3" fill="#1E3A21"/>
            <circle cx="64" cy="46" r="3" fill="#1E3A21"/>
          </svg>
          
          <!-- Dynamic Eyes that Follow Mouse -->
          <div class="absolute top-[37%] left-[36%] w-3 h-3 bg-white rounded-full" id="left-eye">
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-black rounded-full" id="left-pupil"></div>
          </div>
          <div class="absolute top-[37%] right-[36%] w-3 h-3 bg-white rounded-full" id="right-eye">
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-black rounded-full" id="right-pupil"></div>
          </div>
        </div>
      </div>

      <!-- Settings Navigation Tabs -->
      <div class="mb-8" x-data="{ activeTab: 'account' }">
        <div class="bg-white rounded-lg shadow p-1 relative">
          <div class="flex">
            <button 
              @click="activeTab = 'account'" 
              :class="{ 'text-green-800 font-medium': activeTab === 'account', 'text-gray-600': activeTab !== 'account' }" 
              class="flex-1 py-3 px-4 rounded-md text-center relative transition-colors duration-200 focus:outline-none"
            >
              <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Account</span>
              </div>
            </button>
            
            <button 
              @click="activeTab = 'notifications'" 
              :class="{ 'text-green-800 font-medium': activeTab === 'notifications', 'text-gray-600': activeTab !== 'notifications' }" 
              class="flex-1 py-3 px-4 rounded-md text-center relative transition-colors duration-200 focus:outline-none"
            >
              <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span>Notifications</span>
              </div>
            </button>
            
            <button 
              @click="activeTab = 'appearance'" 
              :class="{ 'text-green-800 font-medium': activeTab === 'appearance', 'text-gray-600': activeTab !== 'appearance' }" 
              class="flex-1 py-3 px-4 rounded-md text-center relative transition-colors duration-200 focus:outline-none"
            >
              <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
                <span>Appearance</span>
              </div>
            </button>
            
            <button 
              @click="activeTab = 'privacy'" 
              :class="{ 'text-green-800 font-medium': activeTab === 'privacy', 'text-gray-600': activeTab !== 'privacy' }" 
              class="flex-1 py-3 px-4 rounded-md text-center relative transition-colors duration-200 focus:outline-none"
            >
              <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span>Privacy</span>
              </div>
            </button>
          </div>
          
          <!-- Dynamic Tab Slider -->
          <div 
            class="tab-slider" 
            :style="{ 
              left: activeTab === 'account' ? '0%' : 
                   activeTab === 'notifications' ? '25%' : 
                   activeTab === 'appearance' ? '50%' : '75%', 
              width: '25%' 
            }"
          ></div>
        </div>
        
        <!-- Account Settings Tab -->
        <div x-show="activeTab === 'account'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <!-- Change Password Card -->
            <div class="settings-card bg-white" x-data="{ 
              currentPassword: '', 
              newPassword: '', 
              confirmPassword: '',
              strength: 0,
              strengthText: '',
              strengthColor: '',
              passwordVisible: false,
              loading: false,
              updateStrength() {
                const password = this.newPassword;
                let score = 0;
                
                // Length check
                if (password.length >= 8) score += 25;
                
                // Uppercase check
                if (/[A-Z]/.test(password)) score += 25;
                
                // Number check
                if (/[0-9]/.test(password)) score += 25;
                
                // Special character check
                if (/[^A-Za-z0-9]/.test(password)) score += 25;
                
                this.strength = score;
                
                if (score < 25) {
                  this.strengthText = 'Very Weak';
                  this.strengthColor = 'bg-red-500';
                } else if (score < 50) {
                  this.strengthText = 'Weak';
                  this.strengthColor = 'bg-orange-500';
                } else if (score < 75) {
                  this.strengthText = 'Moderate';
                  this.strengthColor = 'bg-yellow-500';
                } else {
                  this.strengthText = 'Strong';
                  this.strengthColor = 'bg-green-500';
                }
              }
            }">
              <div class="bg-blue-600 text-white px-6 py-4">
                <h3 class="text-lg font-semibold flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                  </svg>
                  Change Password
                </h3>
              </div>
              
              <form action="<?= $baseUrl ?>/dashboard/settings/password/update" method="POST" class="p-6" @submit="loading = true">
                <div class="space-y-4">
                  <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                    <div class="relative">
                      <input 
                        x-bind:type="passwordVisible ? 'text' : 'password'" 
                        name="current_password" 
                        id="current_password" 
                        required 
                        x-model="currentPassword"
                        class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      >
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                      </div>
                      <button 
                        type="button" 
                        @click="passwordVisible = !passwordVisible"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                      >
                        <svg 
                          x-show="!passwordVisible"
                          class="w-5 h-5 text-gray-400" 
                          fill="none" 
                          stroke="currentColor" 
                          viewBox="0 0 24 24" 
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg 
                          x-show="passwordVisible"
                          class="w-5 h-5 text-gray-400" 
                          fill="none" 
                          stroke="currentColor" 
                          viewBox="0 0 24 24" 
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                      </button>
                    </div>
                  </div>
                  
                  <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <div class="relative">
                      <input 
                        x-bind:type="passwordVisible ? 'text' : 'password'" 
                        name="new_password" 
                        id="new_password" 
                        required 
                        x-model="newPassword"
                        @input="updateStrength"
                        class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      >
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                      </div>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="mt-2" x-show="newPassword.length > 0">
                      <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div 
                          class="password-strength rounded-full h-1.5" 
                          :class="strengthColor"
                          :style="{ width: strength + '%' }"
                        ></div>
                      </div>
                      <div class="flex justify-between mt-1">
                        <span class="text-xs" x-text="strengthText"></span>
                        <span class="text-xs text-gray-500">Min. 8 characters</span>
                      </div>
                    </div>
                  </div>
                  
                  <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <div class="relative">
                      <input 
                        x-bind:type="passwordVisible ? 'text' : 'password'" 
                        name="confirm_password" 
                        id="confirm_password" 
                        required 
                        x-model="confirmPassword"
                        class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      >
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                      </div>
                    </div>
                    <!-- Password match indicator -->
                    <p 
                      x-show="confirmPassword.length > 0" 
                      class="mt-1 text-xs" 
                      :class="newPassword === confirmPassword ? 'text-green-600' : 'text-red-600'"
                    >
                      <span x-show="newPassword === confirmPassword">
                        <svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Passwords match
                      </span>
                      <span x-show="newPassword !== confirmPassword">
                        <svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Passwords do not match
                      </span>
                    </p>
                  </div>
                  
                  <div class="pt-4">
                    <button 
                      type="submit" 
                      class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 flex items-center justify-center"
                      :disabled="loading || newPassword !== confirmPassword || newPassword.length < 8"
                      :class="{'opacity-50 cursor-not-allowed': loading || newPassword !== confirmPassword || newPassword.length < 8}"
                    >
                      <svg 
                        x-show="loading" 
                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" 
                        xmlns="http://www.w3.org/2000/svg" 
                        fill="none" 
                        viewBox="0 0 24 24"
                      >
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
                      <span x-text="loading ? 'Updating...' : 'Update Password'"></span>
                    </button>
                  </div>
                </div>
              </form>
            </div>
            
            <!-- Connected Accounts Card -->
            <div class="settings-card bg-white">
              <div class="bg-purple-600 text-white px-6 py-4">
                <h3 class="text-lg font-semibold flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                  </svg>
                  Connected Accounts
                </h3>
              </div>
              
              <div class="p-6">
                <div class="space-y-4">
                  <!-- Google Account -->
                  <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center">
                      <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                        </svg>
                      </div>
                      <div>
                        <h4 class="font-medium">Google</h4>
                        <p class="text-sm text-gray-600"><?= $user['oauth_provider'] === 'google' ? 'Connected' : 'Not connected' ?></p>
                      </div>
                    </div>
                    
                    <?php if ($user['oauth_provider'] === 'google'): ?>
                      <span class="text-sm text-green-600 font-medium">Connected</span>
                    <?php else: ?>
                      <button class="px-3 py-1 text-sm text-purple-600 border border-purple-600 rounded-md hover:bg-purple-50 transition-colors focus:outline-none">
                        Connect
                      </button>
                    <?php endif; ?>
                  </div>
                  
                  <!-- Apple Account -->
                  <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center">
                      <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-gray-800" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M12.152,6.896c-0.948,0-2.415-1.078-3.96-1.04c-2.04,0.027-3.913,1.183-4.962,3.028c-2.104,3.671-0.545,9.086,1.55,12.075c1,1.511,2.194,3.193,3.77,3.131c1.517-0.065,2.085-0.981,3.912-0.981c1.83,0,2.35,0.981,3.962,0.95c1.631-0.031,2.667-1.488,3.667-3.004c1.137-1.675,1.6-3.293,1.639-3.379c-0.032-0.027-3.225-1.241-3.26-4.925c-0.026-3.076,2.506-4.553,2.621-4.624C15.362,6.112,13.219,6.896,12.152,6.896L12.152,6.896z M15.657,3.645c0.858-1.019,1.429-2.439,1.27-3.854c-1.219,0.051-2.704,0.813-3.588,1.82c-0.832,0.951-1.544,2.35-1.347,3.742C13.345,5.472,14.799,4.652,15.657,3.645L15.657,3.645z"/>
                        </svg>
                      </div>
                      <div>
                        <h4 class="font-medium">Apple</h4>
                        <p class="text-sm text-gray-600"><?= $user['oauth_provider'] === 'apple' ? 'Connected' : 'Not connected' ?></p>
                      </div>
                    </div>
                    
                    <?php if ($user['oauth_provider'] === 'apple'): ?>
                      <span class="text-sm text-green-600 font-medium">Connected</span>
                    <?php else: ?>
                      <button class="px-3 py-1 text-sm text-purple-600 border border-purple-600 rounded-md hover:bg-purple-50 transition-colors focus:outline-none">
                        Connect
                      </button>
                    <?php endif; ?>
                  </div>
                  
                  <!-- Wildlife Habitat Account -->
                  <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-green-50">
                    <div class="flex items-center">
                      <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M21 8c-1.45 0-2.26 1.44-1.93 2.51l-3.55 3.56c-.3-.09-.74-.09-1.04 0l-2.55-2.55C12.27 10.45 11.46 9 10 9c-1.45 0-2.27 1.44-1.93 2.52l-4.56 4.55C2.44 15.74 1 16.55 1 18c0 1.1.9 2 2 2 1.45 0 2.26-1.44 1.93-2.51l4.55-4.56c.3.09.74.09 1.04 0l2.55 2.55C12.73 16.55 13.54 18 15 18c1.45 0 2.27-1.44 1.93-2.52l3.56-3.55c1.07.33 2.51-.48 2.51-1.93 0-1.1-.9-2-2-2z" />
                          <path d="M15 9l.94-2.07L18 6l-2.06-.93L15 3l-.92 2.07L12 6l2.08.93zM3.5 11L4 9l2-.5L4 8l-.5-2L3 8l-2 .5L3 9z" />
                        </svg>
                      </div>
                      <div>
                        <h4 class="font-medium">Wildlife Habitat</h4>
                        <p class="text-sm text-gray-600">Connected with premium benefits</p>
                      </div>
                    </div>
                    
                    <span class="text-sm text-green-600 font-medium">Active</span>
                  </div>
                  
                  <div class="paw-divider">
                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M8.89,10.5c-0.53,0.08-1.07-0.17-1.36-0.65c-0.31-0.51-0.36-1.14-0.13-1.69c0.21-0.5,0.58-0.91,1.05-1.18C8.92,6.73,9.44,6.58,9.97,6.6c0.45,0.02,0.89,0.18,1.22,0.46c0.45,0.38,0.72,0.94,0.72,1.53C11.91,9.75,10.5,10.35,8.89,10.5z M12.89,10.5c-0.53,0.08-1.07-0.17-1.36-0.65c-0.31-0.51-0.36-1.14-0.13-1.69c0.21-0.5,0.58-0.91,1.05-1.18c0.47-0.25,0.99-0.4,1.52-0.38c0.45,0.02,0.89,0.18,1.22,0.46c0.45,0.38,0.72,0.94,0.72,1.53C15.91,9.75,14.5,10.35,12.89,10.5z"></path>
                      <path d="M9.91,6.5c-0.92-0.32-1.85-0.93-2.45-1.76C6.97,4.02,6.76,3.16,6.79,2.3c0.61,0.17,1.2,0.44,1.72,0.82C9.22,3.6,9.77,4.26,10.16,5.02c0.1,0.19,0.14,0.39,0.19,0.6c0.04,0.18-0.02,0.35-0.12,0.5C10.07,6.39,9.91,6.5,9.91,6.5z M13.91,6.5c-0.92-0.32-1.85-0.93-2.45-1.76c-0.49-0.72-0.7-1.58-0.67-2.44c0.61,0.17,1.2,0.44,1.72,0.82c0.71,0.48,1.26,1.14,1.65,1.9c0.1,0.19,0.14,0.39,0.19,0.6c0.04,0.18-0.02,0.35-0.12,0.5C14.07,6.39,13.91,6.5,13.91,6.5z"></path>
                      <path d="M10.91,15.5c-0.85,0.6-1.87,0.92-2.91,0.92c-0.63,0-1.25-0.09-1.85-0.26c-0.56-0.16-1.08-0.39-1.55-0.71c-0.6-0.41-1.09-0.96-1.43-1.59c-0.33-0.62-0.5-1.32-0.48-2.02c0.02-0.46,0.13-0.91,0.33-1.33c0.23-0.5,0.59-0.94,1.05-1.28c0.46-0.33,0.99-0.56,1.54-0.67c0.31-0.06,0.62-0.08,0.93-0.05c0.27,0.02,0.54,0.08,0.8,0.18c0.72,0.27,1.33,0.8,1.71,1.48c0.4,0.72,0.53,1.57,0.35,2.38c-0.09,0.41-0.28,0.8-0.55,1.14c-0.26,0.32-0.57,0.58-0.94,0.79c0.85-0.24,1.64-0.67,2.35-1.25c0.71-0.58,1.31-1.29,1.78-2.09c0.45-0.77,0.77-1.61,0.94-2.48c0.16-0.83,0.18-1.69,0.07-2.52c-0.12-0.86-0.38-1.7-0.77-2.48c-0.42-0.84-0.98-1.61-1.65-2.29c0.48,0.03,0.95,0.1,1.41,0.22c0.58,0.14,1.13,0.35,1.66,0.62c0.62,0.32,1.2,0.71,1.73,1.17c0.59,0.51,1.12,1.08,1.56,1.72c0.46,0.68,0.82,1.42,1.05,2.2c0.25,0.82,0.36,1.68,0.32,2.53c-0.04,0.94-0.26,1.86-0.65,2.71c-0.04,0.1-0.09,0.2-0.14,0.3c-0.56,1.11-1.4,2.06-2.42,2.77c-0.55,0.38-1.15,0.69-1.78,0.94c-0.74,0.29-1.52,0.48-2.31,0.57C12.46,16.57,11.66,16.11,10.91,15.5z"></path>
                    </svg>
                  </div>
                  
                  <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="font-medium text-green-800 mb-2 flex items-center">
                      <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                      </svg>
                      Conservation Integration
                    </h4>
                    <p class="text-sm text-gray-700 mb-3">Link your account with our conservation partners to track your real-world impact.</p>
                    <button class="w-full py-2 bg-green-600 text-white font-medium rounded-lg transition-colors hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                      Link Conservation Account
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Account Manager (Danger Zone) -->
          <div class="settings-card bg-white mt-6" x-data="{ showDeleteModal: false }">
            <div class="bg-red-600 text-white px-6 py-4">
              <h3 class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Account Management
              </h3>
            </div>
            
            <div class="p-6">
              <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex items-start">
                  <div class="flex-shrink-0 mt-0.5">
                    <svg class="w-10 h-10 text-red-400 pulse-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  <div class="ml-4">
                    <h4 class="text-lg font-medium text-red-800 mb-2">Delete Account</h4>
                    <p class="text-red-700 mb-4">
                      Permanently delete your account and all associated data. This action cannot be undone.
                    </p>
                    <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
                      <button 
                        @click="showDeleteModal = true"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                      >
                        Delete Account
                      </button>
                      <button class="inline-flex justify-center py-2 px-4 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Export My Data
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Delete Account Modal -->
            <div 
              x-show="showDeleteModal" 
              @keydown.escape.window="showDeleteModal = false"
              class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50 modal-transition"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 transform scale-95"
              x-transition:enter-end="opacity-100 transform scale-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 transform scale-100"
              x-transition:leave-end="opacity-0 transform scale-95"
            >
              <div @click.away="showDeleteModal = false" class="bg-white rounded-lg max-w-md w-full">
                <div class="p-6">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </div>
                  
                  <h3 class="text-xl font-bold text-gray-900 text-center mb-1">Confirm Account Deletion</h3>
                  <p class="text-gray-600 text-center mb-6">This will release all your virtual animals back to the wild.</p>
                  
                  <form action="<?= $baseUrl ?>/dashboard/settings/account/delete" method="POST">
                    <div class="mb-4">
                      <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1">Enter your password to confirm</label>
                      <input type="password" name="password_confirm" id="password_confirm" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                    </div>
                    
                    <div class="mb-4">
                      <label class="flex items-center">
                        <input type="checkbox" name="confirm_deletion" required class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">I understand this action cannot be undone and all my data will be permanently lost</span>
                      </label>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                      <button type="button" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      @click="showDeleteModal = false">
                        Cancel
                      </button>
                      <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Account
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Notifications Tab -->
        <div x-show="activeTab === 'notifications'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
          <div class="settings-card bg-white mt-6">
            <div class="bg-green-600 text-white px-6 py-4">
              <h3 class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                Notification Preferences
              </h3>
            </div>
            
            <form action="<?= $baseUrl ?>/dashboard/settings/notifications/update" method="POST" class="p-6">
              <div class="space-y-6">
                <!-- Email Notifications Section -->
                <div>
                  <h4 class="text-base font-medium text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Email Notifications
                  </h4>
                  
                  <div class="bg-gray-50 rounded-lg p-4">
                    <ul class="divide-y divide-gray-200">
                      <li class="py-3 flex items-center justify-between">
                        <div>
                          <p class="text-sm font-medium text-gray-900">Account Updates</p>
                          <p class="text-xs text-gray-500">Security alerts and account changes</p>
                        </div>
                        <label class="toggle-switch">
                          <input type="checkbox" name="email_account_updates" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </li>
                      
                      <li class="py-3 flex items-center justify-between">
                        <div>
                          <p class="text-sm font-medium text-gray-900">Focus Reminders</p>
                          <p class="text-xs text-gray-500">Daily reminders to maintain your focus streak</p>
                        </div>
                        <label class="toggle-switch">
                          <input type="checkbox" name="email_focus_reminders" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </li>
                      
                      <li class="py-3 flex items-center justify-between">
                        <div>
                          <p class="text-sm font-medium text-gray-900">Creature Updates</p>
                          <p class="text-xs text-gray-500">Notifications about your creatures' well-being</p>
                        </div>
                        <label class="toggle-switch">
                          <input type="checkbox" name="email_creature_updates" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </li>
                      
                      <li class="py-3 flex items-center justify-between">
                        <div>
                          <p class="text-sm font-medium text-gray-900">Conservation Impact</p>
                          <p class="text-xs text-gray-500">Updates on your real-world conservation impact</p>
                        </div>
                        <label class="toggle-switch">
                          <input type="checkbox" name="email_conservation_updates" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </li>
                      
                      <li class="py-3 flex items-center justify-between">
                        <div>
                          <p class="text-sm font-medium text-gray-900">Marketing & Newsletter</p>
                          <p class="text-xs text-gray-500">News, promotions, and feature announcements</p>
                        </div>
                        <label class="toggle-switch">
                          <input type="checkbox" name="email_marketing">
                          <span class="toggle-slider"></span>
                        </label>
                      </li>
                    </ul>
                  </div>
                </div>
                
                <!-- Push Notification Section with Animal Icons -->
                <div>
                  <h4 class="text-base font-medium text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    Push Notifications
                  </h4>
                  
                  <div class="bg-gray-50 rounded-lg p-4">
                    <ul class="divide-y divide-gray-200">
                      <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                          <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-700 mr-3">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                              <path d="M10 2c-1.716 0-3.408.106-5.07.31C3.806 2.45 3 3.414 3 4.517V17.25a.75.75 0 001.075.676L10 15.082l5.925 2.844A.75.75 0 0017 17.25V4.517c0-1.103-.806-2.068-1.93-2.207A41.403 41.403 0 0010 2z" />
                            </svg>
                          </span>
                          <div>
                            <p class="text-sm font-medium text-gray-900">Focus Session Reminders</p>
                            <p class="text-xs text-gray-500">Reminders to start your scheduled focus sessions</p>
                          </div>
                        </div>
                        <label class="toggle-switch">
                          <input type="checkbox" name="push_focus_reminders" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </li>
                      
                      <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                          <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-700 mr-3">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                              <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                          </span>
                          <div>
                            <p class="text-sm font-medium text-gray-900">Creature Care Alerts</p>
                            <p class="text-xs text-gray-500">Alerts when your creatures need attention</p>
                          </div>
                        </div>
                        <label class="toggle-switch">
                          <input type="checkbox" name="push_creature_alerts" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </li>
                      
                      <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                          <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-yellow-100 text-yellow-700 mr-3">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M8.5 2a6.5 6.5 0 00-1.866 12.702c.071.022.152.046.254.07l.206.056A6.5 6.5 0 008.5 15h3c.51 0 .98-.1 1.401-.262l.081-.021c.145-.036.219-.055.299-.086A6.5 6.5 0 108.5 2zM6.05 7.705a.75.75 0 00-1.05 1.075L5.84 9.808c-.94.127-.182.275-.264.436-.332.646-.669 1.755.39 2.5.386.273.746.36 1.056.36.266 0 .502-.069.66-.17l.203-.101a.75.75 0 00-.32-1.428c-.152.068-.378-.062-.616-.23-.156-.11-.24-.218-.241-.218a.75.75 0 01.007-.993l1.054-1.066L6.05 7.705z" clip-rule="evenodd" />
                            </svg>
                          </span>
                          <div>
                            <p class="text-sm font-medium text-gray-900">Achievement Notifications</p>
                            <p class="text-xs text-gray-500">Alerts when you earn new achievements</p>
                          </div>
                        </div>
                        <label class="toggle-switch">
                          <input type="checkbox" name="push_achievements" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </li>
                      
                      <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                          <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-purple-100 text-purple-700 mr-3">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                              <path d="M3.33 8L10 12l10-6-10-6L0 6h10v2H3.33zM0 8v8l2-2.22V9.2L0 8zm10 12l-5-3-2-1.2v-6l7 4.2 7-4.2v6L10 20z" />
                            </svg>
                          </span>
                          <div>
                            <p class="text-sm font-medium text-gray-900">Friend Activity</p>
                            <p class="text-xs text-gray-500">Updates on your friends' focus milestones</p>
                          </div>
                        </div>
                        <label class="toggle-switch">
                          <input type="checkbox" name="push_friend_activity" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </li>
                      
                      <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center">
                          <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-700 mr-3">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                              <path d="M9.38 10.761a.25.25 0 01-.226 0L7.25 9.643V8.5a.75.75 0 00-1.5 0v1.75c0 .276.154.5.38.615l2.5 1.518a1.75 1.75 0 001.579 0l2.5-1.518A.704.704 0 0012.75 10.25V8.5a.75.75 0 00-1.5 0v1.143L9.38 10.761z" />
                              <path d="M2.5 4A1.5 1.5 0 001 5.5V16c0 .546.292 1.023.736 1.281l.61.31A8.5 8.5 0 007 19a8.5 8.5 0 004.5-1.286.75.75 0 00.4-.657V5.5A1.5 1.5 0 0010.5 4h-8zM9 6a1 1 0 011-1h.5a.5.5 0 01.5.5v.5a1 1 0 01-1 1H9V6zM9 9a1 1 0 011-1h.5a.5.5 0 01.5.5v.5a1 1 0 01-1 1H9V9zM9 12a1 1 0 011-1h.5a.5.5 0 01.5.5v.5a1 1 0 01-1 1H9v-1z" />
                            </svg>
                          </span>
                          <div>
                            <p class="text-sm font-medium text-gray-900">Conservation News</p>
                            <p class="text-xs text-gray-500">Updates on conservation impact and news</p>
                          </div>
                        </div>
                        <label class="toggle-switch">
                          <input type="checkbox" name="push_conservation_news">
                          <span class="toggle-slider"></span>
                        </label>
                      </li>
                    </ul>
                  </div>
                </div>
                
                <!-- Session Notifications Section -->
                <div>
                  <h4 class="text-base font-medium text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Focus Session Sounds & Alerts
                  </h4>
                  
                  <div class="bg-gray-50 rounded-lg p-4">
                    <div class="space-y-4">
                      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                          <p class="text-sm font-medium text-gray-900">Session Start/End Sounds</p>
                          <p class="text-xs text-gray-500">Audio feedback when sessions start and end</p>
                        </div>
                        <div class="mt-2 sm:mt-0">
                          <select name="session_sounds" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                            <option value="nature">Nature Sounds</option>
                            <option value="animal">Animal Calls</option>
                            <option value="forest">Forest Ambience</option>
                            <option value="chime">Simple Chime</option>
                            <option value="none">No Sound</option>
                          </select>
                        </div>
                      </div>
                      
                      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                          <p class="text-sm font-medium text-gray-900">Creature Animations</p>
                          <p class="text-xs text-gray-500">Show creature animations during focus sessions</p>
                        </div>
                        <div class="mt-2 sm:mt-0">
                          <label class="toggle-switch">
                            <input type="checkbox" name="show_creature_animations" checked>
                            <span class="toggle-slider"></span>
                          </label>
                        </div>
                      </div>
                      
                      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                          <p class="text-sm font-medium text-gray-900">Focus Score Updates</p>
                          <p class="text-xs text-gray-500">Show real-time focus score during sessions</p>
                        </div>
                        <div class="mt-2 sm:mt-0">
                          <label class="toggle-switch">
                            <input type="checkbox" name="show_focus_score" checked>
                            <span class="toggle-slider"></span>
                          </label>
                        </div>
                      </div>
                      
                      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                          <p class="text-sm font-medium text-gray-900">Distraction Alerts</p>
                          <p class="text-xs text-gray-500">Notify when distractions are detected</p>
                        </div>
                        <div class="mt-2 sm:mt-0">
                          <label class="toggle-switch">
                            <input type="checkbox" name="distraction_alerts" checked>
                            <span class="toggle-slider"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="pt-4">
                  <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    Save Notification Preferences
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        
        <!-- Appearance Tab -->
        <div x-show="activeTab === 'appearance'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
          <div class="settings-card bg-white mt-6">
            <div class="bg-indigo-600 text-white px-6 py-4">
              <h3 class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
                Appearance Settings
              </h3>
            </div>
            
            <form action="<?= $baseUrl ?>/dashboard/settings/appearance/update" method="POST" class="p-6">
              <div class="space-y-6">
                <!-- Theme Selection with Preview -->
                <div>
                  <h4 class="text-base font-medium text-gray-900 mb-4">Theme</h4>
                  
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Forest Theme (Default) -->
                    <label class="cursor-pointer">
                      <input type="radio" name="theme" value="forest" class="sr-only" checked>
                      <div class="border-2 border-gray-200 rounded-lg overflow-hidden hover:border-green-500 transition-colors p-2">
                        <div class="h-32 bg-gradient-to-b from-green-600 to-green-800 rounded-lg mb-2 flex items-center justify-center">
                          <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                          </svg>
                        </div>
                        <div class="text-center">
                          <span class="font-medium text-gray-900">Forest</span>
                          <p class="text-xs text-gray-500">Default</p>
                        </div>
                      </div>
                    </label>
                    
                    <!-- Ocean Theme -->
                    <label class="cursor-pointer">
                      <input type="radio" name="theme" value="ocean" class="sr-only">
                      <div class="border-2 border-gray-200 rounded-lg overflow-hidden hover:border-blue-500 transition-colors p-2">
                        <div class="h-32 bg-gradient-to-b from-blue-500 to-blue-700 rounded-lg mb-2 flex items-center justify-center">
                          <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                          </svg>
                        </div>
                        <div class="text-center">
                          <span class="font-medium text-gray-900">Ocean</span>
                          <p class="text-xs text-gray-500">Marine creatures</p>
                        </div>
                      </div>
                    </label>
                    
                    <!-- Mystic Theme -->
                    <label class="cursor-pointer">
                      <input type="radio" name="theme" value="mystic" class="sr-only">
                      <div class="border-2 border-gray-200 rounded-lg overflow-hidden hover:border-purple-500 transition-colors p-2">
                        <div class="h-32 bg-gradient-to-b from-purple-600 to-purple-800 rounded-lg mb-2 flex items-center justify-center">
                          <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                          </svg>
                        </div>
                        <div class="text-center">
                          <span class="font-medium text-gray-900">Mystic</span>
                          <p class="text-xs text-gray-500">Magical creatures</p>
                        </div>
                      </div>
                    </label>
                  </div>
                </div>
                
                <!-- Habitat Background Selection -->
                <div>
                  <h4 class="text-base font-medium text-gray-900 mb-4">Habitat Background</h4>
                  
                  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Forest Background -->
                    <label class="cursor-pointer">
                      <input type="radio" name="habitat_background" value="forest" class="sr-only" checked>
                      <div class="border-2 border-gray-200 rounded-lg overflow-hidden hover:border-green-500 transition-colors">
                        <div class="h-24 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1448375240586-882707db888b?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80')"></div>
                        <div class="text-center py-2">
                          <span class="text-sm font-medium">Forest</span>
                        </div>
                      </div>
                    </label>
                    
                    <!-- Mountain Background -->
                    <label class="cursor-pointer">
                      <input type="radio" name="habitat_background" value="mountain" class="sr-only">
                      <div class="border-2 border-gray-200 rounded-lg overflow-hidden hover:border-green-500 transition-colors">
                        <div class="h-24 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80')"></div>
                        <div class="text-center py-2">
                          <span class="text-sm font-medium">Mountains</span>
                        </div>
                      </div>
                    </label>
                    
                    <!-- Ocean Background -->
                    <label class="cursor-pointer">
                      <input type="radio" name="habitat_background" value="ocean" class="sr-only">
                      <div class="border-2 border-gray-200 rounded-lg overflow-hidden hover:border-green-500 transition-colors">
                        <div class="h-24 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1518837695005-2083093ee35b?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80')"></div>
                        <div class="text-center py-2">
                          <span class="text-sm font-medium">Ocean</span>
                        </div>
                      </div>
                    </label>
                    
                    <!-- Cosmic Background -->
                    <label class="cursor-pointer">
                      <input type="radio" name="habitat_background" value="cosmic" class="sr-only">
                      <div class="border-2 border-gray-200 rounded-lg overflow-hidden hover:border-green-500 transition-colors">
                        <div class="h-24 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1534796636912-3b95b3ab5986?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80')"></div>
                        <div class="text-center py-2">
                          <span class="text-sm font-medium">Cosmic</span>
                        </div>
                      </div>
                    </label>
                  </div>
                </div>
                
                <!-- Interface Settings -->
                <div>
                  <h4 class="text-base font-medium text-gray-900 mb-4">Interface Settings</h4>
                  
                  <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                    <!-- Display Mode -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Display Mode</p>
                        <p class="text-xs text-gray-500">Choose between light and dark mode</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <select name="display_mode" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                          <option value="light">Light Mode</option>
                          <option value="dark">Dark Mode</option>
                          <option value="system">System Default</option>
                        </select>
                      </div>
                    </div>
                    
                    <!-- Font Size -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Font Size</p>
                        <p class="text-xs text-gray-500">Adjust the size of text in the app</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <select name="font_size" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                          <option value="small">Small</option>
                          <option value="medium" selected>Medium (Default)</option>
                          <option value="large">Large</option>
                          <option value="extra-large">Extra Large</option>
                        </select>
                      </div>
                    </div>
                    
                    <!-- Animations -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Interface Animations</p>
                        <p class="text-xs text-gray-500">Enable or disable UI animations</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="enable_animations" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                    
                    <!-- Reduce Motion -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Reduced Motion</p>
                        <p class="text-xs text-gray-500">Minimize motion effects for accessibility</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="reduced_motion">
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                    
                    <!-- High Contrast -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">High Contrast</p>
                        <p class="text-xs text-gray-500">Increase contrast for better visibility</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="high_contrast">
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Animal Animations -->
                <div>
                  <h4 class="text-base font-medium text-gray-900 mb-4">Creature Animations</h4>
                  
                  <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Creature Animation Style</p>
                        <p class="text-xs text-gray-500">Choose how your creatures move and behave</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <select name="creature_animation_style" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                          <option value="realistic">Realistic</option>
                          <option value="playful" selected>Playful</option>
                          <option value="magical">Magical</option>
                          <option value="minimal">Minimal</option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Animation Frequency</p>
                        <p class="text-xs text-gray-500">How often your creatures animate</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <select name="animation_frequency" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                          <option value="low">Low</option>
                          <option value="medium" selected>Medium</option>
                          <option value="high">High</option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Background Movement</p>
                        <p class="text-xs text-gray-500">Animate habitat backgrounds</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="animate_backgrounds" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">3D Effects</p>
                        <p class="text-xs text-gray-500">Enable 3D effects for creatures and habitats</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="enable_3d" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="pt-4">
                  <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                    Save Appearance Settings
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        
        <!-- Privacy Tab -->
        <div x-show="activeTab === 'privacy'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
          <div class="settings-card bg-white mt-6">
            <div class="bg-blue-600 text-white px-6 py-4">
              <h3 class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Privacy & Data Settings
              </h3>
            </div>
            
            <form action="<?= $baseUrl ?>/dashboard/settings/privacy/update" method="POST" class="p-6">
              <div class="space-y-6">
                <!-- Data Collection Settings -->
                <div>
                  <h4 class="text-base font-medium text-gray-900 mb-4">Data Collection</h4>
                  
                  <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Focus Analytics</p>
                        <p class="text-xs text-gray-500">Collect data about your focus patterns</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="collect_focus_analytics" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Usage Statistics</p>
                        <p class="text-xs text-gray-500">Collect anonymous app usage data</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="collect_usage_stats" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Conservation Contribution</p>
                        <p class="text-xs text-gray-500">Share anonymized data with conservation partners</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="share_conservation_data" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Device Sensors</p>
                        <p class="text-xs text-gray-500">Use device sensors to improve focus detection</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="use_device_sensors" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Social Settings -->
                <div>
                  <h4 class="text-base font-medium text-gray-900 mb-4">Social Settings</h4>
                  
                  <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Public Profile</p>
                        <p class="text-xs text-gray-500">Make your profile visible to other users</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="public_profile" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Show Focus Stats</p>
                        <p class="text-xs text-gray-500">Show your focus statistics to friends</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="share_focus_stats" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Show Creature Collection</p>
                        <p class="text-xs text-gray-500">Show your creatures to friends</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="share_creatures" checked>
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm font-medium text-gray-900">Find Me By Email</p>
                        <p class="text-xs text-gray-500">Allow others to find you using your email</p>
                      </div>
                      <div class="mt-2 sm:mt-0">
                        <label class="toggle-switch">
                          <input type="checkbox" name="findable_by_email">
                          <span class="toggle-slider"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Data Export and Deletion -->
                <div>
                  <h4 class="text-base font-medium text-gray-900 mb-4">Your Data</h4>
                  
                  <div class="space-y-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                      <h5 class="font-medium text-blue-800 mb-2">Download Your Data</h5>
                      <p class="text-sm text-blue-600 mb-3">Export all your data in a portable format.</p>
                      <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download My Data
                      </button>
                    </div>
                    
                    <div class="bg-yellow-50 rounded-lg p-4">
                      <h5 class="font-medium text-yellow-800 mb-2">Clear Focus History</h5>
                      <p class="text-sm text-yellow-600 mb-3">Remove all your focus session history while keeping creatures.</p>
                      <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Clear Focus History
                      </button>
                    </div>
                    
                    <div class="bg-gray-100 rounded-lg p-4">
                      <h5 class="font-medium text-gray-800 mb-2">Data Retention</h5>
                      <p class="text-sm text-gray-600 mb-3">Choose how long we keep your focus data.</p>
                      <select name="data_retention" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="indefinitely">Keep indefinitely</option>
                        <option value="1-year">1 year</option>
                        <option value="6-months">6 months</option>
                        <option value="3-months">3 months</option>
                        <option value="1-month">1 month</option>
                      </select>
                    </div>
                  </div>
                </div>
                
                <div class="pt-4">
                  <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Save Privacy Settings
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Initialize Scripts -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Eye movement tracking for animal illustration
      const leftEye = document.getElementById('left-pupil');
      const rightEye = document.getElementById('right-pupil');
      
      document.addEventListener('mousemove', function(e) {
        // Get the position of the eyes relative to the viewport
        const leftEyeBounds = document.getElementById('left-eye').getBoundingClientRect();
        const rightEyeBounds = document.getElementById('right-eye').getBoundingClientRect();
        
        // Calculate the center of each eye
        const leftEyeCenter = {
          x: leftEyeBounds.left + leftEyeBounds.width / 2,
          y: leftEyeBounds.top + leftEyeBounds.height / 2
        };
        
        const rightEyeCenter = {
          x: rightEyeBounds.left + rightEyeBounds.width / 2,
          y: rightEyeBounds.top + rightEyeBounds.height / 2
        };
        
        // Calculate the angle between the mouse position and each eye center
        function getEyeMovement(eyeCenter, mousePos, maxMovement = 1) {
          const deltaX = mousePos.x - eyeCenter.x;
          const deltaY = mousePos.y - eyeCenter.y;
          const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY);
          const angle = Math.atan2(deltaY, deltaX);
          
          // Limit the movement to a maximum radius
          const movement = Math.min(distance / 50, maxMovement);
          
          return {
            x: Math.cos(angle) * movement,
            y: Math.sin(angle) * movement
          };
        }
        
        // Apply the movement to the pupils
        const leftEyeMovement = getEyeMovement(leftEyeCenter, { x: e.clientX, y: e.clientY });
        const rightEyeMovement = getEyeMovement(rightEyeCenter, { x: e.clientX, y: e.clientY });
        
        leftEye.style.transform = `translate(${leftEyeMovement.x}px, ${leftEyeMovement.y}px)`;
        rightEye.style.transform = `translate(${rightEyeMovement.x}px, ${rightEyeMovement.y}px)`;
      });
      
      // GSAP animations for page elements
      gsap.from('.settings-card', {
        y: 30,
        opacity: 0,
        duration: 0.5,
        stagger: 0.2,
        ease: 'power2.out'
      });
    });
  </script>
</body>
</html>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>