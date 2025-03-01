/**
 * Wildlife Haven - Focus Page 3D Model Implementation
 * This file is a complete implementation of 3D functionality for the focus page
 * 
 * Features:
 * - 3D model loading and display with Three.js
 * - Dynamic model transitions based on timer progress
 * - Habitat environments and creatures based on selection
 * - Navigation restrictions during focus sessions
 */

// ModelViewer class for handling 3D rendering
class ModelViewer {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            console.error(`Container with ID "${containerId}" not found.`);
            return;
        }

        // Set default options and merge with provided options
        this.options = Object.assign({
            width: this.container.clientWidth,
            height: this.container.clientHeight,
            backgroundColor: 0xf5f5f8,
            cameraPosition: { x: 0, y: 1, z: 5 },
            autoRotate: true,
            rotateSpeed: 0.5,
            loadingText: "Loading 3D model..."
        }, options);

        // Create references for models
        this.models = {
            stage1: null, // First 1/3 of time
            stage2: null, // 1/3 to 2/3 of time
            stage3: null, // 2/3 to end
            current: null  // Currently displayed model
        };

        this.currentStage = 'stage1';
        this.habitatModel = null;
        this.creatureModel = null;
        this.loadingManager = null;
        this.objLoader = null;
        this.mtlLoader = null;
        this.loadingElement = null;

        // Initialize the 3D scene
        this.init();
    }

    init() {
        // Create loading manager for tracking model loading progress
        this.loadingManager = new THREE.LoadingManager();
        this.loadingManager.onProgress = (url, itemsLoaded, itemsTotal) => {
            const progress = (itemsLoaded / itemsTotal * 100).toFixed(0);
            this.updateLoadingStatus(`Loading models: ${progress}%`);
        };
        this.loadingManager.onError = (url) => {
            console.error(`Error loading ${url}`);
            this.updateLoadingStatus(`Failed to load ${url.split('/').pop()}`);
        };
        this.loadingManager.onLoad = () => {
            this.hideLoadingStatus();
        };

        // Initialize loaders
        this.objLoader = new THREE.OBJLoader(this.loadingManager);
        this.mtlLoader = new THREE.MTLLoader(this.loadingManager);

        // Create loading indicator
        this.createLoadingElement();

        // Set up Three.js scene
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(this.options.backgroundColor);

        // Add lighting
        this.addLighting();

        // Set up camera
        this.camera = new THREE.PerspectiveCamera(
            75, 
            this.options.width / this.options.height, 
            0.1, 
            1000
        );
        this.camera.position.set(
            this.options.cameraPosition.x,
            this.options.cameraPosition.y,
            this.options.cameraPosition.z
        );
        this.camera.lookAt(0, 0, 0);

        // Set up renderer
        this.renderer = new THREE.WebGLRenderer({ 
            antialias: true,
            alpha: true
        });
        this.renderer.setSize(this.options.width, this.options.height);
        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;

        // Clear container and add renderer
        while (this.container.firstChild) {
            this.container.removeChild(this.container.firstChild);
        }
        this.container.appendChild(this.renderer.domElement);
        this.container.appendChild(this.loadingElement);

        // Set up orbit controls
        this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
        this.controls.enableDamping = true;
        this.controls.dampingFactor = 0.05;
        this.controls.autoRotate = this.options.autoRotate;
        this.controls.autoRotateSpeed = this.options.rotateSpeed;
        this.controls.maxPolarAngle = Math.PI / 1.5;
        this.controls.minDistance = 2;
        this.controls.maxDistance = 10;

        // Start animation loop
        this.animate();
        this.loadDefaultModel();
    }

    loadDefaultModel() {
        // Create a simple default model or load one from your assets
        const defaultModelPath = '/Wildlife/models/default/10054_Whale_v2_L3.obj';
        const defaultMtlPath = '/Wildlife/models/default/10054_Whale_v2_L3.mtl';
        
        // Use your existing loading mechanism
        this.mtlLoader.load(defaultMtlPath, (materials) => {
          materials.preload();
          this.objLoader.setMaterials(materials);
          this.objLoader.load(defaultModelPath, (object) => {
            this.configureModel(object);
            this.defaultModel = object;
            this.scene.add(object);
          });
        });
      }

    createLoadingElement() {
        this.loadingElement = document.createElement('div');
        this.loadingElement.className = 'loading-overlay';
        this.loadingElement.style.position = 'absolute';
        this.loadingElement.style.top = '0';
        this.loadingElement.style.left = '0';
        this.loadingElement.style.width = '100%';
        this.loadingElement.style.height = '100%';
        this.loadingElement.style.backgroundColor = 'rgba(245, 245, 248, 0.7)';
        this.loadingElement.style.display = 'flex';
        this.loadingElement.style.alignItems = 'center';
        this.loadingElement.style.justifyContent = 'center';
        this.loadingElement.style.zIndex = '10';
        this.loadingElement.innerHTML = `
            <div style="text-align: center;">
                <div class="spinner" style="width: 40px; height: 40px; margin: 0 auto 10px; border: 4px solid rgba(0, 0, 0, 0.1); border-left-color: #4D724D; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                <div class="loading-text">${this.options.loadingText}</div>
            </div>
        `;
    }

    updateLoadingStatus(message) {
        const textElement = this.loadingElement.querySelector('.loading-text');
        if (textElement) {
            textElement.textContent = message;
        }
        this.showLoadingStatus();
    }

    showLoadingStatus() {
        if (this.loadingElement) {
            this.loadingElement.style.display = 'flex';
        }
    }

    hideLoadingStatus() {
        if (this.loadingElement) {
            this.loadingElement.style.display = 'none';
        }
    }

    addLighting() {
        // Ambient light for overall scene illumination
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
        this.scene.add(ambientLight);

        // Hemisphere light for natural sky/ground lighting
        const hemisphereLight = new THREE.HemisphereLight(0xffffff, 0x444444, 0.6);
        hemisphereLight.position.set(0, 20, 0);
        this.scene.add(hemisphereLight);

        // Directional light for shadows and depth
        const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
        directionalLight.position.set(-5, 10, 7.5);
        directionalLight.castShadow = true;
        directionalLight.shadow.camera.top = 5;
        directionalLight.shadow.camera.right = 5;
        directionalLight.shadow.camera.bottom = -5;
        directionalLight.shadow.camera.left = -5;
        directionalLight.shadow.mapSize.width = 2048;
        directionalLight.shadow.mapSize.height = 2048;
        this.scene.add(directionalLight);

        // Add a subtle point light to brighten the front of models
        const pointLight = new THREE.PointLight(0xffffff, 0.5);
        pointLight.position.set(0, 2, 3);
        this.scene.add(pointLight);
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        this.controls.update();
        this.renderer.render(this.scene, this.camera);
    }

    /**
     * Load models for the different time stages
     * @param {Object} modelPaths - Paths to models for different stages
     */
    loadModels(modelPaths) {
        this.showLoadingStatus();
        this.updateLoadingStatus("Loading stage models...");

        // Helper function to load OBJ model with optional MTL
        const loadModel = (path, targetStage) => {
            const mtlPath = path.replace('.obj', '.mtl');
            
            // Check if MTL file exists
            fetch(mtlPath)
                .then(response => {
                    if (response.ok) {
                        // MTL exists, load material first
                        this.mtlLoader.load(mtlPath, (materials) => {
                            materials.preload();
                            this.objLoader.setMaterials(materials);
                            this.loadObjModel(path, targetStage);
                        });
                    } else {
                        // No MTL file, load OBJ directly
                        this.loadObjModel(path, targetStage);
                    }
                })
                .catch(() => {
                    // Error checking MTL, load OBJ directly
                    this.loadObjModel(path, targetStage);
                });
        };

        // Load stage models
        if (modelPaths.stage1) loadModel(modelPaths.stage1, 'stage1');
        if (modelPaths.stage2) loadModel(modelPaths.stage2, 'stage2');
        if (modelPaths.stage3) loadModel(modelPaths.stage3, 'stage3');
    }

    /**
     * Load an OBJ model
     * @param {string} path - Path to OBJ file
     * @param {string} targetStage - Stage to assign the model to
     */
    loadObjModel(path, targetStage) {
        this.objLoader.load(
            path,
            (object) => {
                // Configure the loaded model
                this.configureModel(object);
                
                // Store the model
                this.models[targetStage] = object;
                
                // If this is the current stage, display it
                if (this.currentStage === targetStage) {
                    this.setCurrentModel(targetStage);
                }
            },
            (xhr) => {
                const percent = Math.round((xhr.loaded / xhr.total) * 100);
                this.updateLoadingStatus(`Loading ${path.split('/').pop()}: ${percent}%`);
            },
            (error) => {
                console.error(`Error loading model: ${path}`, error);
                this.updateLoadingStatus(`Failed to load model: ${path.split('/').pop()}`);
                
                // Create a placeholder model if the actual model fails to load
                const geometry = new THREE.SphereGeometry(1, 32, 32);
                const material = new THREE.MeshStandardMaterial({ 
                    color: targetStage === 'stage1' ? 0x8bc34a : 
                           targetStage === 'stage2' ? 0x2196f3 : 0x9c27b0 
                });
                const mesh = new THREE.Mesh(geometry, material);
                const group = new THREE.Group();
                group.add(mesh);
                
                // Store the placeholder
                this.models[targetStage] = group;
                
                // If this is the current stage, display it
                if (this.currentStage === targetStage) {
                    this.setCurrentModel(targetStage);
                }
            }
        );
    }

    /**
     * Configure a loaded model (apply common settings)
     * @param {THREE.Object3D} object - The loaded 3D model
     */
    configureModel(object) {
        // Apply common settings to the model
        object.traverse((child) => {
            if (child.isMesh) {
                child.castShadow = true;
                child.receiveShadow = true;
                
                // If no material assigned, create a default one
                if (!child.material) {
                    child.material = new THREE.MeshPhongMaterial({ 
                        color: 0xcccccc, 
                        shininess: 30 
                    });
                }
            }
        });

        // Center and scale the model
        const box = new THREE.Box3().setFromObject(object);
        const center = box.getCenter(new THREE.Vector3());
        const size = box.getSize(new THREE.Vector3());
        
        // Center the model at origin
        object.position.x = -center.x;
        object.position.y = -center.y;
        object.position.z = -center.z;
        
        // Normalize the size
        const maxDim = Math.max(size.x, size.y, size.z);
        if (maxDim > 2) {
            const scale = 2 / maxDim;
            object.scale.set(scale, scale, scale);
        }
    }

    /**
     * Load a habitat background model
     * @param {string} habitatPath - Path to habitat OBJ file
     */
    loadHabitat(habitatPath) {
        this.showLoadingStatus();
        this.updateLoadingStatus("Loading habitat...");

        const mtlPath = habitatPath.replace('.obj', '.mtl');
        
        // Check if MTL file exists
        fetch(mtlPath)
            .then(response => {
                if (response.ok) {
                    // MTL exists, load material first
                    this.mtlLoader.load(mtlPath, (materials) => {
                        materials.preload();
                        this.objLoader.setMaterials(materials);
                        this.loadHabitatObj(habitatPath);
                    });
                } else {
                    // No MTL file, load OBJ directly
                    this.loadHabitatObj(habitatPath);
                }
            })
            .catch(() => {
                // Error checking MTL, load OBJ directly
                this.loadHabitatObj(habitatPath);
            });
    }

    /**
     * Load a habitat OBJ file
     * @param {string} path - Path to OBJ file
     */
    loadHabitatObj(path) {
        this.objLoader.load(
            path,
            (object) => {
                // Remove existing habitat if any
                if (this.habitatModel) {
                    this.scene.remove(this.habitatModel);
                }
                
                // Configure the habitat model
                object.traverse((child) => {
                    if (child.isMesh) {
                        child.receiveShadow = true;
                    }
                });
                
                // Scale and position the habitat
                const box = new THREE.Box3().setFromObject(object);
                const size = box.getSize(new THREE.Vector3());
                
                // Make habitat larger than creatures
                const scale = 5 / Math.max(size.x, size.y, size.z);
                object.scale.set(scale, scale, scale);
                
                // Position habitat to be centered and below creatures
                object.position.y = -1;
                
                this.habitatModel = object;
                this.scene.add(object);
                
                // Ensure it's sent to the back
                object.renderOrder = -1;
            },
            (xhr) => {
                const percent = Math.round((xhr.loaded / xhr.total) * 100);
                this.updateLoadingStatus(`Loading habitat: ${percent}%`);
            },
            (error) => {
                console.error('Error loading habitat model:', error);
                this.updateLoadingStatus('Failed to load habitat model');
                
                // Create a placeholder habitat if the actual model fails to load
                const habitatType = path.split('/').pop().replace('.obj', '');
                this.createPlaceholderHabitat(habitatType);
            }
        );
    }
    
    /**
     * Create a placeholder habitat when model loading fails
     * @param {string} habitatType - Type of habitat
     */
    createPlaceholderHabitat(habitatType) {
        // Remove existing habitat if any
        if (this.habitatModel) {
            this.scene.remove(this.habitatModel);
        }
        
        // Create a placeholder habitat based on type
        const planeGeometry = new THREE.PlaneGeometry(10, 10);
        let material;
        
        switch(habitatType) {
            case 'forest':
                material = new THREE.MeshStandardMaterial({ color: 0x2d6a4f });
                break;
            case 'ocean':
                material = new THREE.MeshStandardMaterial({ color: 0x1e40af });
                break;
            case 'mountain':
                material = new THREE.MeshStandardMaterial({ color: 0x7f1d1d });
                break;
            case 'sky':
                material = new THREE.MeshStandardMaterial({ color: 0x0369a1 });
                break;
            case 'cosmic':
                material = new THREE.MeshStandardMaterial({ color: 0x4c1d95 });
                break;
            case 'enchanted':
                material = new THREE.MeshStandardMaterial({ color: 0x9d174d });
                break;
            default:
                material = new THREE.MeshStandardMaterial({ color: 0x6b7280 });
        }
        
        const plane = new THREE.Mesh(planeGeometry, material);
        plane.rotation.x = -Math.PI / 2; // Make it horizontal
        plane.position.y = -1;
        plane.receiveShadow = true;
        
        this.habitatModel = plane;
        this.scene.add(plane);
    }

    /**
     * Load a creature model
     * @param {string} basePath - Base path to models directory
     * @param {string} creatureType - Type/species of creature
     * @param {string} stage - Development stage of creature
     */
    loadCreature(basePath, creatureType, stage) {
        this.showLoadingStatus();
        this.updateLoadingStatus("Loading creature...");

        // Construct the full path to the creature model
        const path = `${basePath}/${creatureType}_${stage}.obj`;
        const mtlPath = path.replace('.obj', '.mtl');

        // Check if MTL file exists
        fetch(mtlPath)
            .then(response => {
                if (response.ok) {
                    // MTL exists, load material first
                    this.mtlLoader.load(mtlPath, (materials) => {
                        materials.preload();
                        this.objLoader.setMaterials(materials);
                        this.loadCreatureObj(path, creatureType);
                    });
                } else {
                    // No MTL file, load OBJ directly
                    this.loadCreatureObj(path, creatureType);
                }
            })
            .catch(() => {
                // Error checking MTL, load OBJ directly
                this.loadCreatureObj(path, creatureType);
            });
    }

    /**
     * Load a creature OBJ file
     * @param {string} path - Path to OBJ file
     * @param {string} creatureType - Type/species of creature
     */
    loadCreatureObj(path, creatureType) {
        this.objLoader.load(
            path,
            (object) => {
                // Remove existing creature if any
                if (this.creatureModel) {
                    this.scene.remove(this.creatureModel);
                }
                
                // Configure the creature model
                this.configureModel(object);
                
                // Position based on creature type
                this.positionCreature(object, creatureType);
                
                this.creatureModel = object;
                this.scene.add(object);
            },
            (xhr) => {
                const percent = Math.round((xhr.loaded / xhr.total) * 100);
                this.updateLoadingStatus(`Loading creature: ${percent}%`);
            },
            (error) => {
                console.error('Error loading creature model:', error);
                this.updateLoadingStatus('Creating placeholder creature');
                
                // Create a placeholder creature if the actual model fails to load
                this.createPlaceholderCreature(creatureType);
            }
        );
    }
    
    /**
     * Create a placeholder creature when model loading fails
     * @param {string} creatureType - Type of creature (habitat)
     */
    createPlaceholderCreature(creatureType) {
        // Remove existing creature if any
        if (this.creatureModel) {
            this.scene.remove(this.creatureModel);
        }
        
        // Create a placeholder creature
        let color;
        switch(creatureType) {
            case 'forest': color = 0x2d6a4f; break;
            case 'ocean': color = 0x1e40af; break;
            case 'mountain': color = 0x7f1d1d; break;
            case 'sky': color = 0x0369a1; break;
            case 'cosmic': color = 0x4c1d95; break;
            case 'enchanted': color = 0x9d174d; break;
            default: color = 0x6b7280;
        }
        
        // Create a simple creature representation
        const group = new THREE.Group();
        
        // Body
        const bodyGeometry = new THREE.SphereGeometry(0.5, 32, 16);
        const bodyMaterial = new THREE.MeshStandardMaterial({ color });
        const body = new THREE.Mesh(bodyGeometry, bodyMaterial);
        body.castShadow = true;
        group.add(body);
        
        // Head
        const headGeometry = new THREE.SphereGeometry(0.3, 32, 16);
        const headMaterial = new THREE.MeshStandardMaterial({ color });
        const head = new THREE.Mesh(headGeometry, headMaterial);
        head.position.set(0, 0.5, 0.3);
        head.castShadow = true;
        group.add(head);
        
        // Position creature appropriately
        this.positionCreature(group, creatureType);
        
        this.creatureModel = group;
        this.scene.add(group);
    }

    /**
     * Position creature based on its type
     * @param {THREE.Object3D} model - The creature model
     * @param {string} creatureType - Type/species of creature
     */
    positionCreature(model, creatureType) {
        // Different positioning based on creature habitat type
        switch(creatureType) {
            case 'forest':
                model.position.set(0, 0, 0);
                break;
            case 'ocean':
                model.position.set(-0.5, -0.3, 0);
                break;
            case 'mountain':
                model.position.set(0.5, 0.2, 0);
                break;
            case 'sky':
                model.position.set(0, 0.5, 0);
                break;
            case 'cosmic':
                model.position.set(0, 0.3, 0.5);
                break;
            case 'enchanted':
                model.position.set(0.3, 0, 0.3);
                break;
            default:
                model.position.set(0, 0, 0);
        }
    }

    /**
     * Set the current model to display
     * @param {string} stage - Stage to display ('stage1', 'stage2', or 'stage3')
     */
    setCurrentModel(stage) {
        // Remove current model if exists
        if (this.models.current) {
            this.scene.remove(this.models.current);
        }
        
        // Set new current model
        this.currentStage = stage;
        this.models.current = this.models[stage];
        
        if (this.models.current) {
            this.scene.add(this.models.current);
        }
    }

    /**
     * Update the displayed model based on timer progress
     * @param {number} progress - Progress as a value between 0 and 1
     */
    updateModelByProgress(progress) {
        if (progress < 1/3) {
            if (this.currentStage !== 'stage1' && this.models.stage1) {
                this.setCurrentModel('stage1');
            }
        } else if (progress < 2/3) {
            if (this.currentStage !== 'stage2' && this.models.stage2) {
                this.setCurrentModel('stage2');
            }
        } else {
            if (this.currentStage !== 'stage3' && this.models.stage3) {
                this.setCurrentModel('stage3');
            }
        }
    }

    /**
     * Resize the renderer when container size changes
     */
    resize() {
        if (!this.renderer || !this.camera) return;
        
        const width = this.container.clientWidth;
        const height = this.container.clientHeight;
        
        this.camera.aspect = width / height;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(width, height);
    }

    /**
     * Clear all models from the scene
     */
    clear() {
        // Remove all models
        if (this.models.current) {
            this.scene.remove(this.models.current);
            this.models.current = null;
        }
        
        if (this.habitatModel) {
            this.scene.remove(this.habitatModel);
            this.habitatModel = null;
        }
        
        if (this.creatureModel) {
            this.scene.remove(this.creatureModel);
            this.creatureModel = null;
        }
        
        // Reset stage models
        this.models.stage1 = null;
        this.models.stage2 = null;
        this.models.stage3 = null;
        this.currentStage = 'stage1';
    }
}

