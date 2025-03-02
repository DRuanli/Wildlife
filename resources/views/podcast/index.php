<?php
// Path: resources/views/podcast/index.php
$baseUrl = $data['baseUrl'] ?? '/Wildlife';
?>

<?php include ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="bg-primary text-white py-16 relative overflow-hidden">
  <!-- Nature-inspired background patterns -->
  <div class="absolute inset-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <pattern id="leaf-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M30,50 Q50,20 70,50 Q50,80 30,50 Z" fill="currentColor"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#leaf-pattern)"/>
    </svg>
  </div>
  
  <div class="container mx-auto px-4 relative z-10">
    <div class="flex flex-col md:flex-row items-center">
      <div class="md:w-1/2 mb-8 md:mb-0">
        <h1 class="text-4xl md:text-5xl font-display font-bold mb-4">Wild Echoes Podcast</h1>
        <p class="text-xl mb-6">Exploring wildlife conservation through mindful conversations</p>
        
        <div class="flex flex-wrap gap-3">
          <a href="https://open.spotify.com" target="_blank" class="flex items-center bg-secondary text-primary px-4 py-3 rounded-lg font-medium hover:bg-opacity-90 transition">
            <i class="fab fa-spotify mr-2 text-lg"></i> Listen on Spotify
          </a>
          <a href="https://podcasts.apple.com" target="_blank" class="flex items-center bg-white text-primary px-4 py-3 rounded-lg font-medium hover:bg-opacity-90 transition">
            <i class="fab fa-apple mr-2 text-lg"></i> Apple Podcasts
          </a>
          <a href="#" class="flex items-center bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-3 rounded-lg font-medium transition">
            <i class="fas fa-podcast mr-2"></i> More Platforms
          </a>
        </div>
      </div>
      
      <?php if (isset($data['featuredPodcast']) && $data['featuredPodcast']): ?>
      <div class="md:w-1/2">
        <!-- Featured Episode Player -->
        <div class="bg-white bg-opacity-10 p-6 rounded-lg backdrop-blur-sm">
          <div class="flex items-start mb-4">
            <img src="<?= $data['featuredPodcast']['image_url'] ?>" alt="<?= htmlspecialchars($data['featuredPodcast']['title']) ?>" class="w-20 h-20 object-cover rounded-md mr-4">
            <div>
              <span class="text-secondary font-medium">Latest Episode</span>
              <h3 class="text-xl font-bold"><?= htmlspecialchars($data['featuredPodcast']['title']) ?></h3>
              <p class="text-sm text-gray-200">Episode <?= count($data['podcasts']) + 42 - array_search($data['featuredPodcast']['id'], array_column($data['podcasts'], 'id')) ?> • <?= date('M j, Y', strtotime($data['featuredPodcast']['publish_date'])) ?></p>
            </div>
          </div>
          
          <!-- Podcast Player -->
          <div class="bg-black bg-opacity-30 rounded-md p-3">
            <div class="flex items-center justify-between mb-2">
              <div class="flex items-center">
                <button class="w-10 h-10 bg-secondary text-primary rounded-full flex items-center justify-center hover:bg-opacity-90 transition play-button" data-audio="<?= $data['featuredPodcast']['audio_url'] ?>">
                  <i class="fas fa-play"></i>
                </button>
                <div class="ml-3">
                  <span class="text-sm font-medium current-time">00:00</span>
                  <span class="mx-2 text-gray-400">/</span>
                  <span class="text-sm text-gray-300 duration"><?= App\Models\Podcast::formatDuration($data['featuredPodcast']['duration']) ?></span>
                </div>
              </div>
              <div class="flex items-center space-x-3">
                <button class="text-white hover:text-secondary transition">
                  <i class="fas fa-volume-up"></i>
                </button>
                <a href="<?= $data['featuredPodcast']['audio_url'] ?>" download class="text-white hover:text-secondary transition">
                  <i class="fas fa-download"></i>
                </a>
                <button class="text-white hover:text-secondary transition share-button" data-url="<?= $baseUrl ?>/podcast/<?= $data['featuredPodcast']['slug'] ?>">
                  <i class="fas fa-share-alt"></i>
                </button>
              </div>
            </div>
            
            <!-- Audio Progress Bar -->
            <div class="relative h-1.5 bg-gray-600 rounded-full overflow-hidden">
              <div class="absolute left-0 top-0 h-full bg-secondary progress-bar" style="width: 0%"></div>
              <div class="absolute left-0 top-0 h-full w-1.5 bg-white rounded-full progress-handle" style="left: 0%"></div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Search and Filter Section -->
