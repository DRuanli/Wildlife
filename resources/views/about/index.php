<?php
// Path: resources/views/about/index.php
$baseUrl = '/Wildlife';
?>

<?php include ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Advanced WebGL Hero Section -->
<section class="relative min-h-screen bg-primary text-white overflow-hidden">
  <canvas id="hero-canvas" class="absolute inset-0 w-full h-full"></canvas>
  
  <div class="container mx-auto px-4 py-20 md:py-28 lg:py-36 relative z-10 flex items-center min-h-[calc(100vh-100px)]">
    <div class="max-w-3xl mx-auto text-center">
      <h1 class="text-4xl md:text-6xl lg:text-7xl font-display font-bold mb-6 opacity-0 transform -translate-y-8 transition-all duration-1000 ease-out hero-animate" id="hero-title">Our Story</h1>
      <p class="text-xl md:text-2xl mb-8 opacity-0 transform -translate-y-8 transition-all duration-1000 delay-300 ease-out hero-animate" id="hero-text">
        Combining technology and wildlife conservation to create a world where focus and mindfulness benefit both humans and the natural world.
      </p>
      <div class="flex flex-col sm:flex-row justify-center gap-4 opacity-0 transform -translate-y-8 duration-1000 delay-500 ease-out hero-animate">
        <a href="#our-mission" class="btn-primary group">
          <span>Discover Our Mission</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
          </svg>
        </a>
        <a href="#our-impact" class="btn-secondary">
          <span>See Our Impact</span>
        </a>
      </div>
    </div>
  </div>
  
  <!-- Advanced wave divider with SVG animation -->
  <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
    <svg class="relative block w-full h-[120px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
      <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="fill-light"></path>
      <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="fill-light"></path>
      <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="fill-light"></path>
    </svg>
  </div>
</section>

<!-- Interactive Mission Section -->
<section id="our-mission" class="py-20 md:py-32 bg-light">
  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row items-center gap-12">
      <div class="lg:w-1/2 order-2 lg:order-1">
        <!-- WebGL Interactive Canvas -->
        <div class="webgl-parallax-container h-96 md:h-[450px] rounded-lg shadow-2xl relative overflow-hidden group" data-rotation="0.05">
          <canvas id="mission-webgl" class="w-full h-full rounded-lg"></canvas>
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="p-6 text-white">
              <h3 class="text-xl font-bold">Connecting People & Nature</h3>
              <p class="text-sm">Through digital innovation</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="lg:w-1/2 order-1 lg:order-2">
        <div data-aos="fade-left">
          <div class="inline-flex items-center bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium mb-6">
            <span class="flex h-2 w-2 rounded-full bg-primary mr-2"></span>
            Our Purpose
          </div>
          <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-6 text-primary">Our Mission</h2>
          <p class="text-lg mb-6 text-gray-700">
            At Wildlife Haven, we've created a unique digital ecosystem where personal productivity and wildlife conservation unite. Our mission is to harness the power of technology to create meaningful connections between human focus and global conservation efforts.
          </p>
          <p class="text-lg mb-8 text-gray-700">
            Through our innovative focus timer and virtual wildlife sanctuary, we're transforming daily productivity sessions into tangible support for endangered species protection, habitat restoration, and conservation education worldwide.
          </p>
          
          <!-- Interactive Stats Counter -->
          <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-counter-container">
              <div class="text-3xl font-bold text-primary">$<span class="stat-counter" data-target="2350000">0</span></div>
              <p class="text-gray-600">Conservation Funding</p>
            </div>
            <div class="stat-counter-container">
              <div class="text-3xl font-bold text-primary"><span class="stat-counter" data-target="1245000">0</span></div>
              <p class="text-gray-600">Active Users</p>
            </div>
            <div class="stat-counter-container">
              <div class="text-3xl font-bold text-primary"><span class="stat-counter" data-target="42">0</span></div>
              <p class="text-gray-600">Protected Habitats</p>
            </div>
          </div>
          
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="#our-values" class="btn-primary">
              Our Values
            </a>
            <a href="#our-impact" class="btn-outline">
              See Our Impact
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Immersive Timeline Section -->
<section id="our-history" class="py-20 md:py-32 relative bg-gray-50 overflow-hidden">
  <!-- Decorative Background Elements -->
  <div class="absolute inset-0 pointer-events-none">
    <div class="absolute top-0 left-0 w-64 h-64 bg-primary/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary/5 rounded-full translate-x-1/2 translate-y-1/2"></div>
    <div class="absolute top-1/4 right-10 w-20 h-20 bg-secondary/10 rounded-full"></div>
  </div>

  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-16" data-aos="fade-up">
      <div class="inline-flex items-center bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium mb-6">
        <span class="flex h-2 w-2 rounded-full bg-primary mr-2"></span>
        Our Evolution
      </div>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-6 text-primary">Our Journey</h2>
      <p class="text-lg max-w-3xl mx-auto text-gray-700">
        From a simple idea to a global movement, explore how Wildlife Haven evolved over the years to create a meaningful impact.
      </p>
    </div>
    
    <!-- 3D WebGL Timeline -->
    <div id="webgl-timeline-container" class="w-full h-[600px] md:h-[700px] mb-12">
      <canvas id="timeline-webgl" class="w-full h-full"></canvas>
      
      <!-- Timeline Overlay UI -->
      <div class="absolute bottom-6 left-0 right-0 flex justify-center">
        <div class="timeline-years flex bg-white/90 backdrop-blur-sm rounded-full shadow-lg p-2">
          <button class="timeline-year-btn px-4 py-2 rounded-full text-gray-500 hover:text-primary transition-colors" data-year="2020">2020</button>
          <button class="timeline-year-btn px-4 py-2 rounded-full text-gray-500 hover:text-primary transition-colors" data-year="2021">2021</button>
          <button class="timeline-year-btn px-4 py-2 rounded-full text-gray-500 hover:text-primary transition-colors" data-year="2022">2022</button>
          <button class="timeline-year-btn px-4 py-2 rounded-full text-gray-500 hover:text-primary transition-colors" data-year="2023">2023</button>
          <button class="timeline-year-btn px-4 py-2 rounded-full text-gray-500 hover:text-primary transition-colors" data-year="2024">2024</button>
          <button class="timeline-year-btn px-4 py-2 rounded-full text-gray-500 hover:text-primary transition-colors" data-year="2025">2025</button>
        </div>
      </div>
      
      <!-- Timeline Info Panel (initially hidden) -->
      <div id="timeline-info" class="absolute top-8 left-8 max-w-md bg-white/95 backdrop-blur-md rounded-xl shadow-xl p-6 opacity-0 transform -translate-y-4 transition-all duration-300">
        <h3 id="timeline-year" class="text-2xl font-bold mb-3 text-primary">2025</h3>
        <h4 id="timeline-title" class="text-xl font-bold mb-3">Today & Beyond</h4>
        <p id="timeline-description" class="text-gray-700 mb-4">Implementing advanced ML-driven focus engine and expanding our virtual biodiversity. Join us as we continue to grow our impact together.</p>
        <img id="timeline-image" src="" alt="Timeline event" class="w-full h-48 object-cover rounded-lg mb-4">
      </div>
    </div>
  </div>
</section>

<!-- 3D Values Section -->
<section id="our-values" class="py-20 md:py-32 bg-light">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16" data-aos="fade-up">
      <div class="inline-flex items-center bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium mb-6">
        <span class="flex h-2 w-2 rounded-full bg-primary mr-2"></span>
        What We Stand For
      </div>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-6 text-primary">Our Core Values</h2>
      <p class="text-lg max-w-3xl mx-auto text-gray-700">
        These principles guide everything we do at Wildlife Haven, from product development to conservation partnerships.
      </p>
    </div>
    
    <!-- 3D WebGL Values Display -->
    <div id="values-webgl-container" class="h-[600px] mb-16 relative">
      <canvas id="values-webgl" class="w-full h-full"></canvas>
      
      <!-- Interactive Controls -->
      <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-4">
        <button id="values-prev" class="btn-circle">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <div id="values-indicators" class="flex items-center space-x-2">
          <!-- Indicators added dynamically by JS -->
        </div>
        <button id="values-next" class="btn-circle">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
      
      <!-- Values Info Overlay -->
      <div id="value-info" class="absolute top-1/2 left-8 md:left-16 max-w-md transform -translate-y-1/2">
        <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-xl p-6 md:p-8">
          <div class="value-icon mb-6 flex justify-center">
            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center">
              <i class="fas fa-globe-americas text-primary text-2xl"></i>
            </div>
          </div>
          <h3 id="value-title" class="text-2xl font-bold mb-4 text-center">Conservation First</h3>
          <p id="value-description" class="text-gray-700">We believe in measurable, transparent conservation impact. Every design and business decision is evaluated by its potential to benefit wildlife.</p>
          
          <div class="mt-6 pt-6 border-t border-gray-200">
            <div id="value-stats" class="space-y-3 text-sm">
              <div class="flex items-center">
                <i class="fas fa-check-circle text-primary mr-2"></i>
                <span>$2.3M contributed to conservation</span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-check-circle text-primary mr-2"></i>
                <span>42 protected habitats worldwide</span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-check-circle text-primary mr-2"></i>
                <span>15 endangered species supported</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Interactive Team Gallery Section -->
