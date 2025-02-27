<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="gallery-exhibition" x-data="galleryApp">
  <!-- Exhibition Header -->
  <div class="exhibition-header">
    <div class="container mx-auto px-4 py-16 text-center">
      <h1 class="text-4xl md:text-5xl font-serif font-light mb-6 tracking-wide text-gray-900">Wildlife Haven Exhibition</h1>
      <p class="max-w-3xl mx-auto text-lg text-gray-600 leading-relaxed">
        Explore our collection of mythical creatures inspired by endangered wildlife. Each creature tells a story of beauty, resilience, and the delicate balance of our natural world.
      </p>
      
      <!-- Audio Controls -->
      <div class="mt-8">
        <button @click="toggleAmbientSound" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <template x-if="!isPlaying">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd" />
            </svg>
          </template>
          <template x-if="isPlaying">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM12.293 7.293a1 1 0 011.414 0L15 8.586l1.293-1.293a1 1 0 111.414 1.414L16.414 10l1.293 1.293a1 1 0 01-1.414 1.414L15 11.414l-1.293 1.293a1 1 0 01-1.414-1.414L13.586 10l-1.293-1.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </template>
          <span x-text="isPlaying ? 'Mute Ambient Sound' : 'Play Ambient Sound'"></span>
        </button>
      </div>
    </div>
  </div>

  <!-- Exhibition Controls -->
  <div class="bg-gray-50 border-t border-b border-gray-200">
    <div class="container mx-auto px-4 py-6">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Search -->
        <div class="relative flex-grow max-w-lg">
          <input 
            type="text" 
            placeholder="Search the exhibition..." 
            x-model="searchQuery"
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
          >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        
        <!-- Filters -->
        <div class="flex flex-wrap gap-2">
          <select 
            x-model="habitatFilter" 
            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white"
          >
            <option value="all">All Habitats</option>
            <option value="forest">Forest</option>
            <option value="ocean">Ocean</option>
            <option value="mountain">Mountain</option>
            <option value="sky">Sky</option>
            <option value="cosmic">Cosmic</option>
            <option value="enchanted">Enchanted</option>
          </select>
          
          <select 
            x-model="rarityFilter" 
            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white"
          >
            <option value="all">All Rarities</option>
            <option value="common">Common</option>
            <option value="uncommon">Uncommon</option>
            <option value="rare">Rare</option>
            <option value="legendary">Legendary</option>
            <option value="mythical">Mythical</option>
          </select>
          
          <select 
            x-model="stageFilter" 
            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white"
          >
            <option value="all">All Stages</option>
            <option value="egg">Egg</option>
            <option value="baby">Baby</option>
            <option value="juvenile">Juvenile</option>
            <option value="adult">Adult</option>
            <option value="mythical">Mythical</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- Exhibition Gallery -->
  <div class="exhibition-gallery py-12 bg-white">
    <div class="container mx-auto px-4">
      <!-- Gallery Stats -->
      <div class="flex justify-between items-center mb-8">
        <p class="text-gray-600">
          <span x-text="filteredCreatures.length"></span> creatures on display
        </p>
        
        <button @click="resetFilters" class="text-indigo-600 hover:text-indigo-800 font-medium">
          Reset Filters
        </button>
      </div>
      
      <!-- Gallery Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <template x-for="creature in filteredCreatures" :key="creature.id">
          <div class="exhibition-item" :class="getHabitatClass(creature.habitat_type)">
            <!-- Artwork Frame -->
            <div 
              class="artwork-frame bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300"
              @click="openCreatureModal(creature)"
            >
              <!-- Creature Image -->
              <div class="relative aspect-square overflow-hidden bg-gray-100">
                <div class="absolute inset-0 flex items-center justify-center">
                  <img 
                    :src="getCreatureImage(creature)" 
                    :alt="creature.name"
                    class="object-contain h-full w-full transform hover:scale-105 transition-transform duration-500"
                  >
                </div>
                
                <!-- Rarity Badge -->
                <div class="absolute top-3 right-3">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="getRarityClass(creature.rarity)">
                    <span x-text="capitalizeFirstLetter(creature.rarity)"></span>
                  </span>
                </div>
              </div>
              
              <!-- Artwork Info -->
              <div class="p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-1" x-text="creature.name"></h3>
                <p class="text-sm text-gray-500 mb-2" x-text="creature.species_name"></p>
                
                <div class="flex items-center justify-between">
                  <span class="text-xs font-medium px-2 py-1 rounded-full capitalize" :class="getHabitatBadgeClass(creature.habitat_type)" x-text="creature.habitat_type"></span>
                  <span class="text-xs font-medium px-2 py-1 rounded-full capitalize" :class="getStageBadgeClass(creature.stage)" x-text="creature.stage"></span>
                </div>
              </div>
            </div>
          </div>
        </template>
      </div>
      
      <!-- Empty State -->
      <template x-if="filteredCreatures.length === 0">
        <div class="text-center py-16">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No creatures found</h3>
          <p class="text-gray-500 mb-4">Try adjusting your search or filters</p>
          <button @click="resetFilters" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Reset Filters
          </button>
        </div>
      </template>
    </div>
  </div>

  <!-- Creature Detail Modal -->
  <div 
    x-show="selectedCreature !== null" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    class="fixed inset-0 z-50 overflow-y-auto" 
    @keydown.escape.window="closeCreatureModal"
    style="display: none;"
  >
    <!-- Modal Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" @click="closeCreatureModal"></div>
    
    <!-- Modal Content -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
      <div 
        class="relative bg-white rounded-lg max-w-5xl w-full max-h-[90vh] overflow-hidden shadow-xl" 
        @click.stop
      >
        <template x-if="selectedCreature">
          <!-- Modal Header -->
          <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-2xl font-serif font-light text-gray-900" x-text="selectedCreature.name"></h2>
            <button @click="closeCreatureModal" class="text-gray-400 hover:text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          
          <!-- Modal Body -->
          <div class="p-6 overflow-y-auto max-h-[calc(90vh-12rem)]">
            <div class="flex flex-col lg:flex-row gap-8">
              <!-- Creature Image Section -->
              <div class="w-full lg:w-1/2">
                <div class="relative aspect-square bg-gray-100 rounded-lg overflow-hidden">
                  <!-- Creature Image -->
                  <img 
                    :src="getCreatureImage(selectedCreature)" 
                    :alt="selectedCreature.name"
                    class="object-contain h-full w-full"
                  >
                  
                  <!-- Habitat Decoration -->
                  <div class="absolute inset-0 pointer-events-none opacity-20 z-0" x-html="getHabitatDecoration(selectedCreature.habitat_type)"></div>
                </div>
                
                <!-- Audio Player -->
                <div class="mt-4">
                  <button 
                    @click="toggleCreatureSound" 
                    class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                  >
                    <template x-if="!isCreatureSoundPlaying">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                      </svg>
                    </template>
                    <template x-if="isCreatureSoundPlaying">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd" />
                      </svg>
                    </template>
                    <span x-text="isCreatureSoundPlaying ? 'Pause Creature Sound' : 'Play Creature Sound'"></span>
                  </button>
                </div>
                
                <!-- Creature Stats -->
                <div class="mt-6 bg-gray-50 rounded-lg p-4">
                  <h3 class="text-lg font-medium text-gray-900 mb-4">Creature Information</h3>
                  
                  <!-- Species & Stage -->
                  <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                      <span class="block text-sm font-medium text-gray-500">Species</span>
                      <span class="block mt-1 text-sm text-gray-900" x-text="selectedCreature.species_name"></span>
                    </div>
                    <div>
                      <span class="block text-sm font-medium text-gray-500">Stage</span>
                      <div class="mt-1">
                        <span 
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" 
                          :class="getStageBadgeClass(selectedCreature.stage)" 
                          x-text="selectedCreature.stage"
                        ></span>
                      </div>
                    </div>
                    <div>
                      <span class="block text-sm font-medium text-gray-500">Habitat</span>
                      <div class="mt-1">
                        <span 
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" 
                          :class="getHabitatBadgeClass(selectedCreature.habitat_type)" 
                          x-text="selectedCreature.habitat_type"
                        ></span>
                      </div>
                    </div>
                    <div>
                      <span class="block text-sm font-medium text-gray-500">Rarity</span>
                      <div class="mt-1">
                        <span 
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" 
                          :class="getRarityClass(selectedCreature.rarity)" 
                          x-text="selectedCreature.rarity"
                        ></span>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Health & Happiness -->
                  <div class="mb-4">
                    <div class="mb-2">
                      <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-500">Health</span>
                        <span class="text-sm font-medium text-gray-900" x-text="selectedCreature.health + '%'"></span>
                      </div>
                      <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" :style="`width: ${selectedCreature.health}%`"></div>
                      </div>
                    </div>
                    
                    <div>
                      <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-500">Happiness</span>
                        <span class="text-sm font-medium text-gray-900" x-text="selectedCreature.happiness + '%'"></span>
                      </div>
                      <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" :style="`width: ${selectedCreature.happiness}%`"></div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Growth Progress -->
                  <template x-if="selectedCreature.stage !== 'mythical'">
                    <div>
                      <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-500">Growth Progress</span>
                        <span class="text-sm font-medium text-gray-900" x-text="selectedCreature.growth_progress + '%'"></span>
                      </div>
                      <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-indigo-600 h-2 rounded-full" :style="`width: ${selectedCreature.growth_progress}%`"></div>
                      </div>
                      <p class="mt-1 text-xs text-gray-500" x-text="getGrowthStatusText(selectedCreature)"></p>
                    </div>
                  </template>
                </div>
              </div>
              
              <!-- Creature Description Section -->
              <div class="w-full lg:w-1/2">
                <!-- Exhibition Note -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                  <h3 class="text-lg font-medium text-gray-900 mb-2">Exhibition Note</h3>
                  <p class="italic text-gray-600" x-text="selectedCreature.exhibition_note"></p>
                </div>
                
                <!-- Description -->
                <div class="mb-6">
                  <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                  <p class="text-gray-600" x-text="selectedCreature.description"></p>
                </div>
                
                <!-- Real World Connection -->
                <div class="mb-6">
                  <h3 class="text-lg font-medium text-gray-900 mb-2">Real World Inspiration</h3>
                  <p class="text-gray-600 italic" x-text="selectedCreature.real_world_inspiration"></p>
                </div>
                
                <!-- Conservation Note -->
                <div class="bg-amber-50 rounded-lg p-6">
                  <div class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                    <div class="ml-3">
                      <h3 class="text-lg font-medium text-amber-800 mb-2">Conservation Status</h3>
                      <p class="text-gray-700" x-text="selectedCreature.conservation_fact"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Modal Footer -->
          <div class="bg-gray-50 px-6 py-4 flex justify-end">
            <button 
              @click="closeCreatureModal" 
              class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Close
            </button>
          </div>
        </template>
      </div>
    </div>
  </div>
