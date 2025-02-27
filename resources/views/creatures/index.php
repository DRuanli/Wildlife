<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800">My Creatures</h1>
        <?php if (count($creatures) < 5): ?>
        <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition">
            <i class="fas fa-plus mr-2"></i> Get More Creatures
        </a>
        <?php endif; ?>
    </div>
    
    <!-- Flash Message -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="bg-<?= $_SESSION['flash_type'] ?? 'blue' ?>-100 border-l-4 border-<?= $_SESSION['flash_type'] ?? 'blue' ?>-500 text-<?= $_SESSION['flash_type'] ?? 'blue' ?>-700 p-4 mb-6" role="alert">
            <p><?= $_SESSION['flash_message']; ?></p>
        </div>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    <?php endif; ?>
    
    <!-- Creatures Grid -->
    <?php if (empty($creatures)): ?>
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                <i class="fas fa-egg text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No creatures yet!</h3>
            <p class="text-gray-600 mb-6">Complete focus sessions to hatch your first egg and start building your collection.</p>
            <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-play mr-2"></i> Start Focus Session
            </a>
        </div>
    <?php else: ?>
        <!-- Filter Controls -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-wrap items-center">
                <div class="mr-4 mb-2">
                    <label for="stage-filter" class="block text-sm font-medium text-gray-700 mb-1">Stage</label>
                    <select id="stage-filter" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                        <option value="all">All Stages</option>
                        <option value="egg">Eggs</option>
                        <option value="baby">Babies</option>
                        <option value="juvenile">Juveniles</option>
                        <option value="adult">Adults</option>
                        <option value="mythical">Mythicals</option>
                    </select>
                </div>
                <div class="mr-4 mb-2">
                    <label for="habitat-filter" class="block text-sm font-medium text-gray-700 mb-1">Habitat Type</label>
                    <select id="habitat-filter" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                        <option value="all">All Habitats</option>
                        <option value="forest">Forest</option>
                        <option value="ocean">Ocean</option>
                        <option value="mountain">Mountain</option>
                        <option value="sky">Sky</option>
                        <option value="cosmic">Cosmic</option>
                        <option value="enchanted">Enchanted</option>
                    </select>
                </div>
                <div class="mr-4 mb-2">
                    <label for="sort-by" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select id="sort-by" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="stage">Stage</option>
                        <option value="name">Name</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Creatures Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-md p-4 text-center">
                <div class="text-sm text-gray-500 mb-1">Total</div>
                <div class="text-2xl font-bold text-gray-800"><?= $creatureStats['total'] ?></div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 text-center">
                <div class="text-sm text-gray-500 mb-1">Eggs</div>
                <div class="text-2xl font-bold text-indigo-600"><?= $creatureStats['egg'] ?></div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 text-center">
                <div class="text-sm text-gray-500 mb-1">Babies</div>
                <div class="text-2xl font-bold text-green-600"><?= $creatureStats['baby'] ?></div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 text-center">
                <div class="text-sm text-gray-500 mb-1">Adults</div>
                <div class="text-2xl font-bold text-orange-600"><?= $creatureStats['adult'] ?></div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 text-center">
                <div class="text-sm text-gray-500 mb-1">Mythicals</div>
                <div class="text-2xl font-bold text-purple-600"><?= $creatureStats['mythical'] ?></div>
            </div>
        </div>
        
        <!-- Creatures Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mb-8">
            <?php foreach ($creatures as $creature): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden creature-card" 
                     data-stage="<?= $creature['stage'] ?>"
                     data-habitat="<?= $creature['habitat_type'] ?>">
                    <!-- Creature Image -->
                    <div class="h-40 bg-<?= $creature['habitat_type'] ?>-100 flex items-center justify-center relative">
                        <?php if ($creature['stage'] === 'egg'): ?>
                            <i class="fas fa-egg text-<?= $creature['habitat_type'] ?>-500 text-5xl"></i>
                            <?php if ($creature['growth_progress'] >= 100): ?>
                                <div class="absolute top-2 right-2 bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center" title="Ready to hatch!">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <img src="<?= $baseUrl ?>/images/creatures/<?= $creature['species_id'] ?>_<?= $creature['stage'] ?>.png" alt="<?= $creature['name'] ?>" class="h-32 w-32 object-contain">
                            <?php if ($creature['stage'] !== 'mythical' && $creature['growth_progress'] >= 200): ?>
                                <div class="absolute top-2 right-2 bg-yellow-500 text-white rounded-full w-6 h-6 flex items-center justify-center" title="Ready to evolve!">
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Creature Info -->
                    <div class="p-4">
                        <h3 class="font-medium text-lg text-gray-800"><?= htmlspecialchars($creature['name'] ?? 'Mystery Creature') ?></h3>
                        <p class="text-sm text-gray-500"><?= ucfirst($creature['stage']) ?> <?= $creature['species_name'] ?></p>
                        
                        <!-- Progress Bar -->
                        <div class="mt-2">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <?php
                                            $maxProgress = ($creature['stage'] === 'egg') ? 100 : 200;
                                            $progressPercent = min(100, ($creature['growth_progress'] / $maxProgress) * 100);
                                        ?>
                                        <div class="h-full bg-<?= $creature['habitat_type'] ?>-500" style="width: <?= $progressPercent ?>%"></div>
                                    </div>
                                </div>
                                <span class="ml-2 text-xs text-gray-600"><?= round($progressPercent) ?>%</span>
                            </div>
                        </div>
                        
                        <!-- Action Button -->
                        <div class="mt-4 text-center">
                            <a href="<?= $baseUrl ?>/creatures/view/<?= $creature['id'] ?>" class="inline-block w-full py-2 bg-<?= $creature['habitat_type'] ?>-500 text-white text-sm font-medium rounded hover:bg-<?= $creature['habitat_type'] ?>-600 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Simple filtering script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get filter elements
    const stageFilter = document.getElementById('stage-filter');
    const habitatFilter = document.getElementById('habitat-filter');
    const sortBy = document.getElementById('sort-by');
    
    // Add event listeners if filters exist
    if (stageFilter && habitatFilter && sortBy) {
        stageFilter.addEventListener('change', filterCreatures);
        habitatFilter.addEventListener('change', filterCreatures);
        sortBy.addEventListener('change', filterCreatures);
    }
    
    function filterCreatures() {
        const stage = stageFilter.value;
        const habitat = habitatFilter.value;
        const sort = sortBy.value;
        const cards = document.querySelectorAll('.creature-card');
        
        cards.forEach(card => {
            const cardStage = card.dataset.stage;
            const cardHabitat = card.dataset.habitat;
            let showCard = true;
            
            // Filter by stage
            if (stage !== 'all' && cardStage !== stage) {
                showCard = false;
            }
            
            // Filter by habitat
            if (habitat !== 'all' && cardHabitat !== habitat) {
                showCard = false;
            }
            
            // Show/hide card
            card.style.display = showCard ? 'block' : 'none';
        });
        
        // Sort functionality would need more complex implementation
        // This is just a placeholder for demonstration
    }
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>