<section id="our-team" class="py-20 md:py-32 bg-gray-50 relative overflow-hidden">
  <!-- Decorative patterns -->
  <div class="absolute inset-0 opacity-10 pointer-events-none">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <pattern id="dots-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
        <circle cx="10" cy="10" r="2" fill="#1a365d"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#dots-pattern)"/>
    </svg>
  </div>

  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-16" data-aos="fade-up">
      <div class="inline-flex items-center bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium mb-6">
        <span class="flex h-2 w-2 rounded-full bg-primary mr-2"></span>
        The People Behind Our Mission
      </div>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-6 text-primary">Meet Our Team</h2>
      <p class="text-lg max-w-3xl mx-auto text-gray-700">
        Wildlife Haven brings together experts in technology, conservation, and productivity to create innovative solutions for a better world.
      </p>
    </div>
    
    <!-- 3D WebGL Team Gallery -->
    <div id="team-webgl-container" class="h-[600px] md:h-[700px] mb-16 relative">
      <canvas id="team-webgl" class="w-full h-full"></canvas>
      
      <!-- Team member info overlay -->
      <div id="team-info" class="absolute bottom-8 left-8 md:left-16 max-w-md bg-white/95 backdrop-blur-md rounded-xl shadow-xl p-6 transition-opacity duration-300 opacity-0">
        <h3 id="team-name" class="text-2xl font-bold mb-1">Dr. Emma Chen</h3>
        <p id="team-title" class="text-gray-600 mb-4">Founder & CEO</p>
        <p id="team-bio" class="text-gray-700 mb-4">Former wildlife biologist with 15 years of conservation experience in Southeast Asia. Leads Wildlife Haven's vision and conservation strategy.</p>
        <p id="team-quote" class="text-gray-700 italic mb-4">"Technology can be the bridge reconnecting humans with nature in our digital age."</p>
        <div class="flex space-x-3">
          <a href="#" class="h-10 w-10 bg-primary/10 text-primary rounded-full flex items-center justify-center hover:bg-primary/20 transition-colors">
            <i class="fab fa-linkedin-in"></i>
          </a>
          <a href="#" class="h-10 w-10 bg-primary/10 text-primary rounded-full flex items-center justify-center hover:bg-primary/20 transition-colors">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="h-10 w-10 bg-primary/10 text-primary rounded-full flex items-center justify-center hover:bg-primary/20 transition-colors">
            <i class="fas fa-envelope"></i>
          </a>
        </div>
      </div>
      
      <!-- Team navigation -->
      <div class="absolute bottom-8 right-8 flex gap-4">
        <button id="team-prev" class="btn-circle">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button id="team-next" class="btn-circle">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
    </div>
    
    <!-- Join Our Team CTA -->
    <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center max-w-3xl mx-auto" data-aos="fade-up">
      <h3 class="text-2xl md:text-3xl font-bold mb-6">Join Our Team</h3>
      <p class="text-lg max-w-2xl mx-auto mb-8">
        We're always looking for passionate individuals who want to make a difference through technology and conservation.
      </p>
      <a href="#" class="btn-primary inline-flex items-center">
        <i class="fas fa-briefcase mr-2"></i> View Open Positions
      </a>
    </div>
  </div>
</section>

<!-- Interactive Impact Section -->
<section id="our-impact" class="relative py-20 md:py-32 bg-primary text-white overflow-hidden">
  <!-- WebGL Particle Background -->
  <canvas id="impact-webgl-background" class="absolute inset-0 w-full h-full"></canvas>
  
  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-16" data-aos="fade-up">
      <div class="inline-flex items-center bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium mb-6">
        <span class="flex h-2 w-2 rounded-full bg-white mr-2"></span>
        Real World Change
      </div>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-6">Our Impact</h2>
      <p class="text-xl max-w-3xl mx-auto">
        Every minute of focus contributes to real conservation impact around the world. Here's what we've accomplished together.
      </p>
    </div>
    
    <!-- Interactive 3D Globe Visualization -->
    <div id="impact-globe-container" class="h-[600px] mb-16">
      <canvas id="impact-globe" class="w-full h-full"></canvas>
      
      <!-- Impact Stats Overlay -->
      <div class="absolute top-1/2 right-8 md:right-16 max-w-md transform -translate-y-1/2">
        <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 md:p-8 text-white">
          <div class="grid grid-cols-2 gap-6">
            <div class="text-center">
              <div class="text-3xl md:text-4xl font-bold mb-2 impact-counter" data-target="1245000">0</div>
              <p class="text-sm md:text-base">Active Users</p>
            </div>
            <div class="text-center">
              <div class="text-3xl md:text-4xl font-bold mb-2"><span class="impact-counter" data-target="73">0</span>M</div>
              <p class="text-sm md:text-base">Focus Hours</p>
            </div>
            <div class="text-center">
              <div class="text-3xl md:text-4xl font-bold mb-2">$<span class="impact-counter" data-target="2350000">0</span></div>
              <p class="text-sm md:text-base">Conservation Funding</p>
            </div>
            <div class="text-center">
              <div class="text-3xl md:text-4xl font-bold mb-2"><span class="impact-counter" data-target="42">0</span></div>
              <p class="text-sm md:text-base">Protected Habitats</p>
            </div>
          </div>
          
          <div class="mt-8">
            <h3 class="text-xl font-bold mb-4">Where Your Focus Goes</h3>
            <div class="space-y-3">
              <div class="flex items-center">
                <div class="w-16 h-1 bg-secondary mr-3"></div>
                <div class="text-sm">35% - Habitat Protection</div>
              </div>
              <div class="flex items-center">
                <div class="w-12 h-1 bg-secondary mr-3"></div>
                <div class="text-sm">25% - Species Conservation</div>
              </div>
              <div class="flex items-center">
                <div class="w-10 h-1 bg-secondary mr-3"></div>
                <div class="text-sm">20% - Conservation Education</div>
              </div>
              <div class="flex items-center">
                <div class="w-7 h-1 bg-secondary mr-3"></div>
                <div class="text-sm">15% - Community Engagement</div>
              </div>
              <div class="flex items-center">
                <div class="w-3 h-1 bg-secondary mr-3"></div>
                <div class="text-sm">5% - Research & Innovation</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Wave divider -->
  <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none transform rotate-180">
    <svg class="relative block w-full h-[120px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
      <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="fill-gray-50"></path>
    </svg>
  </div>
</section>

<!-- Testimonials Section with 3D Carousel -->
<section class="py-20 md:py-32 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16" data-aos="fade-up">
      <div class="inline-flex items-center bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium mb-6">
        <span class="flex h-2 w-2 rounded-full bg-primary mr-2"></span>
        Community Voices
      </div>
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-6 text-primary">What People Say</h2>
      <p class="text-lg max-w-3xl mx-auto text-gray-700">
        Hear from our community of users, partners, and conservation experts about their Wildlife Haven experience.
      </p>
    </div>
    
    <!-- 3D WebGL Testimonials Carousel -->
    <div id="testimonials-webgl-container" class="h-[500px] md:h-[600px] mb-8 relative">
      <canvas id="testimonials-webgl" class="w-full h-full"></canvas>
      
      <!-- Testimonial Content Overlay -->
      <div id="testimonial-content" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 max-w-2xl w-full px-4">
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl p-8">
          <div class="flex items-center mb-6">
            <div class="text-5xl text-secondary opacity-50 mr-4">"</div>
            <div class="h-px flex-grow bg-gray-200"></div>
          </div>
          
          <div id="testimonial-text" class="text-lg md:text-xl text-gray-700 mb-8">
            Wildlife Haven transformed my productivity habits completely. Instead of dreading long focus sessions, I now look forward to helping my virtual creatures grow. The best part is knowing my focus time contributes to real conservation efforts. I've improved my work efficiency while supporting causes I care about!
          </div>
          
          <div class="flex items-center">
            <img id="testimonial-image" src="<?= $baseUrl ?>/assets/images/about/testimonial-1.jpg" alt="Testimonial" class="w-14 h-14 rounded-full object-cover mr-4">
            <div>
              <h4 id="testimonial-name" class="font-bold">Jessica Taylor</h4>
              <p id="testimonial-title" class="text-gray-600">Freelance Designer, Wildlife Haven user for 2 years</p>
            </div>
            <div class="ml-auto flex">
              <i class="fas fa-star text-yellow-400"></i>
              <i class="fas fa-star text-yellow-400"></i>
              <i class="fas fa-star text-yellow-400"></i>
              <i class="fas fa-star text-yellow-400"></i>
              <i class="fas fa-star text-yellow-400"></i>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Testimonial navigation -->
      <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-4">
        <button id="testimonial-prev" class="btn-circle">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <div id="testimonial-indicators" class="flex items-center space-x-2">
          <!-- Indicators added dynamically by JS -->
        </div>
        <button id="testimonial-next" class="btn-circle">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Modern Contact Section with Mapbox Globe -->
