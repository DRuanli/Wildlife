<?php
// Path: resources/views/about/index.php
$baseUrl = '/Wildlife';
?>

<?php include ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="relative bg-primary text-white overflow-hidden">
  <!-- Nature-inspired background patterns -->
  <div class="absolute inset-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <pattern id="leaf-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M30,50 Q50,20 70,50 Q50,80 30,50 Z" fill="currentColor"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#leaf-pattern)"/>
    </svg>
  </div>
  
  <div class="container mx-auto px-4 py-20 md:py-28 relative z-10">
    <div class="max-w-3xl mx-auto text-center">
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold mb-6 opacity-0 transform -translate-y-8 transition-all duration-1000 ease-out" id="hero-title">Our Story</h1>
      <p class="text-xl md:text-2xl mb-8 opacity-0 transform -translate-y-8 transition-all duration-1000 delay-300 ease-out" id="hero-text">Combining technology and wildlife conservation to create a world where focus and mindfulness benefit both humans and the natural world.</p>
      <a href="#our-mission" class="inline-flex items-center bg-secondary text-primary px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition-all opacity-0 transform -translate-y-8 duration-1000 delay-500 ease-out" id="hero-cta">
        <span>Discover Our Mission</span>
        <i class="fas fa-arrow-down ml-2"></i>
      </a>
    </div>
  </div>
  
  <!-- Animated wave divider -->
  <div class="absolute bottom-0 left-0 w-full">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="#F9F8F2" preserveAspectRatio="none">
      <path d="M0,96L48,80C96,64,192,32,288,26.7C384,21,480,43,576,58.7C672,75,768,85,864,80C960,75,1056,53,1152,42.7C1248,32,1344,32,1392,32L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
    </svg>
  </div>
</section>