// Add CSS for 3D container and animations
function addStyles() {
    const style = document.createElement('style');
    style.textContent = `
        /* 3D model container styles */
        .model-container {
            position: relative;
            width: 100%;
            height: 300px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .model-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100%;
            padding: 2rem;
        }
        
        .habitat-type-indicator {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 12px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 10;
        }
        
        .creature-info-panel {
            position: absolute;
            bottom: 10px;
            left: 10px;
            right: 10px;
            padding: 10px 15px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
            transition: all 0.3s ease;
        }
        
        /* Loading animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Focus mode overlay */
        .focus-mode-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s ease;
        }
        
        .focus-mode-active .focus-mode-overlay {
            opacity: 1;
            pointer-events: auto;
        }
        
        /* Warning modal */
        .warning-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        
        .warning-content {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            max-width: 90%;
            width: 400px;
            text-align: center;
        }
        
        .warning-title {
            color: #ef4444;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .warning-message {
            margin-bottom: 1.5rem;
        }
        
        .warning-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        
        .warning-buttons button {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: medium;
            cursor: pointer;
        }
        
        .warning-continue {
            background-color: #ef4444;
            color: white;
            border: none;
        }
        
        .warning-stay {
            background-color: #e5e7eb;
            color: #1f2937;
            border: 1px solid #d1d5db;
        }
    `;
    document.head.appendChild(style);
}