<section id="contact" class="py-20 md:py-32 bg-light">
  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row items-center gap-12">
      <div class="lg:w-1/2 order-2 lg:order-1">
        <div data-aos="fade-right">
          <div class="inline-flex items-center bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium mb-6">
            <span class="flex h-2 w-2 rounded-full bg-primary mr-2"></span>
            Connect With Us
          </div>
          <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-6 text-primary">Get in Touch</h2>
          <p class="text-lg mb-8 text-gray-700">
            Have questions about Wildlife Haven or want to explore partnership opportunities? Our team is ready to help.
          </p>
          
          <div class="space-y-6 mb-8">
            <div class="flex items-start">
              <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mr-4 shrink-0">
                <i class="fas fa-map-marker-alt text-primary"></i>
              </div>
              <div>
                <h4 class="font-bold mb-1">Our Headquarters</h4>
                <p class="text-gray-700">123 Conservation Way<br>San Francisco, CA 94110</p>
              </div>
            </div>
            
            <div class="flex items-start">
              <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mr-4 shrink-0">
                <i class="fas fa-envelope text-primary"></i>
              </div>
              <div>
                <h4 class="font-bold mb-1">Email Us</h4>
                <p class="text-gray-700">
                  <a href="mailto:info@wildlifehaven.com" class="hover:text-primary transition-colors">info@wildlifehaven.com</a><br>
                  <a href="mailto:partnerships@wildlifehaven.com" class="hover:text-primary transition-colors">partnerships@wildlifehaven.com</a>
                </p>
              </div>
            </div>
            
            <div class="flex items-start">
              <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mr-4 shrink-0">
                <i class="fas fa-phone-alt text-primary"></i>
              </div>
              <div>
                <h4 class="font-bold mb-1">Call Us</h4>
                <p class="text-gray-700">
                  +1 (415) 555-0123<br>
                  Mon-Fri, 9am-5pm PST
                </p>
              </div>
            </div>
          </div>
          
          <div class="flex space-x-4">
            <a href="#" class="social-btn">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-btn">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-btn">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="social-btn">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>
      </div>
      
      <div class="lg:w-1/2 w-full order-1 lg:order-2">
        <div class="bg-white rounded-2xl shadow-xl p-8 transform transition-all hover:shadow-2xl" data-aos="fade-left">
          <h3 class="text-2xl font-bold mb-6">Send Us a Message</h3>
          
          <form id="contact-form" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="form-group">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" id="name" name="name" class="form-input" placeholder="Enter your name" required>
              </div>
              <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" required>
              </div>
            </div>
            
            <div class="form-group">
              <label for="subject" class="form-label">Subject</label>
              <input type="text" id="subject" name="subject" class="form-input" placeholder="What is this regarding?">
            </div>
            
            <div class="form-group">
              <label for="message" class="form-label">Message</label>
              <textarea id="message" name="message" rows="4" class="form-input" placeholder="How can we help you?" required></textarea>
            </div>
            
            <div class="flex items-start">
              <input type="checkbox" id="consent" name="consent" class="mt-1 mr-2" required>
              <label for="consent" class="text-gray-700 text-sm">
                I consent to Wildlife Haven collecting and storing the information I have provided to respond to my inquiry. View our <a href="#" class="text-primary hover:underline">Privacy Policy</a>.
              </label>
            </div>
            
            <button type="submit" class="btn-primary w-full">
              <i class="fas fa-paper-plane mr-2"></i> Send Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section with WebGL Background -->
<section class="py-16 md:py-20 bg-primary text-white relative overflow-hidden">
  <!-- WebGL Animated Background -->
  <canvas id="cta-webgl-background" class="absolute inset-0 w-full h-full"></canvas>
  
  <div class="container mx-auto px-4 relative z-10 text-center">
    <div data-aos="fade-up">
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-6">Join Our Mission Today</h2>
      <p class="text-xl mb-8 max-w-3xl mx-auto">
        Transform your productivity while making a real difference for wildlife conservation. Download Wildlife Haven and start your journey.
      </p>
      
      <div class="flex flex-wrap justify-center gap-4">
        <a href="#" class="app-store-btn">
          <i class="fab fa-apple text-2xl mr-3"></i> 
          <div class="text-left">
            <div class="text-xs">Download on the</div>
            <div class="text-lg">App Store</div>
          </div>
        </a>
        <a href="#" class="app-store-btn">
          <i class="fab fa-google-play text-2xl mr-3"></i>
          <div class="text-left">
            <div class="text-xs">Get it on</div>
            <div class="text-lg">Google Play</div>
          </div>
        </a>
        <a href="#" class="app-store-btn bg-secondary text-primary hover:bg-secondary/90">
          <i class="fas fa-laptop text-2xl mr-3"></i>
          <div class="text-lg">Use Web App</div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Modern CSS Styles -->
<style>
:root {
  --primary: #1a365d;
  --primary-light: rgba(26, 54, 93, 0.1);
  --secondary: #fcd34d;
  --light: #F9F8F2;
  --dark: #111827;
}

/* General Reusable Classes */
.btn-primary {
  @apply inline-flex items-center bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition-all;
}

.btn-secondary {
  @apply inline-flex items-center bg-secondary text-primary px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition-all;
}

.btn-outline {
  @apply inline-flex items-center bg-white border border-primary text-primary px-6 py-3 rounded-lg font-medium hover:bg-gray-50 transition-all;
}

.btn-circle {
  @apply h-12 w-12 bg-white text-primary rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-md;
}

.social-btn {
  @apply w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white hover:bg-opacity-90 transition-all;
}

.app-store-btn {
  @apply flex items-center bg-white text-primary px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition shadow-md;
}

.form-group {
  @apply flex flex-col;
}

.form-label {
  @apply block text-gray-700 mb-2 font-medium;
}

.form-input {
  @apply w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all;
}

/* Webgl Container Styles */
.webgl-parallax-container {
  perspective: 1000px;
}

/* 3D Card Effect Styles */
.perspective {
  perspective: 1000px;
}

.preserve-3d {
  transform-style: preserve-3d;
}

.backface-hidden {
  backface-visibility: hidden;
}

.rotate-y-180 {
  transform: rotateY(180deg);
}

/* Stats counter */
.stat-counter-container {
  @apply bg-white p-4 rounded-lg shadow-md text-center;
}

/* Animations */
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

.float-animation {
  animation: float 5s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.7; }
}

.pulse-animation {
  animation: pulse 3s ease-in-out infinite;
}

/* Responsive Adjustments */
@media (max-width: 640px) {
  .app-store-btn {
    @apply w-full;
  }
}
</style>

<!-- WebGL and JS dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r132/three.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three-globe@2.24.10/dist/three-globe.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tween.js/18.6.4/tween.umd.min.js"></script>

<!-- Core JS functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize AOS
  AOS.init({
    duration: 800,
    once: true,
    offset: 100
  });
  
  // Hero section animation
  animateHeroElements();
  
  // Initialize WebGL scenes when visible in viewport
  initVisibilityObserver();
  
  // Smooth scrolling for navigation links
  initSmoothScroll();
  
  // Initialize stat counters
  initStatCounters();
  
  // Handle contact form submission
  initContactForm();
});

// Hero Animation
function animateHeroElements() {
  const heroElements = document.querySelectorAll('.hero-animate');
  
  setTimeout(() => {
    heroElements.forEach(el => {
      el.classList.remove('opacity-0', '-translate-y-8');
      el.classList.add('opacity-100', 'translate-y-0');
    });
  }, 500);
}

// Intersection Observer for initializing WebGL scenes when in viewport
function initVisibilityObserver() {
  const webglContainers = [
    { id: 'hero-canvas', init: initHeroScene },
    { id: 'mission-webgl', init: initMissionScene },
    { id: 'timeline-webgl', init: initTimelineScene },
    { id: 'values-webgl', init: initValuesScene },
    { id: 'team-webgl', init: initTeamScene },
    { id: 'impact-globe', init: initImpactGlobe },
    { id: 'testimonials-webgl', init: initTestimonialsScene },
    { id: 'cta-webgl-background', init: initCtaBackground }
  ];
  
  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
  };
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const container = webglContainers.find(c => c.id === entry.target.id);
        if (container) {
          container.init(entry.target);
          observer.unobserve(entry.target);
        }
      }
    });
  }, observerOptions);
  
  webglContainers.forEach(container => {
    const element = document.getElementById(container.id);
    if (element) {
      observer.observe(element);
    }
  });
}

// Smooth scrolling for anchor links
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      
      const targetId = this.getAttribute('href');
      const targetElement = document.querySelector(targetId);
      
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - 100,
          behavior: 'smooth'
        });
      }
    });
  });
}

// Initialize stat counters with IntersectionObserver
function initStatCounters() {
  const statCounters = document.querySelectorAll('.stat-counter, .impact-counter');
  
  function animateCounter(counter, target, duration = 2000) {
    let startTime = null;
    const startValue = parseInt(counter.textContent);
    
    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      
      // Easing function for smoother animation
      const easeOutQuad = progress * (2 - progress);
      
      const currentValue = Math.floor(startValue + (target - startValue) * easeOutQuad);
      counter.textContent = currentValue.toLocaleString();
      
      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        counter.textContent = target.toLocaleString();
      }
    }
    
    window.requestAnimationFrame(step);
  }
  
  // Intersection Observer for triggering counter animations
  const observerOptions = {
    threshold: 0.25
  };
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const counter = entry.target;
        const target = parseInt(counter.dataset.target);
        animateCounter(counter, target);
        observer.unobserve(counter);
      }
    });
  }, observerOptions);
  
  statCounters.forEach(counter => {
    observer.observe(counter);
  });
}

