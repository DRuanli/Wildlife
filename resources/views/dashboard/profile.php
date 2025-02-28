<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wildlife Haven - My Profile</title>
  
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
    
    /* Parallax effect */
    .parallax-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      transform: translateZ(-10px) scale(2);
      z-index: -1;
    }
    
    .parallax-container {
      position: relative;
      height: 300px;
      overflow: hidden;
      perspective: 10px;
    }
    
    .parallax-content {
      position: absolute;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      transform-style: preserve-3d;
    }
    
    /* Card styles */
    .profile-card {
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .profile-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 35px -10px rgba(0,0,0,0.15);
    }
    
    /* Avatar container with interactive elements */
    .avatar-container {
      position: relative;
      width: 150px;
      height: 150px;
      margin: 0 auto;
    }
    
    .avatar-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background-color: rgba(0,0,0,0.4);
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .avatar-container:hover .avatar-overlay {
      opacity: 1;
    }
    
    /* Achievement badge styles */
    .achievement-badge {
      position: relative;
      transition: transform 0.3s ease;
    }
    
    .achievement-badge:hover {
      transform: scale(1.05);
    }
    
    .achievement-badge.locked {
      filter: grayscale(1);
      opacity: 0.6;
    }
    
    /* Stats card */
    .stat-card {
      border-radius: 12px;
      transition: all 0.3s ease;
      overflow: hidden;
    }
    
    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* Animated progress bars */
    .progress-bar {
      height: 8px;
      border-radius: 4px;
      background-color: rgba(0,0,0,0.1);
      overflow: hidden;
    }
    
    .progress-fill {
      height: 100%;
      border-radius: 4px;
      transform-origin: left;
      animation: progressFill 1.5s ease-out forwards;
    }
    
    @keyframes progressFill {
      from { transform: scaleX(0); }
      to { transform: scaleX(1); }
    }
    
    /* Animal footprint pattern */
    .footprint-pattern {
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%234D724D' fill-opacity='0.05' fill-rule='evenodd'%3E%3Cpath d='M13.9,17.7c-0.5-0.3-1.1-0.6-1.4-1.2c-0.3-0.6-0.3-1.3-0.2-2c0.1-0.7,0.4-1.4,0.8-1.9c0.4-0.5,1-0.9,1.6-1c0.6-0.1,1.3,0.1,1.8,0.4c0.5,0.3,1.1,0.6,1.4,1.2c0.3,0.6,0.3,1.3,0.2,2c-0.1,0.7-0.4,1.4-0.8,1.9c-0.4,0.5-1,0.9-1.6,1C15,18.2,14.4,18,13.9,17.7z M18.5,11.5c-0.4-0.3-0.9-0.5-1.2-1c-0.3-0.5-0.3-1.1-0.1-1.7c0.1-0.6,0.4-1.2,0.7-1.6c0.4-0.4,0.8-0.7,1.3-0.8c0.5-0.1,1.1,0.1,1.5,0.4c0.4,0.3,0.9,0.5,1.2,1c0.3,0.5,0.3,1.1,0.1,1.7c-0.1,0.6-0.4,1.2-0.7,1.6c-0.4,0.4-0.8,0.7-1.3,0.8C19.5,12,19,11.8,18.5,11.5z M9.9,11.5c-0.4-0.3-0.9-0.5-1.2-1c-0.3-0.5-0.3-1.1-0.1-1.7c0.1-0.6,0.4-1.2,0.7-1.6c0.4-0.4,0.8-0.7,1.3-0.8c0.5-0.1,1.1,0.1,1.5,0.4c0.4,0.3,0.9,0.5,1.2,1c0.3,0.5,0.3,1.1,0.1,1.7c-0.1,0.6-0.4,1.2-0.7,1.6c-0.4,0.4-0.8,0.7-1.3,0.8C10.9,12,10.3,11.8,9.9,11.5z M22.9,17.7c-0.5-0.3-1.1-0.6-1.4-1.2c-0.3-0.6-0.3-1.3-0.2-2c0.1-0.7,0.4-1.4,0.8-1.9c0.4-0.5,1-0.9,1.6-1c0.6-0.1,1.3,0.1,1.8,0.4c0.5,0.3,1.1,0.6,1.4,1.2c0.3,0.6,0.3,1.3,0.2,2c-0.1,0.7-0.4,1.4-0.8,1.9c-0.4,0.5-1,0.9-1.6,1C24.1,18.2,23.4,18,22.9,17.7z'/%3E%3C/g%3E%3C/svg%3E");
    }
    
    /* Breathing animation for elements */
    .breathing {
      animation: breathing 8s ease-in-out infinite;
    }
    
    @keyframes breathing {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.03); }
    }
    
    /* Floating animation for decorative elements */
    .float {
      animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
    }
    
    /* Animation for numbers */
    .animate-number {
      display: inline-block;
      opacity: 0;
      transform: translateY(10px);
    }
    
    /* Profile chart container */
    .chart-container {
      position: relative;
      height: 250px;
    }
  </style>
