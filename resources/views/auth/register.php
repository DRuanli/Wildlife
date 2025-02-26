<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; 
// Path: resources/views/auth/register.php
?>

<div class="container mx-auto px-6 py-12">
    <!-- Simple, balanced layout with ample negative space -->
    <div class="max-w-md mx-auto bg-stone-50 rounded-lg overflow-hidden">
        <!-- Subtle natural texture and shadow -->
        <div class="px-8 py-10 bg-gradient-to-b from-stone-50 to-stone-100">
            <!-- Clean, minimalist typography -->
            <h2 class="text-2xl font-normal text-stone-800 mb-3 text-center">Join Wildlife Haven</h2>
            <p class="text-center text-stone-600 text-sm mb-6">Create an account to start your mindful focus journey</p>
            
            <?php if (isset($_SESSION['flash_message'])): ?>
                <!-- Subtle, non-intrusive alert with natural colors -->
                <div class="bg-<?= ($_SESSION['flash_type'] == 'danger') ? 'red-50' : (($_SESSION['flash_type'] == 'success') ? 'green-50' : 'amber-50') ?> 
                            border-l-2 border-<?= ($_SESSION['flash_type'] == 'danger') ? 'red-300' : (($_SESSION['flash_type'] == 'success') ? 'green-300' : 'amber-300') ?> 
                            text-<?= ($_SESSION['flash_type'] == 'danger') ? 'red-700' : (($_SESSION['flash_type'] == 'success') ? 'green-700' : 'amber-700') ?> 
                            p-4 mb-6 text-sm" role="alert">
                    <p><?= $_SESSION['flash_message']; ?></p>
                </div>
                <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
            <?php endif; ?>
            
            <!-- Clean form with generous spacing -->
            <form action="<?= $baseUrl ?>/auth/register/process" method="POST" class="space-y-5">
                <div>
                    <label for="username" class="block text-sm font-medium text-stone-600 mb-1">Username</label>
                    <input type="text" name="username" id="username" 
                           class="w-full px-3 py-2 bg-white border border-stone-200 rounded-md focus:outline-none focus:ring-1 focus:ring-stone-400"
                           required>
                    <p class="mt-1 text-xs text-stone-500">Choose a unique username (3-50 characters)</p>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-stone-600 mb-1">Email</label>
                    <input type="email" name="email" id="email" 
                           class="w-full px-3 py-2 bg-white border border-stone-200 rounded-md focus:outline-none focus:ring-1 focus:ring-stone-400"
                           required>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-stone-600 mb-1">Password</label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-3 py-2 bg-white border border-stone-200 rounded-md focus:outline-none focus:ring-1 focus:ring-stone-400"
                           required>
                    <p class="mt-1 text-xs text-stone-500">Must be at least 8 characters</p>
                </div>
                
                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-stone-600 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" 
                           class="w-full px-3 py-2 bg-white border border-stone-200 rounded-md focus:outline-none focus:ring-1 focus:ring-stone-400"
                           required>
                </div>
                
                <!-- Terms checkbox with subtle styling -->
                <div class="flex items-start mt-4">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="terms" id="terms" 
                               class="h-4 w-4 text-green-600 border-stone-300 rounded focus:ring-0"
                               required>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-stone-600">
                            I agree to the <a href="<?= $baseUrl ?>/terms" class="text-green-700 hover:text-green-800">Terms of Service</a> and <a href="<?= $baseUrl ?>/privacy" class="text-green-700 hover:text-green-800">Privacy Policy</a>
                        </label>
                    </div>
                </div>
                
                <!-- Natural-looking button with earthy tone -->
                <div class="mt-6">
                    <button type="submit" 
                            class="w-full py-2 px-4 bg-green-700 hover:bg-green-800 text-white font-normal rounded-md transition duration-200 ease-in-out">
                        Create Account
                    </button>
                </div>
            </form>
            
            <!-- Subtle divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-stone-200"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-2 bg-stone-50 text-stone-500 text-sm">Or sign up with</span>
                </div>
            </div>
            
            <!-- OAuth buttons with minimalist styling -->
            <div class="grid grid-cols-2 gap-4">
                <a href="<?= $baseUrl ?>/auth/google" 
                   class="flex justify-center items-center py-2 px-4 border border-stone-300 rounded-md hover:bg-stone-100 transition duration-150">
                    <svg class="w-5 h-5 text-stone-700" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032c0-3.331,2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                    </svg>
                    <span class="ml-2 text-stone-700 text-sm">Google</span>
                </a>
                
                <a href="<?= $baseUrl ?>/auth/apple" 
                   class="flex justify-center items-center py-2 px-4 border border-stone-300 rounded-md hover:bg-stone-100 transition duration-150">
                    <svg class="w-5 h-5 text-stone-700" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.543,11.971c-0.019-2.116,1.731-3.136,1.809-3.186c-0.988-1.444-2.524-1.643-3.063-1.662 c-1.294-0.134-2.542,0.765-3.201,0.765c-0.666,0-1.679-0.75-2.771-0.729c-1.401,0.021-2.714,0.825-3.437,2.082 c-1.485,2.574-0.377,6.368,1.047,8.45c0.711,1.017,1.541,2.156,2.629,2.116c1.063-0.043,1.461-0.682,2.741-0.682 c1.269,0,1.639,0.682,2.741,0.658c1.135-0.018,1.851-1.021,2.532-2.047c0.812-1.163,1.139-2.303,1.153-2.362 C19.705,15.291,17.564,14.506,17.543,11.971z M15.061,4.4c0.571-0.7,0.96-1.659,0.852-2.625c-0.826,0.034-1.854,0.556-2.447,1.245 c-0.53,0.616-1.002,1.611-0.879,2.552C13.557,5.647,14.48,5.094,15.061,4.4z"/>
                    </svg>
                    <span class="ml-2 text-stone-700 text-sm">Apple</span>
                </a>
            </div>
            
            <!-- Nature-inspired decorative element -->
            <div class="mt-8 flex justify-center">
                <svg class="text-green-700 opacity-30 w-24 h-8" viewBox="0 0 135 24" fill="currentColor">
                    <path d="M0,12 C8,8 16,4 24,0 C32,4 40,8 48,12 C40,16 32,20 24,24 C16,20 8,16 0,12 Z" />
                    <path d="M48,12 C56,8 64,4 72,0 C80,4 88,8 96,12 C88,16 80,20 72,24 C64,20 56,16 48,12 Z" />
                    <path d="M96,12 C104,8 112,4 120,0 C128,4 136,8 144,12 C136,16 128,20 120,24 C112,20 104,16 96,12 Z" />
                </svg>
            </div>
        </div>
        
        <!-- Footer section with muted background -->
        <div class="px-8 py-4 bg-stone-100 border-t border-stone-200">
            <p class="text-center text-sm text-stone-600">
                Already have an account? 
                <a href="<?= $baseUrl ?>/auth/login" class="font-medium text-green-700 hover:text-green-800">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>