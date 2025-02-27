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
                    <img src="<?= asset('images/logo.png') ?>" alt="Wildlife Haven Logo" class="h-10 w-auto mr-2">
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
                        <li><a href="<?= url('dashboard') ?>" class="text-gray-400 hover:text-white">Dashboard</a></li>
                        <li><a href="<?= url('focus') ?>" class="text-gray-400 hover:text-white">Focus Timer</a></li>
                        <li><a href="<?= url('creatures') ?>" class="text-gray-400 hover:text-white">Creatures</a></li>
                        <li><a href="<?= url('habitats') ?>" class="text-gray-400 hover:text-white">Habitats</a></li>
                    </ul>
                </div>
                
                <!-- Rest of the footer code with updates... -->
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