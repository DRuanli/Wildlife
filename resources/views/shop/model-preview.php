<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <nav class="text-sm breadcrumbs mb-6">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="<?= $baseUrl ?>/dashboard" class="text-gray-500 hover:text-gray-700">Dashboard</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="<?= $baseUrl ?>/shop" class="text-gray-500 hover:text-gray-700">Shop</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <span class="text-gray-700"><?= htmlspecialchars($item['name'] ?? 'Arctic Shimmer Hare') ?></span>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- 3D Model Viewer - Left side -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white flex justify-between items-center">
                    <h2 class="text-xl font-bold">Arctic Shimmer Hare - 3D Preview</h2>
                </div>
                <div class="p-6">
                    <div id="model-viewer" class="model-viewer-container">
                        <div class="model-viewer-loading">
                            <span></span>
                        </div>
                        
                        <div class="model-controls">
                            <button id="stage-egg" data-stage="egg">Egg</button>
                            <button id="stage-baby" data-stage="baby">Baby</button>
                            <button id="stage-juvenile" data-stage="juvenile">Juvenile</button>
                            <button id="stage-adult" data-stage="adult" class="active">Adult</button>
                            <button id="stage-mythical" data-stage="mythical">Mythical</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Item Details - Right side -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-4">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                    <h2 class="text-xl font-bold">Item Details</h2>
                </div>
                
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Arctic Shimmer Hare</h1>
                    <div class="flex items-center mb-4">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full mr-2">
                            Rare
                        </span>
                        <span class="text-gray-600 text-sm">
                            Special Egg
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-6">
                        A magical creature inspired by the Arctic Hare, developing crystalline ear tufts and frost-patterned fur as it evolves. In its mythical form, it leaves frost trails and can briefly camouflage into sparkling light.
                    </p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="font-medium text-gray-800 mb-2">Conservation Fact</h3>
                        <p class="text-gray-600 text-sm">
                            Arctic Hares are facing challenges due to climate change. As warming temperatures reduce snowy habitat and create mismatches between seasonal coat changes and their environment, they become more vulnerable to predation.
                        </p>
                    </div>
                    
                    <h3 class="font-medium text-gray-800 mb-2">Special Abilities</h3>
                    <ul class="text-gray-600 text-sm mb-6 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-snowflake text-blue-500 mt-1 mr-2"></i>
                            <div>
                                <span class="font-medium">Frost Step:</span>
                                <span> Creates beautiful frost patterns with each step</span>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-moon text-indigo-500 mt-1 mr-2"></i>
                            <div>
                                <span class="font-medium">Moonlight Camouflage:</span>
                                <span> 10% bonus to focus efficiency during night hours</span>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-mountain text-gray-600 mt-1 mr-2"></i>
                            <div>
                                <span class="font-medium">Winter's Resilience:</span>
                                <span> 15% happiness bonus in mountain habitats</span>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <span class="text-3xl font-bold text-gray-800 mr-2">650</span>
                            <i class="fas fa-coins text-yellow-500 text-xl"></i>
                        </div>
                        
                        <button class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="font-medium text-gray-800 mb-4">More Mountain Habitat Creatures</h3>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-50 rounded-lg p-3 text-center hover:bg-gray-100 transition-colors">
                            <img src="<?= $baseUrl ?>/images/creatures/2_adult.png" alt="Mountain Goat" class="h-16 mx-auto mb-2">
                            <span class="text-sm text-gray-600">Alpine Spirithorn</span>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3 text-center hover:bg-gray-100 transition-colors">
                            <img src="<?= $baseUrl ?>/images/creatures/5_adult.png" alt="Snow Leopard" class="h-16 mx-auto mb-2">
                            <span class="text-sm text-gray-600">Frost Prowler</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load required libraries -->
<link rel="stylesheet" href="<?= $baseUrl ?>/css/model-viewer.css">

<script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/controls/OrbitControls.js"></script>

<!-- Load model viewer and Arctic Hare model -->
<script src="<?= $baseUrl ?>/js/three/ModelViewer.js"></script>
<script src="<?= $baseUrl ?>/js/models/creatures/ArcticShimmerHare.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the model viewer with better error handling
    function initModelViewer() {
        // First check if all required libraries are loaded
        if (typeof THREE === 'undefined') {
            console.error('Three.js library not loaded');
            displayErrorMessage('Failed to load 3D libraries. Please try refreshing the page.');
            return;
        }
        
        if (typeof THREE.OrbitControls === 'undefined') {
            console.error('OrbitControls not loaded');
            displayErrorMessage('Failed to load 3D controls. Please try refreshing the page.');
            return;
        }
        
        if (typeof ModelViewer === 'undefined') {
            console.error('ModelViewer class not loaded');
            displayErrorMessage('Failed to load model viewer. Please try refreshing the page.');
            return;
        }
        
        if (typeof ArcticShimmerHare === 'undefined') {
            console.error('ArcticShimmerHare model not loaded');
            displayErrorMessage('Failed to load the 3D model. Please try refreshing the page.');
            return;
        }
        
        try {
            // Hide loading spinner
            document.querySelector('.model-viewer-loading').style.display = 'none';
            
            // Create model viewer
            const viewer = new ModelViewer('model-viewer', {
                height: 500,
                backgroundColor: 0xf5f5f8,
                autoRotate: true,
                cameraPosZ: 25 // Adjust camera position if needed
            });
            
            // Load Arctic Hare model (adult stage by default)
            const hare = viewer.loadModel(ArcticShimmerHare, 'adult');
            
            // Add event listeners for stage buttons
            const stageButtons = document.querySelectorAll('[data-stage]');
            stageButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const stage = this.getAttribute('data-stage');
                    
                    // Update model stage
                    viewer.setStage(stage);
                    
                    // Update button states
                    stageButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            console.log('3D model initialized successfully');
        } catch (error) {
            console.error('Error initializing 3D model:', error);
            displayErrorMessage('An error occurred while initializing the 3D model. Please try refreshing the page.');
        }
    }
    
    // Helper function to display error messages in the model viewer container
    function displayErrorMessage(message) {
        const container = document.getElementById('model-viewer');
        if (container) {
            // Hide loading spinner
            const spinner = container.querySelector('.model-viewer-loading');
            if (spinner) spinner.style.display = 'none';
            
            // Display error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'p-4 bg-red-50 text-red-800 rounded flex items-center justify-center h-full';
            errorDiv.innerHTML = `
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                    <p>${message}</p>
                    <button class="mt-3 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="location.reload()">
                        Refresh Page
                    </button>
                </div>
            `;
            container.appendChild(errorDiv);
        }
    }
    
    // Wait a moment to ensure all resources are loaded
    setTimeout(initModelViewer, 300);
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>