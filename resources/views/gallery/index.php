<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Include Alpine.js and GSAP for animations -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>

<div class="wildlife-gallery" x-data="galleryApp" x-init="initializeGallery()" @keydown.escape.window="closeDetailsPanel()">
  
  <!-- Ambient Audio Player -->
  <audio id="ambient-sound" loop>
    <source src="<?= $baseUrl ?>/resources/audio/ambient_nature.mp3" type="audio/mpeg">
  </audio>
  <audio id="creature-sound">
    <source src="" type="audio/mpeg">
  </audio>
  
  <!-- Immersive Hero Section -->
  <section class="gallery-hero" :class="currentHabitatTheme">
    <div class="habitat-background" x-html="getHabitatBackground(currentHabitatTheme)"></div>
    
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="title" x-intersect:enter="animateHeroTitle">Wildlife Haven</h1>
        <p class="subtitle" x-intersect:enter="animateHeroSubtitle">Discover the extraordinary creatures that share our world</p>
      </div>
      
      <div class="experience-controls">
        <button @click="toggleAmbientSound" class="sound-toggle" :class="{'is-playing': isPlaying}">
          <span class="sr-only" x-text="isPlaying ? 'Mute ambient sounds' : 'Play ambient sounds'"></span>
          <svg class="icon-sound-on" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5L6 9H2v6h4l5 4V5z"></path><path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path></svg>
          <svg class="icon-sound-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5L6 9H2v6h4l5 4V5z"></path><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>
        </button>
        
        <div class="habitat-switcher">
          <span>Explore: </span>
          <div class="habitat-buttons">
            <button @click="switchHabitatTheme('forest')" :class="{'active': currentHabitatTheme === 'forest'}" class="habitat-forest">Forest</button>
            <button @click="switchHabitatTheme('ocean')" :class="{'active': currentHabitatTheme === 'ocean'}" class="habitat-ocean">Ocean</button>
            <button @click="switchHabitatTheme('mountain')" :class="{'active': currentHabitatTheme === 'mountain'}" class="habitat-mountain">Mountain</button>
            <button @click="switchHabitatTheme('sky')" :class="{'active': currentHabitatTheme === 'sky'}" class="habitat-sky">Sky</button>
            <button @click="switchHabitatTheme('cosmic')" :class="{'active': currentHabitatTheme === 'cosmic'}" class="habitat-cosmic">Cosmic</button>
            <button @click="switchHabitatTheme('enchanted')" :class="{'active': currentHabitatTheme === 'enchanted'}" class="habitat-enchanted">Enchanted</button>
          </div>
        </div>
      </div>
      
      <div class="hero-scroll-indicator" x-intersect:leave="hideScrollIndicator">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"></path><path d="M19 12l-7 7-7-7"></path></svg>
        <span>Scroll to explore</span>
      </div>
    </div>
  </section>
  
  <!-- Interactive Gallery Controls -->
  <section class="gallery-controls" :class="{'sticky-controls': isControlsSticky}" x-ref="galleryControls" @scroll.window="checkControlsSticky()">
    <div class="search-and-filters">
      <div class="search-container">
        <input 
          type="text" 
          placeholder="Search creatures..." 
          x-model="searchQuery"
          @input="debouncedSearch()"
          class="search-input"
        >
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <button @click="searchQuery = ''" class="clear-search" x-show="searchQuery">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
      
      <div class="filter-controls">
        <div class="filter-group">
          <label class="filter-label">Habitat</label>
          <div class="filter-options">
            <button @click="habitatFilter = 'all'" :class="{'active': habitatFilter === 'all'}" class="filter-btn">All</button>
            <button @click="habitatFilter = 'forest'" :class="{'active': habitatFilter === 'forest'}" class="filter-btn habitat-forest">Forest</button>
            <button @click="habitatFilter = 'ocean'" :class="{'active': habitatFilter === 'ocean'}" class="filter-btn habitat-ocean">Ocean</button>
            <button @click="habitatFilter = 'mountain'" :class="{'active': habitatFilter === 'mountain'}" class="filter-btn habitat-mountain">Mountain</button>
            <button @click="habitatFilter = 'sky'" :class="{'active': habitatFilter === 'sky'}" class="filter-btn habitat-sky">Sky</button>
            <button @click="habitatFilter = 'cosmic'" :class="{'active': habitatFilter === 'cosmic'}" class="filter-btn habitat-cosmic">Cosmic</button>
            <button @click="habitatFilter = 'enchanted'" :class="{'active': habitatFilter === 'enchanted'}" class="filter-btn habitat-enchanted">Enchanted</button>
          </div>
        </div>
        
        <div class="filter-group">
          <label class="filter-label">Rarity</label>
          <div class="filter-options">
            <button @click="rarityFilter = 'all'" :class="{'active': rarityFilter === 'all'}" class="filter-btn">All</button>
            <button @click="rarityFilter = 'common'" :class="{'active': rarityFilter === 'common'}" class="filter-btn rarity-common">Common</button>
            <button @click="rarityFilter = 'uncommon'" :class="{'active': rarityFilter === 'uncommon'}" class="filter-btn rarity-uncommon">Uncommon</button>
            <button @click="rarityFilter = 'rare'" :class="{'active': rarityFilter === 'rare'}" class="filter-btn rarity-rare">Rare</button>
            <button @click="rarityFilter = 'legendary'" :class="{'active': rarityFilter === 'legendary'}" class="filter-btn rarity-legendary">Legendary</button>
          </div>
        </div>
        
        <div class="filter-group">
          <label class="filter-label">Conservation Status</label>
          <div class="filter-options">
            <button @click="conservationFilter = 'all'" :class="{'active': conservationFilter === 'all'}" class="filter-btn">All</button>
            <button @click="conservationFilter = 'LC'" :class="{'active': conservationFilter === 'LC'}" class="filter-btn status-lc">Least Concern</button>
            <button @click="conservationFilter = 'NT'" :class="{'active': conservationFilter === 'NT'}" class="filter-btn status-nt">Near Threatened</button>
            <button @click="conservationFilter = 'VU'" :class="{'active': conservationFilter === 'VU'}" class="filter-btn status-vu">Vulnerable</button>
            <button @click="conservationFilter = 'EN'" :class="{'active': conservationFilter === 'EN'}" class="filter-btn status-en">Endangered</button>
            <button @click="conservationFilter = 'CR'" :class="{'active': conservationFilter === 'CR'}" class="filter-btn status-cr">Critically Endangered</button>
          </div>
        </div>
        
        <button @click="resetFilters" class="reset-filters">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
          Reset Filters
        </button>
      </div>
    </div>
    
    <div class="view-options">
      <button @click="galleryView = 'grid'" :class="{'active': galleryView === 'grid'}" class="view-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        Grid
      </button>
      <button @click="galleryView = 'masonry'" :class="{'active': galleryView === 'masonry'}" class="view-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
        Masonry
      </button>
      <button @click="galleryView = 'carousel'" :class="{'active': galleryView === 'carousel'}" class="view-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="10" rx="2" ry="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M12 8v8"></path></svg>
        Carousel
      </button>
    </div>
  </section>
  
  <!-- Results Summary -->
  <section class="results-summary" x-show="filteredCreatures.length > 0">
    <p class="results-count">
      <span x-text="filteredCreatures.length"></span> creatures found
      <template x-if="hasActiveFilters">
        <span class="filter-summary">
          <template x-if="habitatFilter !== 'all'">
            <span class="active-filter habitat" x-text="habitatFilter"></span>
          </template>
          <template x-if="rarityFilter !== 'all'">
            <span class="active-filter rarity" x-text="rarityFilter"></span>
          </template>
          <template x-if="conservationFilter !== 'all'">
            <span class="active-filter conservation" x-text="getConservationLabel(conservationFilter)"></span>
          </template>
        </span>
      </template>
    </p>
  </section>
  
  <!-- No Results Message -->
  <section class="no-results" x-show="filteredCreatures.length === 0">
    <div class="no-results-content">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      <h2>No creatures found</h2>
      <p>Try adjusting your search or filters to find what you're looking for.</p>
      <button @click="resetFilters" class="reset-button">Reset All Filters</button>
    </div>
  </section>
  
  <!-- Main Gallery Content -->
  <section class="gallery-content" x-show="filteredCreatures.length > 0">
    <!-- Grid View Fix -->
