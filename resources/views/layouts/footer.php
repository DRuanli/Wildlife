<?php
// Path: resources/views/layouts/footer.php
// Sử dụng biến $baseUrl từ header.php
?>

</main>

<footer class="bg-gray-900 text-white mt-12 relative overflow-hidden">
  <!-- Decorative Background Pattern (optional) -->
  <div class="absolute inset-0 opacity-20" style="background: url('<?= $baseUrl ?>/images/footer-pattern.png') repeat;"></div>
  <div class="relative z-10">
    <div class="container mx-auto px-4 py-12">
      <div class="flex flex-col md:flex-row justify-between items-start">
        <!-- Branding & Newsletter -->
        <div class="mb-8 md:mb-0">
          <div class="flex items-center">
            <img src="<?= $baseUrl ?>/images/logo.png" alt="Wildlife Haven Logo" class="h-12 w-auto mr-3">
            <span class="text-2xl font-bold">Wildlife Haven</span>
          </div>
          <p class="mt-3 text-gray-400">
            Focus on what matters, help wildlife thrive.
          </p>
          <!-- Newsletter Subscription -->
          <div class="mt-4">
            <p class="text-sm text-gray-400">Subscribe to our newsletter</p>
            <form action="#" method="POST" class="mt-2 flex max-w-sm">
              <input type="email" name="email" placeholder="Your email" required
                     class="w-full px-4 py-2 rounded-l-md focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]">
              <button type="submit" class="px-4 py-2 bg-[var(--primary-color)] text-white rounded-r-md hover:bg-opacity-90 transition">
                Subscribe
              </button>
            </form>
          </div>
        </div>

        <!-- Navigation Links -->
        <div class="grid grid-cols-2 gap-8 md:grid-cols-4 flex-grow">
          <div>
            <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">App</h3>
            <ul class="mt-4 space-y-2">
              <li><a href="<?= $baseUrl ?>/dashboard" class="text-gray-400 hover:text-white transition">Dashboard</a></li>
              <li><a href="<?= $baseUrl ?>/focus" class="text-gray-400 hover:text-white transition">Focus Timer</a></li>
              <li><a href="<?= $baseUrl ?>/creatures" class="text-gray-400 hover:text-white transition">Creatures</a></li>
              <li><a href="<?= $baseUrl ?>/habitats" class="text-gray-400 hover:text-white transition">Habitats</a></li>
            </ul>
          </div>
          
          <div>
            <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Community</h3>
            <ul class="mt-4 space-y-2">
              <li><a href="<?= $baseUrl ?>/marketplace" class="text-gray-400 hover:text-white transition">Marketplace</a></li>
              <li><a href="<?= $baseUrl ?>/conservation" class="text-gray-400 hover:text-white transition">Conservation</a></li>
              <li><a href="<?= $baseUrl ?>/community" class="text-gray-400 hover:text-white transition">Forums</a></li>
              <li><a href="<?= $baseUrl ?>/community/leaderboard" class="text-gray-400 hover:text-white transition">Leaderboard</a></li>
            </ul>
          </div>
          
          <div>
            <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Help</h3>
            <ul class="mt-4 space-y-2">
              <li><a href="<?= $baseUrl ?>/support" class="text-gray-400 hover:text-white transition">Support</a></li>
              <li><a href="<?= $baseUrl ?>/faq" class="text-gray-400 hover:text-white transition">FAQ</a></li>
              <li><a href="<?= $baseUrl ?>/contact" class="text-gray-400 hover:text-white transition">Contact Us</a></li>
              <li><a href="<?= $baseUrl ?>/privacy" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
            </ul>
          </div>
          
          <div>
            <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Follow Us</h3>
            <div class="mt-4 flex space-x-4">
              <a href="#" class="text-gray-400 hover:text-white transition">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="text-gray-400 hover:text-white transition">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="text-gray-400 hover:text-white transition">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="#" class="text-gray-400 hover:text-white transition">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="mt-10 pt-10 border-t border-gray-700 text-center">
        <p class="text-gray-400 text-sm">
          &copy; <?= date('Y') ?> Wildlife Haven. All rights reserved.
        </p>
        <p class="text-gray-500 text-xs mt-2">
          Crafted with <span class="text-red-500">&hearts;</span> for wildlife conservation.
        </p>
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
