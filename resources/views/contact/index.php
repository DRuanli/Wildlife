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
    <h1 class="text-4xl md:text-5xl font-display font-bold mb-4" data-lang-key="contact-us">Contact Us</h1>
    <p class="text-xl max-w-3xl mx-auto" data-lang-key="contact-subtitle">We're here to help. Let us know how we can assist you with your focus journey and wildlife conservation efforts.</p>
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
            <h2 class="text-2xl font-display font-semibold mb-6" data-lang-key="get-in-touch">Get in Touch</h2>
            <p class="mb-8" data-lang-key="contact-intro">Choose how you'd like to reach us—whether it's for support, feedback, or inquiries about our conservation initiatives.</p>
            
            <div class="space-y-6">
              <!-- Phone Contact -->
              <div class="flex items-start">
                <div class="bg-white bg-opacity-20 rounded-full p-3 mr-4">
                  <i class="fas fa-phone text-xl"></i>
                </div>
                <div>
                  <h3 class="font-bold text-lg" data-lang-key="call-us">Call Us</h3>
                  <p class="text-gray-200 mb-1">+1 (555) 123-4567</p>
                  <p class="text-sm text-gray-300" data-lang-key="call-hours">Monday-Friday, 9 AM - 5 PM EST</p>
                </div>
              </div>
              
              <!-- Email Contact -->
              <div class="flex items-start">
                <div class="bg-white bg-opacity-20 rounded-full p-3 mr-4">
                  <i class="fas fa-envelope text-xl"></i>
                </div>
                <div>
                  <h3 class="font-bold text-lg" data-lang-key="email-us">Email Us</h3>
                  <p class="text-gray-200 mb-1"><a href="mailto:support@wildlifehaven.com" class="hover:text-secondary transition">support@wildlifehaven.com</a></p>
                  <p class="text-sm text-gray-300" data-lang-key="general-inquiries">For general inquiries</p>
                  
                  <p class="text-gray-200 mt-2 mb-1"><a href="mailto:conservation@wildlifehaven.com" class="hover:text-secondary transition">conservation@wildlifehaven.com</a></p>
                  <p class="text-sm text-gray-300" data-lang-key="conservation-inquiries">For conservation partnership inquiries</p>
                </div>
              </div>
              
              <!-- Address -->
              <div class="flex items-start">
                <div class="bg-white bg-opacity-20 rounded-full p-3 mr-4">
                  <i class="fas fa-map-marker-alt text-xl"></i>
                </div>
                <div>
                  <h3 class="font-bold text-lg" data-lang-key="visit-us">Visit Us</h3>
                  <p class="text-gray-200 mb-1">
                    123 Forest Way, Suite 500<br>
                    Portland, OR 97205<br>
                    United States
                  </p>
                  <a href="https://maps.google.com" target="_blank" class="inline-flex items-center text-secondary hover:underline mt-2">
                    <span data-lang-key="get-directions">Get Directions</span>
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                  </a>
                </div>
              </div>
              
              <!-- Social Media -->
              <div>
                <h3 class="font-bold text-lg mb-3" data-lang-key="connect-with-us">Connect With Us</h3>
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
            <h2 class="text-2xl font-display font-semibold text-gray-800 mb-6" data-lang-key="send-message">Send Us a Message</h2>
            
            <!-- Form Status Messages (initially hidden) -->
            <div id="form-success" class="hidden bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
              <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span data-lang-key="form-success">Thank you! Your message has been sent. We'll get back to you shortly.</span>
              </div>
            </div>
            
            <div id="form-error" class="hidden bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded mb-6">
              <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span data-lang-key="form-error">Something went wrong. Please try again later.</span>
              </div>
            </div>
            
            <form id="contact-form" class="space-y-6">
              <!-- Name Fields - First and Last side by side -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1" data-lang-key="first-name">First Name *</label>
                  <input type="text" id="first-name" name="first-name" placeholder="Enter your first name" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                  <span class="text-red-600 text-sm hidden" id="first-name-error" data-lang-key="first-name-error">Please enter your first name</span>
                </div>
                
                <div>
                  <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1" data-lang-key="last-name">Last Name *</label>
                  <input type="text" id="last-name" name="last-name" placeholder="Enter your last name" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                  <span class="text-red-600 text-sm hidden" id="last-name-error" data-lang-key="last-name-error">Please enter your last name</span>
                </div>
              </div>
              
              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1" data-lang-key="email">Email Address *</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <span class="text-red-600 text-sm hidden" id="email-error" data-lang-key="email-error">Please enter a valid email address</span>
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
        <span class="text-gray-600 text-sm mr-3" data-lang-key="language">Language:</span>
        <select id="language-selector" class="px-3 py-1 bg-white border border-gray-300 rounded text-sm">
          <option value="en">English</option>
          <option value="vi">Tiếng Việt</option>
          <option value="fr">Français</option>
          <option value="es">Español</option>
          <option value="de">Deutsch</option>
          <option value="zh">中文</option>
        </select>
      </div>
    </div>
  </div>
</section>