<!-- Our Mission Section -->
<section id="our-mission" class="py-16 md:py-24 bg-light">
  <div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row items-center">
      <div class="md:w-1/2 md:pr-12 mb-10 md:mb-0">
        <img src="<?= $baseUrl ?>/assets/images/about/mission.jpg" alt="Wildlife conservation" class="rounded-lg shadow-xl transform transition-all duration-700 hover:scale-105" id="mission-image">
      </div>
      <div class="md:w-1/2">
        <h2 class="text-3xl md:text-4xl font-display font-bold mb-6 text-primary" id="mission-title">Our Mission</h2>
        <p class="text-lg mb-6 text-gray-700" id="mission-text">
          At Wildlife Haven, we've created a unique digital ecosystem where personal productivity and wildlife conservation unite. Our mission is to harness the power of technology to create meaningful connections between human focus and global conservation efforts.
        </p>
        <p class="text-lg mb-8 text-gray-700" id="mission-text-2">
          Through our innovative focus timer and virtual wildlife sanctuary, we're transforming daily productivity sessions into tangible support for endangered species protection, habitat restoration, and conservation education worldwide.
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
          <a href="#our-values" class="px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-opacity-90 transition text-center">
            Our Values
          </a>
          <a href="#our-impact" class="px-6 py-3 bg-white border border-primary text-primary rounded-lg font-medium hover:bg-gray-50 transition text-center">
            See Our Impact
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Our History Timeline Section -->
<section class="py-16 md:py-24 relative bg-gray-50 overflow-hidden" id="our-history">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <h2 class="text-3xl md:text-4xl font-display font-bold mb-6 text-primary">Our Journey</h2>
      <p class="text-lg max-w-3xl mx-auto text-gray-700">
        From a simple idea to a global movement, explore how Wildlife Haven evolved over the years to create a meaningful impact.
      </p>
    </div>
    
    <!-- 3D Timeline (horizontal scroll experience) -->
    <div class="timeline-wrapper relative">
      <div class="absolute inset-y-0 left-0 w-12 bg-gradient-to-r from-gray-50 to-transparent z-10"></div>
      <div class="absolute inset-y-0 right-0 w-12 bg-gradient-to-l from-gray-50 to-transparent z-10"></div>
      
      <div class="timeline-scroll-container overflow-x-auto py-8" id="timeline-container">
        <div class="timeline-track flex items-center min-w-max px-8">
          <!-- Timeline Item 1 -->
          <div class="timeline-item relative mx-6 w-80 flex-shrink-0" data-year="2020">
            <div class="timeline-connector absolute top-1/2 right-full w-12 h-0.5 bg-primary"></div>
            <div class="timeline-marker absolute top-1/2 right-full w-6 h-6 -mt-3 -mr-3 rounded-full bg-primary border-4 border-white z-20"></div>
            <div class="timeline-content h-full p-6 bg-white rounded-lg shadow-lg transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
              <span class="inline-block px-3 py-1 bg-primary bg-opacity-10 text-primary rounded-full text-sm font-semibold mb-4">2020</span>
              <h3 class="text-xl font-bold mb-3">The Beginning</h3>
              <p class="text-gray-700">Founded by a team of wildlife biologists and tech entrepreneurs with a shared vision to connect digital productivity with conservation efforts.</p>
              <img src="<?= $baseUrl ?>/assets/images/about/timeline-1.jpg" alt="Wildlife Haven founding" class="w-full h-40 object-cover rounded-md mt-4">
            </div>
          </div>
          
          <!-- Timeline Item 2 -->
          <div class="timeline-item relative mx-6 w-80 flex-shrink-0" data-year="2021">
            <div class="timeline-connector absolute top-1/2 right-full w-12 h-0.5 bg-primary"></div>
            <div class="timeline-marker absolute top-1/2 right-full w-6 h-6 -mt-3 -mr-3 rounded-full bg-primary border-4 border-white z-20"></div>
            <div class="timeline-content h-full p-6 bg-white rounded-lg shadow-lg transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
              <span class="inline-block px-3 py-1 bg-primary bg-opacity-10 text-primary rounded-full text-sm font-semibold mb-4">2021</span>
              <h3 class="text-xl font-bold mb-3">First App Release</h3>
              <p class="text-gray-700">Launched our beta version with basic focus timer functionality and virtual creatures, establishing partnerships with five conservation organizations.</p>
              <img src="<?= $baseUrl ?>/assets/images/about/timeline-2.jpg" alt="App launch" class="w-full h-40 object-cover rounded-md mt-4">
            </div>
          </div>
          
          <!-- Timeline Item 3 -->
          <div class="timeline-item relative mx-6 w-80 flex-shrink-0" data-year="2022">
            <div class="timeline-connector absolute top-1/2 right-full w-12 h-0.5 bg-primary"></div>
            <div class="timeline-marker absolute top-1/2 right-full w-6 h-6 -mt-3 -mr-3 rounded-full bg-primary border-4 border-white z-20"></div>
            <div class="timeline-content h-full p-6 bg-white rounded-lg shadow-lg transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
              <span class="inline-block px-3 py-1 bg-primary bg-opacity-10 text-primary rounded-full text-sm font-semibold mb-4">2022</span>
              <h3 class="text-xl font-bold mb-3">Community Growth</h3>
              <p class="text-gray-700">Reached 100,000 active users and expanded our conservation impact to support 15 endangered species across three continents.</p>
              <img src="<?= $baseUrl ?>/assets/images/about/timeline-3.jpg" alt="Community growth" class="w-full h-40 object-cover rounded-md mt-4">
            </div>
          </div>
          
          <!-- Timeline Item 4 -->
          <div class="timeline-item relative mx-6 w-80 flex-shrink-0" data-year="2023">
            <div class="timeline-connector absolute top-1/2 right-full w-12 h-0.5 bg-primary"></div>
            <div class="timeline-marker absolute top-1/2 right-full w-6 h-6 -mt-3 -mr-3 rounded-full bg-primary border-4 border-white z-20"></div>
            <div class="timeline-content h-full p-6 bg-white rounded-lg shadow-lg transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
              <span class="inline-block px-3 py-1 bg-primary bg-opacity-10 text-primary rounded-full text-sm font-semibold mb-4">2023</span>
              <h3 class="text-xl font-bold mb-3">AR Implementation</h3>
              <p class="text-gray-700">Introduced augmented reality features allowing users to interact with virtual wildlife in their real environments, enhancing the connection to nature.</p>
              <img src="<?= $baseUrl ?>/assets/images/about/timeline-4.jpg" alt="AR implementation" class="w-full h-40 object-cover rounded-md mt-4">
            </div>
          </div>
          
          <!-- Timeline Item 5 -->
          <div class="timeline-item relative mx-6 w-80 flex-shrink-0" data-year="2024">
            <div class="timeline-connector absolute top-1/2 right-full w-12 h-0.5 bg-primary"></div>
            <div class="timeline-marker absolute top-1/2 right-full w-6 h-6 -mt-3 -mr-3 rounded-full bg-primary border-4 border-white z-20"></div>
            <div class="timeline-content h-full p-6 bg-white rounded-lg shadow-lg transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
              <span class="inline-block px-3 py-1 bg-primary bg-opacity-10 text-primary rounded-full text-sm font-semibold mb-4">2024</span>
              <h3 class="text-xl font-bold mb-3">Global Expansion</h3>
              <p class="text-gray-700">Expanded to over 1 million users across 150+ countries, with direct conservation contributions exceeding $2 million for wildlife protection projects.</p>
              <img src="<?= $baseUrl ?>/assets/images/about/timeline-5.jpg" alt="Global expansion" class="w-full h-40 object-cover rounded-md mt-4">
            </div>
          </div>
          
          <!-- Timeline Item 6 -->
          <div class="timeline-item relative mx-6 w-80 flex-shrink-0" data-year="2025">
            <div class="timeline-connector absolute top-1/2 right-full w-12 h-0.5 bg-primary"></div>
            <div class="timeline-marker absolute top-1/2 right-full w-6 h-6 -mt-3 -mr-3 rounded-full bg-primary border-4 border-white z-20"></div>
            <div class="timeline-content h-full p-6 bg-white rounded-lg shadow-lg transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
              <span class="inline-block px-3 py-1 bg-secondary text-primary rounded-full text-sm font-semibold mb-4">2025</span>
              <h3 class="text-xl font-bold mb-3">Today & Beyond</h3>
              <p class="text-gray-700">Implementing advanced ML-driven focus engine and expanding our virtual biodiversity. Join us as we continue to grow our impact together.</p>
              <img src="<?= $baseUrl ?>/assets/images/about/timeline-6.jpg" alt="Future vision" class="w-full h-40 object-cover rounded-md mt-4">
            </div>
          </div>
        </div>
      </div>
      
      <!-- Timeline navigation buttons -->
      <div class="flex justify-center mt-8 space-x-3">
        <button class="timeline-nav-btn px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed" data-direction="prev" disabled>
          <i class="fas fa-arrow-left mr-2"></i> Previous
        </button>
        <button class="timeline-nav-btn px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed" data-direction="next">
          Next <i class="fas fa-arrow-right ml-2"></i>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Our Values Section -->
