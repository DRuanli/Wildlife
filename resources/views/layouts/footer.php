<?php
// Path: resources/views/layouts/footer.php
$baseUrl = '/Wildlife';
?>

</main>

<footer class="bg-primary text-white mt-12 relative overflow-hidden">
  <!-- Nature-inspired background pattern -->
  <div class="absolute inset-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <pattern id="leaf-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M30,50 Q50,20 70,50 Q50,80 30,50 Z" fill="currentColor"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#leaf-pattern)"/>
    </svg>
  </div>
  
  <div class="relative z-10">
    <!-- Newsletter Banner -->
    <div class="bg-secondary bg-opacity-20 py-6">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="mb-4 md:mb-0">
            <h3 class="text-xl font-display font-semibold">Stay Connected with Wildlife Haven</h3>
            <p class="text-gray-200">Receive conservation updates and exclusive content</p>
          </div>
          <form action="#" method="POST" class="flex w-full md:w-auto">
            <input type="email" name="email" placeholder="Your email address" required
                  class="w-full md:w-64 px-4 py-3 rounded-l-md bg-white bg-opacity-10 border border-white border-opacity-20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent">
            <button type="submit" class="px-6 py-3 bg-secondary text-primary font-medium rounded-r-md hover:bg-opacity-90 transition whitespace-nowrap">
              Subscribe
            </button>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Main Footer Content -->
    <div class="container mx-auto px-4 py-12">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        <!-- Brand Column -->
        <div class="md:col-span-4">
          <div class="flex items-center mb-4">
            <div class="h-12 w-12 bg-white rounded-full flex items-center justify-center mr-3">
              <i class="fas fa-paw text-primary text-xl"></i>
            </div>
            <span class="text-2xl font-bold font-display">Wildlife Haven</span>
          </div>
          <p class="text-gray-300 mb-6">
            Focus on what matters, help wildlife thrive. Join our mission to protect endangered species through mindful productivity.
          </p>
          <div class="flex space-x-4 mb-6">
            <a href="#" class="h-10 w-10 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-secondary hover:text-primary transition-all">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="h-10 w-10 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-secondary hover:text-primary transition-all">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="h-10 w-10 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-secondary hover:text-primary transition-all">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="h-10 w-10 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-secondary hover:text-primary transition-all">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="md:col-span-2">
          <h3 class="text-sm font-semibold text-secondary uppercase tracking-wider mb-4">App Features</h3>
          <ul class="space-y-3">
            <li><a href="<?= $baseUrl ?>/dashboard" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Dashboard</a></li>
            <li><a href="<?= $baseUrl ?>/focus" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Focus Timer</a></li>
            <li><a href="<?= $baseUrl ?>/creatures" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Creatures</a></li>
            <li><a href="<?= $baseUrl ?>/habitats" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Habitats</a></li>
          </ul>
        </div>
        
        <div class="md:col-span-2">
          <h3 class="text-sm font-semibold text-secondary uppercase tracking-wider mb-4">Community</h3>
          <ul class="space-y-3">
            <li><a href="<?= $baseUrl ?>/marketplace" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Marketplace</a></li>
            <li><a href="<?= $baseUrl ?>/conservation" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Conservation</a></li>
            <li><a href="<?= $baseUrl ?>/community" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Forums</a></li>
            <li><a href="<?= $baseUrl ?>/community/leaderboard" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Leaderboard</a></li>
          </ul>
        </div>
        
        <div class="md:col-span-2">
          <h3 class="text-sm font-semibold text-secondary uppercase tracking-wider mb-4">Resources</h3>
          <ul class="space-y-3">
            <li><a href="<?= $baseUrl ?>/learn/support" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Support</a></li>
            <li><a href="<?= $baseUrl ?>/faq" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> FAQ</a></li>
            <li><a href="<?= $baseUrl ?>/contact" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Contact Us</a></li>
            <li><a href="<?= $baseUrl ?>/blog" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Blog</a></li>
          </ul>
        </div>
        
        <div class="md:col-span-2">
          <h3 class="text-sm font-semibold text-secondary uppercase tracking-wider mb-4">Legal</h3>
          <ul class="space-y-3">
            <li><a href="<?= $baseUrl ?>/terms" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Terms of Use</a></li>
            <li><a href="<?= $baseUrl ?>/privacy" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Privacy Policy</a></li>
            <li><a href="<?= $baseUrl ?>/cookies" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Cookie Policy</a></li>
            <li><a href="<?= $baseUrl ?>/licenses" class="text-gray-300 hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-secondary"></i> Licenses</a></li>
          </ul>
        </div>
      </div>

      <!-- Download App Section -->
      <div class="mt-12 pt-8 border-t border-white border-opacity-10">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="mb-6 md:mb-0">
            <h3 class="text-xl font-semibold mb-2">Download Our App</h3>
            <p class="text-gray-300">Track your focus sessions on the go and help wildlife conservation</p>
          </div>
          <div class="flex space-x-4">
            <a href="#" class="flex items-center bg-white bg-opacity-10 hover:bg-opacity-20 transition px-4 py-2 rounded-md">
              <i class="fab fa-apple text-2xl mr-2"></i>
              <div>
                <span class="text-xs">Download on the</span>
                <p class="font-medium">App Store</p>
              </div>
            </a>
            <a href="#" class="flex items-center bg-white bg-opacity-10 hover:bg-opacity-20 transition px-4 py-2 rounded-md">
              <i class="fab fa-google-play text-2xl mr-2"></i>
              <div>
                <span class="text-xs">Get it on</span>
                <p class="font-medium">Google Play</p>
              </div>
            </a>
          </div>
        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="mt-12 pt-6 border-t border-white border-opacity-10 flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-400 text-sm">
          &copy; <?= date('Y') ?> Wildlife Haven. All rights reserved.
        </p>
        <div class="mt-4 md:mt-0">
          <p class="text-gray-400 text-sm flex items-center">
            <i class="fas fa-heart text-red-500 mr-2"></i> Crafted with love for wildlife conservation
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- JavaScript -->
<script src="<?= $baseUrl ?>/js/main.js"></script>
<script>
  // Toggle mobile menu
  document.getElementById('mobile-menu-button').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
  });

  // Toggle user menu dropdown
  const userMenuButton = document.getElementById('user-menu-button');
  if (userMenuButton) {
    userMenuButton.addEventListener('click', function() {
      document.getElementById('user-menu').classList.toggle('hidden');
    });
    
    // Close the dropdown when clicking outside
    window.addEventListener('click', function(event) {
      if (!userMenuButton.contains(event.target)) {
        document.getElementById('user-menu').classList.add('hidden');
      }
    });
  }
</script>
</body>
</html>