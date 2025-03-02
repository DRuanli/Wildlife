<?php
// Path: resources/views/contact/index.php
$baseUrl = '/Wildlife';
?>

<?php include ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="bg-primary text-white py-16 relative overflow-hidden">
  <!-- Nature-inspired background pattern -->
  <div class="absolute inset-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <pattern id="leaf-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M30,50 Q50,20 70,50 Q50,80 30,50 Z" fill="currentColor"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#leaf-pattern)"/>
    </svg>
  </div>
  
  <div class="container mx-auto px-4 relative z-10 text-center">
    <h1 class="text-4xl md:text-5xl font-display font-bold mb-4">Contact Us</h1>
    <p class="text-xl max-w-3xl mx-auto">We're here to help. Let us know how we can assist you with your focus journey and wildlife conservation efforts.</p>
  </div>
</section>

<!-- Main Content Area -->
<section class="py-12 bg-light">
  <div class="container mx-auto px-4">
    <div class="max-w-5xl mx-auto">
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-5">
          <!-- Contact Information Sidebar -->
          <div class="lg:col-span-2 bg-primary text-white p-8">
            <h2 class="text-2xl font-display font-semibold mb-6">Get in Touch</h2>
            <p class="mb-8">Choose how you'd like to reach us—whether it's for support, feedback, or inquiries about our conservation initiatives.</p>
            
            <div class="space-y-6">
              <!-- Phone Contact -->
              <div class="flex items-start">
                <div class="bg-white bg-opacity-20 rounded-full p-3 mr-4">
                  <i class="fas fa-phone text-xl"></i>
                </div>
                <div>
                  <h3 class="font-bold text-lg">Call Us</h3>
                  <p class="text-gray-200 mb-1">+1 (555) 123-4567</p>
                  <p class="text-sm text-gray-300">Monday-Friday, 9 AM - 5 PM EST</p>
                </div>
              </div>
              
              <!-- Email Contact -->
              <div class="flex items-start">
                <div class="bg-white bg-opacity-20 rounded-full p-3 mr-4">
                  <i class="fas fa-envelope text-xl"></i>
                </div>
                <div>
                  <h3 class="font-bold text-lg">Email Us</h3>
                  <p class="text-gray-200 mb-1"><a href="mailto:support@wildlifehaven.com" class="hover:text-secondary transition">support@wildlifehaven.com</a></p>
                  <p class="text-sm text-gray-300">For general inquiries</p>
                  
                  <p class="text-gray-200 mt-2 mb-1"><a href="mailto:conservation@wildlifehaven.com" class="hover:text-secondary transition">conservation@wildlifehaven.com</a></p>
                  <p class="text-sm text-gray-300">For conservation partnership inquiries</p>
                </div>
              </div>
              
              <!-- Address -->
              <div class="flex items-start">
                <div class="bg-white bg-opacity-20 rounded-full p-3 mr-4">
                  <i class="fas fa-map-marker-alt text-xl"></i>
                </div>
                <div>
                  <h3 class="font-bold text-lg">Visit Us</h3>
                  <p class="text-gray-200 mb-1">
                    123 Forest Way, Suite 500<br>
                    Portland, OR 97205<br>
                    United States
                  </p>
                  <a href="https://maps.google.com" target="_blank" class="inline-flex items-center text-secondary hover:underline mt-2">
                    <span>Get Directions</span>
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                  </a>
                </div>
              </div>
              
              <!-- Social Media -->
              <div>
                <h3 class="font-bold text-lg mb-3">Connect With Us</h3>
                <div class="flex space-x-4">
                  <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 transition w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fab fa-facebook-f"></i>
                  </a>
                  <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 transition w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fab fa-twitter"></i>
                  </a>
                  <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 transition w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fab fa-instagram"></i>
                  </a>
                  <a href="#" class="bg-white bg-opacity-20 hover:bg-opacity-30 transition w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fab fa-linkedin-in"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Contact Form -->
          <div class="lg:col-span-3 p-8">
            <h2 class="text-2xl font-display font-semibold text-gray-800 mb-6">Send Us a Message</h2>
            
            <!-- Form Status Messages (initially hidden) -->
            <div id="form-success" class="hidden bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
              <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Thank you! Your message has been sent. We'll get back to you shortly.</span>
              </div>
            </div>
            
            <div id="form-error" class="hidden bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded mb-6">
              <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>Something went wrong. Please try again later.</span>
              </div>
            </div>
            
            <form id="contact-form" class="space-y-6">
              <!-- Name Fields - First and Last side by side -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                  <input type="text" id="first-name" name="first-name" placeholder="Enter your first name" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                  <span class="text-red-600 text-sm hidden" id="first-name-error">Please enter your first name</span>
                </div>
                
                <div>
                  <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                  <input type="text" id="last-name" name="last-name" placeholder="Enter your last name" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                  <span class="text-red-600 text-sm hidden" id="last-name-error">Please enter your last name</span>
                </div>
              </div>
              
              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <span class="text-red-600 text-sm hidden" id="email-error">Please enter a valid email address</span>
              </div>
              
              <!-- Phone (Optional) -->
              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number (Optional)</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
              </div>
              
              <!-- Subject Dropdown -->
              <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
                <select id="subject" name="subject" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                  <option value="" disabled selected>Select a subject</option>
                  <option value="support">Support Request</option>
                  <option value="feedback">App Feedback</option>
                  <option value="partnership">Conservation Partnership</option>
                  <option value="business">Business Inquiry</option>
                  <option value="other">Other</option>
                </select>
                <span class="text-red-600 text-sm hidden" id="subject-error">Please select a subject</span>
              </div>
              
              <!-- Message -->
              <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                <span class="text-red-600 text-sm hidden" id="message-error">Please enter your message</span>
              </div>
              
              <!-- File Upload -->
              <div>
                <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Attachment (Optional)</label>
                <div class="border border-dashed border-gray-300 rounded-md px-6 py-8">
                  <div class="text-center">
                    <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                    <p class="text-sm text-gray-500">
                      <span class="font-medium text-primary">Click to upload</span> or drag and drop
                    </p>
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, PDF, or DOC (Max. 5MB)</p>
                  </div>
                  <input id="attachment" name="attachment" type="file" class="hidden">
                </div>
                <div id="file-name" class="mt-2 text-sm text-gray-500 hidden">
                  <span class="font-medium"></span>
                  <button type="button" id="remove-file" class="ml-2 text-red-600">
                    <i class="fas fa-times"></i> Remove
                  </button>
                </div>
              </div>
              
              <!-- CAPTCHA -->
              <div class="flex items-center space-x-3">
                <div class="w-36 h-12 bg-gray-200 rounded-md flex items-center justify-center">
                  <span class="text-gray-500 font-mono">5RtG9a</span>
                </div>
                <div class="flex-grow">
                  <input type="text" id="captcha" name="captcha" placeholder="Enter the code shown" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                  <span class="text-red-600 text-sm hidden" id="captcha-error">Please enter the correct code</span>
                </div>
                <button type="button" class="h-12 w-12 bg-gray-100 hover:bg-gray-200 rounded-md flex items-center justify-center" title="Refresh CAPTCHA">
                  <i class="fas fa-sync-alt text-gray-600"></i>
                </button>
              </div>
              
              <!-- Terms & Submit -->
              <div class="pt-2">
                <div class="flex items-start mb-6">
                  <div class="flex items-center h-5">
                    <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                  </div>
                  <div class="ml-3 text-sm">
                    <label for="terms" class="font-medium text-gray-700">I agree to the <a href="#" class="text-primary hover:underline">Terms of Service</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a></label>
                    <span class="text-red-600 text-sm hidden block" id="terms-error">You must agree to the terms</span>
                  </div>
                </div>
                
                <button type="submit" class="w-full bg-primary text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition flex items-center justify-center">
                  <i class="fas fa-paper-plane mr-2"></i>
                  <span>Send Message</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Map Section -->