<section id="our-values" class="py-16 md:py-24 bg-light">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <h2 class="text-3xl md:text-4xl font-display font-bold mb-6 text-primary">Our Core Values</h2>
      <p class="text-lg max-w-3xl mx-auto text-gray-700">
        These principles guide everything we do at Wildlife Haven, from product development to conservation partnerships.
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Value 1 -->
      <div class="value-card bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-500 relative overflow-hidden">
        <div class="value-icon text-center mb-6">
          <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mx-auto">
            <i class="fas fa-globe-americas text-primary text-2xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-bold mb-4 text-center">Conservation First</h3>
        <p class="text-gray-700 text-center">We believe in measurable, transparent conservation impact. Every design and business decision is evaluated by its potential to benefit wildlife.</p>
        
        <!-- Interactive flip effect (back side) -->
        <div class="value-details absolute inset-0 bg-primary text-white p-8 flex flex-col items-center justify-center opacity-0 transition-opacity duration-500">
          <h3 class="text-xl font-bold mb-4">Conservation First</h3>
          <p class="mb-4">Our partnerships with conservation organizations are carefully selected based on transparency, effectiveness, and direct field impact.</p>
          <div class="mt-2 text-sm">
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>$2.3M contributed to conservation</span>
            </div>
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>42 protected habitats worldwide</span>
            </div>
            <div class="flex items-center">
              <i class="fas fa-check-circle mr-2"></i>
              <span>15 endangered species supported</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Value 2 -->
      <div class="value-card bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-500 relative overflow-hidden">
        <div class="value-icon text-center mb-6">
          <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mx-auto">
            <i class="fas fa-brain text-primary text-2xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-bold mb-4 text-center">Mindful Technology</h3>
        <p class="text-gray-700 text-center">We design technology that enhances human wellbeing and focus while creating meaningful connections to the natural world.</p>
        
        <!-- Interactive flip effect (back side) -->
        <div class="value-details absolute inset-0 bg-primary text-white p-8 flex flex-col items-center justify-center opacity-0 transition-opacity duration-500">
          <h3 class="text-xl font-bold mb-4">Mindful Technology</h3>
          <p class="mb-4">Our app is designed with digital wellbeing principles, helping users build better focus habits and reduce screen addiction.</p>
          <div class="mt-2 text-sm">
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>82% of users report improved focus</span>
            </div>
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>45% reduction in phone pickups</span>
            </div>
            <div class="flex items-center">
              <i class="fas fa-check-circle mr-2"></i>
              <span>3.2 hours of daily focused time avg.</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Value 3 -->
      <div class="value-card bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-500 relative overflow-hidden">
        <div class="value-icon text-center mb-6">
          <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mx-auto">
            <i class="fas fa-hands-helping text-primary text-2xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-bold mb-4 text-center">Community Empowerment</h3>
        <p class="text-gray-700 text-center">We believe in the collective power of individual actions. Our community of users drives our conservation impact and shapes our future.</p>
        
        <!-- Interactive flip effect (back side) -->
        <div class="value-details absolute inset-0 bg-primary text-white p-8 flex flex-col items-center justify-center opacity-0 transition-opacity duration-500">
          <h3 class="text-xl font-bold mb-4">Community Empowerment</h3>
          <p class="mb-4">Our users directly influence which conservation projects we support and which features we develop next.</p>
          <div class="mt-2 text-sm">
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>1M+ active community members</span>
            </div>
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>65% of features are community-driven</span>
            </div>
            <div class="flex items-center">
              <i class="fas fa-check-circle mr-2"></i>
              <span>Monthly conservation voting</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Value 4 -->
      <div class="value-card bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-500 relative overflow-hidden">
        <div class="value-icon text-center mb-6">
          <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mx-auto">
            <i class="fas fa-lightbulb text-primary text-2xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-bold mb-4 text-center">Creative Innovation</h3>
        <p class="text-gray-700 text-center">We continuously explore new ways to connect technology, productivity, and conservation through imaginative solutions.</p>
        
        <!-- Interactive flip effect (back side) -->
        <div class="value-details absolute inset-0 bg-primary text-white p-8 flex flex-col items-center justify-center opacity-0 transition-opacity duration-500">
          <h3 class="text-xl font-bold mb-4">Creative Innovation</h3>
          <p class="mb-4">Our innovation lab dedicates 20% of development time to experimental features that push the boundaries of conservation tech.</p>
          <div class="mt-2 text-sm">
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>AR wildlife experiences</span>
            </div>
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>ML-powered focus enhancement</span>
            </div>
            <div class="flex items-center">
              <i class="fas fa-check-circle mr-2"></i>
              <span>Real-time conservation tracking</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Value 5 -->
      <div class="value-card bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-500 relative overflow-hidden">
        <div class="value-icon text-center mb-6">
          <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mx-auto">
            <i class="fas fa-balance-scale text-primary text-2xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-bold mb-4 text-center">Ethical Business</h3>
        <p class="text-gray-700 text-center">We maintain the highest standards of transparency, data privacy, and ethical business practices in everything we do.</p>
        
        <!-- Interactive flip effect (back side) -->
        <div class="value-details absolute inset-0 bg-primary text-white p-8 flex flex-col items-center justify-center opacity-0 transition-opacity duration-500">
          <h3 class="text-xl font-bold mb-4">Ethical Business</h3>
          <p class="mb-4">We are committed to transparent operations, ethical data practices, and creating sustainable value for all stakeholders.</p>
          <div class="mt-2 text-sm">
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>B-Corp certified</span>
            </div>
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>No data selling, ever</span>
            </div>
            <div class="flex items-center">
              <i class="fas fa-check-circle mr-2"></i>
              <span>Annual impact transparency report</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Value 6 -->
      <div class="value-card bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-500 relative overflow-hidden">
        <div class="value-icon text-center mb-6">
          <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mx-auto">
            <i class="fas fa-book-open text-primary text-2xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-bold mb-4 text-center">Education & Awareness</h3>
        <p class="text-gray-700 text-center">We believe knowledge is the foundation of conservation. We strive to educate and inspire users about wildlife and their habitats.</p>
        
        <!-- Interactive flip effect (back side) -->
        <div class="value-details absolute inset-0 bg-primary text-white p-8 flex flex-col items-center justify-center opacity-0 transition-opacity duration-500">
          <h3 class="text-xl font-bold mb-4">Education & Awareness</h3>
          <p class="mb-4">Every virtual creature in our app is paired with real scientific information and conservation context about its real-world counterpart.</p>
          <div class="mt-2 text-sm">
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>500+ wildlife fact sheets</span>
            </div>
            <div class="flex items-center mb-1">
              <i class="fas fa-check-circle mr-2"></i>
              <span>Educational content partners</span>
            </div>
            <div class="flex items-center">
              <i class="fas fa-check-circle mr-2"></i>
              <span>Wildlife podcast with 50K listeners</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Team Section with 3D Card Effects -->