<section class="py-8 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
      <h2 class="text-2xl font-display font-semibold mb-4 md:mb-0">Browse Episodes</h2>
      
      <!-- Search Bar -->
      <form action="<?= $baseUrl ?>/podcast" method="GET" class="w-full md:w-64 relative">
        <input type="text" name="search" placeholder="Search episodes..." value="<?= htmlspecialchars($data['search'] ?? '') ?>" 
               class="w-full py-2 pl-10 pr-4 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
      </form>
    </div>
    
    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-2 mb-6">
      <a href="<?= $baseUrl ?>/podcast" 
         class="px-4 py-2 <?= empty($data['currentCategory']) ? 'bg-primary text-white' : 'bg-white border border-gray-300 hover:bg-gray-100' ?> rounded-full text-sm font-medium transition">
        All Episodes
      </a>
      
      <?php foreach ($data['categories'] as $category): ?>
      <a href="<?= $baseUrl ?>/podcast/category/<?= $category['slug'] ?>" 
         class="px-4 py-2 <?= ($data['currentCategory'] ?? '') === $category['slug'] ? 'bg-primary text-white' : 'bg-white border border-gray-300 hover:bg-gray-100' ?> rounded-full text-sm font-medium transition">
        <?= htmlspecialchars($category['name']) ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Episodes Masonry Grid -->
