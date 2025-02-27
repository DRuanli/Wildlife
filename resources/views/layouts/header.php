<?php
// Base URL is now available as a constant
$baseUrl = BASE_URL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wildlife Haven - Focus and Conservation</title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= asset('images/favicon.ico') ?>" type="image/x-icon">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= asset('css/styles.css') ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="bg-green-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="<?= url('/') ?>" class="flex items-center">
                        <img src="<?= asset('images/logo.png') ?>" alt="Wildlife Haven Logo" class="h-10 w-auto mr-2">
                        <span class="text-xl font-bold">Wildlife Haven</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-4">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                        <a href="<?= url('dashboard') ?>" class="px-3 py-2 rounded hover:bg-green-700">Dashboard</a>
                        <a href="<?= url('focus') ?>" class="px-3 py-2 rounded hover:bg-green-700">Focus</a>
                        <a href="<?= url('creatures') ?>" class="px-3 py-2 rounded hover:bg-green-700">Creatures</a>
                        <a href="<?= url('habitats') ?>" class="px-3 py-2 rounded hover:bg-green-700">Habitats</a>
                        <a href="<?= url('marketplace') ?>" class="px-3 py-2 rounded hover:bg-green-700">Marketplace</a>
                        <a href="<?= url('conservation') ?>" class="px-3 py-2 rounded hover:bg-green-700">Conservation</a>
                        <a href="<?= url('community') ?>" class="px-3 py-2 rounded hover:bg-green-700">Community</a>
                        
                        <div class="relative ml-3">
                            <button id="user-menu-button" class="flex items-center">
                                <?php if (!empty($_SESSION['avatar_url'])): ?>
                                    <img src="<?= htmlspecialchars($_SESSION['avatar_url']) ?>" alt="User Avatar" class="h-8 w-8 rounded-full">
                                <?php else: ?>
                                    <div class="h-8 w-8 rounded-full bg-green-800 flex items-center justify-center">
                                        <span class="text-sm font-medium"><?= substr($_SESSION['username'] ?? 'U', 0, 1) ?></span>
                                    </div>
                                <?php endif; ?>
                                <span class="ml-2"><?= htmlspecialchars($_SESSION['username'] ?? '') ?></span>
                                <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-gray-700">
                                <a href="/dashboard/profile" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                                <a href="/dashboard/settings" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                                <div class="border-t border-gray-200"></div>
                                <a href="/auth/logout" class="block px-4 py-2 hover:bg-gray-100">Sign out</a>
                            </div>
                        </div>
                     <?php else: ?>
                        <a href="<?= url('auth/login') ?>" class="px-3 py-2 rounded hover:bg-green-700">Sign In</a>
                        <a href="<?= url('auth/register') ?>" class="px-3 py-2 bg-white text-green-600 font-medium rounded hover:bg-gray-100">Sign Up</a>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="flex items-center p-2 rounded hover:bg-green-700">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-3 space-y-1 pb-3">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                    <a href="/dashboard" class="block px-3 py-2 rounded hover:bg-green-700">Dashboard</a>
                    <a href="/focus" class="block px-3 py-2 rounded hover:bg-green-700">Focus</a>
                    <a href="/creatures" class="block px-3 py-2 rounded hover:bg-green-700">Creatures</a>
                    <a href="/habitats" class="block px-3 py-2 rounded hover:bg-green-700">Habitats</a>
                    <a href="/marketplace" class="block px-3 py-2 rounded hover:bg-green-700">Marketplace</a>
                    <a href="/conservation" class="block px-3 py-2 rounded hover:bg-green-700">Conservation</a>
                    <a href="/community" class="block px-3 py-2 rounded hover:bg-green-700">Community</a>
                    <div class="border-t border-green-700 my-2"></div>
                    <a href="/dashboard/profile" class="block px-3 py-2 rounded hover:bg-green-700">Profile</a>
                    <a href="/dashboard/settings" class="block px-3 py-2 rounded hover:bg-green-700">Settings</a>
                    <a href="/auth/logout" class="block px-3 py-2 rounded hover:bg-green-700">Sign out</a>
                <?php else: ?>
                    <a href="/auth/login" class="block px-3 py-2 rounded hover:bg-green-700">Sign In</a>
                    <a href="/auth/register" class="block px-3 py-2 rounded hover:bg-green-700">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <main>