<section id="our-team" class="py-16 md:py-24 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <h2 class="text-3xl md:text-4xl font-display font-bold mb-6 text-primary">Meet Our Team</h2>
      <p class="text-lg max-w-3xl mx-auto text-gray-700">
        Wildlife Haven brings together experts in technology, conservation, and productivity to create innovative solutions for a better world.
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
      <!-- Team Member 1 -->
      <div class="team-card relative h-96 group perspective">
        <div class="relative h-full w-full rounded-xl shadow-xl transition-all duration-700 preserve-3d group-hover:rotate-y-180">
          <!-- Card Front -->
          <div class="absolute inset-0 backface-hidden">
            <img src="<?= $baseUrl ?>/assets/images/about/team-1.jpg" class="h-full w-full object-cover rounded-xl" alt="CEO portrait">
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-xl"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
              <h3 class="text-xl font-bold">Dr. Emma Chen</h3>
              <p class="text-gray-300">Founder & CEO</p>
            </div>
          </div>
          
          <!-- Card Back -->
          <div class="absolute inset-0 bg-primary text-white p-8 rounded-xl flex flex-col backface-hidden rotate-y-180">
            <h3 class="text-xl font-bold mb-2">Dr. Emma Chen</h3>
            <p class="text-gray-200 text-sm mb-4">Founder & CEO</p>
            <p class="text-gray-100 mb-4">Former wildlife biologist with 15 years of conservation experience in Southeast Asia. Leads Wildlife Haven's vision and conservation strategy.</p>
            <p class="text-gray-200 italic mb-4">"Technology can be the bridge reconnecting humans with nature in our digital age."</p>
            <div class="mt-auto flex space-x-3">
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-linkedin-in"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Team Member 2 -->
      <div class="team-card relative h-96 group perspective">
        <div class="relative h-full w-full rounded-xl shadow-xl transition-all duration-700 preserve-3d group-hover:rotate-y-180">
          <!-- Card Front -->
          <div class="absolute inset-0 backface-hidden">
            <img src="<?= $baseUrl ?>/assets/images/about/team-2.jpg" class="h-full w-full object-cover rounded-xl" alt="CTO portrait">
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-xl"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
              <h3 class="text-xl font-bold">Marcus Rivera</h3>
              <p class="text-gray-300">CTO & Co-Founder</p>
            </div>
          </div>
          
          <!-- Card Back -->
          <div class="absolute inset-0 bg-primary text-white p-8 rounded-xl flex flex-col backface-hidden rotate-y-180">
            <h3 class="text-xl font-bold mb-2">Marcus Rivera</h3>
            <p class="text-gray-200 text-sm mb-4">CTO & Co-Founder</p>
            <p class="text-gray-100 mb-4">Previously led engineering teams at Apple and Google. Brings technical expertise in AI, mobile development, and sustainable tech practices.</p>
            <p class="text-gray-200 italic mb-4">"The best technology feels invisible while creating meaningful impact in our lives and world."</p>
            <div class="mt-auto flex space-x-3">
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-linkedin-in"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-github"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Team Member 3 -->
      <div class="team-card relative h-96 group perspective">
        <div class="relative h-full w-full rounded-xl shadow-xl transition-all duration-700 preserve-3d group-hover:rotate-y-180">
          <!-- Card Front -->
          <div class="absolute inset-0 backface-hidden">
            <img src="<?= $baseUrl ?>/assets/images/about/team-3.jpg" class="h-full w-full object-cover rounded-xl" alt="Conservation Director portrait">
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-xl"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
              <h3 class="text-xl font-bold">Dr. Amara Okafor</h3>
              <p class="text-gray-300">Conservation Director</p>
            </div>
          </div>
          
          <!-- Card Back -->
          <div class="absolute inset-0 bg-primary text-white p-8 rounded-xl flex flex-col backface-hidden rotate-y-180">
            <h3 class="text-xl font-bold mb-2">Dr. Amara Okafor</h3>
            <p class="text-gray-200 text-sm mb-4">Conservation Director</p>
            <p class="text-gray-100 mb-4">Former Director of Conservation at World Wildlife Fund with expertise in creating effective conservation programs across Africa and Asia.</p>
            <p class="text-gray-200 italic mb-4">"Digital tools can amplify conservation impact and engage people who have never considered their role in wildlife protection."</p>
            <div class="mt-auto flex space-x-3">
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-linkedin-in"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Team Member 4 -->
      <div class="team-card relative h-96 group perspective">
        <div class="relative h-full w-full rounded-xl shadow-xl transition-all duration-700 preserve-3d group-hover:rotate-y-180">
          <!-- Card Front -->
          <div class="absolute inset-0 backface-hidden">
            <img src="<?= $baseUrl ?>/assets/images/about/team-4.jpg" class="h-full w-full object-cover rounded-xl" alt="Creative Director portrait">
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-xl"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
              <h3 class="text-xl font-bold">Sanjay Patel</h3>
              <p class="text-gray-300">Creative Director</p>
            </div>
          </div>
          
          <!-- Card Back -->
          <div class="absolute inset-0 bg-primary text-white p-8 rounded-xl flex flex-col backface-hidden rotate-y-180">
            <h3 class="text-xl font-bold mb-2">Sanjay Patel</h3>
            <p class="text-gray-200 text-sm mb-4">Creative Director</p>
            <p class="text-gray-100 mb-4">Award-winning designer with background in game development and interactive experiences. Leads the creative vision for our virtual ecosystem.</p>
            <p class="text-gray-200 italic mb-4">"Great design creates emotional connections. We're using those connections to inspire conservation action."</p>
            <div class="mt-auto flex space-x-3">
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-linkedin-in"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Team Member 5 -->
      <div class="team-card relative h-96 group perspective">
        <div class="relative h-full w-full rounded-xl shadow-xl transition-all duration-700 preserve-3d group-hover:rotate-y-180">
          <!-- Card Front -->
          <div class="absolute inset-0 backface-hidden">
            <img src="<?= $baseUrl ?>/assets/images/about/team-5.jpg" class="h-full w-full object-cover rounded-xl" alt="Head of Product portrait">
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-xl"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
              <h3 class="text-xl font-bold">Olivia Kim</h3>
              <p class="text-gray-300">Head of Product</p>
            </div>
          </div>
          
          <!-- Card Back -->
          <div class="absolute inset-0 bg-primary text-white p-8 rounded-xl flex flex-col backface-hidden rotate-y-180">
            <h3 class="text-xl font-bold mb-2">Olivia Kim</h3>
            <p class="text-gray-200 text-sm mb-4">Head of Product</p>
            <p class="text-gray-100 mb-4">Former product leader at Headspace and Duolingo. Expert in behavioral design and creating habit-forming experiences with positive impact.</p>
            <p class="text-gray-200 italic mb-4">"The best products create both personal and global benefits. We're building tools that help you while helping the planet."</p>
            <div class="mt-auto flex space-x-3">
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-linkedin-in"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Team Member 6 -->
      <div class="team-card relative h-96 group perspective">
        <div class="relative h-full w-full rounded-xl shadow-xl transition-all duration-700 preserve-3d group-hover:rotate-y-180">
          <!-- Card Front -->
          <div class="absolute inset-0 backface-hidden">
            <img src="<?= $baseUrl ?>/assets/images/about/team-6.jpg" class="h-full w-full object-cover rounded-xl" alt="Ecological Scientist portrait">
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent rounded-xl"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
              <h3 class="text-xl font-bold">Dr. Miguel Torres</h3>
              <p class="text-gray-300">Lead Ecological Scientist</p>
            </div>
          </div>
          
          <!-- Card Back -->
          <div class="absolute inset-0 bg-primary text-white p-8 rounded-xl flex flex-col backface-hidden rotate-y-180">
            <h3 class="text-xl font-bold mb-2">Dr. Miguel Torres</h3>
            <p class="text-gray-200 text-sm mb-4">Lead Ecological Scientist</p>
            <p class="text-gray-100 mb-4">Renowned ecologist specialized in biodiversity and ecosystem restoration. Ensures scientific accuracy in our virtual creatures and educational content.</p>
            <p class="text-gray-200 italic mb-4">"By creating digital versions of endangered species, we're helping people develop emotional connections to wildlife they might never see in person."</p>
            <div class="mt-auto flex space-x-3">
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-linkedin-in"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fab fa-researchgate"></i>
              </a>
              <a href="#" class="h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Join Our Team CTA -->
    <div class="mt-16 text-center">
      <h3 class="text-2xl font-bold mb-6">Join Our Team</h3>
      <p class="text-lg max-w-2xl mx-auto mb-6">
        We're always looking for passionate individuals who want to make a difference through technology and conservation.
      </p>
      <a href="#" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-opacity-90 transition">
        <i class="fas fa-briefcase mr-2"></i> View Open Positions
      </a>
    </div>
  </div>
