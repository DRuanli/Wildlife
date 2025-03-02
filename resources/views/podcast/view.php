<?php
// Path: resources/views/podcast/view.php
$baseUrl = $data['baseUrl'] ?? '/Wildlife';
$podcast = $data['podcast'];
?>

<?php include ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Immersive Hero Section with Background Blur -->
<section class="relative overflow-hidden">
  <!-- Background Image with Blur and Gradient Overlay -->
  <div class="absolute inset-0 bg-gradient-to-b from-gray-900 via-primary/90 to-primary/80">
    <div class="absolute inset-0 opacity-30 bg-blend-multiply" style="background-image: url('<?= $podcast['image_url'] ?>'); background-size: cover; background-position: center; filter: blur(70px);"></div>
  </div>

  <div class="container mx-auto px-4 pt-8 pb-16 relative z-10">
    <!-- Return Link -->
    <a href="<?= $baseUrl ?>/podcast" class="inline-flex items-center text-gray-300 hover:text-white mb-8 group">
      <i class="fas fa-arrow-left mr-2 transition-transform duration-300 group-hover:-translate-x-1"></i>
      Back to all episodes
    </a>

    <div class="flex flex-col lg:flex-row items-center lg:items-start">
      <!-- Episode Artwork -->
      <div class="w-64 h-64 md:w-80 md:h-80 shrink-0 mb-8 lg:mb-0 lg:mr-12">
        <div class="relative group">
          <div class="absolute -inset-2 bg-white/10 rounded-xl blur-md opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
          <div class="relative aspect-square rounded-xl overflow-hidden shadow-2xl border-2 border-white/20">
            <img src="<?= $podcast['image_url'] ?>" alt="<?= htmlspecialchars($podcast['title']) ?>" class="w-full h-full object-cover">
            
            <!-- Play Button Overlay -->
            <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <button class="w-16 h-16 bg-primary rounded-full flex items-center justify-center shadow-lg text-white transform transition hover:scale-110 main-play-button" data-audio="<?= $podcast['audio_url'] ?>">
                <i class="fas fa-play text-xl"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Episode Details -->
      <div class="text-white lg:flex-1">
        <div class="flex flex-wrap items-center gap-2 mb-4">
          <span class="px-3 py-1 rounded-full text-sm font-semibold <?= 'bg-' . getColorForCategory($podcast['category_slug']) . '-500' ?>">
            <?= htmlspecialchars($podcast['category_name']) ?>
          </span>
          <span class="text-gray-300 text-sm">
            Episode <?= rand(30, 50) ?> • <?= date('F j, Y', strtotime($podcast['publish_date'])) ?>
          </span>
          
          <?php if ($podcast['featured']): ?>
          <span class="px-3 py-1 rounded-full text-xs font-semibold bg-secondary text-primary">
            Featured
          </span>
          <?php endif; ?>
        </div>
        
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-4 leading-tight">
          <?= htmlspecialchars($podcast['title']) ?>
        </h1>
        
        <!-- Host Info & Stats -->
        <div class="flex items-center mb-6">
          <?php if (!empty($podcast['host_image_url'])): ?>
          <img src="<?= $podcast['host_image_url'] ?>" alt="<?= htmlspecialchars($podcast['host_name']) ?>" class="w-12 h-12 rounded-full object-cover border-2 border-white/20 mr-4">
          <?php endif; ?>
          
          <div>
            <p class="font-medium">
              <?= !empty($podcast['host_name']) ? 'Hosted by ' . htmlspecialchars($podcast['host_name']) : 'Wild Echoes Podcast' ?>
            </p>
            <p class="text-sm text-gray-300">
              <?= !empty($podcast['host_title']) ? htmlspecialchars($podcast['host_title']) : 'Wildlife Conservation Podcast' ?>
            </p>
          </div>
        </div>
        
        <!-- Stats -->
        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mb-6 text-sm text-gray-300">
          <div class="flex items-center">
            <i class="far fa-clock mr-2"></i>
            <?= App\Models\Podcast::formatDuration($podcast['duration']) ?>
          </div>
          <div class="flex items-center">
            <i class="far fa-play-circle mr-2"></i>
            <?= rand(500, 5000) ?> plays
          </div>
          <div class="flex items-center">
            <i class="far fa-comment mr-2"></i>
            <?= rand(5, 50) ?> comments
          </div>
          <div class="flex items-center">
            <i class="fas fa-star text-yellow-400 mr-1"></i>
            <i class="fas fa-star text-yellow-400 mr-1"></i>
            <i class="fas fa-star text-yellow-400 mr-1"></i>
            <i class="fas fa-star text-yellow-400 mr-1"></i>
            <i class="fas fa-star-half-alt text-yellow-400 mr-1"></i>
            <span>(<?= rand(10, 100) ?>)</span>
          </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3">
          <button class="px-6 py-3 bg-primary hover:bg-opacity-80 text-white rounded-full font-medium transition flex items-center play-button" data-audio="<?= $podcast['audio_url'] ?>">
            <i class="fas fa-play mr-2"></i> Play Episode
          </button>
          <button class="px-6 py-3 bg-white/10 backdrop-blur hover:bg-white/20 text-white rounded-full font-medium transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Add to Queue
          </button>
          <a href="<?= $podcast['audio_url'] ?>" download class="p-3 bg-white/10 backdrop-blur hover:bg-white/20 text-white rounded-full transition">
            <i class="fas fa-download"></i>
          </a>
          <button class="p-3 bg-white/10 backdrop-blur hover:bg-white/20 text-white rounded-full transition share-button" data-url="<?= $baseUrl ?>/podcast/<?= $podcast['slug'] ?>" data-title="<?= htmlspecialchars($podcast['title']) ?>">
            <i class="fas fa-share-alt"></i>
          </button>
          <button class="p-3 bg-white/10 backdrop-blur hover:bg-white/20 text-white rounded-full transition">
            <i class="fas fa-ellipsis-h"></i>
          </button>
        </div>

        <!-- Quick Description -->
        <div class="mt-6 bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-white/10">
          <p class="text-gray-200">
            <?= nl2br(htmlspecialchars(substr($podcast['description'], 0, 200))) ?>...
            <button class="text-secondary hover:underline ml-1 read-more-btn">Read more</button>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Waveform Player Section -->