// Handle contact form submission
function initContactForm() {
  const contactForm = document.getElementById('contact-form');
  
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // In a real implementation, you would send the form data to your server here
      // For demo purposes, we'll just show a success message
      
      const formData = new FormData(contactForm);
      let formValues = {};
      
      for (let [key, value] of formData.entries()) {
        formValues[key] = value;
      }
      
      console.log('Form data:', formValues);
      
      // Reset form and show success message
      contactForm.reset();
      
      // Create success message
      const successMessage = document.createElement('div');
      successMessage.className = 'p-4 mb-4 bg-green-100 text-green-800 rounded-md flex items-center';
      successMessage.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Thank you for your message! We\'ll get back to you soon.';
      
      // Insert success message before form
      contactForm.parentNode.insertBefore(successMessage, contactForm);
      
      // Remove success message after 5 seconds
      setTimeout(() => {
        successMessage.remove();
      }, 5000);
    });
  }
}

// Hero WebGL Scene
function initHeroScene(canvas) {
  if (!canvas || !isWebGLSupported()) return;
  
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true,
    alpha: true
  });
  
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(
    60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000
  );
  camera.position.z = 5;
  
  // Create particles
  const particlesCount = 2000;
  const particlesGeometry = new THREE.BufferGeometry();
  const posArray = new Float32Array(particlesCount * 3);
  const colorArray = new Float32Array(particlesCount * 3);
  
  // Fill positions and colors
  for (let i = 0; i < particlesCount * 3; i+=3) {
    // Positions (sphere distribution)
    const radius = 10;
    const theta = Math.random() * Math.PI * 2;
    const phi = Math.random() * Math.PI;
    
    posArray[i] = radius * Math.sin(phi) * Math.cos(theta);
    posArray[i+1] = radius * Math.sin(phi) * Math.sin(theta);
    posArray[i+2] = radius * Math.cos(phi);
    
    // Colors (from primary to secondary)
    const mixFactor = Math.random();
    colorArray[i] = 0.1 + mixFactor * 0.9; // Red: from primary to secondary
    colorArray[i+1] = 0.2 + mixFactor * 0.8; // Green: from primary to secondary
    colorArray[i+2] = 0.4 - mixFactor * 0.2; // Blue: from primary to secondary
  }
  
  particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
  particlesGeometry.setAttribute('color', new THREE.BufferAttribute(colorArray, 3));
  
  const particlesMaterial = new THREE.PointsMaterial({
    size: 0.03,
    vertexColors: true,
    transparent: true,
    opacity: 0.7,
    blending: THREE.AdditiveBlending
  });
  
  const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
  scene.add(particlesMesh);
  
  // Add ambient light
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
  scene.add(ambientLight);
  
  // Animation
  function animate() {
    requestAnimationFrame(animate);
    
    particlesMesh.rotation.x += 0.0005;
    particlesMesh.rotation.y += 0.0003;
    
    // Update renderer
    renderer.render(scene, camera);
  }
  
  // Handle resize
  function handleResize() {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    
    renderer.setSize(width, height);
  }
  
  window.addEventListener('resize', handleResize);
  animate();
}

// Mission WebGL Scene with Parallax Effect
function initMissionScene(canvas) {
  if (!canvas || !isWebGLSupported()) return;
  
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true
  });
  
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(
    60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000
  );
  camera.position.z = 1.5;
  
  // Load mission image texture
  const textureLoader = new THREE.TextureLoader();
  const imagePath = '/Wildlife/assets/images/about/mission.jpg';
  let planeMesh;
  
  // Create a plane for the image with displacement effect
  textureLoader.load(imagePath, function(texture) {
    const geometry = new THREE.PlaneGeometry(2, 1.5, 64, 64);
    
    // Create depth map from the image (for demo purposes)
    const depthTexture = texture.clone();
    
    const material = new THREE.MeshStandardMaterial({
      map: texture,
      displacementMap: depthTexture,
      displacementScale: 0.15,
      bumpMap: depthTexture,
      bumpScale: 0.1,
      side: THREE.DoubleSide
    });
    
    planeMesh = new THREE.Mesh(geometry, material);
    scene.add(planeMesh);
    
    // Add atmospheric particles
    addAtmosphericParticles(scene);
  });
  
  // Add lights
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
  scene.add(ambientLight);
  
  const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
  directionalLight.position.set(1, 1, 2);
  scene.add(directionalLight);
  
  // Mouse movement for parallax effect
  let mouseX = 0, mouseY = 0;
  let targetX = 0, targetY = 0;
  
  function onMouseMove(event) {
    const containerRect = canvas.getBoundingClientRect();
    
    // Normalize mouse coordinates to -1 to 1
    mouseX = ((event.clientX - containerRect.left) / containerRect.width) * 2 - 1;
    mouseY = -((event.clientY - containerRect.top) / containerRect.height) * 2 + 1;
  }
  
  window.addEventListener('mousemove', onMouseMove);
  
  // Add particles for atmospheric effect
  function addAtmosphericParticles(scene) {
    const particlesCount = 200;
    const particlesGeometry = new THREE.BufferGeometry();
    const posArray = new Float32Array(particlesCount * 3);
    
    // Fill positions
    for (let i = 0; i < particlesCount * 3; i+=3) {
      posArray[i] = (Math.random() - 0.5) * 3;
      posArray[i+1] = (Math.random() - 0.5) * 3;
      posArray[i+2] = (Math.random() - 0.5) * 2;
    }
    
    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
    
    const particlesMaterial = new THREE.PointsMaterial({
      size: 0.01,
      color: 0xffffff,
      transparent: true,
      opacity: 0.4,
      blending: THREE.AdditiveBlending
    });
    
    const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
    scene.add(particlesMesh);
  }
  
  // Animation
  function animate() {
    requestAnimationFrame(animate);
    
    // Smooth transition for mouse movement
    targetX = mouseX * 0.1;
    targetY = mouseY * 0.1;
    
    if (planeMesh) {
      // Rotate mesh based on mouse position for parallax effect
      planeMesh.rotation.y += (targetX - planeMesh.rotation.y) * 0.05;
      planeMesh.rotation.x += (targetY - planeMesh.rotation.x) * 0.05;
      
      // Subtle continuous animation
      planeMesh.position.z = Math.sin(Date.now() * 0.001) * 0.05;
    }
    
    // Update renderer
    renderer.render(scene, camera);
  }
  
  // Handle resize
  function handleResize() {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    
    renderer.setSize(width, height);
  }
  
  window.addEventListener('resize', handleResize);
  animate();
}

// 3D Timeline Scene
function initTimelineScene(canvas) {
  if (!canvas || !isWebGLSupported()) return;
  
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true,
    alpha: true
  });
  
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(
    60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000
  );
  camera.position.z = 10;
  
  // Timeline data
  const timelineData = [
    {
      year: 2020,
      title: "The Beginning",
      description: "Founded by a team of wildlife biologists and tech entrepreneurs with a shared vision to connect digital productivity with conservation efforts.",
      imagePath: "/Wildlife/assets/images/about/timeline-1.jpg"
    },
    {
      year: 2021,
      title: "First App Release",
      description: "Launched our beta version with basic focus timer functionality and virtual creatures, establishing partnerships with five conservation organizations.",
      imagePath: "/Wildlife/assets/images/about/timeline-2.jpg"
    },
    {
      year: 2022,
      title: "Community Growth",
      description: "Reached 100,000 active users and expanded our conservation impact to support 15 endangered species across three continents.",
      imagePath: "/Wildlife/assets/images/about/timeline-3.jpg"
    },
    {
      year: 2023,
      title: "AR Implementation",
      description: "Introduced augmented reality features allowing users to interact with virtual wildlife in their real environments, enhancing the connection to nature.",
      imagePath: "/Wildlife/assets/images/about/timeline-4.jpg"
    },
    {
      year: 2024,
      title: "Global Expansion",
      description: "Expanded to over 1 million users across 150+ countries, with direct conservation contributions exceeding $2 million for wildlife protection projects.",
      imagePath: "/Wildlife/assets/images/about/timeline-5.jpg"
    },
    {
      year: 2025,
      title: "Today & Beyond",
      description: "Implementing advanced ML-driven focus engine and expanding our virtual biodiversity. Join us as we continue to grow our impact together.",
      imagePath: "/Wildlife/assets/images/about/timeline-6.jpg"
    }
  ];
  
  // Create timeline cards in 3D space
  const cards = new THREE.Group();
  scene.add(cards);
  
  // Load timeline images and create cards
  const textureLoader = new THREE.TextureLoader();
  const timelineCards = [];
  
  timelineData.forEach((item, index) => {
    textureLoader.load(item.imagePath, function(texture) {
      // Create card geometry
      const cardWidth = 3;
      const cardHeight = 2;
      const cardGeometry = new THREE.PlaneGeometry(cardWidth, cardHeight, 1, 1);
      
      // Create card material with image texture
      const cardMaterial = new THREE.MeshStandardMaterial({
        map: texture,
        side: THREE.DoubleSide
      });
      
      // Create card mesh
      const cardMesh = new THREE.Mesh(cardGeometry, cardMaterial);
      cardMesh.position.x = (index - 2.5) * 5;
      cardMesh.position.y = 0;
      cardMesh.position.z = 0;
      cardMesh.userData = {
        info: item,
        index: index,
        originalX: cardMesh.position.x
      };
      
      // Add card to group
      cards.add(cardMesh);
      timelineCards.push(cardMesh);
      
      // If this is the first card, show its info in the panel
      if (index === 0) {
        updateTimelineInfo(item);
      }
    });
  });
  
  // Add lighting
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
  scene.add(ambientLight);
  
  const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
  directionalLight.position.set(1, 1, 2);
  scene.add(directionalLight);
  
  // Timeline navigation
  let activeIndex = 0;
  let targetRotation = 0;
  
  document.querySelectorAll('.timeline-year-btn').forEach((btn, index) => {
    btn.addEventListener('click', function() {
      navigateToTimelineIndex(index);
      
      // Highlight active button
      document.querySelectorAll('.timeline-year-btn').forEach(b => 
        b.classList.remove('bg-primary', 'text-white'));
      this.classList.add('bg-primary', 'text-white');
    });
  });
  
  function navigateToTimelineIndex(index) {
    if (index >= 0 && index < timelineData.length) {
      activeIndex = index;
      
      // Calculate target rotation to center the selected card
      targetRotation = -index * Math.PI / 3;
      
      // Show card info
      const item = timelineData[index];
      updateTimelineInfo(item);
    }
  }
  
  function updateTimelineInfo(item) {
    const infoPanel = document.getElementById('timeline-info');
    
    // Update content
    document.getElementById('timeline-year').textContent = item.year;
    document.getElementById('timeline-title').textContent = item.title;
    document.getElementById('timeline-description').textContent = item.description;
    document.getElementById('timeline-image').src = item.imagePath;
    
    // Show panel with animation
    infoPanel.style.opacity = '1';
    infoPanel.style.transform = 'translateY(0)';
  }
  
  // Initialize first button as active
  document.querySelector('.timeline-year-btn').classList.add('bg-primary', 'text-white');
  
  // Animation
  function animate() {
    requestAnimationFrame(animate);
    
    // Rotate cards smoothly to target rotation
    cards.rotation.y += (targetRotation - cards.rotation.y) * 0.1;
    
    // Adjust card positions for curved layout
    timelineCards.forEach(card => {
      // Calculate angle for positioning in a circle
      const angle = (card.userData.index - activeIndex) * Math.PI / 6;
      
      // Position on a circle in 3D space
      const radius = 8;
      card.position.x = Math.sin(angle) * radius;
      card.position.z = -Math.cos(angle) * radius + radius;
      
      // Look at center
      card.lookAt(0, 0, 0);
      
      // Scale based on position
      const dist = Math.abs(card.userData.index - activeIndex);
      card.scale.set(1 - dist * 0.15, 1 - dist * 0.15, 1);
    });
    
    // Update renderer
    renderer.render(scene, camera);
  }
  
  // Handle resize
  function handleResize() {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    
    renderer.setSize(width, height);
  }
  
  window.addEventListener('resize', handleResize);
  animate();
}

