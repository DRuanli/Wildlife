<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; 
include('public/loading-component.php');?>


<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <nav class="text-sm breadcrumbs mb-6">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="<?= $baseUrl ?>/dashboard" class="text-gray-500 hover:text-gray-700">Dashboard</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="<?= $baseUrl ?>/creatures" class="text-gray-500 hover:text-gray-700">Creatures</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <span class="text-gray-700"><?= htmlspecialchars($creature['name'] ?? 'Creature') ?></span>
            </li>
        </ol>
    </nav>

    <!-- Flash Message -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="bg-<?= $_SESSION['flash_type'] ?? 'blue' ?>-100 border-l-4 border-<?= $_SESSION['flash_type'] ?? 'blue' ?>-500 text-<?= $_SESSION['flash_type'] ?? 'blue' ?>-700 p-4 mb-6" role="alert">
            <p><?= $_SESSION['flash_message']; ?></p>
        </div>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    <?php endif; ?>
    
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Creature Header -->
        <div class="bg-<?= $creature['habitat_type'] ?? 'green' ?>-600 text-white p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="w-16 h-16 bg-<?= $creature['habitat_type'] ?? 'green' ?>-100 rounded-full flex items-center justify-center mr-4">
                        <?php if ($creature['stage'] === 'egg'): ?>
                            <i class="fas fa-egg text-<?= $creature['habitat_type'] ?? 'green' ?>-500 text-3xl"></i>
                        <?php else: ?>
                            <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-12 w-12">
                        <?php endif; ?>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold"><?= htmlspecialchars($creature['name'] ?? 'Mystery Creature') ?></h1>
                        <p class="opacity-90"><?= ucfirst($creature['stage']) ?> <?= $creature['species_name'] ?></p>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-2">
                    <?php if ($creature['stage'] === 'egg' && $creature['growth_progress'] >= 100): ?>
                        <a href="<?= $baseUrl ?>/creatures/hatch/<?= $creature['id'] ?>" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                            <i class="fas fa-egg-crack mr-2"></i> Hatch Now
                        </a>
                    <?php elseif ($creature['stage'] !== 'egg' && $creature['stage'] !== 'mythical' && $creature['growth_progress'] >= 200): ?>
                        <button id="evolve-btn" class="inline-flex items-center px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600">
                            <i class="fas fa-level-up-alt mr-2"></i> Evolve
                        </button>
                    <?php endif; ?>
                    
                    <?php if ($creature['stage'] !== 'egg'): ?>
                        <button id="feed-btn" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                            <i class="fas fa-cookie mr-2"></i> Feed
                        </button>
                        <button id="play-btn" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            <i class="fas fa-gamepad mr-2"></i> Play
                        </button>
                    <?php endif; ?>
                    
                    <button id="rename-btn" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        <i class="fas fa-pencil-alt mr-2"></i> Rename
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Creature Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Creature Image -->
                <div class="md:col-span-1">
                    <div class="bg-<?= $creature['habitat_type'] ?? 'green' ?>-50 p-6 rounded-lg flex items-center justify-center h-64">
                        <?php if ($creature['stage'] === 'egg'): ?>
                            <!-- Egg Animation -->
                            <div class="w-32 h-32 relative animate-pulse-slow">
                                <i class="fas fa-egg text-<?= $creature['habitat_type'] ?? 'green' ?>-500 text-7xl"></i>
                                <?php if ($creature['growth_progress'] >= 50): ?>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="inline-block animate-ping absolute w-12 h-12 rounded-full bg-<?= $creature['habitat_type'] ?? 'green' ?>-400 opacity-40"></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <!-- Creature Animation -->
                            <div class="w-48 h-48 flex items-center justify-center animate-float">
                                <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="max-h-full max-w-full">
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Habitat Info -->
                    <div class="mt-4 bg-white border border-gray-200 rounded-lg p-4">
                        <h3 class="font-medium text-gray-700 mb-2">Current Habitat</h3>
                        <?php if ($currentHabitat): ?>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-<?= $currentHabitat['type'] ?>-100 flex items-center justify-center mr-3">
                                    <?php 
                                        $habitatIcon = 'tree';
                                        switch ($currentHabitat['type']) {
                                            case 'ocean': $habitatIcon = 'water'; break;
                                            case 'mountain': $habitatIcon = 'mountain'; break;
                                            case 'sky': $habitatIcon = 'cloud'; break;
                                            case 'cosmic': $habitatIcon = 'moon'; break;
                                            case 'enchanted': $habitatIcon = 'magic'; break;
                                        }
                                    ?>
                                    <i class="fas fa-<?= $habitatIcon ?> text-<?= $currentHabitat['type'] ?>-500"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 capitalize"><?= $currentHabitat['type'] ?> Habitat</p>
                                    <p class="text-sm text-gray-500">Level <?= $currentHabitat['level'] ?></p>
                                </div>
                            </div>
                            <button id="change-habitat-btn" class="w-full mt-3 py-1 px-3 bg-gray-100 text-gray-700 text-sm rounded hover:bg-gray-200">
                                Change Habitat
                            </button>
                        <?php else: ?>
                            <p class="text-gray-500 text-sm">This creature is not assigned to any habitat.</p>
                            <button id="assign-habitat-btn" class="w-full mt-3 py-1 px-3 bg-<?= $creature['habitat_type'] ?? 'green' ?>-100 text-<?= $creature['habitat_type'] ?? 'green' ?>-700 text-sm rounded hover:bg-<?= $creature['habitat_type'] ?? 'green' ?>-200">
                                <i class="fas fa-home mr-1"></i> Assign to Habitat
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Creature Details -->
                <div class="md:col-span-2">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Stats Panel -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="font-medium text-gray-700 mb-3">Creature Stats</h3>
                            
                            <!-- Health -->
                            <div class="mb-3">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-600">Health</span>
                                    <span class="text-sm font-medium text-gray-700"><?= $creature['health'] ?>/100</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-red-500 h-2 rounded-full" style="width: <?= $creature['health'] ?>%"></div>
                                </div>
                            </div>
                            
                            <!-- Happiness -->
                            <div class="mb-3">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-600">Happiness</span>
                                    <span class="text-sm font-medium text-gray-700"><?= $creature['happiness'] ?>/100</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: <?= $creature['happiness'] ?>%"></div>
                                </div>
                            </div>
                            
                            <!-- Growth Progress -->
                            <div class="mb-3">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-600">Growth Progress</span>
                                    <span class="text-sm font-medium text-gray-700"><?= $growthData['percentage'] ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: <?= $growthData['percentage'] ?>%"></div>
                                </div>
                            </div>
                            
                            <!-- Additional Stats -->
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <div class="text-sm text-gray-500">Age</div>
                                    <div class="font-medium">
                                        <?php
                                            if ($creature['stage'] === 'egg') {
                                                echo 'Unhatched';
                                            } else {
                                                $created = new DateTime($creature['created_at']);
                                                $now = new DateTime();
                                                $diff = $created->diff($now);
                                                echo $diff->days . ' days';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <div class="text-sm text-gray-500">Rarity</div>
                                    <div class="font-medium capitalize"><?= $creature['rarity'] ?? 'Common' ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Species Info Panel -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="font-medium text-gray-700 mb-3">Species Information</h3>
                            <p class="text-gray-600 mb-4"><?= $creature['species_description'] ?? 'A mysterious creature with unknown origins.' ?></p>
                            
                            <?php if ($creature['real_world_inspiration']): ?>
                                <div class="mb-3">
                                    <h4 class="text-sm font-medium text-gray-700">Real World Inspiration</h4>
                                    <p class="text-sm text-gray-600"><?= $creature['real_world_inspiration'] ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($creature['conservation_fact']): ?>
                                <div class="p-3 bg-blue-50 rounded-lg mt-4">
                                    <h4 class="text-sm font-medium text-blue-700">Conservation Fact</h4>
                                    <p class="text-sm text-blue-600"><?= $creature['conservation_fact'] ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Evolution Path -->
                        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="font-medium text-gray-700 mb-3">Evolution Path</h3>
                            <div class="flex items-center justify-between">
                                <!-- Egg Stage -->
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center <?= $creature['stage'] === 'egg' ? 'ring-2 ring-green-500' : '' ?>">
                                        <i class="fas fa-egg text-gray-400"></i>
                                    </div>
                                    <span class="text-xs mt-1">Egg</span>
                                </div>
                                
                                <!-- Arrow -->
                                <div class="h-0.5 w-6 bg-gray-300"></div>
                                
                                <!-- Baby Stage -->
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center <?= $creature['stage'] === 'baby' ? 'ring-2 ring-green-500' : '' ?> <?= $creature['stage'] === 'egg' ? 'opacity-50' : '' ?>">
                                        <i class="fas fa-baby text-gray-400"></i>
                                    </div>
                                    <span class="text-xs mt-1">Baby</span>
                                </div>
                                
                                <!-- Arrow -->
                                <div class="h-0.5 w-6 bg-gray-300"></div>
                                
                                <!-- Juvenile Stage -->
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center <?= $creature['stage'] === 'juvenile' ? 'ring-2 ring-green-500' : '' ?> <?= in_array($creature['stage'], ['egg', 'baby']) ? 'opacity-50' : '' ?>">
                                        <i class="fas fa-child text-gray-400"></i>
                                    </div>
                                    <span class="text-xs mt-1">Juvenile</span>
                                </div>
                                
                                <!-- Arrow -->
                                <div class="h-0.5 w-6 bg-gray-300"></div>
                                
                                <!-- Adult Stage -->
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center <?= $creature['stage'] === 'adult' ? 'ring-2 ring-green-500' : '' ?> <?= in_array($creature['stage'], ['egg', 'baby', 'juvenile']) ? 'opacity-50' : '' ?>">
                                        <i class="fas fa-dragon text-gray-400"></i>
                                    </div>
                                    <span class="text-xs mt-1">Adult</span>
                                </div>
                                
                                <!-- Arrow -->
                                <div class="h-0.5 w-6 bg-gray-300"></div>
                                
                                <!-- Mythical Stage -->
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center <?= $creature['stage'] === 'mythical' ? 'ring-2 ring-green-500' : '' ?> <?= $creature['stage'] !== 'mythical' ? 'opacity-50' : '' ?>">
                                        <i class="fas fa-crown text-gray-400"></i>
                                    </div>
                                    <span class="text-xs mt-1">Mythical</span>
                                </div>
                            </div>
                            
                            <?php if ($growthData['next_stage']): ?>
                                <div class="mt-4 text-center text-sm">
                                    <p class="text-gray-600">
                                        <?php if ($creature['stage'] === 'egg'): ?>
                                            Focus to warm your egg until it's ready to hatch.
                                        <?php else: ?>
                                            Continue focusing to help your creature evolve into a <?= $growthData['next_stage'] ?>.
                                        <?php endif; ?>
                                    </p>
                                </div>
                            <?php else: ?>
                                <div class="mt-4 text-center text-sm">
                                    <p class="text-green-600 font-medium">
                                        <i class="fas fa-star mr-1"></i>
                                        Your creature has reached its final evolution stage!
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rename Modal -->
<div id="rename-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Rename Your Creature</h3>
        <form id="rename-form">
            <input type="hidden" id="creature-id" value="<?= $creature['id'] ?>">
            <div class="mb-4">
                <label for="creature-name" class="block text-sm font-medium text-gray-700 mb-1">New Name</label>
                <input type="text" id="creature-name" name="name" value="<?= htmlspecialchars($creature['name'] ?? '') ?>" class="w-full rounded-md border-gray-300 shadow-sm focus:border-<?= $creature['habitat_type'] ?? 'green' ?>-500 focus:ring-<?= $creature['habitat_type'] ?? 'green' ?>-500" maxlength="50" required>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" id="rename-cancel" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-<?= $creature['habitat_type'] ?? 'green' ?>-600 text-white rounded-md hover:bg-<?= $creature['habitat_type'] ?? 'green' ?>-700">
                    Save Name
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Change Habitat Modal -->
<div id="habitat-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg max-w-lg w-full p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Change Habitat</h3>
        <p class="text-gray-600 mb-4">Select a habitat for your creature to live in:</p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4 max-h-64 overflow-y-auto">
            <?php foreach ($habitats as $habitat): ?>
                <div class="relative">
                    <input type="radio" id="habitat-<?= $habitat['id'] ?>" name="habitat_id" value="<?= $habitat['id'] ?>" class="absolute opacity-0 w-full h-full cursor-pointer z-10 peer" <?= ($creature['habitat_id'] == $habitat['id']) ? 'checked' : '' ?>>
                    <label for="habitat-<?= $habitat['id'] ?>" class="block p-3 border border-gray-200 rounded-lg bg-white peer-checked:border-<?= $habitat['type'] ?>-500 peer-checked:ring-2 peer-checked:ring-<?= $habitat['type'] ?>-500 transition-all cursor-pointer">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-<?= $habitat['type'] ?>-100 rounded-full flex items-center justify-center mr-3">
                                <?php 
                                    $habitatIcon = 'tree';
                                    switch ($habitat['type']) {
                                        case 'ocean': $habitatIcon = 'water'; break;
                                        case 'mountain': $habitatIcon = 'mountain'; break;
                                        case 'sky': $habitatIcon = 'cloud'; break;
                                        case 'cosmic': $habitatIcon = 'moon'; break;
                                        case 'enchanted': $habitatIcon = 'magic'; break;
                                    }
                                ?>
                                <i class="fas fa-<?= $habitatIcon ?> text-<?= $habitat['type'] ?>-500"></i>
                            </div>
                            <div>
                                <h4 class="font-medium capitalize"><?= $habitat['type'] ?> Habitat</h4>
                                <p class="text-xs text-gray-500">Level <?= $habitat['level'] ?></p>
                            </div>
                        </div>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="flex justify-end space-x-3">
            <button type="button" id="habitat-cancel" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                Cancel
            </button>
            <button type="button" id="habitat-submit" class="px-4 py-2 bg-<?= $creature['habitat_type'] ?? 'green' ?>-600 text-white rounded-md hover:bg-<?= $creature['habitat_type'] ?? 'green' ?>-700">
                Set Habitat
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rename functionality
    const renameBtn = document.getElementById('rename-btn');
    const renameModal = document.getElementById('rename-modal');
    const renameForm = document.getElementById('rename-form');
    const renameCancel = document.getElementById('rename-cancel');
    
    if (renameBtn && renameModal && renameForm && renameCancel) {
        renameBtn.addEventListener('click', function() {
            renameModal.classList.remove('hidden');
        });
        
        renameCancel.addEventListener('click', function() {
            renameModal.classList.add('hidden');
        });
        
        renameForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const creatureId = document.getElementById('creature-id').value;
            const newName = document.getElementById('creature-name').value;
            
            // Send AJAX request to rename
            fetch('<?= $baseUrl ?>/creatures/rename', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    creature_id: creatureId,
                    name: newName
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to show new name
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Could not rename creature'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    }
    
    // Habitat change functionality
    const changeHabitatBtn = document.getElementById('change-habitat-btn');
    const assignHabitatBtn = document.getElementById('assign-habitat-btn');
    const habitatModal = document.getElementById('habitat-modal');
    const habitatCancel = document.getElementById('habitat-cancel');
    const habitatSubmit = document.getElementById('habitat-submit');
    
    if (habitatModal && habitatCancel && habitatSubmit) {
        // Open modal
        if (changeHabitatBtn) {
            changeHabitatBtn.addEventListener('click', function() {
                habitatModal.classList.remove('hidden');
            });
        }
        
        if (assignHabitatBtn) {
            assignHabitatBtn.addEventListener('click', function() {
                habitatModal.classList.remove('hidden');
            });
        }
        
        // Close modal
        habitatCancel.addEventListener('click', function() {
            habitatModal.classList.add('hidden');
        });
        
        // Submit habitat change
        habitatSubmit.addEventListener('click', function() {
            const selectedHabitat = document.querySelector('input[name="habitat_id"]:checked');
            
            if (!selectedHabitat) {
                alert('Please select a habitat');
                return;
            }
            
            const habitatId = selectedHabitat.value;
            const creatureId = <?= $creature['id'] ?>;
            
            // Send AJAX request
            fetch('<?= $baseUrl ?>/creatures/habitat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    creature_id: creatureId,
                    habitat_id: habitatId
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to show new habitat
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Could not change habitat'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    }
    
    // Feed functionality
    const feedBtn = document.getElementById('feed-btn');
    if (feedBtn) {
        feedBtn.addEventListener('click', function() {
            const creatureId = <?= $creature['id'] ?>;
            
            // Send AJAX request
            fetch('<?= $baseUrl ?>/creatures/feed', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    creature_id: creatureId
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to show updated stats
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Could not feed creature'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    }
    
    // Play functionality
    const playBtn = document.getElementById('play-btn');
    if (playBtn) {
        playBtn.addEventListener('click', function() {
            const creatureId = <?= $creature['id'] ?>;
            
            // Send AJAX request
            fetch('<?= $baseUrl ?>/creatures/play', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    creature_id: creatureId
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to show updated stats
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Could not play with creature'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    }
    
    // Evolve functionality
    const evolveBtn = document.getElementById('evolve-btn');
    if (evolveBtn) {
        evolveBtn.addEventListener('click', function() {
            if (confirm('Are you ready to evolve your creature to the next stage?')) {
                const creatureId = <?= $creature['id'] ?>;
                
                // Send AJAX request
                fetch('<?= $baseUrl ?>/creatures/evolve', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        creature_id: creatureId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to show evolved creature
                        window.location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Could not evolve creature'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }
        });
    }
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>