</div>

<!-- Hidden Audio Elements -->
<audio id="ambient-sound" loop>
  <source src="<?= $baseUrl ?>/resources/audio/ambient_nature.mp3" type="audio/mpeg">
</audio>
<audio id="creature-sound">
  <source src="" type="audio/mpeg">
</audio>

<script>
  function galleryApp() {
    return {
      creatures: <?= json_encode($creatures) ?>,
      searchQuery: '',
      habitatFilter: 'all',
      rarityFilter: 'all',
      stageFilter: 'all',
      selectedCreature: null,
      isPlaying: false,
      isCreatureSoundPlaying: false,
      ambientSound: null,
      creatureSound: null,
      
      init() {
        this.ambientSound = document.getElementById('ambient-sound');
        this.creatureSound = document.getElementById('creature-sound');
        
        // Preload images
        this.creatures.forEach(creature => {
          if (creature.image_urls) {
            Object.values(creature.image_urls).forEach(url => {
              const img = new Image();
              img.src = url;
            });
          }
        });
      },
      
      get filteredCreatures() {
        return this.creatures.filter(creature => {
          // Text search
          if (this.searchQuery && !this.creatureMatchesSearch(creature, this.searchQuery)) {
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
          
          // Stage filter
          if (this.stageFilter !== 'all' && creature.stage !== this.stageFilter) {
            return false;
          }
          
          return true;
        });
      },
      
      creatureMatchesSearch(creature, query) {
        const searchTerm = query.toLowerCase();
        return creature.name.toLowerCase().includes(searchTerm) || 
               creature.species_name.toLowerCase().includes(searchTerm) || 
               creature.description.toLowerCase().includes(searchTerm);
      },
      
      resetFilters() {
        this.searchQuery = '';
        this.habitatFilter = 'all';
        this.rarityFilter = 'all';
        this.stageFilter = 'all';
      },
      
      openCreatureModal(creature) {
        this.selectedCreature = creature;
        this.isCreatureSoundPlaying = false;
      },
      
      closeCreatureModal() {
        if (this.isCreatureSoundPlaying) {
          this.toggleCreatureSound();
        }
        this.selectedCreature = null;
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
      
      getCreatureImage(creature) {
        if (creature.image_urls && creature.image_urls[creature.stage]) {
          return creature.image_urls[creature.stage];
        }
        return `<?= $baseUrl ?>/images/creatures/${creature.id}_${creature.stage}.png`;
      },
      
      getHabitatClass(habitat) {
        const classes = {
          'forest': 'habitat-forest',
          'ocean': 'habitat-ocean',
          'mountain': 'habitat-mountain',
          'sky': 'habitat-sky',
          'cosmic': 'habitat-cosmic',
          'enchanted': 'habitat-enchanted'
        };
        return classes[habitat] || '';
      },
      
      getHabitatBadgeClass(habitat) {
        const classes = {
          'forest': 'bg-green-100 text-green-800',
          'ocean': 'bg-blue-100 text-blue-800',
          'mountain': 'bg-red-100 text-red-800',
          'sky': 'bg-cyan-100 text-cyan-800',
          'cosmic': 'bg-purple-100 text-purple-800',
          'enchanted': 'bg-pink-100 text-pink-800'
        };
        return classes[habitat] || 'bg-gray-100 text-gray-800';
      },
      
      getStageBadgeClass(stage) {
        const classes = {
          'egg': 'bg-yellow-100 text-yellow-800',
          'baby': 'bg-blue-100 text-blue-800',
          'juvenile': 'bg-green-100 text-green-800',
          'adult': 'bg-purple-100 text-purple-800',
          'mythical': 'bg-red-100 text-red-800'
        };
        return classes[stage] || 'bg-gray-100 text-gray-800';
      },
      
      getRarityClass(rarity) {
        const classes = {
          'common': 'bg-gray-100 text-gray-800',
          'uncommon': 'bg-green-100 text-green-800',
          'rare': 'bg-blue-100 text-blue-800',
          'legendary': 'bg-purple-100 text-purple-800',
          'mythical': 'bg-amber-100 text-amber-800'
        };
        return classes[rarity] || 'bg-gray-100 text-gray-800';
      },
      
      capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
      },
      
      getGrowthStatusText(creature) {
        if (creature.stage === 'mythical') {
          return 'Fully evolved';
        }
        
        if (creature.growth_progress >= 100) {
          const nextStages = {
            'egg': 'baby',
            'baby': 'juvenile',
            'juvenile': 'adult',
            'adult': 'mythical'
          };
          return `Ready to evolve to ${nextStages[creature.stage]}`;
        }
        
        return `${creature.growth_progress}% progress to next stage`;
      },
      
      getHabitatDecoration(habitat) {
        // SVG decorations based on habitat type
        const decorations = {
          'forest': `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-full h-full">
              <path d="M10,80 Q25,40 40,80 T70,80" stroke="#22c55e" stroke-width="1" fill="none">
                <animate attributeName="d" values="M10,80 Q25,40 40,80 T70,80; M10,80 Q25,30 40,80 T70,80; M10,80 Q25,40 40,80 T70,80" dur="8s" repeatCount="indefinite" />
              </path>
              <path d="M30,80 Q45,30 60,80 T90,80" stroke="#22c55e" stroke-width="1" fill="none">
                <animate attributeName="d" values="M30,80 Q45,30 60,80 T90,80; M30,80 Q45,40 60,80 T90,80; M30,80 Q45,30 60,80 T90,80" dur="10s" repeatCount="indefinite" />
              </path>
            </svg>
          `,
          'ocean': `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-full h-full">
              <path d="M0,50 Q25,40 50,50 Q75,60 100,50 L100,100 L0,100 Z" fill="#3b82f6">
                <animate attributeName="d" values="M0,50 Q25,40 50,50 Q75,60 100,50 L100,100 L0,100 Z; M0,50 Q25,60 50,50 Q75,40 100,50 L100,100 L0,100 Z; M0,50 Q25,40 50,50 Q75,60 100,50 L100,100 L0,100 Z" dur="12s" repeatCount="indefinite" />
              </path>
            </svg>
          `,
          'mountain': `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-full h-full">
              <polygon points="20,90 50,20 80,90" fill="#ef4444" />
              <polygon points="10,90 30,40 50,90" fill="#ef4444" />
              <polygon points="50,90 70,30 90,90" fill="#ef4444" />
            </svg>
          `,
          'sky': `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-full h-full">
              <circle cx="30" cy="30" r="8" fill="#0ea5e9">
                <animate attributeName="opacity" values="0.3;0.7;0.3" dur="8s" repeatCount="indefinite" />
              </circle>
              <circle cx="70" cy="40" r="10" fill="#0ea5e9">
                <animate attributeName="opacity" values="0.4;0.8;0.4" dur="10s" repeatCount="indefinite" />
              </circle>
              <circle cx="20" cy="60" r="6" fill="#0ea5e9">
                <animate attributeName="opacity" values="0.2;0.6;0.2" dur="7s" repeatCount="indefinite" />
              </circle>
            </svg>
          `,
          'cosmic': `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-full h-full">
              <circle cx="20" cy="20" r="1" fill="#a855f7">
                <animate attributeName="r" values="1;2;1" dur="3s" repeatCount="indefinite" />
                <animate attributeName="opacity" values="0.3;1;0.3" dur="3s" repeatCount="indefinite" />
              </circle>
              <circle cx="40" cy="60" r="1.5" fill="#a855f7">
                <animate attributeName="r" values="1.5;3;1.5" dur="5s" repeatCount="indefinite" />
                <animate attributeName="opacity" values="0.3;1;0.3" dur="5s" repeatCount="indefinite" />
              </circle>
              <circle cx="70" cy="30" r="1" fill="#a855f7">
                <animate attributeName="r" values="1;2;1" dur="4s" repeatCount="indefinite" />
                <animate attributeName="opacity" values="0.3;1;0.3" dur="4s" repeatCount="indefinite" />
              </circle>
              <circle cx="80" cy="70" r="1.2" fill="#a855f7">
                <animate attributeName="r" values="1.2;2.5;1.2" dur="6s" repeatCount="indefinite" />
                <animate attributeName="opacity" values="0.3;1;0.3" dur="6s" repeatCount="indefinite" />
              </circle>
              <circle cx="50" cy="40" r="1.8" fill="#a855f7">
                <animate attributeName="r" values="1.8;3.5;1.8" dur="7s" repeatCount="indefinite" />
                <animate attributeName="opacity" values="0.3;1;0.3" dur="7s" repeatCount="indefinite" />
              </circle>
            </svg>
          `,
          'enchanted': `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-full h-full">
              <path d="M30,30 Q50,10 70,30 Q90,50 70,70 Q50,90 30,70 Q10,50 30,30" stroke="#ec4899" stroke-width="1" fill="none">
                <animate attributeName="d" values="M30,30 Q50,10 70,30 Q90,50 70,70 Q50,90 30,70 Q10,50 30,30; M35,35 Q50,15 65,35 Q85,50 65,65 Q50,85 35,65 Q15,50 35,35; M30,30 Q50,10 70,30 Q90,50 70,70 Q50,90 30,70 Q10,50 30,30" dur="15s" repeatCount="indefinite" />
              </path>
              <circle cx="50" cy="50" r="3" fill="#ec4899">
                <animate attributeName="r" values="3;5;3" dur="10s" repeatCount="indefinite" />
                <animate attributeName="opacity" values="0.2;0.6;0.2" dur="10s" repeatCount="indefinite" />
              </circle>
            </svg>
          `
        };
        
        return decorations[habitat] || '';
      }
    }
  }
</script>

<style>
  /* Exhibition styling */
  .exhibition-header {
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
  }
  
  .exhibition-gallery {
    background-color: #fff;
  }
  
  .exhibition-item {
    transition: transform 0.3s ease;
  }
  
  .exhibition-item:hover {
    transform: translateY(-5px);
  }
  
  .artwork-frame {
    position: relative;
    cursor: pointer;
  }
  
  /* Habitat-specific styling */
  .habitat-forest .artwork-frame {
    border-color: rgba(34, 197, 94, 0.3);
  }
  
  .habitat-ocean .artwork-frame {
    border-color: rgba(59, 130, 246, 0.3);
  }
  
  .habitat-mountain .artwork-frame {
    border-color: rgba(239, 68, 68, 0.3);
  }
  
  .habitat-sky .artwork-frame {
    border-color: rgba(14, 165, 233, 0.3);
  }
  
  .habitat-cosmic .artwork-frame {
    border-color: rgba(168, 85, 247, 0.3);
  }
  
  .habitat-enchanted .artwork-frame {
    border-color: rgba(236, 72, 153, 0.3);
  }
  
  /* Animation for creature images */
  @keyframes float {
    0% {
      transform: translateY(0px);
    }
    50% {
      transform: translateY(-10px);
    }
    100% {
      transform: translateY(0px);
    }
  }
  
  .animate-float {
    animation: float 6s ease-in-out infinite;
  }
</style>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>