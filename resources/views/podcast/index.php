<?php
// Path: resources/views/podcast/index.php
$baseUrl = $data['baseUrl'] ?? '/Wildlife';
?>

<?php include ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Immersive Hero Section with Blur Background -->
<section class="relative overflow-hidden">
  <!-- Background Image with Blur -->
  <?php if (isset($data['featuredPodcast']) && $data['featuredPodcast']): ?>
  <div class="absolute inset-0 bg-gradient-to-b from-gray-900 to-primary">
    <div class="absolute inset-0 opacity-40 bg-blend-multiply" style="background-image: url('<?= $data['featuredPodcast']['image_url'] ?>'); background-size: cover; background-position: center; filter: blur(40px);"></div>
  </div>
  <?php else: ?>
  <div class="absolute inset-0 bg-gradient-to-b from-gray-900 to-primary"></div>
  <?php endif; ?>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-12 md:py-20 relative z-10">
    <!-- Podcast Header -->
    <div class="flex flex-col md:flex-row items-start md:items-end mb-10">
      <!-- Podcast Icon -->
      <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8">
        <div class="w-48 h-48 rounded-xl shadow-2xl overflow-hidden border-4 border-white/10">
          <img src="<?= $baseUrl ?>/assets/images/podcast/podcast-cover.jpg" alt="Wild Echoes Podcast" class="w-full h-full object-cover">
        </div>
      </div>
      
      <!-- Podcast Info -->
      <div class="flex-grow text-white">
        <div class="flex items-center mb-2">
          <span class="text-sm bg-secondary text-primary px-3 py-1 rounded-full font-medium mr-2">PODCAST</span>
          <span class="text-gray-300 flex items-center">
            <i class="fas fa-headphones mr-1"></i> <?= count($data['podcasts']) + 42 ?> Episodes
          </span>
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold mb-3">Wild Echoes</h1>
        <p class="text-xl md:text-2xl text-gray-200 mb-4">Exploring wildlife conservation through mindful conversations</p>
        
        <div class="flex flex-wrap items-center gap-2 md:gap-6 text-sm md:text-base text-gray-300 mb-4">
          <div class="flex items-center">
            <img src="<?= $baseUrl ?>/assets/images/podcast/host1.jpg" alt="Dr. Sarah Chen" class="w-7 h-7 rounded-full mr-2">
            <span>Dr. Sarah Chen</span>
          </div>
          <div class="flex items-center">
            <img src="<?= $baseUrl ?>/assets/images/podcast/host2.jpg" alt="Alex Rivera" class="w-7 h-7 rounded-full mr-2">
            <span>Alex Rivera</span>
          </div>
          <div class="flex items-center">
            <i class="fas fa-calendar-alt mr-2"></i>
            <span>Updated Weekly</span>
          </div>
          <div class="flex items-center">
            <i class="fas fa-star text-yellow-400 mr-1"></i>
            <i class="fas fa-star text-yellow-400 mr-1"></i>
            <i class="fas fa-star text-yellow-400 mr-1"></i>
            <i class="fas fa-star text-yellow-400 mr-1"></i>
            <i class="fas fa-star-half-alt text-yellow-400 mr-1"></i>
            <span>(452)</span>
          </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3">
          <button class="px-6 py-3 bg-primary hover:bg-opacity-80 text-white rounded-full font-medium transition flex items-center">
            <i class="fas fa-play mr-2"></i> Play Latest
          </button>
          <button class="px-6 py-3 bg-white/10 backdrop-blur hover:bg-white/20 text-white rounded-full font-medium transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Follow
          </button>
          <button class="p-3 bg-white/10 backdrop-blur hover:bg-white/20 text-white rounded-full transition">
            <i class="fas fa-share-alt"></i>
          </button>
          <button class="p-3 bg-white/10 backdrop-blur hover:bg-white/20 text-white rounded-full transition">
            <i class="fas fa-ellipsis-h"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sticky Player for Featured Episode -->
<?php if (isset($data['featuredPodcast']) && $data['featuredPodcast']): ?>
<div id="sticky-player" class="bg-gray-900/90 backdrop-blur-md border-t border-b border-white/10 sticky top-0 z-40 transition-all duration-300 transform translate-y-0">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between py-3">
      <!-- Episode Info -->
      <div class="flex items-center">
        <img src="<?= $data['featuredPodcast']['image_url'] ?>" alt="Featured Episode" class="w-12 h-12 rounded-md mr-3">
        <div class="mr-6">
          <h3 class="text-white font-medium text-sm md:text-base line-clamp-1"><?= htmlspecialchars($data['featuredPodcast']['title'] ?? '') ?></h3>
          <p class="text-gray-400 text-xs">Episode <?= count($data['podcasts']) + 42 - array_search($data['featuredPodcast']['id'], array_column($data['podcasts'], 'id')) ?></p>
        </div>
      </div>
      
      <!-- Player Controls -->
      <div class="flex-grow hidden md:flex items-center max-w-2xl">
        <button class="text-white mx-2 focus:outline-none">
          <i class="fas fa-step-backward"></i>
        </button>
        <button class="text-white mx-2 w-8 h-8 bg-white/10 rounded-full flex items-center justify-center play-button" data-audio="<?= $data['featuredPodcast']['audio_url'] ?>">
          <i class="fas fa-play"></i>
        </button>
        <button class="text-white mx-2 focus:outline-none">
          <i class="fas fa-step-forward"></i>
        </button>
        
        <!-- Progress Bar -->
        <div class="mx-4 flex-grow flex items-center">
          <span class="text-xs text-gray-400 mr-2 w-8 text-right current-time">0:00</span>
          <div class="relative h-1 bg-white/20 rounded-full flex-grow overflow-hidden group cursor-pointer">
            <div class="absolute left-0 top-0 h-full bg-secondary progress-bar" style="width: 0%"></div>
            <div class="absolute left-0 top-0 h-full w-4 rounded-full bg-secondary opacity-0 group-hover:opacity-100 transition progress-handle" style="transform: translateX(-50%)"></div>
          </div>
          <span class="text-xs text-gray-400 ml-2 w-8"><?= gmdate("i:s", $data['featuredPodcast']['duration']) ?></span>
        </div>
        
        <div class="flex items-center">
          <button class="text-white mx-1 focus:outline-none" title="Playback Speed">
            <span class="text-xs font-medium">1.0x</span>
          </button>
          <button class="text-white mx-1 focus:outline-none" title="Volume">
            <i class="fas fa-volume-up"></i>
          </button>
        </div>
      </div>
      
      <!-- Mobile Play Button -->
      <button class="md:hidden text-white w-10 h-10 bg-white/10 rounded-full flex items-center justify-center play-button-mobile" data-audio="<?= $data['featuredPodcast']['audio_url'] ?>">
        <i class="fas fa-play"></i>
      </button>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Advanced Filter and Search Bar -->
