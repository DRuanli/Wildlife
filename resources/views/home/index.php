<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Custom CSS for Claude-inspired styling -->
<style>
  :root {
    --primary-color: #CE6246;
    --secondary-color: #F9F8F2;
  }
  body {
    background-color: var(--secondary-color);
    color: #333;
    font-family: 'Inter', sans-serif;
  }
  a, button {
    transition: all 0.3s ease;
  }
  .btn-primary {
    background-color: var(--primary-color);
    color: #fff;
  }
  .btn-primary:hover {
    background-color: #B0553C; /* A slightly darker tone */
  }
  .btn-outline {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
  }
  .btn-outline:hover {
    background-color: var(--primary-color);
    color: #fff;
  }
  .bg-primary {
    background-color: var(--primary-color) !important;
  }
  /* Hero Section */
  .hero-section {
    background: linear-gradient(135deg, var(--secondary-color), #fff);
  }
</style>

<main>
  <!-- Hero Section -->
  <section class="hero-section relative h-screen flex items-center justify-center">
    <div class="text-center px-4">
      <h1 class="text-5xl md:text-6xl font-bold mb-6" style="color: var(--primary-color);">
        Focus on what matters, help wildlife thrive
      </h1>
      <p class="text-xl md:text-2xl mb-8">
        Transform your focus time into a journey of nurturing mythical creatures and real-world conservation.
      </p>
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="<?= $baseUrl ?>/auth/register" class="btn-primary px-8 py-4 rounded-full" aria-label="Get Started">
          Get Started
        </a>
        <a href="#features" class="btn-outline px-8 py-4 rounded-full" aria-label="Learn More">
          Learn More
        </a>
      </div>
    </div>
  </section>

  <!-- Interactive Focus Timer Component -->
  <section id="focus-timer" class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12" style="color: var(--primary-color);">Interactive Focus Timer</h2>
      <div x-data="timer()" class="max-w-lg mx-auto text-center">
        <div class="text-6xl font-mono mb-6" style="color: var(--primary-color);" x-text="displayTime"></div>
        <div class="flex justify-center gap-4 mb-4">
          <button @click="start()" class="btn-primary px-6 py-2 rounded-full">Start</button>
          <button @click="pause()" class="px-6 py-2 rounded-full" style="background-color: #F1A989; color: #fff;">Pause</button>
          <button @click="reset()" class="px-6 py-2 rounded-full" style="background-color: #D9534F; color: #fff;">Reset</button>
        </div>
        <p>Set your focus session and track your time.</p>
      </div>
    </div>
  </section>

  <!-- Virtual Sanctuary: Creature Gallery -->
  <section id="creature-gallery" class="py-16" style="background-color: #fff;">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12" style="color: var(--primary-color);">Virtual Sanctuary</h2>
      <p class="text-center mb-8 text-gray-700">Explore your collection of mythical creatures nurtured by your focus sessions.</p>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        <!-- Creature Card 1 -->
        <div class="rounded-lg overflow-hidden shadow hover:shadow-lg transition" style="background-color: var(--secondary-color);">
          <img src="<?= $baseUrl ?>/images/creature1.jpg" alt="Aurora the Phoenix" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-xl font-semibold" style="color: var(--primary-color);">Aurora the Phoenix</h3>
            <p class="text-sm text-gray-600">Rises from the ashes with every focus session completed.</p>
          </div>
        </div>
        <!-- Creature Card 2 -->
        <div class="rounded-lg overflow-hidden shadow hover:shadow-lg transition" style="background-color: var(--secondary-color);">
          <img src="<?= $baseUrl ?>/images/creature2.jpg" alt="Zephyr the Dragon" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-xl font-semibold" style="color: var(--primary-color);">Zephyr the Dragon</h3>
            <p class="text-sm text-gray-600">Guardian of focus and the skies, soaring with your productivity.</p>
          </div>
        </div>
        <!-- Creature Card 3 -->
        <div class="rounded-lg overflow-hidden shadow hover:shadow-lg transition" style="background-color: var(--secondary-color);">
          <img src="<?= $baseUrl ?>/images/creature3.jpg" alt="Luna the Unicorn" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-xl font-semibold" style="color: var(--primary-color);">Luna the Unicorn</h3>
            <p class="text-sm text-gray-600">Brings magic and clarity to your work sessions.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Carousel -->
  <section id="testimonials" class="py-16" style="background-color: var(--secondary-color);">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12" style="color: var(--primary-color);">What Our Users Say</h2>
      <div x-data="{ current: 0, testimonials: [
          { quote: 'Wildlife Haven transformed my daily routine! I never imagined productivity could be this magical.', name: 'Sarah K.', role: 'Student', avatar: 'S' },
          { quote: 'A perfect blend of work and play. Every session feels like a new adventure.', name: 'John D.', role: 'Designer', avatar: 'J' },
          { quote: 'It keeps me motivated and engaged. My focus sessions are now the highlight of my day!', name: 'Alex R.', role: 'Entrepreneur', avatar: 'A' }
        ] }" class="max-w-2xl mx-auto relative">
        <template x-for="(testimonial, index) in testimonials" :key="index">
          <div x-show="current === index" class="text-center transition-opacity duration-500" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100">
            <p class="text-xl mb-6" x-text="testimonial.quote"></p>
            <div class="flex items-center justify-center">
              <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold mr-3 bg-primary" style="color: #fff;" x-text="testimonial.avatar"></div>
              <div>
                <p class="font-semibold" style="color: var(--primary-color);" x-text="testimonial.name"></p>
                <p class="text-sm text-gray-600" x-text="testimonial.role"></p>
              </div>
            </div>
          </div>
        </template>
        <div class="flex justify-center gap-2 mt-6">
          <template x-for="(testimonial, index) in testimonials" :key="index">
            <button @click="current = index" class="w-3 h-3 rounded-full" :class="current === index ? 'bg-primary' : 'bg-gray-300'"></button>
          </template>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faqs" class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12" style="color: var(--primary-color);">Frequently Asked Questions</h2>
      <div x-data="{ open: null }" class="max-w-3xl mx-auto">
        <template x-for="(faq, index) in [
            { question: 'How does the focus timer work?', answer: 'Simply set the timer and start your focus session. The app tracks your time and rewards you with progress.' },
            { question: 'What are the mythical creatures?', answer: 'They represent your achievements. The more sessions you complete, the more creatures you unlock.' },
            { question: 'How does this help conservation?', answer: 'A portion of every session contributes to real-world conservation efforts through our trusted partners.' }
          ]" :key="index">
          <div class="mb-4 border-b border-gray-200">
            <button @click="open === index ? open = null : open = index" class="w-full text-left py-4 flex justify-between items-center focus:outline-none">
              <span class="text-xl" x-text="faq.question" style="color: var(--primary-color);"></span>
              <svg x-show="open === index" class="w-6 h-6 transform rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
              <svg x-show="open !== index" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div x-show="open === index" x-collapse class="pb-4 text-gray-700">
              <p x-text="faq.answer"></p>
            </div>
          </div>
        </template>
      </div>
    </div>
  </section>
</main>

<!-- AlpineJS for interactive components -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
  // AlpineJS Timer Component
  function timer() {
    return {
      seconds: 0,
      interval: null,
      get displayTime() {
        let mins = Math.floor(this.seconds / 60);
        let secs = this.seconds % 60;
        return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
      },
      start() {
        if (!this.interval) {
          this.interval = setInterval(() => { this.seconds++; }, 1000);
        }
      },
      pause() {
        clearInterval(this.interval);
        this.interval = null;
      },
      reset() {
        this.pause();
        this.seconds = 0;
      }
    }
  }
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