// Values WebGL Scene
function initValuesScene(canvas) {
  if (!canvas || !isWebGLSupported()) return;
  
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true,
    alpha: true
  });
  
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  
  const scene = new THREE.Scene();
  scene.background = new THREE.Color(0xf9f8f2);
  
  const camera = new THREE.PerspectiveCamera(
    60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000
  );
  camera.position.z = 10;
  
  // Values data
  const valuesData = [
    {
      title: "Conservation First",
      description: "We believe in measurable, transparent conservation impact. Every design and business decision is evaluated by its potential to benefit wildlife.",
      icon: "fas fa-globe-americas",
      stats: [
        "$2.3M contributed to conservation",
        "42 protected habitats worldwide",
        "15 endangered species supported"
      ]
    },
    {
      title: "Mindful Technology",
      description: "We design technology that enhances human wellbeing and focus while creating meaningful connections to the natural world.",
      icon: "fas fa-brain",
      stats: [
        "82% of users report improved focus",
        "45% reduction in phone pickups",
        "3.2 hours of daily focused time avg."
      ]
    },
    {
      title: "Community Empowerment",
      description: "We believe in the collective power of individual actions. Our community of users drives our conservation impact and shapes our future.",
      icon: "fas fa-hands-helping",
      stats: [
        "1M+ active community members",
        "65% of features are community-driven",
        "Monthly conservation voting"
      ]
    },
    {
      title: "Creative Innovation",
      description: "We continuously explore new ways to connect technology, productivity, and conservation through imaginative solutions.",
      icon: "fas fa-lightbulb",
      stats: [
        "AR wildlife experiences",
        "ML-powered focus enhancement",
        "Real-time conservation tracking"
      ]
    },
    {
      title: "Ethical Business",
      description: "We maintain the highest standards of transparency, data privacy, and ethical business practices in everything we do.",
      icon: "fas fa-balance-scale",
      stats: [
        "B-Corp certified",
        "No data selling, ever",
        "Annual impact transparency report"
      ]
    },
    {
      title: "Education & Awareness",
      description: "We believe knowledge is the foundation of conservation. We strive to educate and inspire users about wildlife and their habitats.",
      icon: "fas fa-book-open",
      stats: [
        "500+ wildlife fact sheets",
        "Educational content partners",
        "Wildlife podcast with 50K listeners"
      ]
    }
  ];
  
  // Create visual representations of values using 3D objects
  const valueObjects = new THREE.Group();
  scene.add(valueObjects);
  
  // Create geometric representations for each value
  const geometries = [
    new THREE.IcosahedronGeometry(1, 0), // Conservation First
    new THREE.OctahedronGeometry(1, 0),  // Mindful Technology
    new THREE.DodecahedronGeometry(1, 0), // Community Empowerment
    new THREE.TetrahedronGeometry(1, 0),  // Creative Innovation
    new THREE.TorusKnotGeometry(0.7, 0.3, 64, 8), // Ethical Business
    new THREE.SphereGeometry(1, 32, 32)  // Education & Awareness
  ];
  
  // Create materials with different colors
  const materials = [
    new THREE.MeshStandardMaterial({ color: 0x1a365d, roughness: 0.7 }), // Primary color
    new THREE.MeshStandardMaterial({ color: 0x2c5282, roughness: 0.7 }),
    new THREE.MeshStandardMaterial({ color: 0x2b6cb0, roughness: 0.7 }),
    new THREE.MeshStandardMaterial({ color: 0x3182ce, roughness: 0.7 }),
    new THREE.MeshStandardMaterial({ color: 0x4299e1, roughness: 0.7 }),
    new THREE.MeshStandardMaterial({ color: 0x63b3ed, roughness: 0.7 })
  ];
  
  // Create meshes for each value
  valuesData.forEach((value, index) => {
    const geometry = geometries[index % geometries.length];
    const material = materials[index % materials.length];
    
    const mesh = new THREE.Mesh(geometry, material);
    
    // Position in a circle
    const angle = (index / valuesData.length) * Math.PI * 2;
    const radius = 5;
    mesh.position.x = Math.cos(angle) * radius;
    mesh.position.z = Math.sin(angle) * radius;
    
    mesh.userData = {
      info: value,
      index: index,
      originalPosition: mesh.position.clone(),
      originalRotation: new THREE.Euler(0, 0, 0)
    };
    
    valueObjects.add(mesh);
  });
  
  // Add particles for background atmosphere
  const particles = createParticleSystem(2000, 15);
  scene.add(particles);
  
  // Add lighting
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
  scene.add(ambientLight);
  
  const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
  directionalLight.position.set(1, 1, 2);
  scene.add(directionalLight);
  
  // Values navigation
  let activeIndex = 0;
  let targetRotation = 0;
  
  // Create indicators
  const indicatorsContainer = document.getElementById('values-indicators');
  
  valuesData.forEach((_, index) => {
    const indicator = document.createElement('button');
    indicator.className = 'w-3 h-3 rounded-full bg-gray-300 hover:bg-primary transition-colors';
    indicator.addEventListener('click', () => navigateToValueIndex(index));
    indicatorsContainer.appendChild(indicator);
  });
  
  // Set first indicator as active
  indicatorsContainer.firstChild.classList.remove('bg-gray-300');
  indicatorsContainer.firstChild.classList.add('bg-primary');
  
  // Setup navigation buttons
  document.getElementById('values-prev').addEventListener('click', () => {
    navigateToValueIndex((activeIndex - 1 + valuesData.length) % valuesData.length);
  });
  
  document.getElementById('values-next').addEventListener('click', () => {
    navigateToValueIndex((activeIndex + 1) % valuesData.length);
  });
  
  function navigateToValueIndex(index) {
    if (index >= 0 && index < valuesData.length) {
      activeIndex = index;
      
      // Calculate target rotation to show the selected value
      targetRotation = -index * (Math.PI * 2 / valuesData.length);
      
      // Update info panel
      const value = valuesData[index];
      updateValueInfo(value);
      
      // Update indicators
      const indicators = indicatorsContainer.children;
      for (let i = 0; i < indicators.length; i++) {
        if (i === index) {
          indicators[i].classList.remove('bg-gray-300');
          indicators[i].classList.add('bg-primary');
        } else {
          indicators[i].classList.remove('bg-primary');
          indicators[i].classList.add('bg-gray-300');
        }
      }
    }
  }
  
  function updateValueInfo(value) {
    // Update content
    document.getElementById('value-title').textContent = value.title;
    document.getElementById('value-description').textContent = value.description;
    
    // Update icon
    const iconElement = document.querySelector('.value-icon i');
    iconElement.className = value.icon + ' text-primary text-2xl';
    
    // Update stats
    const statsContainer = document.getElementById('value-stats');
    statsContainer.innerHTML = '';
    
    value.stats.forEach(stat => {
      const div = document.createElement('div');
      div.className = 'flex items-center';
      div.innerHTML = `
        <i class="fas fa-check-circle text-primary mr-2"></i>
        <span>${stat}</span>
      `;
      statsContainer.appendChild(div);
    });
  }
  
  // Animation
  function animate() {
    requestAnimationFrame(animate);
    
    // Rotate value objects group smoothly
    valueObjects.rotation.y += (targetRotation - valueObjects.rotation.y) * 0.1;
    
    // Animate individual objects
    valueObjects.children.forEach((mesh, index) => {
      // Float up and down
      mesh.position.y = mesh.userData.originalPosition.y + Math.sin(Date.now() * 0.001 + index) * 0.2;
      
      // Continuously rotate
      mesh.rotation.x += 0.003;
      mesh.rotation.y += 0.005;
      
      // Highlight active value
      if (index === activeIndex) {
        // Scale up active value
        mesh.scale.lerp(new THREE.Vector3(1.3, 1.3, 1.3), 0.1);
      } else {
        // Scale down inactive values
        mesh.scale.lerp(new THREE.Vector3(1, 1, 1), 0.1);
      }
    });
    
    // Animate particles
    particles.rotation.y += 0.0005;
    
    // Update renderer
    renderer.render(scene, camera);
  }
  
  // Handle resize
  function handleResize() {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    
    renderer.setSize(width, height);
  }
  
  window.addEventListener('resize', handleResize);
  animate();
}