</section>

<!-- Impact Stats Section with Animation -->
<section id="our-impact" class="relative py-16 md:py-24 bg-primary text-white overflow-hidden">
  <!-- Nature-inspired background patterns -->
  <div class="absolute inset-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <pattern id="dots-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
        <circle cx="10" cy="10" r="2" fill="currentColor"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#dots-pattern)"/>
    </svg>
  </div>
  
  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-16">
      <h2 class="text-3xl md:text-4xl font-display font-bold mb-6">Our Impact</h2>
      <p class="text-xl max-w-3xl mx-auto">
        Every minute of focus contributes to real conservation impact around the world. Here's what we've accomplished together.
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <!-- Impact Stat 1 -->
      <div class="bg-white bg-opacity-10 backdrop-blur-sm p-8 rounded-xl text-center transform transition-all duration-500 hover:-translate-y-2">
        <div class="mb-6">
          <i class="fas fa-users text-5xl text-secondary"></i>
        </div>
        <div class="text-4xl md:text-5xl font-bold mb-2 stat-counter" data-target="1245000">0</div>
        <p class="text-xl text-gray-200">Active Users</p>
      </div>
      
      <!-- Impact Stat 2 -->
      <div class="bg-white bg-opacity-10 backdrop-blur-sm p-8 rounded-xl text-center transform transition-all duration-500 hover:-translate-y-2">
        <div class="mb-6">
          <i class="fas fa-clock text-5xl text-secondary"></i>
        </div>
        <div class="text-4xl md:text-5xl font-bold mb-2"><span class="stat-counter" data-target="73">0</span>M</div>
        <p class="text-xl text-gray-200">Focus Hours</p>
      </div>
      
      <!-- Impact Stat 3 -->
      <div class="bg-white bg-opacity-10 backdrop-blur-sm p-8 rounded-xl text-center transform transition-all duration-500 hover:-translate-y-2">
        <div class="mb-6">
          <i class="fas fa-hand-holding-usd text-5xl text-secondary"></i>
        </div>
        <div class="text-4xl md:text-5xl font-bold mb-2">$<span class="stat-counter" data-target="2350000">0</span></div>
        <p class="text-xl text-gray-200">Conservation Funding</p>
      </div>
      
      <!-- Impact Stat 4 -->
      <div class="bg-white bg-opacity-10 backdrop-blur-sm p-8 rounded-xl text-center transform transition-all duration-500 hover:-translate-y-2">
        <div class="mb-6">
          <i class="fas fa-paw text-5xl text-secondary"></i>
        </div>
        <div class="text-4xl md:text-5xl font-bold mb-2"><span class="stat-counter" data-target="42">0</span></div>
        <p class="text-xl text-gray-200">Protected Habitats</p>
      </div>
    </div>
    
    <!-- Additional Impact Details -->
    <div class="mt-16 bg-white bg-opacity-10 backdrop-blur-sm p-8 rounded-xl">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <h3 class="text-2xl font-bold mb-4">Where Your Focus Goes</h3>
          <p class="mb-6">
            Your focus sessions directly fund conservation projects worldwide. We partner with established organizations to ensure maximum impact.
          </p>
          <div class="space-y-4">
            <div class="flex items-center">
              <div class="w-2 h-2 bg-secondary rounded-full mr-2"></div>
              <div class="text-gray-200">35% - Habitat Protection</div>
            </div>
            <div class="flex items-center">
              <div class="w-2 h-2 bg-secondary rounded-full mr-2"></div>
              <div class="text-gray-200">25% - Species Conservation</div>
            </div>
            <div class="flex items-center">
              <div class="w-2 h-2 bg-secondary rounded-full mr-2"></div>
              <div class="text-gray-200">20% - Conservation Education</div>
            </div>
            <div class="flex items-center">
              <div class="w-2 h-2 bg-secondary rounded-full mr-2"></div>
              <div class="text-gray-200">15% - Community Engagement</div>
            </div>
            <div class="flex items-center">
              <div class="w-2 h-2 bg-secondary rounded-full mr-2"></div>
              <div class="text-gray-200">5% - Research & Innovation</div>
            </div>
          </div>
        </div>
        <div>
          <h3 class="text-2xl font-bold mb-4">Featured Partners</h3>
          <div class="space-y-6">
            <div class="flex items-center">
              <img src="<?= $baseUrl ?>/assets/images/about/partner-1.png" alt="Conservation Partner" class="h-12 w-12 object-cover rounded-full bg-white p-1 mr-4">
              <div>
                <h4 class="font-bold">Global Wildlife Fund</h4>
                <p class="text-sm text-gray-200">Protection of endangered habitats worldwide</p>
              </div>
            </div>
            <div class="flex items-center">
              <img src="<?= $baseUrl ?>/assets/images/about/partner-2.png" alt="Conservation Partner" class="h-12 w-12 object-cover rounded-full bg-white p-1 mr-4">
              <div>
                <h4 class="font-bold">Ocean Conservation Alliance</h4>
                <p class="text-sm text-gray-200">Marine habitat protection and rehabilitation</p>
              </div>
            </div>
            <div class="flex items-center">
              <img src="<?= $baseUrl ?>/assets/images/about/partner-3.png" alt="Conservation Partner" class="h-12 w-12 object-cover rounded-full bg-white p-1 mr-4">
              <div>
                <h4 class="font-bold">Rainforest Trust</h4>
                <p class="text-sm text-gray-200">Preservation of tropical forests and biodiversity</p>
              </div>
            </div>
          </div>
          <a href="#" class="inline-flex items-center mt-6 text-secondary hover:underline">
            <span>View All Conservation Partners</span>
            <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section with 3D Carousel -->