<div class="bg-white sticky top-0 z-30 shadow-sm" id="filter-section">
  <div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row md:items-center py-4 gap-4">
      <!-- View Toggle -->
      <div class="flex items-center mr-6">
        <button id="masonry-view-btn" class="p-2 text-primary hover:bg-gray-100 rounded-md active">
          <i class="fas fa-th-large"></i>
        </button>
        <button id="list-view-btn" class="p-2 text-gray-500 hover:bg-gray-100 rounded-md">
          <i class="fas fa-list"></i>
        </button>
      </div>
      
      <!-- Filter Dropdown -->
      <div class="relative group mr-4">
        <button class="flex items-center px-4 py-2 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-50 transition">
          <i class="fas fa-filter mr-2"></i>
          <span>Filters</span>
          <i class="fas fa-chevron-down ml-2 text-xs"></i>
        </button>
        
        <div class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-10">
          <div class="p-4">
            <h4 class="font-semibold mb-2">Categories</h4>
            <div class="space-y-2">
              <?php foreach ($data['categories'] as $category): ?>
              <label class="flex items-center cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-primary rounded border-gray-300" 
                       <?= ($data['currentCategory'] ?? '') === $category['slug'] ? 'checked' : '' ?>>
                <span class="ml-2 text-gray-700"><?= htmlspecialchars($category['name'] ?? '') ?></span>
              </label>
              <?php endforeach; ?>
            </div>
            
            <h4 class="font-semibold mt-4 mb-2">Duration</h4>
            <div class="space-y-2">
              <label class="flex items-center cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-primary rounded border-gray-300">
                <span class="ml-2 text-gray-700">< 30 min</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-primary rounded border-gray-300">
                <span class="ml-2 text-gray-700">30-60 min</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-primary rounded border-gray-300">
                <span class="ml-2 text-gray-700">> 60 min</span>
              </label>
            </div>
            
            <div class="mt-4 flex justify-between">
              <button class="text-sm text-gray-500 hover:text-gray-700">Reset</button>
              <button class="px-3 py-1 bg-primary text-white rounded text-sm">Apply</button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Sort Dropdown -->
      <div class="relative group mr-4">
        <button class="flex items-center px-4 py-2 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-50 transition">
          <i class="fas fa-sort mr-2"></i>
          <span>Newest First</span>
          <i class="fas fa-chevron-down ml-2 text-xs"></i>
        </button>
        
        <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-10">
          <div class="py-2">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Newest First</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Oldest First</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Most Popular</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Duration (Shortest)</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Duration (Longest)</a>
          </div>
        </div>
      </div>
      
      <!-- Category Pills -->
      <div class="flex-grow overflow-x-auto pb-2 md:pb-0 hide-scrollbar">
        <div class="flex space-x-2">
          <a href="<?= $baseUrl ?>/podcast" 
             class="shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors <?= empty($data['currentCategory']) ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
            All Episodes
          </a>
          
          <?php foreach ($data['categories'] as $category): ?>
          <a href="<?= $baseUrl ?>/podcast/category/<?= $category['slug'] ?>" 
             class="shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors <?= ($data['currentCategory'] ?? '') === $category['slug'] ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
            <?= htmlspecialchars($category['name'] ?? '') ?>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
      
      <!-- Search Input -->
      <form action="<?= $baseUrl ?>/podcast" method="GET" class="relative w-full md:w-64 flex-shrink-0">
        <input type="text" name="search" placeholder="Search episodes..." value="<?= htmlspecialchars($data['search'] ?? '') ?>" 
               class="w-full py-2 pl-10 pr-4 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
        <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Main Content Section -->
