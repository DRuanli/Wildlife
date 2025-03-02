<?php
// Path: resources/views/podcast/view.php
$baseUrl = $data['baseUrl'] ?? '/Wildlife';
$podcast = $data['podcast'];
?>

<?php include ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Episode Hero Section -->
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
    <a href="<?= $baseUrl ?>/podcast" class="inline-flex items-center text-gray-200 hover:text-white mb-6 group">
      <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
      Back to all episodes
    </a>
    
    <div class="flex flex-col lg:flex-row items-center">
      <div class="lg:w-1/2 mb-8 lg:mb-0">
        <div class="bg-white bg-opacity-10 rounded-lg overflow-hidden shadow-xl backdrop-blur-sm">
          <img src="<?= $podcast['image_url'] ?>" alt="<?= htmlspecialchars($podcast['title']) ?>" class="w-full h-64 lg:h-80 object-cover">
        </div>
      </div>
      
      <div class="lg:w-1/2 lg:pl-12">
        <div class="mb-4">
          <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold <?= 'bg-' . getColorForCategory($podcast['category_slug']) . '-500' ?>">
            <?= htmlspecialchars($podcast['category_name']) ?>
          </span>
          <span class="ml-3 text-gray-300 text-sm">
            <i class="far fa-calendar-alt mr-1"></i> 
            <?= date('F j, Y', strtotime($podcast['publish_date'])) ?>
          </span>
        </div>
        
        <h1 class="text-3xl lg:text-4xl font-display font-bold mb-4"><?= htmlspecialchars($podcast['title']) ?></h1>
        
        <div class="flex items-center mb-6">
          <span class="mr-4 flex items-center">
            <i class="far fa-clock mr-2"></i>
            <?= App\Models\Podcast::formatDuration($podcast['duration']) ?>
          </span>
          
          <a href="<?= $podcast['audio_url'] ?>" download class="mr-4 flex items-center hover:text-secondary transition">
            <i class="fas fa-download mr-2"></i>
            Download
          </a>
          
          <button class="flex items-center hover:text-secondary transition share-button" data-url="<?= $baseUrl ?>/podcast/<?= $podcast['slug'] ?>">
            <i class="fas fa-share-alt mr-2"></i>
            Share
          </button>
        </div>
        
        <!-- Podcast Player -->
        <div class="bg-black bg-opacity-30 rounded-md p-4 mb-6">
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
              <button class="w-12 h-12 bg-secondary text-primary rounded-full flex items-center justify-center hover:bg-opacity-90 transition play-button" data-audio="<?= $podcast['audio_url'] ?>">
                <i class="fas fa-play"></i>
              </button>
              <div class="ml-4">
                <span class="text-sm font-medium current-time">00:00</span>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-sm text-gray-300 duration">
                  <?= App\Models\Podcast::formatDuration($podcast['duration']) ?>
                </span>
              </div>
            </div>
            <div class="flex items-center space-x-4">
              <button class="text-white hover:text-secondary transition">
                <i class="fas fa-volume-up"></i>
              </button>
              <button class="text-white hover:text-secondary transition playback-rate" data-rate="1">
                1x
              </button>
            </div>
          </div>
          
          <!-- Audio Progress Bar -->
          <div class="relative h-2 bg-gray-600 rounded-full overflow-hidden cursor-pointer" id="progress-container">
            <div class="absolute left-0 top-0 h-full bg-secondary progress-bar" style="width: 0%"></div>
            <div class="absolute left-0 top-0 h-full w-2 bg-white rounded-full progress-handle" style="left: 0%"></div>
          </div>
        </div>
        
        <?php if (!empty($podcast['host_name'])): ?>
        <div class="flex items-center mb-6">
          <img src="<?= $podcast['host_image_url'] ?>" alt="<?= htmlspecialchars($podcast['host_name']) ?>" class="w-12 h-12 rounded-full object-cover mr-4">
          <div>
            <p class="font-semibold text-white">Hosted by <?= htmlspecialchars($podcast['host_name']) ?></p>
            <p class="text-sm text-gray-300"><?= htmlspecialchars($podcast['host_title']) ?></p>
          </div>
        </div>
        <?php endif; ?>
        
        <div class="flex flex-wrap gap-3">
          <a href="https://open.spotify.com" target="_blank" class="flex items-center bg-[#1DB954] text-white px-4 py-2 rounded-md font-medium hover:bg-opacity-90 transition">
            <i class="fab fa-spotify mr-2"></i> Spotify
          </a>
          <a href="https://podcasts.apple.com" target="_blank" class="flex items-center bg-white text-primary px-4 py-2 rounded-md font-medium hover:bg-opacity-90 transition">
            <i class="fab fa-apple mr-2"></i> Apple
          </a>
          <a href="https://youtube.com" target="_blank" class="flex items-center bg-[#F43E37] text-white px-4 py-2 rounded-md font-medium hover:bg-opacity-90 transition">
            <i class="fab fa-youtube mr-2"></i> YouTube
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Episode Content -->
<section class="py-12">
  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row">
      <div class="lg:w-2/3 lg:pr-12">
        <h2 class="text-2xl font-display font-bold mb-4">Episode Description</h2>
        <div class="prose prose-lg max-w-none mb-8">
          <p class="mb-4"><?= nl2br(htmlspecialchars($podcast['description'])) ?></p>
        </div>
        
        <!-- Episode Chapters (example) -->
        <h3 class="text-xl font-bold mb-4">Episode Chapters</h3>
        <div class="space-y-4 mb-8">
          <div class="flex border-b border-gray-200 pb-3">
            <span class="w-16 text-gray-500 font-medium">00:00</span>
            <span class="font-medium">Introduction and topic overview</span>
          </div>
          <div class="flex border-b border-gray-200 pb-3">
            <span class="w-16 text-gray-500 font-medium">03:45</span>
            <span class="font-medium">Background on the conservation challenges</span>
          </div>
          <div class="flex border-b border-gray-200 pb-3">
            <span class="w-16 text-gray-500 font-medium">12:18</span>
            <span class="font-medium">Interview with guest expert</span>
          </div>
          <div class="flex border-b border-gray-200 pb-3">
            <span class="w-16 text-gray-500 font-medium">27:40</span>
            <span class="font-medium">Case studies and success stories</span>
          </div>
          <div class="flex border-b border-gray-200 pb-3">
            <span class="w-16 text-gray-500 font-medium">38:15</span>
            <span class="font-medium">Lessons for conservation efforts</span>
          </div>
          <div class="flex">
            <span class="w-16 text-gray-500 font-medium">42:30</span>
            <span class="font-medium">Closing thoughts and next steps</span>
          </div>
        </div>
        
        <!-- Show Notes -->
        <h3 class="text-xl font-bold mb-4">Show Notes</h3>
        <div class="prose prose-lg max-w-none mb-8">
          <ul class="space-y-2">
            <li><strong>Referenced papers and studies:</strong>
              <ul class="ml-6 space-y-1 list-disc">
                <li>Johnson, T. et al. (2024). "Conservation outcomes in Eastern Siberia." <em>Journal of Wildlife Conservation</em>, 42(3), 215-230.</li>
                <li>Rivera, A. &amp; Chen, S. (2025). "Focus techniques for field researchers." <em>Mindfulness in Practice</em>, 18(1), 78-92.</li>
              </ul>
            </li>
            <li><strong>Organizations mentioned:</strong>
              <ul class="ml-6 space-y-1 list-disc">
                <li>International Wildlife Conservation Society</li>
                <li>Eastern Siberia Nature Preserve</li>
                <li>Wildlife Haven Foundation</li>
              </ul>
            </li>
            <li><strong>Resources for listeners:</strong>
              <ul class="ml-6 space-y-1 list-disc">
                <li>How to get involved in local conservation efforts</li>
                <li>Recommended reading on wildlife protection</li>
                <li>Links to donation opportunities</li>
              </ul>
            </li>
          </ul>
        </div>
        
        <!-- Comments Section (simplified) -->
        <h3 class="text-xl font-bold mb-4">Listener Comments</h3>
        <div class="space-y-6 mb-8">
          <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-start">
              <img src="<?= $baseUrl ?>/assets/images/podcast/user1.jpg" alt="User" class="w-10 h-10 rounded-full object-cover mr-3">
              <div>
                <div class="flex items-center">
                  <p class="font-semibold">Emma Rodriguez</p>
                  <span class="text-gray-500 text-sm ml-2">3 days ago</span>
                </div>
                <p class="text-gray-700 mt-1">This episode was incredibly informative! I had no idea about the recent conservation success with Amur leopards. Great job explaining the complex issues in an accessible way.</p>
              </div>
            </div>
          </div>
          
          <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-start">
              <img src="<?= $baseUrl ?>/assets/images/podcast/user2.jpg" alt="User" class="w-10 h-10 rounded-full object-cover mr-3">
              <div>
                <div class="flex items-center">
                  <p class="font-semibold">David Kim</p>
                  <span class="text-gray-500 text-sm ml-2">1 week ago</span>
                </div>
                <p class="text-gray-700 mt-1">I've been implementing the focus techniques mentioned in this episode for my own work, and I've noticed a significant improvement in my productivity. Thanks for combining mindfulness with conservation topics!</p>
              </div>
            </div>
          </div>
          
          <!-- Comment Form -->
          <div class="mt-8">
            <h4 class="font-semibold mb-3">Leave a Comment</h4>
            <form class="space-y-4">
              <div>
                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" rows="4" placeholder="Share your thoughts..."></textarea>
              </div>
              <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition">Post Comment</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <div class="lg:w-1/3 mt-8 lg:mt-0">
        <!-- Sidebar -->
        <div class="bg-gray-50 rounded-xl p-6 mb-8">
          <h3 class="text-xl font-bold mb-4">Subscribe to Wild Echoes</h3>
          <p class="text-gray-600 mb-4">Receive new episodes directly in your inbox. Never miss an update!</p>
          <form class="space-y-3">
            <input type="email" placeholder="Your email address" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
            <button type="submit" class="w-full px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition">Subscribe</button>
          </form>
        </div>
        
        <?php if (!empty($data['relatedPodcasts'])): ?>
        <!-- Related Episodes -->
        <div class="mb-8">
          <h3 class="text-xl font-bold mb-4">Related Episodes</h3>
          <div class="space-y-4">
            <?php foreach ($data['relatedPodcasts'] as $relatedPodcast): ?>
            <div class="flex items-start border-b border-gray-200 pb-4">
              <img src="<?= $relatedPodcast['image_url'] ?>" alt="<?= htmlspecialchars($relatedPodcast['title']) ?>" class="w-20 h-20 object-cover rounded-md mr-3">
              <div>
                <h4 class="font-medium hover:text-primary transition">
                  <a href="<?= $baseUrl ?>/podcast/<?= $relatedPodcast['slug'] ?>">
                    <?= htmlspecialchars($relatedPodcast['title']) ?>
                  </a>
                </h4>
                <p class="text-sm text-gray-500 mb-1"><?= date('M j, Y', strtotime($relatedPodcast['publish_date'])) ?> • <?= App\Models\Podcast::formatDuration($relatedPodcast['duration']) ?></p>
                <p class="text-sm text-gray-600"><?= htmlspecialchars(substr($relatedPodcast['description'], 0, 70)) ?>...</p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
        
        <!-- Categories Widget -->
        <div class="bg-gray-50 rounded-xl p-6 mb-8">
          <h3 class="text-lg font-bold mb-4">Browse Categories</h3>
          <div class="space-y-2">
            <?php 
            $categoryModel = new App\Models\Podcast($GLOBALS['db']);
            $categories = $categoryModel->getAllCategories();
            foreach ($categories as $category): 
            ?>
            <a href="<?= $baseUrl ?>/podcast/category/<?= $category['slug'] ?>" class="block py-2 px-3 rounded hover:bg-gray-200 transition flex justify-between items-center">
              <span><?= htmlspecialchars($category['name']) ?></span>
              <span class="text-sm bg-gray-200 rounded-full px-2 py-1"><?= $category['podcast_count'] ?></span>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        
        <!-- Support Widget -->
        <div class="bg-primary text-white rounded-xl p-6">
          <h3 class="text-xl font-bold mb-3">Support Our Podcast</h3>
          <p class="mb-4">Your contribution helps us create more content and support wildlife conservation efforts around the world.</p>
          <a href="#" class="block w-full text-center px-4 py-2 bg-secondary text-primary rounded-md font-medium hover:bg-opacity-90 transition">
            Become a Supporter
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const audioPlayer = new Audio('<?= $podcast['audio_url'] ?>');
  const playButton = document.querySelector('.play-button');
  const progressBar = document.querySelector('.progress-bar');
  const progressHandle = document.querySelector('.progress-handle');
  const currentTimeElement = document.querySelector('.current-time');
  const progressContainer = document.getElementById('progress-container');
  const playbackRateButton = document.querySelector('.playback-rate');
  let progressInterval = null;
  
  // Play/pause functionality
  playButton.addEventListener('click', function() {
    if (audioPlayer.paused) {
      audioPlayer.play()
        .then(() => {
          this.innerHTML = '<i class="fas fa-pause"></i>';
          progressInterval = setInterval(updateProgress, 1000);
        })
        .catch(error => {
          console.error('Error playing audio:', error);
        });
    } else {
      audioPlayer.pause();
      this.innerHTML = '<i class="fas fa-play"></i>';
      clearInterval(progressInterval);
    }
  });
  
  // Update progress function
  function updateProgress() {
    if (audioPlayer.paused || audioPlayer.ended) {
      clearInterval(progressInterval);
      playButton.innerHTML = '<i class="fas fa-play"></i>';
      return;
    }
    
    const progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
    progressBar.style.width = `${progress}%`;
    progressHandle.style.left = `${progress}%`;
    
    // Format and display current time
    const minutes = Math.floor(audioPlayer.currentTime / 60);
    const seconds = Math.floor(audioPlayer.currentTime % 60);
    currentTimeElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
  }
  
  // Click on progress bar to seek
  progressContainer.addEventListener('click', function(e) {
    const rect = this.getBoundingClientRect();
    const clickPosition = (e.clientX - rect.left) / rect.width;
    const seekTime = clickPosition * audioPlayer.duration;
    
    audioPlayer.currentTime = seekTime;
    updateProgress();
  });
  
  // Playback rate control
  playbackRateButton.addEventListener('click', function() {
    const currentRate = parseFloat(this.getAttribute('data-rate'));
    let newRate = 1;
    
    // Cycle through rates: 1 -> 1.25 -> 1.5 -> 2 -> 1
    if (currentRate === 1) newRate = 1.25;
    else if (currentRate === 1.25) newRate = 1.5;
    else if (currentRate === 1.5) newRate = 2;
    else if (currentRate === 2) newRate = 1;
    
    // Update audio playback rate
    audioPlayer.playbackRate = newRate;
    
    // Update button text and data attribute
    this.textContent = `${newRate}x`;
    this.setAttribute('data-rate', newRate);
  });
  
  // Share button functionality
  document.querySelector('.share-button').addEventListener('click', function() {
    const url = this.getAttribute('data-url');
    
    if (navigator.share) {
      navigator.share({
        title: '<?= htmlspecialchars($podcast['title']) ?> - Wild Echoes Podcast',
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