// Initialize after DOM content is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add CSS styles to the page
    addStyles();

    // Add Three.js and dependencies to the page
    function loadScript(src, callback) {
        const script = document.createElement('script');
        script.src = src;
        script.async = true;
        script.onload = callback;
        script.onerror = function() {
            console.error(`Failed to load script: ${src}`);
        };
        document.head.appendChild(script);
    }

    // Queue of scripts to load in sequence
    const scripts = [
        'https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js',
        'https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/controls/OrbitControls.js',
        'https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/loaders/MTLLoader.js',
        'https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/loaders/OBJLoader.js'
    ];

    // Load scripts sequentially
    let index = 0;
    function loadNextScript() {
        if (index < scripts.length) {
            loadScript(scripts[index], function() {
                index++;
                loadNextScript();
            });
        } else {
            // All scripts loaded, initialize the model viewer
            initializeModelViewer();
        }
    }

    // Start loading scripts
    loadNextScript();
    
    // Global variables for focus restrictions
    let isLeavingAllowed = true;
    let userAttemptedToLeave = false;
    let originalLocation = window.location.href;
    let isWarningModalShown = false;

    // Create warning modal element
    function createWarningModal() {
        const modal = document.createElement('div');
        modal.className = 'warning-modal';
        modal.style.display = 'none';
        modal.innerHTML = `
            <div class="warning-content">
                <h3 class="warning-title">Cảnh Báo</h3>
                <p class="warning-message">Leaving this page will end your focus session. All progress will be lost.</p>
                <div class="warning-buttons">
                    <button class="warning-stay">Stay Focused</button>
                    <button class="warning-continue">Leave Anyway</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        
        // Add event listeners to buttons
        modal.querySelector('.warning-stay').addEventListener('click', function() {
            modal.style.display = 'none';
            isWarningModalShown = false;
        });
        
        modal.querySelector('.warning-continue').addEventListener('click', function() {
            isLeavingAllowed = true;
            userAttemptedToLeave = true;
            modal.style.display = 'none';
            isWarningModalShown = false;
            
            // Mark session as failed and allow navigation
            if (window.timerRunning && !window.timerPaused) {
                window.cancelSession();
            }
        });
        
        return modal;
    }

    // Initialize 3D model viewer once Three.js is loaded
    function initializeModelViewer() {
        if (typeof THREE === 'undefined') {
            console.error('Three.js not loaded correctly');
            return;
        }

        // Create the model viewer instance
        window.modelViewer = new ModelViewer('model-display', {
            backgroundColor: 0xf5f5f8,
            cameraPosition: { x: 0, y: 1, z: 5 },
            autoRotate: true
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            window.modelViewer.resize();
        });

        // Setup focus restrictions
        setupFocusRestrictions();

        // Extend existing select creature handler
        const creatureSelect = document.getElementById('creature-select');
        if (creatureSelect) {
            // Store original onchange handler if it exists
            const originalChangeHandler = creatureSelect.onchange;
            
            creatureSelect.onchange = function(e) {
                // Call original handler if it exists
                if (typeof originalChangeHandler === 'function') {
                    originalChangeHandler.call(this, e);
                }
                
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const creatureStage = selectedOption.dataset.stage;
                    const creatureSpecies = selectedOption.dataset.species;
                    const creatureHabitat = selectedOption.dataset.habitat;
                    
                    // Update habitat type indicator
                    const habitatType = document.getElementById('habitat-type');
                    if (habitatType) {
                        let habitatIcon = '<i class="fas fa-tree mr-1"></i>';
                        switch(creatureHabitat) {
                            case 'ocean': habitatIcon = '<i class="fas fa-water mr-1"></i>'; break;
                            case 'mountain': habitatIcon = '<i class="fas fa-mountain mr-1"></i>'; break;
                            case 'sky': habitatIcon = '<i class="fas fa-cloud mr-1"></i>'; break;
                            case 'cosmic': habitatIcon = '<i class="fas fa-star mr-1"></i>'; break;
                            case 'enchanted': habitatIcon = '<i class="fas fa-magic mr-1"></i>'; break;
                        }
                        habitatType.innerHTML = `${habitatIcon} ${creatureHabitat.charAt(0).toUpperCase() + creatureHabitat.slice(1)} Habitat`;
                        habitatType.className = `habitat-type-indicator text-${creatureHabitat}`;
                    }
                    
                    // Load habitat background
                    try {
                        window.modelViewer.loadHabitat(`/Wildlife/models/habitats/${creatureHabitat}.obj`);
                    } catch (error) {
                        console.error(`Failed to load habitat: ${error.message}`);
                    }
                    
                    // Load creature model
                    try {
                        window.modelViewer.loadCreature('/Wildlife/models/creatures', creatureSpecies, creatureStage);
                    } catch (error) {
                        console.error(`Failed to load creature: ${error.message}`);
                    }
                    
                    // Show creature info panel and hide placeholder
                    document.getElementById('creature-info-panel').classList.remove('opacity-0');
                    document.getElementById('model-placeholder').style.display = 'none';
                    
                    // Update creature info
                    document.getElementById('creature-name').textContent = selectedOption.dataset.name;
                    document.getElementById('creature-stage').textContent = creatureStage.charAt(0).toUpperCase() + creatureStage.slice(1);
                    document.getElementById('creature-stage').className = `px-2 py-1 text-xs font-medium rounded-full badge-${creatureStage}`;
                    document.getElementById('creature-health').textContent = `Health: ${selectedOption.dataset.health}/100`;
                    document.getElementById('creature-happiness').textContent = `Happiness: ${selectedOption.dataset.happiness}/100`;
                    
                    // Calculate growth percentage
                    let growthPercentage = 0;
                    if (creatureStage === 'egg') {
                        growthPercentage = (selectedOption.dataset.growth / 100) * 100;
                    } else if (creatureStage === 'mythical') {
                        growthPercentage = 100;
                    } else {
                        growthPercentage = (selectedOption.dataset.growth / 200) * 100;
                    }
                    document.getElementById('growth-percentage').textContent = `${Math.round(growthPercentage)}%`;
                    document.getElementById('growth-bar').style.width = `${growthPercentage}%`;
                    
                    // Enable model controls
                    document.getElementById('rotate-left-btn').disabled = false;
                    document.getElementById('rotate-right-btn').disabled = false;
                    document.getElementById('zoom-in-btn').disabled = false;
                    document.getElementById('zoom-out-btn').disabled = false;
                    document.getElementById('reset-view-btn').disabled = false;
                } else {
                    // Show placeholder when no creature selected
                    document.getElementById('model-placeholder').style.display = 'flex';
                    document.getElementById('creature-info-panel').classList.add('opacity-0');
                    document.getElementById('habitat-type').innerHTML = '<i class="fas fa-tree mr-1"></i> Select a creature';
                    document.getElementById('habitat-type').className = 'habitat-type-indicator';
                    
                    // Clear models
                    window.modelViewer.clear();
                    
                    // Disable model controls
                    document.getElementById('rotate-left-btn').disabled = true;
                    document.getElementById('rotate-right-btn').disabled = true;
                    document.getElementById('zoom-in-btn').disabled = true;
                    document.getElementById('zoom-out-btn').disabled = true;
                    document.getElementById('reset-view-btn').disabled = true;
                }
            };
        }

        // Setup model control buttons
        setupModelControls();

        // Extend timer functionality
        setupTimerModifications();

        // Create warning modal
        const warningModal = createWarningModal();
    }

    // Setup model control buttons
    function setupModelControls() {
        // Rotate left button
        document.getElementById('rotate-left-btn')?.addEventListener('click', function() {
            if (window.modelViewer && window.modelViewer.controls) {
                window.modelViewer.controls.rotateLeft(Math.PI / 6);
            }
        });
        
        // Rotate right button
        document.getElementById('rotate-right-btn')?.addEventListener('click', function() {
            if (window.modelViewer && window.modelViewer.controls) {
                window.modelViewer.controls.rotateLeft(-Math.PI / 6);
            }
        });
        
        // Zoom in button
        document.getElementById('zoom-in-btn')?.addEventListener('click', function() {
            if (window.modelViewer && window.modelViewer.controls) {
                window.modelViewer.controls.dollyIn(1.2);
                window.modelViewer.controls.update();
            }
        });
        
        // Zoom out button
        document.getElementById('zoom-out-btn')?.addEventListener('click', function() {
            if (window.modelViewer && window.modelViewer.controls) {
                window.modelViewer.controls.dollyOut(1.2);
                window.modelViewer.controls.update();
            }
        });
        
        // Reset view button
        document.getElementById('reset-view-btn')?.addEventListener('click', function() {
            if (window.modelViewer && window.modelViewer.controls) {
                window.modelViewer.controls.reset();
            }
        });
    }

    // Setup focus restrictions for the page
    function setupFocusRestrictions() {
        // Save original beforeunload function
        const originalBeforeUnload = window.onbeforeunload;
        
        // Add exit warning
        window.onbeforeunload = function(e) {
            // Only trigger if timer is running and navigation is not explicitly allowed
            if (window.timerRunning && !window.timerPaused && !isLeavingAllowed) {
                // Check if user already attempted to leave
                if (userAttemptedToLeave) {
                    // Mark session as failed and allow navigation
                    if (typeof window.cancelSession === 'function') {
                        window.cancelSession();
                    }
                    
                    // Allow navigation this time
                    return undefined;
                }
                
                // Show custom warning modal if possible
                if (!isWarningModalShown) {
                    // Can't show custom modal in beforeunload event in modern browsers
                    // Instead, we'll use the browser's default dialog
                    const confirmationMessage = "Cảnh Báo: Closing this page will end your focus session. Do you want to continue?";
                    
                    // For modern browsers
                    e.preventDefault();
                    e.returnValue = confirmationMessage;
                    return confirmationMessage;
                }
            }
            
            // Call original function if exists
            if (typeof originalBeforeUnload === 'function') {
                return originalBeforeUnload(e);
            }
        };

        // Monitor page visibility change
        document.addEventListener('visibilitychange', function() {
            if (window.timerRunning && !window.timerPaused) {
                if (document.visibilityState === 'hidden') {
                    // Page is hidden - might be switching to another tab
                    console.log('Focus session interrupted - switched away from tab');
                    
                    // We could implement focus penalties here
                    // For example, reducing focus score by a small amount
                }
            }
        });
        
        // Restrict navigation to other pages on the site
        document.addEventListener('click', function(e) {
            if (window.timerRunning && !window.timerPaused) {
                const link = e.target.closest('a');
                if (link) {
                    const href = link.getAttribute('href');
                    
                    // Skip if no href or it's a hash/anchor link
                    if (!href || href.startsWith('#')) {
                        return;
                    }
                    
                    // Allow external links (starts with http and not on this domain)
                    if (href.startsWith('http') && !href.includes(window.location.hostname)) {
                        // External link - allow navigation
                        return;
                    }
                    
                    // Internal link - prevent navigation
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Show warning
                    const warningModal = document.querySelector('.warning-modal');
                    if (warningModal) {
                        warningModal.style.display = 'flex';
                        isWarningModalShown = true;
                    } else {
                        alert("You cannot navigate to other pages during a focus session. Please complete or cancel your session first.");
                    }
                }
            }
        }, true);
        
        // Block form submissions
        document.addEventListener('submit', function(e) {
            if (window.timerRunning && !window.timerPaused) {
                e.preventDefault();
                e.stopPropagation();
                
                // Show warning
                const warningModal = document.querySelector('.warning-modal');
                if (warningModal) {
                    warningModal.style.display = 'flex';
                    isWarningModalShown = true;
                } else {
                    alert("You cannot submit forms during a focus session. Please complete or cancel your session first.");
                }
            }
        }, true);
        
        // Monitor history changes
        window.addEventListener('popstate', function(e) {
            if (window.timerRunning && !window.timerPaused) {
                // Prevent navigation by pushing the original state back
                window.history.pushState(null, document.title, originalLocation);
                
                // Show warning
                const warningModal = document.querySelector('.warning-modal');
                if (warningModal) {
                    warningModal.style.display = 'flex';
                    isWarningModalShown = true;
                } else {
                    alert("You cannot navigate away during a focus session. Please complete or cancel your session first.");
                }
            }
        });
        
        // Store original pushState and replaceState functions
        const originalPushState = window.history.pushState;
        const originalReplaceState = window.history.replaceState;
        
        // Override pushState
        window.history.pushState = function() {
            if (window.timerRunning && !window.timerPaused && !isLeavingAllowed) {
                // Show warning
                const warningModal = document.querySelector('.warning-modal');
                if (warningModal) {
                    warningModal.style.display = 'flex';
                    isWarningModalShown = true;
                } else {
                    alert("Navigation is restricted during a focus session.");
                }
                return;
            }
            return originalPushState.apply(this, arguments);
        };
        
        // Override replaceState
        window.history.replaceState = function() {
            if (window.timerRunning && !window.timerPaused && !isLeavingAllowed) {
                // Show warning
                const warningModal = document.querySelector('.warning-modal');
                if (warningModal) {
                    warningModal.style.display = 'flex';
                    isWarningModalShown = true;
                } else {
                    alert("Navigation is restricted during a focus session.");
                }
                return;
            }
            return originalReplaceState.apply(this, arguments);
        };
    }

    // Extend existing timer functionality with model updates
    function setupTimerModifications() {
        // Check if timer is already initialized
        if (typeof window.timerRunning !== 'undefined') {
            extendTimerFunctions();
        } else {
            // Wait until main timer variables are defined
            const checkTimerVars = setInterval(function() {
                if (typeof window.timerRunning !== 'undefined') {
                    clearInterval(checkTimerVars);
                    extendTimerFunctions();
                }
            }, 100);
        }
        
        function extendTimerFunctions() {
            // Store original functions
            const originalStartTimer = window.startTimer;
            const originalPauseTimer = window.pauseTimer;
            const originalResumeTimer = window.resumeTimer;
            const originalCompleteSession = window.completeSession;
            const originalCancelSession = window.cancelSession;
            const originalResetTimer = window.resetTimer;
            
            // Override start timer function
            window.startTimer = function() {
                isLeavingAllowed = false;
                userAttemptedToLeave = false;
                originalLocation = window.location.href;
                
                // Call original function
                if (typeof originalStartTimer === 'function') {
                    originalStartTimer.call(this);
                } else {
                    console.error('Original startTimer function not found');
                }
                
                // Load evolution models if creature is selected
                if (window.selectedCreatureId && window.selectedCreatureData) {
                    const creatureStage = window.selectedCreatureData.stage;
                    const creatureSpecies = window.selectedCreatureData.species;
                    const habitatType = window.selectedCreatureData.habitat;
                    
                    // Load habitat
                    try {
                        window.modelViewer.loadHabitat(`/Wildlife/models/habitats/${habitatType}.obj`);
                    } catch (error) {
                        console.error(`Failed to load habitat: ${error.message}`);
                    }
                    
                    // Define evolution model paths based on stages
                    const modelPaths = {
                        stage1: `/Wildlife/models/evolution/${creatureSpecies}_${creatureStage}_1.obj`, // First 1/3
                        stage2: `/Wildlife/models/evolution/${creatureSpecies}_${creatureStage}_2.obj`, // 1/3 to 2/3
                        stage3: `/Wildlife/models/evolution/${creatureSpecies}_${creatureStage}_3.obj`  // Last 1/3
                    };
                    
                    // Load all three evolution stage models
                    try {
                        window.modelViewer.loadModels(modelPaths);
                    } catch (error) {
                        console.error(`Failed to load evolution models: ${error.message}`);
                    }
                    
                    // Hide placeholder
                    const placeholder = document.getElementById('model-placeholder');
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                }
            };
            
            // Override pause timer function
            window.pauseTimer = function() {
                if (typeof originalPauseTimer === 'function') {
                    originalPauseTimer.call(this);
                } else {
                    console.error('Original pauseTimer function not found');
                }
                
                // No model updates needed for pause
            };
            
            // Override resume timer function
            window.resumeTimer = function() {
                if (typeof originalResumeTimer === 'function') {
                    originalResumeTimer.call(this);
                } else {
                    console.error('Original resumeTimer function not found');
                }
                
                // No model updates needed for resume
            };
            
            // Override complete session function
            window.completeSession = function() {
                isLeavingAllowed = true;
                
                if (typeof originalCompleteSession === 'function') {
                    originalCompleteSession.call(this);
                } else {
                    console.error('Original completeSession function not found');
                }
                
                // No model updates needed for completion
            };
            
            // Override cancel session function
            window.cancelSession = function() {
                isLeavingAllowed = true;
                
                if (typeof originalCancelSession === 'function') {
                    originalCancelSession.call(this);
                } else {
                    console.error('Original cancelSession function not found');
                    
                    // Fallback cancel implementation
                    if (window.timerInterval) {
                        clearInterval(window.timerInterval);
                    }
                    
                    window.timerRunning = false;
                    window.timerPaused = false;
                    
                    // Update UI elements
                    if (document.getElementById('timer-status')) {
                        document.getElementById('timer-status').textContent = 'Session canceled';
                    }
                    
                    // Show start button, hide other controls
                    if (document.getElementById('start-btn')) {
                        document.getElementById('start-btn').classList.remove('hidden');
                    }
                    if (document.getElementById('pause-btn')) {
                        document.getElementById('pause-btn').classList.add('hidden');
                    }
                    if (document.getElementById('resume-btn')) {
                        document.getElementById('resume-btn').classList.add('hidden');
                    }
                    if (document.getElementById('complete-btn')) {
                        document.getElementById('complete-btn').classList.add('hidden');
                    }
                    if (document.getElementById('cancel-btn')) {
                        document.getElementById('cancel-btn').classList.add('hidden');
                    }
                    
                    // Show settings
                    if (document.getElementById('timer-settings')) {
                        document.getElementById('timer-settings').classList.remove('hidden');
                    }
                }
                
                // Reset models
                if (window.modelViewer) {
                    window.modelViewer.clear();
                }
            };
            
            // Override reset timer function
            window.resetTimer = function() {
                isLeavingAllowed = true;
                
                if (typeof originalResetTimer === 'function') {
                    originalResetTimer.call(this);
                } else {
                    console.error('Original resetTimer function not found');
                }
                
                // Clear models when timer is reset
                if (window.modelViewer) {
                    window.modelViewer.clear();
                }
                
                // Show placeholder
                const placeholder = document.getElementById('model-placeholder');
                if (placeholder) {
                    placeholder.style.display = 'flex';
                }
            };
            
            // Extend timer interval to update models based on progress
            // We'll use a separate interval to avoid modifying the existing one
            const modelUpdateInterval = setInterval(function() {
                if (window.timerRunning && !window.timerPaused && 
                    typeof window.timeRemaining !== 'undefined' && 
                    typeof window.sessionDuration !== 'undefined' &&
                    window.modelViewer) {
                    
                    const progress = (window.sessionDuration - window.timeRemaining) / window.sessionDuration;
                    window.modelViewer.updateModelByProgress(progress);
                }
            }, 1000);
        }
    }
});