<section class="py-8 bg-gray-50">
  <div class="container mx-auto px-4">
    <!-- Featured Section -->
    <?php if (isset($data['featuredPodcast']) && $data['featuredPodcast']): ?>
    <div class="mb-12">
      <h2 class="text-2xl font-display font-bold mb-6 flex items-center">
        <i class="fas fa-fire text-orange-500 mr-2"></i> Featured Episode
      </h2>
      
      <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:shadow-xl">
        <div class="flex flex-col md:flex-row">
          <div class="md:w-2/5 relative">
            <img src="<?= $data['featuredPodcast']['image_url'] ?>" alt="<?= htmlspecialchars($data['featuredPodcast']['title']) ?>" 
                 class="w-full h-64 md:h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
              <div class="p-6">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-secondary text-primary mb-2">
                  Featured
                </span>
                <h3 class="text-xl md:text-2xl font-bold text-white mb-1">
                  <?= htmlspecialchars($data['featuredPodcast']['title'] ?? '') ?>
                </h3>
                <p class="text-gray-300 text-sm">
                  Episode <?= count($data['podcasts']) + 42 - array_search($data['featuredPodcast']['id'], array_column($data['podcasts'], 'id')) ?> 
                  • <?= date('F j, Y', strtotime($data['featuredPodcast']['publish_date'])) ?>
                </p>
              </div>
            </div>
          </div>
          <div class="md:w-3/5 p-6">
            <div class="flex items-center text-sm text-gray-500 mb-4">
              <span class="mr-4 flex items-center">
                <i class="far fa-clock mr-2"></i>
                <?= App\Models\Podcast::formatDuration($data['featuredPodcast']['duration']) ?>
              </span>
              <span class="flex items-center">
                <i class="far fa-play-circle mr-2"></i>
                875 plays
              </span>
            </div>
            
                          <p class="text-gray-600 mb-6">
              <?= htmlspecialchars($data['featuredPodcast']['description'] ?? '') ?>
            </p>
            
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <img src="<?= $data['featuredPodcast']['host_image_url'] ?>" alt="Host" class="w-10 h-10 rounded-full object-cover mr-3">
                <div>
                  <p class="text-sm font-medium"><?= htmlspecialchars($data['featuredPodcast']['host_name'] ?? '') ?></p>
                  <p class="text-xs text-gray-500"><?= htmlspecialchars($data['featuredPodcast']['host_title'] ?? '') ?></p>
                </div>
              </div>
              
              <div class="flex space-x-2">
                <a href="<?= $baseUrl ?>/podcast/<?= $data['featuredPodcast']['slug'] ?>" 
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full text-sm font-medium transition">
                  <i class="fas fa-info-circle mr-1"></i> Details
                </a>
                <button class="w-10 h-10 bg-primary hover:bg-opacity-80 text-white rounded-full flex items-center justify-center transition shadow-md featured-play-button" data-audio="<?= $data['featuredPodcast']['audio_url'] ?>">
                  <i class="fas fa-play"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Episode Masonry/List Section -->
    <div class="mb-8">
      <h2 class="text-2xl font-display font-bold mb-6">All Episodes</h2>
      
      <?php if (empty($data['podcasts'])): ?>
        <div class="bg-white rounded-xl shadow p-8 text-center">
          <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-podcast text-gray-400 text-3xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-700 mb-2">No episodes found</h3>
          <p class="text-gray-500 mb-4">Try adjusting your search or filter criteria</p>
          <a href="<?= $baseUrl ?>/podcast" class="inline-block px-4 py-2 bg-primary text-white rounded-md">
            View all episodes
          </a>
        </div>
      <?php else: ?>
        <!-- Masonry View (default) -->
        <div id="masonry-view" class="masonry-grid">
          <?php foreach ($data['podcasts'] as $index => $podcast): ?>
            <div class="masonry-item">
              <div class="bg-white rounded-xl shadow overflow-hidden transition-all duration-300 hover:shadow-xl hover:transform hover:-translate-y-1 group h-full">
                <div class="relative">
                  <img src="<?= $podcast['image_url'] ?>" alt="<?= htmlspecialchars($podcast['title']) ?>" 
                       class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105">
                  <div class="absolute top-0 right-0 m-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $podcast['featured'] ? 'bg-secondary text-primary' : 'bg-' . getColorForCategory($podcast['category_slug'] ?? '') . '-500 text-white' ?>">
                      <?= htmlspecialchars($podcast['category_name'] ?? '') ?>
                    </span>
                  </div>
                  <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-between">
                    <div class="p-4">
                      <p class="text-white text-sm">
                        <i class="far fa-calendar-alt mr-1"></i> <?= date('M j, Y', strtotime($podcast['publish_date'])) ?>
                      </p>
                    </div>
                    <div class="p-4">
                      <button class="w-10 h-10 bg-white text-primary rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110 play-button" data-audio="<?= $podcast['audio_url'] ?>">
                        <i class="fas fa-play"></i>
                      </button>
                    </div>
                  </div>
                </div>
                
                <div class="p-5">
                  <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-gray-800">
                      <a href="<?= $baseUrl ?>/podcast/<?= $podcast['slug'] ?? '' ?>" class="hover:text-primary transition">
                        <?= htmlspecialchars($podcast['title'] ?? '') ?>
                      </a>
                    </h3>
                  </div>
                  
                  <div class="flex items-center text-sm text-gray-500 mb-3">
                    <span class="mr-3"><i class="far fa-clock mr-1"></i> <?= App\Models\Podcast::formatDuration($podcast['duration']) ?></span>
                    <span><i class="far fa-play-circle mr-1"></i> <?= rand(150, 950) ?> plays</span>
                  </div>
                  
                  <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                    <?= htmlspecialchars($podcast['description'] ?? '') ?>
                  </p>
                  
                  <div class="pt-2 border-t border-gray-100 flex justify-between items-center">
                    <a href="<?= $baseUrl ?>/podcast/<?= $podcast['slug'] ?>" class="text-primary text-sm font-medium hover:underline">
                      View Details
                    </a>
                    
                    <div class="flex space-x-2">
                      <button class="text-gray-400 hover:text-gray-700 transition" title="Add to favorites">
                        <i class="far fa-heart"></i>
                      </button>
                      <button class="text-gray-400 hover:text-gray-700 transition" title="Share">
                        <i class="fas fa-share-alt"></i>
                      </button>
                      <button class="text-gray-400 hover:text-gray-700 transition" title="Download">
                        <i class="fas fa-download"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        
        <!-- List View (hidden by default) -->
        <div id="list-view" class="hidden space-y-4">
          <?php foreach ($data['podcasts'] as $index => $podcast): ?>
            <div class="bg-white rounded-xl shadow overflow-hidden transition-all duration-300 hover:shadow-xl">
              <div class="flex">
                <div class="w-24 md:w-40 shrink-0 relative">
                  <img src="<?= $podcast['image_url'] ?>" alt="<?= htmlspecialchars($podcast['title']) ?>" 
                       class="w-full h-full object-cover">
                  <button class="absolute inset-0 m-auto w-10 h-10 bg-primary/80 text-white rounded-full flex items-center justify-center opacity-0 hover:opacity-100 transition play-button" data-audio="<?= $podcast['audio_url'] ?>">
                    <i class="fas fa-play"></i>
                  </button>
                </div>
                
                <div class="flex-grow p-4">
                  <div class="flex flex-wrap items-center justify-between mb-1">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold <?= 'bg-' . getColorForCategory($podcast['category_slug'] ?? '') . '-100 text-' . getColorForCategory($podcast['category_slug'] ?? '') . '-800' ?> mb-1 md:mb-0">
                      <?= htmlspecialchars($podcast['category_name'] ?? '') ?>
                    </span>
                    <span class="text-xs text-gray-500">
                      <?= date('F j, Y', strtotime($podcast['publish_date'])) ?>
                    </span>
                  </div>
                  
                  <h3 class="font-bold text-gray-800 mb-1">
                    <a href="<?= $baseUrl ?>/podcast/<?= $podcast['slug'] ?? '' ?>" class="hover:text-primary transition">
                      <?= htmlspecialchars($podcast['title'] ?? '') ?>
                    </a>
                  </h3>
                  
                  <div class="flex items-center text-xs text-gray-500 mb-2">
                    <span class="mr-3"><i class="far fa-clock mr-1"></i> <?= App\Models\Podcast::formatDuration($podcast['duration']) ?></span>
                    <span><i class="far fa-play-circle mr-1"></i> <?= rand(150, 950) ?> plays</span>
                  </div>
                  
                  <p class="text-gray-600 text-sm hidden md:block line-clamp-2">
                    <?= htmlspecialchars($podcast['description'] ?? '') ?>
                  </p>
                </div>
                
                <div class="w-16 md:w-32 flex flex-col items-center justify-center border-l border-gray-100 p-2 md:p-4 shrink-0">
                  <div class="space-y-2 md:space-y-4">
                    <button class="text-gray-400 hover:text-primary transition block" title="Add to favorites">
                      <i class="far fa-heart text-sm md:text-base"></i>
                    </button>
                    <button class="text-gray-400 hover:text-primary transition block" title="Download">
                      <i class="fas fa-download text-sm md:text-base"></i>
                    </button>
                    <button class="text-gray-400 hover:text-primary transition block" title="Share">
                      <i class="fas fa-share-alt text-sm md:text-base"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      
      <!-- Pagination with Fancy Style -->
      <?php if ($data['pagination']['total'] > 1): ?>
      <div class="mt-12 flex justify-center">
        <div class="inline-flex items-center bg-white shadow rounded-full">
          <?php if ($data['pagination']['current'] > 1): ?>
          <a href="<?= $baseUrl ?>/podcast?page=<?= $data['pagination']['current'] - 1 ?><?= !empty($data['search']) ? '&search=' . urlencode($data['search']) : '' ?><?= !empty($data['currentCategory']) ? '&category=' . urlencode($data['currentCategory']) : '' ?>" 
             class="px-4 py-2 rounded-l-full text-gray-600 hover:text-primary hover:bg-gray-50 transition-colors">
            <i class="fas fa-chevron-left"></i>
          </a>
          <?php endif; ?>
          
          <?php 
          $startPage = max(1, $data['pagination']['current'] - 2);
          $endPage = min($data['pagination']['total'], $startPage + 4);
          if ($endPage - $startPage < 4) {
            $startPage = max(1, $endPage - 4);
          }
          ?>
          
          <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
          <a href="<?= $baseUrl ?>/podcast?page=<?= $i ?><?= !empty($data['search']) ? '&search=' . urlencode($data['search']) : '' ?><?= !empty($data['currentCategory']) ? '&category=' . urlencode($data['currentCategory']) : '' ?>" 
             class="w-10 h-10 flex items-center justify-center border-x border-gray-100 first:border-l-0 last:border-r-0 <?= $i === $data['pagination']['current'] ? 'bg-primary text-white font-medium' : 'text-gray-600 hover:text-primary hover:bg-gray-50' ?> transition-colors">
            <?= $i ?>
          </a>
          <?php endfor; ?>
          
          <?php if ($data['pagination']['current'] < $data['pagination']['total']): ?>
          <a href="<?= $baseUrl ?>/podcast?page=<?= $data['pagination']['current'] + 1 ?><?= !empty($data['search']) ? '&search=' . urlencode($data['search']) : '' ?><?= !empty($data['currentCategory']) ? '&category=' . urlencode($data['currentCategory']) : '' ?>" 
             class="px-4 py-2 rounded-r-full text-gray-600 hover:text-primary hover:bg-gray-50 transition-colors">
            <i class="fas fa-chevron-right"></i>
          </a>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Subscription Platforms Section -->