<section class="py-16">
  <div class="container mx-auto px-4">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-3xl font-display font-bold mb-6 text-center">Visit Our Office</h2>
      
      <div class="rounded-xl overflow-hidden shadow-lg h-96">
        <!-- Replace with actual Google Maps embed code -->
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d178526.6864358863!2d-122.85148883619143!3d45.542513699999986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54950a0f5d8eaee5%3A0x2c88fe635d0c31e1!2sForest%20Park!5e0!3m2!1sen!2sus!4v1646088555025!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-3xl font-display font-bold mb-2 text-center">Frequently Asked Questions</h2>
      <p class="text-center text-gray-600 mb-12">Find quick answers to common questions</p>
      
      <div class="space-y-6">
        <!-- FAQ Item 1 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <button class="faq-toggle w-full flex items-center justify-between p-6 text-left focus:outline-none" aria-expanded="false">
            <span class="text-lg font-semibold text-gray-800">How quickly can I expect a response?</span>
            <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
          </button>
          <div class="faq-content hidden px-6 pb-6">
            <p class="text-gray-600">We aim to respond to all inquiries within 24-48 business hours. For urgent matters, we recommend calling our support line directly for immediate assistance.</p>
          </div>
        </div>
        
        <!-- FAQ Item 2 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <button class="faq-toggle w-full flex items-center justify-between p-6 text-left focus:outline-none" aria-expanded="false">
            <span class="text-lg font-semibold text-gray-800">How can I partner with Wildlife Haven on conservation efforts?</span>
            <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
          </button>
          <div class="faq-content hidden px-6 pb-6">
            <p class="text-gray-600">We welcome conservation partnerships with organizations aligned with our mission. Please select "Conservation Partnership" in the contact form subject line, and our partnerships team will reach out to discuss collaboration opportunities.</p>
          </div>
        </div>
        
        <!-- FAQ Item 3 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <button class="faq-toggle w-full flex items-center justify-between p-6 text-left focus:outline-none" aria-expanded="false">
            <span class="text-lg font-semibold text-gray-800">I'm having technical issues with the app. How can I get help?</span>
            <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
          </button>
          <div class="faq-content hidden px-6 pb-6">
            <p class="text-gray-600">For technical support, please select "Support Request" in the contact form and provide details about the issue you're experiencing, including your device model and app version. Our technical team will assist you as soon as possible.</p>
          </div>
        </div>
        
        <!-- FAQ Item 4 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <button class="faq-toggle w-full flex items-center justify-between p-6 text-left focus:outline-none" aria-expanded="false">
            <span class="text-lg font-semibold text-gray-800">Do you offer educational programs or workshops?</span>
            <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
          </button>
          <div class="faq-content hidden px-6 pb-6">
            <p class="text-gray-600">Yes, we offer various educational programs, both virtual and in-person, focused on wildlife conservation and mindfulness practices. Contact us with "Educational Programs" in the subject line to learn about upcoming opportunities.</p>
          </div>
        </div>
      </div>
      
      <div class="text-center mt-10">
        <a href="<?= $baseUrl ?>/learn/faq" class="inline-flex items-center text-primary hover:underline font-medium">
          <span>View all FAQs</span>
          <i class="fas fa-arrow-right ml-2"></i>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Language Selector & Accessibility -->
