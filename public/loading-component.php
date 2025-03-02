<?php
$loading_duration = isset($loading_duration) ? $loading_duration : 3000; // milliseconds
$loading_text = isset($loading_text) ? $loading_text : "ENTERING WILDLIFE HAVEN";
?>

<!-- Wildlife Haven Loading Screen -->
<div id="wh-loading-overlay" class="wh-loading-overlay">
  <div class="wh-white-circle"></div>
  
  <div class="wh-wavy-line-container">
    <svg class="wh-wavy-line" viewBox="0 0 300 60" preserveAspectRatio="none">
      <path id="wh-wavy-path" stroke="white" stroke-width="1.5" fill="none" 
            d="M0,30 C20,20 40,40 60,30 C80,20 100,40 120,30 C140,20 160,40 180,30 C200,20 220,40 240,30 C260,20 280,40 300,30"></path>
      
      <circle id="wh-moving-circle" r="3" fill="white" opacity="0.8">
        <animateMotion 
          dur="3s" 
          repeatCount="indefinite" 
          path="M0,30 C20,20 40,40 60,30 C80,20 100,40 120,30 C140,20 160,40 180,30 C200,20 220,40 240,30 C260,20 280,40 300,30">
        </animateMotion>
      </circle>
    </svg>
  </div>
  
  <div class="wh-loading-text"><?php echo htmlspecialchars($loading_text); ?></div>
  
  <div class="wh-sound-indicator">
    <div class="wh-sound-icon">
      <i class="wh-fa wh-fa-volume-up"></i>
    </div>
    <div class="wh-sound-text">Best experienced with sound</div>
  </div>
</div>

<style>
/* Encapsulated styles for the loading screen to avoid conflicts */
.wh-loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #4D724D;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 9999; /* High z-index to overlay everything */
  transition: opacity 0.8s ease-out, visibility 0.8s;
}

/* Noise texture using inlined SVG */
.wh-loading-overlay::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
  pointer-events: none;
  opacity: 0.4;
}

/* Small white circle in the upper right */
.wh-white-circle {
  position: absolute;
  top: 40px;
  right: 40px;
  width: 20px;
  height: 20px;
  background-color: white;
  border-radius: 50%;
  opacity: 0.7;
}

/* Wavy line container */
.wh-wavy-line-container {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 140px;
}

/* SVG container for wavy line */
.wh-wavy-line {
  width: 300px;
  height: 60px;
  position: relative;
}

/* Sound indicator in bottom right */
.wh-sound-indicator {
  position: absolute;
  bottom: 30px;
  right: 40px;
  display: flex;
  align-items: center;
  opacity: 0.7;
  color: white;
}

/* Font awesome icon replacement */
.wh-fa {
  display: inline-block;
  font-style: normal;
  font-variant: normal;
  text-rendering: auto;
  line-height: 1;
}

.wh-fa-volume-up::before {
  content: "♪";
  font-size: 18px;
  margin-right: 10px;
}

.wh-sound-text {
  font-size: 12px;
  letter-spacing: 0.5px;
  font-weight: 300;
  font-family: 'Inter', sans-serif, Arial, Helvetica;
}

/* Loading text below wavy line */
.wh-loading-text {
  margin-top: 20px;
  font-size: 14px;
  letter-spacing: 1px;
  opacity: 0.6;
  font-weight: 300;
  font-family: 'Inter', sans-serif, Arial, Helvetica;
  color: white;
}

/* Hidden content (optional) */
.wh-hidden-content {
  opacity: 0;
  transition: opacity 1s ease-in;
}
</style>

<script>
// Self-executing function to avoid global scope pollution
(function() {
  // Store references to DOM elements
  const loadingOverlay = document.getElementById('wh-loading-overlay');
  const hiddenElements = document.querySelectorAll('.wh-hidden-content');
  
  // Wait for all resources to load
  window.addEventListener('load', function() {
    setTimeout(function() {
      // Fade out loading overlay
      loadingOverlay.style.opacity = '0';
      loadingOverlay.style.visibility = 'hidden';
      
      // Show hidden content
      hiddenElements.forEach(function(element) {
        element.style.opacity = '1';
      });
      
      // Clean up after animation completes
      setTimeout(function() {
        loadingOverlay.remove(); // Remove from DOM entirely when finished
      }, 1000);
    }, <?php echo $loading_duration; ?>);
  });
})();
</script>