<section class="py-16 bg-gradient-to-br from-primary to-primary-dark text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-pattern opacity-10"></div>
  
  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-display font-bold mb-3">Listen on Your Favorite Platforms</h2>
      <p class="text-lg text-gray-200 max-w-3xl mx-auto">Subscribe to Wild Echoes on your preferred podcast platform and never miss a new episode.</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
      <a href="https://open.spotify.com" target="_blank" class="flex flex-col items-center p-6 bg-white/10 backdrop-blur rounded-xl transition transform hover:-translate-y-2 hover:bg-white/20">
        <i class="fab fa-spotify text-4xl mb-3"></i>
        <span class="font-medium">Spotify</span>
      </a>
      <a href="https://podcasts.apple.com" target="_blank" class="flex flex-col items-center p-6 bg-white/10 backdrop-blur rounded-xl transition transform hover:-translate-y-2 hover:bg-white/20">
        <i class="fab fa-apple text-4xl mb-3"></i>
        <span class="font-medium">Apple Podcasts</span>
      </a>
      <a href="https://music.amazon.com" target="_blank" class="flex flex-col items-center p-6 bg-white/10 backdrop-blur rounded-xl transition transform hover:-translate-y-2 hover:bg-white/20">
        <i class="fab fa-amazon text-4xl mb-3"></i>
        <span class="font-medium">Amazon Music</span>
      </a>
      <a href="https://podcasts.google.com" target="_blank" class="flex flex-col items-center p-6 bg-white/10 backdrop-blur rounded-xl transition transform hover:-translate-y-2 hover:bg-white/20">
        <i class="fab fa-google text-4xl mb-3"></i>
        <span class="font-medium">Google Podcasts</span>
      </a>
    </div>
    
    <div class="mt-16 max-w-md mx-auto">
      <div class="bg-white/10 backdrop-blur rounded-2xl p-6">
        <h3 class="text-xl font-bold mb-4 text-center">Get Notified of New Episodes</h3>
        <form class="space-y-4">
          <div>
            <input type="email" placeholder="Your email address" 
                   class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/30 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
          </div>
          <div class="flex items-center mb-3">
            <input type="checkbox" id="consent" class="form-checkbox h-4 w-4 text-secondary rounded border-white/30">
            <label for="consent" class="ml-2 text-sm text-gray-300">I agree to receive emails about new episodes and updates</label>
          </div>
          <button type="submit" class="w-full px-6 py-3 bg-secondary text-primary font-medium rounded-lg hover:bg-opacity-90 transition">
            Subscribe
          </button>
        </form>
        <p class="text-xs text-center text-gray-300 mt-4">We'll never share your email. Unsubscribe anytime.</p>
      </div>
    </div>
  </div>