// Team Members WebGL Scene
function initTeamScene(canvas) {
  if (!canvas || !isWebGLSupported()) return;
  
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true,
    alpha: true
  });
  
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  
  const scene = new THREE.Scene();
  scene.background = new THREE.Color(0xf8fafc);
  
  const camera = new THREE.PerspectiveCamera(
    60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000
  );
  camera.position.z = 10;
  
  // Team members data
  const teamData = [
    {
      name: "Dr. Emma Chen",
      title: "Founder & CEO",
      bio: "Former wildlife biologist with 15 years of conservation experience in Southeast Asia. Leads Wildlife Haven's vision and conservation strategy.",
      quote: "Technology can be the bridge reconnecting humans with nature in our digital age.",
      imagePath: "/Wildlife/assets/images/about/team-1.jpg"
    },
    {
      name: "Marcus Rivera",
      title: "CTO & Co-Founder",
      bio: "Previously led engineering teams at Apple and Google. Brings technical expertise in AI, mobile development, and sustainable tech practices.",
      quote: "The best technology feels invisible while creating meaningful impact in our lives and world.",
      imagePath: "/Wildlife/assets/images/about/team-2.jpg"
    },
    {
      name: "Dr. Amara Okafor",
      title: "Conservation Director",
      bio: "Former Director of Conservation at World Wildlife Fund with expertise in creating effective conservation programs across Africa and Asia.",
      quote: "Digital tools can amplify conservation impact and engage people who have never considered their role in wildlife protection.",
      imagePath: "/Wildlife/assets/images/about/team-3.jpg"
    },
    {
      name: "Sanjay Patel",
      title: "Creative Director",
      bio: "Award-winning designer with background in game development and interactive experiences. Leads the creative vision for our virtual ecosystem.",
      quote: "Great design creates emotional connections. We're using those connections to inspire conservation action.",
      imagePath: "/Wildlife/assets/images/about/team-4.jpg"
    },
    {
      name: "Olivia Kim",
      title: "Head of Product",
      bio: "Former product leader at Headspace and Duolingo. Expert in behavioral design and creating habit-forming experiences with positive impact.",
      quote: "The best products create both personal and global benefits. We're building tools that help you while helping the planet.",
      imagePath: "/Wildlife/assets/images/about/team-5.jpg"
    },
    {
      name: "Dr. Miguel Torres",
      title: "Lead Ecological Scientist",
      bio: "Renowned ecologist specialized in biodiversity and ecosystem restoration. Ensures scientific accuracy in our virtual creatures and educational content.",
      quote: "By creating digital versions of endangered species, we're helping people develop emotional connections to wildlife they might never see in person.",
      imagePath: "/Wildlife/assets/images/about/team-6.jpg"
    }
  ];
  
  // Create interactive 3D photo frames for team members
  const textureLoader = new THREE.TextureLoader();
  const framesGroup = new THREE.Group();
  scene.add(framesGroup);
  
  // Create frames for each team member
  const teamFrames = [];
  
  teamData.forEach((member, index) => {
    // Create frame group
    const frameGroup = new THREE.Group();
    
    // Load member photo
    textureLoader.load(member.imagePath, function(texture) {
      // Create photo geometry and material
      const photoGeometry = new THREE.PlaneGeometry(3, 4, 1, 1);
      const photoMaterial = new THREE.MeshStandardMaterial({
        map: texture,
        side: THREE.FrontSide
      });
      
      // Create photo mesh
      const photoMesh = new THREE.Mesh(photoGeometry, photoMaterial);
      
      // Create frame geometry and material
      const frameGeometry = new THREE.BoxGeometry(3.2, 4.2, 0.2);
      const frameMaterial = new THREE.MeshStandardMaterial({
        color: 0x1a365d,
        metalness: 0.3,
        roughness: 0.7
      });
      
      // Create frame mesh
      const frameMesh = new THREE.Mesh(frameGeometry, frameMaterial);
      frameMesh.position.z = -0.1;
      
      // Add to frame group
      frameGroup.add(frameMesh);
      frameGroup.add(photoMesh);
      
      // Position on a circle
      const angle = (index / teamData.length) * Math.PI * 2;
      const radius = 6;
      frameGroup.position.x = Math.cos(angle) * radius;
      frameGroup.position.z = Math.sin(angle) * radius;
      
      // Look at center
      frameGroup.lookAt(0, 0, 0);
      
      // Store reference to member data
      frameGroup.userData = {
        info: member,
        index: index
      };
      
      framesGroup.add(frameGroup);
      teamFrames.push(frameGroup);
      
      // If this is the first frame, show info in panel
      if (index === 0) {
        updateTeamInfo(member);
        document.getElementById('team-info').style.opacity = '1';
      }
    });
  });
  
  // Add ambient lighting
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
  scene.add(ambientLight);
  
  // Add directional light
  const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
  directionalLight.position.set(2, 2, 5);
  scene.add(directionalLight);
  
  // Add spot light for dramatic effect
  const spotLight = new THREE.SpotLight(0xffffff, 1);
  spotLight.position.set(0, 8, 0);
  spotLight.angle = Math.PI / 4;
  spotLight.penumbra = 0.1;
  spotLight.decay = 2;
  spotLight.distance = 20;
  scene.add(spotLight);
  
  // Team navigation
  let activeIndex = 0;
  let targetRotation = 0;
  
  document.getElementById('team-prev').addEventListener('click', () => {
    navigateToTeamIndex((activeIndex - 1 + teamData.length) % teamData.length);
  });
  
  document.getElementById('team-next').addEventListener('click', () => {
    navigateToTeamIndex((activeIndex + 1) % teamData.length);
  });
  
  function navigateToTeamIndex(index) {
    if (index >= 0 && index < teamData.length) {
      activeIndex = index;
      
      // Calculate target rotation to center the selected team member
      targetRotation = -index * (Math.PI * 2 / teamData.length);
      
      // Update info panel
      const member = teamData[index];
      updateTeamInfo(member);
    }
  }
  
  function updateTeamInfo(member) {
    // Update content
    document.getElementById('team-name').textContent = member.name;
    document.getElementById('team-title').textContent = member.title;
    document.getElementById('team-bio').textContent = member.bio;
    document.getElementById('team-quote').textContent = `"${member.quote}"`;
  }
  
  // Animation
  function animate() {
    requestAnimationFrame(animate);
    
    // Rotate frames group smoothly to target rotation
    framesGroup.rotation.y += (targetRotation - framesGroup.rotation.y) * 0.1;
    
    // Animate individual frames
    teamFrames.forEach((frame, index) => {
      // Subtle floating animation
      frame.position.y = Math.sin(Date.now() * 0.001 + index) * 0.2;
      
      // Scale active frame
      if (index === activeIndex) {
        frame.scale.lerp(new THREE.Vector3(1.2, 1.2, 1.2), 0.1);
      } else {
        frame.scale.lerp(new THREE.Vector3(1, 1, 1), 0.1);
      }
    });
    
    // Update renderer
    renderer.render(scene, camera);
  }
  
  // Handle resize
  function handleResize() {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    
    renderer.setSize(width, height);
  }
  
  window.addEventListener('resize', handleResize);
  animate();
}