<script>
      // Language translations
  const translations = {
    en: {
      // Page titles
      "contact-us": "Contact Us",
      "contact-subtitle": "We're here to help. Let us know how we can assist you with your focus journey and wildlife conservation efforts.",
      // Theme selector
      "theme": "Theme:",
      "theme-light": "Light",
      "theme-dark": "Dark",
      "theme-system": "System Default",
      // Contact info sidebar
      "get-in-touch": "Get in Touch",
      "contact-intro": "Choose how you'd like to reach us—whether it's for support, feedback, or inquiries about our conservation initiatives.",
      "call-us": "Call Us",
      "call-hours": "Monday-Friday, 9 AM - 5 PM EST",
      "email-us": "Email Us",
      "general-inquiries": "For general inquiries",
      "conservation-inquiries": "For conservation partnership inquiries",
      "visit-us": "Visit Us",
      "get-directions": "Get Directions",
      "connect-with-us": "Connect With Us",
      // Form section
      "send-message": "Send Us a Message",
      "form-success": "Thank you! Your message has been sent. We'll get back to you shortly.",
      "form-error": "Something went wrong. Please try again later.",
      "first-name": "First Name *",
      "first-name-placeholder": "Enter your first name",
      "first-name-error": "Please enter your first name",
      "last-name": "Last Name *",
      "last-name-placeholder": "Enter your last name",
      "last-name-error": "Please enter your last name",
      "email": "Email Address *",
      "email-placeholder": "Enter your email address",
      "email-error": "Please enter a valid email address",
      "phone": "Phone Number (Optional)",
      "phone-placeholder": "Enter your phone number",
      "subject": "Subject *",
      "subject-placeholder": "Select a subject",
      "subject-error": "Please select a subject",
      "subject-support": "Support Request",
      "subject-feedback": "App Feedback",
      "subject-partnership": "Conservation Partnership",
      "subject-business": "Business Inquiry",
      "subject-other": "Other",
      "message": "Message *",
      "message-placeholder": "Write your message here...",
      "message-error": "Please enter your message",
      "attachment": "Attachment (Optional)",
      "attachment-upload": "Click to upload",
      "attachment-drop": "or drag and drop",
      "attachment-types": "PNG, JPG, PDF, or DOC (Max. 5MB)",
      "attachment-remove": "Remove",
      "captcha": "Enter the code shown",
      "captcha-error": "Please enter the correct code",
      "captcha-refresh": "Refresh CAPTCHA",
      "terms-agree": "I agree to the",
      "terms-service": "Terms of Service",
      "terms-and": "and",
      "terms-privacy": "Privacy Policy",
      "terms-error": "You must agree to the terms",
      "send-button": "Send Message",
      // Map section
      "visit-office": "Visit Our Office",
      // FAQ section
      "faq-title": "Frequently Asked Questions",
      "faq-subtitle": "Find quick answers to common questions",
      "faq-question-1": "How quickly can I expect a response?",
      "faq-answer-1": "We aim to respond to all inquiries within 24-48 business hours. For urgent matters, we recommend calling our support line directly for immediate assistance.",
      "faq-question-2": "How can I partner with Wildlife Haven on conservation efforts?",
      "faq-answer-2": "We welcome conservation partnerships with organizations aligned with our mission. Please select \"Conservation Partnership\" in the contact form subject line, and our partnerships team will reach out to discuss collaboration opportunities.",
      "faq-question-3": "I'm having technical issues with the app. How can I get help?",
      "faq-answer-3": "For technical support, please select \"Support Request\" in the contact form and provide details about the issue you're experiencing, including your device model and app version. Our technical team will assist you as soon as possible.",
      "faq-question-4": "Do you offer educational programs or workshops?",
      "faq-answer-4": "Yes, we offer various educational programs, both virtual and in-person, focused on wildlife conservation and mindfulness practices. Contact us with \"Educational Programs\" in the subject line to learn about upcoming opportunities.",
      "view-all-faqs": "View all FAQs",
      // Accessibility
      "accessibility-tools": "Accessibility Tools:",
      "language": "Language:"
    },
    vi: {
      // Page titles
      "contact-us": "Liên Hệ",
      "contact-subtitle": "Chúng tôi luôn sẵn sàng hỗ trợ. Hãy cho chúng tôi biết làm thế nào chúng tôi có thể giúp đỡ bạn trong hành trình tập trung và nỗ lực bảo tồn động vật hoang dã.",
      // Theme selector
      "theme": "Chủ đề:",
      "theme-light": "Sáng",
      "theme-dark": "Tối",
      "theme-system": "Mặc định hệ thống",
      // Contact info sidebar
      "get-in-touch": "Liên Lạc",
      "contact-intro": "Chọn cách bạn muốn liên hệ với chúng tôi—cho dù đó là hỗ trợ, phản hồi, hay câu hỏi về các sáng kiến bảo tồn của chúng tôi.",
      "call-us": "Gọi Cho Chúng Tôi",
      "call-hours": "Thứ Hai–Thứ Sáu, 9 giờ sáng - 5 giờ chiều EST",
      "email-us": "Gửi Email Cho Chúng Tôi",
      "general-inquiries": "Cho các câu hỏi chung",
      "conservation-inquiries": "Cho các câu hỏi về hợp tác bảo tồn",
      "visit-us": "Ghé Thăm Chúng Tôi",
      "get-directions": "Xem Chỉ Đường",
      "connect-with-us": "Kết Nối Với Chúng Tôi",
      // Form section
      "send-message": "Gửi Tin Nhắn Cho Chúng Tôi",
      "form-success": "Cảm ơn bạn! Tin nhắn của bạn đã được gửi. Chúng tôi sẽ liên hệ lại với bạn sớm nhất có thể.",
      "form-error": "Đã xảy ra lỗi. Vui lòng thử lại sau.",
      "first-name": "Tên *",
      "first-name-placeholder": "Nhập tên của bạn",
      "first-name-error": "Vui lòng nhập tên của bạn",
      "last-name": "Họ *",
      "last-name-placeholder": "Nhập họ của bạn",
      "last-name-error": "Vui lòng nhập họ của bạn",
      "email": "Địa Chỉ Email *",
      "email-placeholder": "Nhập địa chỉ email của bạn",
      "email-error": "Vui lòng nhập một địa chỉ email hợp lệ",
      "phone": "Số Điện Thoại (Tùy chọn)",
      "phone-placeholder": "Nhập số điện thoại của bạn",
      "subject": "Chủ Đề *",
      "subject-placeholder": "Chọn một chủ đề",
      "subject-error": "Vui lòng chọn một chủ đề",
      "subject-support": "Yêu Cầu Hỗ Trợ",
      "subject-feedback": "Phản Hồi Ứng Dụng",
      "subject-partnership": "Hợp Tác Bảo Tồn",
      "subject-business": "Thắc Mắc Kinh Doanh",
      "subject-other": "Khác",
      "message": "Tin Nhắn *",
      "message-placeholder": "Viết tin nhắn của bạn tại đây...",
      "message-error": "Vui lòng nhập tin nhắn của bạn",
      "attachment": "Tệp Đính Kèm (Tùy chọn)",
      "attachment-upload": "Nhấp để tải lên",
      "attachment-drop": "hoặc kéo và thả",
      "attachment-types": "PNG, JPG, PDF, hoặc DOC (Tối đa 5MB)",
      "attachment-remove": "Xóa",
      "captcha": "Nhập mã hiển thị",
      "captcha-error": "Vui lòng nhập đúng mã",
      "captcha-refresh": "Làm mới CAPTCHA",
      "terms-agree": "Tôi đồng ý với",
      "terms-service": "Điều Khoản Dịch Vụ",
      "terms-and": "và",
      "terms-privacy": "Chính Sách Bảo Mật",
      "terms-error": "Bạn phải đồng ý với các điều khoản",
      "send-button": "Gửi Tin Nhắn",
      // Map section
      "visit-office": "Ghé Thăm Văn Phòng Của Chúng Tôi",
      // FAQ section
      "faq-title": "Câu Hỏi Thường Gặp",
      "faq-subtitle": "Tìm câu trả lời nhanh cho các câu hỏi phổ biến",
      "faq-question-1": "Tôi có thể nhận được phản hồi trong bao lâu?",
      "faq-answer-1": "Chúng tôi cố gắng phản hồi tất cả các câu hỏi trong vòng 24-48 giờ làm việc. Đối với các vấn đề khẩn cấp, chúng tôi khuyên bạn nên gọi trực tiếp đến đường dây hỗ trợ của chúng tôi để được hỗ trợ ngay lập tức.",
      "faq-question-2": "Làm thế nào để hợp tác với Wildlife Haven trong các nỗ lực bảo tồn?",
      "faq-answer-2": "Chúng tôi chào đón các đối tác bảo tồn với các tổ chức có cùng sứ mệnh. Vui lòng chọn \"Hợp Tác Bảo Tồn\" trong dòng chủ đề biểu mẫu liên hệ, và đội ngũ đối tác của chúng tôi sẽ liên hệ để thảo luận về cơ hội hợp tác.",
      "faq-question-3": "Tôi đang gặp vấn đề kỹ thuật với ứng dụng. Làm thế nào để được giúp đỡ?",
      "faq-answer-3": "Đối với hỗ trợ kỹ thuật, vui lòng chọn \"Yêu Cầu Hỗ Trợ\" trong biểu mẫu liên hệ và cung cấp chi tiết về vấn đề bạn đang gặp phải, bao gồm kiểu thiết bị và phiên bản ứng dụng. Đội ngũ kỹ thuật của chúng tôi sẽ hỗ trợ bạn sớm nhất có thể.",
      "faq-question-4": "Bạn có cung cấp các chương trình giáo dục hoặc hội thảo không?",
      "faq-answer-4": "Có, chúng tôi cung cấp nhiều chương trình giáo dục, cả trực tuyến và trực tiếp, tập trung vào bảo tồn động vật hoang dã và thực hành chánh niệm. Liên hệ với chúng tôi với \"Chương Trình Giáo Dục\" trong dòng chủ đề để tìm hiểu về các cơ hội sắp tới.",
      "view-all-faqs": "Xem tất cả câu hỏi thường gặp",
      // Accessibility
      "accessibility-tools": "Công Cụ Trợ Năng:",
      "language": "Ngôn Ngữ:"
    },
    fr: {
      // Page titles
      "contact-us": "Contactez-Nous",
      "contact-subtitle": "Nous sommes là pour vous aider. Faites-nous savoir comment nous pouvons vous accompagner dans votre parcours de concentration et vos efforts de conservation de la faune.",
      // Theme selector
      "theme": "Thème:",
      "theme-light": "Clair",
      "theme-dark": "Sombre",
      "theme-system": "Système par défaut",
      // Contact info sidebar
      "get-in-touch": "Entrer en Contact",
      "contact-intro": "Choisissez comment vous souhaitez nous joindre—que ce soit pour du support, des commentaires ou des questions sur nos initiatives de conservation.",
      "call-us": "Appelez-Nous",
      "call-hours": "Lundi–Vendredi, 9h - 17h EST",
      "email-us": "Envoyez-Nous un Email",
      "general-inquiries": "Pour les demandes générales",
      "conservation-inquiries": "Pour les demandes de partenariat de conservation",
      "visit-us": "Rendez-Nous Visite",
      "get-directions": "Obtenir l'Itinéraire",
      "connect-with-us": "Connectez-Vous Avec Nous",
      // Form section
      "send-message": "Envoyez-Nous un Message",
      "form-success": "Merci ! Votre message a été envoyé. Nous vous répondrons dès que possible.",
      "form-error": "Une erreur s'est produite. Veuillez réessayer plus tard.",
      "first-name": "Prénom *",
      "first-name-placeholder": "Entrez votre prénom",
      "first-name-error": "Veuillez entrer votre prénom",
      "last-name": "Nom *",
      "last-name-placeholder": "Entrez votre nom",
      "last-name-error": "Veuillez entrer votre nom",
      "email": "Adresse Email *",
      "email-placeholder": "Entrez votre adresse email",
      "email-error": "Veuillez entrer une adresse email valide",
      "phone": "Numéro de Téléphone (Optionnel)",
      "phone-placeholder": "Entrez votre numéro de téléphone",
      "subject": "Sujet *",
      "subject-placeholder": "Sélectionnez un sujet",
      "subject-error": "Veuillez sélectionner un sujet",
      "subject-support": "Demande d'Assistance",
      "subject-feedback": "Commentaires sur l'Application",
      "subject-partnership": "Partenariat de Conservation",
      "subject-business": "Demande Commerciale",
      "subject-other": "Autre",
      "message": "Message *",
      "message-placeholder": "Écrivez votre message ici...",
      "message-error": "Veuillez entrer votre message",
      "attachment": "Pièce Jointe (Optionnel)",
      "attachment-upload": "Cliquez pour télécharger",
      "attachment-drop": "ou glissez-déposez",
      "attachment-types": "PNG, JPG, PDF, ou DOC (Max. 5MB)",
      "attachment-remove": "Supprimer",
      "captcha": "Entrez le code affiché",
      "captcha-error": "Veuillez entrer le code correct",
      "captcha-refresh": "Actualiser CAPTCHA",
      "terms-agree": "J'accepte les",
      "terms-service": "Conditions d'Utilisation",
      "terms-and": "et la",
      "terms-privacy": "Politique de Confidentialité",
      "terms-error": "Vous devez accepter les conditions",
      "send-button": "Envoyer le Message",
      // Map section
      "visit-office": "Visitez Notre Bureau",
      // FAQ section
      "faq-title": "Questions Fréquemment Posées",
      "faq-subtitle": "Trouvez des réponses rapides aux questions courantes",
      "faq-question-1": "À quelle vitesse puis-je m'attendre à une réponse?",
      "faq-answer-1": "Nous visons à répondre à toutes les demandes dans un délai de 24 à 48 heures ouvrables. Pour les questions urgentes, nous vous recommandons d'appeler directement notre ligne d'assistance pour une aide immédiate.",
      "faq-question-2": "Comment puis-je collaborer avec Wildlife Haven sur les efforts de conservation?",
      "faq-answer-2": "Nous accueillons favorablement les partenariats de conservation avec des organisations alignées sur notre mission. Veuillez sélectionner \"Partenariat de Conservation\" dans la ligne d'objet du formulaire de contact, et notre équipe de partenariats vous contactera pour discuter des opportunités de collaboration.",
      "faq-question-3": "Je rencontre des problèmes techniques avec l'application. Comment puis-je obtenir de l'aide?",
      "faq-answer-3": "Pour l'assistance technique, veuillez sélectionner \"Demande d'Assistance\" dans le formulaire de contact et fournir des détails sur le problème que vous rencontrez, y compris votre modèle d'appareil et la version de l'application. Notre équipe technique vous aidera dès que possible.",
      "faq-question-4": "Proposez-vous des programmes éducatifs ou des ateliers?",
      "faq-answer-4": "Oui, nous proposons divers programmes éducatifs, à la fois virtuels et en personne, axés sur la conservation de la faune et les pratiques de pleine conscience. Contactez-nous avec \"Programmes Éducatifs\" dans la ligne d'objet pour en savoir plus sur les opportunités à venir.",
      "view-all-faqs": "Voir toutes les FAQs",
      // Accessibility
      "accessibility-tools": "Outils d'Accessibilité:",
      "language": "Langue:"
    },
    es: {
      // Page titles
      "contact-us": "Contáctenos",
      "contact-subtitle": "Estamos aquí para ayudar. Háganos saber cómo podemos ayudarle con su viaje de concentración y esfuerzos de conservación de la vida silvestre.",
      // Theme selector
      "theme": "Tema:",
      "theme-light": "Claro",
      "theme-dark": "Oscuro",
      "theme-system": "Predeterminado del sistema",
      // Contact info sidebar
      "get-in-touch": "Póngase en Contacto",
      "contact-intro": "Elija cómo desea comunicarse con nosotros, ya sea para soporte, comentarios o consultas sobre nuestras iniciativas de conservación.",
      "call-us": "Llámenos",
      "call-hours": "Lunes–Viernes, 9 AM - 5 PM EST",
      "email-us": "Envíenos un Email",
      "general-inquiries": "Para consultas generales",
      "conservation-inquiries": "Para consultas sobre asociaciones de conservación",
      "visit-us": "Visítenos",
      "get-directions": "Obtener Indicaciones",
      "connect-with-us": "Conéctese Con Nosotros",
      // Form section
      "send-message": "Envíenos un Mensaje",
      "form-success": "¡Gracias! Su mensaje ha sido enviado. Nos pondremos en contacto con usted lo antes posible.",
      "form-error": "Algo salió mal. Por favor, inténtelo de nuevo más tarde.",
      "first-name": "Nombre *",
      "first-name-placeholder": "Ingrese su nombre",
      "first-name-error": "Por favor ingrese su nombre",
      "last-name": "Apellido *",
      "last-name-placeholder": "Ingrese su apellido",
      "last-name-error": "Por favor ingrese su apellido",
      "email": "Dirección de Email *",
      "email-placeholder": "Ingrese su dirección de email",
      "email-error": "Por favor ingrese una dirección de email válida",
      "phone": "Número de Teléfono (Opcional)",
      "phone-placeholder": "Ingrese su número de teléfono",
      "subject": "Asunto *",
      "subject-placeholder": "Seleccione un asunto",
      "subject-error": "Por favor seleccione un asunto",
      "subject-support": "Solicitud de Soporte",
      "subject-feedback": "Comentarios sobre la Aplicación",
      "subject-partnership": "Asociación de Conservación",
      "subject-business": "Consulta de Negocios",
      "subject-other": "Otro",
      "message": "Mensaje *",
      "message-placeholder": "Escriba su mensaje aquí...",
      "message-error": "Por favor ingrese su mensaje",
      "attachment": "Archivo Adjunto (Opcional)",
      "attachment-upload": "Haga clic para subir",
      "attachment-drop": "o arrastre y suelte",
      "attachment-types": "PNG, JPG, PDF, o DOC (Máx. 5MB)",
      "attachment-remove": "Eliminar",
      "captcha": "Ingrese el código mostrado",
      "captcha-error": "Por favor ingrese el código correcto",
      "captcha-refresh": "Actualizar CAPTCHA",
      "terms-agree": "Acepto los",
      "terms-service": "Términos de Servicio",
      "terms-and": "y la",
      "terms-privacy": "Política de Privacidad",
      "terms-error": "Debe aceptar los términos",
      "send-button": "Enviar Mensaje",
      // Map section
      "visit-office": "Visite Nuestra Oficina",
      // FAQ section
      "faq-title": "Preguntas Frecuentes",
      "faq-subtitle": "Encuentre respuestas rápidas a preguntas comunes",
      "faq-question-1": "¿Qué tan rápido puedo esperar una respuesta?",
      "faq-answer-1": "Nos esforzamos por responder a todas las consultas dentro de las 24-48 horas hábiles. Para asuntos urgentes, recomendamos llamar directamente a nuestra línea de soporte para asistencia inmediata.",
      "faq-question-2": "¿Cómo puedo asociarme con Wildlife Haven en esfuerzos de conservación?",
      "faq-answer-2": "Damos la bienvenida a asociaciones de conservación con organizaciones alineadas con nuestra misión. Por favor, seleccione \"Asociación de Conservación\" en el asunto del formulario de contacto, y nuestro equipo de asociaciones se pondrá en contacto para discutir oportunidades de colaboración.",
      "faq-question-3": "Estoy teniendo problemas técnicos con la aplicación. ¿Cómo puedo obtener ayuda?",
      "faq-answer-3": "Para soporte técnico, seleccione \"Solicitud de Soporte\" en el formulario de contacto y proporcione detalles sobre el problema que está experimentando, incluyendo su modelo de dispositivo y versión de la aplicación. Nuestro equipo técnico le ayudará lo antes posible.",
      "faq-question-4": "¿Ofrecen programas educativos o talleres?",
      "faq-answer-4": "Sí, ofrecemos varios programas educativos, tanto virtuales como presenciales, centrados en la conservación de la vida silvestre y prácticas de atención plena. Contáctenos con \"Programas Educativos\" en el asunto para conocer las próximas oportunidades.",
      "view-all-faqs": "Ver todas las preguntas frecuentes",
      // Accessibility
      "accessibility-tools": "Herramientas de Accesibilidad:",
      "language": "Idioma:"
    },
    de: {
      // Page titles
      "contact-us": "Kontaktieren Sie Uns",
      "contact-subtitle": "Wir sind für Sie da. Lassen Sie uns wissen, wie wir Ihnen bei Ihrer Fokusreise und Ihren Bemühungen zum Schutz der Tierwelt helfen können.",
      // Theme selector
      "theme": "Thema:",
      "theme-light": "Hell",
      "theme-dark": "Dunkel",
      "theme-system": "Systemstandard",
      // Contact info sidebar
      "get-in-touch": "Kontakt Aufnehmen",
      "contact-intro": "Wählen Sie, wie Sie uns erreichen möchten—ob für Support, Feedback oder Anfragen zu unseren Naturschutzinitiativen.",
      "call-us": "Rufen Sie Uns An",
      "call-hours": "Montag–Freitag, 9 Uhr - 17 Uhr EST",
      "email-us": "Senden Sie Uns eine E-Mail",
      "general-inquiries": "Für allgemeine Anfragen",
      "conservation-inquiries": "Für Anfragen zu Naturschutzpartnerschaften",
      "visit-us": "Besuchen Sie Uns",
      "get-directions": "Wegbeschreibung Erhalten",
      "connect-with-us": "Verbinden Sie Sich Mit Uns",
      // Form section
      "send-message": "Senden Sie Uns eine Nachricht",
      "form-success": "Vielen Dank! Ihre Nachricht wurde gesendet. Wir werden uns in Kürze bei Ihnen melden.",
      "form-error": "Etwas ist schiefgelaufen. Bitte versuchen Sie es später erneut.",
      "first-name": "Vorname *",
      "first-name-placeholder": "Geben Sie Ihren Vornamen ein",
      "first-name-error": "Bitte geben Sie Ihren Vornamen ein",
      "last-name": "Nachname *",
      "last-name-placeholder": "Geben Sie Ihren Nachnamen ein",
      "last-name-error": "Bitte geben Sie Ihren Nachnamen ein",
      "email": "E-Mail-Adresse *",
      "email-placeholder": "Geben Sie Ihre E-Mail-Adresse ein",
      "email-error": "Bitte geben Sie eine gültige E-Mail-Adresse ein",
      "phone": "Telefonnummer (Optional)",
      "phone-placeholder": "Geben Sie Ihre Telefonnummer ein",
      "subject": "Betreff *",
      "subject-placeholder": "Wählen Sie einen Betreff",
      "subject-error": "Bitte wählen Sie einen Betreff",
      "subject-support": "Support-Anfrage",
      "subject-feedback": "App-Feedback",
      "subject-partnership": "Naturschutzpartnerschaft",
      "subject-business": "Geschäftsanfrage",
      "subject-other": "Anderes",
      "message": "Nachricht *",
      "message-placeholder": "Schreiben Sie Ihre Nachricht hier...",
      "message-error": "Bitte geben Sie Ihre Nachricht ein",
      "attachment": "Anhang (Optional)",
      "attachment-upload": "Klicken zum Hochladen",
      "attachment-drop": "oder ziehen und ablegen",
      "attachment-types": "PNG, JPG, PDF oder DOC (Max. 5MB)",
      "attachment-remove": "Entfernen",
      "captcha": "Geben Sie den angezeigten Code ein",
      "captcha-error": "Bitte geben Sie den richtigen Code ein",
      "captcha-refresh": "CAPTCHA aktualisieren",
      "terms-agree": "Ich stimme den",
      "terms-service": "Nutzungsbedingungen",
      "terms-and": "und der",
      "terms-privacy": "Datenschutzerklärung zu",
      "terms-error": "Sie müssen den Bedingungen zustimmen",
      "send-button": "Nachricht Senden",
      // Map section
      "visit-office": "Besuchen Sie Unser Büro",
      // FAQ section
      "faq-title": "Häufig Gestellte Fragen",
      "faq-subtitle": "Finden Sie schnelle Antworten auf häufige Fragen",
      "faq-question-1": "Wie schnell kann ich mit einer Antwort rechnen?",
      "faq-answer-1": "Wir bemühen uns, alle Anfragen innerhalb von 24-48 Geschäftsstunden zu beantworten. Bei dringenden Angelegenheiten empfehlen wir, direkt unsere Support-Hotline anzurufen, um sofortige Hilfe zu erhalten.",
      "faq-question-2": "Wie kann ich mit Wildlife Haven bei Naturschutzbemühungen zusammenarbeiten?",
      "faq-answer-2": "Wir begrüßen Naturschutzpartnerschaften mit Organisationen, die mit unserer Mission übereinstimmen. Bitte wählen Sie \"Naturschutzpartnerschaft\" in der Betreffzeile des Kontaktformulars, und unser Partnerschaftsteam wird sich mit Ihnen in Verbindung setzen, um Kooperationsmöglichkeiten zu besprechen.",
      "faq-question-3": "Ich habe technische Probleme mit der App. Wie kann ich Hilfe bekommen?",
      "faq-answer-3": "Für technischen Support wählen Sie bitte \"Support-Anfrage\" im Kontaktformular und geben Sie Details zu dem Problem an, das Sie erleben, einschließlich Ihres Gerätemodells und der App-Version. Unser technisches Team wird Ihnen so schnell wie möglich helfen.",
      "faq-question-4": "Bieten Sie Bildungsprogramme oder Workshops an?",
      "faq-answer-4": "Ja, wir bieten verschiedene Bildungsprogramme an, sowohl virtuell als auch persönlich, die sich auf Naturschutz und Achtsamkeitspraktiken konzentrieren. Kontaktieren Sie uns mit \"Bildungsprogramme\" in der Betreffzeile, um mehr über kommende Möglichkeiten zu erfahren.",
      "view-all-faqs": "Alle FAQs anzeigen",
      // Accessibility
      "accessibility-tools": "Barrierefreiheit-Tools:",
      "language": "Sprache:"
    },
    zh: {
      // Page titles
      "contact-us": "联系我们",
      "contact-subtitle": "我们随时为您提供帮助。请告诉我们如何协助您的专注之旅和野生动物保护工作。",
      // Theme selector
      "theme": "主题：",
      "theme-light": "浅色",
      "theme-dark": "深色",
      "theme-system": "系统默认",
      // Contact info sidebar
      "get-in-touch": "取得联系",
      "contact-intro": "选择您希望与我们联系的方式—无论是寻求支持、提供反馈还是咨询我们的保护倡议。",
      "call-us": "致电我们",
      "call-hours": "周一至周五，上午9点至下午5点（东部标准时间）",
      "email-us": "给我们发邮件",
      "general-inquiries": "一般咨询",
      "conservation-inquiries": "保护合作咨询",
      "visit-us": "访问我们",
      "get-directions": "获取路线",
      "connect-with-us": "与我们连接",
      // Form section
      "send-message": "给我们发送消息",
      "form-success": "谢谢您！您的消息已发送。我们将尽快回复您。",
      "form-error": "出现错误。请稍后再试。",
      "first-name": "名字 *",
      "first-name-placeholder": "输入您的名字",
      "first-name-error": "请输入您的名字",
      "last-name": "姓氏 *",
      "last-name-placeholder": "输入您的姓氏",
      "last-name-error": "请输入您的姓氏",
      "email": "电子邮件地址 *",
      "email-placeholder": "输入您的电子邮件地址",
      "email-error": "请输入有效的电子邮件地址",
      "phone": "电话号码（可选）",
      "phone-placeholder": "输入您的电话号码",
      "subject": "主题 *",
      "subject-placeholder": "选择一个主题",
      "subject-error": "请选择一个主题",
      "subject-support": "支持请求",
      "subject-feedback": "应用反馈",
      "subject-partnership": "保护合作",
      "subject-business": "业务咨询",
      "subject-other": "其他",
      "message": "消息 *",
      "message-placeholder": "在此处写下您的消息...",
      "message-error": "请输入您的消息",
      "attachment": "附件（可选）",
      "attachment-upload": "点击上传",
      "attachment-drop": "或拖放",
      "attachment-types": "PNG, JPG, PDF, 或 DOC（最大 5MB）",
      "attachment-remove": "移除",
      "captcha": "输入显示的代码",
      "captcha-error": "请输入正确的代码",
      "captcha-refresh": "刷新验证码",
      "terms-agree": "我同意",
      "terms-service": "服务条款",
      "terms-and": "和",
      "terms-privacy": "隐私政策",
      "terms-error": "您必须同意条款",
      "send-button": "发送消息",
      // Map section
      "visit-office": "访问我们的办公室",
      // FAQ section
      "faq-title": "常见问题",
      "faq-subtitle": "查找常见问题的快速答案",
      "faq-question-1": "我多久能收到回复？",
      "faq-answer-1": "我们努力在24-48个工作小时内回复所有咨询。对于紧急事项，我们建议直接拨打我们的支持热线获取即时帮助。",
      "faq-question-2": "我如何与Wildlife Haven在保护工作上合作？",
      "faq-answer-2": "我们欢迎与使命相符的组织进行保护合作。请在联系表单的主题行中选择"保护合作"，我们的合作团队将与您联系，讨论合作机会。",
      "faq-question-3": "我在使用应用程序时遇到技术问题。如何获取帮助？",
      "faq-answer-3": "对于技术支持，请在联系表单中选择"支持请求"，并提供您遇到的问题详情，包括您的设备型号和应用版本。我们的技术团队将尽快协助您。",
      "faq-question-4": "您提供教育项目或工作坊吗？",
      "faq-answer-4": "是的，我们提供各种教育项目，包括虚拟和现场项目，专注于野生动物保护和正念实践。在主题行中使用"教育项目"联系我们，了解即将到来的机会。",
      "view-all-faqs": "查看所有常见问题",
      // Accessibility
      "accessibility-tools": "无障碍工具：",
      "language": "语言："
    }
  };

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
    
    // Theme switcher functionality
    const themeSelector = document.getElementById('theme-selector');
    
    // Function to detect system theme preference
    function getSystemTheme() {
      return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
    
    // Function to set theme
    function setTheme(theme) {
      if (theme === 'system') {
        const systemTheme = getSystemTheme();
        document.documentElement.classList.toggle('dark', systemTheme === 'dark');
      } else {
        document.documentElement.classList.toggle('dark', theme === 'dark');
      }
    }
    
    // Set initial theme based on user preference or default to system
    let currentTheme = localStorage.getItem('preferredTheme') || 'system';
    themeSelector.value = currentTheme;
    
    // Apply the theme on page load
    setTheme(currentTheme);
    
    // Listen for system theme changes if using system theme
    if (currentTheme === 'system') {
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (themeSelector.value === 'system') {
          setTheme('system');
        }
      });
    }
    
    // Handle theme change
    themeSelector.addEventListener('change', function() {
      currentTheme = this.value;
      
      // Save preferred theme to localStorage
      localStorage.setItem('preferredTheme', currentTheme);
      
      // Apply theme
      setTheme(currentTheme);
    });
    
    // Language switcher functionality
    const languageSelector = document.getElementById('language-selector');
    
    // Set initial language based on browser preference or default to English
    let currentLang = localStorage.getItem('preferredLanguage') || 
                      navigator.language.substring(0, 2) || 
                      'en';
    
    // Make sure the language is supported, default to English if not
    if (!translations[currentLang]) {
      currentLang = 'en';
    }
    
    // Set the language selector to the current language
    languageSelector.value = currentLang;
    
    // Apply translations on page load
    applyTranslations(currentLang);
    
    // Set HTML lang attribute for accessibility
    document.documentElement.lang = currentLang;
    
    // Handle language change
    languageSelector.addEventListener('change', function() {
      currentLang = this.value;
      
      // Save preferred language to localStorage
      localStorage.setItem('preferredLanguage', currentLang);
      
      // Apply translations
      applyTranslations(currentLang);
      
      // Update HTML lang attribute
      document.documentElement.lang = currentLang;
    });
    
    // Function to apply translations
    function applyTranslations(lang) {
      const elements = document.querySelectorAll('[data-lang-key]');
      
      elements.forEach(element => {
        const key = element.getAttribute('data-lang-key');
        if (translations[lang] && translations[lang][key]) {
          element.textContent = translations[lang][key];
        }
      });
      
      // Update form placeholders
      updateFormPlaceholders(lang);
      
      // Update page title and subtitle
      updatePageTitleAndSubtitle(lang);
      
      // Update sidebar content
      updateSidebarContent(lang);
      
      // Update form section content
      updateFormContent(lang);
      
      // Update FAQ content
      updateFaqContent(lang);
    }
    
    // Function to update form placeholders and labels
    function updateFormPlaceholders(lang) {
      // Update input placeholders
      document.getElementById('first-name').placeholder = translations[lang]['first-name-placeholder'];
      document.getElementById('last-name').placeholder = translations[lang]['last-name-placeholder'];
      document.getElementById('email').placeholder = translations[lang]['email-placeholder'];
      document.getElementById('phone').placeholder = translations[lang]['phone-placeholder'];
      document.getElementById('message').placeholder = translations[lang]['message-placeholder'];
      document.getElementById('captcha').placeholder = translations[lang]['captcha'];
      
      // Update form labels
      document.querySelector('label[for="first-name"]').textContent = translations[lang]['first-name'];
      document.querySelector('label[for="last-name"]').textContent = translations[lang]['last-name'];
      document.querySelector('label[for="email"]').textContent = translations[lang]['email'];
      document.querySelector('label[for="phone"]').textContent = translations[lang]['phone'];
      document.querySelector('label[for="subject"]').textContent = translations[lang]['subject'];
      document.querySelector('label[for="message"]').textContent = translations[lang]['message'];
      document.querySelector('label[for="attachment"]').textContent = translations[lang]['attachment'];
      
      // Update error messages
      document.getElementById('first-name-error').textContent = translations[lang]['first-name-error'];
      document.getElementById('last-name-error').textContent = translations[lang]['last-name-error'];
      document.getElementById('email-error').textContent = translations[lang]['email-error'];
      document.getElementById('subject-error').textContent = translations[lang]['subject-error'];
      document.getElementById('message-error').textContent = translations[lang]['message-error'];
      document.getElementById('captcha-error').textContent = translations[lang]['captcha-error'];
      document.getElementById('terms-error').textContent = translations[lang]['terms-error'];
      
      // Update subject dropdown options
      const subjectSelect = document.getElementById('subject');
      subjectSelect.options[0].text = translations[lang]['subject-placeholder'];
      subjectSelect.options[1].text = translations[lang]['subject-support'];
      subjectSelect.options[2].text = translations[lang]['subject-feedback'];
      subjectSelect.options[3].text = translations[lang]['subject-partnership'];
      subjectSelect.options[4].text = translations[lang]['subject-business'];
      subjectSelect.options[5].text = translations[lang]['subject-other'];
      
      // Update terms text
      const termsLabel = document.querySelector('label[for="terms"]');
      termsLabel.innerHTML = `${translations[lang]['terms-agree']} <a href="#" class="text-primary hover:underline">${translations[lang]['terms-service']}</a> ${translations[lang]['terms-and']} <a href="#" class="text-primary hover:underline">${translations[lang]['terms-privacy']}</a>`;
      
      // Update submit button
      document.querySelector('button[type="submit"] span').textContent = translations[lang]['send-button'];
      
      // Update form status messages
      document.querySelector('#form-success span').textContent = translations[lang]['form-success'];
      document.querySelector('#form-error span').textContent = translations[lang]['form-error'];
      
      // Update file upload text
      const uploadText = document.querySelector('.text-sm.text-gray-500 .font-medium');
      uploadText.textContent = translations[lang]['attachment-upload'];
      uploadText.nextSibling.textContent = ` ${translations[lang]['attachment-drop']}`;
      document.querySelector('.text-xs.text-gray-500').textContent = translations[lang]['attachment-types'];
      document.getElementById('remove-file').textContent = translations[lang]['attachment-remove'];
    }
    
    // Function to update page title and subtitle
    function updatePageTitleAndSubtitle(lang) {
      // Update main title and subtitle
      const mainTitle = document.querySelector('.bg-primary.text-white.py-16 h1');
      const subtitle = document.querySelector('.bg-primary.text-white.py-16 p');
      
      mainTitle.textContent = translations[lang]['contact-us'];
      subtitle.textContent = translations[lang]['contact-subtitle'];
    }
    
    // Function to update sidebar content
    function updateSidebarContent(lang) {
      // Update sidebar headings and content
      document.querySelector('.lg\\:col-span-2 h2').textContent = translations[lang]['get-in-touch'];
      document.querySelector('.lg\\:col-span-2 > p').textContent = translations[lang]['contact-intro'];
      
      // Call & Email sections
      const sections = document.querySelectorAll('.lg\\:col-span-2 .flex.items-start');
      sections[0].querySelector('h3').textContent = translations[lang]['call-us'];
      sections[0].querySelector('p.text-sm').textContent = translations[lang]['call-hours'];
      
      sections[1].querySelector('h3').textContent = translations[lang]['email-us'];
      const emailParagraphs = sections[1].querySelectorAll('p.text-sm');
      emailParagraphs[0].textContent = translations[lang]['general-inquiries'];
      emailParagraphs[1].textContent = translations[lang]['conservation-inquiries'];
      
      // Address section
      sections[2].querySelector('h3').textContent = translations[lang]['visit-us'];
      sections[2].querySelector('a span').textContent = translations[lang]['get-directions'];
      
      // Social Media section
      document.querySelector('.lg\\:col-span-2 > div:last-child h3').textContent = translations[lang]['connect-with-us'];
    }
    
    // Function to update form section content
    function updateFormContent(lang) {
      // Update form heading
      document.querySelector('.lg\\:col-span-3 h2').textContent = translations[lang]['send-message'];
    }
    
    // Function to update FAQ content
    function updateFaqContent(lang) {
      // Update FAQ heading and subtitle
      document.querySelector('.py-16.bg-gray-50 h2').textContent = translations[lang]['faq-title'];
      document.querySelector('.py-16.bg-gray-50 p.text-center').textContent = translations[lang]['faq-subtitle'];
      
      // Update FAQ questions and answers
      const faqToggles = document.querySelectorAll('.faq-toggle');
      const faqContents = document.querySelectorAll('.faq-content');
      
      faqToggles[0].querySelector('span').textContent = translations[lang]['faq-question-1'];
      faqContents[0].querySelector('p').textContent = translations[lang]['faq-answer-1'];
      
      faqToggles[1].querySelector('span').textContent = translations[lang]['faq-question-2'];
      faqContents[1].querySelector('p').textContent = translations[lang]['faq-answer-2'];
      
      faqToggles[2].querySelector('span').textContent = translations[lang]['faq-question-3'];
      faqContents[2].querySelector('p').textContent = translations[lang]['faq-answer-3'];
      
      faqToggles[3].querySelector('span').textContent = translations[lang]['faq-question-4'];
      faqContents[3].querySelector('p').textContent = translations[lang]['faq-answer-4'];
      
      // Update "View all FAQs" link
      document.querySelector('.py-16.bg-gray-50 .text-center.mt-10 a span').textContent = translations[lang]['view-all-faqs'];
      
      // Update Map section heading
      document.querySelector('.py-16 h2').textContent = translations[lang]['visit-office'];
    }
  });