</section>

<!-- Podcast Testimonials Carousel -->
<section class="py-16 bg-light">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-display font-bold mb-8 text-center">What Listeners Say</h2>
    
    <div class="max-w-5xl mx-auto relative">
      <!-- Navigation Arrows -->
      <button class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-5 md:-translate-x-12 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-gray-800 hover:bg-gray-100 z-10 testimonial-prev">
        <i class="fas fa-chevron-left"></i>
      </button>
      
      <button class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-5 md:translate-x-12 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-gray-800 hover:bg-gray-100 z-10 testimonial-next">
        <i class="fas fa-chevron-right"></i>
      </button>
      
      <!-- Testimonials -->
      <div class="relative overflow-hidden testimonials-container">
        <div class="flex testimonials-slider transition-transform duration-500" style="transform: translateX(0%)">
          <!-- Testimonial 1 -->
          <div class="shrink-0 w-full md:w-1/2 lg:w-1/3 p-4">
            <div class="bg-white rounded-xl shadow-md p-6 h-full flex flex-col">
              <div class="flex items-center mb-4">
                <img src="<?= $baseUrl ?>/assets/images/podcast/user1.jpg" alt="User" class="w-12 h-12 rounded-full mr-4">
                <div>
                  <h4 class="font-semibold">Sarah Johnson</h4>
                  <div class="flex text-yellow-400 text-sm">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                  </div>
                </div>
              </div>
              <p class="text-gray-600 flex-grow mb-4">"Wild Echoes has completely changed how I view wildlife conservation. The combination of fascinating stories and practical mindfulness techniques has made me more aware of my connection to the natural world."</p>
              <p class="text-gray-500 text-sm">Wildlife Enthusiast, Oregon</p>
            </div>
          </div>
          
          <!-- Testimonial 2 -->
          <div class="shrink-0 w-full md:w-1/2 lg:w-1/3 p-4">
            <div class="bg-white rounded-xl shadow-md p-6 h-full flex flex-col">
              <div class="flex items-center mb-4">
                <img src="<?= $baseUrl ?>/assets/images/podcast/user2.jpg" alt="User" class="w-12 h-12 rounded-full mr-4">
                <div>
                  <h4 class="font-semibold">Michael Chen</h4>
                  <div class="flex text-yellow-400 text-sm">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                  </div>
                </div>
              </div>
              <p class="text-gray-600 flex-grow mb-4">"As a productivity coach, I love how this podcast bridges the gap between personal development and environmental consciousness. The focus techniques inspired by nature have helped many of my clients."</p>
              <p class="text-gray-500 text-sm">Productivity Coach, New York</p>
            </div>
          </div>
          
          <!-- Testimonial 3 -->
          <div class="shrink-0 w-full md:w-1/2 lg:w-1/3 p-4">
            <div class="bg-white rounded-xl shadow-md p-6 h-full flex flex-col">
              <div class="flex items-center mb-4">
                <img src="<?= $baseUrl ?>/assets/images/podcast/user3.jpg" alt="User" class="w-12 h-12 rounded-full mr-4">
                <div>
                  <h4 class="font-semibold">Olivia Martinez</h4>
                  <div class="flex text-yellow-400 text-sm">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                  </div>
                </div>
              </div>
              <p class="text-gray-600 flex-grow mb-4">"The interviews with wildlife researchers and conservationists are absolutely captivating. I've learned so much about species I never knew existed and the complex challenges they face. A must-listen!"</p>
              <p class="text-gray-500 text-sm">Biology Teacher, Colorado</p>
            </div>
          </div>
          
          <!-- Additional Testimonials -->
          <div class="shrink-0 w-full md:w-1/2 lg:w-1/3 p-4">
            <div class="bg-white rounded-xl shadow-md p-6 h-full flex flex-col">
              <div class="flex items-center mb-4">
                <img src="<?= $baseUrl ?>/assets/images/podcast/user4.jpg" alt="User" class="w-12 h-12 rounded-full mr-4">
                <div>
                  <h4 class="font-semibold">James Wilson</h4>
                  <div class="flex text-yellow-400 text-sm">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                  </div>
                </div>
              </div>
              <p class="text-gray-600 flex-grow mb-4">"I listen to Wild Echoes during my morning commute, and it sets a positive tone for my entire day. The blend of education and inspiration is perfectly balanced."</p>
              <p class="text-gray-500 text-sm">Marketing Executive, California</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Indicators -->
      <div class="flex justify-center mt-8 testimonial-dots">
        <button class="w-3 h-3 rounded-full bg-primary mx-1 active"></button>
        <button class="w-3 h-3 rounded-full bg-gray-300 mx-1"></button>
        <button class="w-3 h-3 rounded-full bg-gray-300 mx-1"></button>
        <button class="w-3 h-3 rounded-full bg-gray-300 mx-1"></button>
      </div>
    </div>
  </div>
</section>

