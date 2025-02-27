<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-purple-50 to-white pb-12">
    <!-- Wishlist Header -->
    <div class="relative overflow-hidden bg-purple-600 text-white">
        <div class="absolute opacity-20 right-0 top-0 w-full h-full">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <defs>
                    <pattern id="pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40L40 0" stroke="currentColor" stroke-width="1" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#pattern)" />
            </svg>
        </div>
        <div class="container mx-auto px-4 py-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Your Wishlist</h1>
                    <p class="text-purple-100 text-lg">Items you're saving for later</p>
                </div>
                <div class="flex items-center bg-white bg-opacity-20 rounded-full px-4 py-2">
                    <i class="fas fa-coins text-yellow-300 mr-2"></i>
                    <span class="font-bold"><?= number_format($userCoins) ?></span>
                    <span class="ml-1">WildCoins</span>
                    <a href="<?= $baseUrl ?>/shop/get-currency" class="ml-3 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-3 py-1 rounded-full transition-colors">
                        <i class="fas fa-plus text-xs mr-1"></i> Get More
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Wishlist Items -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 bg-purple-100 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-purple-800">Saved Items</h2>
                    <span class="text-purple-600 font-medium"><?= count($wishlistItems) ?> items</span>
                </div>
            </div>
            
            <?php if (empty($wishlistItems)): ?>
                <div class="p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                        <i class="far fa-heart text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-700 mb-2">Your wishlist is empty</h3>
                    <p class="text-gray-500 mb-4">Save items you like by clicking the heart icon on product pages.</p>
                    <a href="<?= $baseUrl ?>/shop" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-shopping-basket mr-2"></i> Continue Shopping
                    </a>
                </div>
            <?php else: ?>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <?php foreach ($wishlistItems as $item): ?>
                            <div class="flex flex-col sm:flex-row border border-gray-200 rounded-lg overflow-hidden hover:shadow-sm transition-shadow">
                                <!-- Item Image -->
                                <div class="sm:w-48 h-40 sm:h-auto bg-gray-50 flex items-center justify-center p-4">
                                    <img src="<?= $baseUrl ?>/images/shop/<?= $item['id'] ?>.png" alt="<?= htmlspecialchars($item['name']) ?>" class="max-h-full max-w-full object-contain">
                                </div>
                                
                                <!-- Item Details -->
                                <div class="flex-1 p-4 flex flex-col">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-medium text-gray-800 mb-1"><?= htmlspecialchars($item['name']) ?></h3>
                                            <div class="flex items-center mb-2">
                                                <span class="px-2 py-0.5 bg-<?= $this->getRarityColor($item['rarity']) ?>-100 text-<?= $this->getRarityColor($item['rarity']) ?>-800 text-xs font-medium rounded-full capitalize mr-2">
                                                    <?= $item['rarity'] ?>
                                                </span>
                                                <span class="text-gray-500 text-sm capitalize">
                                                    <?= str_replace('_', ' ', $item['type']) ?>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-500">
                                            Added <?= date('M j, Y', strtotime($item['added_at'])) ?>
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-600 text-sm mb-4 flex-grow">
                                        <?= htmlspecialchars($item['description']) ?>
                                    </p>
                                    
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-auto pt-3 border-t border-gray-100">
                                        <div class="flex items-center mb-3 sm:mb-0">
                                            <span class="font-bold text-gray-800 mr-1"><?= number_format($item['price']) ?></span>
                                            <i class="fas fa-coins text-yellow-500 text-sm mr-3"></i>
                                            
                                            <?php if ($item['price'] > $userCoins): ?>
                                                <span class="text-xs text-red-500 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    Not enough coins
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            <button class="remove-wishlist-btn px-3 py-1.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors" data-item-id="<?= $item['id'] ?>">
                                                <i class="fas fa-trash-alt mr-1"></i> Remove
                                            </button>
                                            
                                            <button class="add-to-cart-btn px-3 py-1.5 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors <?= $item['price'] > $userCoins ? 'opacity-50 cursor-not-allowed' : '' ?>" data-item-id="<?= $item['id'] ?>" <?= $item['price'] > $userCoins ? 'disabled' : '' ?>>
                                                <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Recommended Items -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                <h2 class="text-lg font-bold">Recommended For You</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <!-- Recommended Item 1 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                        <div class="relative">
                            <img src="<?= $baseUrl ?>/images/shop/crystal-fountain.png" alt="Crystal Fountain" class="w-full h-36 object-contain p-4 bg-purple-50">
                            <div class="absolute top-2 right-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                Rare
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800 mb-1 text-sm">Crystal Fountain</h3>
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">Enchanted fountain that boosts happiness for all creatures.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="font-bold text-gray-800 mr-1">600</span>
                                    <i class="fas fa-coins text-yellow-500 text-sm"></i>
                                </div>
                                <button class="add-to-wishlist-btn text-gray-400 hover:text-purple-600 transition-colors" data-item-id="11">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recommended Item 2 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                        <div class="relative">
                            <img src="<?= $baseUrl ?>/images/shop/mythical-fruit.png" alt="Mythical Fruit" class="w-full h-36 object-contain p-4 bg-green-50">
                            <div class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                Uncommon
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800 mb-1 text-sm">Mythical Fruit</h3>
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">Magical fruit that boosts creature growth speed.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="font-bold text-gray-800 mr-1">250</span>
                                    <i class="fas fa-coins text-yellow-500 text-sm"></i>
                                </div>
                                <button class="add-to-wishlist-btn text-gray-400 hover:text-purple-600 transition-colors" data-item-id="12">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recommended Item 3 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                        <div class="relative">
                            <img src="<?= $baseUrl ?>/images/shop/ruby-egg.png" alt="Ruby Egg" class="w-full h-36 object-contain p-4 bg-red-50">
                            <div class="absolute top-2 right-2 bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full">
                                Legendary
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800 mb-1 text-sm">Ruby Egg</h3>
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">Contains a rare fire-themed mythical creature.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="font-bold text-gray-800 mr-1">850</span>
                                    <i class="fas fa-coins text-yellow-500 text-sm"></i>
                                </div>
                                <button class="add-to-wishlist-btn text-gray-400 hover:text-purple-600 transition-colors" data-item-id="13">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recommended Item 4 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                        <div class="relative">
                            <img src="<?= $baseUrl ?>/images/shop/mystic-lantern.png" alt="Mystic Lantern" class="w-full h-36 object-contain p-4 bg-yellow-50">
                            <div class="absolute top-2 right-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                Rare
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800 mb-1 text-sm">Mystic Lantern</h3>
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">Illuminates habitats with magical light.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="font-bold text-gray-800 mr-1">480</span>
                                    <i class="fas fa-coins text-yellow-500 text-sm"></i>
                                </div>
                                <button class="add-to-wishlist-btn text-gray-400 hover:text-purple-600 transition-colors" data-item-id="14">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recommended Item 5 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                        <div class="relative">
                            <img src="<?= $baseUrl ?>/images/shop/celestial-arch.png" alt="Celestial Arch" class="w-full h-36 object-contain p-4 bg-blue-50">
                            <div class="absolute top-2 right-2 bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full">
                                Legendary
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800 mb-1 text-sm">Celestial Arch</h3>
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">Magnificent archway for cosmic habitats.</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="font-bold text-gray-800 mr-1">780</span>
                                    <i class="fas fa-coins text-yellow-500 text-sm"></i>
                                </div>
                                <button class="add-to-wishlist-btn text-gray-400 hover:text-purple-600 transition-colors" data-item-id="15">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Purchase Confirmation Modal -->
