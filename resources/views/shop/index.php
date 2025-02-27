<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<style>
  :root {
    --primary-bg: #F9F8F2;
    --primary-text: #111111;
    --accent-primary: #6B5CA5;
    --accent-secondary: #8FC0A9;
    --accent-tertiary: #C8553D;
    --neutral-light: #F5F5F5;
    --neutral-medium: #E0E0E0;
    --neutral-dark: #666666;
  }
  
  /* Animation classes */
  .fade-in {
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.5s ease, transform 0.5s ease;
  }
  
  .fade-in.visible {
    opacity: 1;
    transform: translateY(0);
  }
  
  .hover-scale {
    transition: transform 0.3s ease;
  }
  
  .hover-scale:hover {
    transform: scale(1.05);
  }
  
  /* Remove scrollbar for horizontal scroll areas */
  .no-scrollbar::-webkit-scrollbar {
    display: none;
  }
  
  .no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
  
  /* Rarity badges */
  .badge-common {
    background-color: #E0E0E0;
    color: #555555;
  }
  
  .badge-uncommon {
    background-color: #C5E1A5;
    color: #33691E;
  }
  
  .badge-rare {
    background-color: #90CAF9;
    color: #0D47A1;
  }
  
  .badge-legendary {
    background-color: #CE93D8;
    color: #4A148C;
  }
  
  .badge-mythical {
    background-color: #FFD54F;
    color: #E65100;
  }
</style>