<!-- About the Hosts -->
<section class="py-16 bg-white">
  <div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row items-center">
      <div class="md:w-1/2 mb-8 md:mb-0 md:pr-12">
        <h2 class="text-3xl font-display font-bold mb-6">Meet Your Hosts</h2>
        <p class="text-gray-600 mb-6">Wild Echoes brings together experts in wildlife conservation and personal development to create a unique listening experience that inspires both environmental awareness and personal growth.</p>
        
        <div class="space-y-6">
          <?php foreach ($data['hosts'] as $host): ?>
          <div class="bg-gray-50 rounded-xl p-5 flex items-start">
            <img src="<?= $host['image_url'] ?>" alt="<?= htmlspecialchars($host['name']) ?>" class="w-16 h-16 rounded-full object-cover border-2 border-primary mr-4">
            <div>
              <h4 class="font-bold text-gray-800"><?= htmlspecialchars($host['name'] ?? '') ?></h4>
              <p class="text-primary text-sm mb-2"><?= htmlspecialchars($host['title'] ?? '') ?></p>
              <p class="text-gray-600 text-sm"><?= htmlspecialchars($host['bio'] ?? '') ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        
        <div class="mt-8">
          <a href="#" class="inline-block px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-opacity-90 transition">
            <i class="fas fa-envelope mr-2"></i> Contact the Hosts
          </a>
        </div>
      </div>
      
      <div class="md:w-1/2">
        <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden shadow-xl">
          <iframe width="100%" height="100%" src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        
        <div class="mt-6 grid grid-cols-3 gap-4">
          <img src="<?= $baseUrl ?>/assets/images/podcast/studio1.jpg" alt="Recording Studio" class="rounded-lg h-24 w-full object-cover">
          <img src="<?= $baseUrl ?>/assets/images/podcast/studio2.jpg" alt="Interview Setup" class="rounded-lg h-24 w-full object-cover">
          <img src="<?= $baseUrl ?>/assets/images/podcast/studio3.jpg" alt="Field Recording" class="rounded-lg h-24 w-full object-cover">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Global Audio Player (Hidden initially) -->
<div id="global-player" class="fixed bottom-0 left-0 right-0 bg-gray-900 text-white transform translate-y-full transition-transform duration-300 shadow-lg z-50">
  <div class="container mx-auto px-4">
    <div class="flex items-center py-3">
      <!-- Episode Info -->
      <div class="flex items-center mr-6">
        <img src="" alt="Current Episode" id="player-image" class="w-12 h-12 rounded-md mr-3 object-cover">
        <div>
          <h4 class="font-medium text-sm line-clamp-1" id="player-title">Episode Title</h4>
          <p class="text-xs text-gray-400" id="player-host">Wild Echoes</p>
        </div>
      </div>
      
      <!-- Player Controls -->
      <div class="flex-grow hidden md:flex items-center">
        <!-- Control Buttons -->
        <div class="flex items-center">
          <button class="text-white mx-2 focus:outline-none" id="player-prev">
            <i class="fas fa-step-backward"></i>
          </button>
          <button class="text-white mx-2 w-10 h-10 bg-primary rounded-full flex items-center justify-center" id="player-play-pause">
            <i class="fas fa-play"></i>
          </button>
          <button class="text-white mx-2 focus:outline-none" id="player-next">
            <i class="fas fa-step-forward"></i>
          </button>
        </div>
        
        <!-- Progress Bar -->
        <div class="mx-4 flex-grow flex items-center">
          <span class="text-xs text-gray-400 mr-2 w-10 text-right" id="player-current-time">0:00</span>
          <div class="relative h-1.5 bg-white/20 rounded-full flex-grow cursor-pointer group" id="player-progress-container">
            <div class="absolute left-0 top-0 h-full bg-secondary rounded-full" style="width: 0%" id="player-progress-bar"></div>
            <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity" style="left: 0%" id="player-progress-handle"></div>
          </div>
          <span class="text-xs text-gray-400 ml-2 w-10" id="player-duration">0:00</span>
        </div>
        
        <!-- Additional Controls -->
        <div class="flex items-center">
          <button class="text-white mx-1 focus:outline-none" id="player-speed" title="Playback Speed">
            <span class="text-xs font-medium">1.0x</span>
          </button>
          <button class="text-white mx-1 focus:outline-none relative group" id="player-volume">
            <i class="fas fa-volume-up"></i>
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-6 h-24 bg-gray-800 rounded-full p-2 hidden group-hover:block">
              <div class="w-2 h-full bg-gray-600 rounded-full relative">
                <div class="absolute bottom-0 left-0 w-full bg-white rounded-full" style="height: 70%"></div>
                <div class="absolute bottom-[70%] left-1/2 -translate-x-1/2 w-4 h-4 bg-white rounded-full"></div>
              </div>
            </div>
          </button>
          <button class="text-white mx-1 focus:outline-none" id="player-download" title="Download">
            <i class="fas fa-download"></i>
          </button>
          <button class="text-white mx-1 focus:outline-none" id="player-share" title="Share">
            <i class="fas fa-share-alt"></i>
          </button>
        </div>
      </div>
      
      <!-- Mobile Controls -->
      <div class="flex items-center md:hidden ml-auto space-x-4">
        <button class="text-white w-8 h-8 bg-primary rounded-full flex items-center justify-center" id="player-play-pause-mobile">
          <i class="fas fa-play"></i>
        </button>
        <button class="text-white focus:outline-none" id="player-close-mobile">
          <i class="fas fa-times"></i>
        </button>
      </div>
      
      <!-- Close Button (Desktop) -->
      <button class="ml-6 hidden md:block text-white focus:outline-none" id="player-close">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
</div>

<style>
/* Custom Styles */
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

/* Line Clamp */
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Background Pattern */
.bg-pattern {
  background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50,10 Q60,0 70,10 Q80,20 70,30 Q60,40 50,30 Q40,20 50,10 Z' fill='%23FFFFFF' fill-opacity='0.1'/%3E%3C/svg%3E");
  background-size: 100px 100px;
}

/* Custom Colors */
.bg-primary-dark {
  background-color: #1d4530;
}