<section class="bg-gray-900 text-white py-6 sticky top-0 z-30 shadow-md" id="audio-player-section">
  <div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row items-center">
      <!-- Play Controls -->
      <div class="flex items-center mb-4 md:mb-0 md:mr-6">
        <button class="w-12 h-12 bg-primary rounded-full flex items-center justify-center mr-4 shadow-lg hover:bg-opacity-80 transition play-button" data-audio="<?= $podcast['audio_url'] ?>">
          <i class="fas fa-play"></i>
        </button>
        
        <div>
          <span class="text-sm font-medium current-time">00:00</span>
          <span class="mx-1 text-gray-400">/</span>
          <span class="text-sm text-gray-400 duration"><?= gmdate("i:s", $podcast['duration']) ?></span>
        </div>
      </div>
      
      <!-- Waveform -->
      <div class="flex-grow relative h-16 mb-4 md:mb-0">
        <!-- Waveform Visualization -->
        <div class="absolute inset-0 flex items-center">
          <?php
            // Generate a fake waveform
            $totalBars = 100;
            $heights = [];
            
            // Seed the random number generator so we get consistent waveform for the same podcast
            srand(crc32($podcast['title']));
            
            for ($i = 0; $i < $totalBars; $i++) {
              $height = rand(10, 90);
              $heights[] = $height;
            }
            
            // Smoothen the waveform a bit
            for ($i = 1; $i < $totalBars - 1; $i++) {
              $heights[$i] = round(($heights[$i-1] + $heights[$i] + $heights[$i+1]) / 3);
            }
          ?>
          
          <div class="w-full h-12 flex items-center justify-between">
            <?php foreach ($heights as $index => $height): ?>
              <div class="waveform-bar h-<?= min(12, max(1, round($height/10))) ?> bg-gray-600 w-1 mx-px rounded-full transition-all duration-200" 
                   data-index="<?= $index ?>" 
                   style="height: <?= $height ?>%"></div>
            <?php endforeach; ?>
          </div>
          
          <!-- Progress Overlay -->
          <div class="absolute left-0 top-0 h-full bg-gradient-to-r from-secondary to-secondary/80 progress-wave" style="width: 0%; overflow: hidden;">
            <div class="w-full h-12 flex items-center justify-between">
              <?php foreach ($heights as $index => $height): ?>
                <div class="h-<?= min(12, max(1, round($height/10))) ?> bg-white w-1 mx-px rounded-full" 
                     style="height: <?= $height ?>%"></div>
              <?php endforeach; ?>
            </div>
          </div>
          
          <!-- Progress Handle -->
          <div class="absolute top-0 h-full progress-handle" style="left: 0%">
            <div class="absolute left-0 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3 h-3 bg-white rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>
        </div>
      </div>
      
      <!-- Additional Controls -->
      <div class="flex items-center space-x-4">
        <div class="relative group">
          <button class="text-white focus:outline-none playback-rate" title="Playback Speed">
            <span class="text-sm font-medium">1.0x</span>
          </button>
          
          <div class="absolute bottom-full right-0 mb-2 bg-gray-800 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 w-24">
            <div class="py-1">
              <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-700 transition speed-option" data-speed="0.5">0.5x</button>
              <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-700 transition speed-option" data-speed="0.75">0.75x</button>
              <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-700 transition speed-option" data-speed="1">1.0x</button>
              <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-700 transition speed-option" data-speed="1.25">1.25x</button>
              <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-700 transition speed-option" data-speed="1.5">1.5x</button>
              <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-700 transition speed-option" data-speed="2">2.0x</button>
            </div>
          </div>
        </div>
        
        <div class="relative group">
          <button class="text-white focus:outline-none" title="Volume">
            <i class="fas fa-volume-up"></i>
          </button>
          
          <div class="absolute bottom-full right-0 mb-2 h-24 w-8 bg-gray-800 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 p-2">
            <div class="h-full w-full relative">
              <div class="absolute inset-x-0 bottom-0 bg-gray-600 rounded-full" style="height: 70%"></div>
              <input type="range" min="0" max="100" value="70" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer volume-control">
            </div>
          </div>
        </div>
        
        <button class="text-white focus:outline-none" title="Forward 15 seconds">
          <i class="fas fa-forward-step"></i>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-white">
  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Left Column (Episode Details) -->
      <div class="lg:w-2/3">
        <!-- Episode Navigator -->
        <div class="flex items-center justify-between mb-8">
          <a href="#" class="px-4 py-2 border border-gray-200 rounded-lg flex items-center text-gray-600 hover:bg-gray-50 transition">
            <i class="fas fa-chevron-left mr-2"></i>
            Previous Episode
          </a>
          
          <div class="flex items-center">
            <div class="h-8 w-8 bg-primary/10 text-primary rounded-full flex items-center justify-center font-medium mr-2">
              <?= rand(30, 50) ?>
            </div>
            <span class="text-gray-600">of <?= rand(70, 100) ?></span>
          </div>
          
          <a href="#" class="px-4 py-2 border border-gray-200 rounded-lg flex items-center text-gray-600 hover:bg-gray-50 transition">
            Next Episode
            <i class="fas fa-chevron-right ml-2"></i>
          </a>
        </div>
        
        <!-- Episode Tabs -->
        <div class="mb-8">
          <div class="border-b border-gray-200">
            <nav class="flex -mb-px space-x-8">
              <button class="py-4 px-1 border-b-2 border-primary text-primary font-medium whitespace-nowrap episode-tab active" data-tab="description">
                Description
              </button>
              <button class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium whitespace-nowrap episode-tab" data-tab="chapters">
                Chapters
              </button>
              <button class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium whitespace-nowrap episode-tab" data-tab="notes">
                Show Notes
              </button>
              <button class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium whitespace-nowrap episode-tab" data-tab="transcript">
                Transcript
              </button>
              <button class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium whitespace-nowrap episode-tab" data-tab="comments">
                Comments (<?= rand(5, 50) ?>)
              </button>
            </nav>
          </div>
        </div>
        
        <!-- Tab Content -->
        <div>
          <!-- Description Tab (Visible by Default) -->
          <div class="tab-content active" id="description-content">
            <div class="prose prose-lg max-w-none">
              <p class="mb-4"><?= nl2br(htmlspecialchars($podcast['description'])) ?></p>
              
              <?php 
              // Generate some additional paragraphs based on the title and description
              $additionalContent = [
                "In this enlightening episode, we delve deep into the fascinating world of wildlife conservation and the mindful approaches that are making a difference. Our conversation brings together experts from various fields to discuss sustainable solutions and innovative practices.",
                
                "Our guest shares personal experiences from years of fieldwork and research, offering unique insights that challenge conventional wisdom. We explore the complex relationships between human development, technological advancement, and the preservation of our natural world.",
                
                "The discussion also touches on how individuals can contribute to conservation efforts through simple daily practices and mindful consumption. By the end of this episode, listeners will have a deeper understanding of the issues at hand and practical steps they can take to make a positive impact."
              ];
              
              foreach ($additionalContent as $paragraph): 
              ?>
                <p class="mb-4"><?= $paragraph ?></p>
              <?php endforeach; ?>
              
              <h3 class="text-xl font-bold mt-6 mb-3">Key Insights</h3>
              <ul class="list-disc pl-5 space-y-2">
                <li>The critical role of community engagement in successful conservation projects</li>
                <li>How technological innovations are transforming wildlife monitoring and protection</li>
                <li>The connection between mindfulness practices and deeper appreciation for nature</li>
                <li>Practical ways individuals can support conservation efforts regardless of their location</li>
                <li>Success stories that demonstrate the positive impact of dedicated conservation work</li>
              </ul>
            </div>
          </div>
          
          <!-- Chapters Tab -->
          <div class="tab-content hidden" id="chapters-content">
            <div class="space-y-1">
              <?php
                // Generate fake chapters
                $chapterCount = rand(5, 10);
                $chapterTitles = [
                  "Introduction and Overview",
                  "Background on Conservation Challenges",
                  "Interview with Guest Expert",
                  "Key Research Findings",
                  "Case Studies and Success Stories",
                  "Technological Solutions",
                  "Community Involvement Strategies",
                  "Mindfulness Approaches",
                  "Practical Tips for Listeners",
                  "Future Outlook and Closing Thoughts"
                ];
                
                $totalSeconds = $podcast['duration'];
                $chapters = [];
                
                for ($i = 0; $i < $chapterCount; $i++) {
                  if ($i === 0) {
                    $startTime = 0;
                  } else {
                    $startTime = $chapters[$i-1]['endTime'];
                  }
                  
                  if ($i === $chapterCount - 1) {
                    $endTime = $totalSeconds;
                  } else {
                    $chapterLength = rand(floor($totalSeconds / ($chapterCount * 2)), floor($totalSeconds / $chapterCount));
                    $endTime = $startTime + $chapterLength;
                  }
                  
                  $chapters[] = [
                    'title' => $chapterTitles[$i],
                    'startTime' => $startTime,
                    'endTime' => $endTime
                  ];
                }
                
                foreach ($chapters as $index => $chapter):
                  $startFormatted = gmdate("i:s", $chapter['startTime']);
                  $durationFormatted = gmdate("i:s", $chapter['endTime'] - $chapter['startTime']);
                  $progressPercent = ($chapter['startTime'] / $totalSeconds) * 100;
              ?>
                <div class="chapter-item p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer" data-start="<?= $chapter['startTime'] ?>">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center">
                      <div class="w-8 text-right mr-4 text-gray-500"><?= $startFormatted ?></div>
                      <div class="mr-2 text-gray-400"><?= $index + 1 ?>.</div>
                      <div class="font-medium"><?= $chapter['title'] ?></div>
                    </div>
                    <div class="text-gray-500"><?= $durationFormatted ?></div>
                  </div>
                  
                  <!-- Chapter Progress Bar -->
                  <div class="h-1 bg-gray-200 rounded-full mt-3 relative">
                    <div class="absolute left-0 top-0 h-full bg-primary rounded-full" style="width: <?= $progressPercent ?>%"></div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          
          <!-- Show Notes Tab -->
          <div class="tab-content hidden" id="notes-content">
            <div class="prose prose-lg max-w-none">
              <h3>Referenced Resources</h3>
              <ul>
                <li>Johnson, T. et al. (2024). "Conservation outcomes in Eastern Siberia." <em>Journal of Wildlife Conservation</em>, 42(3), 215-230.</li>
                <li>Rivera, A. &amp; Chen, S. (2025). "Focus techniques for field researchers." <em>Mindfulness in Practice</em>, 18(1), 78-92.</li>
                <li>International Wildlife Conservation Society <a href="#" class="text-primary hover:underline">Website</a></li>
                <li>Eastern Siberia Nature Preserve <a href="#" class="text-primary hover:underline">Research Portal</a></li>
              </ul>
              
              <h3>Organizations Mentioned</h3>
              <ul>
                <li><strong>Wildlife Haven Foundation</strong> - Working to protect endangered species through education and conservation efforts.</li>
                <li><strong>Mindful Earth Alliance</strong> - Connecting mindfulness practices with environmental conservation.</li>
                <li><strong>Tech for Nature Consortium</strong> - Developing technological solutions for wildlife monitoring and protection.</li>
              </ul>
              
              <h3>Guest Information</h3>
              <p><strong>Dr. Elena Ivanova</strong> - Leading researcher at the Eastern Siberia Wildlife Institute with over 15 years of experience studying endangered big cats. Dr. Ivanova has published extensively on conservation strategies and habitat preservation.</p>
              
              <h3>Further Reading</h3>
              <ul>
                <li>"The Mindful Conservationist" by Dr. Sarah Chen</li>
                <li>"Technology and Wildlife: A Modern Approach to Conservation" by Alex Rivera</li>
                <li>"Saving the Amur Leopard: A Conservation Success Story" by Elena Ivanova</li>
              </ul>
            </div>
          </div>
          
          <!-- Transcript Tab -->
          <div class="tab-content hidden" id="transcript-content">
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
              <p class="text-gray-600 text-sm">This transcript is auto-generated and may contain errors. If you notice any issues, please <a href="#" class="text-primary hover:underline">submit corrections</a>.</p>
            </div>
            
            <div class="space-y-6">
              <?php
                // Generate a fake transcript based on the podcast title and description
                $hostName = !empty($podcast['host_name']) ? $podcast['host_name'] : 'Sarah';
                $guestName = 'Dr. Elena';
                
                $transcriptLines = [
                  ['speaker' => $hostName, 'text' => "Welcome to Wild Echoes! I'm $hostName, and today we're discussing " . strtolower(preg_replace('/^The/', '', $podcast['title'])) . ". This is such an important topic in wildlife conservation right now."],
                  
                  ['speaker' => $hostName, 'text' => "We're joined by $guestName, a leading expert in this field. Thanks for being with us today!"],
                  
                  ['speaker' => $guestName, 'text' => "Thank you for having me, $hostName. I'm excited to share some insights on this fascinating subject."],
                  
                  ['speaker' => $hostName, 'text' => "Let's start with some background. Can you tell our listeners why this topic is so significant right now?"],
                  
                  ['speaker' => $guestName, 'text' => "Absolutely. The work we've been doing has shown some remarkable results over the past few years. What we're seeing is a gradual but significant shift in how conservation efforts are being implemented and received by local communities."],
                  
                  ['speaker' => $hostName, 'text' => "That's fascinating. And I understand there have been some challenges along the way?"],
                  
                  ['speaker' => $guestName, 'text' => "Yes, indeed. One of the biggest obstacles we've faced is balancing the needs of wildlife with the economic realities of the regions where these animals live. It's a complex interplay of ecological, social, and economic factors."],
                  
                  ['speaker' => $hostName, 'text' => "I imagine our listeners would be interested in knowing how they can contribute to these efforts, even from afar."],
                  
                  ['speaker' => $guestName, 'text' => "There are actually many ways individuals can help, regardless of where they're located. From supporting reputable conservation organizations to making mindful consumer choices, every action counts."],
                  
                  ['speaker' => $hostName, 'text' => "Could you elaborate on some of the success stories you've witnessed firsthand?"],
                  
                  ['speaker' => $guestName, 'text' => "One particularly inspiring case involves a community in Eastern Siberia that transformed from being skeptical about conservation efforts to becoming passionate advocates. They've developed innovative approaches that serve as a model for other regions."],
                ];
                
                foreach ($transcriptLines as $index => $line):
                  $timestamp = gmdate("i:s", round($index * ($podcast['duration'] / count($transcriptLines))));
              ?>
                <div class="flex">
                  <div class="w-16 text-right text-gray-400 text-sm pt-1">
                    <?= $timestamp ?>
                  </div>
                  <div class="ml-4 flex-grow">
                    <p class="font-semibold text-gray-800"><?= $line['speaker'] ?></p>
                    <p class="text-gray-600"><?= $line['text'] ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
              
              <div class="mt-6 text-center">
                <button class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                  Load Full Transcript
                </button>
              </div>
            </div>
          </div>
          
          <!-- Comments Tab -->
          <div class="tab-content hidden" id="comments-content">
            <div class="mb-8">
              <h3 class="text-xl font-bold mb-4">Leave a Comment</h3>
              <form class="space-y-4">
                <div>
                  <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" 
                            rows="4" placeholder="Share your thoughts on this episode..."></textarea>
                </div>
                <div class="flex justify-between items-center">
                  <div class="flex items-center">
                    <div class="flex text-yellow-400">
                      <i class="far fa-star cursor-pointer"></i>
                      <i class="far fa-star cursor-pointer"></i>
                      <i class="far fa-star cursor-pointer"></i>
                      <i class="far fa-star cursor-pointer"></i>
                      <i class="far fa-star cursor-pointer"></i>
                    </div>
                    <span class="ml-2 text-sm text-gray-500">Rate this episode</span>
                  </div>
                  <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90 transition">
                    Post Comment
                  </button>
                </div>
              </form>
            </div>
            
            <div class="space-y-6">
              <?php
                // Generate fake comments
                $comments = [
                  [
                    'name' => 'Michael Chen',
                    'avatar' => $baseUrl . '/assets/images/podcast/user2.jpg',
                    'rating' => 5,
                    'date' => '3 days ago',
                    'text' => "This episode was incredibly informative! I had no idea about the recent conservation success with Amur leopards. The discussion about community engagement strategies was particularly helpful for my own work."
                  ],
                  [
                    'name' => 'Emma Rodriguez',
                    'avatar' => $baseUrl . '/assets/images/podcast/user1.jpg',
                    'rating' => 4,
                    'date' => '1 week ago',
                    'text' => "I've been implementing the focus techniques mentioned in this episode for my own work, and I've noticed a significant improvement in my productivity. Thanks for combining mindfulness with conservation topics!"
                  ],
                  [
                    'name' => 'David Kim',
                    'avatar' => $baseUrl . '/assets/images/podcast/user3.jpg',
                    'rating' => 5,
                    'date' => '2 weeks ago',
                    'text' => "The interview with Dr. Elena was fascinating. I appreciate how you took complex scientific information and made it accessible without oversimplifying. I'll definitely be sharing this episode with my conservation biology students."
                  ]
                ];
                
                foreach ($comments as $comment):
              ?>
                <div class="bg-gray-50 rounded-lg p-4">
                  <div class="flex items-start">
                    <img src="<?= $comment['avatar'] ?>" alt="User" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div class="flex-grow">
                      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                        <div>
                          <h4 class="font-semibold"><?= $comment['name'] ?></h4>
                          <div class="flex text-yellow-400 text-sm">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                              <?php if ($i < $comment['rating']): ?>
                                <i class="fas fa-star"></i>
                              <?php else: ?>
                                <i class="far fa-star"></i>
                              <?php endif; ?>
                            <?php endfor; ?>
                          </div>
                        </div>
                        <span class="text-gray-500 text-sm"><?= $comment['date'] ?></span>
                      </div>
                      <p class="text-gray-700"><?= $comment['text'] ?></p>
                      
                      <div class="flex items-center mt-3 text-sm text-gray-500">
                        <button class="flex items-center hover:text-gray-700 transition mr-4">
                          <i class="far fa-thumbs-up mr-1"></i> Helpful (<?= rand(1, 20) ?>)
                        </button>
                        <button class="flex items-center hover:text-gray-700 transition">
                          <i class="far fa-comment mr-1"></i> Reply
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              
              <div class="text-center">
                <button class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                  Load More Comments
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Column (Sidebar) -->
      <div class="lg:w-1/3">
        <?php if (!empty($data['relatedPodcasts'])): ?>
        <!-- Related Episodes -->
        <div class="bg-gray-50 rounded-xl p-6 mb-8">
          <h3 class="text-lg font-bold mb-4">Related Episodes</h3>
          
          <div class="space-y-4">
            <?php foreach ($data['relatedPodcasts'] as $relatedPodcast): ?>
            <div class="flex items-start border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
              <div class="shrink-0 w-16 h-16 bg-gray-200 rounded-md overflow-hidden mr-3 group relative">
                <img src="<?= $relatedPodcast['image_url'] ?>" alt="<?= htmlspecialchars($relatedPodcast['title']) ?>" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                  <i class="fas fa-play text-white"></i>
                </div>
              </div>
              
              <div>
                <h4 class="font-medium line-clamp-2 hover:text-primary transition">
                  <a href="<?= $baseUrl ?>/podcast/<?= $relatedPodcast['slug'] ?>">
                    <?= htmlspecialchars($relatedPodcast['title']) ?>
                  </a>
                </h4>
                <p class="text-sm text-gray-500 mb-1"><?= date('M j, Y', strtotime($relatedPodcast['publish_date'])) ?> • <?= App\Models\Podcast::formatDuration($relatedPodcast['duration']) ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          
          <div class="mt-4">
            <a href="<?= $baseUrl ?>/podcast/category/<?= $podcast['category_slug'] ?>" class="text-primary hover:underline text-sm font-medium">
              View all <?= strtolower($podcast['category_name']) ?> episodes
            </a>
          </div>
        </div>
        <?php endif; ?>
        
        <!-- Subscribe Card -->
        <div class="mb-8 bg-primary text-white rounded-xl overflow-hidden">
          <div class="p-6">
            <h3 class="text-xl font-bold mb-3">Subscribe to Wild Echoes</h3>
            <p class="text-gray-200 mb-4">Never miss an episode. Available on all major podcast platforms.</p>
            
            <div class="grid grid-cols-2 gap-3 mb-4">
              <a href="https://open.spotify.com" target="_blank" class="bg-[#1DB954] py-2 px-3 rounded-lg flex items-center justify-center">
                <i class="fab fa-spotify text-lg mr-2"></i> Spotify
              </a>
              <a href="https://podcasts.apple.com" target="_blank" class="bg-white text-primary py-2 px-3 rounded-lg flex items-center justify-center">
                <i class="fab fa-apple text-lg mr-2"></i> Apple
              </a>
              <a href="https://podcasts.google.com" target="_blank" class="bg-[#4285F4] py-2 px-3 rounded-lg flex items-center justify-center">
                <i class="fab fa-google text-lg mr-2"></i> Google
              </a>
              <a href="#" class="bg-white/20 py-2 px-3 rounded-lg flex items-center justify-center">
                <i class="fas fa-rss text-lg mr-2"></i> RSS
              </a>
            </div>
            
            <div class="pt-4 border-t border-white/20">
              <form class="flex">
                <input type="email" placeholder="Your email" class="w-full px-3 py-2 rounded-l-lg bg-white/10 border border-white/30 text-white placeholder-gray-300 focus:outline-none">
                <button type="submit" class="px-4 py-2 bg-secondary text-primary rounded-r-lg font-medium">
                  <i class="fas fa-envelope"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
        
        <!-- Host Info -->
        <?php if (!empty($podcast['host_name'])): ?>
        <div class="mb-8 bg-gray-50 rounded-xl p-6">
          <div class="flex items-center mb-4">
            <img src="<?= $podcast['host_image_url'] ?>" alt="<?= htmlspecialchars($podcast['host_name']) ?>" class="w-14 h-14 rounded-full object-cover mr-4 border-2 border-primary">
            <div>
              <h3 class="font-bold"><?= htmlspecialchars($podcast['host_name']) ?></h3>
              <p class="text-gray-600 text-sm"><?= htmlspecialchars($podcast['host_title']) ?></p>
            </div>
          </div>
          
          <p class="text-gray-600 mb-4"><?= htmlspecialchars($podcast['host_bio'] ?? 'Host of Wild Echoes podcast, bringing you fascinating conversations at the intersection of wildlife conservation and mindful living.') ?></p>
          
          <div class="flex space-x-2">
            <a href="#" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-700 hover:bg-gray-300 transition">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-700 hover:bg-gray-300 transition">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-700 hover:bg-gray-300 transition">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div>
        <?php endif; ?>
        
        <!-- Tags -->
        <div class="mb-8">
          <h3 class="text-lg font-bold mb-3">Tags</h3>
          <div class="flex flex-wrap gap-2">
            <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-700 text-sm transition">
              #wildlife
            </a>
            <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-700 text-sm transition">
              #conservation
            </a>
            <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-700 text-sm transition">
              #mindfulness
            </a>
            <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-700 text-sm transition">
              #focustechniques
            </a>
            <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-700 text-sm transition">
              #nature
            </a>
            <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-700 text-sm transition">
              #sustainability
            </a>
          </div>
        </div>
        
        <!-- Support Card -->
        <div class="bg-gray-50 rounded-xl p-6">
          <h3 class="text-lg font-bold mb-3">Support Our Show</h3>
          <p class="text-gray-600 mb-4">If you enjoy our podcast, please consider supporting us to help continue creating quality content.</p>
          
          <div class="space-y-3">
            <a href="#" class="block w-full py-2 px-4 bg-primary text-white text-center rounded-lg hover:bg-opacity-90 transition">
              Become a Supporter
            </a>
            <a href="#" class="block w-full py-2 px-4 border border-gray-300 text-gray-700 text-center rounded-lg hover:bg-gray-100 transition">
              <i class="fas fa-gift mr-2"></i> Send a One-time Gift
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- More Episodes Section -->
<section class="py-12 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-2xl font-display font-bold">More Episodes</h2>
      <a href="<?= $baseUrl ?>/podcast" class="text-primary hover:underline font-medium flex items-center">
        View All Episodes
        <i class="fas fa-chevron-right ml-2"></i>
      </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php 
        // Combine related podcasts with random ones to fill the grid
        $displayPodcasts = $data['relatedPodcasts'] ?? [];
        
        // Get how many more we need
        $neededPodcasts = 4 - count($displayPodcasts);
        
        // Query for additional podcasts if needed
        if ($neededPodcasts > 0) {
          $podcastModel = new \App\Models\Podcast($GLOBALS['db']);
          $additionalPodcasts = $podcastModel->getAll(['category_id' => $podcast['category_id']], $neededPodcasts);
          
          // Filter out the current podcast and any duplicates
          $additionalPodcasts = array_filter($additionalPodcasts, function($p) use ($podcast, $displayPodcasts) {
            return $p['id'] != $podcast['id'] && !in_array($p['id'], array_column($displayPodcasts, 'id'));
          });
          
          $displayPodcasts = array_merge($displayPodcasts, $additionalPodcasts);
        }
        
        // Take only the first 4
        $displayPodcasts = array_slice($displayPodcasts, 0, 4);
        
        foreach ($displayPodcasts as $morePodcast):
      ?>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
          <div class="relative">
            <img src="<?= $morePodcast['image_url'] ?>" alt="<?= htmlspecialchars($morePodcast['title']) ?>" class="w-full h-48 object-cover">
            <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent">
              <div class="flex justify-between items-center">
                <span class="text-white text-sm font-medium">
                  <i class="far fa-clock mr-1"></i> <?= App\Models\Podcast::formatDuration($morePodcast['duration']) ?>
                </span>
                <button class="w-8 h-8 bg-primary rounded-full flex items-center justify-center shadow-lg text-white transform transition hover:scale-110">
                  <i class="fas fa-play"></i>
                </button>
              </div>
            </div>
          </div>
          
          <div class="p-4">
            <span class="inline-block px-2 py-1 rounded-full text-xs font-medium <?= 'bg-' . getColorForCategory($morePodcast['category_slug']) . '-100 text-' . getColorForCategory($morePodcast['category_slug']) . '-800' ?> mb-2">
              <?= htmlspecialchars($morePodcast['category_name']) ?>
            </span>
            
            <h3 class="font-bold mb-1 hover:text-primary transition line-clamp-2">
              <a href="<?= $baseUrl ?>/podcast/<?= $morePodcast['slug'] ?>">
                <?= htmlspecialchars($morePodcast['title']) ?>
              </a>
            </h3>
            
            <p class="text-gray-500 text-sm mb-3"><?= date('F j, Y', strtotime($morePodcast['publish_date'])) ?></p>
            
            <div class="flex justify-between items-center text-sm">
              <span class="text-gray-500">
                <i class="far fa-play-circle mr-1"></i> <?= rand(100, 900) ?> plays
              </span>
              <button class="text-gray-400 hover:text-gray-700 transition">
                <i class="far fa-heart"></i>
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Global Audio Player (Hidden) -->
<div id="global-player" class="fixed bottom-0 left-0 right-0 bg-gray-900 text-white transform translate-y-full transition-transform duration-300 shadow-lg z-50">
  <div class="container mx-auto px-4">
    <div class="flex items-center py-3">
      <!-- Episode Info -->
      <div class="flex items-center mr-6">
        <img src="<?= $podcast['image_url'] ?>" alt="Current Episode" id="player-image" class="w-12 h-12 rounded-md mr-3 object-cover">
        <div>
          <h4 class="font-medium text-sm line-clamp-1" id="player-title"><?= htmlspecialchars($podcast['title']) ?></h4>
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
          <span class="text-xs text-gray-400 ml-2 w-10" id="player-duration"><?= gmdate("i:s", $podcast['duration']) ?></span>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  /* Audio Player Logic */
  const audioPlayer = new Audio('<?= $podcast['audio_url'] ?>');
  let currentPlayButton = null;
  let progressInterval = null;
  let globalPlayerActive = false;
  let currentTab = 'description';
  
  // Play button functionality
  document.querySelectorAll('.play-button, .main-play-button').forEach(button => {
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
    });
  });
  
  // Chapter item click
  document.querySelectorAll('.chapter-item').forEach(item => {
    item.addEventListener('click', function() {
      const startTime = parseInt(this.getAttribute('data-start'));
      
      if (audioPlayer.paused) {
        // If player is paused, start playing from this chapter
        playAudio('<?= $podcast['audio_url'] ?>', document.querySelector('.main-play-button'));
        audioPlayer.currentTime = startTime;
      } else {
        // If already playing, just jump to this chapter
        audioPlayer.currentTime = startTime;
      }
    });
  });
  
  // Tab switching
  document.querySelectorAll('.episode-tab').forEach(tab => {
    tab.addEventListener('click', function() {
      const tabId = this.getAttribute('data-tab');
      
      // Hide all tab contents
      document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
      });
      
      // Show selected tab content
      document.getElementById(`${tabId}-content`).classList.remove('hidden');
      
      // Update tab styling
      document.querySelectorAll('.episode-tab').forEach(t => {
        t.classList.remove('border-primary', 'text-primary');
        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
      });
      
      this.classList.add('border-primary', 'text-primary');
      this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
      
      // Update current tab
      currentTab = tabId;
    });
  });
  
  // Read more button
  const readMoreBtn = document.querySelector('.read-more-btn');
  if (readMoreBtn) {
    readMoreBtn.addEventListener('click', function() {
      // Switch to description tab
      document.querySelector('.episode-tab[data-tab="description"]').click();
      
      // Scroll to content
      document.getElementById('description-content').scrollIntoView({ behavior: 'smooth' });
    });
  }
  
  // Star rating functionality
  document.querySelectorAll('.comment-form .fa-star').forEach((star, index) => {
    star.addEventListener('mouseover', function() {
      // Fill in stars up to this one
      for (let i = 0; i <= index; i++) {
        document.querySelectorAll('.comment-form .fa-star')[i].classList.remove('far');
        document.querySelectorAll('.comment-form .fa-star')[i].classList.add('fas');
      }
    });
    
    star.addEventListener('mouseout', function() {
      // Reset stars
      document.querySelectorAll('.comment-form .fa-star').forEach(s => {
        s.classList.remove('fas');
        s.classList.add('far');
      });
    });
    
    star.addEventListener('click', function() {
      // Set rating
      for (let i = 0; i <= index; i++) {
        document.querySelectorAll('.comment-form .fa-star')[i].classList.remove('far');
        document.querySelectorAll('.comment-form .fa-star')[i].classList.add('fas');
      }
      
      for (let i = index + 1; i < 5; i++) {
        document.querySelectorAll('.comment-form .fa-star')[i].classList.remove('fas');
        document.querySelectorAll('.comment-form .fa-star')[i].classList.add('far');
      }
    });
  });
  
  // Playback speed options
  document.querySelectorAll('.speed-option').forEach(option => {
    option.addEventListener('click', function() {
      const speed = parseFloat(this.getAttribute('data-speed'));
      
      // Update audio playback rate
      audioPlayer.playbackRate = speed;
      
      // Update button text
      document.querySelector('.playback-rate').textContent = `${speed}x`;
    });
  });
  
  // Volume control
  const volumeControl = document.querySelector('.volume-control');
  if (volumeControl) {
    volumeControl.addEventListener('input', function() {
      const volume = this.value / 100;
      audioPlayer.volume = volume;
    });
  }
  
  // Share button
  const shareButton = document.querySelector('.share-button');
  if (shareButton) {
    shareButton.addEventListener('click', function() {
      const url = this.getAttribute('data-url');
      const title = this.getAttribute('data-title');
      
      if (navigator.share) {
        navigator.share({
          title: title + ' - Wild Echoes Podcast',
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
  }
  
  // Play audio function
  function playAudio(url, button) {
    // Set audio source if it's different
    if (audioPlayer.src !== url) {
      audioPlayer.src = url;
      audioPlayer.load();
    }
    
    // Play audio
    audioPlayer.play()
      .then(() => {
        // Update button appearance
        if (button.classList.contains('main-play-button')) {
          button.innerHTML = '<i class="fas fa-pause text-xl"></i>';
        } else {
          button.innerHTML = '<i class="fas fa-pause"></i>';
        }
        
        // Update all play buttons
        document.querySelectorAll('.play-button').forEach(btn => {
          if (btn !== button) {
            btn.innerHTML = '<i class="fas fa-pause"></i>';
          }
        });
        
        // Update waveform player
        document.querySelector('#audio-player-section .play-button').innerHTML = '<i class="fas fa-pause"></i>';
        
        // Start progress update
        clearInterval(progressInterval);
        progressInterval = setInterval(updateProgress, 100);
      })
      .catch(error => {
        console.error('Error playing audio:', error);
      });
  }
  
  // Pause audio function
  function pauseAudio() {
    audioPlayer.pause();
    
    // Reset all play buttons
    document.querySelectorAll('.play-button, .main-play-button').forEach(btn => {
      if (btn.classList.contains('main-play-button')) {
        btn.innerHTML = '<i class="fas fa-play text-xl"></i>';
      } else {
        btn.innerHTML = '<i class="fas fa-play"></i>';
      }
    });
    
    clearInterval(progressInterval);
  }
  
  // Reset play button appearance
  function resetPlayButton(button) {
    if (button.classList.contains('main-play-button')) {
      button.innerHTML = '<i class="fas fa-play text-xl"></i>';
    } else {
      button.innerHTML = '<i class="fas fa-play"></i>';
    }
  }
  
  // Update progress function
  function updateProgress() {
    if (audioPlayer.paused || audioPlayer.ended) {
      clearInterval(progressInterval);
      pauseAudio();
      return;
    }
    
    // Calculate progress percentage
    const progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
    
    // Update waveform progress
    const progressWave = document.querySelector('.progress-wave');
    if (progressWave) {
      progressWave.style.width = `${progress}%`;
    }
    
    // Update progress handle
    const progressHandle = document.querySelector('.progress-handle');
    if (progressHandle) {
      progressHandle.style.left = `${progress}%`;
    }
    
    // Format and display current time
    const minutes = Math.floor(audioPlayer.currentTime / 60);
    const seconds = Math.floor(audioPlayer.currentTime % 60);
    const formattedTime = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    
    // Update all time displays
    document.querySelectorAll('.current-time').forEach(el => {
      el.textContent = formattedTime;
    });
    
    // Highlight current chapter based on time
    updateCurrentChapter();
  }
  
  // Update current chapter based on playback position
  function updateCurrentChapter() {
    const chapterItems = document.querySelectorAll('.chapter-item');
    if (chapterItems.length === 0) return;
    
    let currentChapterIndex = 0;
    
    for (let i = 0; i < chapterItems.length; i++) {
      const startTime = parseInt(chapterItems[i].getAttribute('data-start'));
      
      if (audioPlayer.currentTime >= startTime) {
        currentChapterIndex = i;
      } else {
        break;
      }
    }
    
    // Remove highlight from all chapters
    chapterItems.forEach(item => {
      item.classList.remove('bg-gray-100');
    });
    
    // Highlight current chapter
    chapterItems[currentChapterIndex].classList.add('bg-gray-100');
  }
  
  // Make waveform clickable
  const waveformContainer = document.querySelector('.progress-wave').parentNode;
  if (waveformContainer) {
    waveformContainer.addEventListener('click', function(e) {
      if (!audioPlayer.paused || audioPlayer.currentTime > 0) {
        const rect = this.getBoundingClientRect();
        const clickPosition = (e.clientX - rect.left) / rect.width;
        
        audioPlayer.currentTime = clickPosition * audioPlayer.duration;
        updateProgress();
      }
    });
  }
  
  // Initialize audio player when metadata is loaded
  audioPlayer.addEventListener('loadedmetadata', function() {
    const durationFormatted = formatTime(audioPlayer.duration);
    
    // Update all duration displays
    document.querySelectorAll('.duration').forEach(el => {
      el.textContent = durationFormatted;
    });
  });
  
  // Format time helper function
  function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${minutes}:${secs.toString().padStart(2, '0')}`;
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

<style>
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
</style>

<?php include ROOT_PATH . '/resources/views/layouts/footer.php'; ?>