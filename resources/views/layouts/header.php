<?php
// Path: resources/views/layouts/header.php
$baseUrl = '/Wildlife';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wildlife Haven - Focus and Conservation</title>
  
  <base href="<?= $baseUrl ?>/" />
  <link rel="icon" href="<?= $baseUrl ?>/favicon.ico" type="image/x-icon" />
  
  <!-- Core Libraries -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#2D5A3E',
            secondary: '#D9C589',
            light: '#F9F8F2',
            dark: '#111111'
          },
          fontFamily: {
            display: ['"Playfair Display"', 'serif'],
            sans: ['"Inter"', 'sans-serif']
          }
        }
      }
    }
  </script>
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />
  
  <!-- Custom Styles -->
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/styles.css" />
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    :root {
      --primary: #2D5A3E;
      --secondary: #D9C589;
      --light: #F9F8F2;
      --dark: #111111;
    }
    body {
      margin: 0;
      background-color: var(--light);
      font-family: 'Inter', sans-serif;
      color: var(--dark);
    }
    .brand-title {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      letter-spacing: 0.5px;
    }
    .nav-link {
      position: relative;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -4px;
      left: 0;
      background-color: var(--primary);
      transition: width 0.3s ease;
    }
    .nav-link:hover::after {
      width: 100%;
    }
    .primary-btn {
      background-color: var(--primary);
      transition: all 0.3s ease;
    }
    .primary-btn:hover {
      background-color: #234832;
      transform: translateY(-1px);
    }
    .dropdown-animation {
      transform-origin: top;
      transition: transform 0.2s ease, opacity 0.2s ease;
    }
  </style>
</head>