<section class="py-12">
  <div class="container mx-auto px-4">
    <!-- Masonry Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="podcast-grid">
      
      <?php if (empty($data['podcasts'])): ?>
        <div class="col-span-3 text-center py-10">
          <i class="fas fa-podcast text-gray-300 text-5xl mb-4"></i>
          <h3 class="text-xl font-bold text-gray-500">No episodes found</h3>
          <p class="text-gray-400 mt-2">Try adjusting your search or filter criteria</p>
        </div>
      <?php else: ?>
        <?php foreach ($data['podcasts'] as $index => $podcast): ?>
          <?php 
            // Determine card size based on index for masonry effect
            $imageHeight = 'h-48'; // Default medium
            $cardClasses = '';
            
            if ($index % 5 === 0 || $index % 5 === 4) {
              $imageHeight = 'h-64'; // Tall card
              $cardClasses = 'row-span-1';
            } elseif ($index % 5 === 2) {
              $imageHeight = 'h-40'; // Short card
            }
          ?>
          
          <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:-translate-y-1 hover:shadow-lg <?= $cardClasses ?>">
            <div class="relative">
              <img src="<?= $podcast['image_url'] ?>" alt="<?= htmlspecialchars($podcast['title']) ?>" class="w-full <?= $imageHeight ?> object-cover">
              <div class="absolute top-4 left-4 <?= $podcast['featured'] ? 'bg-secondary text-primary' : 'bg-' . getColorForCategory($podcast['category_slug']) . '-500 text-white' ?> px-3 py-1 rounded-full text-sm font-semibold">
                <?= $podcast['featured'] ? 'Featured' : htmlspecialchars($podcast['category_name']) ?>
              </div>
              <button class="absolute bottom-4 right-4 w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center hover:bg-opacity-90 transition shadow-lg play-button" data-audio="<?= $podcast['audio_url'] ?>">
                <i class="fas fa-play"></i>
              </button>
            </div>
            <div class="p-5">
              <div class="flex items-center text-sm text-gray-500 mb-2">
                <span class="mr-3"><i class="far fa-calendar-alt mr-1"></i> <?= date('M j, Y', strtotime($podcast['publish_date'])) ?></span>
                <span><i class="far fa-clock mr-1"></i> <?= App\Models\Podcast::formatDuration($podcast['duration']) ?></span>
              </div>
              <h3 class="text-lg font-bold mb-2">
                <a href="<?= $baseUrl ?>/podcast/<?= $podcast['slug'] ?>" class="hover:text-primary transition">
                  <?= htmlspecialchars($podcast['title']) ?>
                </a>
              </h3>
              <p class="text-gray-600 mb-3"><?= htmlspecialchars(substr($podcast['description'], 0, 120)) ?>...</p>
              
              <?php if (!empty($podcast['host_name']) && ($index % 5 === 0 || $index % 5 === 4)): ?>
              <div class="flex items-center mt-4">
                <img src="<?= $podcast['host_image_url'] ?>" alt="<?= htmlspecialchars($podcast['host_name']) ?>" class="w-10 h-10 rounded-full object-cover mr-3">
                <div>
                  <p class="text-sm font-semibold"><?= htmlspecialchars($podcast['host_name']) ?></p>
                  <p class="text-xs text-gray-500"><?= htmlspecialchars($podcast['host_title']) ?></p>
                </div>
              </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($data['pagination']['total'] > 1): ?>
    <div class="mt-10 flex justify-center">
      <div class="inline-flex">
        <?php if ($data['pagination']['current'] > 1): ?>
        <a href="<?= $baseUrl ?>/podcast?page=<?= $data['pagination']['current'] - 1 ?><?= !empty($data['search']) ? '&search=' . urlencode($data['search']) : '' ?><?= !empty($data['currentCategory']) ? '&category=' . urlencode($data['currentCategory']) : '' ?>" 
           class="px-4 py-2 border border-gray-300 bg-white rounded-l-md text-gray-700 hover:bg-gray-50">
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
           class="px-4 py-2 border-t border-b <?= $i < $endPage ? 'border-r' : '' ?> <?= $i > $startPage ? 'border-l-0' : 'border-l rounded-l-md' ?> <?= $i === $endPage && $data['pagination']['current'] !== $data['pagination']['total'] ? 'rounded-r-md' : '' ?> <?= $i === $data['pagination']['current'] ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50' ?>">
          <?= $i ?>
        </a>
        <?php endfor; ?>
        
        <?php if ($data['pagination']['current'] < $data['pagination']['total']): ?>
        <a href="<?= $baseUrl ?>/podcast?page=<?= $data['pagination']['current'] + 1 ?><?= !empty($data['search']) ? '&search=' . urlencode($data['search']) : '' ?><?= !empty($data['currentCategory']) ? '&category=' . urlencode($data['currentCategory']) : '' ?>" 
           class="px-4 py-2 border border-gray-300 bg-white rounded-r-md text-gray-700 hover:bg-gray-50">
          <i class="fas fa-chevron-right"></i>
        </a>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
    
    <!-- Load More Button Alternative -->
    <?php if ($data['pagination']['current'] < $data['pagination']['total'] && false): // Disabled in favor of pagination ?>
    <div class="mt-10 text-center">
      <button id="load-more" class="px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-opacity-90 transition inline-flex items-center" 
              data-page="<?= $data['pagination']['current'] ?>" 
              data-total="<?= $data['pagination']['total'] ?>" 
              data-category="<?= htmlspecialchars($data['currentCategory'] ?? '') ?>" 
              data-search="<?= htmlspecialchars($data['search'] ?? '') ?>">
        <span>Load More Episodes</span>
        <i class="fas fa-arrow-down ml-2"></i>
      </button>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- About the Podcast Section -->