// Impact Globe Visualization
function initImpactGlobe(canvas) {
  if (!canvas || !isWebGLSupported() || typeof ThreeGlobe === 'undefined') {
    // Fallback if ThreeGlobe is not available
    return initImpactParticles(canvas);
  }
  
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true,
    alpha: true
  });
  
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(
    60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000
  );
  camera.position.z = 200;
  
  // Initialize Globe
  const Globe = new ThreeGlobe()
    .globeImageUrl('/Wildlife/assets/images/earth-blue-marble.jpg')
    .bumpImageUrl('/Wildlife/assets/images/earth-topology.jpg')
    .atmosphereColor('#1a365d')
    .atmosphereAltitude(0.15);
  
  // Conservation project locations (example data)
  const projectsData = [
    { lat: 36.7783, lng: -119.4179, name: "California Redwood Conservation", value: 20 },
    { lat: -2.5489, lng: 117.8653, name: "Borneo Rainforest Protection", value: 35 },
    { lat: -33.8688, lng: 151.2093, name: "Great Barrier Reef Restoration", value: 25 },
    { lat: 27.1750, lng: 78.0422, name: "Indian Tiger Sanctuary", value: 15 },
    { lat: -2.3333, lng: 34.8333, name: "Serengeti Wildlife Preserve", value: 30 },
    { lat: 64.2008, lng: -149.4937, name: "Alaska Wildlife Refuge", value: 18 },
    { lat: -13.1631, lng: -72.5450, name: "Amazon Biodiversity Project", value: 40 },
    { lat: 71.7069, lng: -42.6043, name: "Greenland Ice Sheet Research", value: 12 },
    { lat: -0.0236, lng: 37.9062, name: "Kenya Elephant Protection", value: 22 },
    { lat: 35.6762, lng: 139.6503, name: "Japan Marine Conservation", value: 17 }
  ];
  
  // Add points to globe
  Globe.pointsData(projectsData)
    .pointColor(() => '#fcd34d')
    .pointAltitude(0.07)
    .pointRadius(0.25);
  
  // Add arcs connecting headquarters to project locations
  const headquarters = { lat: 37.7749, lng: -122.4194 }; // San Francisco
  
  const arcsData = projectsData.map(project => ({
    startLat: headquarters.lat,
    startLng: headquarters.lng,
    endLat: project.lat,
    endLng: project.lng,
    color: '#fcd34d'
  }));
  
  Globe.arcsData(arcsData)
    .arcColor('color')
    .arcDashLength(0.4)
    .arcDashGap(0.2)
    .arcDashAnimateTime(2000)
    .arcStroke(0.5);
  
  // Add rings at project locations
  Globe.ringsData(projectsData)
    .ringColor(() => '#fcd34d')
    .ringMaxRadius(5)
    .ringPropagationSpeed(3)
    .ringRepeatPeriod(1000);
  
  // Add globe to scene
  scene.add(Globe);
  
  // Add ambient light
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.8);
  scene.add(ambientLight);
  
  // Add directional light
  const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
  directionalLight.position.set(1, 1, 1);
  scene.add(directionalLight);
  
  // Add background stars
  const stars = createStarField(1000, 500);
  scene.add(stars);
  
  // Animation
  function animate() {
    requestAnimationFrame(animate);
    
    // Rotate globe
    Globe.rotation.y += 0.002;
    
    // Animate stars
    stars.rotation.y -= 0.0005;
    
    // Update renderer
    renderer.render(scene, camera);
  }
  
  // Handle resize
  function handleResize() {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    
    renderer.setSize(width, height);
  }
  
  window.addEventListener('resize', handleResize);
  animate();
}

// Testimonials WebGL Scene
function initTestimonialsScene(canvas) {
  if (!canvas || !isWebGLSupported()) return;
  
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true,
    alpha: true
  });
  
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  
  const scene = new THREE.Scene();
  scene.background = new THREE.Color(0xf8fafc);
  
  const camera = new THREE.PerspectiveCamera(
    60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000
  );
  camera.position.z = 10;
  
  // Testimonial data
  const testimonialData = [
    {
      text: "Wildlife Haven transformed my productivity habits completely. Instead of dreading long focus sessions, I now look forward to helping my virtual creatures grow. The best part is knowing my focus time contributes to real conservation efforts. I've improved my work efficiency while supporting causes I care about!",
      name: "Jessica Taylor",
      title: "Freelance Designer, Wildlife Haven user for 2 years",
      imagePath: "/Wildlife/assets/images/about/testimonial-1.jpg"
    },
    {
      text: "As a teacher, I've introduced Wildlife Haven to my students as part of our focus training. They're engaged with the wildlife conservation aspects and compete to see who can contribute the most focus time. It's been incredible to see their concentration improve while they learn about endangered species.",
      name: "Michael Johnson",
      title: "High School Science Teacher",
      imagePath: "/Wildlife/assets/images/about/testimonial-2.jpg"
    },
    {
      text: "We partnered with Wildlife Haven to connect our conservation work with digital audiences, and the results have exceeded expectations. Their innovative approach brings conservation to people who might never otherwise engage with our mission. The transparency in how funds are used builds tremendous trust.",
      name: "Dr. Sarah Nguyen",
      title: "Director, Global Wildlife Fund",
      imagePath: "/Wildlife/assets/images/about/testimonial-3.jpg"
    },
    {
      text: "As someone with ADHD, traditional focus techniques never worked for me. Wildlife Haven's approach using virtual creatures and gamification has been life-changing. I'm actually excited to start focus sessions, and the AR features make the experience incredibly immersive.",
      name: "Alex Rodriguez",
      title: "Software Developer, Wildlife Haven user for 1 year",
      imagePath: "/Wildlife/assets/images/about/testimonial-4.jpg"
    },
    {
      text: "Our entire marketing team uses Wildlife Haven for our focused work sessions. We've seen a 30% increase in productivity, and the team building aspect of supporting conservation together has strengthened our company culture. The detailed progress analytics have been invaluable.",
      name: "Samantha Lee",
      title: "Marketing Director, Eco Innovations",
      imagePath: "/Wildlife/assets/images/about/testimonial-5.jpg"
    }
  ];
  
  // Create 3D carousel for testimonials
  const carousel = new THREE.Group();
  scene.add(carousel);
  
  // Load testimonial images and create cards
  const textureLoader = new THREE.TextureLoader();
  const testimonialCards = [];
  
  testimonialData.forEach((testimonial, index) => {
    textureLoader.load(testimonial.imagePath, function(texture) {
      // Create card geometry
      const cardGeometry = new THREE.PlaneGeometry(4, 2.5, 1, 1);
      
      // Create gradient background for card
      const cardMaterial = new THREE.MeshStandardMaterial({
        color: 0xffffff,
        metalness: 0.1,
        roughness: 0.8,
        side: THREE.DoubleSide
      });
      
      // Create card mesh
      const cardMesh = new THREE.Mesh(cardGeometry, cardMaterial);
      
      // Create photo geometry
      const photoGeometry = new THREE.CircleGeometry(0.5, 32);
      const photoMaterial = new THREE.MeshBasicMaterial({
        map: texture,
        side: THREE.DoubleSide
      });
      
      // Create photo mesh
      const photoMesh = new THREE.Mesh(photoGeometry, photoMaterial);
      photoMesh.position.set(-1.5, 0, 0.01);
      
      // Create card group
      const cardGroup = new THREE.Group();
      cardGroup.add(cardMesh);
      cardGroup.add(photoMesh);
      
      // Position on a circle
      const angle = (index / testimonialData.length) * Math.PI * 2;
      const radius = 7;
      cardGroup.position.x = Math.cos(angle) * radius;
      cardGroup.position.z = Math.sin(angle) * radius;
      
      // Look at center
      cardGroup.lookAt(0, 0, 0);
      
      // Store testimonial data
      cardGroup.userData = {
        info: testimonial,
        index: index
      };
      
      carousel.add(cardGroup);
      testimonialCards.push(cardGroup);
      
      // If this is the first card, show its content
      if (index === 0) {
        updateTestimonialContent(testimonial);
      }
    });
  });
  
  // Add ambient lighting
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
  scene.add(ambientLight);
  
  // Add directional light
  const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
  directionalLight.position.set(1, 1, 2);
  scene.add(directionalLight);
  
  // Create indicators
  const indicatorsContainer = document.getElementById('testimonial-indicators');
  
  testimonialData.forEach((_, index) => {
    const indicator = document.createElement('button');
    indicator.className = 'w-3 h-3 rounded-full bg-gray-300 hover:bg-primary transition-colors';
    indicator.addEventListener('click', () => navigateToTestimonialIndex(index));
    indicatorsContainer.appendChild(indicator);
  });
  
  // Set first indicator as active
  indicatorsContainer.firstChild.classList.remove('bg-gray-300');
  indicatorsContainer.firstChild.classList.add('bg-primary');
  
  // Testimonial navigation
  let activeIndex = 0;
  let targetRotation = 0;
  
  document.getElementById('testimonial-prev').addEventListener('click', () => {
    navigateToTestimonialIndex((activeIndex - 1 + testimonialData.length) % testimonialData.length);
  });
  
  document.getElementById('testimonial-next').addEventListener('click', () => {
    navigateToTestimonialIndex((activeIndex + 1) % testimonialData.length);
  });
  
  function navigateToTestimonialIndex(index) {
    if (index >= 0 && index < testimonialData.length) {
      activeIndex = index;
      
      // Calculate target rotation to center the selected testimonial
      targetRotation = -index * (Math.PI * 2 / testimonialData.length);
      
      // Update content
      const testimonial = testimonialData[index];
      updateTestimonialContent(testimonial);
      
      // Update indicators
      const indicators = indicatorsContainer.children;
      for (let i = 0; i < indicators.length; i++) {
        if (i === index) {
          indicators[i].classList.remove('bg-gray-300');
          indicators[i].classList.add('bg-primary');
        } else {
          indicators[i].classList.remove('bg-primary');
          indicators[i].classList.add('bg-gray-300');
        }
      }
    }
  }
  
  function updateTestimonialContent(testimonial) {
    // Animate content change with fade out/in
    const contentElement = document.getElementById('testimonial-content');
    contentElement.style.opacity = '0';
    
    setTimeout(() => {
      // Update content
      document.getElementById('testimonial-text').textContent = testimonial.text;
      document.getElementById('testimonial-name').textContent = testimonial.name;
      document.getElementById('testimonial-title').textContent = testimonial.title;
      document.getElementById('testimonial-image').src = testimonial.imagePath;
      
      // Fade back in
      contentElement.style.opacity = '1';
    }, 300);
  }
  
  // Animation
  function animate() {
    requestAnimationFrame(animate);
    
    // Rotate carousel smoothly
    carousel.rotation.y += (targetRotation - carousel.rotation.y) * 0.05;
    
    // Animate individual cards
    testimonialCards.forEach((card, index) => {
      // Highlight active card
      if (index === activeIndex) {
        card.scale.lerp(new THREE.Vector3(1.2, 1.2, 1.2), 0.1);
      } else {
        card.scale.lerp(new THREE.Vector3(0.8, 0.8, 0.8), 0.1);
      }
      
      // Add subtle floating motion
      card.position.y = Math.sin(Date.now() * 0.001 + index) * 0.1;
    });
    
    // Update renderer
    renderer.render(scene, camera);
  }
  
  // Handle resize
  function handleResize() {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    
    renderer.setSize(width, height);
  }
  
  window.addEventListener('resize', handleResize);
  animate();
}