<div class="min-h-screen bg-[var(--primary-bg)]">
  <!-- Hero Section -->
  <div class="relative overflow-hidden bg-[var(--primary-bg)] text-[var(--primary-text)]">
    <div class="absolute opacity-10 right-0 top-0 w-full h-full">
      <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
        <pattern id="anthropic-pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
          <path d="M20,0 Q40,20 20,40 Q0,20 20,0" stroke="currentColor" stroke-width="1" fill="none" />
        </pattern>
        <rect width="100%" height="100%" fill="url(#anthropic-pattern)" />
      </svg>
    </div>
    <div class="container mx-auto px-4 py-12 relative z-10">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-6 md:mb-0 max-w-xl">
          <h1 class="font-display text-3xl md:text-4xl font-bold mb-3">Wildlife Haven Shop</h1>
          <p class="text-[var(--neutral-dark)] text-lg font-light">Enhance your digital wildlife sanctuary with thoughtfully designed items that support real-world conservation efforts.</p>
        </div>
        <div class="flex items-center bg-white shadow-sm rounded-lg px-5 py-4">
          <i class="fas fa-coins text-yellow-400 mr-3 text-xl"></i>
          <div>
            <span class="block text-sm text-[var(--neutral-dark)]">Your Balance</span>
            <span class="font-bold text-xl"><?= number_format($userCoins) ?> WildCoins</span>
          </div>
          <a href="<?= $baseUrl ?>/shop/get-currency" class="ml-4 bg-gradient-to-r from-[var(--accent-primary)] to-[#5D4F91] hover:from-[#5D4F91] hover:to-[#4F4178] text-white text-sm font-medium px-4 py-2 rounded-lg transition-all duration-300">
            Get More
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content Container -->
  <div class="container mx-auto px-4 pb-12">
    <!-- Daily Deals Section -->
    <div class="fade-in mb-8 bg-white rounded-lg shadow-sm overflow-hidden">
      <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="flex items-center mb-4 md:mb-0">
            <div class="bg-white rounded-full p-3 mr-4 shadow-sm">
              <i class="fas fa-bolt text-amber-500 text-xl"></i>
            </div>
            <div>
              <h2 class="text-white font-bold text-2xl">Daily Deals</h2>
              <p class="text-amber-100">Special offers refreshing in <span id="countdown-timer" class="font-bold">23:45:19</span></p>
            </div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full md:w-auto">
            <!-- Daily Deal Item 1 -->
            <div class="bg-white bg-opacity-10 rounded-lg p-3 flex items-center group hover:bg-opacity-20 transition-all cursor-pointer">
              <div class="w-12 h-12 bg-white rounded-md flex items-center justify-center mr-3 shadow-sm">
                <img src="<?= $baseUrl ?>/images/shop/crystal-egg.png" alt="Crystal Egg" class="w-10 h-10 object-contain">
              </div>
              <div class="flex-1">
                <h3 class="text-white font-medium text-sm">Crystal Egg</h3>
                <div class="flex items-center">
                  <span class="text-gray-200 text-xs line-through mr-2">500</span>
                  <span class="text-white font-bold">350</span>
                  <i class="fas fa-coins text-yellow-300 text-xs ml-1"></i>
                </div>
              </div>
            </div>
            
            <!-- Daily Deal Item 2 -->
            <div class="bg-white bg-opacity-10 rounded-lg p-3 flex items-center group hover:bg-opacity-20 transition-all cursor-pointer">
              <div class="w-12 h-12 bg-white rounded-md flex items-center justify-center mr-3 shadow-sm">
                <img src="<?= $baseUrl ?>/images/shop/golden-fountain.png" alt="Golden Fountain" class="w-10 h-10 object-contain">
              </div>
              <div class="flex-1">
                <h3 class="text-white font-medium text-sm">Golden Fountain</h3>
                <div class="flex items-center">
                  <span class="text-gray-200 text-xs line-through mr-2">1200</span>
                  <span class="text-white font-bold">800</span>
                  <i class="fas fa-coins text-yellow-300 text-xs ml-1"></i>
                </div>
              </div>
            </div>
            
            <!-- Daily Deal Item 3 -->
            <div class="hidden sm:flex bg-white bg-opacity-10 rounded-lg p-3 items-center group hover:bg-opacity-20 transition-all cursor-pointer">
              <div class="w-12 h-12 bg-white rounded-md flex items-center justify-center mr-3 shadow-sm">
                <img src="<?= $baseUrl ?>/images/shop/sapphire-collar.png" alt="Sapphire Collar" class="w-10 h-10 object-contain">
              </div>
              <div class="flex-1">
                <h3 class="text-white font-medium text-sm">Sapphire Collar</h3>
                <div class="flex items-center">
                  <span class="text-gray-200 text-xs line-through mr-2">750</span>
                  <span class="text-white font-bold">550</span>
                  <i class="fas fa-coins text-yellow-300 text-xs ml-1"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="fade-in bg-white rounded-lg shadow-sm p-5 mb-8">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="relative flex-grow max-w-md">
          <input 
            type="text" 
            placeholder="Search items..." 
            class="w-full pl-10 pr-4 py-2 bg-[var(--primary-bg)] border border-[var(--neutral-medium)] rounded-lg focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)] transition-colors">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-search text-[var(--neutral-dark)]"></i>
          </div>
        </div>
        
        <div class="flex flex-wrap gap-3">
          <div class="relative">
            <select class="appearance-none bg-[var(--primary-bg)] border border-[var(--neutral-medium)] rounded-lg py-2 pl-4 pr-10 focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)] transition-colors">
              <option value="">Sort by: Newest</option>
              <option value="price-asc">Price: Low to High</option>
              <option value="price-desc">Price: High to Low</option>
              <option value="popularity">Most Popular</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[var(--neutral-dark)]">
              <i class="fas fa-chevron-down text-xs"></i>
            </div>
          </div>
          
          <div class="relative">
            <select class="appearance-none bg-[var(--primary-bg)] border border-[var(--neutral-medium)] rounded-lg py-2 pl-4 pr-10 focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)] transition-colors">
              <option value="">Filter by Rarity</option>
              <option value="common">Common</option>
              <option value="uncommon">Uncommon</option>
              <option value="rare">Rare</option>
              <option value="legendary">Legendary</option>
              <option value="mythical">Mythical</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[var(--neutral-dark)]">
              <i class="fas fa-chevron-down text-xs"></i>
            </div>
          </div>
          
          <button class="bg-[var(--primary-bg)] hover:bg-[var(--neutral-medium)] text-[var(--primary-text)] py-2 px-4 rounded-lg flex items-center transition-colors duration-300">
            <i class="fas fa-sliders-h mr-2"></i> More Filters
          </button>
        </div>
      </div>
    </div>

    <!-- Shop Categories Tab Navigation -->
    <div class="fade-in mb-8" x-data="{ activeTab: 'all' }">
      <div class="flex flex-nowrap overflow-x-auto md:flex-wrap no-scrollbar border-b border-[var(--neutral-medium)] mb-6">
        <button 
          @click="activeTab = 'all'" 
          :class="{ 'border-[var(--accent-primary)] text-[var(--accent-primary)] font-medium': activeTab === 'all', 'border-transparent text-[var(--neutral-dark)] hover:text-[var(--primary-text)]': activeTab !== 'all' }" 
          class="px-5 py-3 border-b-2 -mb-px whitespace-nowrap transition-all duration-300">
          All Items
        </button>
        <button 
          @click="activeTab = 'creatures'" 
          :class="{ 'border-[var(--accent-primary)] text-[var(--accent-primary)] font-medium': activeTab === 'creatures', 'border-transparent text-[var(--neutral-dark)] hover:text-[var(--primary-text)]': activeTab !== 'creatures' }" 
          class="px-5 py-3 border-b-2 -mb-px whitespace-nowrap transition-all duration-300">
          <i class="fas fa-dragon mr-2"></i> Creature Items
        </button>
        <button 
          @click="activeTab = 'habitats'" 
          :class="{ 'border-[var(--accent-primary)] text-[var(--accent-primary)] font-medium': activeTab === 'habitats', 'border-transparent text-[var(--neutral-dark)] hover:text-[var(--primary-text)]': activeTab !== 'habitats' }" 
          class="px-5 py-3 border-b-2 -mb-px whitespace-nowrap transition-all duration-300">
          <i class="fas fa-tree mr-2"></i> Habitat Decorations
        </button>
        <button 
          @click="activeTab = 'eggs'" 
          :class="{ 'border-[var(--accent-primary)] text-[var(--accent-primary)] font-medium': activeTab === 'eggs', 'border-transparent text-[var(--neutral-dark)] hover:text-[var(--primary-text)]': activeTab !== 'eggs' }" 
          class="px-5 py-3 border-b-2 -mb-px whitespace-nowrap transition-all duration-300">
          <i class="fas fa-egg mr-2"></i> Special Eggs
        </button>
        <button 
          @click="activeTab = 'conservation'" 
          :class="{ 'border-[var(--accent-primary)] text-[var(--accent-primary)] font-medium': activeTab === 'conservation', 'border-transparent text-[var(--neutral-dark)] hover:text-[var(--primary-text)]': activeTab !== 'conservation' }" 
          class="px-5 py-3 border-b-2 -mb-px whitespace-nowrap transition-all duration-300">
          <i class="fas fa-leaf mr-2"></i> Conservation
        </button>
        <button 
          @click="activeTab = 'limited'" 
          :class="{ 'border-[var(--accent-primary)] text-[var(--accent-primary)] font-medium': activeTab === 'limited', 'border-transparent text-[var(--neutral-dark)] hover:text-[var(--primary-text)]': activeTab !== 'limited' }" 
          class="px-5 py-3 border-b-2 -mb-px whitespace-nowrap transition-all duration-300">
          <i class="fas fa-star mr-2"></i> Limited Edition
        </button>
      </div>
      
      <!-- All Items Tab Panel -->
      <div 
        x-show="activeTab === 'all'" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        
        <!-- Featured Item -->
        <div class="col-span-2 lg:col-span-2 bg-gradient-to-br from-[var(--accent-primary)] to-purple-700 rounded-xl shadow-md overflow-hidden text-white relative group">
          <div class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 font-bold uppercase text-xs px-2 py-1 rounded-full z-10">
            Featured
          </div>
          <div class="p-6 flex flex-col h-full relative z-0">
            <h3 class="text-xl font-bold mb-1">Mythical Habitat Expansion</h3>
            <p class="text-purple-100 text-sm mb-4">Double your habitat size and unlock special decoration slots</p>
            <div class="mt-auto flex justify-between items-end">
              <div class="flex items-center">
                <span class="text-2xl font-bold mr-1">1,500</span>
                <i class="fas fa-coins text-yellow-300"></i>
              </div>
              <button class="bg-white text-[var(--accent-primary)] font-medium px-4 py-2 rounded-lg hover:bg-purple-50 transition-colors duration-300">
                Buy Now
              </button>
            </div>
          </div>
          <img src="<?= $baseUrl ?>/images/shop/mythical-expansion.png" alt="Mythical Habitat Expansion" class="absolute -right-8 bottom-0 h-32 transform transition-transform duration-300 group-hover:scale-110 group-hover:translate-x-2">
        </div>
        
        <!-- Regular Item 1 -->
        <div class="bg-white rounded-lg shadow-sm border border-[var(--neutral-light)] overflow-hidden group hover:shadow-md transition-all duration-300 shop-item">
            <div class="relative">
                <div class="bg-[var(--primary-bg)] h-48 flex items-center justify-center p-4 transition-all duration-300 group-hover:bg-[#F5F2E9]">
                <img src="<?= $baseUrl ?>/public/images/arctic_hare.png" alt="Arctic Shimmer Hare" class="h-32 w-auto object-contain item-image transform transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="absolute top-3 right-3 badge-rare text-xs font-medium px-2 py-1 rounded-full">
                Rare
                </div>
            </div>
            <div class="p-5">
                <h3 class="font-medium text-[var(--primary-text)] mb-1">Arctic Shimmer Hare</h3>
                <p class="text-sm text-[var(--neutral-dark)] mb-3">A magical egg containing a rare mountain creature</p>
                <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <span class="font-bold text-[var(--primary-text)] mr-1">650</span>
                    <i class="fas fa-coins text-yellow-500 text-sm"></i>
                </div>
                <div class="flex space-x-2">
                    <a href="<?= $baseUrl ?>/shop/model-preview/100" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-3 py-2 rounded-lg transition-colors inline-flex items-center">
                    <i class="fas fa-cube mr-1"></i> 3D View
                    </a>
                    <button class="bg-[var(--accent-primary)] hover:bg-[#5D4F91] text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i> Add
                    </button>
                </div>
                </div>
            </div>  
        </div>
        
        <!-- Regular Item 2 -->
        <div class="bg-white rounded-lg shadow-sm border border-[var(--neutral-light)] overflow-hidden group hover:shadow-md transition-all duration-300 shop-item">
          <div class="relative">
            <div class="bg-[var(--primary-bg)] h-48 flex items-center justify-center p-4 transition-all duration-300 group-hover:bg-[#F5F2E9]">
              <img src="<?= $baseUrl ?>/images/shop/golden-crown.png" alt="Golden Crown" class="h-32 w-auto object-contain item-image transform transition-transform duration-300 group-hover:scale-105">
            </div>
            <div class="absolute top-3 right-3 badge-legendary text-xs font-medium px-2 py-1 rounded-full">
              Legendary
            </div>
          </div>
          <div class="p-5">
            <h3 class="font-medium text-[var(--primary-text)] mb-1">Golden Crown</h3>
            <p class="text-sm text-[var(--neutral-dark)] mb-3">Royal accessory for your mythical creatures</p>
            <div class="flex justify-between items-center">
              <div class="flex items-center">
                <span class="font-bold text-[var(--primary-text)] mr-1">750</span>
                <i class="fas fa-coins text-yellow-500 text-sm"></i>
              </div>
              <button class="bg-[var(--accent-primary)] hover:bg-[#5D4F91] text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-300 flex items-center">
                <i class="fas fa-shopping-cart mr-2"></i> Add
              </button>
            </div>
          </div>
        </div>
        
        <!-- Regular Item 3 -->
        <div class="bg-white rounded-lg shadow-sm border border-[var(--neutral-light)] overflow-hidden group hover:shadow-md transition-all duration-300 shop-item">
          <div class="relative">
            <div class="bg-[var(--primary-bg)] h-48 flex items-center justify-center p-4 transition-all duration-300 group-hover:bg-[#F5F2E9]">
              <img src="<?= $baseUrl ?>/images/shop/enchanted-fountain.png" alt="Enchanted Fountain" class="h-32 w-auto object-contain item-image transform transition-transform duration-300 group-hover:scale-105">
            </div>
            <div class="absolute top-3 right-3 badge-uncommon text-xs font-medium px-2 py-1 rounded-full">
              Uncommon
            </div>
          </div>
          <div class="p-5">
            <h3 class="font-medium text-[var(--primary-text)] mb-1">Enchanted Fountain</h3>
            <p class="text-sm text-[var(--neutral-dark)] mb-3">Boosts happiness for all creatures in a habitat</p>
            <div class="flex justify-between items-center">
              <div class="flex items-center">
                <span class="font-bold text-[var(--primary-text)] mr-1">325</span>
                <i class="fas fa-coins text-yellow-500 text-sm"></i>
              </div>
              <button class="bg-[var(--accent-primary)] hover:bg-[#5D4F91] text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-300 flex items-center">
                <i class="fas fa-shopping-cart mr-2"></i> Add
              </button>
            </div>
          </div>
        </div>
        
        <!-- Regular Item 4 -->
        <div class="bg-white rounded-lg shadow-sm border border-[var(--neutral-light)] overflow-hidden group hover:shadow-md transition-all duration-300 shop-item">
          <div class="relative">
            <div class="bg-[var(--primary-bg)] h-48 flex items-center justify-center p-4 transition-all duration-300 group-hover:bg-[#F5F2E9]">
              <img src="<?= $baseUrl ?>/images/shop/emerald-egg.png" alt="Emerald Egg" class="h-32 w-auto object-contain item-image transform transition-transform duration-300 group-hover:scale-105">
            </div>
            <div class="absolute top-3 right-3 badge-rare text-xs font-medium px-2 py-1 rounded-full">
              Rare
            </div>
          </div>
          <div class="p-5">
            <h3 class="font-medium text-[var(--primary-text)] mb-1">Emerald Egg</h3>
            <p class="text-sm text-[var(--neutral-dark)] mb-3">Contains a rare forest creature</p>
            <div class="flex justify-between items-center">
              <div class="flex items-center">
                <span class="font-bold text-[var(--primary-text)] mr-1">500</span>
                <i class="fas fa-coins text-yellow-500 text-sm"></i>
              </div>
              <button class="bg-[var(--accent-primary)] hover:bg-[#5D4F91] text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-300 flex items-center">
                <i class="fas fa-shopping-cart mr-2"></i> Add
              </button>
            </div>
          </div>
        </div>
        
        <!-- More items would be populated here -->
      </div>
      
      <!-- Creatures Items Tab Panel -->
      <div 
        x-show="activeTab === 'creatures'" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        class="min-h-[200px] flex items-center justify-center">
        <div class="text-center py-8 text-[var(--neutral-dark)]">
          <i class="fas fa-spinner fa-spin text-xl mb-3"></i>
          <p>Loading creature items...</p>
        </div>
      </div>
      
      <!-- Other tab panels would be structured similarly -->
    </div>

    <!-- Recently Viewed Section -->
    <div class="fade-in bg-white rounded-xl shadow-sm overflow-hidden mb-8">
      <div class="px-6 py-4 bg-[var(--neutral-light)] border-b border-[var(--neutral-medium)]">
        <h2 class="text-lg font-medium text-[var(--primary-text)]">Recently Viewed</h2>
      </div>
      <div class="p-6">
        <div class="flex overflow-x-auto no-scrollbar space-x-4 pb-2">
          <?php foreach ($recentlyViewed as $item): ?>
            <div class="flex-shrink-0 w-40 bg-white rounded-lg border border-[var(--neutral-light)] overflow-hidden hover:shadow-sm transition-all duration-300">
              <div class="bg-[var(--primary-bg)] p-3 flex items-center justify-center h-32">
                <img src="<?= $baseUrl ?>/images/shop/<?= $item['id'] ?>.png" alt="<?= htmlspecialchars($item['name']) ?>" class="max-h-24 max-w-full object-contain hover-scale">
              </div>
              <div class="p-3">
                <h3 class="font-medium text-sm text-[var(--primary-text)] mb-1 truncate"><?= htmlspecialchars($item['name']) ?></h3>
                <div class="flex items-center">
                  <span class="font-bold text-sm text-[var(--primary-text)] mr-1"><?= number_format($item['price']) ?></span>
                  <i class="fas fa-coins text-yellow-500 text-xs"></i>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          
          <?php if (empty($recentlyViewed)): ?>
            <!-- Placeholder items if no recent views -->
            <div class="flex-shrink-0 w-40 bg-white rounded-lg border border-[var(--neutral-light)] overflow-hidden">
              <div class="bg-[var(--primary-bg)] p-3 flex items-center justify-center h-32">
                <img src="<?= $baseUrl ?>/images/shop/magic-crystal.png" alt="Magic Crystal" class="max-h-24 max-w-full object-contain hover-scale">
              </div>
              <div class="p-3">
                <h3 class="font-medium text-sm text-[var(--primary-text)] mb-1 truncate">Magic Crystal</h3>
                <div class="flex items-center">
                  <span class="font-bold text-sm text-[var(--primary-text)] mr-1">450</span>
                  <i class="fas fa-coins text-yellow-500 text-xs"></i>
                </div>
              </div>
            </div>
            
            <div class="flex-shrink-0 w-40 bg-white rounded-lg border border-[var(--neutral-light)] overflow-hidden">
              <div class="bg-[var(--primary-bg)] p-3 flex items-center justify-center h-32">
                <img src="<?= $baseUrl ?>/images/shop/golden-crown.png" alt="Golden Crown" class="max-h-24 max-w-full object-contain hover-scale">
              </div>
              <div class="p-3">
                <h3 class="font-medium text-sm text-[var(--primary-text)] mb-1 truncate">Golden Crown</h3>
                <div class="flex items-center">
                  <span class="font-bold text-sm text-[var(--primary-text)] mr-1">750</span>
                  <i class="fas fa-coins text-yellow-500 text-xs"></i>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <!-- Community Progress Section -->
    <div class="fade-in bg-[var(--primary-bg)] rounded-xl shadow-sm overflow-hidden mt-12">
      <div class="px-6 py-4 bg-gradient-to-r from-[var(--accent-secondary)] to-[#7FB09A] text-white">
        <h2 class="text-xl font-display font-bold">Community Conservation Impact</h2>
      </div>
      <div class="p-6">
        <div class="mb-8">
          <p class="text-[var(--neutral-dark)] text-center mb-6 max-w-2xl mx-auto">Together, the Wildlife Haven community is making a measurable difference in conservation efforts worldwide.</p>
          
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg p-6 shadow-sm flex flex-col items-center">
              <div class="w-12 h-12 rounded-full bg-[#F3F0E6] flex items-center justify-center mb-4">
                <i class="fas fa-tree text-[var(--accent-secondary)] text-xl"></i>
              </div>
              <span class="text-4xl font-display font-bold text-[var(--primary-text)] mb-1"><?= number_format($globalStats['trees_planted'] ?? 547) ?></span>
              <span class="text-[var(--neutral-dark)]">Trees Planted</span>
            </div>
            
            <div class="bg-white rounded-lg p-6 shadow-sm flex flex-col items-center">
              <div class="w-12 h-12 rounded-full bg-[#F3F0E6] flex items-center justify-center mb-4">
                <i class="fas fa-mountain text-blue-700 text-xl"></i>
              </div>
              <span class="text-4xl font-display font-bold text-[var(--primary-text)] mb-1"><?= number_format($globalStats['habitat_protected'] ?? 32) ?></span>
              <span class="text-[var(--neutral-dark)]">Acres Protected</span>
            </div>
            
            <div class="bg-white rounded-lg p-6 shadow-sm flex flex-col items-center">
              <div class="w-12 h-12 rounded-full bg-[#F3F0E6] flex items-center justify-center mb-4">
                <i class="fas fa-paw text-[var(--accent-tertiary)] text-xl"></i>
              </div>
              <span class="text-4xl font-display font-bold text-[var(--primary-text)] mb-1"><?= number_format($globalStats['animals_supported'] ?? 124) ?></span>
              <span class="text-[var(--neutral-dark)]">Animals Supported</span>
            </div>
          </div>
        </div>
        
        <!-- Current Goal -->
        <div class="bg-white rounded-lg p-6 mb-6 shadow-sm">
          <div class="flex justify-between items-center mb-3">
            <h3 class="font-bold text-[var(--primary-text)]">Current Community Goal: 1,000 Trees</h3>
            <span class="text-[var(--accent-secondary)] font-medium"><?= (($globalStats['trees_planted'] ?? 547) / 1000) * 100 ?>% Complete</span>
          </div>
          <div class="w-full bg-[var(--neutral-light)] rounded-full h-2.5 mb-4 overflow-hidden">
            <div class="bg-[var(--accent-secondary)] h-2.5 rounded-full" style="width: <?= (($globalStats['trees_planted'] ?? 547) / 1000) * 100 ?>%"></div>
          </div>
          <p class="text-sm text-[var(--neutral-dark)] mb-4">When we reach 1,000 trees, all users will receive a special Rainforest Guardian egg!</p>
          <div class="text-center">
            <button class="inline-flex items-center px-4 py-2 bg-[var(--accent-secondary)] hover:bg-[#7FB09A] text-white font-medium rounded-lg transition-colors duration-300">
              <i class="fas fa-seedling mr-2"></i> Contribute Now
            </button>
          </div>
        </div>
        
        <!-- Conservation Partners -->
        <div class="text-center">
          <h3 class="font-medium text-[var(--primary-text)] mb-3">Our Conservation Partners</h3>
          <div class="flex flex-wrap justify-center items-center gap-6">
            <img src="<?= $baseUrl ?>/images/partners/rainforest-trust.png" alt="Rainforest Trust" class="h-12 opacity-70 hover:opacity-100 transition-opacity">
            <img src="<?= $baseUrl ?>/images/partners/wwf.png" alt="World Wildlife Fund" class="h-10 opacity-70 hover:opacity-100 transition-opacity">
            <img src="<?= $baseUrl ?>/images/partners/one-tree-planted.png" alt="One Tree Planted" class="h-12 opacity-70 hover:opacity-100 transition-opacity">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Item Preview Modal -->