<section class="py-16 bg-light">
  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row items-center">
      <div class="lg:w-2/5 mb-8 lg:mb-0">
        <div class="relative">
          <img src="<?= $baseUrl ?>/assets/images/podcast/hosts.jpg" alt="Podcast Hosts" class="rounded-xl shadow-lg w-full object-cover" style="max-height: 500px;">
          <div class="absolute -bottom-5 -right-5 bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center space-x-2">
              <div class="text-gray-700 font-medium">
                <div class="flex items-center mb-1">
                  <i class="fas fa-headphones-alt text-primary mr-2"></i>
                  <span><?= count($data['podcasts']) + 42 ?>+ Episodes</span>
                </div>
                <div class="flex items-center">
                  <i class="fas fa-star text-yellow-500 mr-2"></i>
                  <span>4.9/5 Rating</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="lg:w-3/5 lg:pl-16">
        <h2 class="text-3xl font-display font-bold mb-4">About Wild Echoes</h2>
        <p class="text-lg text-gray-700 mb-6">
          Wild Echoes is a weekly podcast that explores the fascinating intersection of wildlife conservation, mindfulness, and productivity. Our mission is to inspire listeners to develop deeper connections with the natural world while cultivating personal growth.
        </p>
        
        <h3 class="text-xl font-bold mb-3">Meet Your Hosts</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <?php foreach ($data['hosts'] as $host): ?>
          <div class="flex items-start">
            <img src="<?= $host['image_url'] ?>" alt="<?= htmlspecialchars($host['name']) ?>" class="w-16 h-16 rounded-full object-cover mr-4">
            <div>
              <h4 class="font-bold"><?= htmlspecialchars($host['name']) ?></h4>
              <p class="text-gray-600 text-sm mb-2"><?= htmlspecialchars($host['title']) ?></p>
              <p class="text-gray-700"><?= htmlspecialchars($host['bio']) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        
        <div class="flex flex-wrap gap-3">
          <a href="#" class="flex items-center bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-opacity-90 transition">
            <i class="fas fa-envelope mr-2"></i> Contact the Hosts
          </a>
          <a href="#" class="flex items-center bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
            <i class="fas fa-microphone-alt mr-2"></i> Suggest a Topic
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Subscribe CTA -->
<section class="py-16 bg-primary text-white relative overflow-hidden">
  <div class="absolute inset-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <pattern id="wave-pattern" x="0" y="0" width="100" height="20" patternUnits="userSpaceOnUse">
        <path d="M0,10 C30,15 70,5 100,10 L100,20 L0,20 Z" fill="currentColor"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#wave-pattern)"/>
    </svg>
  </div>
  
  <div class="container mx-auto px-4 relative z-10 text-center">
    <h2 class="text-3xl md:text-4xl font-display font-bold mb-6">Never Miss an Episode</h2>
    <p class="text-xl mb-8 max-w-3xl mx-auto">Subscribe to the Wild Echoes podcast on your favorite platform and join our community of mindful conservationists.</p>
    
    <div class="flex flex-wrap justify-center gap-4 mb-10">
      <a href="https://open.spotify.com" target="_blank" class="flex items-center bg-[#1DB954] text-white px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition">
        <i class="fab fa-spotify text-2xl mr-3"></i> Spotify
      </a>
      <a href="https://podcasts.apple.com" target="_blank" class="flex items-center bg-[#872EC4] text-white px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition">
        <i class="fab fa-apple text-2xl mr-3"></i> Apple Podcasts
      </a>
      <a href="https://youtube.com" target="_blank" class="flex items-center bg-[#F43E37] text-white px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition">
        <i class="fab fa-youtube text-2xl mr-3"></i> YouTube
      </a>
      <a href="#" class="flex items-center bg-[#FEAA2D] text-white px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition">
        <i class="fas fa-rss text-2xl mr-3"></i> RSS Feed
      </a>
    </div>
    
    <div class="max-w-md mx-auto">
      <h3 class="text-xl font-bold mb-4">Get Episode Notifications</h3>
      <form class="flex">
        <input type="email" placeholder="Your email address" class="flex-grow px-4 py-3 rounded-l-lg text-gray-800 focus:outline-none">
        <button type="submit" class="px-6 py-3 bg-secondary text-primary font-medium rounded-r-lg hover:bg-opacity-90 transition">
          Subscribe
        </button>
      </form>
      <p class="text-sm mt-2 text-gray-300">We'll never share your email. Unsubscribe anytime.</p>
    </div>
  </div>
