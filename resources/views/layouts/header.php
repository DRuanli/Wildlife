<?php
// Path: resources/views/layouts/header.php

// Thêm đường dẫn cơ sở
$baseUrl = '/Wildlife';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wildlife Haven - Focus and Conservation</title>
  
  <!-- Base URL -->
  <base href="<?= $baseUrl ?>/" />
  
  <!-- Favicon -->
  <link rel="icon" href="<?= $baseUrl ?>/favicon.ico" type="image/x-icon" />
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Google Fonts (Playfair Display & Inter) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@500;700&display=swap"
    rel="stylesheet"
  />
  
  <!-- Custom Styles -->
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/styles.css" />
  
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
  />

  <!-- Inline Styles for Header -->
  <style>
    :root {
      --anthropic-bg: #F9F8F2; /* Light, near-white background */
      --anthropic-text: #111;  /* Dark text color */
    }
    body {
      margin: 0;
      background-color: var(--anthropic-bg);
      font-family: 'Inter', Helvetica, Arial, sans-serif;
      color: var(--anthropic-text);
    }
    /* Brand Name in Playfair Display */
    .brand-title {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      font-size: 1.5rem;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }
  </style>
</head>

<body class="min-h-screen flex flex-col">
  <!-- Header / Nav -->
  <nav class="w-full bg-[var(--anthropic-bg)] border-b border-gray-200">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Left: Logo/Brand -->
      <a href="<?= $baseUrl ?>/" class="flex items-center space-x-2">
        <!-- If you have a logo image, you can uncomment below:
        <img src="<?= $baseUrl ?>/images/logo.png" alt="Wildlife Haven Logo" class="h-8 w-auto" />
        -->
        <span class="brand-title text-[var(--anthropic-text)]">Wildlife Haven</span>
      </a>

      <!-- Center / Primary Nav Links -->
      <div class="hidden md:flex items-center space-x-6 font-medium">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
          <a href="<?= $baseUrl ?>/dashboard" class="hover:underline">Dashboard</a>
          <a href="<?= $baseUrl ?>/creatures" class="hover:underline">Creatures</a>
          <a href="<?= $baseUrl ?>/habitats" class="hover:underline">Habitats</a>
          <a href="<?= $baseUrl ?>/shop" class="hover:underline">Marketplace</a>
          <a href="<?= $baseUrl ?>/conservation" class="hover:underline">Conservation</a>
          <a href="<?= $baseUrl ?>/community" class="hover:underline">Community</a>
        <?php else: ?>
          <!-- Feel free to adjust or rename these if you prefer fewer items -->
          <a href="<?= $baseUrl ?>/#features" class="hover:underline">Features</a>
          <a href="<?= $baseUrl ?>/#creature-gallery" class="hover:underline">Creatures</a>
          <a href="<?= $baseUrl ?>/#testimonials" class="hover:underline">Testimonials</a>
        <?php endif; ?>
      </div>

      <!-- Right: CTA or Session Buttons -->
      <div class="flex items-center space-x-4">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
          <!-- User Dropdown -->
          <div class="relative">
            <button id="user-menu-button" class="flex items-center space-x-2">
              <?php if (!empty($_SESSION['avatar_url'])): ?>
                <img
                  src="<?= htmlspecialchars($_SESSION['avatar_url']) ?>"
                  alt="User Avatar"
                  class="h-8 w-8 rounded-full object-cover"
                />
              <?php else: ?>
                <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                  <span class="text-sm font-semibold text-gray-700">
                    <?= substr($_SESSION['username'] ?? 'U', 0, 1) ?>
                  </span>
                </div>
              <?php endif; ?>
              <span class="font-medium"><?= htmlspecialchars($_SESSION['username'] ?? '') ?></span>
              <i class="fa fa-caret-down"></i>
            </button>

            <!-- Dropdown Menu -->
            <div
              id="user-menu"
              class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-lg py-1 text-gray-700 z-50"
            >
              <a
                href="<?= $baseUrl ?>/dashboard/profile"
                class="block px-4 py-2 hover:bg-gray-100"
              >Profile</a>
              <a
                href="<?= $baseUrl ?>/dashboard/settings"
                class="block px-4 py-2 hover:bg-gray-100"
              >Settings</a>
              <hr class="my-1 border-gray-200" />
              <a
                href="<?= $baseUrl ?>/auth/logout"
                class="block px-4 py-2 hover:bg-gray-100"
              >Sign out</a>
            </div>
          </div>

          <!-- CTA Button (Example: 'Focus') -->
          <a
            href="<?= $baseUrl ?>/focus"
            class="bg-black text-white px-4 py-2 rounded hover:bg-gray-900"
          >
            Focus
          </a>
        <?php else: ?>
          <!-- Sign In / Sign Up Buttons -->
          <a href="<?= $baseUrl ?>/auth/login" class="hover:underline font-medium">Sign In</a>
          <a
            href="<?= $baseUrl ?>/auth/register"
            class="bg-black text-white px-4 py-2 rounded hover:bg-gray-900"
          >
            Sign Up
          </a>
        <?php endif; ?>
      </div>

      <!-- Mobile Menu Button -->
      <button
        id="mobile-menu-button"
        class="md:hidden ml-2 p-2 rounded hover:bg-gray-200"
      >
        <i class="fa fa-bars text-[var(--anthropic-text)]"></i>
      </button>
    </div>

    <!-- Mobile Nav (hidden by default) -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200">
      <div class="px-4 py-3 space-y-2 font-medium">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
          <a href="<?= $baseUrl ?>/dashboard" class="block hover:underline">Dashboard</a>
          <a href="<?= $baseUrl ?>/creatures" class="block hover:underline">Creatures</a>
          <a href="<?= $baseUrl ?>/habitats" class="block hover:underline">Habitats</a>
          <a href="<?= $baseUrl ?>/shop" class="block hover:underline">Marketplace</a>
          <a href="<?= $baseUrl ?>/conservation" class="block hover:underline">Conservation</a>
          <a href="<?= $baseUrl ?>/community" class="block hover:underline">Community</a>
          <hr class="border-gray-200" />
          <a href="<?= $baseUrl ?>/dashboard/profile" class="block hover:underline">Profile</a>
          <a href="<?= $baseUrl ?>/dashboard/settings" class="block hover:underline">Settings</a>
          <a href="<?= $baseUrl ?>/auth/logout" class="block hover:underline">Sign out</a>
        <?php else: ?>
          <a href="<?= $baseUrl ?>/auth/login" class="block hover:underline">Sign In</a>
          <a href="<?= $baseUrl ?>/auth/register" class="block hover:underline">Sign Up</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-grow">
