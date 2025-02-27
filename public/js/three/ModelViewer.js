class ModelViewer {
    constructor(containerId, options = {}) {
      this.container = document.getElementById(containerId);
      if (!this.container) {
        console.error(`Container with ID "${containerId}" not found.`);
        return;
      }
      
      // Default options
      this.options = Object.assign({
        width: this.container.clientWidth,
        height: 400,
        backgroundColor: 0xf0f0f0,
        controlsEnabled: true,
        autoRotate: true,
        cameraPosZ: 20
      }, options);
      
      this.scene = null;
      this.camera = null;
      this.renderer = null;
      this.controls = null;
      this.model = null;
      
      this.init();
    }
    
    init() {
      // Create scene
      this.scene = new THREE.Scene();
      this.scene.background = new THREE.Color(this.options.backgroundColor);
      
      // Create camera
      this.camera = new THREE.PerspectiveCamera(
        75, 
        this.options.width / this.options.height, 
        0.1, 
        1000
      );
      this.camera.position.z = this.options.cameraPosZ;
      
      // Create renderer
      this.renderer = new THREE.WebGLRenderer({ antialias: true });
      this.renderer.setSize(this.options.width, this.options.height);
      this.renderer.setPixelRatio(window.devicePixelRatio);
      this.container.appendChild(this.renderer.domElement);
      
      // Add lights
      const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
      this.scene.add(ambientLight);
      
      const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
      directionalLight.position.set(1, 1, 1);
      this.scene.add(directionalLight);
      
      // Add orbit controls if enabled
      if (this.options.controlsEnabled && typeof THREE.OrbitControls !== 'undefined') {
        this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
        this.controls.enableDamping = true;
        this.controls.dampingFactor = 0.05;
        this.controls.autoRotate = this.options.autoRotate;
        this.controls.autoRotateSpeed = 2.0;
      }
      
      // Start animation loop
      this.animate();
      
      // Handle window resize
      window.addEventListener('resize', this.onWindowResize.bind(this));
    }
    
    loadModel(modelClass, stage = 'adult') {
      // Clear any existing model
      if (this.model) {
        this.scene.remove(this.model.getModel());
        this.model.dispose();
      }
      
      // Create new model instance
      this.model = new modelClass(stage);
      this.scene.add(this.model.getModel());
      
      // Return model for further manipulation
      return this.model;
    }
    
    setStage(stage) {
      if (this.model && typeof this.model.setStage === 'function') {
        this.model.setStage(stage);
      }
    }
    
    animate() {
      requestAnimationFrame(this.animate.bind(this));
      
      if (this.controls) {
        this.controls.update();
      }
      
      this.renderer.render(this.scene, this.camera);
    }
    
    onWindowResize() {
      if (this.container) {
        const width = this.container.clientWidth;
        
        this.camera.aspect = width / this.options.height;
        this.camera.updateProjectionMatrix();
        
        this.renderer.setSize(width, this.options.height);
      }
    }
    
    dispose() {
      // Clean up resources to prevent memory leaks
      if (this.model) {
        this.model.dispose();
      }
      
      window.removeEventListener('resize', this.onWindowResize.bind(this));
      
      if (this.controls) {
        this.controls.dispose();
      }
      
      this.container.removeChild(this.renderer.domElement);
      this.renderer.dispose();
      
      this.scene = null;
      this.camera = null;
      this.renderer = null;
      this.controls = null;
      this.model = null;
    }
  }