<div class="grid-gallery" x-show="galleryView === 'grid'" x-transition:enter="transition-opacity" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
  <template x-for="(creature, index) in filteredCreatures" :key="creature.id">
    <div class="creature-card" 
         :class="getHabitatClass(creature.habitat_type)"
         x-init="setTimeout(() => $el.classList.add('visible'), index * 50)"
         @click="openDetailsPanel(creature)">
      <div class="card-image-container">
        <img :src="getCreatureImage(creature)" :alt="creature.name" class="card-image">
        <div class="card-badges">
          <span class="rarity-badge" :class="getRarityClass(creature.rarity)" x-text="capitalizeFirstLetter(creature.rarity)"></span>
          <span class="conservation-badge" :class="getConservationClass(creature.iucn_status)" x-text="creature.iucn_status"></span>
        </div>
      </div>
      <div class="card-info">
        <h3 class="creature-name" x-text="creature.name"></h3>
        <p class="species-name" x-text="creature.species_name"></p>
        <div class="habitat-tag" :class="getHabitatClass(creature.habitat_type)">
          <span x-text="capitalizeFirstLetter(creature.habitat_type)"></span>
        </div>
      </div>
    </div>
  </template>
</div>

<!-- Revamped Ethical Masonry View -->
<div class="ethical-masonry" x-show="galleryView === 'masonry'" x-transition:enter="transition-opacity" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
  <template x-for="(creature, index) in filteredCreatures" :key="creature.id">
    <div class="masonry-card" 
         :class="[getHabitatClass(creature.habitat_type), getCreatureSizeClass(creature), getCreatureAspectRatio(creature)]"
         @click="openDetailsPanel(creature)">
      <div class="masonry-image-wrapper">
        <img :src="getCreatureImage(creature)" :alt="creature.name" class="masonry-image">
        
        <div class="masonry-metadata">
          <div class="masonry-badges">
            <span class="rarity-badge" :class="getRarityClass(creature.rarity)" x-text="capitalizeFirstLetter(creature.rarity)"></span>
            <span class="conservation-badge" :class="getConservationClass(creature.iucn_status)" x-text="creature.iucn_status"></span>
          </div>
          
          <!-- Behavioral Metadata Icons -->
          <div class="behavior-indicators">
            <template x-if="hasBehavioralTrait(creature, 'nocturnal')">
              <span class="behavior-icon nocturnal" title="Nocturnal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3a9 9 0 1 0 9 9c0-.46-.04-.92-.1-1.36a5.5 5.5 0 0 1-4.96-8.65A9 9 0 0 0 12 3z"/></svg>
              </span>
            </template>
            
            <template x-if="hasBehavioralTrait(creature, 'social')">
              <span class="behavior-icon social" title="Social">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
              </span>
            </template>
            
            <template x-if="isEndangered(creature)">
              <span class="behavior-icon endangered" title="Endangered">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
              </span>
            </template>
          </div>
        </div>
      </div>
      
      <div class="masonry-info">
        <h3 class="creature-name" x-text="creature.name"></h3>
        <p class="species-name" x-text="creature.species_name"></p>
        <p class="masonry-description" x-text="truncateText(creature.description, 120)"></p>
      </div>
    </div>
  </template>
</div>
    
    <!-- Carousel View -->
    <div class="carousel-gallery" x-show="galleryView === 'carousel'" x-transition:enter="transition-opacity" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
      <button class="carousel-nav prev" @click="carouselPrev" :disabled="carouselIndex === 0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
      </button>
      
      <div class="carousel-container" x-ref="carouselContainer">
        <div class="carousel-track" :style="`transform: translateX(-${carouselIndex * 100}%)`">
          <template x-for="creature in filteredCreatures" :key="creature.id">
            <div class="carousel-slide" @click="openDetailsPanel(creature)">
              <div class="carousel-card" :class="getHabitatClass(creature.habitat_type)">
                <div class="carousel-image-container">
                  <img :src="getCreatureImage(creature)" :alt="creature.name" class="carousel-image">
                  <div class="carousel-badges">
                    <span class="rarity-badge" :class="getRarityClass(creature.rarity)" x-text="capitalizeFirstLetter(creature.rarity)"></span>
                    <span class="conservation-badge" :class="getConservationClass(creature.iucn_status)" x-text="creature.iucn_status"></span>
                  </div>
                </div>
                <div class="carousel-info">
                  <h3 class="creature-name" x-text="creature.name"></h3>
                  <p class="species-name" x-text="creature.species_name"></p>
                  <p class="creature-description" x-text="truncateText(creature.description, 120)"></p>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
      
      <button class="carousel-nav next" @click="carouselNext" :disabled="carouselIndex >= Math.max(0, filteredCreatures.length - carouselItemsPerPage)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </button>
      
      <div class="carousel-pagination">
        <template x-for="(_, index) in getCarouselPages()" :key="index">
          <button 
            class="pagination-dot" 
            :class="{'active': Math.floor(carouselIndex / carouselItemsPerPage) === index}"
            @click="carouselGoToPage(index)"></button>
        </template>
      </div>
    </div>
  </section>
  
  <!-- Creature Details Panel -->
  <section 
    class="creature-details-panel" 
    :class="{'active': selectedCreature !== null, 'habitat-forest': selectedCreature?.habitat_type === 'forest', 'habitat-ocean': selectedCreature?.habitat_type === 'ocean', 'habitat-mountain': selectedCreature?.habitat_type === 'mountain', 'habitat-sky': selectedCreature?.habitat_type === 'sky', 'habitat-cosmic': selectedCreature?.habitat_type === 'cosmic', 'habitat-enchanted': selectedCreature?.habitat_type === 'enchanted'}"
    x-transition:enter="panel-enter"
    x-transition:enter-start="panel-enter-start"
    x-transition:enter-end="panel-enter-end"
    x-transition:leave="panel-leave"
    x-transition:leave-start="panel-leave-start"
    x-transition:leave-end="panel-leave-end"
  >
    <template x-if="selectedCreature">
      <div class="panel-content">
        <!-- Panel Navigation -->
        <div class="panel-nav">
          <button @click="previousCreature" :disabled="!hasPreviousCreature" class="panel-nav-btn prev">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            <span>Previous</span>
          </button>
          <button @click="closeDetailsPanel" class="panel-close-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            <span>Close</span>
          </button>
          <button @click="nextCreature" :disabled="!hasNextCreature" class="panel-nav-btn next">
            <span>Next</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </button>
        </div>
        
        <!-- Panel Content -->
        <div class="panel-columns">
          <!-- Column 1: Media -->
          <div class="panel-media">
            <div class="media-container">
              <img :src="getCreatureImage(selectedCreature)" :alt="selectedCreature.name" class="creature-image">
              
              <div class="creature-stages" x-show="hasMultipleStages(selectedCreature)">
                <button class="stage-btn" :class="{'active': selectedStage === 'egg'}" @click="selectedStage = 'egg'">Egg</button>
                <button class="stage-btn" :class="{'active': selectedStage === 'baby'}" @click="selectedStage = 'baby'">Baby</button>
                <button class="stage-btn" :class="{'active': selectedStage === 'juvenile'}" @click="selectedStage = 'juvenile'">Juvenile</button>
                <button class="stage-btn" :class="{'active': selectedStage === 'adult'}" @click="selectedStage = 'adult'">Adult</button>
                <button class="stage-btn" :class="{'active': selectedStage === 'mythical'}" @click="selectedStage = 'mythical'">Mythical</button>
              </div>
              
              <button 
                @click="toggleCreatureSound" 
                class="creature-sound-btn"
                :class="{'playing': isCreatureSoundPlaying}"
              >
                <svg class="icon-play" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                <svg class="icon-pause" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="4" width="4" height="16"></rect><rect x="14" y="4" width="4" height="16"></rect></svg>
                <span x-text="isCreatureSoundPlaying ? 'Pause Sound' : 'Play Sound'"></span>
              </button>
            </div>
          </div>
          
          <!-- Column 2: Information -->
          <div class="panel-info">
            <div class="info-header">
              <h2 class="creature-title" x-text="selectedCreature.name"></h2>
              <div class="creature-badges">
                <span class="status-badge" :class="getConservationClass(selectedCreature.iucn_status)">
                  <span x-text="getConservationLabel(selectedCreature.iucn_status)"></span>
                </span>
                <span class="rarity-badge" :class="getRarityClass(selectedCreature.rarity)">
                  <span x-text="capitalizeFirstLetter(selectedCreature.rarity)"></span>
                </span>
              </div>
              <h3 class="scientific-name" x-text="selectedCreature.species_name"></h3>
            </div>
            
            <div class="info-section">
              <p class="creature-description" x-text="selectedCreature.description"></p>
            </div>
            
            <div class="info-section stats-grid">
              <div class="stat-card">
                <h4>Health</h4>
                <div class="progress-bar">
                  <div class="progress-fill health" :style="`width: ${selectedCreature.health}%`"></div>
                </div>
                <span class="stat-value" x-text="`${selectedCreature.health}%`"></span>
              </div>
              
              <div class="stat-card">
                <h4>Happiness</h4>
                <div class="progress-bar">
                  <div class="progress-fill happiness" :style="`width: ${selectedCreature.happiness}%`"></div>
                </div>
                <span class="stat-value" x-text="`${selectedCreature.happiness}%`"></span>
              </div>
              
              <div class="stat-card" x-show="selectedCreature.stage !== 'mythical'">
                <h4>Growth Progress</h4>
                <div class="progress-bar">
                  <div class="progress-fill growth" :style="`width: ${selectedCreature.growth_progress}%`"></div>
                </div>
                <span class="stat-value" x-text="`${selectedCreature.growth_progress}%`"></span>
              </div>
              
              <div class="stat-card habitat">
                <h4>Habitat</h4>
                <div class="habitat-indicator" :class="getHabitatClass(selectedCreature.habitat_type)">
                  <span x-text="capitalizeFirstLetter(selectedCreature.habitat_type)"></span>
                </div>
              </div>
            </div>
            
            <div class="info-section">
              <h3 class="section-title">Conservation Information</h3>
              <div class="conservation-card">
                <div class="conservation-icon" :class="getConservationClass(selectedCreature.iucn_status)">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <div class="conservation-content">
                  <p class="conservation-fact" x-text="selectedCreature.conservation_fact"></p>
                  <p class="real-world-inspiration" x-text="selectedCreature.real_world_inspiration"></p>
                </div>
              </div>
            </div>
            
            <div class="info-section">
              <h3 class="section-title">Exhibition Note</h3>
              <blockquote class="exhibition-note" x-text="selectedCreature.exhibition_note"></blockquote>
            </div>
          </div>
        </div>
      </div>
    </template>
  </section>
  
  <!-- Conservation Education Section -->
  <section class="conservation-section">
    <div class="conservation-header">
      <h2>Understanding Conservation Status</h2>
      <p>Learn about the IUCN Red List categories and what they mean for wildlife conservation efforts worldwide.</p>
    </div>
    
    <div class="conservation-cards">
      <div class="status-explanation status-lc">
        <h3>LC - Least Concern</h3>
        <p>Species evaluated as having a low risk of extinction. These are widespread and abundant species.</p>
      </div>
      
      <div class="status-explanation status-nt">
        <h3>NT - Near Threatened</h3>
        <p>Species that may be considered threatened in the near future, but don't currently qualify for threatened categories.</p>
      </div>
      
      <div class="status-explanation status-vu">
        <h3>VU - Vulnerable</h3>
        <p>Species considered to be facing a high risk of extinction in the wild. First level of the threatened categories.</p>
      </div>
      
      <div class="status-explanation status-en">
        <h3>EN - Endangered</h3>
        <p>Species that have a very high risk of extinction in the wild, often with declining populations and habitats.</p>
      </div>
      
      <div class="status-explanation status-cr">
        <h3>CR - Critically Endangered</h3>
        <p>Species facing an extremely high risk of extinction in the wild, often with severely fragmented populations.</p>
      </div>
      
      <div class="status-explanation status-ew">
        <h3>EW - Extinct in the Wild</h3>
        <p>Species known to survive only in captivity, cultivation, or outside their natural range.</p>
      </div>
      
      <div class="status-explanation status-ex">
        <h3>EX - Extinct</h3>
        <p>Species with no known living individuals. Complete disappearance with no reasonable doubt.</p>
      </div>
    </div>
  </section>
