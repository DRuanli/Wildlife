<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="bg-gradient-to-b from-green-50 to-transparent min-h-screen py-12">
  <div class="container mx-auto px-4">
    <!-- Page Header -->
    <div class="text-center mb-12">
      <h1 class="headline headline-large mb-4 text-gray-900">Creature Gallery</h1>
      <p class="max-w-3xl mx-auto text-lg text-gray-600">Discover mythical creatures inspired by endangered wildlife. Each creature you nurture through focus helps support real-world conservation efforts.</p>
    </div>

    <!-- Gallery Controls -->
    <div x-data="galleryControls()" class="mb-10">
      <!-- Search & Filter Controls -->
      <div class="flex flex-col md:flex-row gap-4 mb-6">
        <!-- Search Bar -->
        <div class="relative flex-grow">
          <input 
            type="text" 
            x-model="searchQuery" 
            placeholder="Search creatures..." 
            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
          >
          <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
            <i class="fas fa-search"></i>
          </span>
        </div>

        <!-- Filter Dropdown -->
        <div class="relative w-full md:w-48">
          <select 
            x-model="activeFilter" 
            class="w-full py-3 px-4 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 appearance-none"
          >
            <option value="all">All Habitats</option>
            <option value="forest">Forest</option>
            <option value="ocean">Ocean</option>
            <option value="mountain">Mountain</option>
            <option value="sky">Sky</option>
            <option value="cosmic">Cosmic</option>
            <option value="enchanted">Enchanted</option>
          </select>
          <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
            <i class="fas fa-chevron-down"></i>
          </span>
        </div>

        <!-- Ownership Filter -->
        <div class="relative w-full md:w-48">
          <select 
            x-model="ownershipFilter" 
            class="w-full py-3 px-4 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 appearance-none"
          >
            <option value="all">All Creatures</option>
            <option value="owned">Owned Only</option>
            <option value="unowned">Unowned Only</option>
          </select>
          <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
            <i class="fas fa-chevron-down"></i>
          </span>
        </div>

        <!-- Stage Filter -->
        <div class="relative w-full md:w-48">
          <select 
            x-model="stageFilter" 
            class="w-full py-3 px-4 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 appearance-none"
          >
            <option value="all">All Stages</option>
            <option value="egg">Egg</option>
            <option value="baby">Baby</option>
            <option value="juvenile">Juvenile</option>
            <option value="adult">Adult</option>
            <option value="mythical">Mythical</option>
          </select>
          <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
            <i class="fas fa-chevron-down"></i>
          </span>
        </div>
      </div>

      <!-- Gallery Navigation/Sort -->
      <div class="flex flex-wrap justify-between items-center">
        <!-- Gallery Stats -->
        <div class="text-gray-600 mb-4 lg:mb-0">
          <template x-if="filteredCreatures.length === 1">
            <span>Showing <span class="font-semibold" x-text="filteredCreatures.length"></span> creature</span>
          </template>
          <template x-if="filteredCreatures.length !== 1">
            <span>Showing <span class="font-semibold" x-text="filteredCreatures.length"></span> creatures</span>
          </template>
        </div>

        <!-- Sort Controls -->
        <div class="flex items-center space-x-2">
          <span class="text-gray-600">Sort by:</span>
          <button 
            @click="sortBy('name')" 
            :class="sortField === 'name' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600'"
            class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-50 transition"
          >
            Name
            <template x-if="sortField === 'name' && !sortAsc">
              <i class="fas fa-arrow-down ml-1"></i>
            </template>
            <template x-if="sortField === 'name' && sortAsc">
              <i class="fas fa-arrow-up ml-1"></i>
            </template>
          </button>
          <button 
            @click="sortBy('rarity')" 
            :class="sortField === 'rarity' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600'"
            class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-50 transition"
          >
            Rarity
            <template x-if="sortField === 'rarity' && !sortAsc">
              <i class="fas fa-arrow-down ml-1"></i>
            </template>
            <template x-if="sortField === 'rarity' && sortAsc">
              <i class="fas fa-arrow-up ml-1"></i>
            </template>
          </button>
          <button 
            @click="toggleFavorites()" 
            :class="showOnlyFavorites ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-600'"
            class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-amber-50 transition"
          >
            <i class="fas fa-heart mr-1"></i> Favorites
          </button>
        </div>
      </div>
    </div>

    <!-- Gallery Grid -->
    <div 
      x-data="galleryData()" 
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
    >
      <!-- Creature Cards -->
      <template x-for="creature in filteredCreatures" :key="creature.id">
        <div 
          class="creature-card group rounded-xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
          :class="[
            getHabitatClasses(creature.habitat_type),
            {'opacity-100': creature.owned, 'opacity-60 grayscale': !creature.owned}
          ]"
        >
          <!-- Card Header with Habitat Type & Favorite Button -->
          <div class="flex justify-between items-center px-4 py-2 border-b border-gray-100">
            <span 
              class="text-xs font-medium px-2 py-1 rounded-full capitalize" 
              :class="getHabitatBadgeClasses(creature.habitat_type)"
              x-text="creature.habitat_type">
            </span>
            
            <button 
              @click.stop="toggleFavorite(creature.id)" 
              class="h-8 w-8 rounded-full flex items-center justify-center transition-colors"
              :class="isFavorite(creature.id) ? 'text-red-500 hover:text-red-400' : 'text-gray-300 hover:text-gray-400'"
            >
              <i class="fas fa-heart"></i>
            </button>
          </div>

          <!-- Creature Image Container -->
          <div 
            @click="openModal(creature.id)"
            class="relative h-48 overflow-hidden flex items-center justify-center cursor-pointer"
            :class="getHabitatBgClasses(creature.habitat_type)"
          >
            <!-- Animated background elements based on habitat -->
            <div class="absolute inset-0 opacity-20" x-html="getHabitatDecoration(creature.habitat_type)"></div>
            
            <!-- Creature Image -->
            <img 
              :src="getImagePath(creature.id, creature.stage)" 
              :alt="creature.name" 
              class="h-40 w-40 object-contain z-10 transition-transform group-hover:scale-110 duration-300"
            >
            
            <!-- Egg wobble or special effects based on stage -->
            <template x-if="creature.stage === 'egg'">
              <div class="absolute -top-1 -right-1 h-3 w-3 bg-green-400 rounded-full animate-ping"></div>
            </template>
          </div>

          <!-- Card Content -->
          <div class="p-4" :class="{'opacity-100': creature.owned, 'opacity-80': !creature.owned}">
            <!-- Creature Name & Stage -->
            <div class="flex justify-between items-start mb-2">
              <h3 class="font-medium" :class="{'text-gray-900': creature.owned, 'text-gray-600': !creature.owned}" x-text="creature.name"></h3>
              <div class="flex items-center space-x-1">
                <template x-if="creature.owned">
                  <span class="text-xs px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full">Owned</span>
                </template>
                <span 
                  class="text-xs px-2 py-1 rounded-full capitalize" 
                  :class="getStageBadgeClasses(creature.stage)"
                  x-text="creature.stage">
                </span>
              </div>
            </div>
            
            <!-- Rarity -->
            <div class="flex items-center mb-3">
              <template x-for="i in getRarityStars(creature.rarity)" :key="i">
                <i class="fas fa-star text-amber-400 text-xs"></i>
              </template>
              <span class="text-xs text-gray-500 ml-1 capitalize" x-text="creature.rarity"></span>
            </div>
            
            <!-- Species Description (truncated) -->
            <p class="text-sm text-gray-600 line-clamp-2 mb-3" x-text="creature.description"></p>
            
            <!-- Growth Progress (if not mythical) -->
            <template x-if="creature.stage !== 'mythical'">
              <div class="mt-2">
                <div class="flex justify-between text-xs text-gray-500 mb-1">
                  <span>Growth Progress</span>
                  <span x-text="creature.growth_progress + '%'"></span>
                </div>
                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                  <div 
                    class="h-full rounded-full" 
                    :class="getProgressBarColor(creature.stage)"
                    :style="'width: ' + creature.growth_progress + '%'"
                  ></div>
                </div>
              </div>
            </template>
            
            <!-- View Details Button -->
            <button 
              @click="openModal(creature.id)"
              class="w-full mt-4 py-2 text-sm font-medium text-center rounded-lg transition-colors"
              :class="getHabitatButtonClasses(creature.habitat_type)"
            >
              View Details
            </button>
          </div>
        </div>
      </template>

      <!-- Empty State - No Results -->
      <template x-if="filteredCreatures.length === 0">
        <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 py-16 text-center">
          <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
            <i class="fas fa-dragon text-3xl"></i>
          </div>
          <h3 class="text-xl font-medium text-gray-800 mb-2">No creatures found</h3>
          <p class="text-gray-600 mb-6">Try adjusting your filters or search terms</p>
          <button 
            @click="resetFilters()" 
            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
          >
            Reset Filters
          </button>
        </div>
      </template>
    </div>

    <!-- Creature Detail Modal -->
    <div 
      x-data="modalData()" 
      x-show="isOpen" 
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 transform scale-95"
      x-transition:enter-end="opacity-100 transform scale-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 transform scale-100"
      x-transition:leave-end="opacity-0 transform scale-95"
      @keydown.escape.window="closeModal()"
      class="fixed inset-0 z-50 overflow-y-auto"
      style="display: none;"
    >
      <!-- Modal Backdrop -->
      <div 
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" 
        @click="closeModal()"
      ></div>
      
      <!-- Modal Content -->
      <div class="relative min-h-screen flex items-center justify-center p-4">
        <div 
          class="relative bg-white rounded-2xl shadow-xl w-full max-w-4xl overflow-hidden max-h-[90vh] flex flex-col"
          @click.stop
        >
          <!-- Modal Header -->
          <div 
            class="flex justify-between items-center p-6 border-b"
            :class="selectedCreature ? getHabitatBorderClasses(selectedCreature.habitat_type) : ''"
          >
            <h3 class="text-2xl font-medium text-gray-900 flex items-center">
              <template x-if="selectedCreature">
                <span x-text="selectedCreature.name"></span>
              </template>
              <template x-if="selectedCreature">
                <span 
                  class="ml-3 text-xs px-2 py-1 rounded-full capitalize"
                  :class="selectedCreature ? getStageBadgeClasses(selectedCreature.stage) : ''"
                  x-text="selectedCreature ? selectedCreature.stage : ''"
                ></span>
              </template>
            </h3>
            <button @click="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
              <i class="fas fa-times text-xl"></i>
            </button>
          </div>
          
          <!-- Modal Body -->
          <div class="p-6 overflow-y-auto flex-grow">
            <template x-if="selectedCreature">
              <div class="flex flex-col md:flex-row gap-8">
                <!-- Creature Image & Details -->
                <div class="w-full md:w-2/5">
                  <!-- Creature Image Container -->
                  <div 
                    class="relative h-64 overflow-hidden rounded-xl flex items-center justify-center mb-4"
                    :class="getHabitatBgClasses(selectedCreature.habitat_type)"
                  >
                    <!-- Animated background elements based on habitat -->
                    <div class="absolute inset-0 opacity-20" x-html="getHabitatDecoration(selectedCreature.habitat_type)"></div>
                    
                    <!-- Creature Image -->
                    <img 
                      :src="getImagePath(selectedCreature.id, selectedCreature.stage)" 
                      :alt="selectedCreature.name" 
                      class="h-52 w-52 object-contain z-10 animate-float"
                    >
                  </div>
                  
                  <!-- Species Information -->
                  <div class="bg-gray-50 rounded-xl p-4">
                    <h4 class="font-medium text-gray-800 mb-2">Species Information</h4>
                    <div class="space-y-3">
                      <!-- Species -->
                      <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Species</span>
                        <span class="text-sm font-medium text-gray-800" x-text="selectedCreature.species_name"></span>
                      </div>
                      
                      <!-- Habitat -->
                      <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Habitat</span>
                        <span 
                          class="text-sm font-medium capitalize"
                          :class="getHabitatTextClasses(selectedCreature.habitat_type)"
                          x-text="selectedCreature.habitat_type"
                        ></span>
                      </div>
                      
                      <!-- Rarity -->
                      <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Rarity</span>
                        <div class="flex items-center">
                          <template x-for="i in getRarityStars(selectedCreature.rarity)" :key="i">
                            <i class="fas fa-star text-amber-400 text-xs"></i>
                          </template>
                          <span class="text-sm text-gray-800 ml-1 capitalize" x-text="selectedCreature.rarity"></span>
                        </div>
                      </div>
                      
                      <!-- Growth Progress (if not mythical) -->
                      <template x-if="selectedCreature.stage !== 'mythical'">
                        <div>
                          <div class="flex justify-between text-sm text-gray-500 mb-1">
                            <span>Growth Progress</span>
                            <span x-text="selectedCreature.growth_progress + '%'"></span>
                          </div>
                          <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div 
                              class="h-full rounded-full" 
                              :class="getProgressBarColor(selectedCreature.stage)"
                              :style="'width: ' + selectedCreature.growth_progress + '%'"
                            ></div>
                          </div>
                          <div class="text-xs text-gray-500 mt-1" x-text="getGrowthStatusText(selectedCreature)"></div>
                        </div>
                      </template>
                    </div>
                  </div>
                </div>
                
                <!-- Creature Description & Stats -->
                <div class="w-full md:w-3/5">
                  <!-- Species Description -->
                  <div class="mb-6">
                    <h4 class="font-medium text-gray-800 mb-2">Description</h4>
                    <p class="text-gray-600" x-text="selectedCreature.description"></p>
                  </div>
                  
                  <!-- Conservation Connection -->
                  <div class="mb-6">
                    <h4 class="font-medium text-gray-800 mb-2">Real-World Connection</h4>
                    <div class="bg-amber-50 rounded-xl p-4 relative overflow-hidden">
                      <!-- Decorative icon -->
                      <div class="absolute right-0 bottom-0 opacity-5 transform translate-x-1/4 translate-y-1/4">
                        <i class="fas fa-leaf text-9xl text-amber-800"></i>
                      </div>
                      
                      <div class="relative z-10">
                        <p class="italic mb-3">"<span x-text="selectedCreature.real_world_inspiration"></span>"</p>
                        <p class="text-gray-700" x-text="selectedCreature.conservation_fact"></p>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Creature Stats & Care -->
                  <div>
                    <h4 class="font-medium text-gray-800 mb-2">Care & Status</h4>
                    <div class="grid grid-cols-2 gap-4">
                      <!-- Health -->
                      <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex justify-between items-center mb-2">
                          <span class="text-sm text-gray-500">Health</span>
                          <span class="text-sm font-medium text-gray-800" x-text="selectedCreature.health + '%'"></span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                          <div 
                            class="h-full bg-red-500 rounded-full"
                            :style="'width: ' + selectedCreature.health + '%'"
                          ></div>
                        </div>
                      </div>
                      
                      <!-- Happiness -->
                      <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex justify-between items-center mb-2">
                          <span class="text-sm text-gray-500">Happiness</span>
                          <span class="text-sm font-medium text-gray-800" x-text="selectedCreature.happiness + '%'"></span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                          <div 
                            class="h-full bg-yellow-500 rounded-full"
                            :style="'width: ' + selectedCreature.happiness + '%'"
                          ></div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Last Interaction -->
                    <div class="mt-4 text-sm text-gray-500">
                      <template x-if="selectedCreature.last_interaction_at">
                        <div>Last interaction: <span x-text="formatDate(selectedCreature.last_interaction_at)"></span></div>
                      </template>
                      <template x-if="!selectedCreature.last_interaction_at">
                        <div>No interactions yet</div>
                      </template>
                    </div>
                  </div>
                </div>
              </div>
            </template>
          </div>
          
          <!-- Modal Footer -->
          <div class="p-6 border-t border-gray-200 flex justify-between">
            <button 
              @click="closeModal()" 
              class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
            >
              Close
            </button>
            
            <template x-if="selectedCreature">
              <div class="flex gap-2">
                <template x-if="selectedCreature.stage !== 'egg'">
                  <button
                    @click="interactWithCreature('feed')"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center"
                  >
                    <i class="fas fa-apple-alt mr-2"></i>
                    Feed
                  </button>
                </template>
                
                <template x-if="selectedCreature.stage !== 'egg'">
                  <button
                    @click="interactWithCreature('play')"
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center"
                  >
                    <i class="fas fa-gamepad mr-2"></i>
                    Play
                  </button>
                </template>
                
                <template x-if="selectedCreature.stage === 'egg' && selectedCreature.growth_progress >= 100">
                  <button
                    @click="interactWithCreature('hatch')"
                    class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors flex items-center"
                  >
                    <i class="fas fa-egg mr-2"></i>
                    Hatch
                  </button>
                </template>
                
                <template x-if="selectedCreature.stage !== 'egg' && selectedCreature.stage !== 'mythical' && selectedCreature.growth_progress >= 100">
                  <button
                    @click="interactWithCreature('evolve')"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center"
                  >
                    <i class="fas fa-level-up-alt mr-2"></i>
                    Evolve
                  </button>
                </template>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for Interactive Features -->
