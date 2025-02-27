// public/js/main.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Wildlife Haven script loaded successfully');
    
    // Initialize Alpine components if not auto-initialized
    if (typeof Alpine !== 'undefined' && Alpine.start) {
      Alpine.start();
    }
  });