<body class="min-h-screen flex flex-col">
  
  <!-- Header with Announcement Bar 
  <div class="bg-primary text-white text-center py-2 text-sm">
    <div class="container mx-auto px-4">
      <span class="flex items-center justify-center">
        <i class="fas fa-leaf mr-2"></i> Join our conservation efforts and get 15% off merchandise! 
        <a href="<?= $baseUrl ?>/conservation" class="underline ml-2 font-medium">Learn more</a>
      </span>
    </div>
  </div>
  -->
  
  <!-- Main Navigation -->
  <nav class="w-full bg-light border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Logo -->
      <a href="<?= $baseUrl ?>/" class="flex items-center space-x-2">
        <div class="h-10 w-10 bg-primary rounded-full flex items-center justify-center">
          <i class="fas fa-paw text-white text-lg"></i>
        </div>
        <span class="brand-title text-xl text-dark">Wildlife Haven</span>
      </a>

      <!-- Desktop Navigation -->
      <div class="hidden lg:flex items-center space-x-8 font-medium">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
          <a href="<?= $baseUrl ?>/dashboard" class="nav-link text-dark">Dashboard</a>
          <a href="<?= $baseUrl ?>/creatures" class="nav-link text-dark">Creatures</a>
          <a href="<?= $baseUrl ?>/habitats" class="nav-link text-dark">Habitats</a>
          <div class="relative group">
            <button class="flex items-center nav-link text-dark">
              Explore <i class="fas fa-chevron-down ml-1 text-xs"></i>
            </button>
            <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-md py-2 mt-1 w-48 dropdown-animation">
              <a href="<?= $baseUrl ?>/shop" class="block px-4 py-2 hover:bg-gray-50">Marketplace</a>
              <a href="<?= $baseUrl ?>/conservation" class="block px-4 py-2 hover:bg-gray-50">Conservation</a>
              <a href="<?= $baseUrl ?>/community" class="block px-4 py-2 hover:bg-gray-50">Community</a>
              <a href="<?= $baseUrl ?>/gallery" class="block px-4 py-2 hover:bg-gray-50">Gallery</a>
              <a href="<?= $baseUrl ?>/podcast" class="block px-4 py-2 hover:bg-gray-50">Podcast</a>
            </div>
          </div>
        <?php else: ?>
          <a href="<?= $baseUrl ?>/#features" class="nav-link text-dark">Features</a>
          <a href="<?= $baseUrl ?>/#creature-gallery" class="nav-link text-dark">Creatures</a>
          <a href="<?= $baseUrl ?>/#testimonials" class="nav-link text-dark">Testimonials</a>
          <a href="<?= $baseUrl ?>/podcast" class="nav-link text-dark">Podcast</a>
          <a href="<?= $baseUrl ?>/about" class="nav-link text-dark">About Us</a>
        <?php endif; ?>
      </div>

      <!-- User Actions -->
      <div class="flex items-center space-x-4">
        <!-- Search Button -->
        <button class="text-dark hover:text-primary transition-colors p-2 hidden md:block">
          <i class="fas fa-search"></i>
        </button>
        
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
          <!-- Notifications -->
          <div class="relative hidden md:block">
            <button class="text-dark hover:text-primary transition-colors p-2 relative">
              <i class="fas fa-bell"></i>
              <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
            </button>
          </div>
          
          <!-- User Menu -->
          <div class="relative">
            <button id="user-menu-button" class="flex items-center space-x-2">
              <?php if (!empty($_SESSION['avatar_url'])): ?>
                <img src="<?= htmlspecialchars($_SESSION['avatar_url']) ?>" alt="User Avatar" class="h-9 w-9 rounded-full object-cover border-2 border-primary" />
              <?php else: ?>
                <div class="h-9 w-9 bg-secondary rounded-full flex items-center justify-center border-2 border-primary">
                  <span class="text-sm font-semibold text-primary">
                    <?= substr($_SESSION['username'] ?? 'U', 0, 1) ?>
                  </span>
                </div>
              <?php endif; ?>
              <span class="font-medium hidden md:block"><?= htmlspecialchars($_SESSION['username'] ?? '') ?></span>
              <i class="fas fa-chevron-down text-xs hidden md:block"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-lg py-1 text-gray-700 z-50">
              <div class="px-4 py-2 border-b border-gray-100">
                <p class="font-medium"><?= htmlspecialchars($_SESSION['username'] ?? '') ?></p>
                <p class="text-xs text-gray-500"><?= htmlspecialchars($_SESSION['email'] ?? '') ?></p>
              </div>
              <a href="<?= $baseUrl ?>/dashboard/profile" class="flex items-center px-4 py-2 hover:bg-gray-50">
                <i class="fas fa-user-circle w-5 mr-2 text-primary"></i> Profile
              </a>
              <a href="<?= $baseUrl ?>/dashboard/settings" class="flex items-center px-4 py-2 hover:bg-gray-50">
                <i class="fas fa-cog w-5 mr-2 text-primary"></i> Settings
              </a>
              <hr class="my-1 border-gray-200" />
              <a href="<?= $baseUrl ?>/auth/logout" class="flex items-center px-4 py-2 hover:bg-gray-50 text-red-600">
                <i class="fas fa-sign-out-alt w-5 mr-2"></i> Sign out
              </a>
            </div>
          </div>

          <!-- Focus Button -->
          <a href="<?= $baseUrl ?>/focus" class="primary-btn text-white px-4 py-2 rounded-md font-medium flex items-center">
            <i class="fas fa-leaf mr-2"></i> Focus
          </a>
        <?php else: ?>
          <!-- Sign In / Sign Up -->
          <a href="<?= $baseUrl ?>/auth/login" class="hover:text-primary transition-colors font-medium hidden md:block">Sign In</a>
          <a href="<?= $baseUrl ?>/auth/register" class="primary-btn text-white px-4 py-2 rounded-md font-medium">
            Get Started
          </a>
        <?php endif; ?>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-button" class="lg:hidden ml-2 p-2 rounded-md hover:bg-gray-200">
        <i class="fas fa-bars text-dark"></i>
      </button>
    </div>

    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-200 bg-white shadow-md">
      <!-- Search Bar (Mobile) -->
      <div class="px-4 py-3 border-b border-gray-100">
        <div class="relative">
          <input type="text" placeholder="Search..." class="w-full py-2 pl-10 pr-4 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
          <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
      </div>
      
      <!-- Mobile Menu Links -->
      <div class="px-4 py-3 space-y-3 font-medium">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
          <a href="<?= $baseUrl ?>/dashboard" class="block hover:text-primary">Dashboard</a>
          <a href="<?= $baseUrl ?>/creatures" class="block hover:text-primary">Creatures</a>
          <a href="<?= $baseUrl ?>/habitats" class="block hover:text-primary">Habitats</a>
          <a href="<?= $baseUrl ?>/shop" class="block hover:text-primary">Marketplace</a>
          <a href="<?= $baseUrl ?>/conservation" class="block hover:text-primary">Conservation</a>
          <a href="<?= $baseUrl ?>/community" class="block hover:text-primary">Community</a>
          <a href="<?= $baseUrl ?>/gallery" class="block hover:text-primary">Gallery</a>
          <hr class="border-gray-200" />
          <a href="<?= $baseUrl ?>/dashboard/profile" class="block hover:text-primary">Profile</a>
          <a href="<?= $baseUrl ?>/dashboard/settings" class="block hover:text-primary">Settings</a>
          <a href="<?= $baseUrl ?>/auth/logout" class="block text-red-600">Sign out</a>
        <?php else: ?>
          <a href="<?= $baseUrl ?>/#features" class="block hover:text-primary">Features</a>
          <a href="<?= $baseUrl ?>/#creature-gallery" class="block hover:text-primary">Creatures</a>
          <a href="<?= $baseUrl ?>/#testimonials" class="block hover:text-primary">Testimonials</a>
          <a href="<?= $baseUrl ?>/about" class="block hover:text-primary">About Us</a>
          <hr class="border-gray-200" />
          <a href="<?= $baseUrl ?>/auth/login" class="block hover:text-primary">Sign In</a>
          <a href="<?= $baseUrl ?>/auth/register" class="block primary-btn text-white px-4 py-2 rounded-md text-center mt-2">Get Started</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-grow">