<section class="py-16 md:py-24 bg-light">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <h2 class="text-3xl md:text-4xl font-display font-bold mb-6 text-primary">What People Say</h2>
      <p class="text-lg max-w-3xl mx-auto text-gray-700">
        Hear from our community of users, partners, and conservation experts about their Wildlife Haven experience.
      </p>
    </div>
    
    <div class="relative max-w-5xl mx-auto">
      <!-- Testimonials Carousel -->
      <div class="testimonials-carousel">
        <!-- Current Testimonial (Center) -->
        <div class="testimonial-card active absolute top-0 left-0 w-full transform transition-all duration-700 opacity-100 z-30 translate-x-0" data-position="center">
          <div class="bg-white rounded-xl shadow-xl p-8 md:p-10">
            <div class="flex items-center mb-6">
              <div class="text-5xl text-secondary opacity-50 mr-4">"</div>
              <div class="h-px flex-grow bg-gray-200"></div>
            </div>
            <p class="text-lg md:text-xl text-gray-700 mb-8">
              Wildlife Haven transformed my productivity habits completely. Instead of dreading long focus sessions, I now look forward to helping my virtual creatures grow. The best part is knowing my focus time contributes to real conservation efforts. I've improved my work efficiency while supporting causes I care about!
            </p>
            <div class="flex items-center">
              <img src="<?= $baseUrl ?>/assets/images/about/testimonial-1.jpg" alt="Testimonial" class="w-14 h-14 rounded-full object-cover mr-4">
              <div>
                <h4 class="font-bold">Jessica Taylor</h4>
                <p class="text-gray-600">Freelance Designer, Wildlife Haven user for 2 years</p>
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
        
        <!-- Left Testimonial -->
        <div class="testimonial-card absolute top-0 left-0 w-full transform transition-all duration-700 opacity-60 scale-90 z-20 -translate-x-10" data-position="left">
          <div class="bg-white rounded-xl shadow-lg p-8 md:p-10">
            <div class="flex items-center mb-6">
              <div class="text-5xl text-secondary opacity-50 mr-4">"</div>
              <div class="h-px flex-grow bg-gray-200"></div>
            </div>
            <p class="text-lg md:text-xl text-gray-700 mb-8">
              As a teacher, I've introduced Wildlife Haven to my students as part of our focus training. They're engaged with the wildlife conservation aspects and compete to see who can contribute the most focus time. It's been incredible to see their concentration improve while they learn about endangered species.
            </p>
            <div class="flex items-center">
              <img src="<?= $baseUrl ?>/assets/images/about/testimonial-2.jpg" alt="Testimonial" class="w-14 h-14 rounded-full object-cover mr-4">
              <div>
                <h4 class="font-bold">Michael Johnson</h4>
                <p class="text-gray-600">High School Science Teacher</p>
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
        
        <!-- Right Testimonial -->
        <div class="testimonial-card absolute top-0 left-0 w-full transform transition-all duration-700 opacity-60 scale-90 z-20 translate-x-10" data-position="right">
          <div class="bg-white rounded-xl shadow-lg p-8 md:p-10">
            <div class="flex items-center mb-6">
              <div class="text-5xl text-secondary opacity-50 mr-4">"</div>
              <div class="h-px flex-grow bg-gray-200"></div>
            </div>
            <p class="text-lg md:text-xl text-gray-700 mb-8">
              We partnered with Wildlife Haven to connect our conservation work with digital audiences, and the results have exceeded expectations. Their innovative approach brings conservation to people who might never otherwise engage with our mission. The transparency in how funds are used builds tremendous trust.
            </p>
            <div class="flex items-center">
              <img src="<?= $baseUrl ?>/assets/images/about/testimonial-3.jpg" alt="Testimonial" class="w-14 h-14 rounded-full object-cover mr-4">
              <div>
                <h4 class="font-bold">Dr. Sarah Nguyen</h4>
                <p class="text-gray-600">Director, Global Wildlife Fund</p>
              </div>
              <div class="ml-auto flex">
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star-half-alt text-yellow-400"></i>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Hidden Testimonial 4 -->
        <div class="testimonial-card absolute top-0 left-0 w-full transform transition-all duration-700 opacity-0 scale-75 z-10 translate-x-20" data-position="hidden">
          <div class="bg-white rounded-xl shadow-lg p-8 md:p-10">
            <div class="flex items-center mb-6">
              <div class="text-5xl text-secondary opacity-50 mr-4">"</div>
              <div class="h-px flex-grow bg-gray-200"></div>
            </div>
            <p class="text-lg md:text-xl text-gray-700 mb-8">
              As someone with ADHD, traditional focus techniques never worked for me. Wildlife Haven's approach using virtual creatures and gamification has been life-changing. I'm actually excited to start focus sessions, and the AR features make the experience incredibly immersive.
            </p>
            <div class="flex items-center">
              <img src="<?= $baseUrl ?>/assets/images/about/testimonial-4.jpg" alt="Testimonial" class="w-14 h-14 rounded-full object-cover mr-4">
              <div>
                <h4 class="font-bold">Alex Rodriguez</h4>
                <p class="text-gray-600">Software Developer, Wildlife Haven user for 1 year</p>
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
        
        <!-- Hidden Testimonial 5 -->
        <div class="testimonial-card absolute top-0 left-0 w-full transform transition-all duration-700 opacity-0 scale-75 z-10 -translate-x-20" data-position="hidden">
          <div class="bg-white rounded-xl shadow-lg p-8 md:p-10">
            <div class="flex items-center mb-6">
              <div class="text-5xl text-secondary opacity-50 mr-4">"</div>
              <div class="h-px flex-grow bg-gray-200"></div>
            </div>
            <p class="text-lg md:text-xl text-gray-700 mb-8">
              Our entire marketing team uses Wildlife Haven for our focused work sessions. We've seen a 30% increase in productivity, and the team building aspect of supporting conservation together has strengthened our company culture. The detailed progress analytics have been invaluable.
            </p>
            <div class="flex items-center">
              <img src="<?= $baseUrl ?>/assets/images/about/testimonial-5.jpg" alt="Testimonial" class="w-14 h-14 rounded-full object-cover mr-4">
              <div>
                <h4 class="font-bold">Samantha Lee</h4>
                <p class="text-gray-600">Marketing Director, Eco Innovations</p>
              </div>
              <div class="ml-auto flex">
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star-half-alt text-yellow-400"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Testimonial Navigation -->
      <div class="flex justify-center mt-8 space-x-4">
        <button class="testimonial-nav-btn p-3 bg-primary text-white rounded-full hover:bg-opacity-90 transition" data-direction="prev">
          <i class="fas fa-arrow-left"></i>
        </button>
        <button class="testimonial-nav-btn p-3 bg-primary text-white rounded-full hover:bg-opacity-90 transition" data-direction="next">
          <i class="fas fa-arrow-right"></i>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Contact Section with Dynamic Effects -->