</head>



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
      <!-- Parallax Header with User's Habitat -->
      <div class="parallax-container mb-10 rounded-2xl overflow-hidden">
        <div class="parallax-bg" style="background-image: url('https://images.unsplash.com/photo-1473773508845-188df298d2d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1050&q=80');"></div>
        <div class="parallax-content">
          <div class="text-center text-white z-10 px-4">
            <h1 class="headline text-4xl mb-2 text-shadow-lg">Your Wildlife Profile</h1>
            <p class="text-shadow-md">Where your focus creates a thriving ecosystem</p>
          </div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Information Column -->
        <div class="lg:col-span-1">
          <!-- Profile Card -->
          <div class="profile-card bg-white mb-8 p-0 overflow-hidden">
            <!-- Banner Image for Profile Card -->
            <div class="h-32 bg-gradient-to-r from-green-600 to-emerald-400 relative overflow-hidden">
              <!-- Animated shapes (like leaves or animals) -->
              <div class="absolute top-3 right-10">
                <svg class="w-8 h-8 text-white/40 float" style="animation-delay: -2s" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12.92,5.6c-0.3-0.5-0.9-0.5-1.3-0.1c-0.9,1-2.1,2.4-2.6,3.2C8.5,9.5,8,10.4,7.6,11.4S7,13.5,7,14.6c0,2.8,2.2,5,5,5 s5-2.2,5-5c0-1.1-0.2-2.6-0.6-3.6s-0.9-1.9-1.5-2.8C14.4,7.4,13.2,6.1,12.92,5.6z"/>
                </svg>
              </div>
              <div class="absolute top-5 left-10">
                <svg class="w-6 h-6 text-white/30 float" style="animation-delay: -4s" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M4.10257 8.30643L5.39764 7.8674L4.10257 8.30643ZM4.73654 5.91281L3.44147 6.35184V6.35184L4.73654 5.91281ZM19.2635 5.91281L20.5585 6.35184L19.2635 5.91281ZM19.8974 8.30643L18.6024 7.8674L18.6024 7.8674L19.8974 8.30643ZM17.5 14L17.5 15L17.5 14ZM6.5 14L6.5 13H6.5L6.5 14ZM3.44147 6.35184C3.5261 6.10396 3.50471 5.92282 3.45948 5.80251C3.41425 5.68219 3.31643 5.56427 3.09944 5.45043C2.67419 5.22964 2.07982 5.22202 1.66916 5.61194C1.25229 6.00772 1.23631 6.66644 1.60307 7.09297L3.44147 6.35184ZM4.80751 8.7454C4.33921 8.9074 4.05232 9.00042 3.84594 9.05271C3.64452 9.10356 3.58338 9.09241 3.55527 9.0851C3.52715 9.07779 3.4834 9.0423 3.39255 8.86898C3.29955 8.69103 3.246 8.41002 3.31548 7.92525C3.38284 7.45296 3.55049 6.99354 3.79942 6.58335L5.39764 7.8674C5.3513 7.93522 5.31297 8.00776 5.28375 8.08379C5.25986 8.14704 5.24728 8.20542 5.24299 8.25366C5.23915 8.29537 5.2447 8.29824 5.23165 8.26787C5.21859 8.2375 5.21252 8.16221 5.32593 8.00398C5.44224 7.84178 5.63549 7.71045 6.10257 7.54832L4.80751 8.7454ZM3.79942 6.58335C4.0063 6.22356 4.27992 5.91536 4.60111 5.6744L5.87197 7.00304C5.80233 7.05547 5.74454 7.11657 5.69864 7.18466L3.79942 6.58335ZM4.60111 5.6744C4.97189 5.39221 5.40191 5.2044 5.85689 5.12831L6.14311 7.10541C6.0448 7.12371 5.95387 7.15633 5.87197 7.00304L4.60111 5.6744ZM5.85689 5.12831C6.30923 5.05261 6.76964 5.08811 7.20433 5.23195L6.46234 7.16454C6.36023 7.1208 6.23904 7.08763 6.14311 7.10541L5.85689 5.12831ZM7.20433 5.23195C7.63901 5.37578 8.03612 5.62378 8.36454 5.95565L6.96214 7.34757C6.88753 7.27233 6.56445 7.20829 6.46234 7.16454L7.20433 5.23195ZM8.36454 5.95565C8.69603 6.29067 8.94323 6.69108 9.08526 7.1286L7.16003 7.89782C7.11574 7.79251 7.03367 7.42588 6.96214 7.34757L8.36454 5.95565ZM9.08526 7.1286C9.22729 7.56612 9.26026 8.02941 9.18174 8.4837L7.20759 8.18001C7.22511 8.08193 7.20431 8.00313 7.16003 7.89782L9.08526 7.1286ZM9.18174 8.4837C9.10321 8.93798 8.91343 9.36657 8.63006 9.7349L7.32089 8.45195C7.38802 8.39675 7.1901 8.27809 7.20759 8.18001L9.18174 8.4837ZM8.63006 9.7349C8.34705 10.103 7.97905 10.3992 7.55495 10.5952L6.77924 8.73478C6.86133 8.69437 6.25377 8.5071 7.32089 8.45195L8.63006 9.7349ZM7.55495 10.5952C7.13175 10.7915 6.66747 10.8833 6.20083 10.862L6.29917 8.86517C6.41584 8.872 6.69714 8.77519 6.77924 8.73478L7.55495 10.5952ZM6.20083 10.862C5.96493 10.8504 5.51175 10.7921 5.053 10.6334C4.61392 10.4807 4.25411 10.2785 3.94228 10.0495C3.18057 9.5001 2.41421 8.73374 2.41421 8.73374L3.82843 7.31952C3.82843 7.31952 4.46943 7.96053 5.03269 8.34732C5.32929 8.55399 5.56288 8.67273 5.76048 8.74054C5.9584 8.80861 6.09003 8.81913 6.29917 8.86517L6.20083 10.862ZM17.8519 5.6744C18.172 5.91582 18.4448 6.22379 18.6513 6.58335L16.7521 7.18466C16.7065 7.11739 16.6493 7.05695 16.5803 7.0051L17.8519 5.6744ZM18.6513 6.58335C18.9002 6.99354 19.0679 7.45296 19.1352 7.92525L17.1513 8.08379C17.142 8.00776 17.1037 7.93522 17.0573 7.8674L18.6513 6.58335ZM19.1352 7.92525C19.2047 8.41002 19.1511 8.69103 19.0581 8.86898C18.9673 9.0423 18.9235 9.07779 18.8954 9.0851C18.8673 9.09241 18.8062 9.10356 18.6047 9.05271C18.3984 9.00042 18.1115 8.9074 17.6432 8.7454L18.9382 7.54832C19.4053 7.71045 19.5985 7.84178 19.7148 8.00398C19.8282 8.16221 19.8222 8.2375 19.8091 8.26787C19.796 8.29824 19.8016 8.29537 19.7977 8.25366C19.7934 8.20542 19.7809 8.14704 19.757 8.08379L19.1352 7.92525ZM17.6432 8.7454C17.1752 7.91045 16.2647 7.30253 15.2057 7.16454L15.4615 5.18744C17.1384 5.42392 18.5742 6.43326 18.9382 7.54832L17.6432 8.7454ZM15.2057 7.16454C14.1456 7.02637 13.0842 7.38805 12.3333 8.13896L10.9191 6.72474C12.1229 5.52091 13.7856 4.95115 15.4615 5.18744L15.2057 7.16454ZM12.3333 8.13896C11.5831 8.88953 11.2195 9.95092 11.3557 11.0129L9.37863 11.2687C9.13446 9.59067 9.7066 7.92926 10.9191 6.72474L12.3333 8.13896ZM11.3557 11.0129C11.4918 12.0738 12.0976 12.9862 12.9333 13.457L12.0667 15.0192C10.7332 14.3012 9.61262 12.9457 9.37863 11.2687L11.3557 11.0129ZM18.1969 5.45043C17.9799 5.56427 17.8821 5.68219 17.8369 5.80251C17.7916 5.92282 17.7702 6.10396 17.8549 6.35184L20.5585 6.35184C20.9252 5.92531 20.9092 5.2666 20.4924 4.87081C20.0817 4.48089 19.4873 4.48851 19.0621 4.70931L18.1969 5.45043ZM22.3979 7.09297C22.7647 6.66644 22.7487 6.00772 22.3318 5.61194C21.9212 5.22202 21.3268 5.22964 20.9016 5.45043C20.6846 5.56427 20.5868 5.68219 20.5415 5.80251C20.4963 5.92282 20.4749 6.10396 20.5595 6.35184L22.3979 7.09297ZM16.0003 15.457C15.1646 14.9862 14.5588 14.0738 14.4227 13.0129L16.3998 12.7571C16.6338 14.4342 17.7544 15.7896 19.0879 16.5076L16.0003 15.457ZM14.4227 13.0129C14.2865 11.9509 14.6501 10.8895 15.4003 10.139L16.8145 11.5532C16.0637 12.3041 15.3658 11.5 16.3998 12.7571L14.4227 13.0129ZM15.4003 10.139C16.1513 9.38805 17.2127 9.02637 18.2728 9.16454L18.0169 11.1416C16.341 10.9054 14.6784 11.4751 16.8145 11.5532L15.4003 10.139ZM18.2728 9.16454C19.3318 9.30253 20.2422 9.91045 20.7103 10.7454L19.4153 11.9425C19.0512 10.8274 17.6154 9.81807 18.0169 11.1416L18.2728 9.16454ZM16.5 14C16.5 13.9125 16.5042 13.8316 16.5112 13.7553L18.5021 13.9305C18.5007 13.9536 18.5 13.9768 18.5 14H16.5ZM16.5112 13.7553C16.5669 13.1492 16.8524 12.5814 17.3191 12.1829L18.6809 13.7399C18.5476 13.8534 18.4752 14.0093 18.5021 13.9305L16.5112 13.7553ZM17.3191 12.1829C17.7869 11.7834 18.4139 11.5777 19.0225 11.6247L18.8642 13.6151C18.6861 13.6006 18.8131 13.6273 18.6809 13.7399L17.3191 12.1829ZM19.0225 11.6247C19.6286 11.6715 20.1964 11.9569 20.5948 12.4237L19.0379 13.7854C18.9244 13.6521 18.7686 13.5797 18.8642 13.6151L19.0225 11.6247ZM20.5948 12.4237C20.9944 12.8915 21.2 13.5186 21.153 14.1271L19.1626 13.9689C19.1771 13.7907 19.1504 13.9178 19.0379 13.7854L20.5948 12.4237ZM21.153 14.1271C21.1062 14.7333 20.8209 15.3011 20.3541 15.6995L18.9972 14.2015C19.1306 14.0881 19.4629 14.0272 19.1626 13.9689L21.153 14.1271ZM20.3541 15.6995C19.8864 16.0991 19.2593 16.3047 18.6507 16.2577L18.809 14.2673C18.9872 14.2819 18.8649 14.3139 18.9972 14.2015L20.3541 15.6995ZM18.6507 16.2577C18.0447 16.2109 17.477 15.9257 17.0785 15.459L18.5365 14.0973C18.6498 14.2306 18.8057 14.3029 18.809 14.2673L18.6507 16.2577ZM7.48884 13.7553C7.49576 13.8316 7.5 13.9125 7.5 14H5.5C5.5 13.9768 5.49934 13.9536 5.49787 13.9305L7.48884 13.7553ZM7.48884 13.7553C7.54467 13.1492 7.83006 12.5814 8.29682 12.1829L9.65863 13.7399C9.52533 13.8534 9.45295 14.0093 9.47985 13.9305L7.48884 13.7553ZM8.29682 12.1829C8.76453 11.7834 9.39156 11.5777 10.0001 11.6247L9.84187 13.6151C9.66373 13.6006 9.79066 13.6273 9.65863 13.7399L8.29682 12.1829ZM10.0001 11.6247C10.6062 11.6715 11.174 11.9569 11.5724 12.4237L10.0154 13.7854C9.90201 13.6521 9.74613 13.5797 9.84187 13.6151L10.0001 11.6247ZM11.5724 12.4237C11.972 12.8915 12.1775 13.5186 12.1306 14.1271L10.1402 13.9689C10.1547 13.7907 10.128 13.9178 10.0154 13.7854L11.5724 12.4237ZM12.1306 14.1271C12.0838 14.7333 11.7984 15.3011 11.3317 15.6995L9.9748 14.2015C10.1082 14.0881 10.4405 14.0272 10.1402 13.9689L12.1306 14.1271ZM11.3317 15.6995C10.864 16.0991 10.2369 16.3047 9.62835 16.2577L9.78661 14.2673C9.96473 14.2819 9.84241 14.3139 9.9748 14.2015L11.3317 15.6995ZM9.62835 16.2577C9.02229 16.2109 8.45454 15.9257 8.05607 15.459L9.51407 14.0973C9.62738 14.2306 9.78328 14.3029 9.78661 14.2673L9.62835 16.2577Z"/>
                </svg>
              </div>
              <div class="absolute bottom-2 left-20">
                <svg class="w-10 h-10 text-white/20 float" style="animation-delay: -1s" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M21.721 12.752a9.711 9.711 0 00-.945-5.003 12.754 12.754 0 01-4.339 2.708 18.991 18.991 0 01-.214 4.772 17.165 17.165 0 005.498-2.477zM14.634 15.55a17.324 17.324 0 00.332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 00.332 4.647 17.385 17.385 0 005.268 0zM9.772 17.119a18.963 18.963 0 004.456 0A17.182 17.182 0 0112 21.724a17.18 17.18 0 01-2.228-4.605zM7.777 15.23a18.87 18.87 0 01-.214-4.774 12.753 12.753 0 01-4.34-2.708 9.711 9.711 0 00-.944 5.004 17.165 17.165 0 005.498 2.477zM21.356 14.752a9.765 9.765 0 01-7.478 6.817 18.64 18.64 0 001.988-4.718 18.627 18.627 0 005.49-2.098zM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 001.988 4.718 9.765 9.765 0 01-7.478-6.816zM13.878 2.43a9.755 9.755 0 016.116 3.986 11.267 11.267 0 01-3.746 2.504 18.63 18.63 0 00-2.37-6.49zM12 2.276a17.152 17.152 0 012.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0112 2.276zM10.122 2.43a18.629 18.629 0 00-2.37 6.49 11.266 11.266 0 01-3.746-2.504 9.754 9.754 0 016.116-3.985z" />
                </svg>
              </div>
            </div>
            
            <!-- User Avatar and Upload Interface -->
            <div class="flex flex-col items-center -mt-16 mb-6 px-6" x-data="{ avatarUrl: '<?= !empty($user['avatar_url']) ? htmlspecialchars($user['avatar_url']) : '' ?>' }">
              <div class="avatar-container">
                <template x-if="avatarUrl">
                  <img :src="avatarUrl" alt="Profile Avatar" class="w-32 h-32 rounded-full border-4 border-white object-cover">
                </template>
                <template x-if="!avatarUrl">
                  <div class="w-32 h-32 rounded-full bg-gradient-to-br from-green-600 to-green-400 border-4 border-white flex items-center justify-center text-white text-4xl font-bold">
                    <?= strtoupper(substr($user['username'] ?? 'U', 0, 1)) ?>
                  </div>
                </template>
                <label class="avatar-overlay cursor-pointer">
                  <span class="bg-green-600 rounded-full p-2">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                  </span>
                  <input type="file" name="avatar" accept="image/*" class="hidden"
                         @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { avatarUrl = e.target.result }; reader.readAsDataURL(file); }">
                </label>
              </div>
              <h2 class="text-2xl font-bold mt-4"><?= htmlspecialchars($user['username'] ?? 'User') ?></h2>
              <p class="text-gray-600"><?= htmlspecialchars($user['email'] ?? 'email@example.com') ?></p>
              
              <!-- User Bio -->
              <div class="w-full mt-4 p-4 bg-green-50 rounded-lg">
                <h3 class="font-semibold text-green-800 flex items-center mb-2">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  About Me
                </h3>
                <p class="text-gray-700"><?= htmlspecialchars($user['bio'] ?? 'No bio provided yet. Tell the world about your focus journey!') ?></p>
              </div>
            </div>
            
            <!-- Edit Profile Form -->
            <form action="<?= $baseUrl ?>/dashboard/profile/update" method="POST" enctype="multipart/form-data" class="px-6 pb-6">
              <div class="space-y-4">
                <div>
                  <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                      </svg>
                    </div>
                    <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                  </div>
                </div>
                
                <div>
                  <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                  <div class="relative">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                      <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                    </div>
                    <textarea name="bio" id="bio" rows="3"
                              class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                  </div>
                  <p class="mt-1 text-xs text-gray-500">Share something about your focus journey (200 characters max)</p>
                </div>
                
                <div class="pt-4">
                  <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    Save Profile Changes
                  </button>
                </div>
              </div>
            </form>
          </div>
          
          <!-- Creature Cards section -->
          <div class="profile-card bg-white p-6">
            <h3 class="font-bold text-lg mb-4 flex items-center">
              <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
              </svg>
              Your Favorite Creatures
            </h3>
            
            <div class="space-y-4">
              <!-- Creature Card 1 -->
              <div class="bg-gradient-to-br from-blue-50 to-green-50 p-3 rounded-lg flex items-center">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                  <i class="fas fa-dragon text-blue-500 text-2xl"></i>
                </div>
                <div>
                  <h4 class="font-semibold">Aquaris</h4>
                  <p class="text-sm text-gray-600">Water Dragon • Adult</p>
                  <div class="flex items-center mt-1">
                    <div class="w-24 bg-gray-200 h-1.5 rounded-full overflow-hidden">
                      <div class="bg-blue-500 h-full" style="width: 85%"></div>
                    </div>
                    <span class="text-xs text-gray-500 ml-2">85%</span>
                  </div>
                </div>
              </div>
              
              <!-- Creature Card 2 -->
              <div class="bg-gradient-to-br from-amber-50 to-red-50 p-3 rounded-lg flex items-center">
                <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mr-4">
                  <i class="fas fa-fire text-amber-500 text-2xl"></i>
                </div>
                <div>
                  <h4 class="font-semibold">Ember</h4>
                  <p class="text-sm text-gray-600">Fire Phoenix • Adult</p>
                  <div class="flex items-center mt-1">
                    <div class="w-24 bg-gray-200 h-1.5 rounded-full overflow-hidden">
                      <div class="bg-amber-500 h-full" style="width: 92%"></div>
                    </div>
                    <span class="text-xs text-gray-500 ml-2">92%</span>
                  </div>
                </div>
              </div>
              
              <a href="<?= $baseUrl ?>/creatures" class="block text-center text-green-600 hover:text-green-800 font-medium">
                View All Creatures
                <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Stats and Achievements Column -->
        <div class="lg:col-span-2">
          <!-- Focus Stats Card -->
          <div class="profile-card bg-white mb-8">
            <div class="p-6 border-b border-gray-100">
              <h3 class="font-bold text-lg flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Focus Journey Statistics
              </h3>
            </div>
            
            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Focus Time Stat -->
                <div class="stat-card p-4" style="background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);">
                  <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: rgba(37, 99, 235, 0.1);">
                      <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <div class="flex flex-col items-end">
                      <span class="text-xs text-blue-600 font-semibold">FOCUS TIME</span>
                      <h4 class="text-2xl font-bold text-blue-800">
                        <?= floor(($user['total_focus_time'] ?? 0) / 60) ?><span class="text-sm">h</span> <?= ($user['total_focus_time'] ?? 0) % 60 ?><span class="text-sm">m</span>
                      </h4>
                    </div>
                  </div>
                  <div class="progress-bar">
                    <div class="progress-fill bg-blue-500" style="width: 78%"></div>
                  </div>
                  <div class="flex justify-between mt-2 text-xs text-gray-600">
                    <span>Monthly Goal: 24h</span>
                    <span>78% Complete</span>
                  </div>
                </div>
                
                <!-- Current Streak Stat -->
                <div class="stat-card p-4" style="background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);">
                  <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: rgba(217, 119, 6, 0.1);">
                      <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                      </svg>
                    </div>
                    <div class="flex flex-col items-end">
                      <span class="text-xs text-amber-600 font-semibold">CURRENT STREAK</span>
                      <h4 class="text-2xl font-bold text-amber-800">
                        <?= $user['streak_days'] ?? 0 ?><span class="text-sm"> days</span>
                      </h4>
                    </div>
                  </div>
                  <div class="progress-bar">
                    <div class="progress-fill bg-amber-500" style="width: 65%"></div>
                  </div>
                  <div class="flex justify-between mt-2 text-xs text-gray-600">
                    <span>Best Streak: 21 days</span>
                    <span>Keep it up!</span>
                  </div>
                </div>
                
                <!-- Focus Score Stat -->
                <div class="stat-card p-4" style="background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);">
                  <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: rgba(5, 150, 105, 0.1);">
                      <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                      </svg>
                    </div>
                    <div class="flex flex-col items-end">
                      <span class="text-xs text-emerald-600 font-semibold">AVG FOCUS SCORE</span>
                      <h4 class="text-2xl font-bold text-emerald-800">
                        87<span class="text-sm">%</span>
                      </h4>
                    </div>
                  </div>
                  <div class="progress-bar">
                    <div class="progress-fill bg-emerald-500" style="width: 87%"></div>
                  </div>
                  <div class="flex justify-between mt-2 text-xs text-gray-600">
                    <span>Last week: 82%</span>
                    <span>↑ 5%</span>
                  </div>
                </div>
              </div>
              
              <!-- Focus Chart -->
              <div x-data="{ showChart: false }">
                <button @click="showChart = !showChart" class="flex items-center text-green-600 hover:text-green-800 font-medium mb-4">
                  <span x-text="showChart ? 'Hide Focus Chart' : 'Show Focus Chart'"></span>
                  <svg x-bind:class="showChart ? 'transform rotate-180' : ''" class="w-5 h-5 ml-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </button>
                
                <div x-show="showChart" x-transition class="p-4 bg-white rounded-lg border border-gray-100">
                  <div class="chart-container">
                    <canvas id="focusHistoryChart"></canvas>
                  </div>
                </div>
              </div>
              
              <!-- Conservation Impact -->
              <div class="mt-8">
                <h4 class="font-semibold text-lg mb-3 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  Your Conservation Impact
                </h4>
                
                <div class="grid grid-cols-3 gap-4">
                  <div class="bg-green-50 p-3 rounded-lg text-center">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-2">
                      <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                      </svg>
                    </div>
                    <div>
                      <span class="block text-xl font-bold text-green-800">12</span>
                      <span class="text-sm text-green-600">Trees Planted</span>
                    </div>
                  </div>
                  
                  <div class="bg-blue-50 p-3 rounded-lg text-center">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-2">
                      <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                      </svg>
                    </div>
                    <div>
                      <span class="block text-xl font-bold text-blue-800">4</span>
                      <span class="text-sm text-blue-600">Wildlife Protected</span>
                    </div>
                  </div>
                  
                  <div class="bg-amber-50 p-3 rounded-lg text-center">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-2">
                      <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <div>
                      <span class="block text-xl font-bold text-amber-800">$18</span>
                      <span class="text-sm text-amber-600">Donated</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Achievements Card -->
          <div class="profile-card bg-white">
            <div class="p-6 border-b border-gray-100">
              <h3 class="font-bold text-lg flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
                Wildlife Achievements
              </h3>
            </div>
            
            <?php if (empty($achievements)): ?>
              <!-- Achievement Onboarding -->
              <div class="p-8 text-center bg-gradient-to-br from-green-50 to-emerald-50 breathing">
                <img src="<?= $baseUrl ?>/assets/images/achievement_empty.svg" alt="No achievements yet" class="w-32 h-32 mx-auto mb-4 opacity-80">
                <h4 class="text-lg font-semibold text-green-800 mb-2">Your achievement journey begins!</h4>
                <p class="text-gray-600 mb-4">Stay focused and unlock badges as you progress. Each achievement is a milestone in your focus journey.</p>
                <a href="<?= $baseUrl ?>/focus" class="inline-block bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition">Start Focusing</a>
              </div>
            <?php else: ?>
              <!-- Achievement Grid with Animation and Effects -->
              <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Achievement 1 - Early Bird (Unlocked) -->
                <div class="achievement-badge text-center">
                  <div class="h-20 w-20 mx-auto mb-2 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full p-4 shadow-lg">
                    <svg class="w-full h-full text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                  </div>
                  <h5 class="font-medium">Early Bird</h5>
                  <p class="text-xs text-gray-500">Complete 5 focus sessions before 9 AM</p>
                  <div class="text-xs text-green-600 mt-1">
                    <i class="fas fa-check-circle"></i> Earned
                  </div>
                </div>
                
                <!-- Achievement 2 - Focus Master (Unlocked) -->
                <div class="achievement-badge text-center">
                  <div class="h-20 w-20 mx-auto mb-2 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full p-4 shadow-lg">
                    <svg class="w-full h-full text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"></path>
                    </svg>
                  </div>
                  <h5 class="font-medium">Focus Master</h5>
                  <p class="text-xs text-gray-500">Maintain 90%+ focus score for 5 consecutive sessions</p>
                  <div class="text-xs text-green-600 mt-1">
                    <i class="fas fa-check-circle"></i> Earned
                  </div>
                </div>
                
                <!-- Achievement 3 - Nurturing Soul (Unlocked) -->
                <div class="achievement-badge text-center">
                  <div class="h-20 w-20 mx-auto mb-2 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full p-4 shadow-lg">
                    <svg class="w-full h-full text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                    </svg>
                  </div>
                  <h5 class="font-medium">Nurturing Soul</h5>
                  <p class="text-xs text-gray-500">Evolve your first creature to adult stage</p>
                  <div class="text-xs text-green-600 mt-1">
                    <i class="fas fa-check-circle"></i> Earned
                  </div>
                </div>
                
                <!-- Achievement 4 - Dragon Tamer (Locked) -->
                <div class="achievement-badge text-center locked">
                  <div class="h-20 w-20 mx-auto mb-2 bg-gradient-to-br from-gray-300 to-gray-500 rounded-full p-4 shadow-lg relative">
                    <svg class="w-full h-full text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path d="M13 7H7v6h6V7z" />
                      <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1V9H2a1 1 0 010-2h1V5a2 2 0 012-2h2V2zM5 5h10v10H5V5z" clip-rule="evenodd" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                      <svg class="w-10 h-10 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                  </div>
                  <h5 class="font-medium">Dragon Tamer</h5>
                  <p class="text-xs text-gray-500">Evolve a dragon to mythical stage</p>
                  <div class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-lock"></i> Locked
                  </div>
                </div>
                
                <!-- Achievement 5 - Tree Hugger (Locked) -->
                <div class="achievement-badge text-center locked">
                  <div class="h-20 w-20 mx-auto mb-2 bg-gradient-to-br from-gray-300 to-gray-500 rounded-full p-4 shadow-lg relative">
                    <svg class="w-full h-full text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8l3-4z" clip-rule="evenodd"></path>
                      <path fill-rule="evenodd" d="M8 1a3 3 0 0 0-2.83 2H5a2 2 0 0 0-2 2v1h10V5a2 2 0 0 0-2-2h-.17A3 3 0 0 0 8 1zm0 1a2 2 0 0 1 2 2l-4 0a2 2 0 0 1 2-2z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                      <svg class="w-10 h-10 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                  </div>
                  <h5 class="font-medium">Tree Hugger</h5>
                  <p class="text-xs text-gray-500">Plant 20 trees through focus sessions</p>
                  <div class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-lock"></i> Locked
                  </div>
                </div>
                
                <!-- Achievement 6 - Streak Warrior (Locked) -->
                <div class="achievement-badge text-center locked">
                  <div class="h-20 w-20 mx-auto mb-2 bg-gradient-to-br from-gray-300 to-gray-500 rounded-full p-4 shadow-lg relative">
                    <svg class="w-full h-full text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                      <svg class="w-10 h-10 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                  </div>
                  <h5 class="font-medium">Streak Warrior</h5>
                  <p class="text-xs text-gray-500">Maintain a 30-day focus streak</p>
                  <div class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-lock"></i> Locked
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Initialize Scripts -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // GSAP animations for page elements
      gsap.registerPlugin(ScrollTrigger);
      
      // Animate in the cards
      gsap.from('.profile-card', {
        y: 30,
        opacity: 0,
        duration: 0.5,
        stagger: 0.2,
        ease: 'power2.out'
      });
      
      // Animate stat numbers
      const statCards = document.querySelectorAll('.stat-card');
      statCards.forEach(card => {
        const numberElement = card.querySelector('h4');
        const originalText = numberElement.textContent;
        const onlyNumbers = originalText.replace(/\D/g, '');
        const hasDecimal = originalText.includes('.');
        let targetNumber = parseInt(onlyNumbers, 10);
        
        // Only animate if we have a proper number
        if (!isNaN(targetNumber) && targetNumber > 0) {
          numberElement.textContent = '0';
          
          gsap.to({val: 0}, {
            val: targetNumber,
            duration: 2,
            delay: 0.5,
            ease: 'power2.out',
            onUpdate: function() {
              const currentValue = Math.round(this.targets()[0].val);
              // Reconstruct the string with the same format as original
              numberElement.textContent = originalText.replace(onlyNumbers, currentValue);
            }
          });
        }
      });
      
      // Initialize focus history chart if present
      const chartCtx = document.getElementById('focusHistoryChart');
      if (chartCtx) {
        const chart = new Chart(chartCtx, {
          type: 'line',
          data: {
            labels: ['7 days ago', '6 days ago', '5 days ago', '4 days ago', '3 days ago', '2 days ago', 'Yesterday', 'Today'],
            datasets: [{
              label: 'Focus Minutes',
              data: [45, 60, 75, 30, 90, 65, 85, 50],
              borderColor: 'rgba(77, 114, 77, 1)',
              backgroundColor: 'rgba(77, 114, 77, 0.1)',
              tension: 0.3,
              fill: true
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: true,
                position: 'top'
              },
              tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                titleColor: '#111827',
                bodyColor: '#374151',
                borderColor: '#E5E7EB',
                borderWidth: 1,
                cornerRadius: 8,
                boxPadding: 4,
                usePointStyle: true
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Minutes',
                  color: '#4D724D',
                  font: {
                    size: 12,
                    weight: 'normal'
                  }
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }
      
      // Set up parallax effect
      const parallaxElements = document.querySelectorAll('.parallax-bg');
      window.addEventListener('scroll', function() {
        parallaxElements.forEach(element => {
          // Get the parent container's position
          const container = element.closest('.parallax-container');
          const rect = container.getBoundingClientRect();
          
          // Calculate the parallax effect based on the scroll position
          // Only apply the effect when the container is in view
          if (rect.top < window.innerHeight && rect.bottom > 0) {
            // Calculate the distance scrolled within the container
            const containerDistanceFromTop = window.scrollY + rect.top;
            const scrollPosition = window.scrollY - containerDistanceFromTop;
            const parallaxValue = scrollPosition * 0.4; // Adjust this value for more/less effect
            
            element.style.transform = `translateY(${parallaxValue}px)`;
          }
        });
      });
    });
  </script>
</body>
</html>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
