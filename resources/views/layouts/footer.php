<?php
// Path: resources/views/layouts/footer.php
// Sử dụng biến $baseUrl từ header.php
?>

</main>
    
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center">
                        <img src="<?= $baseUrl ?>/images/logo.png" alt="Wildlife Haven Logo" class="h-10 w-auto mr-2">
                        <span class="text-xl font-bold">Wildlife Haven</span>
                    </div>
                    <p class="mt-2 text-gray-400">
                        Focus on what matters, help wildlife thrive.
                    </p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">App</h3>
                        <ul class="mt-4 space-y-2">
                            <li><a href="<?= $baseUrl ?>/dashboard" class="text-gray-400 hover:text-white">Dashboard</a></li>
                            <li><a href="<?= $baseUrl ?>/focus" class="text-gray-400 hover:text-white">Focus Timer</a></li>
                            <li><a href="<?= $baseUrl ?>/creatures" class="text-gray-400 hover:text-white">Creatures</a></li>
                            <li><a href="<?= $baseUrl ?>/habitats" class="text-gray-400 hover:text-white">Habitats</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Community</h3>
                        <ul class="mt-4 space-y-2">
                            <li><a href="<?= $baseUrl ?>/marketplace" class="text-gray-400 hover:text-white">Marketplace</a></li>
                            <li><a href="<?= $baseUrl ?>/conservation" class="text-gray-400 hover:text-white">Conservation</a></li>
                            <li><a href="<?= $baseUrl ?>/community" class="text-gray-400 hover:text-white">Forums</a></li>
                            <li><a href="<?= $baseUrl ?>/community/leaderboard" class="text-gray-400 hover:text-white">Leaderboard</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Help</h3>
                        <ul class="mt-4 space-y-2">
                            <li><a href="<?= $baseUrl ?>/support" class="text-gray-400 hover:text-white">Support</a></li>
                            <li><a href="<?= $baseUrl ?>/faq" class="text-gray-400 hover:text-white">FAQ</a></li>
                            <li><a href="<?= $baseUrl ?>/contact" class="text-gray-400 hover:text-white">Contact Us</a></li>
                            <li><a href="<?= $baseUrl ?>/privacy" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Follow Us</h3>
                        <div class="mt-4 flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t border-gray-700 text-center">
                <p class="text-gray-400">
                    &copy; <?= date('Y') ?> Wildlife Haven. All rights reserved.
                </p>
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