<section id="contact" class="py-16 md:py-24 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row items-center gap-12">
      <div class="lg:w-1/2">
        <h2 class="text-3xl md:text-4xl font-display font-bold mb-6 text-primary">Get in Touch</h2>
        <p class="text-lg mb-8 text-gray-700">
          Have questions about Wildlife Haven or want to explore partnership opportunities? Our team is ready to help.
        </p>
        
        <div class="space-y-6 mb-8">
          <div class="flex items-start">
            <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4 shrink-0">
              <i class="fas fa-map-marker-alt text-primary"></i>
            </div>
            <div>
              <h4 class="font-bold mb-1">Our Headquarters</h4>
              <p class="text-gray-700">123 Conservation Way<br>San Francisco, CA 94110</p>
            </div>
          </div>
          
          <div class="flex items-start">
            <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4 shrink-0">
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
            <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4 shrink-0">
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
          <a href="#" class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white hover:bg-opacity-90 transition-all">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white hover:bg-opacity-90 transition-all">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white hover:bg-opacity-90 transition-all">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white hover:bg-opacity-90 transition-all">
            <i class="fab fa-linkedin-in"></i>
          </a>
        </div>
      </div>
      
      <div class="lg:w-1/2 w-full">
        <div class="bg-white rounded-xl shadow-lg p-8 transform transition-all hover:shadow-xl">
          <h3 class="text-2xl font-bold mb-6">Send Us a Message</h3>
          
          <form id="contact-form" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="name" class="block text-gray-700 mb-2 font-medium">Your Name</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="Enter your name" required>
              </div>
              <div>
                <label for="email" class="block text-gray-700 mb-2 font-medium">Email Address</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="Enter your email" required>
              </div>
            </div>
            
            <div>
              <label for="subject" class="block text-gray-700 mb-2 font-medium">Subject</label>
              <input type="text" id="subject" name="subject" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="What is this regarding?">
            </div>
            
            <div>
              <label for="message" class="block text-gray-700 mb-2 font-medium">Message</label>
              <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="How can we help you?" required></textarea>
            </div>
            
            <div class="flex items-start">
              <input type="checkbox" id="consent" name="consent" class="mt-1 mr-2" required>
              <label for="consent" class="text-gray-700 text-sm">
                I consent to Wildlife Haven collecting and storing the information I have provided to respond to my inquiry. View our <a href="#" class="text-primary hover:underline">Privacy Policy</a>.
              </label>
            </div>
            
            <button type="submit" class="w-full px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-opacity-90 transition-all">
              <i class="fas fa-paper-plane mr-2"></i> Send Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary text-white relative overflow-hidden">
  <div class="absolute inset-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <pattern id="wave-pattern" x="0" y="0" width="100" height="20" patternUnits="userSpaceOnUse">
        <path d="M0,10 C30,15 70,5 100,10 L100,20 L0,20 Z" fill="currentColor"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#wave-pattern)"/>
    </svg>
  </div>
  
  <div class="container mx-auto px-4 relative z-10 text-center">
    <h2 class="text-3xl md:text-4xl font-display font-bold mb-6">Join Our Mission Today</h2>
    <p class="text-xl mb-8 max-w-3xl mx-auto">
      Transform your productivity while making a real difference for wildlife conservation. Download Wildlife Haven and start your journey.
    </p>
    
    <div class="flex flex-wrap justify-center gap-4">
      <a href="#" class="flex items-center bg-white text-primary px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition">
        <i class="fab fa-apple text-2xl mr-3"></i> 
        <div class="text-left">
          <div class="text-xs">Download on the</div>
          <div class="text-lg">App Store</div>
        </div>
      </a>
      <a href="#" class="flex items-center bg-white text-primary px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition">
        <i class="fab fa-google-play text-2xl mr-3"></i>
        <div class="text-left">
          <div class="text-xs">Get it on</div>
          <div class="text-lg">Google Play</div>
        </div>
      </a>
      <a href="#" class="flex items-center bg-secondary text-primary px-6 py-3 rounded-lg font-medium hover:bg-opacity-90 transition">
        <i class="fas fa-laptop text-2xl mr-3"></i>
        <div class="text-lg">Use Web App</div>
      </a>
    </div>
  </div>