<div id="purchase-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl max-w-md w-full overflow-hidden">
        <div class="bg-purple-600 px-6 py-4 text-white relative">
            <h3 class="text-xl font-bold">Purchase Confirmation</h3>
            <button id="close-modal-btn" class="absolute top-4 right-4 text-white hover:text-purple-100">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="text-center mb-6">
                <div id="purchase-item-image" class="w-32 h-32 mx-auto mb-4 flex items-center justify-center">
                    <img src="<?= $baseUrl ?>/images/shop/golden-crown.png" alt="Item" class="max-h-full max-w-full object-contain">
                </div>
                <h4 id="purchase-item-name" class="text-xl font-bold text-gray-800 mb-2">Golden Crown</h4>
                <p id="purchase-item-description" class="text-gray-600">Royal accessory for your mythical creatures</p>
            </div>
            
            <div class="flex justify-between items-center py-3 border-t border-b border-gray-200 mb-6">
                <span class="text-gray-700">Price:</span>
                <div class="flex items-center">
                    <span id="purchase-item-price" class="font-bold text-gray-800 mr-1">750</span>
                    <i class="fas fa-coins text-yellow-500"></i>
                </div>
            </div>
            
            <div class="flex justify-between mb-6">
                <span class="text-gray-700">Your Balance:</span>
                <div class="flex items-center">
                    <span class="font-bold text-gray-800 mr-1"><?= number_format($userCoins) ?></span>
                    <i class="fas fa-coins text-yellow-500"></i>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <button id="cancel-purchase-btn" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button id="confirm-purchase-btn" class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                    Confirm Purchase
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl max-w-md w-full overflow-hidden">
        <div class="bg-green-600 px-6 py-4 text-white relative">
            <h3 class="text-xl font-bold">Purchase Successful</h3>
            <button class="close-success-btn absolute top-4 right-4 text-white hover:text-green-100">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Thank You!</h4>
                <p class="text-gray-600" id="success-message">Your purchase was successful.</p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h5 class="font-medium text-gray-800 mb-2">Item Added to Inventory</h5>
                <p class="text-gray-600 text-sm">You can find your new item in your inventory. Would you like to equip it now?</p>
            </div>
            
            <div class="flex space-x-3">
                <button class="close-success-btn flex-1 px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Later
                </button>
                <button id="go-to-inventory-btn" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    Go to Inventory
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove from wishlist functionality
    const removeButtons = document.querySelectorAll('.remove-wishlist-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            removeFromWishlist(itemId);
        });
    });
    
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn:not([disabled])');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            
            // Find item data from wishlist items
            const itemElement = this.closest('.flex.flex-col.sm\\:flex-row');
            if (itemElement) {
                const itemName = itemElement.querySelector('h3').textContent;
                const itemDescription = itemElement.querySelector('p.text-gray-600').textContent;
                const itemPrice = parseInt(itemElement.querySelector('.font-bold.text-gray-800').textContent.replace(/,/g, ''));
                const itemImage = itemElement.querySelector('img').src;
                
                showPurchaseModal(itemId, itemName, itemDescription, itemPrice, itemImage);
            }
        });
    });
    
    // Add to wishlist from recommended items
    const addToWishlistButtons = document.querySelectorAll('.add-to-wishlist-btn');
    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            addToWishlist(itemId);
        });
    });
    
    // Purchase modal functionality
    const purchaseModal = document.getElementById('purchase-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelPurchaseBtn = document.getElementById('cancel-purchase-btn');
    const confirmPurchaseBtn = document.getElementById('confirm-purchase-btn');
    
    // Success modal functionality
    const successModal = document.getElementById('success-modal');
    const closeSuccessButtons = document.querySelectorAll('.close-success-btn');
    const goToInventoryBtn = document.getElementById('go-to-inventory-btn');
    
    // Function to show purchase modal
    function showPurchaseModal(itemId, itemName, itemDescription, itemPrice, itemImage) {
        // Update modal content
        document.getElementById('purchase-item-name').textContent = itemName;
        document.getElementById('purchase-item-description').textContent = itemDescription;
        document.getElementById('purchase-item-price').textContent = itemPrice;
        document.getElementById('purchase-item-image').querySelector('img').src = itemImage;
        
        // Store item ID for purchase confirmation
        confirmPurchaseBtn.setAttribute('data-item-id', itemId);
        
        // Show modal
        purchaseModal.classList.remove('hidden');
    }
    
    // Function to close purchase modal
    function closePurchaseModal() {
        purchaseModal.classList.add('hidden');
    }
    
    // Function to show success modal
    function showSuccessModal(message) {
        document.getElementById('success-message').textContent = message || 'Your purchase was successful.';
        successModal.classList.remove('hidden');
    }
    
    // Function to close success modal
    function closeSuccessModal() {
        successModal.classList.add('hidden');
    }
    
    // Function to remove item from wishlist
    function removeFromWishlist(itemId) {
        // In a real implementation, this would make an AJAX request to the server
        fetch('<?= $baseUrl ?>/shop/wishlist/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ item_id: itemId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove item from UI
                const itemElement = document.querySelector(`.remove-wishlist-btn[data-item-id="${itemId}"]`).closest('.flex.flex-col.sm\\:flex-row');
                if (itemElement) {
                    itemElement.remove();
                }
                
                // Update item count
                const itemCountEl = document.querySelector('.text-purple-600.font-medium');
                if (itemCountEl) {
                    const currentCount = parseInt(itemCountEl.textContent);
                    itemCountEl.textContent = (currentCount - 1) + ' items';
                }
                
                // If no items left, reload page to show empty state
                if (document.querySelectorAll('.flex.flex-col.sm\\:flex-row').length === 0) {
                    window.location.reload();
                }
            } else {
                alert('Failed to remove item from wishlist. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
    
    // Function to add item to wishlist
    function addToWishlist(itemId) {
        // In a real implementation, this would make an AJAX request to the server
        fetch('<?= $baseUrl ?>/shop/wishlist/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ item_id: itemId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Change heart icon to filled
                const heartIcon = document.querySelector(`.add-to-wishlist-btn[data-item-id="${itemId}"] i`);
                if (heartIcon) {
                    heartIcon.classList.remove('far');
                    heartIcon.classList.add('fas');
                    heartIcon.closest('button').classList.add('text-purple-600');
                }
                
                // Show feedback
                alert('Item added to your wishlist!');
            } else {
                alert('Failed to add item to wishlist. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
    
    // Function to purchase item
    function purchaseItem(itemId) {
        // In a real implementation, this would make an AJAX request to the server
        fetch('<?= $baseUrl ?>/shop/purchase', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 
                item_id: itemId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close purchase modal
                closePurchaseModal();
                
                // Show success modal
                showSuccessModal(data.message);
                
                // Remove from wishlist
                removeFromWishlist(itemId);
                
                // Update coin balance
                // In a real implementation, this would update the displayed balance
            } else {
                alert('Purchase failed: ' + (data.message || 'Please try again.'));
                closePurchaseModal();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            closePurchaseModal();
        });
    }
    
    // Close modal when clicking the close button
    closeModalBtn.addEventListener('click', closePurchaseModal);
    
    // Close modal when clicking the cancel button
    cancelPurchaseBtn.addEventListener('click', closePurchaseModal);
    
    // Handle purchase confirmation
    confirmPurchaseBtn.addEventListener('click', function() {
        const itemId = this.getAttribute('data-item-id');
        purchaseItem(itemId);
    });
    
    // Close success modal when clicking the close buttons
    closeSuccessButtons.forEach(button => {
        button.addEventListener('click', closeSuccessModal);
    });
    
    // Go to inventory
    goToInventoryBtn.addEventListener('click', function() {
        window.location.href = '<?= $baseUrl ?>/inventory';
    });
    
    // Close modals when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === purchaseModal) {
            closePurchaseModal();
        }
        
        if (e.target === successModal) {
            closeSuccessModal();
        }
    });
});
</script>

<?php 
// Helper function to get color for rarity
function getRarityColor($rarity) {
    switch ($rarity) {
        case 'common':
            return 'gray';
        case 'uncommon':
            return 'green';
        case 'rare':
            return 'blue';
        case 'legendary':
            return 'purple';
        case 'mythical':
            return 'yellow';
        default:
            return 'gray';
    }
}
?>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>