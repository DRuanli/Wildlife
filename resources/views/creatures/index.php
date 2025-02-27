<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="min-h-screen bg-[#F9F8F4]">
    <!-- Page Header - Inspired by Anthropic's clean headers -->
    <div class="pt-24 pb-16 px-6 md:px-12 max-w-7xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-display font-medium text-gray-900 mb-4">Your Wildlife Collection</h1>
        <p class="text-xl text-gray-600 max-w-3xl">Nurture and evolve your mythical companions through focused attention.</p>
        
        <div class="flex flex-wrap gap-4 mt-8">
            <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-6 py-3 rounded-full bg-[#4D724D] text-white font-medium hover:bg-[#3D5D3D] transition-colors shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Start Focus Session
            </a>
            <a href="<?= $baseUrl ?>/shop" class="inline-flex items-center px-6 py-3 rounded-full bg-white text-[#4D724D] font-medium hover:bg-gray-50 transition-colors shadow-sm border border-[#4D724D]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Visit Shop
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 md:px-12 pb-24">
        <!-- Collection Overview - Stats Cards -->
        <div class="mb-16">
            <h2 class="text-2xl font-medium text-gray-900 mb-6">Collection Overview</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <!-- Total Collection -->
                <div class="col-span-1 md:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-1">Total Collection</h3>
                            <p class="text-3xl font-semibold"><?= count($creatures) ?> creatures</p>
                            
                            <div class="mt-4 flex space-x-6">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Species Found</p>
                                    <?php
                                    // Calculate unique species count
                                    $uniqueSpecies = [];
                                    foreach ($creatures as $creature) {
                                        $uniqueSpecies[$creature['species_id']] = true;
                                    }
                                    $speciesCount = count($uniqueSpecies);
                                    ?>
                                    <p class="text-lg font-medium"><?= $speciesCount ?><span class="text-sm text-gray-400 ml-1">/ 24</span></p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Mythical Stage</p>
                                    <p class="text-lg font-medium"><?= isset($organized['mythicals']) ? count($organized['mythicals']) : 0 ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="h-14 w-14 rounded-full bg-[#F2F5F2] flex items-center justify-center">
                            <svg class="w-7 h-7 text-[#4D724D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mt-6">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Collection Progress</span>
                            <span class="text-[#4D724D]"><?= $speciesCount ?>/24</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#4D724D] rounded-full" style="width: <?= ($speciesCount / 24) * 100 ?>%"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Lifecycle Distribution -->
                <div class="col-span-1 md:col-span-3 bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-lg font-medium text-gray-800">Lifecycle Distribution</h3>
                        
                        <div class="h-10 w-10 rounded-full bg-[#F2F5F2] flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#4D724D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Lifecycle Stage Distribution with subtle, anthropic-inspired styling -->
                    <div class="grid grid-cols-5 gap-2">
                        <!-- Eggs -->
                        <div class="flex flex-col items-center">
                            <div class="w-full aspect-square rounded-xl bg-gray-50 flex flex-col items-center justify-center gap-2 relative overflow-hidden group">
                                <div class="absolute inset-0 bg-yellow-50 transform origin-bottom transition-all duration-300 ease-out" 
                                     style="height: <?= isset($organized['eggs']) ? (count($organized['eggs']) / max(1, count($creatures)) * 100) : 0 ?>%"></div>
                                <svg class="w-7 h-7 text-yellow-500 relative z-10" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 22C8.5 22 5 18.5 5 13.5C5 8.5 8 3 12 3C16 3 19 8.5 19 13.5C19 18.5 15.5 22 12 22Z"></path>
                                </svg>
                                <span class="text-lg font-medium text-gray-800 relative z-10"><?= isset($organized['eggs']) ? count($organized['eggs']) : 0 ?></span>
                            </div>
                            <span class="text-sm text-gray-600 mt-2">Eggs</span>
                        </div>
                        
                        <!-- Babies -->
                        <div class="flex flex-col items-center">
                            <div class="w-full aspect-square rounded-xl bg-gray-50 flex flex-col items-center justify-center gap-2 relative overflow-hidden group">
                                <div class="absolute inset-0 bg-blue-50 transform origin-bottom transition-all duration-300 ease-out" 
                                     style="height: <?= isset($organized['babies']) ? (count($organized['babies']) / max(1, count($creatures)) * 100) : 0 ?>%"></div>
                                <svg class="w-7 h-7 text-blue-500 relative z-10" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 12.5C11.5 12.5 11 12.3 10.6 11.9C10.2 11.5 10 11 10 10.5C10 10 10.2 9.5 10.6 9.1C11 8.7 11.5 8.5 12 8.5C12.5 8.5 13 8.7 13.4 9.1C13.8 9.5 14 10 14 10.5C14 11 13.8 11.5 13.4 11.9C13 12.3 12.5 12.5 12 12.5ZM15 22H9C8.5 22 8 21.8 7.6 21.4C7.2 21 7 20.5 7 20C7 17.9 7.8 16.1 9.3 14.6C10.9 13.1 12.7 12.3 14.8 12.3H15C15.5 12.3 15.9 12.5 16.3 12.9C16.7 13.3 16.9 13.7 16.9 14.2C17 16.3 16.2 18.1 14.7 19.6C13.2 21.2 11.4 22 9.3 22H15Z"></path>
                                </svg>
                                <span class="text-lg font-medium text-gray-800 relative z-10"><?= isset($organized['babies']) ? count($organized['babies']) : 0 ?></span>
                            </div>
                            <span class="text-sm text-gray-600 mt-2">Babies</span>
                        </div>
                        
                        <!-- Juveniles -->
                        <div class="flex flex-col items-center">
                            <div class="w-full aspect-square rounded-xl bg-gray-50 flex flex-col items-center justify-center gap-2 relative overflow-hidden group">
                                <div class="absolute inset-0 bg-green-50 transform origin-bottom transition-all duration-300 ease-out" 
                                     style="height: <?= isset($organized['juveniles']) ? (count($organized['juveniles']) / max(1, count($creatures)) * 100) : 0 ?>%"></div>
                                <svg class="w-7 h-7 text-green-500 relative z-10" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2M15.9 8.1C15.5 7.7 14.8 7 13.5 7H11C8.2 7 6 9.2 6 12C6 14.2 7.5 16.1 9.5 16.8L7 22H9L10.6 18.6L12 22H14L12.5 17.5L14 14.5V22H16V14.5L18 9L15.9 8.1Z"></path>
                                </svg>
                                <span class="text-lg font-medium text-gray-800 relative z-10"><?= isset($organized['juveniles']) ? count($organized['juveniles']) : 0 ?></span>
                            </div>
                            <span class="text-sm text-gray-600 mt-2">Juveniles</span>
                        </div>
                        
                        <!-- Adults -->
                        <div class="flex flex-col items-center">
                            <div class="w-full aspect-square rounded-xl bg-gray-50 flex flex-col items-center justify-center gap-2 relative overflow-hidden group">
                                <div class="absolute inset-0 bg-purple-50 transform origin-bottom transition-all duration-300 ease-out" 
                                     style="height: <?= isset($organized['adults']) ? (count($organized['adults']) / max(1, count($creatures)) * 100) : 0 ?>%"></div>
                                <svg class="w-7 h-7 text-purple-500 relative z-10" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2M20 18C21.1 18 22 17.1 22 16V14.5C22 13.1 21.2 11.9 20 11.3V7.5C20 6.1 19.1 5 18 5H14.8C14.4 4.4 13.8 4 13 4H11C10.2 4 9.6 4.4 9.2 5H6C4.9 5 4 6.1 4 7.5V11.3C2.8 11.9 2 13.1 2 14.5V16C2 17.1 2.9 18 4 18H6.2C6.6 19.8 8.1 21.2 10 21.7V22H14V21.7C15.9 21.2 17.4 19.8 17.8 18H20M7.5 12.5L8 10H8.5L9 12.5H7.5M6 10H7L6 13L5.5 15H4V14.5C4 13.7 4.4 13 5 12.5V10M16.5 15L16 13L15 10H16V12.5C16.6 13 17 13.7 17 14.5V15H16.5M18 10H19V12.5C19.6 13 20 13.7 20 14.5V15H18.5L18 13L17.5 10H18M14.5 10H15.5L16 12.5H15V15H13V12.5L14.5 10M10.5 10H11.5L13 12.5V15H11V12.5H10L10.5 10M8.5 15H9.5V12.5H11V15H9.5V19.2C8.6 18.9 8 18 8 17V15H8.5Z"></path>
                                </svg>
                                <span class="text-lg font-medium text-gray-800 relative z-10"><?= isset($organized['adults']) ? count($organized['adults']) : 0 ?></span>
                            </div>
                            <span class="text-sm text-gray-600 mt-2">Adults</span>
                        </div>
                        
                        <!-- Mythicals -->
                        <div class="flex flex-col items-center">
                            <div class="w-full aspect-square rounded-xl bg-gray-50 flex flex-col items-center justify-center gap-2 relative overflow-hidden group">
                                <div class="absolute inset-0 bg-rose-50 transform origin-bottom transition-all duration-300 ease-out" 
                                     style="height: <?= isset($organized['mythicals']) ? (count($organized['mythicals']) / max(1, count($creatures)) * 100) : 0 ?>%"></div>
                                <svg class="w-7 h-7 text-rose-500 relative z-10" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path>
                                </svg>
                                <span class="text-lg font-medium text-gray-800 relative z-10"><?= isset($organized['mythicals']) ? count($organized['mythicals']) : 0 ?></span>
                            </div>
                            <span class="text-sm text-gray-600 mt-2">Mythicals</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actionable States Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <!-- Ready to Hatch Panel -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800">Ready to Hatch</h3>
                        <p class="text-sm text-gray-500 mt-1">Eggs that are warmed and ready for hatching</p>
                    </div>
                    
                    <div class="h-10 w-10 rounded-full bg-amber-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-500" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C8.5 22 5 18.5 5 13.5C5 8.5 8 3 12 3C16 3 19 8.5 19 13.5C19 18.5 15.5 22 12 22Z"></path>
                        </svg>
                    </div>
                </div>
                
                <?php
                // Get eggs that are ready to hatch (growth progress >= 100)
                $readyToHatchEggs = array_filter($organized['eggs'] ?? [], function($egg) {
                    return $egg['growth_progress'] >= 100;
                });
                ?>
                
                <?php if (empty($readyToHatchEggs)): ?>
                    <div class="bg-gray-50 rounded-xl p-8 text-center">
                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-3">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22C8.5 22 5 18.5 5 13.5C5 8.5 8 3 12 3C16 3 19 8.5 19 13.5C19 18.5 15.5 22 12 22Z"></path>
                            </svg>
                        </div>
                        <h4 class="text-gray-700 font-medium mb-2">No Eggs Ready Yet</h4>
                        <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">Continue focusing to warm your eggs until they're ready to hatch.</p>
                        <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-4 py-2 rounded-full bg-amber-500 text-white font-medium text-sm hover:bg-amber-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Focus to Warm Eggs
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <?php foreach ($readyToHatchEggs as $egg): ?>
                            <a href="<?= $baseUrl ?>/creatures/hatch/<?= $egg['id'] ?>" class="group">
                                <div class="bg-amber-50 rounded-xl p-4 text-center hover:bg-amber-100 transition-colors group">
                                    <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-3 relative">
                                        <svg class="w-8 h-8 text-amber-400" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 22C8.5 22 5 18.5 5 13.5C5 8.5 8 3 12 3C16 3 19 8.5 19 13.5C19 18.5 15.5 22 12 22Z"></path>
                                        </svg>
                                        <!-- Pulsing effect -->
                                        <span class="absolute w-full h-full rounded-full bg-amber-400 opacity-20 animate-ping"></span>
                                    </div>
                                    <h4 class="font-medium text-gray-800 mb-1">Mystery Egg</h4>
                                    <p class="text-xs text-amber-600">Ready to hatch!</p>
                                    
                                    <div class="mt-3 px-3 py-1 bg-amber-500 text-white text-xs font-medium rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                        Hatch Now
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Growing Creatures Panel -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800">Growing Creatures</h3>
                        <p class="text-sm text-gray-500 mt-1">Creatures ready to evolve or nearing evolution</p>
                    </div>
                    
                    <div class="h-10 w-10 rounded-full bg-green-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                
                <?php
                // Get creatures that are currently growing (not eggs and not mythicals)
                $growingCreatures = array_filter($creatures, function($creature) {
                    return $creature['stage'] !== 'egg' && $creature['stage'] !== 'mythical';
                });
                
                // Sort by growth progress
                usort($growingCreatures, function($a, $b) {
                    // Calculate percentage
                    $aPercentage = ($a['growth_progress'] / 200) * 100;
                    $bPercentage = ($b['growth_progress'] / 200) * 100;
                    
                    // Sort by percentage in descending order
                    return $bPercentage <=> $aPercentage;
                });
                
                // Get the top 3 growing
                $topGrowing = array_slice($growingCreatures, 0, 3);
                ?>
                
                <?php if (empty($topGrowing)): ?>
                    <div class="bg-gray-50 rounded-xl p-8 text-center">
                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-gray-700 font-medium mb-2">No Growing Creatures</h4>
                        <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">Hatch an egg to start growing your first creature.</p>
                        <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-4 py-2 rounded-full bg-green-500 text-white font-medium text-sm hover:bg-green-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Start Focus Session
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach ($topGrowing as $creature): ?>
                            <?php 
                                // Calculate growth percentage 
                                $growthPercentage = min(100, ($creature['growth_progress'] / 200) * 100);
                                
                                // Determine habitat color class based on type
                                $habitatColor = 'green';
                                switch ($creature['habitat_type'] ?? '') {
                                    case 'forest': $habitatColor = 'green'; break;
                                    case 'ocean': $habitatColor = 'blue'; break;
                                    case 'mountain': $habitatColor = 'red'; break;
                                    case 'sky': $habitatColor = 'sky'; break;
                                    case 'cosmic': $habitatColor = 'purple'; break;
                                    case 'enchanted': $habitatColor = 'pink'; break;
                                }
                            ?>
                            <a href="<?= $baseUrl ?>/creatures/view/<?= $creature['id'] ?>" class="block group">
                                <div class="bg-white rounded-xl p-4 border border-gray-100 hover:border-<?= $habitatColor ?>-200 hover:bg-<?= $habitatColor ?>-50 transition-colors">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-<?= $habitatColor ?>-100 rounded-lg flex items-center justify-center mr-4 group-hover:scale-105 transition-transform">
                                            <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-8 w-8 object-contain">
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-center">
                                                <h4 class="text-sm font-medium text-gray-800 truncate" title="<?= htmlspecialchars($creature['name'] ?? 'Unnamed') ?>">
                                                    <?= htmlspecialchars($creature['name'] ?? 'Unnamed') ?>
                                                </h4>
                                                <span class="text-xs bg-<?= $habitatColor ?>-100 text-<?= $habitatColor ?>-800 px-2 py-0.5 rounded-full capitalize">
                                                    <?= $creature['stage'] ?>
                                                </span>
                                            </div>
                                            
                                            <!-- Growth Progress -->
                                            <div class="mt-2">
                                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                                    <span><?= $creature['growth_progress'] ?>/200</span>
                                                    <span><?= round($growthPercentage) ?>%</span>
                                                </div>
                                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-<?= $habitatColor ?>-500 rounded-full" style="width: <?= $growthPercentage ?>%"></div>
                                                </div>
                                            </div>
                                            
                                            <?php if ($growthPercentage >= 100): ?>
                                                <div class="mt-1 text-xs text-green-600 flex items-center justify-end">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                                    </svg>
                                                    Ready to evolve
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                        
                        <?php if (count($growingCreatures) > 3): ?>
                            <div class="text-center pt-2">
                                <a href="<?= $baseUrl ?>/creatures?filter=growing" class="text-[#4D724D] hover:text-[#3D5D3D] text-sm font-medium inline-flex items-center">
                                    View <?= count($growingCreatures) - 3 ?> more growing creatures
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- All Creatures Section -->
        <div class="mb-16">
            <div class="flex flex-wrap justify-between items-center mb-6">
                <h2 class="text-2xl font-medium text-gray-900">All Creatures</h2>
                
                <!-- Search and Filter -->
                <div class="flex flex-wrap items-center gap-3 mt-4 sm:mt-0">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" placeholder="Search creatures..." class="pl-10 pr-4 py-2 rounded-full text-sm border-gray-300 focus:ring-[#4D724D] focus:border-[#4D724D]">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Sort Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                            </svg>
                            Sort
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                            <div class="py-1" role="menu" aria-orientation="vertical">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Newest First</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Oldest First</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">By Stage</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">By Growth Progress</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">By Name</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filter Button -->
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Filter
                    </button>
                </div>
            </div>
            
            <?php if (empty($creatures)): ?>
                <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
                    <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-800 mb-2">Your collection is empty</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Complete focus sessions to incubate eggs and build your mythical creature collection.</p>
                    <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-6 py-3 rounded-full bg-[#4D724D] text-white font-medium hover:bg-[#3D5D3D] transition-colors shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Start Focus Session
                    </a>
                </div>
            <?php else: ?>
                <!-- Creatures Grid with Anthropic-inspired styling -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    <?php foreach ($creatures as $creature): ?>
                        <div class="creature-card" 
                             data-stage="<?= $creature['stage'] ?>" 
                             data-habitat="<?= $creature['habitat_type'] ?? 'none' ?>"
                             data-status="<?php 
                                if ($creature['stage'] === 'mythical') {
                                    echo 'maxed';
                                } else if ($creature['stage'] === 'egg' && $creature['growth_progress'] >= 100) {
                                    echo 'ready';
                                } else if ($creature['stage'] !== 'egg' && $creature['growth_progress'] >= 200) {
                                    echo 'ready';
                                } else if ($creature['stage'] !== 'mythical') {
                                    echo 'growing';
                                } else {
                                    echo 'none';
                                }
                             ?>"
                         >
                            <?php 
                                // Determine habitat color class based on type
                                $habitatColor = 'green';
                                switch ($creature['habitat_type'] ?? '') {
                                    case 'forest': $habitatColor = 'green'; break;
                                    case 'ocean': $habitatColor = 'blue'; break;
                                    case 'mountain': $habitatColor = 'red'; break;
                                    case 'sky': $habitatColor = 'sky'; break;
                                    case 'cosmic': $habitatColor = 'purple'; break;
                                    case 'enchanted': $habitatColor = 'pink'; break;
                                }
                            ?>
                            <a href="<?= $baseUrl ?>/creatures/view/<?= $creature['id'] ?>" class="group">
                                <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-md hover:border-<?= $habitatColor ?>-200 transition-all h-full flex flex-col">
                                    <!-- Creature Image -->
                                    <div class="aspect-square p-6 flex items-center justify-center bg-<?= $habitatColor ?>-50 group-hover:bg-<?= $habitatColor ?>-100 transition-colors relative">
                                        <?php if ($creature['stage'] === 'egg'): ?>
                                            <div class="w-24 h-24 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-<?= $habitatColor ?>-400 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 22C8.5 22 5 18.5 5 13.5C5 8.5 8 3 12 3C16 3 19 8.5 19 13.5C19 18.5 15.5 22 12 22Z"></path>
                                                </svg>
                                            </div>
                                            <?php if ($creature['growth_progress'] >= 100): ?>
                                                <div class="absolute bottom-3 right-3 w-6 h-6 bg-amber-500 rounded-full text-white flex items-center justify-center animate-pulse">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-32 w-32 object-contain transform group-hover:scale-110 transition-transform">
                                            <?php if ($creature['stage'] !== 'mythical' && $creature['growth_progress'] >= 200): ?>
                                                <div class="absolute bottom-3 right-3 w-6 h-6 bg-green-500 rounded-full text-white flex items-center justify-center animate-pulse">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Creature Info -->
                                    <div class="p-4 flex-1 flex flex-col">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="font-medium text-gray-800 truncate" title="<?= htmlspecialchars($creature['name'] ?? 'Unnamed') ?>">
                                                <?= htmlspecialchars($creature['name'] ?? 'Unnamed') ?>
                                            </h4>
                                            <span class="text-xs bg-<?= $habitatColor ?>-100 text-<?= $habitatColor ?>-800 px-2 py-0.5 rounded-full capitalize">
                                                <?= $creature['stage'] ?>
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mb-2"><?= $creature['species_name'] ?></p>
                                        
                                        <?php if ($creature['stage'] !== 'mythical'): ?>
                                            <!-- Growth Progress -->
                                            <div class="mt-auto">
                                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                    <?php 
                                                    // Calculate growth percentage
                                                    $growthPercentage = 0;
                                                    if ($creature['stage'] === 'egg') {
                                                        $growthPercentage = min(100, ($creature['growth_progress'] / 100) * 100);
                                                    } else {
                                                        $growthPercentage = min(100, ($creature['growth_progress'] / 200) * 100);
                                                    }
                                                    ?>
                                                    <div class="h-full bg-<?= $habitatColor ?>-500 rounded-full" style="width: <?= $growthPercentage ?>%"></div>
                                                </div>
                                                <div class="flex justify-between mt-1 text-xs text-gray-500">
                                                    <span>Progress: <?= round($growthPercentage) ?>%</span>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <!-- Mythical Badge -->
                                            <div class="flex items-center justify-center space-x-1 mt-auto">
                                                <?php for($i = 0; $i < 5; $i++): ?>
                                                    <svg class="w-3 h-3 text-amber-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path>
                                                    </svg>
                                                <?php endfor; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Habitats Section -->
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-medium text-gray-900">Creature Habitats</h2>
                <a href="<?= $baseUrl ?>/habitats" class="text-[#4D724D] hover:text-[#3D5D3D] text-sm font-medium inline-flex items-center">
                    View All Habitats
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            
            <?php if (empty($habitats)): ?>
                <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
                    <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-800 mb-2">No habitats created yet</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Create your first habitat to provide a home for your creatures.</p>
                    <a href="<?= $baseUrl ?>/habitats/create" class="inline-flex items-center px-6 py-3 rounded-full bg-[#4D724D] text-white font-medium hover:bg-[#3D5D3D] transition-colors shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create First Habitat
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($habitats as $habitat): 
                        // Count creatures in this habitat
                        $habitatCreatures = array_filter($creatures, function($creature) use ($habitat) {
                            return isset($creature['habitat_id']) && $creature['habitat_id'] == $habitat['id'];
                        });
                        $creatureCount = count($habitatCreatures);
                        
                        // Determine habitat color
                        $habitatColor = 'green';
                        switch ($habitat['type']) {
                            case 'forest': $habitatColor = 'green'; break;
                            case 'ocean': $habitatColor = 'blue'; break;
                            case 'mountain': $habitatColor = 'red'; break;
                            case 'sky': $habitatColor = 'sky'; break;
                            case 'cosmic': $habitatColor = 'purple'; break;
                            case 'enchanted': $habitatColor = 'pink'; break;
                        }
                    ?>
                        <div class="group">
                            <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-md hover:border-<?= $habitatColor ?>-200 transition-all h-full">
                                <!-- Habitat Background -->
                                <div class="h-40 bg-gradient-to-br from-<?= $habitatColor ?>-50 to-<?= $habitatColor ?>-100 p-6 relative overflow-hidden">
                                    <!-- Subtle pattern overlay -->
                                    <div class="absolute inset-0 opacity-10">
                                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" class="absolute inset-0">
                                            <defs>
                                                <pattern id="habitat-pattern-<?= $habitat['id'] ?>" width="30" height="30" patternUnits="userSpaceOnUse">
                                                    <?php if ($habitat['type'] === 'forest'): ?>
                                                        <path d="M15,5 Q25,10 15,20 Q5,15 15,5" fill="none" stroke="currentColor" stroke-width="0.8"/>
                                                    <?php elseif ($habitat['type'] === 'ocean'): ?>
                                                        <path d="M0,15 Q7.5,10 15,15 Q22.5,20 30,15" fill="none" stroke="currentColor" stroke-width="0.8"/>
                                                    <?php elseif ($habitat['type'] === 'mountain'): ?>
                                                        <path d="M0,30 L15,5 L30,30" fill="none" stroke="currentColor" stroke-width="0.8"/>
                                                    <?php elseif ($habitat['type'] === 'sky'): ?>
                                                        <circle cx="15" cy="15" r="5" fill="none" stroke="currentColor" stroke-width="0.8"/>
                                                    <?php elseif ($habitat['type'] === 'cosmic'): ?>
                                                        <circle cx="15" cy="15" r="2" fill="currentColor"/>
                                                        <circle cx="5" cy="5" r="1" fill="currentColor"/>
                                                        <circle cx="25" cy="25" r="1" fill="currentColor"/>
                                                    <?php else: ?>
                                                        <path d="M15,0 Q25,15 15,30 Q5,15 15,0" fill="none" stroke="currentColor" stroke-width="0.8"/>
                                                    <?php endif; ?>
                                                </pattern>
                                            </defs>
                                            <rect width="100%" height="100%" fill="url(#habitat-pattern-<?= $habitat['id'] ?>)"/>
                                        </svg>
                                    </div>
                                    
                                    <!-- Habitat Header -->
                                    <div class="flex justify-between relative z-10">
                                        <div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-<?= $habitatColor ?>-800 uppercase">
                                                <?= $habitat['type'] ?>
                                            </span>
                                            <h4 class="text-<?= $habitatColor ?>-800 text-lg font-medium mt-1">
                                                <?= ucfirst($habitat['type']) ?> Haven
                                            </h4>
                                        </div>
                                        <div class="bg-white bg-opacity-70 px-2 py-1 rounded-full flex items-center text-xs font-medium text-<?= $habitatColor ?>-800">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            Level <?= $habitat['level'] ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Habitat Creatures Preview -->
                                    <div class="absolute bottom-4 right-4 flex items-center space-x-1">
                                        <div class="flex -space-x-2">
                                            <?php 
                                            $displayCount = min(3, $creatureCount);
                                            $displayedCreatures = array_slice($habitatCreatures, 0, $displayCount);
                                            foreach ($displayedCreatures as $creature): 
                                            ?>
                                                <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden bg-<?= $habitatColor ?>-100 flex items-center justify-center">
                                                    <?php if ($creature['stage'] === 'egg'): ?>
                                                        <svg class="w-4 h-4 text-<?= $habitatColor ?>-400" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12 22C8.5 22 5 18.5 5 13.5C5 8.5 8 3 12 3C16 3 19 8.5 19 13.5C19 18.5 15.5 22 12 22Z"></path>
                                                        </svg>
                                                    <?php else: ?>
                                                        <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-6 w-6 object-contain">
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                            
                                            <?php if ($creatureCount > $displayCount): ?>
                                                <div class="w-8 h-8 rounded-full border-2 border-white bg-white flex items-center justify-center text-xs font-medium text-gray-600">
                                                    +<?= $creatureCount - $displayCount ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-5">
                                    <!-- Habitat Stats -->
                                    <div class="grid grid-cols-2 gap-3 mb-4">
                                        <div class="bg-gray-50 p-3 rounded-xl">
                                            <p class="text-xs text-gray-500">Creatures</p>
                                            <p class="font-medium"><?= $creatureCount ?></p>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-xl">
                                            <p class="text-xs text-gray-500">Expansion</p>
                                            <p class="font-medium"><?= $habitat['expansion_level'] ?>/5</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex justify-between">
                                        <a href="<?= $baseUrl ?>/habitats/view/<?= $habitat['id'] ?>" class="text-<?= $habitatColor ?>-600 hover:text-<?= $habitatColor ?>-800 text-sm font-medium">
                                            View Habitat
                                        </a>
                                        <a href="<?= $baseUrl ?>/habitats/edit/<?= $habitat['id'] ?>" class="text-<?= $habitatColor ?>-600 hover:text-<?= $habitatColor ?>-800 text-sm font-medium">
                                            Manage
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <!-- Create New Habitat Card -->
                    <div>
                        <div class="relative overflow-hidden rounded-2xl border border-dashed border-gray-300 flex flex-col items-center justify-center p-8 bg-gray-50 text-center hover:bg-gray-100 transition h-full">
                            <div class="w-16 h-16 rounded-full bg-[#E9F0E9] flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-[#4D724D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-800 mb-2">Create Habitat</h4>
                            <p class="text-sm text-gray-500 mb-4">Build a new home for your mythical creatures</p>
                            <a href="<?= $baseUrl ?>/habitats/create" class="px-4 py-2 bg-[#4D724D] text-white rounded-full font-medium text-sm shadow-sm hover:bg-[#3D5D3D] transition-colors">
                                Create Habitat
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtering and sorting functionality can be implemented here
    // This will use the data attributes on the creature cards
    
    // Add smooth scroll behavior
    document.documentElement.style.scrollBehavior = 'smooth';
    
    // Add fade-in animation to sections
    const sections = document.querySelectorAll('.mb-16');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100');
                entry.target.classList.remove('opacity-0', 'translate-y-8');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    sections.forEach((section, index) => {
        section.classList.add('transition-all', 'duration-700', 'opacity-0', 'translate-y-8');
        section.style.transitionDelay = `${index * 100}ms`;
        observer.observe(section);
    });
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>