</div>

<style>
/* Base Styles & Reset */
:root {
  --color-forest: #22c55e;
  --color-ocean: #3b82f6;
  --color-mountain: #ef4444;
  --color-sky: #0ea5e9;
  --color-cosmic: #a855f7;
  --color-enchanted: #ec4899;
  
  --color-status-lc: #4ade80;
  --color-status-nt: #a3e635;
  --color-status-vu: #fbbf24;
  --color-status-en: #f97316;
  --color-status-cr: #ef4444;
  --color-status-ew: #a1a1aa;
  --color-status-ex: #1f2937;
  
  --color-rarity-common: #a1a1aa;
  --color-rarity-uncommon: #22c55e;
  --color-rarity-rare: #3b82f6;
  --color-rarity-legendary: #a855f7;
  --color-rarity-mythical: #f59e0b;
  
  --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
  --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
  --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
  --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.15);
  
  --radius-sm: 0.25rem;
  --radius-md: 0.5rem;
  --radius-lg: 0.75rem;
  --radius-xl: 1rem;
  
  --transition-fast: 0.2s ease;
  --transition-normal: 0.3s ease;
  --transition-slow: 0.5s ease;
  
  --font-sans: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  --font-serif: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
}

.wildlife-gallery {
  font-family: var(--font-sans);
  color: #1f2937;
  overflow-x: hidden;
}

/* Hero Section Styles */
.gallery-hero {
  position: relative;
  height: 90vh;
  min-height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  transition: background-color var(--transition-slow);
}

.habitat-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  opacity: 0.3;
  pointer-events: none;
}

.gallery-hero.forest {
  background-color: rgba(34, 197, 94, 0.1);
}

.gallery-hero.ocean {
  background-color: rgba(59, 130, 246, 0.1);
}

.gallery-hero.mountain {
  background-color: rgba(239, 68, 68, 0.1);
}

.gallery-hero.sky {
  background-color: rgba(14, 165, 233, 0.1);
}

.gallery-hero.cosmic {
  background-color: rgba(168, 85, 247, 0.1);
}

.gallery-hero.enchanted {
  background-color: rgba(236, 72, 153, 0.1);
}

.hero-content {
  position: relative;
  z-index: 2;
  text-align: center;
  max-width: 900px;
  padding: 2rem;
}

.hero-text {
  margin-bottom: 3rem;
}

.hero-text .title {
  font-family: var(--font-serif);
  font-size: 4rem;
  font-weight: 300;
  margin-bottom: 1rem;
  line-height: 1.2;
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 1s ease, transform 1s ease;
}

.hero-text .subtitle {
  font-size: 1.5rem;
  color: #4b5563;
  max-width: 700px;
  margin: 0 auto;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 1s ease 0.3s, transform 1s ease 0.3s;
}

.hero-text .title.animate,
.hero-text .subtitle.animate {
  opacity: 1;
  transform: translateY(0);
}

.experience-controls {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 2rem;
  margin-bottom: 4rem;
}

.sound-toggle {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background-color: white;
  border: 2px solid #e5e7eb;
  cursor: pointer;
  transition: all var(--transition-normal);
  box-shadow: var(--shadow-md);
}

.sound-toggle:hover {
  transform: scale(1.05);
  box-shadow: var(--shadow-lg);
}

.sound-toggle svg {
  width: 24px;
  height: 24px;
  stroke-width: 1.5;
}

.sound-toggle .icon-sound-off {
  display: none;
}

.sound-toggle.is-playing .icon-sound-on {
  display: none;
}

.sound-toggle.is-playing .icon-sound-off {
  display: block;
}

.habitat-switcher {
  display: flex;
  align-items: center;
  gap: 1rem;
  font-size: 0.875rem;
  color: #6b7280;
}

.habitat-buttons {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
  justify-content: center;
}

.habitat-buttons button {
  padding: 0.5rem 1rem;
  border-radius: var(--radius-md);
  border: 1px solid #e5e7eb;
  background-color: white;
  cursor: pointer;
  font-size: 0.875rem;
  transition: all var(--transition-fast);
  position: relative;
  overflow: hidden;
}

.habitat-buttons button::before {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background-color: currentColor;
  transform: scaleX(0);
  transition: transform var(--transition-fast);
}

.habitat-buttons button:hover::before,
.habitat-buttons button.active::before {
  transform: scaleX(1);
}

.habitat-buttons button.active {
  font-weight: 500;
}

.habitat-buttons .habitat-forest {
  color: var(--color-forest);
}