<script>
  // Gallery Controls Component
  function galleryControls() {
    return {
      searchQuery: '',
      activeFilter: 'all',
      stageFilter: 'all',
      ownershipFilter: 'all',
      sortField: 'name',
      sortAsc: true,
      showOnlyFavorites: false,
      
      sortBy(field) {
        if (this.sortField === field) {
          this.sortAsc = !this.sortAsc;
        } else {
          this.sortField = field;
          this.sortAsc = true;
        }
        
        // Dispatch a custom event to notify the gallery component
        window.dispatchEvent(new CustomEvent('gallery-sort', {
          detail: { field: this.sortField, asc: this.sortAsc }
        }));
      },
      
      toggleFavorites() {
        this.showOnlyFavorites = !this.showOnlyFavorites;
        
        // Dispatch a custom event to notify the gallery component
        window.dispatchEvent(new CustomEvent('gallery-filter-favorites', {
          detail: { showOnlyFavorites: this.showOnlyFavorites }
        }));
      },
      
      resetFilters() {
        this.searchQuery = '';
        this.activeFilter = 'all';
        this.stageFilter = 'all';
        this.showOnlyFavorites = false;
        this.ownershipFilter = 'all';
        
        // Dispatch custom events
        window.dispatchEvent(new CustomEvent('gallery-reset-filters'));
      }
    };
  }

  // Gallery Data Component
  function galleryData() {
    return {
      creatures: [
        {
          id: 1,
          name: "Aquaris",
          species_name: "Water Dragon",
          stage: "adult",
          health: 80,
          happiness: 90,
          growth_progress: 60,
          habitat_type: "ocean",
          rarity: "rare",
          owned: true, // This creature is owned by the user
          description: "A majestic water dragon with scales that shimmer like the ocean surface. Known for its ability to breathe underwater and control water currents.",
          real_world_inspiration: "Inspired by the endangered Leatherback Sea Turtle, the largest sea turtle species that can dive to depths of over 1,000 meters.",
          conservation_fact: "Leatherback Sea Turtles are critically endangered due to plastic pollution, fishing net entanglement, and habitat loss. Their population has declined by over 80% in the last century.",
          last_interaction_at: "2023-11-20 15:30:00"
        },
        {
          id: 2,
          name: "Starshifter",
          species_name: "Cosmic Wyvern",
          stage: "mythical",
          health: 100,
          happiness: 100,
          growth_progress: 100,
          habitat_type: "cosmic",
          rarity: "mythical",
          owned: true, // This creature is owned by the user
          description: "A celestial dragon whose scales contain the light of distant stars. It can traverse space and time, leaving trails of stardust in its wake.",
          real_world_inspiration: "Inspired by the Amur Leopard, one of the world's most endangered big cats with fewer than 100 individuals remaining in the wild.",
          conservation_fact: "The Amur Leopard faces threats from poaching, habitat loss, and fragmentation. Conservation efforts include anti-poaching measures and habitat protection in Russia and China.",
          last_interaction_at: "2023-11-21 09:15:00"
        },
        {
          id: 3,
          name: "Leafling",
          species_name: "Forest Sprite",
          stage: "baby",
          health: 95,
          happiness: 85,
          growth_progress: 45,
          habitat_type: "forest",
          rarity: "common",
          owned: true, // This creature is owned by the user
          description: "A small woodland creature with leaves growing from its body. It can blend perfectly with forest foliage and communicate with plants.",
          real_world_inspiration: "Inspired by the Giant Panda, a beloved symbol of wildlife conservation that relies on bamboo forests for survival.",
          conservation_fact: "While Giant Panda populations have increased slightly in recent years thanks to conservation efforts, they remain vulnerable due to habitat fragmentation and limited bamboo resources.",
          last_interaction_at: "2023-11-22 11:45:00"
        },
        {
          id: 4,
          name: "Mystery Egg",
          species_name: "Unknown",
          stage: "egg",
          health: 100,
          happiness: 100,
          growth_progress: 85,
          habitat_type: "mountain",
          rarity: "uncommon",
          owned: true, // This creature is owned by the user
          description: "A mysterious egg with a tough, stone-like shell that occasionally emits a warm glow. The creature inside seems to be growing stronger.",
          real_world_inspiration: "Inspired by the Snow Leopard, a highly elusive big cat adapted to the harsh mountain environments of Central Asia.",
          conservation_fact: "Snow Leopards face threats from poaching, retaliatory killings by herders, and habitat loss. There are estimated to be fewer than 10,000 mature individuals left in the wild.",
          last_interaction_at: null
        },
        {
          id: 5,
          name: "Skyweaver",
          species_name: "Wind Serpent",
          stage: "juvenile",
          health: 75,
          happiness: 92,
          growth_progress: 70,
          habitat_type: "sky",
          rarity: "rare",
          owned: false, // This creature is NOT owned by the user
          description: "A graceful serpentine creature that glides through the air by manipulating wind currents. Its body is almost transparent with subtle blue hues.",
          real_world_inspiration: "Inspired by the Philippine Eagle, one of the largest and most powerful birds of prey, critically endangered with fewer than 400 pairs remaining.",
          conservation_fact: "The Philippine Eagle faces threats from deforestation, hunting, and climate change. Each breeding pair requires a large territory of old-growth forest to survive.",
          last_interaction_at: "2023-11-19 16:20:00"
        },
        {
          id: 6,
          name: "Emberhorn",
          species_name: "Lava Stag",
          stage: "adult",
          health: 88,
          happiness: 76,
          growth_progress: 50,
          habitat_type: "mountain",
          rarity: "uncommon",
          owned: false, // This creature is NOT owned by the user
          description: "A majestic stag with antlers of molten lava and hooves that leave smoldering footprints. Despite its fiery appearance, it's gentle and protective.",
          real_world_inspiration: "Inspired by the Saola, often called the 'Asian unicorn' - one of the world's rarest mammals discovered only in 1992.",
          conservation_fact: "The Saola is critically endangered and notoriously difficult to study. Scientists estimate fewer than 100 individuals remain in the forests of Vietnam and Laos.",
          last_interaction_at: "2023-11-18 10:05:00"
        },
        {
          id: 7,
          name: "Whisperleaf",
          species_name: "Enchanted Fern",
          stage: "juvenile",
          health: 92,
          happiness: 96,
          growth_progress: 65,
          habitat_type: "enchanted",
          rarity: "uncommon",
          owned: false, // This creature is NOT owned by the user
          description: "A sentient plant-creature that communicates through soft rustling sounds. Its leaves glow with magical light when it's happy.",
          real_world_inspiration: "Inspired by the Venus Flytrap, one of the world's most famous carnivorous plants native to a small region in North and South Carolina.",
          conservation_fact: "Wild Venus Flytraps are vulnerable due to habitat loss and poaching for the plant trade. They only naturally grow in a small area of about 120 square kilometers.",
          last_interaction_at: "2023-11-17 14:30:00"
        },
        {
          id: 8,
          name: "Corallium",
          species_name: "Reef Guardian",
          stage: "egg",
          health: 100,
          happiness: 100,
          growth_progress: 25,
          habitat_type: "ocean",
          rarity: "legendary",
          owned: false, // This creature is NOT owned by the user
          description: "This rare egg pulses with blue and pink light, and seems to be growing a protective coral-like shell. Something powerful sleeps inside.",
          real_world_inspiration: "Inspired by coral reefs, which are living organisms that provide habitat for nearly 25% of all marine species despite covering less than 1% of the ocean floor.",
          conservation_fact: "Coral reefs worldwide are threatened by climate change, ocean acidification, pollution, and destructive fishing practices. Some regions have lost over 50% of their coral coverage in recent decades.",
          last_interaction_at: null
        },
        {
          id: 9,
          name: "Lunaris",
          species_name: "Moon Owl",
          stage: "baby",
          health: 85,
          happiness: 90,
          growth_progress: 30,
          habitat_type: "cosmic",
          rarity: "rare",
          owned: false, // This creature is NOT owned by the user
          description: "A small owl with feathers that shimmer like moonlight. Its eyes appear to contain tiny galaxies, and it hoots in a musical, ethereal tone.",
          real_world_inspiration: "Inspired by the endangered Blakiston's Fish Owl, the largest owl species which needs old-growth forests near clean rivers to survive.",
          conservation_fact: "Blakiston's Fish Owls are endangered with only a few thousand remaining in Russia, China, and Japan. They require large territories with old trees for nesting and unpolluted rivers for fishing.",
          last_interaction_at: "2023-11-16 18:45:00"
        },
        {
          id: 10,
          name: "Thornheart",
          species_name: "Forest Guardian",
          stage: "mythical",
          health: 100,
          happiness: 100,
          growth_progress: 100,
          habitat_type: "forest",
          rarity: "legendary",
          owned: false, // This creature is NOT owned by the user
          description: "An ancient woodland spirit with bark-like skin and branches growing from its shoulders. It can command nearby plants and trees to protect the forest.",
          real_world_inspiration: "Inspired by the Sumatran Orangutan, a critically endangered great ape that spends most of its life in the trees of Indonesian rainforests.",
          conservation_fact: "Sumatran Orangutans have lost over 80% of their habitat in the last 50 years, primarily due to palm oil plantations, logging, and human encroachment.",
          last_interaction_at: "2023-11-15 12:10:00"
        },
        {
          id: 11,
          name: "Shimmerscale",
          species_name: "Crystal Serpent",
          stage: "adult",
          health: 94,
          happiness: 88,
          growth_progress: 75,
          habitat_type: "enchanted",
          rarity: "rare",
          owned: true, // This creature is owned by the user
          description: "A serpent with scales made of living crystal that change color with its mood. It can channel magical energies and create dazzling light displays.",
          real_world_inspiration: "Inspired by the Chinese Giant Salamander, the world's largest amphibian that can grow up to 6 feet long.",
          conservation_fact: "Chinese Giant Salamanders are critically endangered due to habitat destruction, pollution, and over-harvesting for traditional medicine and food. Wild populations have declined by over 80% since the 1950s.",
          last_interaction_at: "2023-11-14 09:30:00"
        },
        {
          id: 12,
          name: "Cloudracer",
          species_name: "Sky Dolphin",
          stage: "juvenile",
          health: 82,
          happiness: 95,
          growth_progress: 60,
          habitat_type: "sky",
          rarity: "uncommon",
          owned: true, // This creature is owned by the user
          description: "A playful creature that resembles a dolphin but swims through the air instead of water. It can create small rainclouds when excited.",
          real_world_inspiration: "Inspired by the Vaquita, the world's most endangered marine mammal with fewer than 10 individuals remaining in the wild.",
          conservation_fact: "The Vaquita's population has collapsed due to illegal fishing practices in the Gulf of California. Despite protection efforts, their numbers continue to decline dramatically.",
          last_interaction_at: "2023-11-13 15:50:00"
        }
      ],
      favorites: [],
      filteredCreatures: [],
      searchQuery: '',
      activeFilter: 'all',
      stageFilter: 'all',
      ownershipFilter: 'all',
      sortField: 'name',
      sortAsc: true,
      showOnlyFavorites: false,
      
      init() {
        // Initialize favorites from localStorage if available
        const storedFavorites = localStorage.getItem('wildlife_favorites');
        if (storedFavorites) {
          this.favorites = JSON.parse(storedFavorites);
        }
        
        // Apply initial filtering and sorting
        this.filteredCreatures = [...this.creatures];
        this.applyFilters();
        
        // Listen for filter changes
        this.$watch('searchQuery', () => this.applyFilters());
        this.$watch('activeFilter', () => this.applyFilters());
        this.$watch('stageFilter', () => this.applyFilters());
        this.$watch('ownershipFilter', () => this.applyFilters());
        
        // Listen for custom events from other components
        window.addEventListener('gallery-sort', (e) => {
          this.sortField = e.detail.field;
          this.sortAsc = e.detail.asc;
          this.applyFilters();
        });
        
        window.addEventListener('gallery-filter-favorites', (e) => {
          this.showOnlyFavorites = e.detail.showOnlyFavorites;
          this.applyFilters();
        });
        
        window.addEventListener('gallery-reset-filters', () => {
          this.searchQuery = '';
          this.activeFilter = 'all';
          this.stageFilter = 'all';
          this.showOnlyFavorites = false;
          this.applyFilters();
        });
      },
      
      applyFilters() {
        let result = [...this.creatures];
        
        // Apply text search
        if (this.searchQuery.trim() !== '') {
          const query = this.searchQuery.toLowerCase();
          result = result.filter(creature => 
            creature.name.toLowerCase().includes(query) || 
            creature.species_name.toLowerCase().includes(query) ||
            creature.description.toLowerCase().includes(query)
          );
        }
        
        // Apply habitat filter
        if (this.activeFilter !== 'all') {
          result = result.filter(creature => creature.habitat_type === this.activeFilter);
        }
        
        // Apply stage filter
        if (this.stageFilter !== 'all') {
          result = result.filter(creature => creature.stage === this.stageFilter);
        }
        
        // Apply ownership filter
        if (this.ownershipFilter !== 'all') {
          const isOwned = this.ownershipFilter === 'owned';
          result = result.filter(creature => creature.owned === isOwned);
        }
        
        // Apply favorites filter
        if (this.showOnlyFavorites) {
          result = result.filter(creature => this.favorites.includes(creature.id));
        }
        
        // Apply sorting
        result.sort((a, b) => {
          let comparison = 0;
          
          if (this.sortField === 'name') {
            comparison = a.name.localeCompare(b.name);
          } else if (this.sortField === 'rarity') {
            const rarityOrder = { 'common': 1, 'uncommon': 2, 'rare': 3, 'legendary': 4, 'mythical': 5 };
            comparison = rarityOrder[a.rarity] - rarityOrder[b.rarity];
          }
          
          return this.sortAsc ? comparison : -comparison;
        });
        
        this.filteredCreatures = result;
      },
      
      toggleFavorite(creatureId) {
        const index = this.favorites.indexOf(creatureId);
        
        if (index === -1) {
          // Add to favorites
          this.favorites.push(creatureId);
        } else {
          // Remove from favorites
          this.favorites.splice(index, 1);
        }
        
        // Save to localStorage
        localStorage.setItem('wildlife_favorites', JSON.stringify(this.favorites));
        
        // Re-apply filters if we're showing only favorites
        if (this.showOnlyFavorites) {
          this.applyFilters();
        }
      },
      
      isFavorite(creatureId) {
        return this.favorites.includes(creatureId);
      },
      
      openModal(creatureId) {
        // Dispatch custom event to open modal with the selected creature
        window.dispatchEvent(new CustomEvent('open-creature-modal', {
          detail: { creatureId }
        }));
      },
      
      // Helper functions for styling based on creature properties
      getHabitatClasses(habitatType) {
        return {
          'border-l-4': true,
          'border-forest': habitatType === 'forest',
          'border-ocean': habitatType === 'ocean',
          'border-mountain': habitatType === 'mountain',
          'border-sky': habitatType === 'sky',
          'border-cosmic': habitatType === 'cosmic',
          'border-enchanted': habitatType === 'enchanted',
        };
      },
      
      getHabitatBgClasses(habitatType) {
        return {
          'bg-green-50': habitatType === 'forest',
          'bg-blue-50': habitatType === 'ocean',
          'bg-red-50': habitatType === 'mountain',
          'bg-cyan-50': habitatType === 'sky',
          'bg-purple-50': habitatType === 'cosmic',
          'bg-pink-50': habitatType === 'enchanted',
        };
      },
      
      getHabitatBadgeClasses(habitatType) {
        return {
          'bg-green-100 text-green-800': habitatType === 'forest',
          'bg-blue-100 text-blue-800': habitatType === 'ocean',
          'bg-red-100 text-red-800': habitatType === 'mountain',
          'bg-cyan-100 text-cyan-800': habitatType === 'sky',
          'bg-purple-100 text-purple-800': habitatType === 'cosmic',
          'bg-pink-100 text-pink-800': habitatType === 'enchanted',
        };
      },
      
      getHabitatButtonClasses(habitatType) {
        return {
          'bg-green-100 hover:bg-green-200 text-green-800': habitatType === 'forest',
          'bg-blue-100 hover:bg-blue-200 text-blue-800': habitatType === 'ocean',
          'bg-red-100 hover:bg-red-200 text-red-800': habitatType === 'mountain',
          'bg-cyan-100 hover:bg-cyan-200 text-cyan-800': habitatType === 'sky',
          'bg-purple-100 hover:bg-purple-200 text-purple-800': habitatType === 'cosmic',
          'bg-pink-100 hover:bg-pink-200 text-pink-800': habitatType === 'enchanted',
        };
      },
      
      getStageBadgeClasses(stage) {
        return {
          'bg-yellow-100 text-yellow-800': stage === 'egg',
          'bg-blue-100 text-blue-800': stage === 'baby',
          'bg-green-100 text-green-800': stage === 'juvenile',
          'bg-purple-100 text-purple-800': stage === 'adult',
          'bg-red-100 text-red-800': stage === 'mythical',
        };
      },
      
      getProgressBarColor(stage) {
        return {
          'bg-yellow-400': stage === 'egg',
          'bg-blue-500': stage === 'baby',
          'bg-green-500': stage === 'juvenile',
          'bg-purple-500': stage === 'adult',
        };
      },
      
      getHabitatTextClasses(habitatType) {
        return {
          'text-forest': habitatType === 'forest',
          'text-ocean': habitatType === 'ocean',
          'text-mountain': habitatType === 'mountain',
          'text-sky': habitatType === 'sky',
          'text-cosmic': habitatType === 'cosmic',
          'text-enchanted': habitatType === 'enchanted',
        };
      },
      
      getHabitatBorderClasses(habitatType) {
        return {
          'border-forest': habitatType === 'forest',
          'border-ocean': habitatType === 'ocean',
          'border-mountain': habitatType === 'mountain',
          'border-sky': habitatType === 'sky',
          'border-cosmic': habitatType === 'cosmic',
          'border-enchanted': habitatType === 'enchanted',
        };
      },
      
      getImagePath(creatureId, stage) {
        // In a real implementation, this would return the correct image path
        return `/Wildlife/images/creatures/${creatureId}_${stage}.png`;
      },
      
      getRarityStars(rarity) {
        const rarityStars = {
          'common': 1,
          'uncommon': 2,
          'rare': 3,
          'legendary': 4,
          'mythical': 5
        };
        
        return rarityStars[rarity] || 1;
      },
      
      getHabitatDecoration(habitatType) {
        // Return SVG decorations based on habitat type
        switch(habitatType) {
          case 'forest':
            return `
              <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                <path d="M20,20 Q30,5 40,20 Q50,35 60,20 Q70,5 80,20" stroke="#22c55e" stroke-width="1" fill="none">
                  <animate attributeName="d" values="M20,20 Q30,5 40,20 Q50,35 60,20 Q70,5 80,20; M20,25 Q30,10 40,25 Q50,40 60,25 Q70,10 80,25; M20,20 Q30,5 40,20 Q50,35 60,20 Q70,5 80,20" dur="8s" repeatCount="indefinite" />
                </path>
              </svg>
            `;
          case 'ocean':
            return `
              <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                <path d="M0,50 Q25,40 50,50 Q75,60 100,50 L100,100 L0,100 Z" fill="#3B82F6" class="animate-pulse">
                  <animate attributeName="d" values="M0,50 Q25,40 50,50 Q75,60 100,50 L100,100 L0,100 Z; M0,50 Q25,60 50,50 Q75,40 100,50 L100,100 L0,100 Z; M0,50 Q25,40 50,50 Q75,60 100,50 L100,100 L0,100 Z" dur="10s" repeatCount="indefinite" />
                </path>
              </svg>
            `;
          case 'mountain':
            return `
              <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                <polygon points="20,80 35,30 50,65 65,20 80,80" fill="none" stroke="#ef4444" stroke-width="1">
                  <animate attributeName="points" values="20,80 35,30 50,65 65,20 80,80; 20,80 35,35 50,60 65,25 80,80; 20,80 35,30 50,65 65,20 80,80" dur="12s" repeatCount="indefinite" />
                </polygon>
              </svg>
            `;
          case 'sky':
            return `
              <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                <path d="M20,40 Q30,20 40,40 Q50,60 60,40 Q70,20 80,40" stroke="#0ea5e9" stroke-width="1" fill="none">
                  <animate attributeName="d" values="M20,40 Q30,20 40,40 Q50,60 60,40 Q70,20 80,40; M20,45 Q30,25 40,45 Q50,65 60,45 Q70,25 80,45; M20,40 Q30,20 40,40 Q50,60 60,40 Q70,20 80,40" dur="6s" repeatCount="indefinite" />
                </path>
                <circle cx="30" cy="30" r="2" fill="#0ea5e9">
                  <animate attributeName="opacity" values="0;1;0" dur="4s" repeatCount="indefinite" />
                </circle>
                <circle cx="70" cy="45" r="1" fill="#0ea5e9">
                  <animate attributeName="opacity" values="0;1;0" dur="5s" repeatCount="indefinite" />
                </circle>
                <circle cx="50" cy="20" r="1.5" fill="#0ea5e9">
                  <animate attributeName="opacity" values="0;1;0" dur="3s" repeatCount="indefinite" />
                </circle>
              </svg>
            `;
          case 'cosmic':
            return `
              <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                <circle cx="30" cy="30" r="2" fill="#a855f7">
                  <animate attributeName="opacity" values="0;1;0" dur="4s" repeatCount="indefinite" />
                </circle>
                <circle cx="70" cy="45" r="1" fill="#a855f7">
                  <animate attributeName="opacity" values="0;1;0" dur="5s" repeatCount="indefinite" />
                </circle>
                <circle cx="50" cy="20" r="1.5" fill="#a855f7">
                  <animate attributeName="opacity" values="0;1;0" dur="3s" repeatCount="indefinite" />
                </circle>
                <circle cx="25" cy="60" r="1" fill="#a855f7">
                  <animate attributeName="opacity" values="0;1;0" dur="6s" repeatCount="indefinite" />
                </circle>
                <circle cx="80" cy="25" r="2" fill="#a855f7">
                  <animate attributeName="opacity" values="0;1;0" dur="7s" repeatCount="indefinite" />
                </circle>
              </svg>
            `;
          case 'enchanted':
            return `
              <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                <path d="M30,30 Q50,10 70,30 Q90,50 70,70 Q50,90 30,70 Q10,50 30,30" stroke="#ec4899" stroke-width="1" fill="none">
                  <animate attributeName="d" values="M30,30 Q50,10 70,30 Q90,50 70,70 Q50,90 30,70 Q10,50 30,30; M35,35 Q50,15 65,35 Q85,50 65,65 Q50,85 35,65 Q15,50 35,35; M30,30 Q50,10 70,30 Q90,50 70,70 Q50,90 30,70 Q10,50 30,30" dur="10s" repeatCount="indefinite" />
                </path>
                <circle cx="50" cy="50" r="2" fill="#ec4899">
                  <animate attributeName="r" values="2;3;2" dur="4s" repeatCount="indefinite" />
                </circle>
              </svg>
            `;
          default:
            return '';
        }
      }
    };
  }

  // Modal Component
  function modalData() {
    return {
      isOpen: false,
      selectedCreature: null,
      
      init() {
        // Listen for open modal event
        window.addEventListener('open-creature-modal', (e) => {
          this.openModal(e.detail.creatureId);
        });
      },
      
      openModal(creatureId) {
        // Find the creature in the gallery data
        const galleryComponent = document.querySelector('[x-data="galleryData()"]').__x.$data;
        this.selectedCreature = galleryComponent.creatures.find(c => c.id === creatureId);
        
        if (this.selectedCreature) {
          this.isOpen = true;
          // Prevent scrolling on body
          document.body.style.overflow = 'hidden';
        }
      },
      
      closeModal() {
        this.isOpen = false;
        this.selectedCreature = null;
        // Re-enable scrolling
        document.body.style.overflow = '';
      },
      
      interactWithCreature(action) {
        // This is where we would update the creature based on the action
        // In a real application, this would call an API endpoint
        
        const creatureId = this.selectedCreature.id;
        
        switch(action) {
          case 'feed':
            // Increase health
            this.selectedCreature.health = Math.min(100, this.selectedCreature.health + 10);
            break;
          case 'play':
            // Increase happiness
            this.selectedCreature.happiness = Math.min(100, this.selectedCreature.happiness + 10);
            break;
          case 'hatch':
            // Change stage from egg to baby
            this.selectedCreature.stage = 'baby';
            this.selectedCreature.growth_progress = 0;
            break;
          case 'evolve':
            // Progress to next stage
            const stages = ['egg', 'baby', 'juvenile', 'adult', 'mythical'];
            const currentIndex = stages.indexOf(this.selectedCreature.stage);
            if (currentIndex < stages.length - 1) {
              this.selectedCreature.stage = stages[currentIndex + 1];
              this.selectedCreature.growth_progress = 0;
            }
            break;
        }
        
        // Update last interaction time
        this.selectedCreature.last_interaction_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
        
        // Show a notification
        this.showNotification(`Successfully ${action}ed ${this.selectedCreature.name}!`);
        
        // Update the creature in the gallery data
        const galleryComponent = document.querySelector('[x-data="galleryData()"]').__x.$data;
        const creatureIndex = galleryComponent.creatures.findIndex(c => c.id === creatureId);
        if (creatureIndex !== -1) {
          galleryComponent.creatures[creatureIndex] = {...this.selectedCreature};
          galleryComponent.applyFilters(); // Re-filter and sort
        }
      },
      
      showNotification(message) {
        // Create a notification element
        const notification = document.createElement('div');
        notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-500';
        notification.textContent = message;
        
        // Add to the document
        document.body.appendChild(notification);
        
        // Remove after a delay
        setTimeout(() => {
          notification.style.opacity = '0';
          setTimeout(() => {
            document.body.removeChild(notification);
          }, 500);
        }, 3000);
      },
      
      formatDate(dateString) {
        if (!dateString) return 'N/A';
        
        const date = new Date(dateString);
        return date.toLocaleString('en-US', {
          year: 'numeric',
          month: 'short',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        });
      },
      
      getGrowthStatusText(creature) {
        if (creature.stage === 'mythical') {
          return 'Fully evolved';
        }
        
        if (creature.growth_progress >= 100) {
          const nextStage = {
            'egg': 'baby',
            'baby': 'juvenile',
            'juvenile': 'adult',
            'adult': 'mythical'
          }[creature.stage];
          
          return `Ready to evolve to ${nextStage}!`;
        }
        
        return `Focus more to help ${creature.name} grow`;
      },
      
      // Re-use helper functions from gallery component
      getHabitatBgClasses: galleryData().getHabitatBgClasses,
      getHabitatTextClasses: galleryData().getHabitatTextClasses,
      getHabitatBorderClasses: galleryData().getHabitatBorderClasses,
      getStageBadgeClasses: galleryData().getStageBadgeClasses,
      getProgressBarColor: galleryData().getProgressBarColor,
      getImagePath: galleryData().getImagePath,
      getRarityStars: galleryData().getRarityStars,
      getHabitatDecoration: galleryData().getHabitatDecoration
    };
  }
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>