// CTA Background Animation
function initCtaBackground(canvas) {
  if (!canvas || !isWebGLSupported()) return;
  
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true,
    alpha: true
  });
  
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(
    60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000
  );
  camera.position.z = 20;
  
  // Create wave effect
  const geometry = new THREE.PlaneGeometry(50, 30, 128, 128);
  const material = new THREE.MeshStandardMaterial({
    color: 0x2c5282,
    metalness: 0.2,
    roughness: 0.8,
    wireframe: false,
    side: THREE.DoubleSide,
    transparent: true,
    opacity: 0.6
  });
  
  const waves = new THREE.Mesh(geometry, material);
  waves.rotation.x = -Math.PI / 3;
  waves.position.y = -5;
  scene.add(waves);
  
  // Add animal silhouettes
  const silhouettes = createWildlifeSilhouettes();
  scene.add(silhouettes);
  
  // Add lights
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.3);
  scene.add(ambientLight);
  
  const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
  directionalLight.position.set(1, 1, 2);
  scene.add(directionalLight);
  
  // Add spotlight
  const spotLight = new THREE.SpotLight(0xfcd34d, 1);
  spotLight.position.set(10, 10, 10);
  spotLight.angle = Math.PI / 6;
  spotLight.penumbra = 0.2;
  scene.add(spotLight);
  
  // Animation
  function animate() {
    requestAnimationFrame(animate);
    
    // Animate waves
    const position = geometry.attributes.position;
    const time = Date.now() * 0.001;
    
    for (let i = 0; i < position.count; i++) {
      const vertex = new THREE.Vector3();
      vertex.fromBufferAttribute(position, i);
      
      // Create wave pattern
      const waveX1 = 0.5 * Math.sin(vertex.x * 0.3 + time);
      const waveX2 = 0.25 * Math.sin(vertex.x * 0.5 + time * 0.5);
      const waveY1 = 0.1 * Math.sin(vertex.y * 0.5 + time * 0.7);
      
      vertex.z = waveX1 + waveX2 + waveY1;
      
      position.setZ(i, vertex.z);
    }
    
    position.needsUpdate = true;
    
    // Animate silhouettes
    silhouettes.children.forEach(silhouette => {
      silhouette.position.x += silhouette.userData.speed;
      
      // Loop around when off screen
      if (silhouette.position.x > 30) {
        silhouette.position.x = -30;
      }
    });
    
    // Update renderer
    renderer.render(scene, camera);
  }
  
  // Creates wildlife silhouettes
  function createWildlifeSilhouettes() {
    const group = new THREE.Group();
    
    const silhouetteShapes = [
      { points: [[-1,0], [-0.5,0.8], [0,1], [0.5,0.8], [1,0.5], [0.8,-0.5], [0,-0.8], [-0.8,-0.5]], scale: 2 }, // Bird
      { points: [[-2,-1], [-1.5,0], [-1,0.5], [0,0.8], [1,0.5], [2,0], [2,-0.5], [1,-1], [0,-0.8], [-1,-1]], scale: 1.5 }, // Fish
      { points: [[-1.5,-1], [-1,0], [-0.5,0.5], [0,0.8], [0.5,0.5], [1,0.8], [1.5,0], [1,-0.5], [0,-1], [-1,-0.8]], scale: 2 }  // Dolphin
    ];
    
    // Create multiple silhouettes
    for (let i = 0; i < 8; i++) {
      const shapeIndex = i % silhouetteShapes.length;
      const shapeData = silhouetteShapes[shapeIndex];
      
      // Create shape
      const shape = new THREE.Shape();
      shape.moveTo(shapeData.points[0][0], shapeData.points[0][1]);
      
      for (let j = 1; j < shapeData.points.length; j++) {
        shape.lineTo(shapeData.points[j][0], shapeData.points[j][1]);
      }
      
      shape.closePath();
      
      // Create geometry
      const geometry = new THREE.ShapeGeometry(shape);
      const material = new THREE.MeshBasicMaterial({
        color: 0xffffff,
        transparent: true,
        opacity: 0.3,
        side: THREE.DoubleSide
      });
      
      // Create mesh
      const silhouette = new THREE.Mesh(geometry, material);
      
      // Scale and position
      silhouette.scale.set(shapeData.scale, shapeData.scale, 1);
      silhouette.position.set(
        Math.random() * 60 - 30,
        Math.random() * 10 - 5,
        Math.random() * 10
      );
      
      // Set movement speed
      silhouette.userData.speed = 0.05 + Math.random() * 0.05;
      
      group.add(silhouette);
    }
    
    return group;
  }
  
  // Handle resize
  function handleResize() {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    
    renderer.setSize(width, height);
  }
  
  window.addEventListener('resize', handleResize);
  animate();
}

// Impact Particles Animation (fallback for impact globe)
function initImpactParticles(canvas) {
  if (!canvas || !isWebGLSupported()) return;
  
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true,
    alpha: true
  });
  
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(canvas.clientWidth, canvas.clientHeight);
  
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(
    60, canvas.clientWidth / canvas.clientHeight, 0.1, 1000
  );
  camera.position.z = 15;
  
  // Create particle system
  const particles = createParticleSystem(3000, 20);
  scene.add(particles);
  
  // Add lighting
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
  scene.add(ambientLight);
  
  // Animation
  function animate() {
    requestAnimationFrame(animate);
    
    // Rotate particles
    particles.rotation.y += 0.001;
    particles.rotation.x += 0.0005;
    
    // Update renderer
    renderer.render(scene, camera);
  }
  
  // Handle resize
  function handleResize() {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    
    renderer.setSize(width, height);
  }
  
  window.addEventListener('resize', handleResize);
  animate();
}

// Utility Function: Create Particle System
function createParticleSystem(count, radius) {
  const particles = new THREE.BufferGeometry();
  const positions = new Float32Array(count * 3);
  const colors = new Float32Array(count * 3);
  
  const colorOptions = [
    new THREE.Color(0x1a365d), // Primary
    new THREE.Color(0x2c5282),
    new THREE.Color(0x3182ce),
    new THREE.Color(0xfcd34d), // Secondary
    new THREE.Color(0xfbd38d)
  ];
  
  for (let i = 0; i < count; i++) {
    // Position particles in a sphere
    const i3 = i * 3;
    const phi = Math.random() * Math.PI * 2;
    const theta = Math.random() * Math.PI;
    const r = radius * Math.cbrt(Math.random()); // For more even distribution
    
    positions[i3] = r * Math.sin(theta) * Math.cos(phi);
    positions[i3 + 1] = r * Math.sin(theta) * Math.sin(phi);
    positions[i3 + 2] = r * Math.cos(theta);
    
    // Assign random color from options
    const color = colorOptions[Math.floor(Math.random() * colorOptions.length)];
    colors[i3] = color.r;
    colors[i3 + 1] = color.g;
    colors[i3 + 2] = color.b;
  }
  
  particles.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  particles.setAttribute('color', new THREE.BufferAttribute(colors, 3));
  
  const material = new THREE.PointsMaterial({
    size: 0.05,
    transparent: true,
    opacity: 0.8,
    vertexColors: true,
    blending: THREE.AdditiveBlending
  });
  
  return new THREE.Points(particles, material);
}

// Utility Function: Create Star Field
function createStarField(count, radius) {
  const starsGeometry = new THREE.BufferGeometry();
  const positions = new Float32Array(count * 3);
  
  for (let i = 0; i < count; i++) {
    const i3 = i * 3;
    const phi = Math.random() * Math.PI * 2;
    const theta = Math.random() * Math.PI;
    const r = radius * Math.random();
    
    positions[i3] = r * Math.sin(theta) * Math.cos(phi);
    positions[i3 + 1] = r * Math.sin(theta) * Math.sin(phi);
    positions[i3 + 2] = r * Math.cos(theta);
  }
  
  starsGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  
  const starsMaterial = new THREE.PointsMaterial({
    color: 0xffffff,
    size: 0.1,
    transparent: true,
    opacity: 0.8,
    blending: THREE.AdditiveBlending
  });
  
  return new THREE.Points(starsGeometry, starsMaterial);
}

// Utility Function: Check WebGL Support
function isWebGLSupported() {
  try {
    const canvas = document.createElement('canvas');
    return !!(window.WebGLRenderingContext && 
      (canvas.getContext('webgl') || canvas.getContext('experimental-webgl')));
  } catch (e) {
    return false;
  }
}
</script>

<?php include ROOT_PATH . '/resources/views/layouts/footer.php'; ?>