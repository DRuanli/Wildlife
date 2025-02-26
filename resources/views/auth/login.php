<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; 
    // resources/views/auth/login.php
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Sign In to Wildlife Haven</h2>
            
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="bg-<?= $_SESSION['flash_type'] ?? 'blue' ?>-100 border-l-4 border-<?= $_SESSION['flash_type'] ?? 'blue' ?>-500 text-<?= $_SESSION['flash_type'] ?? 'blue' ?>-700 p-4 mb-6" role="alert">
                    <p><?= $_SESSION['flash_message']; ?></p>
                </div>
                <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
            <?php endif; ?>
            
            <form action="<?= $baseUrl ?>/auth/login/process" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    
                    <div class="text-sm">
                        <a href="<?= $baseUrl ?>/auth/forgot-password" class="font-medium text-green-600 hover:text-green-500">Forgot your password?</a>
                    </div>
                </div>
                
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Sign In
                    </button>
                </div>
            </form>
            
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>
                
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <div>
                        <a href="<?= $baseUrl ?>/auth/google" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032 c0-3.331,2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2 C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                            </svg>
                        </a>
                    </div>
                    
                    <div>
                        <a href="<?= $baseUrl ?>/auth/apple" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M16.032 15.935c-.148.352-.32.703-.512 1.047a8.932 8.932 0 01-.648.962 5.255 5.255 0 01-.902.952c-.36.312-.672.513-.945.611-.382.131-.764.195-1.146.195-.414 0-.82-.07-1.214-.212a3.76 3.76 0 01-1.01-.539c-.14-.105-.342-.262-.61-.471-.269-.207-.465-.336-.59-.383a6.004 6.004 0 01-.61.383c-.27.21-.471.367-.61.471-.355.254-.691.433-1.01.539-.395.141-.8.212-1.214.212-.382 0-.764-.064-1.146-.195-.273-.098-.586-.3-.945-.61a5.255 5.255 0 01-.902-.954 8.932 8.932 0 01-.648-.962c-.192-.344-.364-.695-.512-1.048-.49-1.125-.735-2.403-.735-3.812 0-1.093.227-2.016.68-2.77.453-.752 1.023-1.35 1.71-1.792.688-.444 1.438-.667 2.25-.667.305 0 .63.055.976.164.345.11.699.281 1.06.512.363.23.65.425.86.582.21.156.445.349.704.578.258-.23.492-.422.703-.578.21-.157.497-.351.86-.582.36-.23.715-.402 1.06-.512.345-.11.671-.164.976-.164.813 0 1.563.223 2.25.667.688.441 1.258 1.04 1.71 1.793.454.753.68 1.676.68 2.769 0 1.41-.245 2.687-.734 3.812z"/>
                                <path d="M16.57 7.45c-.383-.52-.907-.925-1.587-1.215-.5-.215-1.07-.357-1.704-.433.101-.812.413-1.422.938-1.828.523-.406 1.207-.61 2.05-.61.047 0 .118.004.212.012a.675.675 0 01.207 0c.094-.008.165-.012.211-.012V2c-.508.016-.883.023-1.125.023-.852 0-1.602.157-2.25.473-.648.316-1.149.785-1.504 1.41-.355.624-.539 1.39-.551 2.296v.187c.773.035 1.297.117 1.575.246.468.21.836.507 1.102.89.266.381.399.842.399 1.381 0 .532-.133.995-.399 1.387-.266.391-.628.685-1.086.883-.457.199-1.04.297-1.746.297-.719 0-1.315-.113-1.79-.34-.477-.226-.868-.604-1.174-1.135-.307-.53-.461-1.213-.461-2.047 0-.984.266-1.804.797-2.46.531-.658 1.19-1.172 1.977-1.542.453-.21.996-.374 1.625-.492-.031-.218-.094-.43-.19-.633a1.979 1.979 0 00-.445-.633c-.218-.21-.484-.316-.797-.316-.5 0-.899.125-1.197.375-.297.25-.46.59-.488 1.02-.531-.032-1.148-.166-1.852-.404a.651.651 0 01-.176-.071 8.49 8.49 0 01-.176-.082c.063-.75.293-1.418.688-2.004.395-.586.91-1.04 1.547-1.363C10.332 2.84 11.035 2.66 11.8 2.66c.695 0 1.35.093 1.961.281.613.188 1.156.51 1.63.965.477.457.845 1.077 1.102 1.863.258.786.387 1.75.387 2.89 0 1.296-.168 2.358-.504 3.189-.336.83-.824 1.41-1.465 1.737-.64.329-1.425.493-2.355.493-.93 0-1.716-.164-2.356-.493-.64-.328-1.129-.907-1.465-1.737-.305-.735-.46-1.695-.461-2.882 0-.023.004-.058.012-.105-.437.18-.756.42-.957.718-.199.297-.3.662-.3 1.093 0 .375.078.703.234.985.156.28.352.51.586.686.235.175.485.328.75.457.305.14.7.251 1.184.33.484.078.84.12 1.067.125v1.125c-.844-.031-1.48-.113-1.907-.246a4.475 4.475 0 01-1.204-.563 3.663 3.663 0 01-.89-.843 3.55 3.55 0 01-.587-1.112 4.322 4.322 0 01-.211-1.394c0-.798.176-1.488.527-2.07.352-.584.868-1.022 1.547-1.313.68-.29 1.5-.491 2.461-.602v-.117c.024-1.203.466-2.145 1.325-2.824.86-.68 1.939-1.02 3.235-1.02.07 0 .207.008.41.024v1.36c-.047 0-.095-.004-.144-.012a.675.675 0 01-.14 0c-.048.008-.095.012-.14.012-.618 0-1.13.187-1.536.562-.406.375-.636.883-.691 1.524.468.03.875.09 1.22.175.344.086.653.203.926.352.273.148.536.332.785.55.321.21.594.483.82.818.227.336.39.682.489 1.04.98.356.148.723.148 1.1 0 .625-.134 1.184-.399 1.676z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <p class="text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="<?= $baseUrl ?>/auth/register" class="font-medium text-green-600 hover:text-green-500">
                    Sign up
                </a>
            </p>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>