.habitat-buttons .habitat-ocean {
  color: var(--color-ocean);
}

.habitat-buttons .habitat-mountain {
  color: var(--color-mountain);
}

.habitat-buttons .habitat-sky {
  color: var(--color-sky);
}

.habitat-buttons .habitat-cosmic {
  color: var(--color-cosmic);
}

.habitat-buttons .habitat-enchanted {
  color: var(--color-enchanted);
}

.hero-scroll-indicator {
  position: absolute;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  color: #6b7280;
  font-size: 0.875rem;
  opacity: 0.7;
  animation: bounce 2s infinite;
  cursor: pointer;
}

.hero-scroll-indicator svg {
  width: 24px;
  height: 24px;
}

@keyframes bounce {
  0%, 20%, 50%, 80%, 100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-10px);
  }
  60% {
    transform: translateY(-5px);
  }
}

.hero-scroll-indicator.hidden {
  opacity: 0;
  pointer-events: none;
}

/* Gallery Controls Styles */
.gallery-controls {
  background-color: white;
  padding: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  transition: box-shadow var(--transition-normal);
  z-index: 10;
}

.gallery-controls.sticky-controls {
  position: sticky;
  top: 0;
  box-shadow: var(--shadow-md);
}

.search-and-filters {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.search-container {
  position: relative;
  max-width: 100%;
}

.search-input {
  width: 100%;
  padding: 0.75rem 1rem 0.75rem 3rem;
  border-radius: var(--radius-lg);
  border: 1px solid #e5e7eb;
  background-color: #f9fafb;
  font-size: 1rem;
  transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.search-input:focus {
  outline: none;
  border-color: #93c5fd;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.search-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 20px;
  height: 20px;
  color: #9ca3af;
}

.clear-search {
  position: absolute;
  right: 1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 20px;
  height: 20px;
  color: #9ca3af;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
}

.filter-controls {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  align-items: flex-start;
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  flex: 1;
  min-width: 200px;
}

.filter-label {
  font-size: 0.875rem;
  font-weight: 500;
  color: #4b5563;
}

.filter-options {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.filter-btn {
  padding: 0.375rem 0.75rem;
  border-radius: var(--radius-md);
  border: 1px solid #e5e7eb;
  background-color: #f9fafb;
  font-size: 0.875rem;
  color: #4b5563;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.filter-btn:hover {
  background-color: #f3f4f6;
}

.filter-btn.active {
  background-color: #1f2937;
  color: white;
  border-color: #1f2937;
}

.filter-btn.habitat-forest.active {
  background-color: var(--color-forest);
  border-color: var(--color-forest);
}

.filter-btn.habitat-ocean.active {
  background-color: var(--color-ocean);
  border-color: var(--color-ocean);
}

.filter-btn.habitat-mountain.active {
  background-color: var(--color-mountain);
  border-color: var(--color-mountain);
}

.filter-btn.habitat-sky.active {
  background-color: var(--color-sky);
  border-color: var(--color-sky);
}

.filter-btn.habitat-cosmic.active {
  background-color: var(--color-cosmic);
  border-color: var(--color-cosmic);
}

.filter-btn.habitat-enchanted.active {
  background-color: var(--color-enchanted);
  border-color: var(--color-enchanted);
}

.filter-btn.status-lc.active {
  background-color: var(--color-status-lc);
  border-color: var(--color-status-lc);
}

.filter-btn.status-nt.active {
  background-color: var(--color-status-nt);
  border-color: var(--color-status-nt);
}

.filter-btn.status-vu.active {
  background-color: var(--color-status-vu);
  border-color: var(--color-status-vu);
}

.filter-btn.status-en.active {
  background-color: var(--color-status-en);
  border-color: var(--color-status-en);
}

.filter-btn.status-cr.active {
  background-color: var(--color-status-cr);
  border-color: var(--color-status-cr);
}

.reset-filters {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.375rem 0.75rem;
  border-radius: var(--radius-md);
  border: 1px solid #e5e7eb;
  background-color: #f9fafb;
  font-size: 0.875rem;
  color: #4b5563;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.reset-filters:hover {
  background-color: #f3f4f6;
}

.reset-filters svg {
  width: 16px;
  height: 16px;
}

.view-options {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 1.5rem;
  border-top: 1px solid #e5e7eb;
  padding-top: 1.5rem;
}

.view-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border-radius: var(--radius-md);
  border: 1px solid #e5e7eb;
  background-color: #f9fafb;
  font-size: 0.875rem;
  color: #4b5563;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.view-btn:hover {
  background-color: #f3f4f6;
}

.view-btn.active {
  background-color: #1f2937;
  color: white;
  border-color: #1f2937;
}

.view-btn svg {
  width: 18px;
  height: 18px;
}

/* Results Summary Styles */
.results-summary {
  padding: 1rem 1.5rem;
  background-color: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
}

.results-count {
  font-size: 0.875rem;
  color: #6b7280;
}

.filter-summary {
  margin-left: 0.5rem;
  display: inline-flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.active-filter {
  padding: 0.125rem 0.375rem;
  border-radius: var(--radius-sm);
  font-size: 0.75rem;
  background-color: #f3f4f6;
}

/* No Results Styles */
.no-results {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 300px;
  padding: 3rem 1.5rem;
}

.no-results-content {
  text-align: center;
  max-width: 500px;
}

.no-results-content svg {
  width: 60px;
  height: 60px;
  margin: 0 auto 1.5rem;
  color: #9ca3af;
}

.no-results-content h2 {
  font-size: 1.5rem;
  font-weight: 500;
  margin-bottom: 1rem;
}

.no-results-content p {
  color: #6b7280;
  margin-bottom: 1.5rem;
}

.reset-button {
  padding: 0.75rem 1.5rem;
  border-radius: var(--radius-md);
  background-color: #1f2937;
  color: white;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: background-color var(--transition-fast);
}

.reset-button:hover {
  background-color: #111827;
}

/* Grid Gallery Styles */
.gallery-content {
  padding: 2rem 1.5rem;
}

/* Grid Gallery Fixes */
.grid-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 1.5rem;
}

.creature-card {
  border-radius: var(--radius-lg);
  overflow: hidden;
  background-color: white;
  box-shadow: var(--shadow-md);
  cursor: pointer;
  border: 1px solid #e5e7eb;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.4s ease, transform 0.4s ease, box-shadow var(--transition-normal);
}

.creature-card.visible {
  opacity: 1;
  transform: translateY(0);
}

.creature-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}


.card-image-container {
  position: relative;
  height: 260px;
  overflow: hidden;
  background-color: #f3f4f6;
}

.card-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform var(--transition-normal);
}

.creature-card:hover .card-image {
  transform: scale(1.05);
}