</section>

<style>
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
  
  /* Timeline Styles */
  .timeline-wrapper {
    position: relative;
  }
  
  .timeline-scroll-container {
    overflow-x: auto;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
  }
  
  .timeline-scroll-container::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
  }
  
  /* Value Card Hover Effect */
  .value-card:hover .value-details {
    opacity: 1;
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Hero Section Animation
  setTimeout(function() {
    document.getElementById('hero-title').classList.remove('opacity-0', '-translate-y-8');
    document.getElementById('hero-title').classList.add('opacity-100', 'translate-y-0');
    
    setTimeout(function() {
      document.getElementById('hero-text').classList.remove('opacity-0', '-translate-y-8');
      document.getElementById('hero-text').classList.add('opacity-100', 'translate-y-0');
      
      setTimeout(function() {
        document.getElementById('hero-cta').classList.remove('opacity-0', '-translate-y-8');
        document.getElementById('hero-cta').classList.add('opacity-100', 'translate-y-0');
      }, 300);
    }, 300);
  }, 300);
  
  // Timeline Navigation
  const timelineContainer = document.getElementById('timeline-container');
  const timelineItems = document.querySelectorAll('.timeline-item');
  const timelineNavBtns = document.querySelectorAll('.timeline-nav-btn');
  
  let currentYear = 2020;
  const years = [2020, 2021, 2022, 2023, 2024, 2025];
  
  // Initialize Timeline Navigation
  function updateTimelineNav() {
    const prevBtn = document.querySelector('.timeline-nav-btn[data-direction="prev"]');
    const nextBtn = document.querySelector('.timeline-nav-btn[data-direction="next"]');
    
    const currentIndex = years.indexOf(currentYear);
    
    prevBtn.disabled = currentIndex === 0;
    nextBtn.disabled = currentIndex === years.length - 1;
  }
  
  // Scroll to a specific year in the timeline
  function scrollToYear(year) {
    const targetItem = document.querySelector(`.timeline-item[data-year="${year}"]`);
    
    if (targetItem) {
      const containerWidth = timelineContainer.offsetWidth;
      const itemLeft = targetItem.offsetLeft;
      
      timelineContainer.scrollTo({
        left: itemLeft - containerWidth / 2 + targetItem.offsetWidth / 2,
        behavior: 'smooth'
      });
      
      currentYear = year;
      updateTimelineNav();
    }
  }
  
  // Handle timeline navigation button clicks
  timelineNavBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const direction = this.dataset.direction;
      const currentIndex = years.indexOf(currentYear);
      
      if (direction === 'prev' && currentIndex > 0) {
        scrollToYear(years[currentIndex - 1]);
      } else if (direction === 'next' && currentIndex < years.length - 1) {
        scrollToYear(years[currentIndex + 1]);
      }
    });
  });
  
  // Initialize timeline
  updateTimelineNav();
  
  // Testimonials Carousel
  const testimonialCards = document.querySelectorAll('.testimonial-card');
  const testimonialNavBtns = document.querySelectorAll('.testimonial-nav-btn');
  
  let positions = ['hidden-left', 'left', 'center', 'right', 'hidden-right'];
  let currentIndex = 2; // Center position
  
  function updateTestimonialPositions() {
    testimonialCards.forEach((card, index) => {
      // Remove all position classes
      card.dataset.position = '';
      card.classList.remove('translate-x-0', '-translate-x-10', '-translate-x-20', 'translate-x-10', 'translate-x-20', 'opacity-100', 'opacity-60', 'opacity-0', 'z-30', 'z-20', 'z-10', 'scale-100', 'scale-90', 'scale-75');
      
      const relativePosition = (index - currentIndex + 2) % 5;
      
      switch(relativePosition) {
        case 0: // hidden-left
          card.dataset.position = 'hidden';
          card.classList.add('-translate-x-20', 'opacity-0', 'scale-75', 'z-10');
          break;
        case 1: // left
          card.dataset.position = 'left';
          card.classList.add('-translate-x-10', 'opacity-60', 'scale-90', 'z-20');
          break;
        case 2: // center
          card.dataset.position = 'center';
          card.classList.add('translate-x-0', 'opacity-100', 'scale-100', 'z-30');
          break;
        case 3: // right
          card.dataset.position = 'right';
          card.classList.add('translate-x-10', 'opacity-60', 'scale-90', 'z-20');
          break;
        case 4: // hidden-right
          card.dataset.position = 'hidden';
          card.classList.add('translate-x-20', 'opacity-0', 'scale-75', 'z-10');
          break;
      }
    });
  }
  
  // Handle testimonial navigation button clicks
  testimonialNavBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const direction = this.dataset.direction;
      
      if (direction === 'prev') {
        currentIndex = (currentIndex - 1 + 5) % 5;
      } else if (direction === 'next') {
        currentIndex = (currentIndex + 1) % 5;
      }
      
      updateTestimonialPositions();
    });
  });
  
  // Initialize testimonial carousel
  updateTestimonialPositions();
  
  // Stat Counters Animation
  const statCounters = document.querySelectorAll('.stat-counter');
  
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
  
  // Contact Form Handling
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
      successMessage.className = 'p-4 mb-4 bg-green-100 text-green-800 rounded-md';
      successMessage.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Thank you for your message! We\'ll get back to you soon.';
      
      // Insert success message before form
      contactForm.parentNode.insertBefore(successMessage, contactForm);
      
      // Remove success message after 5 seconds
      setTimeout(() => {
        successMessage.remove();
      }, 5000);
    });
  }
  
  // Smooth Scrolling for Anchor Links
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
});
</script>

<?php include ROOT_PATH . '/resources/views/layouts/footer.php'; ?>