</script>

<!-- High Contrast Mode Styles -->
<style>
  /* High Contrast Mode Styles */
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
  
  /* Dark Mode Styles */
  .dark {
    color-scheme: dark;
  }

  .dark body {
    background-color: #121212;
    color: #f3f4f6;
  }
  
  .dark .bg-white {
    background-color: #1f2937 !important;
  }
  
  .dark .bg-gray-50 {
    background-color: #111827 !important;
  }
  
  .dark .bg-gray-100 {
    background-color: #1f2937 !important;
  }
  
  .dark .text-gray-600,
  .dark .text-gray-700,
  .dark .text-gray-800 {
    color: #e5e7eb !important;
  }
  
  .dark .text-dark {
    color: #f3f4f6 !important;
  }
  
  .dark .border-gray-200,
  .dark .border-gray-300 {
    border-color: #374151 !important;
  }
  
  .dark .bg-green-100 {
    background-color: rgba(52, 211, 153, 0.2) !important;
  }
  
  .dark .text-green-800 {
    color: #a7f3d0 !important;
  }
  
  .dark .border-green-200 {
    border-color: #34d399 !important;
  }
  
  .dark .bg-red-100 {
    background-color: rgba(248, 113, 113, 0.2) !important;
  }
  
  .dark .text-red-800 {
    color: #fca5a5 !important;
  }
  
  .dark .border-red-200 {
    border-color: #f87171 !important;
  }
  
  .dark .shadow-md,
  .dark .shadow-lg {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
  }
  
  .dark .bg-light {
    background-color: #1f2937 !important;
  }
  
  .dark .bg-primary {
    background-color: #213a28 !important;
  }
  
  /* Adjust form elements for dark mode */
  .dark input,
  .dark select,
  .dark textarea {
    background-color: #374151;
    color: #f3f4f6;
    border-color: #4b5563;
  }
  
  .dark input::placeholder,
  .dark textarea::placeholder {
    color: #9ca3af;
  }
  
  .dark .placeholder-gray-300::placeholder {
    color: #6b7280;
  }
  
  /* Dark mode focus styles */
  .dark .focus\:ring-primary:focus {
    --tw-ring-color: rgba(45, 90, 62, 0.6);
  }
  
  .dark .focus\:border-transparent:focus {
    border-color: transparent;
  }
</style>

<?php include ROOT_PATH . '/resources/views/layouts/footer.php'; ?>