<section class="py-6 bg-gray-100 border-t border-gray-200">
  <div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row justify-between items-center">
      <div class="mb-4 md:mb-0">
        <div class="flex items-center">
          <i class="fas fa-universal-access text-gray-500 mr-2"></i>
          <span class="text-gray-600 text-sm">Accessibility Tools:</span>
          <button class="ml-2 px-2 py-1 bg-white border border-gray-300 rounded text-sm flex items-center" id="increase-font">
            <i class="fas fa-font text-xs mr-1"></i>
            <i class="fas fa-plus text-xs"></i>
          </button>
          <button class="ml-2 px-2 py-1 bg-white border border-gray-300 rounded text-sm flex items-center" id="decrease-font">
            <i class="fas fa-font text-xs mr-1"></i>
            <i class="fas fa-minus text-xs"></i>
          </button>
          <button class="ml-2 px-2 py-1 bg-white border border-gray-300 rounded text-sm" id="high-contrast">
            <i class="fas fa-adjust text-xs"></i>
          </button>
        </div>
      </div>
      
      <div class="flex items-center">
        <span class="text-gray-600 text-sm mr-3">Language:</span>
        <select class="px-3 py-1 bg-white border border-gray-300 rounded text-sm">
          <option value="en">English</option>
          <option value="es">Español</option>
          <option value="fr">Français</option>
          <option value="de">Deutsch</option>
          <option value="zh">中文</option>
        </select>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // File upload handling
    const fileInput = document.getElementById('attachment');
    const fileNameDisplay = document.getElementById('file-name');
    const fileNameText = fileNameDisplay.querySelector('span');
    const removeFileButton = document.getElementById('remove-file');
    const dropZone = fileInput.parentElement;
    
    // Click to upload
    dropZone.addEventListener('click', function() {
      fileInput.click();
    });
    
    // Drag and drop functionality
    dropZone.addEventListener('dragover', function(e) {
      e.preventDefault();
      dropZone.classList.add('border-primary');
    });
    
    dropZone.addEventListener('dragleave', function() {
      dropZone.classList.remove('border-primary');
    });
    
    dropZone.addEventListener('drop', function(e) {
      e.preventDefault();
      dropZone.classList.remove('border-primary');
      
      if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        updateFileDisplay();
      }
    });
    
    // Handle file selection
    fileInput.addEventListener('change', updateFileDisplay);
    
    function updateFileDisplay() {
      if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        fileNameText.textContent = file.name;
        fileNameDisplay.classList.remove('hidden');
      } else {
        fileNameDisplay.classList.add('hidden');
      }
    }
    
    // Remove selected file
    removeFileButton.addEventListener('click', function() {
      fileInput.value = '';
      fileNameDisplay.classList.add('hidden');
    });
    
    // Form validation
    const contactForm = document.getElementById('contact-form');
    const formSuccess = document.getElementById('form-success');
    const formError = document.getElementById('form-error');
    
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Reset error messages
      document.querySelectorAll('.text-red-600').forEach(el => el.classList.add('hidden'));
      
      let isValid = true;
      
      // Validate required fields
      const requiredFields = ['first-name', 'last-name', 'email', 'subject', 'message', 'captcha'];
      
      requiredFields.forEach(field => {
        const input = document.getElementById(field);
        const errorMsg = document.getElementById(`${field}-error`);
        
        if (!input.value.trim()) {
          errorMsg.classList.remove('hidden');
          isValid = false;
        }
      });
      
      // Validate email format
      const emailInput = document.getElementById('email');
      const emailError = document.getElementById('email-error');
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      
      if (emailInput.value.trim() && !emailRegex.test(emailInput.value)) {
        emailError.classList.remove('hidden');
        isValid = false;
      }
      
      // Validate terms checkbox
      const termsCheckbox = document.getElementById('terms');
      const termsError = document.getElementById('terms-error');
      
      if (!termsCheckbox.checked) {
        termsError.classList.remove('hidden');
        isValid = false;
      }
      
      // Submit form if valid
      if (isValid) {
        // This would normally submit to server, but for demo we'll just show success message
        formSuccess.classList.remove('hidden');
        contactForm.reset();
        fileNameDisplay.classList.add('hidden');
        
        // Scroll to success message
        formSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Hide success message after 5 seconds
        setTimeout(() => {
          formSuccess.classList.add('hidden');
        }, 5000);
      }
    });
    
    // FAQ Toggles
    const faqToggles = document.querySelectorAll('.faq-toggle');
    
    faqToggles.forEach(toggle => {
      toggle.addEventListener('click', function() {
        const content = this.nextElementSibling;
        const icon = this.querySelector('i');
        
        // Toggle the content visibility
        content.classList.toggle('hidden');
        
        // Toggle icon rotation
        icon.classList.toggle('transform');
        icon.classList.toggle('rotate-180');
        
        // Update aria-expanded
        const expanded = this.getAttribute('aria-expanded') === 'true' || false;
        this.setAttribute('aria-expanded', !expanded);
      });
    });
    
    // Accessibility features
    const increaseFontBtn = document.getElementById('increase-font');
    const decreaseFontBtn = document.getElementById('decrease-font');
    const highContrastBtn = document.getElementById('high-contrast');
    
    let fontSize = 100;
    let highContrast = false;
    
    increaseFontBtn.addEventListener('click', function() {
      if (fontSize < 130) {
        fontSize += 10;
        document.body.style.fontSize = `${fontSize}%`;
      }
    });
    
    decreaseFontBtn.addEventListener('click', function() {
      if (fontSize > 90) {
        fontSize -= 10;
        document.body.style.fontSize = `${fontSize}%`;
      }
    });
    
    highContrastBtn.addEventListener('click', function() {
      highContrast = !highContrast;
      
      if (highContrast) {
        document.body.classList.add('high-contrast');
      } else {
        document.body.classList.remove('high-contrast');
      }
    });
  });
</script>

<!-- High Contrast Mode Styles -->
<style>
  body.high-contrast {
    background: #000;
    color: #fff;
  }
  
  body.high-contrast .bg-white {
    background-color: #000 !important;
    color: #fff !important;
  }
  
  body.high-contrast .text-gray-600, 
  body.high-contrast .text-gray-700, 
  body.high-contrast .text-gray-800 {
    color: #fff !important;
  }
  
  body.high-contrast .border {
    border-color: #fff !important;
  }
  
  body.high-contrast .bg-primary {
    background-color: #000 !important;
  }
  
  body.high-contrast a, 
  body.high-contrast button {
    color: #ffff00 !important;
  }
  
  body.high-contrast input, 
  body.high-contrast select, 
  body.high-contrast textarea {
    background-color: #000 !important;
    color: #fff !important;
    border-color: #fff !important;
  }
</style>

<?php include ROOT_PATH . '/resources/views/layouts/footer.php'; ?> 