.card-badges {
  position: absolute;
  top: 0.75rem;
  right: 0.75rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.rarity-badge, .conservation-badge {
  padding: 0.25rem 0.5rem;
  border-radius: var(--radius-md);
  font-size: 0.75rem;
  font-weight: 500;
  background-color: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(4px);
}

.rarity-common {
  color: var(--color-rarity-common);
}

.rarity-uncommon {
  color: var(--color-rarity-uncommon);
}

.rarity-rare {
  color: var(--color-rarity-rare);
}

.rarity-legendary {
  color: var(--color-rarity-legendary);
}

.rarity-mythical {
  color: var(--color-rarity-mythical);
}

.status-lc {
  color: var(--color-status-lc);
}

.status-nt {
  color: var(--color-status-nt);
}

.status-vu {
  color: var(--color-status-vu);
}

.status-en {
  color: var(--color-status-en);
}

.status-cr {
  color: var(--color-status-cr);
}

.status-ew {
  color: var(--color-status-ew);
}

.status-ex {
  color: var(--color-status-ex);
}

.card-info {
  padding: 1rem;
}

.creature-name {
  font-size: 1.125rem;
  font-weight: 500;
  margin-bottom: 0.25rem;
}

.species-name {
  font-size: 0.875rem;
  color: #6b7280;
  font-style: italic;
  margin-bottom: 0.75rem;
}

.habitat-tag {
  display: inline-flex;
  padding: 0.25rem 0.5rem;
  border-radius: var(--radius-md);
  font-size: 0.75rem;
  background-color: #f3f4f6;
}

.habitat-tag.habitat-forest {
  background-color: rgba(34, 197, 94, 0.1);
  color: var(--color-forest);
}

.habitat-tag.habitat-ocean {
  background-color: rgba(59, 130, 246, 0.1);
  color: var(--color-ocean);
}

.habitat-tag.habitat-mountain {
  background-color: rgba(239, 68, 68, 0.1);
  color: var(--color-mountain);
}

.habitat-tag.habitat-sky {
  background-color: rgba(14, 165, 233, 0.1);
  color: var(--color-sky);
}

.habitat-tag.habitat-cosmic {
  background-color: rgba(168, 85, 247, 0.1);
  color: var(--color-cosmic);
}

.habitat-tag.habitat-enchanted {
  background-color: rgba(236, 72, 153, 0.1);
  color: var(--color-enchanted);
}

/* Masonry Gallery Styles */
.ethical-masonry {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  grid-auto-flow: dense;
  gap: 1.5rem;
  margin-bottom: 2rem;
  padding-bottom: 1rem;
}

.masonry-card {
  border-radius: var(--radius-lg);
  overflow: hidden;
  background-color: white;
  box-shadow: var(--shadow-md);
  transition: transform var(--transition-normal), box-shadow var(--transition-normal);
  cursor: pointer;
  border: 1px solid #e5e7eb;
  display: flex;
  flex-direction: column;
}

.masonry-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

/* Variable sizing classes to prevent commodification gaze */
.masonry-card.size-small {
  grid-row: span 1;
}

.masonry-card.size-medium {
  grid-row: span 2;
}

.masonry-card.size-large {
  grid-row: span 3;
  grid-column: span 1;
}

.masonry-card.size-featured {
  grid-row: span 3;
  grid-column: span 2;
}

/* Aspect ratio classes to maintain individual animal identity */
.masonry-card.ratio-square .masonry-image-wrapper {
  aspect-ratio: 1 / 1; /* For cat-like creatures */
}

.masonry-card.ratio-portrait .masonry-image-wrapper {
  aspect-ratio: 2 / 3; /* For general creatures */
}

.masonry-card.ratio-landscape .masonry-image-wrapper {
  aspect-ratio: 3 / 2; /* For dog-like creatures */
}

.masonry-card.ratio-wide .masonry-image-wrapper {
  aspect-ratio: 16 / 9; /* For landscape views or flying creatures */
}

.masonry-image-wrapper {
  position: relative;
  overflow: hidden;
  background-color: #f3f4f6;
}

.masonry-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform var(--transition-normal);
}

.masonry-card:hover .masonry-image {
  transform: scale(1.05);
}

.masonry-metadata {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 0.75rem;
}

.masonry-badges {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 0.5rem;
}

/* Behavioral metadata via icon overlays */
.behavior-indicators {
  display: flex;
  gap: 0.5rem;
  margin-top: auto;
  align-self: flex-start;
}

.behavior-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(4px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease;
}

.behavior-icon:hover {
  transform: scale(1.1);
}

.behavior-icon svg {
  width: 18px;
  height: 18px;
}

.behavior-icon.nocturnal {
  color: #6366f1;
}

.behavior-icon.social {
  color: #10b981;
}

.behavior-icon.endangered {
  color: #ef4444;
}

.masonry-info {
  padding: 1rem;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.masonry-description {
  margin-top: 0.5rem;
  font-size: 0.875rem;
  color: #6b7280;
  line-height: 1.5;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
  .ethical-masonry {
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  }
  
  .masonry-card.size-featured {
    grid-column: span 1;
  }
}

@media (max-width: 640px) {
  .ethical-masonry {
    grid-template-columns: 1fr;
  }
  
  .masonry-card {
    grid-column: span 1 !important;
  }
}

/* Carousel Gallery Styles */
.carousel-gallery {
  position: relative;
  padding: 2rem 0;
  overflow: hidden;
}

.carousel-container {
  width: 100%;
  overflow: hidden;
}

.carousel-track {
  display: flex;
  transition: transform var(--transition-normal);
}

.carousel-slide {
  min-width: 33.333%;
  padding: 0 0.75rem;
  flex: 0 0 33.333%;
}

.carousel-card {
  border-radius: var(--radius-lg);
  overflow: hidden;
  background-color: white;
  box-shadow: var(--shadow-md);
  transition: transform var(--transition-normal), box-shadow var(--transition-normal);
  cursor: pointer;
  border: 1px solid #e5e7eb;
  height: 450px;
  display: flex;
  flex-direction: column;
}

.carousel-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.carousel-image-container {
  position: relative;
  height: 280px;
  overflow: hidden;
  background-color: #f3f4f6;
}

.carousel-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform var(--transition-normal);
}

.carousel-card:hover .carousel-image {
  transform: scale(1.05);
}

.carousel-badges {
  position: absolute;
  top: 0.75rem;
  right: 0.75rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.carousel-info {
  padding: 1rem;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.carousel-info .creature-name {
  font-size: 1.25rem;
  margin-bottom: 0.25rem;
}

.carousel-info .species-name {
  margin-bottom: 0.75rem;
}

.creature-description {
  font-size: 0.875rem;
  color: #6b7280;
  line-height: 1.5;
  flex-grow: 1;
}

.carousel-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background-color: white;
  border: 1px solid #e5e7eb;
  cursor: pointer;
  z-index: 5;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: var(--shadow-md);
  transition: all var(--transition-fast);
}

.carousel-nav:hover:not(:disabled) {
  background-color: #f9fafb;
  transform: translateY(-50%) scale(1.05);
}

.carousel-nav:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.carousel-nav.prev {
  left: 1rem;
}

.carousel-nav.next {
  right: 1rem;
}

.carousel-nav svg {
  width: 24px;
  height: 24px;
}

.carousel-pagination {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 1.5rem;
}

.pagination-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: #d1d5db;
  border: none;
  padding: 0;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.pagination-dot:hover {
  background-color: #9ca3af;
}

.pagination-dot.active {
  background-color: #1f2937;
  transform: scale(1.2);
}

/* Creature Details Panel Styles */
.creature-details-panel {
  position: fixed;
  top: 0;
  right: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 100;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  pointer-events: none;
  backdrop-filter: blur(5px);
  transition: opacity var(--transition-normal);
  overflow-y: auto;
}

.creature-details-panel.active {
  opacity: 1;
  pointer-events: auto;
}

.panel-content {
  position: relative;
  width: 90%;
  max-width: 1200px;
  max-height: 90vh;
  overflow-y: auto;
  background-color: white;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-xl);
}

.panel-nav {
  display: flex;
  justify-content: space-between;
  padding: 1rem;
  border-bottom: 1px solid #e5e7eb;
  background-color: #f9fafb;
  position: sticky;
  top: 0;
  z-index: 5;
}

.panel-nav-btn, .panel-close-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border-radius: var(--radius-md);
  border: 1px solid #e5e7eb;
  background-color: white;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.panel-nav-btn:hover:not(:disabled), .panel-close-btn:hover {
  background-color: #f3f4f6;
}

.panel-nav-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.panel-nav-btn svg, .panel-close-btn svg {
  width: 18px;
  height: 18px;
}

.panel-columns {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2rem;
  padding: 2rem;
}

.panel-media {
  position: sticky;
  top: 5rem;
  align-self: start;
}

.media-container {
  border-radius: var(--radius-lg);
  overflow: hidden;
  background-color: #f9fafb;
  box-shadow: var(--shadow-md);
}

.creature-image {
  width: 100%;
  height: auto;
  display: block;
  object-fit: contain;
  background-color: #f9fafb;
  min-height: 400px;
  max-height: 600px;
}

.creature-stages {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  padding: 1rem;
  border-top: 1px solid #e5e7eb;
}

.stage-btn {
  padding: 0.375rem 0.75rem;
  border-radius: var(--radius-md);
  border: 1px solid #e5e7eb;
  background-color: #f9fafb;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.stage-btn:hover {
  background-color: #f3f4f6;
}

.stage-btn.active {
  background-color: #1f2937;
  color: white;
  border-color: #1f2937;
}

.creature-sound-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  width: 100%;
  padding: 0.75rem;
  border: none;
  border-top: 1px solid #e5e7eb;
  background-color: #f9fafb;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.creature-sound-btn:hover {
  background-color: #f3f4f6;
}

.creature-sound-btn svg {
  width: 18px;
  height: 18px;
}

.creature-sound-btn .icon-pause {
  display: none;
}

.creature-sound-btn.playing .icon-play {
  display: none;
}

.creature-sound-btn.playing .icon-pause {
  display: block;
}