/* Aspect Ratio */
.aspect-w-16 {
  position: relative;
  padding-bottom: 56.25%;
}
.aspect-w-16 > * {
  position: absolute;
  height: 100%;
  width: 100%;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}

/* Masonry Grid Layout */
.masonry-grid {
  column-count: 1;
  column-gap: 1.5rem;
  width: 100%;
}

@media (min-width: 640px) {
  .masonry-grid {
    column-count: 2;
  }
}

@media (min-width: 1024px) {
  .masonry-grid {
    column-count: 3;
  }
}

.masonry-item {
  break-inside: avoid;
  margin-bottom: 1.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  /* Audio Player Logic */
  const audioPlayer = new Audio();
  let currentPlayButton = null;
  let progressInterval = null;
  let globalPlayerActive = false;
  
  // Initialize Global Player
  const globalPlayer = document.getElementById('global-player');
  const playerImage = document.getElementById('player-image');
  const playerTitle = document.getElementById('player-title');
  const playerHost = document.getElementById('player-host');
  const playerPlayPause = document.getElementById('player-play-pause');
  const playerPlayPauseMobile = document.getElementById('player-play-pause-mobile');
  const playerProgressBar = document.getElementById('player-progress-bar');
  const playerProgressHandle = document.getElementById('player-progress-handle');
  const playerCurrentTime = document.getElementById('player-current-time');
  const playerDuration = document.getElementById('player-duration');
  const playerClose = document.getElementById('player-close');
  const playerCloseMobile = document.getElementById('player-close-mobile');
  const playerProgressContainer = document.getElementById('player-progress-container');
  const playerSpeed = document.getElementById('player-speed');
  
  // Play/pause functionality for all buttons
  document.querySelectorAll('.play-button, .featured-play-button, .play-button-mobile').forEach(button => {
    button.addEventListener('click', function() {
      const audioUrl = this.getAttribute('data-audio');
      
      // If clicking the same button that's already playing
      if (currentPlayButton === this && !audioPlayer.paused) {
        pauseAudio();
        return;
      }
      
      // If a different button was playing, reset it
      if (currentPlayButton && currentPlayButton !== this) {
        resetPlayButton(currentPlayButton);
      }
      
      // Update current button
      currentPlayButton = this;
      
      // Play the new audio
      playAudio(audioUrl, this);
      
      // Show global player
      showGlobalPlayer(this);
    });
  });
  
  // Play audio function
  function playAudio(url, button) {
    // Set audio source and load it
    audioPlayer.src = url;
    audioPlayer.load();
    
    // Play audio
    audioPlayer.play()
      .then(() => {
        // Update button appearance
        button.innerHTML = '<i class="fas fa-pause"></i>';
        
        // Update global player controls
        playerPlayPause.innerHTML = '<i class="fas fa-pause"></i>';
        playerPlayPauseMobile.innerHTML = '<i class="fas fa-pause"></i>';
        
        // Start progress update
        clearInterval(progressInterval);
        progressInterval = setInterval(updateProgress, 1000);
      })
      .catch(error => {
        console.error('Error playing audio:', error);
      });
  }
  
  // Pause audio function
  function pauseAudio() {
    audioPlayer.pause();
    
    if (currentPlayButton) {
      resetPlayButton(currentPlayButton);
    }
    
    playerPlayPause.innerHTML = '<i class="fas fa-play"></i>';
    playerPlayPauseMobile.innerHTML = '<i class="fas fa-play"></i>';
    
    clearInterval(progressInterval);
  }
  
  // Reset play button appearance
  function resetPlayButton(button) {
    button.innerHTML = '<i class="fas fa-play"></i>';
  }
  
  // Show global player
  function showGlobalPlayer(button) {
    // Find the nearest parent with episode information
    let episodeCard = button.closest('.bg-white');
    let episodeImage = episodeCard.querySelector('img');
    let episodeTitle = episodeCard.querySelector('h3') || episodeCard.querySelector('h4');
    
    // Set global player info
    if (episodeImage) playerImage.src = episodeImage.src;
    if (episodeTitle) playerTitle.textContent = episodeTitle.textContent.trim();
    
    // Show global player if hidden
    if (!globalPlayerActive) {
      globalPlayer.classList.remove('translate-y-full');
      globalPlayerActive = true;
    }
    
    // Format duration when metadata is loaded
    audioPlayer.addEventListener('loadedmetadata', function() {
      const minutes = Math.floor(audioPlayer.duration / 60);
      const seconds = Math.floor(audioPlayer.duration % 60);
      playerDuration.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    });
  }
  
  // Update progress function
  function updateProgress() {
    if (audioPlayer.paused || audioPlayer.ended) {
      clearInterval(progressInterval);
      if (currentPlayButton) {
        resetPlayButton(currentPlayButton);
      }
      playerPlayPause.innerHTML = '<i class="fas fa-play"></i>';
      playerPlayPauseMobile.innerHTML = '<i class="fas fa-play"></i>';
      return;
    }
    
    // Calculate progress percentage
    const progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
    
    // Update progress bars
    playerProgressBar.style.width = `${progress}%`;
    playerProgressHandle.style.left = `${progress}%`;
    
    // Format and display current time
    const minutes = Math.floor(audioPlayer.currentTime / 60);
    const seconds = Math.floor(audioPlayer.currentTime % 60);
    playerCurrentTime.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
  }
  
  // Click on progress bar to seek
  if (playerProgressContainer) {
    playerProgressContainer.addEventListener('click', function(e) {
      if (!audioPlayer.paused || audioPlayer.currentTime > 0) {
        const rect = this.getBoundingClientRect();
        const clickPosition = (e.clientX - rect.left) / rect.width;
        audioPlayer.currentTime = clickPosition * audioPlayer.duration;
        updateProgress();
      }
    });
  }
  
  // Global player play/pause
  playerPlayPause.addEventListener('click', function() {
    if (audioPlayer.paused) {
      audioPlayer.play()
        .then(() => {
          playerPlayPause.innerHTML = '<i class="fas fa-pause"></i>';
          playerPlayPauseMobile.innerHTML = '<i class="fas fa-pause"></i>';
          if (currentPlayButton) {
            currentPlayButton.innerHTML = '<i class="fas fa-pause"></i>';
          }
          progressInterval = setInterval(updateProgress, 1000);
        });
    } else {
      pauseAudio();
    }
  });
  
  // Mobile play/pause
  playerPlayPauseMobile.addEventListener('click', function() {
    if (audioPlayer.paused) {
      audioPlayer.play()
        .then(() => {
          playerPlayPause.innerHTML = '<i class="fas fa-pause"></i>';
          playerPlayPauseMobile.innerHTML = '<i class="fas fa-pause"></i>';
          if (currentPlayButton) {
            currentPlayButton.innerHTML = '<i class="fas fa-pause"></i>';
          }
          progressInterval = setInterval(updateProgress, 1000);
        });
    } else {
      pauseAudio();
    }
  });
  
  // Close global player
  playerClose.addEventListener('click', function() {
    globalPlayer.classList.add('translate-y-full');
    pauseAudio();
    globalPlayerActive = false;
  });
  
  playerCloseMobile.addEventListener('click', function() {
    globalPlayer.classList.add('translate-y-full');
    pauseAudio();
    globalPlayerActive = false;
  });
  
  // Playback speed
  playerSpeed.addEventListener('click', function() {
    const speeds = [1, 1.25, 1.5, 2, 0.75];
    const currentText = this.textContent.trim();
    const currentSpeed = parseFloat(currentText.replace('x', ''));
    const currentIndex = speeds.indexOf(currentSpeed);
    const nextIndex = (currentIndex + 1) % speeds.length;
    const nextSpeed = speeds[nextIndex];
    
    audioPlayer.playbackRate = nextSpeed;
    this.textContent = `${nextSpeed}x`;
  });
  
  /* Masonry/List View Toggle */
  const masonryViewBtn = document.getElementById('masonry-view-btn');
  const listViewBtn = document.getElementById('list-view-btn');
  const masonryView = document.getElementById('masonry-view');
  const listView = document.getElementById('list-view');
  
  if (masonryViewBtn && listViewBtn && masonryView && listView) {
    masonryViewBtn.addEventListener('click', function() {
      masonryView.classList.remove('hidden');
      listView.classList.add('hidden');
      
      masonryViewBtn.classList.add('text-primary');
      masonryViewBtn.classList.remove('text-gray-500');
      listViewBtn.classList.add('text-gray-500');
      listViewBtn.classList.remove('text-primary');
    });
    
    listViewBtn.addEventListener('click', function() {
      masonryView.classList.add('hidden');
      listView.classList.remove('hidden');
      
      listViewBtn.classList.add('text-primary');
      listViewBtn.classList.remove('text-gray-500');
      masonryViewBtn.classList.add('text-gray-500');
      masonryViewBtn.classList.remove('text-primary');
    });
  }
  
  /* Sticky Player Visibility */
  const stickyPlayer = document.getElementById('sticky-player');
  const filterSection = document.getElementById('filter-section');
  
  if (stickyPlayer && filterSection) {
    window.addEventListener('scroll', function() {
      const filterRect = filterSection.getBoundingClientRect();
      
      // Hide sticky player when user scrolls to the top (before filter section)
      if (filterRect.top > 0) {
        stickyPlayer.classList.add('-translate-y-full');
      } else {
        stickyPlayer.classList.remove('-translate-y-full');
      }
    });
  }
  
  /* Testimonials Carousel */
  const testimonialSlider = document.querySelector('.testimonials-slider');
  const testimonialDots = document.querySelectorAll('.testimonial-dots button');
  const testimonialPrev = document.querySelector('.testimonial-prev');
  const testimonialNext = document.querySelector('.testimonial-next');
  
  if (testimonialSlider && testimonialDots.length && testimonialPrev && testimonialNext) {
    let currentSlide = 0;
    const totalSlides = testimonialDots.length;
    
    function goToSlide(index) {
      // Update current slide
      currentSlide = index;
      
      // Calculate position percentage based on viewport
      let percentage = 0;
      
      if (window.innerWidth >= 1024) { // lg and above: showing 3 slides
        percentage = -(index * 33.33);
      } else if (window.innerWidth >= 768) { // md: showing 2 slides
        percentage = -(index * 50);
      } else { // sm: showing 1 slide
        percentage = -(index * 100);
      }
      
      // Update slider position
      testimonialSlider.style.transform = `translateX(${percentage}%)`;
      
      // Update dots
      testimonialDots.forEach((dot, i) => {
        if (i === index) {
          dot.classList.add('bg-primary');
          dot.classList.remove('bg-gray-300');
        } else {
          dot.classList.remove('bg-primary');
          dot.classList.add('bg-gray-300');
        }
      });
    }
    
    // Add click events to dots
    testimonialDots.forEach((dot, index) => {
      dot.addEventListener('click', () => goToSlide(index));
    });
    
    // Add click events to navigation buttons
    testimonialPrev.addEventListener('click', () => {
      const newSlide = (currentSlide - 1 + totalSlides) % totalSlides;
      goToSlide(newSlide);
    });
    
    testimonialNext.addEventListener('click', () => {
      const newSlide = (currentSlide + 1) % totalSlides;
      goToSlide(newSlide);
    });
    
    // Auto-advance slides
    setInterval(() => {
      if (!document.hidden) { // Only advance if page is visible
        const newSlide = (currentSlide + 1) % totalSlides;
        goToSlide(newSlide);
      }
    }, 5000);
    
    // Adjust on resize
    window.addEventListener('resize', () => {
      goToSlide(currentSlide);
    });
  }
});

// Helper function to get color for category
function getColorForCategory(slug) {
  const colorMap = {
    'conservation': 'green',
    'interviews': 'blue',
    'field-stories': 'purple',
    'focus-tips': 'yellow',
    'wildlife-science': 'red'
  };
  
  return colorMap[slug] || 'blue';
}
</script>

<?php include ROOT_PATH . '/resources/views/layouts/footer.php'; ?>