</section>

<script>
// Helper function to handle audio playback
document.addEventListener('DOMContentLoaded', function() {
  const audioPlayer = new Audio();
  let currentPlayButton = null;
  let progressInterval = null;
  
  // Play/pause functionality for episode cards
  document.querySelectorAll('.play-button').forEach(button => {
    button.addEventListener('click', function() {
      const audioUrl = this.getAttribute('data-audio');
      
      // If clicking the same button that's already playing
      if (currentPlayButton === this && !audioPlayer.paused) {
        audioPlayer.pause();
        this.innerHTML = '<i class="fas fa-play"></i>';
        clearInterval(progressInterval);
        return;
      }
      
      // If a different button was playing, reset it
      if (currentPlayButton && currentPlayButton !== this) {
        currentPlayButton.innerHTML = '<i class="fas fa-play"></i>';
      }
      
      // Update current button
      currentPlayButton = this;
      
      // Play the new audio
      audioPlayer.src = audioUrl;
      audioPlayer.play()
        .then(() => {
          this.innerHTML = '<i class="fas fa-pause"></i>';
          
          // Update progress for featured episode player
          if (this.closest('.bg-white.bg-opacity-10')) {
            clearInterval(progressInterval);
            progressInterval = setInterval(updateProgress, 1000);
          }
        })
        .catch(error => {
          console.error('Error playing audio:', error);
        });
    });
  });
  
  // Function to update progress in the featured player
  function updateProgress() {
    if (audioPlayer.paused || audioPlayer.ended) {
      clearInterval(progressInterval);
      return;
    }
    
    const progressBar = document.querySelector('.progress-bar');
    const progressHandle = document.querySelector('.progress-handle');
    const currentTimeElement = document.querySelector('.current-time');
    
    if (progressBar && progressHandle && currentTimeElement) {
      const progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
      progressBar.style.width = `${progress}%`;
      progressHandle.style.left = `${progress}%`;
      
      // Format and display current time
      const minutes = Math.floor(audioPlayer.currentTime / 60);
      const seconds = Math.floor(audioPlayer.currentTime % 60);
      currentTimeElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
  }
  
  // Handle share buttons
  document.querySelectorAll('.share-button').forEach(button => {
    button.addEventListener('click', function() {
      const url = this.getAttribute('data-url');
      
      if (navigator.share) {
        navigator.share({
          title: 'Wild Echoes Podcast',
          url: url
        });
      } else {
        // Fallback to clipboard
        navigator.clipboard.writeText(url)
          .then(() => {
            alert('Link copied to clipboard!');
          })
          .catch(err => {
            console.error('Could not copy text: ', err);
          });
      }
    });
  });
  
  // Load more functionality (if needed)
  const loadMoreButton = document.getElementById('load-more');
  if (loadMoreButton) {
    loadMoreButton.addEventListener('click', function() {
      const currentPage = parseInt(this.getAttribute('data-page'));
      const totalPages = parseInt(this.getAttribute('data-total'));
      const nextPage = currentPage + 1;
      
      if (nextPage <= totalPages) {
        const category = this.getAttribute('data-category');
        const search = this.getAttribute('data-search');
        
        // Make AJAX request to fetch more episodes
        fetch(`${baseUrl}/podcast/load-more`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            page: nextPage,
            category: category,
            search: search
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Append new episodes to the grid
            // Implementation would go here
            
            // Update button data attributes
            this.setAttribute('data-page', nextPage);
            
            // Hide button if we've reached the last page
            if (nextPage >= totalPages) {
              this.style.display = 'none';
            }
          }
        })
        .catch(error => {
          console.error('Error loading more episodes:', error);
        });
      }
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