<div id="item-preview-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
    <div class="flex flex-col md:flex-row">
      <!-- Item Preview Image -->
      <div class="w-full md:w-1/2 bg-[var(--primary-bg)] p-6 flex items-center justify-center min-h-[300px]">
        <div id="item-preview-display" class="w-full h-full">
          <!-- Image will be loaded here -->
          <img src="<?= $baseUrl ?>/images/shop/golden-crown.png" alt="Golden Crown" class="max-w-full max-h-[400px] object-contain mx-auto">
        </div>
      </div>
      
      <!-- Item Details -->
      <div class="w-full md:w-1/2 p-6 overflow-y-auto max-h-[600px]">
        <div class="flex justify-between items-start mb-4">
          <div>
            <h2 id="modal-item-name" class="text-2xl font-bold text-[var(--primary-text)]">Golden Crown</h2>
            <div class="flex items-center mt-1">
              <div id="modal-item-rarity" class="px-2 py-0.5 badge-legendary text-xs font-medium rounded-full">
                Legendary
              </div>
              <span class="mx-2 text-[var(--neutral-dark)]">•</span>
              <div id="modal-item-type" class="text-[var(--neutral-dark)] text-sm">
                Creature Accessory
              </div>
            </div>
          </div>
          <button id="close-preview-btn" class="text-[var(--neutral-dark)] hover:text-[var(--primary-text)] transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
        
        <div class="border-t border-[var(--neutral-light)] pt-4 mb-4">
          <p id="modal-item-description" class="text-[var(--neutral-dark)] mb-4">
            This majestic golden crown is crafted from enchanted materials. When worn by your mythical creatures, it increases their happiness and adds a regal appearance that impresses other creatures.
          </p>
          
          <div class="mb-4">
            <h3 class="font-medium text-[var(--primary-text)] mb-2">Effects</h3>
            <ul id="modal-item-effects" class="space-y-2">
              <li class="flex items-start">
                <i class="fas fa-check-circle text-[var(--accent-secondary)] mt-0.5 mr-2"></i>
                <span>+15% Happiness bonus for the creature wearing it</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check-circle text-[var(--accent-secondary)] mt-0.5 mr-2"></i>
                <span>+5% Growth speed bonus</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check-circle text-[var(--accent-secondary)] mt-0.5 mr-2"></i>
                <span>Special animations and effects in AR view</span>
              </li>
            </ul>
          </div>
        </div>
        
        <div class="border-t border-[var(--neutral-light)] pt-4 mb-4">
          <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
              <span id="modal-item-price" class="text-3xl font-bold text-[var(--primary-text)] mr-2">750</span>
              <i class="fas fa-coins text-yellow-500 text-xl"></i>
            </div>
            
            <div class="flex items-center">
              <div class="text-sm text-[var(--neutral-dark)] mr-4">
                <span class="mr-1">Quantity:</span>
                <select class="border border-[var(--neutral-medium)] rounded p-1 focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)]">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="flex space-x-3">
            <button id="add-to-cart-btn" class="flex-1 bg-[var(--accent-primary)] hover:bg-[#5D4F91] text-white font-medium py-3 px-4 rounded-lg transition-colors duration-300">
              Add to Cart
            </button>
            <button id="add-to-wishlist-btn" class="flex items-center justify-center w-12 h-12 bg-[var(--neutral-light)] hover:bg-[var(--neutral-medium)] text-[var(--neutral-dark)] rounded-lg transition-colors duration-300">
              <i class="far fa-heart"></i>
            </button>
          </div>
        </div>
        
        <div class="border-t border-[var(--neutral-light)] pt-4">
          <h3 class="font-medium text-[var(--primary-text)] mb-3">Try it on your creatures</h3>
          <div class="grid grid-cols-4 gap-2">
            <div class="bg-[var(--primary-bg)] rounded p-2 text-center cursor-pointer hover:bg-[var(--neutral-light)] transition-colors duration-300">
              <img src="<?= $baseUrl ?>/images/creatures/1_mythical.png" alt="Dragon" class="w-full h-12 object-contain">
              <span class="text-xs text-[var(--neutral-dark)] block mt-1 truncate">Dragon</span>
            </div>
            <div class="bg-[var(--primary-bg)] rounded p-2 text-center cursor-pointer hover:bg-[var(--neutral-light)] transition-colors duration-300">
              <img src="<?= $baseUrl ?>/images/creatures/2_mythical.png" alt="Phoenix" class="w-full h-12 object-contain">
              <span class="text-xs text-[var(--neutral-dark)] block mt-1 truncate">Phoenix</span>
            </div>
            <div class="bg-[var(--primary-bg)] rounded p-2 text-center cursor-not-allowed opacity-50">
              <img src="<?= $baseUrl ?>/images/creatures/3_adult.png" alt="Kirin" class="w-full h-12 object-contain">
              <span class="text-xs text-[var(--neutral-dark)] block mt-1 truncate">Kirin (Adult)</span>
            </div>
            <div class="bg-[var(--primary-bg)] rounded p-2 text-center cursor-not-allowed opacity-50">
              <img src="<?= $baseUrl ?>/images/creatures/4_juvenile.png" alt="Serpent" class="w-full h-12 object-contain">
              <span class="text-xs text-[var(--neutral-dark)] block mt-1 truncate">Serpent (Youth)</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Alpine.js for tab functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Shop page JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Countdown timer for daily deals
  function updateCountdown() {
    const now = new Date();
    // Set the end time to midnight
    const end = new Date();
    end.setHours(23, 59, 59, 999);
    
    // Calculate remaining time
    const diff = end - now;
    
    // Calculate hours, minutes, seconds
    const hours = Math.floor(diff / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
    
    // Format the time
    const formattedTime = 
      String(hours).padStart(2, '0') + ':' +
      String(minutes).padStart(2, '0') + ':' +
      String(seconds).padStart(2, '0');
    
    // Update the countdown element
    document.getElementById('countdown-timer').textContent = formattedTime;
  }
  
  // Update the countdown immediately and then every second
  updateCountdown();
  setInterval(updateCountdown, 1000);
  
  // Intersection Observer for fade-in elements
  const fadeElements = document.querySelectorAll('.fade-in');
  
  if ('IntersectionObserver' in window) {
    const fadeObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          fadeObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });
    
    fadeElements.forEach(element => {
      fadeObserver.observe(element);
    });
  } else {
    // Fallback for browsers without Intersection Observer support
    fadeElements.forEach(element => {
      element.classList.add('visible');
    });
  }
  
  // Item preview modal
  const previewModal = document.getElementById('item-preview-modal');
  const closePreviewBtn = document.getElementById('close-preview-btn');
  const addToCartBtn = document.getElementById('add-to-cart-btn');
  const addToWishlistBtn = document.getElementById('add-to-wishlist-btn');
  
  // Sample function to open the preview modal
  window.openItemPreview = function(itemId, name, description, price, rarity, type, image) {
    // Update modal content
    document.getElementById('modal-item-name').textContent = name;
    document.getElementById('modal-item-description').textContent = description;
    document.getElementById('modal-item-price').textContent = price;
    document.getElementById('modal-item-rarity').textContent = rarity;
    document.getElementById('modal-item-rarity').className = `px-2 py-0.5 badge-${rarity.toLowerCase()} text-xs font-medium rounded-full`;
    document.getElementById('modal-item-type').textContent = type;
    document.getElementById('item-preview-display').innerHTML = `<img src="${image}" alt="${name}" class="max-w-full max-h-[400px] object-contain mx-auto">`;
    
    // Show modal
    previewModal.classList.remove('hidden');
    
    // Prevent scrolling of the body when modal is open
    document.body.style.overflow = 'hidden';
  }
  
  // Close modal when clicking the close button
  closePreviewBtn.addEventListener('click', function() {
    previewModal.classList.add('hidden');
    document.body.style.overflow = '';
  });
  
  // Close modal when clicking outside the content
  previewModal.addEventListener('click', function(e) {
    if (e.target === previewModal) {
      previewModal.classList.add('hidden');
      document.body.style.overflow = '';
    }
  });
  
  // Add click event listeners to shop items
  document.querySelectorAll('.shop-item').forEach(item => {
    item.addEventListener('click', function() {
      // Extract item details
      const name = this.querySelector('h3').textContent;
      const description = this.querySelector('p').textContent;
      const price = this.querySelector('.font-bold').textContent;
      const rarityBadge = this.querySelector('[class*="badge-"]');
      const rarity = rarityBadge ? rarityBadge.textContent.trim() : 'Common';
      const type = 'Shop Item'; // This would be extracted from data attributes in a real implementation
      const image = this.querySelector('img').src;
      
      // Open the preview modal
      window.openItemPreview(1, name, description, price, rarity, type, image);
    });
  });
  
  // Event listeners for card buttons
  addToCartBtn.addEventListener('click', function() {
    alert('Item added to cart!');
    previewModal.classList.add('hidden');
    document.body.style.overflow = '';
  });
  
  addToWishlistBtn.addEventListener('click', function() {
    // Toggle heart icon
    const heartIcon = this.querySelector('i');
    if (heartIcon.classList.contains('far')) {
      heartIcon.classList.remove('far');
      heartIcon.classList.add('fas');
      this.classList.add('text-[var(--accent-tertiary)]');
      alert('Item added to wishlist!');
    } else {
      heartIcon.classList.remove('fas');
      heartIcon.classList.add('far');
      this.classList.remove('text-[var(--accent-tertiary)]');
      alert('Item removed from wishlist!');
    }
  });
});

// Function to get color for rarity, used by PHP
function getRarityClass(rarity) {
  switch (rarity.toLowerCase()) {
    case 'common':
      return 'badge-common';
    case 'uncommon':
      return 'badge-uncommon';
    case 'rare':
      return 'badge-rare';
    case 'legendary':
      return 'badge-legendary';
    case 'mythical':
      return 'badge-mythical';
    default:
      return 'badge-common';
  }
}
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>