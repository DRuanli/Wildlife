<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gray-50">
    <!-- Shop Header -->
    <div class="bg-white shadow-sm mb-6">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold text-gray-800">Wildlife Haven Shop</h1>
                    <p class="text-gray-600">Enhance your sanctuary and support conservation</p>
                </div>
                <div class="flex items-center bg-gray-100 rounded-lg px-4 py-3">
                    <i class="fas fa-coins text-yellow-500 mr-2"></i>
                    <div>
                        <span class="font-bold"><?= number_format($userCoins ?? 0) ?></span>
                        <span class="text-gray-600 ml-1">WildCoins</span>
                    </div>
                    <a href="<?= $baseUrl ?>/shop/get-currency" class="ml-4 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-3 py-1.5 rounded-md transition-colors">
                        Get More
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 pb-12">
        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="relative flex-grow max-w-md">
                    <input 
                        type="text" 
                        placeholder="Search items..." 
                        class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <div class="relative">
                        <select class="appearance-none bg-gray-50 border border-gray-200 rounded-lg py-2 pl-4 pr-10 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            <option value="">Sort by: Newest</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="popularity">Most Popular</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <select class="appearance-none bg-gray-50 border border-gray-200 rounded-lg py-2 pl-4 pr-10 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            <option value="">All Categories</option>
                            <option value="creature_accessory">Creature Accessories</option>
                            <option value="habitat_decoration">Habitat Decorations</option>
                            <option value="egg">Special Eggs</option>
                            <option value="conservation_package">Conservation</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shop Items Grid -->
        <div class="mb-8">
            <?php if (empty($items)): ?>
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                        <i class="fas fa-store text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-700 mb-2">No items available</h3>
                    <p class="text-gray-500 mb-4">Check back soon for new additions to our shop!</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <?php foreach ($items as $item): ?>
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden group hover:shadow-md transition-all duration-300 shop-item" data-item-id="<?= $item['id'] ?>">
                            <div class="relative">
                                <div class="bg-gray-50 h-40 flex items-center justify-center p-4 transition-all duration-300 group-hover:bg-gray-100">
                                    <img src="<?= $baseUrl ?>/images/shop/<?= $item['id'] ?>.png" alt="<?= htmlspecialchars($item['name']) ?>" class="h-28 w-auto object-contain transform transition-transform duration-300 group-hover:scale-105">
                                    
                                    <!-- Model viewer container (hidden by default) -->
                                    <div id="model-container-<?= $item['id'] ?>" class="model-viewer-container hidden w-full h-full absolute inset-0">
                                        <!-- 3D model will be loaded here in the future -->
                                    </div>
                                </div>
                                
                                <?php if (isset($item['rarity'])): ?>
                                    <div class="absolute top-2 right-2 text-xs font-medium px-2 py-0.5 rounded-full 
                                        <?php switch(strtolower($item['rarity'])) {
                                            case 'common': echo 'bg-gray-100 text-gray-800'; break;
                                            case 'uncommon': echo 'bg-green-100 text-green-800'; break;
                                            case 'rare': echo 'bg-blue-100 text-blue-800'; break;
                                            case 'legendary': echo 'bg-purple-100 text-purple-800'; break;
                                            case 'mythical': echo 'bg-yellow-100 text-yellow-800'; break;
                                            default: echo 'bg-gray-100 text-gray-800';
                                        } ?>">
                                        <?= htmlspecialchars($item['rarity']) ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (isset($item['type'])): ?>
                                    <div class="absolute bottom-2 left-2 bg-white bg-opacity-90 text-xs px-2 py-0.5 rounded">
                                        <?= htmlspecialchars(str_replace('_', ' ', $item['type'])) ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (isset($item['is_model_available']) && $item['is_model_available']): ?>
                                    <button class="absolute bottom-2 right-2 bg-blue-500 text-white text-xs px-2 py-0.5 rounded view-3d-btn" data-item-id="<?= $item['id'] ?>">
                                        <i class="fas fa-cube mr-1"></i> 3D
                                    </button>
                                <?php endif; ?>
                            </div>
                            
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800 text-sm mb-1"><?= htmlspecialchars($item['name']) ?></h3>
                                
                                <div class="flex justify-between items-center mt-2">
                                    <div class="flex items-center">
                                        <span class="font-bold text-gray-800 mr-1"><?= number_format($item['price']) ?></span>
                                        <i class="fas fa-coins text-yellow-500 text-xs"></i>
                                    </div>
                                    
                                    <button class="text-xs bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded transition-colors">
                                        <i class="fas fa-plus mr-1"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Recently Viewed Section -->
        <?php if (!empty($recentlyViewed)): ?>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                    <h2 class="font-medium text-gray-800">Recently Viewed</h2>
                </div>
                <div class="p-4">
                    <div class="flex overflow-x-auto space-x-4 pb-2">
                        <?php foreach ($recentlyViewed as $item): ?>
                            <div class="flex-shrink-0 w-36 bg-white rounded-lg border border-gray-100 overflow-hidden hover:shadow-sm transition-all duration-300">
                                <div class="bg-gray-50 p-3 flex items-center justify-center h-28">
                                    <img src="<?= $baseUrl ?>/images/shop/<?= $item['id'] ?>.png" alt="<?= htmlspecialchars($item['name']) ?>" class="max-h-20 max-w-full object-contain">
                                </div>
                                <div class="p-2">
                                    <h3 class="font-medium text-xs text-gray-800 mb-1 truncate"><?= htmlspecialchars($item['name']) ?></h3>
                                    <div class="flex items-center">
                                        <span class="font-bold text-xs text-gray-800 mr-1"><?= number_format($item['price']) ?></span>
                                        <i class="fas fa-coins text-yellow-500 text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Conservation Impact Section -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-4 py-3 bg-green-600 text-white">
                <h2 class="font-medium">Conservation Impact</h2>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mb-2">
                            <i class="fas fa-tree text-green-600"></i>
                        </div>
                        <span class="text-2xl font-bold text-gray-800"><?= number_format($globalStats['trees_planted'] ?? 0) ?></span>
                        <span class="text-gray-600 text-sm">Trees Planted</span>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mb-2">
                            <i class="fas fa-mountain text-blue-600"></i>
                        </div>
                        <span class="text-2xl font-bold text-gray-800"><?= number_format($globalStats['habitat_protected'] ?? 0) ?></span>
                        <span class="text-gray-600 text-sm">Acres Protected</span>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center mb-2">
                            <i class="fas fa-paw text-amber-600"></i>
                        </div>
                        <span class="text-2xl font-bold text-gray-800"><?= number_format($globalStats['animals_supported'] ?? 0) ?></span>
                        <span class="text-gray-600 text-sm">Animals Supported</span>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="<?= $baseUrl ?>/shop/conservation" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fas fa-leaf mr-2"></i> View Conservation Packages
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Item Detail Modal -->
<div id="item-detail-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Item Image and Model Viewer Container -->
            <div class="w-full md:w-1/2 bg-gray-50 p-4 flex items-center justify-center">
                <div id="modal-item-display" class="relative w-full h-64">
                    <!-- Item image will be displayed here -->
                    <img id="modal-item-image" src="" alt="" class="max-h-full max-w-full object-contain mx-auto">
                    
                    <!-- 3D model container (hidden by default) -->
                    <div id="modal-model-container" class="absolute inset-0 hidden">
                        <!-- 3D model will be rendered here -->
                    </div>
                    
                    <!-- 3D view toggle (only shown when model is available) -->
                    <button id="toggle-view-btn" class="absolute bottom-2 right-2 bg-blue-600 text-white text-xs px-2 py-1 rounded hidden">
                        <i class="fas fa-cube mr-1"></i> Toggle 3D View
                    </button>
                </div>
            </div>
            
            <!-- Item Details -->
            <div class="w-full md:w-1/2 p-4 overflow-y-auto max-h-[600px]">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 id="modal-item-name" class="text-xl font-bold text-gray-800"></h2>
                        <div class="flex items-center mt-1">
                            <div id="modal-item-rarity" class="px-2 py-0.5 text-xs font-medium rounded-full"></div>
                            <span class="mx-2 text-gray-400">•</span>
                            <div id="modal-item-type" class="text-gray-600 text-sm"></div>
                        </div>
                    </div>
                    <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <p id="modal-item-description" class="text-gray-600 text-sm mb-4"></p>
                
                <!-- Conservation Info (only shown for conservation items) -->
                <div id="conservation-info" class="bg-green-50 p-3 rounded-lg mb-4 hidden">
                    <h3 class="font-medium text-green-800 text-sm mb-1">Conservation Impact</h3>
                    <p id="conservation-impact-text" class="text-green-700 text-xs"></p>
                </div>
                
                <!-- Item Effects -->
                <div id="item-effects-container" class="mb-4">
                    <h3 class="font-medium text-gray-800 text-sm mb-1">Effects</h3>
                    <ul id="modal-item-effects" class="text-sm text-gray-600 space-y-1"></ul>
                </div>
                
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <span id="modal-item-price" class="text-xl font-bold text-gray-800 mr-1"></span>
                            <i class="fas fa-coins text-yellow-500"></i>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button id="add-to-wishlist-btn" class="px-3 py-1.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                                <i class="far fa-heart mr-1"></i> Wishlist
                            </button>
                            
                            <button id="purchase-btn" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center">
                                <i class="fas fa-shopping-cart mr-1"></i> Purchase
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shop item click handler
    const shopItems = document.querySelectorAll('.shop-item');
    shopItems.forEach(item => {
        item.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            openItemDetails(itemId);
        });
    });
    
    // View 3D button click handler
    const view3dButtons = document.querySelectorAll('.view-3d-btn');
    view3dButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent triggering parent click
            const itemId = this.getAttribute('data-item-id');
            openItemDetails(itemId, true);
        });
    });
    
    // Close modal button handler
    const closeModalBtn = document.getElementById('close-modal-btn');
    closeModalBtn.addEventListener('click', closeItemModal);
    
    // Toggle view button handler
    const toggleViewBtn = document.getElementById('toggle-view-btn');
    toggleViewBtn.addEventListener('click', function() {
        const imageElem = document.getElementById('modal-item-image');
        const modelContainer = document.getElementById('modal-model-container');
        
        if (imageElem.classList.contains('hidden')) {
            // Switch to image view
            modelContainer.classList.add('hidden');
            imageElem.classList.remove('hidden');
            this.innerHTML = '<i class="fas fa-cube mr-1"></i> View 3D';
        } else {
            // Switch to 3D view
            imageElem.classList.add('hidden');
            modelContainer.classList.remove('hidden');
            this.innerHTML = '<i class="fas fa-image mr-1"></i> View Image';
            
            // Initialize 3D model if not already done
            const itemId = this.getAttribute('data-item-id');
            initializeModelViewer(itemId);
        }
    });
    
    // Close modal when clicking outside
    const modal = document.getElementById('item-detail-modal');
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeItemModal();
        }
    });
    
    // Add to wishlist button handler
    const wishlistBtn = document.getElementById('add-to-wishlist-btn');
    wishlistBtn.addEventListener('click', function() {
        const itemId = this.getAttribute('data-item-id');
        
        // Toggle wishlist icon
        const heartIcon = this.querySelector('i');
        if (heartIcon.classList.contains('far')) {
            heartIcon.classList.remove('far');
            heartIcon.classList.add('fas');
            alert('Item added to wishlist');
        } else {
            heartIcon.classList.remove('fas');
            heartIcon.classList.add('far');
            alert('Item removed from wishlist');
        }
    });
    
    // Purchase button handler
    const purchaseBtn = document.getElementById('purchase-btn');
    purchaseBtn.addEventListener('click', function() {
        const itemId = this.getAttribute('data-item-id');
        alert('Purchase functionality will be implemented here');
        closeItemModal();
    });
    
    // Function to open item details modal
    function openItemDetails(itemId, showModel = false) {
        // Fetch item details from the server
        // This is a placeholder - in a real implementation, you would make an AJAX request
        
        // For the demo, we'll extract data from the clicked item
        const item = document.querySelector(`.shop-item[data-item-id="${itemId}"]`);
        if (!item) return;
        
        const name = item.querySelector('h3').textContent;
        const price = item.querySelector('.font-bold').textContent;
        const image = item.querySelector('img').src;
        const rarityElem = item.querySelector('[class*="bg-"][class*="text-"]');
        const typeElem = item.querySelector('.absolute.bottom-2.left-2');
        
        // Update modal content
        document.getElementById('modal-item-name').textContent = name;
        document.getElementById('modal-item-price').textContent = price;
        document.getElementById('modal-item-image').src = image;
        document.getElementById('modal-item-image').alt = name;
        
        // Set rarity
        const modalRarity = document.getElementById('modal-item-rarity');
        if (rarityElem) {
            modalRarity.textContent = rarityElem.textContent.trim();
            modalRarity.className = rarityElem.className;
        } else {
            modalRarity.textContent = 'Common';
            modalRarity.className = 'px-2 py-0.5 bg-gray-100 text-gray-800 text-xs font-medium rounded-full';
        }
        
        // Set item type
        const modalType = document.getElementById('modal-item-type');
        if (typeElem) {
            modalType.textContent = typeElem.textContent.trim();
        } else {
            modalType.textContent = 'Item';
        }
        
        // Set description (would be fetched from server in real implementation)
        document.getElementById('modal-item-description').textContent = 
            'This is a placeholder description for ' + name + '. In a real implementation, this would be fetched from the database.';
        
        // Set item effects (would be fetched from server in real implementation)
        const effectsList = document.getElementById('modal-item-effects');
        effectsList.innerHTML = '';
        
        // Add some placeholder effects
        const effects = [
            'Increases creature happiness by 10%',
            'Adds visual enhancement to your habitat',
            'Provides bonus coins when used during focus sessions'
        ];
        
        effects.forEach(effect => {
            const li = document.createElement('li');
            li.className = 'flex items-start';
            li.innerHTML = `
                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-1.5"></i>
                <span>${effect}</span>
            `;
            effectsList.appendChild(li);
        });
        
        // Check if item has 3D model available
        const hasModel = item.querySelector('.view-3d-btn') !== null;
        const toggleBtn = document.getElementById('toggle-view-btn');
        
        if (hasModel) {
            toggleBtn.classList.remove('hidden');
            toggleBtn.setAttribute('data-item-id', itemId);
            
            if (showModel) {
                // Show model view immediately
                document.getElementById('modal-item-image').classList.add('hidden');
                document.getElementById('modal-model-container').classList.remove('hidden');
                toggleBtn.innerHTML = '<i class="fas fa-image mr-1"></i> View Image';
                
                // Initialize 3D model
                initializeModelViewer(itemId);
            } else {
                // Show image view by default
                document.getElementById('modal-item-image').classList.remove('hidden');
                document.getElementById('modal-model-container').classList.add('hidden');
                toggleBtn.innerHTML = '<i class="fas fa-cube mr-1"></i> View 3D';
            }
        } else {
            // No model available
            toggleBtn.classList.add('hidden');
            document.getElementById('modal-item-image').classList.remove('hidden');
            document.getElementById('modal-model-container').classList.add('hidden');
        }
        
        // Set item IDs for action buttons
        document.getElementById('add-to-wishlist-btn').setAttribute('data-item-id', itemId);
        document.getElementById('purchase-btn').setAttribute('data-item-id', itemId);
        
        // Show the modal
        document.getElementById('item-detail-modal').classList.remove('hidden');
    }
    
    // Function to close item modal
    function closeItemModal() {
        document.getElementById('item-detail-modal').classList.add('hidden');
    }
    
    // Function to initialize 3D model viewer
    function initializeModelViewer(itemId) {
        const container = document.getElementById('modal-model-container');
        
        // Check if viewer is already initialized
        if (container.getAttribute('data-initialized') === 'true') {
            return;
        }
        
        // Set placeholder loading state
        container.innerHTML = '<div class="flex items-center justify-center h-full"><i class="fas fa-spinner fa-spin text-gray-400 text-2xl"></i></div>';
        
        // This is where you would initialize the Three.js model viewer in the future
        // For now, we'll just add a placeholder message after a brief delay
        
        setTimeout(() => {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <i class="fas fa-cube text-gray-400 text-3xl mb-2"></i>
                    <p class="text-sm text-gray-500">3D model viewer will be integrated here</p>
                    <p class="text-xs text-gray-400 mt-1">Support for Blender models coming soon</p>
                </div>
            `;
            container.setAttribute('data-initialized', 'true');
        }, 1000);
    }
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>