.panel-info {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.info-header {
  margin-bottom: 1rem;
}

.creature-title {
  font-size: 2rem;
  font-weight: 500;
  margin-bottom: 0.5rem;
}

.creature-badges {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 0.5rem;
}

.status-badge, .info-badge {
  padding: 0.25rem 0.5rem;
  border-radius: var(--radius-md);
  font-size: 0.75rem;
  font-weight: 500;
}

.scientific-name {
  font-size: 1.125rem;
  font-style: italic;
  color: #6b7280;
}

.info-section {
  margin-bottom: 1.5rem;
}

.section-title {
  font-size: 1.25rem;
  font-weight: 500;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid #e5e7eb;
}

.creature-description {
  line-height: 1.6;
  color: #4b5563;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.stat-card {
  background-color: #f9fafb;
  border-radius: var(--radius-md);
  padding: 1rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.stat-card h4 {
  font-size: 0.875rem;
  font-weight: 500;
  color: #6b7280;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background-color: #e5e7eb;
  border-radius: 4px;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  border-radius: 4px;
  transition: width var(--transition-slow);
}

.progress-fill.health {
  background-color: #22c55e;
}

.progress-fill.happiness {
  background-color: #f59e0b;
}

.progress-fill.growth {
  background-color: #3b82f6;
}

.stat-value {
  font-size: 0.875rem;
  font-weight: 500;
  color: #1f2937;
  text-align: right;
}

.habitat-indicator {
  padding: 0.375rem 0.75rem;
  border-radius: var(--radius-md);
  font-size: 0.875rem;
  font-weight: 500;
  background-color: #f3f4f6;
  display: inline-flex;
}

.habitat-indicator.habitat-forest {
  background-color: rgba(34, 197, 94, 0.1);
  color: var(--color-forest);
}

.habitat-indicator.habitat-ocean {
  background-color: rgba(59, 130, 246, 0.1);
  color: var(--color-ocean);
}

.habitat-indicator.habitat-mountain {
  background-color: rgba(239, 68, 68, 0.1);
  color: var(--color-mountain);
}

.habitat-indicator.habitat-sky {
  background-color: rgba(14, 165, 233, 0.1);
  color: var(--color-sky);
}

.habitat-indicator.habitat-cosmic {
  background-color: rgba(168, 85, 247, 0.1);
  color: var(--color-cosmic);
}

.habitat-indicator.habitat-enchanted {
  background-color: rgba(236, 72, 153, 0.1);
  color: var(--color-enchanted);
}

.conservation-card {
  display: flex;
  gap: 1rem;
  background-color: #f9fafb;
  border-radius: var(--radius-md);
  padding: 1.5rem;
}

.conservation-icon {
  flex-shrink: 0;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background-color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #6b7280;
}

.conservation-icon svg {
  width: 24px;
  height: 24px;
}

.conservation-icon.status-lc {
  color: var(--color-status-lc);
}

.conservation-icon.status-nt {
  color: var(--color-status-nt);
}

.conservation-icon.status-vu {
  color: var(--color-status-vu);
}

.conservation-icon.status-en {
  color: var(--color-status-en);
}

.conservation-icon.status-cr {
  color: var(--color-status-cr);
}

.conservation-icon.status-ew {
  color: var(--color-status-ew);
}

.conservation-icon.status-ex {
  color: var(--color-status-ex);
}

.conservation-content {
  flex-grow: 1;
}

.conservation-fact {
  margin-bottom: 1rem;
}

.real-world-inspiration {
  font-style: italic;
  color: #6b7280;
}

.exhibition-note {
  padding: 1.5rem;
  background-color: #f9fafb;
  border-radius: var(--radius-md);
  color: #4b5563;
  font-style: italic;
  line-height: 1.6;
  position: relative;
}

.exhibition-note::before {
  content: '"';
  position: absolute;
  top: 0;
  left: 0.5rem;
  font-size: 3rem;
  color: #d1d5db;
  line-height: 1;
}

/* Conservation Education Section */
.conservation-section {
  background-color: #f9fafb;
  padding: 4rem 1.5rem;
  border-top: 1px solid #e5e7eb;
}

.conservation-header {
  text-align: center;
  max-width: 800px;
  margin: 0 auto 3rem;
}

.conservation-header h2 {
  font-size: 2rem;
  font-weight: 500;
  margin-bottom: 1rem;
}

.conservation-header p {
  color: #6b7280;
}

.conservation-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
  max-width: 1200px;
  margin: 0 auto;
}

.status-explanation {
  padding: 1.5rem;
  border-radius: var(--radius-lg);
  background-color: white;
  box-shadow: var(--shadow-md);
  border-top: 4px solid currentColor;
}

.status-explanation h3 {
  font-size: 1.125rem;
  font-weight: 500;
  margin-bottom: 0.75rem;
}

.status-explanation p {
  font-size: 0.875rem;
  color: #6b7280;
  line-height: 1.6;
}

.status-explanation.status-lc {
  color: var(--color-status-lc);
}

.status-explanation.status-nt {
  color: var(--color-status-nt);
}

.status-explanation.status-vu {
  color: var(--color-status-vu);
}

.status-explanation.status-en {
  color: var(--color-status-en);
}

.status-explanation.status-cr {
  color: var(--color-status-cr);
}

.status-explanation.status-ew {
  color: var(--color-status-ew);
}

.status-explanation.status-ex {
  color: var(--color-status-ex);
}

/* Animations */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.transition-opacity {
  transition: opacity var(--transition-normal);
}

.opacity-0 {
  opacity: 0;
}

.opacity-100 {
  opacity: 1;
}

.panel-enter {
  transition: opacity var(--transition-normal), transform var(--transition-normal);
}

.panel-enter-start {
  opacity: 0;
  transform: translateX(30px);
}

.panel-enter-end {
  opacity: 1;
  transform: translateX(0);
}

.panel-leave {
  transition: opacity var(--transition-normal), transform var(--transition-normal);
}

.panel-leave-start {
  opacity: 1;
  transform: translateX(0);
}

.panel-leave-end {
  opacity: 0;
  transform: translateX(30px);
}

/* Responsive Styles */
@media (max-width: 1024px) {
  .hero-text .title {
    font-size: 3rem;
  }
  
  .panel-columns {
    grid-template-columns: 1fr;
  }
  
  .panel-media {
    position: static;
  }
  
  .carousel-slide {
    min-width: 50%;
    flex: 0 0 50%;
  }
}

@media (max-width: 768px) {
  .hero-text .title {
    font-size: 2.5rem;
  }
  
  .hero-text .subtitle {
    font-size: 1.125rem;
  }
  
  .masonry-gallery {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .carousel-slide {
    min-width: 100%;
    flex: 0 0 100%;
  }
}

@media (max-width: 640px) {
  .masonry-gallery {
    grid-template-columns: 1fr;
  }
  
  .conservation-cards {
    grid-template-columns: 1fr;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<script>
function galleryApp() {
  return {
    creatures: <?= json_encode($creatures) ?>,
    searchQuery: '',
    habitatFilter: 'all',
    rarityFilter: 'all',
    conservationFilter: 'all',
    galleryView: 'grid',
    selectedCreature: null,
    selectedCreatureIndex: -1,
    selectedStage: 'adult',
    isPlaying: false,
    isCreatureSoundPlaying: false,
    ambientSound: null,
    creatureSound: null,
    currentHabitatTheme: 'forest',
    isControlsSticky: false,
    carouselIndex: 0,
    carouselItemsPerPage: 3,
    searchTimeout: null,
    
    initializeGallery() {
      // Initialize audio elements
      this.ambientSound = document.getElementById('ambient-sound');
      this.creatureSound = document.getElementById('creature-sound');
      
      // Calculate carousel items per page based on screen width
      this.updateCarouselItemsPerPage();
      window.addEventListener('resize', () => {
        this.updateCarouselItemsPerPage();
      });
      
      // Set up GSAP animations if available
      if (window.gsap) {
        gsap.registerPlugin(ScrollTrigger);
        this.setupScrollAnimations();
      }
    },
    
    setupScrollAnimations() {
      // Fade in animations for creature cards
      gsap.utils.toArray('.creature-card').forEach((card, i) => {
        gsap.from(card, {
          y: 50,
          opacity: 0,
          duration: 0.6,
          delay: i * 0.1,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: card,
            start: 'top bottom-=100',
            toggleActions: 'play none none none'
          }
        });
      });
    },
    
    updateCarouselItemsPerPage() {
      if (window.innerWidth < 768) {
        this.carouselItemsPerPage = 1;
      } else if (window.innerWidth < 1024) {
        this.carouselItemsPerPage = 2;
      } else {
        this.carouselItemsPerPage = 3;
      }
    },
    
    animateHeroTitle() {
      document.querySelector('.hero-text .title').classList.add('animate');
    },
    
    animateHeroSubtitle() {
      document.querySelector('.hero-text .subtitle').classList.add('animate');
    },
    
    hideScrollIndicator() {
      document.querySelector('.hero-scroll-indicator').classList.add('hidden');
    },
    
    checkControlsSticky() {
      const controlsEl = this.$refs.galleryControls;
      if (!controlsEl) return;
      
      const rect = controlsEl.getBoundingClientRect();
      this.isControlsSticky = rect.top <= 0;
    },
    
    animateCardEntry(el, index) {
      setTimeout(() => {
        el.style.opacity = 1;
        el.style.transform = 'translateY(0)';
      }, index * 50);
    },
    
    debouncedSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        // Reset carousel position when search changes
        this.carouselIndex = 0;
      }, 300);
    },
    
    get filteredCreatures() {
      return this.creatures.filter(creature => {
        // Text search
        if (this.searchQuery && !this.creatureMatchesSearch(creature)) {
          return false;
        }
        
        // Habitat filter
        if (this.habitatFilter !== 'all' && creature.habitat_type !== this.habitatFilter) {
          return false;
        }
        
        // Rarity filter
        if (this.rarityFilter !== 'all' && creature.rarity !== this.rarityFilter) {
          return false;
        }
        
        // Conservation status filter
        if (this.conservationFilter !== 'all' && creature.iucn_status !== this.conservationFilter) {
          return false;
        }
        
        return true;
      });
    },
    
    get hasActiveFilters() {
      return this.habitatFilter !== 'all' || this.rarityFilter !== 'all' || this.conservationFilter !== 'all' || this.searchQuery !== '';
    },
    
    get hasPreviousCreature() {
      return this.selectedCreatureIndex > 0;
    },
    
    get hasNextCreature() {
      return this.selectedCreatureIndex < this.filteredCreatures.length - 1;
    },
    
    creatureMatchesSearch(creature) {
      if (!this.searchQuery) return true;
      
      const searchTerm = this.searchQuery.toLowerCase();
      return creature.name.toLowerCase().includes(searchTerm) || 
             creature.species_name.toLowerCase().includes(searchTerm) || 
             creature.description.toLowerCase().includes(searchTerm) ||
             creature.habitat_type.toLowerCase().includes(searchTerm) ||
             creature.rarity.toLowerCase().includes(searchTerm);
    },
    
    resetFilters() {
      this.searchQuery = '';
      this.habitatFilter = 'all';
      this.rarityFilter = 'all';
      this.conservationFilter = 'all';
      this.carouselIndex = 0;
    },
    
    switchHabitatTheme(habitat) {
      this.currentHabitatTheme = habitat;
      this.habitatFilter = habitat;
    },
    
    openDetailsPanel(creature) {
      this.selectedCreature = creature;
      this.selectedCreatureIndex = this.filteredCreatures.findIndex(c => c.id === creature.id);
      this.selectedStage = creature.stage || 'adult';
      this.isCreatureSoundPlaying = false;
      
      // Preload sounds and images
      if (creature.audio_url) {
        this.creatureSound.src = creature.audio_url;
        this.creatureSound.load();
      }
      
      // Prevent body scrolling
      document.body.style.overflow = 'hidden';
    },
    
    closeDetailsPanel() {
      if (this.isCreatureSoundPlaying) {
        this.toggleCreatureSound();
      }
      
      this.selectedCreature = null;
      this.selectedCreatureIndex = -1;
      
      // Restore body scrolling
      document.body.style.overflow = '';
    },
    
    previousCreature() {
      if (this.hasPreviousCreature) {
        this.openDetailsPanel(this.filteredCreatures[this.selectedCreatureIndex - 1]);
      }
    },
    
    nextCreature() {
      if (this.hasNextCreature) {
        this.openDetailsPanel(this.filteredCreatures[this.selectedCreatureIndex + 1]);
      }
    },
    
    toggleAmbientSound() {
      if (this.isPlaying) {
        this.ambientSound.pause();
      } else {
        this.ambientSound.play();
      }
      this.isPlaying = !this.isPlaying;
    },
    
    toggleCreatureSound() {
      if (!this.selectedCreature || !this.selectedCreature.audio_url) {
        return;
      }
      
      // Update source if needed
      if (this.creatureSound.src !== this.selectedCreature.audio_url) {
        this.creatureSound.src = this.selectedCreature.audio_url;
      }
      
      if (this.isCreatureSoundPlaying) {
        this.creatureSound.pause();
      } else {
        this.creatureSound.play();
      }
      this.isCreatureSoundPlaying = !this.isCreatureSoundPlaying;
    },
    
    carouselPrev() {
      if (this.carouselIndex > 0) {
        this.carouselIndex--;
      }
    },
    
    carouselNext() {
      if (this.carouselIndex < this.filteredCreatures.length - this.carouselItemsPerPage) {
        this.carouselIndex++;
      }
    },
    
    carouselGoToPage(pageIndex) {
      this.carouselIndex = pageIndex * this.carouselItemsPerPage;
    },
    
    getCarouselPages() {
      const pageCount = Math.ceil(this.filteredCreatures.length / this.carouselItemsPerPage);
      return Array(pageCount).fill(0);
    },
    
    getMasonryColumn(columnIndex) {
      return this.filteredCreatures.filter((_, index) => index % 3 === columnIndex);
    },
    
    getCreatureImage(creature) {
      if (this.selectedCreature && this.selectedCreature.id === creature.id) {
        // Use selected stage for the detailed view
        if (creature.image_urls && creature.image_urls[this.selectedStage]) {
          return creature.image_urls[this.selectedStage];
        }
      } else {
        // Use creature's current stage for gallery view
        if (creature.image_urls && creature.image_urls[creature.stage]) {
          return creature.image_urls[creature.stage];
        }
      }
      
      // Fallback to default path
      return `<?= $baseUrl ?>/images/creatures/${creature.id}_${creature.stage}.png`;
    },
    
    hasMultipleStages(creature) {
      if (!creature.image_urls) return false;
      
      // Check if creature has images for multiple stages
      const stages = ['egg', 'baby', 'juvenile', 'adult', 'mythical'];
      let stageCount = 0;
      
      for (const stage of stages) {
        if (creature.image_urls[stage]) {
          stageCount++;
        }
      }
      
      return stageCount > 1;
    },
    
    getHabitatClass(habitat) {
      return `habitat-${habitat}`;
    },
    
    getRarityClass(rarity) {
      return `rarity-${rarity}`;
    },
    
    getConservationClass(status) {
      return `status-${status.toLowerCase()}`;
    },
    
    getConservationLabel(status) {
      const labels = {
        'LC': 'Least Concern',
        'NT': 'Near Threatened',
        'VU': 'Vulnerable',
        'EN': 'Endangered',
        'CR': 'Critically Endangered',
        'EW': 'Extinct in Wild',
        'EX': 'Extinct'
      };
      
      return labels[status] || status;
    },
    
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    
    truncateText(text, maxLength) {
      if (!text) return '';
      if (text.length <= maxLength) return text;
      
      return text.substring(0, maxLength) + '...';
    },
    
    getHabitatBackground(habitat) {
      const backgrounds = {
        forest: `
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800" width="100%" height="100%">
            <path d="M0,800 L50,730 L100,760 L150,710 L200,750 L250,700 L300,760 L350,720 L400,770 L450,700 L500,760 L550,710 L600,780 L650,700 L700,770 L750,720 L800,760 L850,700 L900,750 L950,710 L1000,760 L1050,700 L1100,780 L1150,710 L1200,800 Z" fill="#22c55e" />
            <path d="M850,350 Q900,200 950,350 L950,450 L850,450 Z" fill="#22c55e" />
            <path d="M650,300 Q700,100 750,300 L750,450 L650,450 Z" fill="#22c55e" />
            <path d="M450,250 Q500,50 550,250 L550,450 L450,450 Z" fill="#22c55e" />
            <path d="M250,320 Q300,150 350,320 L350,450 L250,450 Z" fill="#22c55e" />
          </svg>
        `,
        ocean: `
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800" width="100%" height="100%">
            <path d="M0,600 Q300,550 600,650 Q900,750 1200,600 L1200,800 L0,800 Z" fill="#3b82f6">
              <animate attributeName="d" values="M0,600 Q300,550 600,650 Q900,750 1200,600 L1200,800 L0,800 Z; M0,620 Q300,680 600,600 Q900,520 1200,620 L1200,800 L0,800 Z; M0,600 Q300,550 600,650 Q900,750 1200,600 L1200,800 L0,800 Z" dur="15s" repeatCount="indefinite" />
              </path>
              <circle cx="300" cy="500" r="8" fill="#3b82f6">
                <animate attributeName="cy" values="500;520;500" dur="4s" repeatCount="indefinite" />
              </circle>
              <circle cx="800" cy="550" r="12" fill="#3b82f6">
                <animate attributeName="cy" values="550;530;550" dur="5s" repeatCount="indefinite" />
              </circle>
              <path d="M400,400 Q450,350 500,400 Q550,450 600,400" fill="none" stroke="#3b82f6" stroke-width="4">
                <animate attributeName="d" values="M400,400 Q450,350 500,400 Q550,450 600,400; M400,420 Q450,370 500,420 Q550,470 600,420; M400,400 Q450,350 500,400 Q550,450 600,400" dur="6s" repeatCount="indefinite" />
              </path>
            </svg>
          `,
        mountain: `
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800" width="100%" height="100%">
            <path d="M0,800 L0,500 L200,200 L400,450 L600,150 L800,350 L1000,250 L1200,400 L1200,800 Z" fill="#ef4444">
              <animate attributeName="opacity" values="0.7;0.8;0.7" dur="8s" repeatCount="indefinite" />
            </path>
            <path d="M0,800 L0,600 L300,400 L500,550 L700,300 L900,500 L1100,350 L1200,450 L1200,800 Z" fill="#ef4444">
              <animate attributeName="opacity" values="0.8;0.9;0.8" dur="10s" repeatCount="indefinite" />
            </path>
            <circle cx="200" cy="200" r="30" fill="white" opacity="0.8" />
            <line x1="100" y1="500" x2="200" y2="600" stroke="#ef4444" stroke-width="2" />
            <line x1="500" y1="400" x2="600" y2="500" stroke="#ef4444" stroke-width="2" />
            <line x1="900" y1="450" x2="1000" y2="550" stroke="#ef4444" stroke-width="2" />
          </svg>
        `,
        sky: `
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800" width="100%" height="100%">
            <path d="M200,300 Q300,200 400,250 Q500,300 600,200 Q700,100 800,200 Q900,300 1000,250" fill="none" stroke="#0ea5e9" stroke-width="3">
              <animate attributeName="d" values="M200,300 Q300,200 400,250 Q500,300 600,200 Q700,100 800,200 Q900,300 1000,250; M200,250 Q300,350 400,300 Q500,250 600,350 Q700,250 800,350 Q900,250 1000,300; M200,300 Q300,200 400,250 Q500,300 600,200 Q700,100 800,200 Q900,300 1000,250" dur="20s" repeatCount="indefinite" />
            </path>
            <circle cx="300" cy="200" r="50" fill="#0ea5e9" opacity="0.2">
              <animate attributeName="cy" values="200;180;200" dur="8s" repeatCount="indefinite" />
            </circle>
            <circle cx="700" cy="150" r="70" fill="#0ea5e9" opacity="0.2">
              <animate attributeName="cy" values="150;170;150" dur="10s" repeatCount="indefinite" />
            </circle>
            <circle cx="900" cy="250" r="40" fill="#0ea5e9" opacity="0.2">
              <animate attributeName="cy" values="250;230;250" dur="9s" repeatCount="indefinite" />
            </circle>
          </svg>
        `,
        cosmic: `
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800" width="100%" height="100%">
            <circle cx="200" cy="200" r="2" fill="#a855f7">
              <animate attributeName="r" values="2;4;2" dur="3s" repeatCount="indefinite" />
              <animate attributeName="opacity" values="0.3;1;0.3" dur="3s" repeatCount="indefinite" />
            </circle>
            <circle cx="400" cy="300" r="3" fill="#a855f7">
              <animate attributeName="r" values="3;6;3" dur="5s" repeatCount="indefinite" />
              <animate attributeName="opacity" values="0.3;1;0.3" dur="5s" repeatCount="indefinite" />
            </circle>
            <circle cx="600" cy="200" r="2" fill="#a855f7">
              <animate attributeName="r" values="2;5;2" dur="4s" repeatCount="indefinite" />
              <animate attributeName="opacity" values="0.3;1;0.3" dur="4s" repeatCount="indefinite" />
            </circle>
            <circle cx="800" cy="400" r="4" fill="#a855f7">
              <animate attributeName="r" values="4;8;4" dur="6s" repeatCount="indefinite" />
              <animate attributeName="opacity" values="0.3;1;0.3" dur="6s" repeatCount="indefinite" />
            </circle>
            <circle cx="1000" cy="300" r="3" fill="#a855f7">
              <animate attributeName="r" values="3;7;3" dur="7s" repeatCount="indefinite" />
              <animate attributeName="opacity" values="0.3;1;0.3" dur="7s" repeatCount="indefinite" />
            </circle>
            <circle cx="300" cy="500" r="2" fill="#a855f7">
              <animate attributeName="r" values="2;4;2" dur="4s" repeatCount="indefinite" />
              <animate attributeName="opacity" values="0.3;1;0.3" dur="4s" repeatCount="indefinite" />
            </circle>
            <circle cx="700" cy="600" r="3" fill="#a855f7">
              <animate attributeName="r" values="3;6;3" dur="5s" repeatCount="indefinite" />
              <animate attributeName="opacity" values="0.3;1;0.3" dur="5s" repeatCount="indefinite" />
            </circle>
            <path d="M0,0 L1200,800" stroke="#a855f7" stroke-width="1" opacity="0.2" />
            <path d="M1200,0 L0,800" stroke="#a855f7" stroke-width="1" opacity="0.2" />
          </svg>
        `,
        enchanted: `
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800" width="100%" height="100%">
            <path d="M400,300 Q600,100 800,300 Q1000,500 800,700 Q600,900 400,700 Q200,500 400,300" stroke="#ec4899" stroke-width="2" fill="none" opacity="0.5">
              <animate attributeName="d" values="M400,300 Q600,100 800,300 Q1000,500 800,700 Q600,900 400,700 Q200,500 400,300; M450,350 Q600,150 750,350 Q900,550 750,750 Q600,950 450,750 Q300,550 450,350; M400,300 Q600,100 800,300 Q1000,500 800,700 Q600,900 400,700 Q200,500 400,300" dur="20s" repeatCount="indefinite" />
            </path>
            <circle cx="400" cy="300" r="5" fill="#ec4899">
              <animate attributeName="opacity" values="0.2;1;0.2" dur="5s" repeatCount="indefinite" />
            </circle>
            <circle cx="600" cy="100" r="5" fill="#ec4899">
              <animate attributeName="opacity" values="0.3;1;0.3" dur="7s" repeatCount="indefinite" />
            </circle>
            <circle cx="800" cy="300" r="5" fill="#ec4899">
              <animate attributeName="opacity" values="0.4;1;0.4" dur="6s" repeatCount="indefinite" />
            </circle>
            <circle cx="1000" cy="500" r="5" fill="#ec4899">
              <animate attributeName="opacity" values="0.2;1;0.2" dur="8s" repeatCount="indefinite" />
            </circle>
            <circle cx="800" cy="700" r="5" fill="#ec4899">
              <animate attributeName="opacity" values="0.3;1;0.3" dur="5s" repeatCount="indefinite" />
            </circle>
            <circle cx="600" cy="900" r="5" fill="#ec4899">
              <animate attributeName="opacity" values="0.4;1;0.4" dur="7s" repeatCount="indefinite" />
            </circle>
            <circle cx="400" cy="700" r="5" fill="#ec4899">
              <animate attributeName="opacity" values="0.2;1;0.2" dur="6s" repeatCount="indefinite" />
            </circle>
            <circle cx="200" cy="500" r="5" fill="#ec4899">
              <animate attributeName="opacity" values="0.3;1;0.3" dur="8s" repeatCount="indefinite" />
            </circle>
          </svg>
        `
      };
      
      return backgrounds[habitat] || '';
    }
  };
}
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>